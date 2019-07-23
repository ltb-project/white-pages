<?php
# LDAP Functions 

function wp_ldap_connect($ldap_url, $ldap_starttls, $ldap_binddn, $ldap_bindpw) {

    # Connect to LDAP
    $ldap = ldap_connect($ldap_url);
    ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

    if ( $ldap_starttls && !ldap_start_tls($ldap) ) {
        error_log("LDAP - Unable to use StartTLS");
        return array(false, "ldaperror");
    }

    # Bind
    if ( isset($ldap_binddn) && isset($ldap_bindpw) ) {
        $bind = ldap_bind($ldap, $ldap_binddn, $ldap_bindpw);
    } else {
        $bind = ldap_bind($ldap);
    }

    if ( !$bind ) {
        $errno = ldap_errno($ldap);
        if ( $errno ) {
            error_log("LDAP - Bind error $errno  (".ldap_error($ldap).")");
        } else {
            error_log("LDAP - Bind error");
        }
        return array(false, "ldaperror");
    }

    return array($ldap, false);
}

function wp_ldap_get_list($ldap, $ldap_base, $ldap_filter, $key, $value) {

    $return = array();

    if ($ldap) {

        # Search entry
        $search = ldap_search($ldap, $ldap_base, $ldap_filter, array($key, $value) );

        $errno = ldap_errno($ldap);

        if ( $errno ) {
            error_log("LDAP - Search error $errno  (".ldap_error($ldap).")");
        } else {
            $entries = ldap_get_entries($ldap, $search);
            for ($i=0; $i<$entries["count"]; $i++) {
                if(isset($entries[$i][$key][0])) {
                    $return[$entries[$i][$key][0]] = isset($entries[$i][$value][0]) ? $entries[$i][$value][0] : $entries[$i][$key][0];
                }
            }
        }
    }

    return $return;
}
?>
