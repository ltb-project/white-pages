<?php
/*
 * Display all entries like a yearbook
 */

$result = "";
$nb_entries = 0;
$entries = array();
$size_limit_reached = false;

# Connect to LDAP
$ldap_connection = $ldapInstance->connect();

$ldap = $ldap_connection[0];
$result = $ldap_connection[1];

if ($ldap) {

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

    [$ldap, $result, $nb_entries, $entries, $size_limit_reached] = $ldapInstance->search($gallery_filter, $attributes, $attributes_map, $gallery_title, $gallery_sortby, array());

}

if ($result == "ldaperror" or $result == "noentriesfound") {
    $page = "error";
}

$smarty->assign("nb_entries", $nb_entries);
$smarty->assign("entries", $entries);
$smarty->assign("size_limit_reached", $size_limit_reached);

$smarty->assign("card_title", $gallery_title);
$smarty->assign("bootstrap_column_class", $gallery_bootstrap_column_class);
$smarty->assign("truncate_title_after", $gallery_truncate_title_after);
?>
