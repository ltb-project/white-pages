<?php

$result = "";
$login = "";
$password = "";
$userdn = "";

$page = "welcome";
if (isset($_GET["return_page"]) and $_GET["return_page"]) { $page = $_GET["page"]; }
$return_url = "index.php?page=".$page;

# If already authenticated
if (isset($_SESSION["userdn"])) {
    header("Location: $return_url");
}

# SSO Header
if ($auth_type === "header") {

    $auth_header_key = "HTTP_".strtoupper(str_replace('-','_',$auth_header_name_user));
    if (array_key_exists($auth_header_key, $_SERVER)) {
        $login = $_SERVER[$auth_header_key];
    }

    if (!$login) {
        $result = "auth_sso_fail";
        error_log("SSO authentication requested but no value found in  $auth_header_name_user HTTP header");
    }

}

# LDAP
$ldap_connection = $ldapInstance->connect();

$ldap = $ldap_connection[0];
$result = $ldap_connection[1];

if ($auth_type === "ldap") {
    if (isset($_POST["login"]) and $_POST["login"]) { $login = $_POST["user"]; }
    if (isset($_POST["password"]) and $_POST["password"]) { $password = $_POST["user"]; }
}

# Search for user
if ($result == "") {

    $search_login = ldap_escape($login, "", LDAP_ESCAPE_FILTER);
    $ldap_filter = str_replace("{login}", $search_login, $ldap_login_filter);
    $search = $ldapInstance->search_with_scope($ldap_scope, $ldap_user_base, $ldap_filter);

    $errno = ldap_errno($ldap);
    if ( $errno ) {
        $result = "ldaperror";
        error_log("LDAP - Search error $errno (".ldap_error($ldap).")");
    } else {

        # Get user DN
        $entry = ldap_first_entry($ldap, $search);

        if( !$entry ) {
            $result = "badcredentials";
            error_log("LDAP - User $login not found");
        } else { 
            $userdn = ldap_get_dn($ldap, $entry);
        }
    }
}

# Create session
if ($result == "") {
    $_SESSION["userdn"] = $userdn;
    header("Location: $return_url");
}

?>
