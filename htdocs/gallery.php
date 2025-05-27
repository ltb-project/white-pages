<?php
/*
 * Display all entries like a yearbook
 */

$result = "";
$nb_entries = 0;
$entries = array();
$size_limit_reached = false;

require_once("../conf/config.inc.php");
require __DIR__ . '/../vendor/autoload.php';

if ($ldapInstance->connect()[0]) {

    # Search attributes
    $attributes[] = $attributes_map[$gallery_title]['attribute'];
    $attributes[] = $attributes_map[$gallery_sortby]['attribute'];

    # Search for users
    $gallery_filter = $ldap_user_filter;
    if (isset($gallery_user_filter) ) {
        $gallery_filter = $gallery_user_filter;
    }
    # Search for users in group
    if (isset($_GET['groupdn'])) {
        $gallery_filter = "(&".$gallery_filter."(memberOf=".$_GET['groupdn']."))";
    }
    [$ldap,$result,$nb_entries,$entries,$size_limit_reached] = $ldapInstance->search($gallery_filter, $attributes_list, $attributes_map, $search_result_title, $search_result_sortby, $result_items);

    $errno = ldap_errno($ldap);

    if ( $errno == 4) {
        $size_limit_reached = true;
    }
    if ( $errno != 0 and $errno != 4 ) {
        $result = "ldaperror";
        error_log("LDAP - Search error $errno  (".ldap_error($ldap).")");
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

$smarty->assign("card_title", $gallery_title);
$smarty->assign("bootstrap_column_class", $gallery_bootstrap_column_class);
$smarty->assign("truncate_title_after", $gallery_truncate_title_after);
?>
