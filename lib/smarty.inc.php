<?php
# Smarty functions

require __DIR__ . '/../vendor/autoload.php';
require_once("date.inc.php");
require_once("filesize.inc.php");

function get_attribute($params) {

    $return = "";
    $dn = $params["dn"];
    $attribute = $params["attribute"];
    $ldap_url = $params["ldap_url"];
    $ldap_starttls = $params["ldap_starttls"];
    $ldap_binddn = $params["ldap_binddn"];
    $ldap_bindpw = $params["ldap_bindpw"];
    $ldap_filter = $params["ldap_filter"];
    $ldap_network_timeout = $params["ldap_network_timeout"];

    # Connect to LDAP
    $ldap_connection = \Ltb\Ldap::connect($ldap_url, $ldap_starttls, $ldap_binddn, $ldap_bindpw, $ldap_network_timeout);

    $ldap = $ldap_connection[0];
    $result = $ldap_connection[1];

    if ($ldap) {

        # Search entry
        $search = ldap_read($ldap, $dn, $ldap_filter, explode(",", $attribute));

        $errno = ldap_errno($ldap);

        if ( $errno ) {
            error_log("LDAP - Search error $errno  (".ldap_error($ldap).")");
        } else {
            $entry = ldap_get_entries($ldap, $search);

	    # Loop over attribute
	    foreach ( explode(",", $attribute) as $ldap_attribute ) {
                if ( isset ($entry[0][$ldap_attribute]) ) {
		     $return = $entry[0][$ldap_attribute][0];
		     break;
	        }
	    }
        }
    }

    return $return;
}

function convert_ldap_date($date) {

    return ldapDate2phpDate( $date );

}

function convert_guid_value($binary) {

    $unpacked = unpack('Va/v2b/n2c/Nd', $binary);
    return sprintf('%08X-%04X-%04X-%04X-%04X%08X', $unpacked['a'], $unpacked['b1'], $unpacked['b2'], $unpacked['c1'], $unpacked['c2'], $unpacked['d']);

}

function convert_bytes($bytes) {

    return FileSizeConvert( $bytes );

}

function get_list_value($params) {
    $value = $params["value"];
    $ldap_url = $params["ldap_url"];
    $ldap_starttls = $params["ldap_starttls"];
    $ldap_binddn = $params["ldap_binddn"];
    $ldap_bindpw = $params["ldap_bindpw"];
    $ldap_network_timeout = $params["ldap_network_timeout"];
    $list_base = $params['list_base'];
    $list_filter = $params['list_filter'];
    $list_key = $params['list_key'];
    $list_value = $params['list_value'];
    $return = $value;

    # Connect to LDAP
    $ldap_connection = \Ltb\Ldap::connect($ldap_url, $ldap_starttls, $ldap_binddn, $ldap_bindpw, $ldap_network_timeout);

    $ldap = $ldap_connection[0];
    $result = $ldap_connection[1];

    if ($ldap) {
        # Search entry
        $filter = "(&".$list_filter."(".$list_key."=$value))";
        $search = ldap_search($ldap, $list_base, $filter, [$list_value]);

        $errno = ldap_errno($ldap);

        if ( $errno ) {
            error_log("LDAP - Search error $errno  (".ldap_error($ldap).")");
	} else {
            $entry = ldap_get_entries($ldap, $search);
            if ( isset ($entry[0][$list_value]) ) {
                $return = $entry[0][$list_value][0];
	    }
        }
    }

    return $return;
}


?>
