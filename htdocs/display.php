<?php
/*
 * Display an entry
 */

$result = "";
$dn = "";
$entry = "";
$type = "";
$edit_link = "";

if (isset($_GET["dn"]) and $_GET["dn"]) {
    $dn = $_GET["dn"];
} elseif (isset($entry_dn)) {
    $dn = $entry_dn;
} else {
    $result = "dnrequired";
}

if ($result === "") {

    # Connect to LDAP
    $ldap_connection = $ldapInstance->connect();

    $ldap = $ldap_connection[0];
    $result = $ldap_connection[1];

    if ($ldap) {

        # Find object type
        # 1. Check type parameter
        if (isset($_POST['type'])) {
            $type = $_POST['type'];
        }
        # 2. Use ldap_user_regex
        else if (isset($ldap_user_regex)) {
            if ( preg_match( $ldap_user_regex, $dn) ) {
                $type = "user";
            } else {
                $type = "group";
            }
        }
        # 3. Check LDAP filter on object
        else {
            $user_search = ldap_read($ldap, $dn, $ldap_user_filter, array('1.1'));
            $errno = ldap_errno($ldap);
            if ( $errno ) {
                error_log("LDAP - Object type search error $errno  (".ldap_error($ldap).")");
            } else if ( ldap_count_entries($ldap, $user_search) ) {
                $type = "user";
            }
            $group_search = ldap_read($ldap, $dn, $ldap_group_filter, array('1.1'));
            $errno = ldap_errno($ldap);
            if ( $errno ) {
                error_log("LDAP - Object type earch error $errno  (".ldap_error($ldap).")");
            } else if ( ldap_count_entries($ldap, $group_search) ) {
                $type = "group";
            }
        }

        # Search attributes
        $attributes = array();
        $search_items = array();
        if ( $type === "user" ) { $search_items = $display_items;  }
        if ( $type === "group" ) { $search_items = $display_group_items;  }
        foreach( $search_items as $item ) {
            $attributes[] = $attributes_map[$item]['attribute'];
        }
        $attributes[] = $attributes_map[$display_title]['attribute'];

        if ($use_vcard and $_GET["vcard"] and $vcard_file_identifier) {
            $attributes[] = $attributes_map[$vcard_file_identifier]['attribute'];
        }

        # Search entry
        $ldap_filter = $ldap_user_filter;
        if ($type === "group" ) {
            $ldap_filter = $ldap_group_filter;
        }
        $search = ldap_read($ldap, $dn, $ldap_filter, $attributes);

        $errno = ldap_errno($ldap);

        if ( $errno ) {
            $result = "ldaperror";
            error_log("LDAP - Search error $errno  (".ldap_error($ldap).")");
        } else {
            $entry = ldap_get_entries($ldap, $search);
        }

        # Sort attributes values
        foreach ($entry[0] as $attr => $values) {
            if ( isset($values['count']) ) {
		if ( $values['count'] > 1 ) {
		    asort($values);
		}
                unset($values['count']);
            }
            $entry[0][$attr] = $values;
        }

	if ($use_vcard and $_GET["vcard"]) {
        require_once("../lib/vcard.inc.php");
        $vcard_file = $entry[0][$attributes_map[$vcard_file_identifier]['attribute']][0].".".$vcard_file_extension;
        download_vcard_send_headers($vcard_file);
	    if ($type == "group") {
		$vcard_map = $vcard_group_map;
		$attributes = array();
		$attributes[] = $attributes_map['mail']['attribute'];
		$attributes[] = $attributes_map['phone']['attribute'];
		$ldap_filter = "(".$attributes_map['memberof']['attribute']."=".$entry[0]['dn'].")";
		$search = ldap_search($ldap, $ldap_user_base, $ldap_filter, $attributes, 0, $ldap_size_limit);
		$errno = ldap_errno($ldap);
		if ( $errno == 4 ) {
		    error_log("LDAP - VCard download hit page size limit");
		}
		if ( $errno != 0 and $errno != 4 ) {
		    error_log("LDAP - Search error $errno  (".ldap_error($ldap).")");
		} else {
		    # Get search results
		    $nb_entries = ldap_count_entries($ldap, $search);
		    $members = array();
		    if ($nb_entries > 0) {
			$entries = ldap_get_entries($ldap, $search);
			foreach ($entries as $item) {
			    foreach ($item as $a => $v) {
				if ( $v['count'] > 1 ) { asort($v); }
				if ( isset($v['count']) ) { unset($v['count']); }
				$item[$a] = $v;
			    }
			    if (isset($item[$attributes_map['mail']['attribute']])) {
				$members[] = 'mailto:'.$item[$attributes_map['mail']['attribute']][0];
			    } else if (isset($item[$attributes_map['phone']['attribute']])) {
				$members[] = 'tel:'.$item[$attributes_map['phone']['attribute']][0];
			    }
			}
		    }
		    $entry[0]['member_mailto'] = $members;
		}
	    } else {
		$vcard_map = $vcard_user_map;
	    }
            echo print_vcard($entry[0], $attributes_map, $vcard_map, $vcard_version);
            die;
        }

    }
}

$smarty->assign("entry", $entry[0]);
$smarty->assign("dn", $dn);

$smarty->assign("card_title", $display_title);
$smarty->assign("card_items", $search_items);
$smarty->assign("show_undef", $display_show_undefined);
$smarty->assign("type", $type);
?>
