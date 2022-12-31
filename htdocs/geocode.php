<?php

require_once("../conf/config.inc.php");

$default_location = '[{"lat": ' . $map_default_location_lat . ', "lon": ' . $map_default_location_long . '}]';

$q = $_GET["q"];
$preload = $_GET["preload"];
$no_cache = $_GET["no_cache"];
$hashed_address = "geocode_" . hash('sha256', $q);

if (extension_loaded("APCu")) {
    if ($no_cache == "1") {
        apcu_delete($hashed_address);
    }
    if (apcu_exists($hashed_address)) {
        header('Content-Type: application/json; charset=UTF-8');
        if ($preload === "1") {
            print("Already in cache\n");
        } else {
            print(apcu_fetch($hashed_address) . "\n");
        }
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
    if ($map_no_location_show_on_default and $preload != "1") {
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
