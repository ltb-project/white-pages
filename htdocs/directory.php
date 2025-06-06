<?php
/*
 * Display all entries in a table list
 */

$result = "";
$nb_entries = 0;
$entries = array();
$size_limit_reached = false;

# Connect to LDAP
$ldap_connection = $ldapInstance->connect();

$ldap = $ldap_connection[0];
$result = $ldap_connection[1];


if (isset($_GET["type"])) {
    $type = $_GET["type"];
} else {
    $type = "user";
}

if ( $type === "user" ) {
    $ldap_search_filter = $ldap_user_filter;
    $result_items = $directory_items;
    $result_sortby = $directory_sortby;
    $result_linkto = $directory_linkto;
}

if ( $type === "group" ) {
    $ldap_search_filter = $ldap_group_filter;
    $result_items = $directory_group_items;
    $result_sortby = $directory_group_sortby;
    $result_linkto = $directory_group_linkto;
}

if ($ldap) {

    # Search attributes
    foreach ($result_items as $item) $attributes[] = $attributes_map[$item]['attribute'];

    # Search for entries
    [$ldap, $result, $nb_entries, $entries, $size_limit_reached] = $ldapInstance->search($ldap_search_filter, $attributes, $attributes_map, $search_result_title, $result_sortby, $result_items);

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
