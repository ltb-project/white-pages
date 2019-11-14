<?php
/*
 * Display all entries like a yearbook
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

    $search = ldap_search($ldap, $ldap_user_base, $gallery_filter, $attributes, 0, $ldap_size_limit);

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
            $sortby = $attributes_map[$gallery_sortby]['attribute'];
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

$smarty->assign("card_title", $gallery_title);
$smarty->assign("bootstrap_column_class", $gallery_bootstrap_column_class);
$smarty->assign("truncate_title_after", $gallery_truncate_title_after);
?>
