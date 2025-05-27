<?php
/*
 * Display all entries in a table list
 */
require_once("../conf/config.inc.php");
require __DIR__ . '/../vendor/autoload.php';

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

if ($ldapInstance->connect()[0]) {

    # Search attributes
    foreach ($result_items as $item) $attributes[] = $attributes_map[$item]['attribute'];

    # Search for entries
    [$ldap,$result,$nb_entries,$entries,$size_limit_reached] = $ldapInstance->search($ldap_search_filter, $attributes_list, $attributes_map, $search_result_title, $search_result_sortby, $result_items);

    if ( $result == 4) {
        $size_limit_reached = true;
    }
    if ( $result != 0 and $result != 4 ) {
        $result = "ldaperror";
        error_log("LDAP - Search error $result  (".ldap_error($ldap).")");
    } else {

        if ($nb_entries === 0) {
            $result = "noentriesfound";
        } else {
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
