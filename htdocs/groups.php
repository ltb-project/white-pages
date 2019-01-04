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

if ($ldap) {

    # Search attributes
    foreach ($groups_items as $item) $attributes[] = $attributes_map[$item]['attribute'];

    # Search for users
    $search = ldap_search($ldap, $ldap_group_base, $ldap_group_filter, $attributes, 0, $ldap_size_limit);

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
            $sortby = $attributes_map[$groups_sortby]['attribute'];
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

$smarty->assign("listing_columns", $groups_items);
$smarty->assign("listing_linkto", $groups_linkto);
$smarty->assign("listing_sortby", array_search($groups_sortby, $groups_items));

$smarty->assign("show_undef", $groups_show_undefined);
$smarty->assign("truncate_value_after", $groups_truncate_value_after);
?>
