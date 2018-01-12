<?php
/*
 * Search entries in LDAP directory
 * with advanced criteria
 */ 

$result = "";
$nb_entries = 0;
$entries = array();
$size_limit_reached = false;

if (!isset($_POST["submit"])) { $result = "displayform"; }

if ($result === "") {

    require_once("../conf/config.inc.php");
    require_once("../lib/ldap.inc.php");
    require_once("../lib/date.inc.php");

    # Connect to LDAP
    $ldap_connection = wp_ldap_connect($ldap_url, $ldap_starttls, $ldap_binddn, $ldap_bindpw);

    $ldap = $ldap_connection[0];
    $result = $ldap_connection[1];

    if ($ldap) {

        # Search filter
        $ldap_filter = "(&".$ldap_user_filter."(&";
        foreach ($advanced_search_criteria as $item) {
            $attribute = $attributes_map[$item]['attribute'];
            $type = $attributes_map[$item]['type'];
            if ( $type == "date") {
                if (isset($_POST[$item."from"]) and $_POST[$item."from"]) {
                    $value = string2ldapDate($_POST[$item."from"]);
                    $ldap_filter .= "($attribute>=$value)";
                }
                if (isset($_POST[$item."to"]) and $_POST[$item."to"]) {
                    $value = string2ldapDate($_POST[$item."to"]);
                    $ldap_filter .= "($attribute<=$value)";
                }
            }
            elseif ( $type == "boolean") {
                if (isset($_POST[$item]) and $_POST[$item]) {
                    $ldap_filter .= "($attribute=".$_POST[$item].")";
                }
            } 
            else {
                if (isset($_POST[$item]) and $_POST[$item]) {
                    $ldap_filter .= "($attribute=".$_POST[$item].")";
                }
            }
        }
        $ldap_filter .= "))";

        # Search attributes
        $attributes = array();
        foreach( $search_result_items as $item ) {
            $attributes[] = $attributes_map[$item]['attribute'];
        }
        $attributes[] = $attributes_map[$search_result_title]['attribute'];
        $attributes[] = $attributes_map[$search_result_sortby]['attribute'];

        # Search for users
        $search = ldap_search($ldap, $ldap_user_base, $ldap_filter, $attributes, 0, $ldap_size_limit);

        $errno = ldap_errno($ldap);

        if ( $errno == 4) {
            $size_limit_reached = true;
        }
        if ( $errno > 0 and $errno !=4 ) {
            $result = "ldaperror";
            error_log("LDAP - Search error $errno  (".ldap_error($ldap).")");
        } else {

            # Sort entries
            if (isset($search_result_sortby)) {
                $sortby = $attributes_map[$search_result_sortby]['attribute'];
                ldap_sort($ldap, $search, $sortby);
            }

            # Get search results
            $nb_entries = ldap_count_entries($ldap, $search);

            if ($nb_entries === 0) {
                $result = "noentriesfound";
            } elseif ($nb_entries === 1) {
                $entries = ldap_get_entries($ldap, $search);
                $entry_dn = $entries[0]["dn"];
                $page = "display";
                include("display.php");
            } else {
                $entries = ldap_get_entries($ldap, $search);
                unset($entries["count"]);
                $smarty->assign("nb_entries", $nb_entries);
                $smarty->assign("entries", $entries);
                $smarty->assign("size_limit_reached", $size_limit_reached);
                $page = "search";
            }
        }
    }
}

?>
