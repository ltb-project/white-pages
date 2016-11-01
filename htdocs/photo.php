<?php
/*
 * Display photo
 */ 


require_once("../conf/config.inc.php");

$result = "";
$dn = "";

if (isset($_GET["dn"]) and $_GET["dn"]) { $dn = $_GET["dn"]; }
 else { $result = "dnrequired"; }

$result = "notfound";

# Display default photo if any error
if ($result !== "") {
    $photo=imagecreatefromjpeg($default_photo);
    header('Content-Type: image/jpeg');
    imagejpeg($photo);
    imagedestroy($photo);
}

?>
