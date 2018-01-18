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
        $search = ldap_read($ldap, $dn, $ldap_user_filter, array('jpegPhoto','uid'));

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

# Display jpeg photo file if exist and Display default photo if any error
if ( !$photo ) {
	$userphotofilename="images/trombinoscope/".$entry[0]["uid"][0].".jpg";
	if (file_exists($userphotofilename))
	{
	$size = getimagesize($userphotofilename);
	$ratio = $size[0]/$size[1]; // width/height
	if( $ratio > 1) {
    	$width = 240;
    	$height = 240/$ratio;
	}
	else {
    	$width = 240*$ratio;
    	$height = 240;
	}
	$src = imagecreatefromjpeg($userphotofilename);
	$dst = imagecreatetruecolor($width,$height);
	imagecopyresampled($dst,$src,0,0,0,0,$width,$height,$size[0],$size[1]);
	$photo = $dst;
	}
	else { $photo = imagecreatefromjpeg($default_photo);}
}

header('Content-Type: image/jpeg');
imagejpeg($photo);
imagedestroy($photo);

?>
