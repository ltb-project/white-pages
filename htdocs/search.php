<?php
/*
 * Search entries in LDAP directory
 */ 

$result = "";
$search_query = "";
$nb_entries = 0;
$entries = array();

if (isset($_POST["search"]) and $_POST["search"]) { $search_query = $_POST["search"]; }
 else { $result = "searchrequired"; }

if ($result === "") {

    require_once("../conf/config.inc.php");

    # Connect to LDAP
    $ldap = ldap_connect($ldap_url);
    ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

    if ( $ldap_starttls && !ldap_start_tls($ldap) ) {
        $result = "ldaperror";
        error_log("LDAP - Unable to use StartTLS");
    } else {

        # Bind
        if ( isset($ldap_binddn) && isset($ldap_bindpw) ) {
            $bind = ldap_bind($ldap, $ldap_binddn, $ldap_bindpw);
        } else {
            $bind = ldap_bind($ldap);
        }

        $errno = ldap_errno($ldap);

        if ( $errno ) {
            $result = "ldaperror";
            error_log("LDAP - Bind error $errno  (".ldap_error($ldap).")");
        } else {

            # Search filter
            $ldap_filter = "(&".$ldap_user_filter;
            foreach ($ldap_user_search_attributes as $lusa) {
                $ldap_filter .= "($lusa=*$search_query*)";
            }
            $ldap_filter .= ")";

            # Search for users
            $search = ldap_search($ldap, $ldap_user_base, $ldap_filter);

            $errno = ldap_errno($ldap);

            if ( $errno ) {
                $result = "ldaperror";
                error_log("LDAP - Search error $errno  (".ldap_error($ldap).")");
            } else {

                # Get search results
                $nb_entries = ldap_count_entries($ldap, $search);

                if ($nb_entries === 0) {
                    $result = "noentriesfound";
                } else {
                    $entries = ldap_get_entries($ldap, $search);
                }
            }
        }
    }
}

$smarty->assign("nb_entries", $nb_entries);

?>
