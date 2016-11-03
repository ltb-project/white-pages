<?php
/*
 * Display photo
 */ 


require_once("../conf/config.inc.php");

$result = "";
$dn = "";
$entry = "";
$photo = "";

if (isset($_GET["dn"]) and $_GET["dn"]) { $dn = $_GET["dn"]; }
 else { $result = "dnrequired"; }

if ($result === "") {

    require_once("../conf/config.inc.php");
    require_once("../lib/ldap.inc.php");

    # Connect to LDAP
    $ldap_connection = wp_ldap_connect($ldap_url, $ldap_starttls, $ldap_binddn, $ldap_bindpw);

    $ldap = $ldap_connection[0];
    $result = $ldap_connection[1];

    if ($ldap) {

        # Search entry
        $search = ldap_read($ldap, $dn, $ldap_user_filter, array('jpegPhoto'));

        $errno = ldap_errno($ldap);

        if ( $errno ) {
            $result = "ldaperror";
            error_log("LDAP - Search error $errno  (".ldap_error($ldap).")");
        } else {
            $entry = ldap_get_entries($ldap, $search);
            if ( !isset($entry[0]["jpegphoto"]) ) {
                $result = "photonotfound";
            } else {
                $jpegphoto = $entry[0]["jpegphoto"][0];
                $photo = imagecreatefromstring($jpegphoto);
            }
        }
    }
}

# Display default photo if any error
if ( !$photo ) {
    $photo = imagecreatefromjpeg($default_photo);
}

header('Content-Type: image/jpeg');
imagejpeg($photo);
imagedestroy($photo);

?>
