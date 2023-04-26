<?php
/*
 * Display photo
 */ 


require_once("../conf/config.inc.php");

$result = "";
$dn = "";
$entry = "";
$photo = "";

if (isset($_GET["dn"]) and $_GET["dn"])
{
    require_once("../conf/config.inc.php");
    require __DIR__ . '/../vendor/autoload.php';

    $dn = $_GET["dn"];

    # Defauft value for LDAP photo attribute
    if (!isset($photo_ldap_attribute)) { $photo_ldap_attribute = "jpegPhoto"; }
    $photo_attributes[] = $photo_ldap_attribute;
    if (isset($photo_local_ldap_attribute)) { $photo_attributes[] = $photo_local_ldap_attribute; }
    if ($use_gravatar) { array_push($photo_attributes, 'mail'); }

    # Connect to LDAP
    $ldap_connection = \Ltb\Ldap::connect($ldap_url, $ldap_starttls, $ldap_binddn, $ldap_bindpw, $ldap_network_timeout);

    $ldap = $ldap_connection[0];
    $result = $ldap_connection[1];

    if ($ldap) {

        # Search entry
        $search = ldap_read($ldap, $dn, $ldap_user_filter, $photo_attributes);

        $errno = ldap_errno($ldap);

        if ( $errno ) {
            $result = "ldaperror";
            error_log("LDAP - Search error $errno  (".ldap_error($ldap).")");
        } else {
            $entry = ldap_get_entries($ldap, $search);
            if ($use_gravatar) {    // If using gravatar
                $size = 240;
                if ($photo_fixed_width) {
                    $size = $photo_fixed_width;
                }
                $url = "https://www.gravatar.com/avatar/".md5($entry[0]['mail'][0]).".jpg?s=$size&d=404";
                $img = @file_get_contents($url);    // Ignore warning (404)

                if (!empty($img)) {
                    $photo = imagecreatefromstring($img);
                }
            }
            if (!$photo) {
                if ( !isset($entry[0][strtolower($photo_ldap_attribute)]) ) {
                    if ( $photo_local_ldap_attribute and isset($entry[0][strtolower($photo_local_ldap_attribute)]) ) {
                        $filephoto = $photo_local_directory . $entry[0][strtolower($photo_local_ldap_attribute)][0] . $photo_local_extension;
                        if ( file_exists($filephoto) ) {
                            $photo = imagecreatefromjpeg($filephoto);
                        }
                    }
                } else {
                    $ldapphoto = $entry[0][strtolower($photo_ldap_attribute)][0];
                    $photo = imagecreatefromstring($ldapphoto);
                }
            }
        }
    }
}
else {
    $result = "dnrequired";
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
