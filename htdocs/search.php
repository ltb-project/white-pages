<?php
/*
 * Search entries in LDAP directory
 */ 

$result = "";
$search_query = "";
$nb_entries = 0;
$entries = array();
$size_limit_reached = false;

if (isset($_POST["search"]) and $_POST["search"]) { $search_query = ldap_escape($_POST["search"], null, LDAP_ESCAPE_FILTER); }
 else { $result = "searchrequired"; }

if ($result === "") {

    require_once("../conf/config.inc.php");
    require_once("../lib/ldap.inc.php");

    # Connect to LDAP
    $ldap_connection = wp_ldap_connect($ldap_url, $ldap_starttls, $ldap_binddn, $ldap_bindpw);

    $ldap = $ldap_connection[0];
    $result = $ldap_connection[1];

    if ($ldap) {

        # Search filter
        $ldap_filter = "(&".$ldap_user_filter."(|";
        foreach ($quick_search_attributes as $attr) {
            $ldap_filter .= "($attr=*$search_query*)";
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
        if ( $errno != 0 and $errno !=4 ) {
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
                /*
                if (! in_array($search_result_title, $search_result_item)) {
                    array_unshift($search_result_items, $search_result_title);
                }
                $smarty->assign("columns", $search_result_items);
                $smarty->assign("linkto",  $search_result_linkto);
                $smarty->assign("sortby",  array_search($search_result_sortby, $search_result_items));
                */
                $smarty->assign("columns", $directory_items);
                $smarty->assign("linkto", $directory_linkto);
                $smarty->assign("sortby", array_search($directory_sortby, $directory_items));
                $page = ($results_display_mode == "table") ? "directory" : "search";
            }
        }
    }
}

?>
