<?php

$ldap = "";
$result = "";
$login = "";
$password = "";
$userdn = "";
$action = "";

$return_url = "index.php";
if (isset($_REQUEST["return_page"]) and $_REQUEST["return_page"]) { $return_url = "index.php?page=".$_REQUEST["return_page"]; }
if (isset($_POST["action"]) and $_POST["action"]) { $action = $_POST["action"]; }

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
        error_log("SSO authentication requested but no value found in $auth_header_name_user HTTP header");
        $page = "error";
    }

}

# Start LDAP connection if needed
if (($auth_type === "header" and $result == "") or ($auth_type === "ldap" and $action === "login")) {
    $ldap_connection = $ldapInstance->connect();
    $ldap = $ldap_connection[0];
    $result = $ldap_connection[1];
}

# Get form data
if ($auth_type === "ldap" and $action === "login") {
    if (isset($_POST["login"]) and $_POST["login"]) { $login = $_POST["login"]; }
    if (isset($_POST["password"]) and $_POST["password"]) { $password = $_POST["password"]; }
}

# Search for user
if ($result == "" and ($auth_type === "header" or ($auth_type === "ldap" and $action === "login"))) {

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
            $result = "passwordinvalid";
            error_log("LDAP - User $login not found");
        } else { 
            $userdn = ldap_get_dn($ldap, $entry);
        }
    }
}

# Authenticate user
if ($result == "" and $action === "login" and $auth_type === "ldap") {
    $bind = ldap_bind($ldap, $userdn, $password);
    if (!$bind) {
        $result = "passwordinvalid";
        error_log("LDAP - Bind error for $userdn)");
    }
}

# Create session
if ($result == "" and $userdn) {
    $_SESSION["userdn"] = $userdn;
    header("Location: $return_url");
}

# Display login form
$smarty->assign("return_page", $return_page);

?>
