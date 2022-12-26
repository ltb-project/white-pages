<?php

require_once("../conf/config.inc.php");

$default_location = '[{"lat": ' . $map_default_location_lat . ', "lon": ' . $map_default_location_long . '}]';

$q = $_GET["q"];
$hashed_address = "geocode_" . hash('sha256', $q);

if (extension_loaded("APCu")) {
    if (apcu_exists($hashed_address)) {
        header('Content-Type: application/json; charset=UTF-8');
        exit(0);
    }
}

$opts = array(
    'http' => array(
        # Set timeout to 5 seconds
        'timeout' => 5,
        'user_agent' => "LTB White-Pages address geocoding/1.0"
    )
);

$context = stream_context_create($opts);
$URL = sprintf($map_geocode_url, urlencode($q));

$json = file_get_contents($URL, false, $context);

if ($json === false) {
    if ($map_no_location_show_on_default) {
        header('Content-Type: application/json; charset=UTF-8');
        print($default_location);
        exit(0);
    } else {
        http_response_code(404);
        print("Location not found\n");
        exit(0);
    }
}

if (extension_loaded("APCu")) {
    apcu_store($hashed_address, $json);
}
header('Content-Type: application/json; charset=UTF-8');
print($json);
print("\n");
?>
