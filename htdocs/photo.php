<?php
/*
 * Display photo
 */ 


require_once("../conf/config.inc.php");
require_once("../vendor/autoload.php");

$ldapInstance = new \Ltb\Ldap(
                                 $ldap_url,
                                 $ldap_starttls,
                                 isset($ldap_binddn) ? $ldap_binddn : null,
                                 isset($ldap_bindpw) ? $ldap_bindpw : null,
                                 isset($ldap_network_timeout) ? $ldap_network_timeout : null,
                                 $ldap_base,
                                 isset($ldap_size_limit) ? $ldap_size_limit : 0,
                                 isset($ldap_krb5ccname) ? $ldap_krb5ccname : null,
                                 isset($ldap_page_size) ? $ldap_page_size : 0
                             );
$result = "";
$dn = "";
$entry = "";
$photo = "";

if (isset($_GET["dn"]) and $_GET["dn"])
{
    $dn = $_GET["dn"];

    # Defauft value for LDAP photo attribute
    if (!isset($photo_ldap_attribute)) { $photo_ldap_attribute = "jpegPhoto"; }
    $photo_attributes[] = $photo_ldap_attribute;
    if (isset($photo_local_ldap_attribute)) { $photo_attributes[] = $photo_local_ldap_attribute; }
    if ($use_gravatar) { array_push($photo_attributes, 'mail'); }

    # Connect to LDAP
    $ldap_connection = $ldapInstance->connect();

    $ldap = $ldap_connection[0];
    $result = $ldap_connection[1];

    if ($ldapInstance->connect()[0]) {

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

if ( !$photo ) {
    # If `no_fallback` in GET parameters, fail with 404
    if(isset($_GET['no_fallback'])) {
        http_response_code(404);
        die();
    }

    # Else, display default photo if any error
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
