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

    $ldapInstance = new \Ltb\Ldap(
                                 $ldap_url,
                                 $ldap_starttls,
                                 isset($ldap_binddn) ? $ldap_binddn : null,
                                 isset($ldap_bindpw) ? $ldap_bindpw : null,
                                 isset($ldap_network_timeout) ? $ldap_network_timeout : null,
                                 $dn,
                                 null,
                                 isset($ldap_krb5ccname) ? $ldap_krb5ccname : null
                             );

    $ldap_connection = $ldapInstance->connect();

    $return = $ldapInstance->get_first_value($dn, "base", $ldap_filter, $attribute);

    return $return;
}

function convert_ldap_date($date) {

    return ldapDate2phpDate( $date );

}

function convert_ad_date($date) {

    return adDate2phpDate( $date );

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

    $ldapInstance = new \Ltb\Ldap(
                                 $ldap_url,
                                 $ldap_starttls,
                                 isset($ldap_binddn) ? $ldap_binddn : null,
                                 isset($ldap_bindpw) ? $ldap_bindpw : null,
                                 isset($ldap_network_timeout) ? $ldap_network_timeout : null,
                                 $list_base,
                                 null,
                                 isset($ldap_krb5ccname) ? $ldap_krb5ccname : null
                             );

    $ldap_connection = $ldapInstance->connect();

    $filter = "(&".$list_filter."(".$list_key."=$value))";
    $return = $ldapInstance->get_first_value($list_base, "sub", $filter, $list_value);

    return $return;
}

function split_value($value,$separator) {

    return explode( $separator, $value );

}

?>
