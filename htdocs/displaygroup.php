<?php
/*
 * Display a groupofname entry 
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
        foreach( $display_group_items as $item ) {
            $attributes[] = $attributes_group_map[$item]['attribute'];
        }
        $attributes[] = $attributes_group_map[$display_group_title]['attribute'];

        # Search entry
        $search = ldap_read($ldap, $dn, $ldap_group_filter, $attributes);

        $errno = ldap_errno($ldap);

        if ( $errno ) {
            $result = "ldaperror";
            error_log("LDAP - Search error $errno  (".ldap_error($ldap).")");
        } else {
            $entry = ldap_get_entries($ldap, $search);
        }
    }
}

$smarty->assign("entry", $entry[0]);

?>
