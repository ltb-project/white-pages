<?php
/*
 * Display all entries in a table list
 */

$result = "";
$nb_entries = 0;
$entries = array();
$size_limit_reached = false;

require_once("../conf/config.inc.php");
require_once("../lib/ldap.inc.php");

# Connect to LDAP
$ldap_connection = wp_ldap_connect($ldap_url, $ldap_starttls, $ldap_binddn, $ldap_bindpw);

$ldap = $ldap_connection[0];
$result = $ldap_connection[1];

if (isset($_GET["type"])) {
    $type = $_GET["type"];
} else {
    $type = "user";
}

if ( $type === "user" ) {
    $ldap_search_base = $ldap_user_base;
    $ldap_search_filter = $ldap_user_filter;
    $result_items = $directory_items;
    $result_sortby = $directory_sortby;
    $result_linkto = $directory_linkto;
}

if ( $type === "group" ) {
    $ldap_search_base = $ldap_group_base;
    $ldap_search_filter = $ldap_group_filter;
    $result_items = $directory_group_items;
    $result_sortby = $directory_group_sortby;
    $result_linkto = $directory_group_linkto;
}

if ($ldap) {

    # Search attributes
    foreach ($result_items as $item) $attributes[] = $attributes_map[$item]['attribute'];

    # Search for entries
    $search = ldap_search($ldap, $ldap_search_base, $ldap_search_filter, $attributes, 0, $ldap_size_limit);

    $errno = ldap_errno($ldap);

    if ( $errno == 4) {
        $size_limit_reached = true;
    }
    if ( $errno != 0 and $errno != 4 ) {
        $result = "ldaperror";
        error_log("LDAP - Search error $errno  (".ldap_error($ldap).")");
    } else {

        # Sort entries
        if (isset($search_result_sortby)) {
            $sortby = $attributes_map[$result_sortby]['attribute'];
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

$smarty->assign("nb_entries", $nb_entries);
$smarty->assign("entries", $entries);
$smarty->assign("size_limit_reached", $size_limit_reached);

$smarty->assign("listing_columns", $result_items);
$smarty->assign("listing_linkto", $result_linkto);
$smarty->assign("listing_sortby", array_search($result_sortby, $result_items));

$smarty->assign("show_undef", $directory_show_undefined);
$smarty->assign("truncate_value_after", $directory_truncate_value_after);

$smarty->assign("type", $type);
$smarty->assign("directory_display_search_objects", $directory_display_search_objects)
?>
