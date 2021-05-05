<?php
/*
 * Search entries in LDAP directory
 * with advanced criteria
 */ 

$result = "";
$nb_entries = 0;
$entries = array();
$size_limit_reached = false;
$type = "user";
$ldap_search_base = "";
$ldap_search_filter = "";

if (!isset($_POST["submit"])) {
    $smarty->assign('advanced_search_criteria', $advanced_search_criteria);
    $smarty->assign('advanded_search_display_search_objects', $advanded_search_display_search_objects);

    # Check if an attribute is a list type and prepare the list
    require_once("../lib/ldap.inc.php");

    # Connect to LDAP
    $ldap_connection = wp_ldap_connect($ldap_url, $ldap_starttls, $ldap_binddn, $ldap_bindpw);

    $ldap = $ldap_connection[0];
    $result = $ldap_connection[1];

    if ($ldap) {
        $item_list = array();
        foreach ( $advanced_search_criteria as $criteria ) {
            if ( $attributes_map[$criteria]["type"] === "list" ) {
                $item_list[$criteria] = wp_ldap_get_list( $ldap, $attributes_list[$criteria]["base"], $attributes_list[$criteria]["filter"], $attributes_list[$criteria]["key"], $attributes_list[$criteria]["value"]  );
            }
        }
        $smarty->assign('item_list', $item_list);
    }

    $result = "displayform";
}

if (isset($_POST["type"])) {
    $type = $_POST["type"];
}

if ( $type === "user" ) {
    $ldap_search_base = $ldap_user_base;
    $ldap_search_filter = $ldap_user_filter;
    $result_items = $search_result_items;
}

if ( $type === "group" ) {
    $ldap_search_base = $ldap_group_base;
    $ldap_search_filter = $ldap_group_filter;
    $result_items = $search_result_group_items;
}

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
        $ldap_filter = "(&".$ldap_search_filter."(&";
        foreach ($advanced_search_criteria as $item) {
            $attribute = $attributes_map[$item]['attribute'];
            $type = $attributes_map[$item]['type'];
            if ( $type == "date") {
                if (isset($_POST[$item."from"]) and $_POST[$item."from"]) {
                    $value = string2ldapDate($_POST[$item."from"]);
                    $value = ldap_escape($value, null, LDAP_ESCAPE_FILTER);
                    $ldap_filter .= "($attribute>=$value)";
                }
                if (isset($_POST[$item."to"]) and $_POST[$item."to"]) {
                    $value = string2ldapDate($_POST[$item."to"]);
                    $value = ldap_escape($value, null, LDAP_ESCAPE_FILTER);
                    $ldap_filter .= "($attribute<=$value)";
                }
            }
            elseif ( $type == "boolean") {
                if (isset($_POST[$item]) and $_POST[$item]) {
                    $value = $_POST[$item];
                    $value = ldap_escape($value, null, LDAP_ESCAPE_FILTER);
                    $ldap_filter .= "($attribute=$value)";
                }
            } 
            else {
                if (isset($_POST[$item]) and $_POST[$item]) {
                    $value = $_POST[$item];
                    if (isset($_POST[$item."match"]) and ($_POST[$item."match"] == 'exact')) {
                        $value = ldap_escape($value, "*", LDAP_ESCAPE_FILTER);
                    } else {
                        $value = '*' . ldap_escape($value, "", LDAP_ESCAPE_FILTER) . '*';
                    }
                    $ldap_filter .= "($attribute=$value)";
                }
            }
        }
        $ldap_filter .= "))";

        # Search attributes
	$attributes = array();
	if ( $use_csv and $_POST["submit"] == "csv" ) {
            foreach( $csv_items as $item ) {
                $attributes[] = $attributes_map[$item]['attribute'];
            }
	} else {
            foreach( $result_items as $item ) {
                $attributes[] = $attributes_map[$item]['attribute'];
            }
            $attributes[] = $attributes_map[$search_result_title]['attribute'];
            $attributes[] = $attributes_map[$search_result_sortby]['attribute'];
        }

        # Search for users
        $search = ldap_search($ldap, $ldap_search_base, $ldap_filter, $attributes, 0, $ldap_size_limit);

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

            # CSV
            if ( $use_csv and $_POST["submit"] == "csv" and $nb_entries >0 ) {
                require_once("../lib/csv.inc.php");
                $entries = ldap_get_entries($ldap, $search);
                unset($entries["count"]);
                $csv_headers_label = array();
                foreach ( $csv_items as $csv_item) {
                    $csv_headers_label[] = $messages["label_".$csv_item];
                }
                $csv_array[] = $csv_headers_label;
                foreach ( $entries as $entry ) {
                    $csv_entry = array();
                    foreach ($csv_items as $csv_item) {
                        $csv_entry[$csv_item] = $entry[$attributes_map[$csv_item]['attribute']][0];
                    }
                    $csv_array[] = $csv_entry;
                }
                download_send_headers($csv_filename);
                echo array2csv($csv_array);
                die();
            }

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
                $smarty->assign("type", $type);

                if ($results_display_mode == 'table') {
                    $columns = $result_items;
                    if (! in_array($search_result_title, $columns)) array_unshift($columns, $search_result_title);
                    $smarty->assign("listing_columns", $columns);
                    $smarty->assign("listing_linkto",  isset($search_result_linkto) ? $search_result_linkto : array($search_result_title));
                    $smarty->assign("listing_sortby",  array_search($search_result_sortby, $columns));
                } else {
                    $smarty->assign("card_items", $result_items);
                    $smarty->assign("card_title", $search_result_title);
                    $smarty->assign("truncate_title_after", $search_result_truncate_title_after);
                    $smarty->assign("bootstrap_column_class", $search_result_bootstrap_column_class);
                }
                $smarty->assign("show_undef", $search_result_show_undefined);
                $smarty->assign("truncate_value_after", $search_result_truncate_value_after);
                $page = "search";
            }
        }
    }
}

?>
