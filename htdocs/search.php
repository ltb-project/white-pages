<?php
/*
 * Search entries in LDAP directory
 */ 

$result = "";
$search_query = "";
$nb_entries = 0;
$entries = array();

if (isset($_POST["search"]) and $_POST["search"]) { $search_query = $_POST["search"]; }
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
        foreach ($ldap_user_search_attributes as $lusa) {
            $ldap_filter .= "($lusa=*$search_query*)";
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
        $search = ldap_search($ldap, $ldap_user_base, $ldap_filter, $attributes);

        $errno = ldap_errno($ldap);

        if ( $errno ) {
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
            } else {
                $entries = ldap_get_entries($ldap, $search);
                unset($entries["count"]);
            }
        }
    }
}

$smarty->assign("nb_entries", $nb_entries);
$smarty->assign("entries", $entries);

?>
