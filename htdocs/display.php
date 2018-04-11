<?php
/*
 * Display an entry 
 */ 

$result = "";
$dn = "";
$entry = "";
$type = "";

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
    $ldap_connection = wp_ldap_connect($ldap_url, $ldap_starttls, $ldap_binddn, $ldap_bindpw);

    $ldap = $ldap_connection[0];
    $result = $ldap_connection[1];

    # Find object type
    if ( preg_match( '/'.$ldap_group_base.'$/i', $dn) ) { $type = "group"; }
    else { $type = "user"; }

    if ($ldap) {

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

	if ($use_vcard and $_GET["vcard"]) {
            require_once("../lib/vcard.inc.php");
            $vcard_file = $entry[0][$attributes_map[$vcard_file_identifier]['attribute']][0].".".$vcard_file_extension;
            download_vcard_send_headers($vcard_file);
            echo print_vcard($entry[0], $attributes_map, $vcard_map, $vcard_version);
            die;
        }
    }
}

$smarty->assign("entry", $entry[0]);

$smarty->assign("card_title", $display_title);
$smarty->assign("card_items", $search_items);
$smarty->assign("show_undef", $display_show_undefined);
$smarty->assign("type", $type);
?>
