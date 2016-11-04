<?php
# Smarty functions

require_once("ldap.inc.php");

function print_dn_link($params, $smarty) {

    $html = "";
    $dn = $params["dn"];
    $display = $params["display"];
    $ldap_url = $params["ldap_url"];
    $ldap_starttls = $params["ldap_starttls"];
    $ldap_binddn = $params["ldap_binddn"];
    $ldap_bindpw = $params["ldap_bindpw"];
    $ldap_user_filter = $params["ldap_user_filter"];

    # Connect to LDAP
    $ldap_connection = wp_ldap_connect($ldap_url, $ldap_starttls, $ldap_binddn, $ldap_bindpw);

    $ldap = $ldap_connection[0];
    $result = $ldap_connection[1];

    if ($ldap) {

        # Search entry
        $search = ldap_read($ldap, $dn, $ldap_user_filter, array($display));

        $errno = ldap_errno($ldap);

        if ( $errno ) {
            error_log("LDAP - Search error $errno  (".ldap_error($ldap).")");
        } else {
            $entry = ldap_get_entries($ldap, $search);

            $html  = "<a href=\"index.php?page=display&dn=".urlencode($entry[0]["dn"])."\">";
            $html .= $entry[0][$display][0];
            $html .= "</a>";
        }
    }

    return $html;
}

?>
