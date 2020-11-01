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

    require_once("../conf/config.inc.php");
    require_once("../lib/ldap.inc.php");

    # Connect to LDAP
    $ldap_connection = wp_ldap_connect($ldap_url, $ldap_starttls, $ldap_binddn, $ldap_bindpw, $ldap_network_timeout);

    $ldap = $ldap_connection[0];
    $result = $ldap_connection[1];

    # Find object type
    if (isset($_POST['type'])) {
        $type = $_POST['type'];
    } else if (isset($_GET["type"])) {
	$type = $_GET["type"];
    } else if (isset($ldap_user_regex)) {
        if ( preg_match( $ldap_user_regex, $dn) ) {
            $type = "user";
        } else {
            $type = "group";
        }
    } else if ( strpos($ldap_user_base, $ldap_group_base) ) {
	if ( strpos($ldap_group_base, $ldap_user_base) ) {
	    $type = "guess";
	} else if ( preg_match( '/'.$ldap_user_base.'$/i', $dn) ) {
	    $type = "user";
	} else if ( preg_match( '/'.$ldap_group_base.'$/i', $dn) ) {
	    $type = "group";
	} else {
	    $type = "guess";
	}
    } else if ( preg_match( '/'.$ldap_user_base.'$/i', $dn) ) {
	$type = "user";
    } else if ( preg_match( '/'.$ldap_group_base.'$/i', $dn) ) {
	$type = "group";
    } else {
	$type = "guess";
    }

    if ($ldap) {

        # Search attributes
        $attributes = array();
        $search_items = array();

        if ( $type === "guess" ) {
	    $guess_filter = "(|".$ldap_user_filter.$ldap_group_filter.")";
	    $guess_search = ldap_read($ldap, $dn, $guess_filter, [ "objectClass" ]);
	    $errno = ldap_errno($ldap);

	    if ( $errno ) {
		$result = "ldaperror";
		error_log("LDAP - Search error $errno  (".ldap_error($ldap).")");
	    } else {
		$guess_entry = ldap_get_entries($ldap, $guess_search);
		foreach ($guess_entry[0] as $attr => $values) {
		    if ( $values['count'] > 1 ) {
			asort($values);
		    }
		    if ( isset($values['count']) ) {
			unset($values['count']);
		    }
		    $guess_entry[0][$attr] = $values;
		}
		foreach ($display_group_objectclasses as $matchGroup) {
		    if (strlen(array_search(strtolower($matchGroup),
			    array_map('strtolower', $guess_entry[0]['objectClass']))) > 0) {
			$type = "group";
			break;
		    }
		}
		if ( $type === "guess" ) {
		    $type = "user";
		}
	    }
	}
	if ( $type != "guess" ) {
	    if ( $type === "user" ) { $search_items = $display_items;  }
	    if ( $type === "group" ) { $search_items = $display_group_items;  }
	    foreach( $search_items as $item ) {
		$attributes[] = $attributes_map[$item]['attribute'];
	    }
	    $attributes[] = $attributes_map[$display_title]['attribute'];

	    if ($use_vcard and isset($_GET["vcard"]) and $vcard_file_identifier) {
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
		if ( $values['count'] > 1 ) {
		    asort($values);
		}
		if ( isset($values['count']) ) {
		    unset($values['count']);
		}
		$entry[0][$attr] = $values;
	    }

	    if ($use_vcard and isset($_GET["vcard"])) {
		require_once("../lib/vcard.inc.php");
		$vcard_file = $entry[0][$attributes_map[$vcard_file_identifier]['attribute']][0].".".$vcard_file_extension;
		download_vcard_send_headers($vcard_file);
		echo print_vcard($entry[0], $attributes_map, $vcard_map, $vcard_version);
		die;
	    }

	    if ($display_edit_link) {
		    # Replace {dn} in URL
		    $edit_link = str_replace("{dn}", urlencode($dn), $display_edit_link);
	    }
	}
    }
}

$smarty->assign("entry", $entry[0]);

$smarty->assign("card_title", $display_title);
$smarty->assign("card_items", $search_items);
$smarty->assign("show_undef", $display_show_undefined);
$smarty->assign("objecttype", $type);

$smarty->assign("edit_link", $edit_link);
?>
