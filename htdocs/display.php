<?php
/*
 * Display an entry 
 */ 

$result = "";
$dn = "";
$entry = "";

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

    if ($ldap) {

        # Search attributes
        $attributes = array();
        foreach( $display_items as $item ) {
            $attributes[] = $attributes_map[$item]['attribute'];
        }
        $attributes[] = $attributes_map[$display_title]['attribute'];

        # Search entry
        $search = ldap_read($ldap, $dn, $ldap_user_filter, $attributes);

        $errno = ldap_errno($ldap);

        if ( $errno ) {
            $result = "ldaperror";
            error_log("LDAP - Search error $errno  (".ldap_error($ldap).")");
        } else {
            $entry = ldap_get_entries($ldap, $search);
        }

	if ($use_vcard and $_GET["vcard"]) {
            require_once("../lib/vcard.inc.php");
            download_vcard_send_headers("$dn.vcard");
            echo print_vcard($entry[0], $attributes_map, $vcard_map, $vcard_version);
            die;
        }
    }
}

$smarty->assign("entry", $entry[0]);

?>
