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

    # Defauft value for LDAP photo attribute
    if (!isset($photo_ldap_attribute)) { $photo_ldap_attribute = "jpegPhoto"; }

    # Connect to LDAP
    $ldap_connection = wp_ldap_connect($ldap_url, $ldap_starttls, $ldap_binddn, $ldap_bindpw);

    $ldap = $ldap_connection[0];
    $result = $ldap_connection[1];

    if ($ldap) {

        # Search entry
        $search = ldap_read($ldap, $dn, $ldap_user_filter, array($photo_ldap_attribute));

        $errno = ldap_errno($ldap);

        if ( $errno ) {
            $result = "ldaperror";
            error_log("LDAP - Search error $errno  (".ldap_error($ldap).")");
        } else {
            $entry = ldap_get_entries($ldap, $search);
            if ( !isset($entry[0][strtolower($photo_ldap_attribute)]) ) {
                $result = "photonotfound";
            } else {
                $ldapphoto = $entry[0][strtolower($photo_ldap_attribute)][0];
                $photo = imagecreatefromstring($ldapphoto);
            }
        }
    }
}

# Display default photo if any error
if ( !$photo ) {
    $photo = imagecreatefromjpeg($default_photo);
}

# Resize photo if needed
if ($photo_fixed_width or $photo_fixed_height) {
    $ratio = imagesx($photo)/imagesy($photo);
    $width = $photo_fixed_width ? $photo_fixed_width : $photo_fixed_height * $ratio;
    $height = $photo_fixed_height ? $photo_fixed_height : $photo_fixed_width / $ratio;
    $src = $photo;
    $photo = imagecreatetruecolor($width,$height);
    imagecopyresampled($photo,$src,0,0,0,0,$width,$height,imagesx($src),imagesy($src));
    imagedestroy($src);
}

header('Content-Type: image/jpeg');
imagejpeg($photo);
imagedestroy($photo);

?>
