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

$http_settings = array(
        # Set timeout to 5 seconds
        'timeout' => 5,
        'user_agent' => "LTB White-Pages address geocoding/1.0"
);

if  (isset($use_proxy) and $use_proxy) {
    if ( isset($proxy_host) and ($proxy_host != "") and isset($proxy_port) and ($proxy_port != "")) {
        # proxy settings are valid
        $http_settings['proxy'] = "tcp://" . $proxy_host . ":" . $proxy_port;

        if (isset($proxy_authentication_method)) {
             if (isset($proxy_authentication_user) and isset($proxy_authentication_pass)){
                if ($proxy_authentication_method === "basic") {
                    $http_settings['header'] = "Proxy-Authorization: Basic " . base64_encode($proxy_authentication_user . ":" . $proxy_authentication_pass);
                } else if ($proxy_authentication_method !== "none") {
                    error_log("Proxy authentication method '" . $proxy_authentication_method . "' is not yet supported.");
                }
            } else {
                error_log("Proxy authentication method is set to 'basic' but proxy authentication user and/or password is not set in config.inc.local.php.");
            } 
        }
        
        if ($proxy_request_fulluri) {
            $http_settings['request_fulluri'] = true;
        }
        if ( isset($proxy_ssl_options) ) {
            $http_settings['ssl'] = $proxy_ssl_options;
        }
    } else {
        error_log("Proxy usage is enabled but proxy host and/or port is not set in config.inc.local.php.");
    }
    
}

$opts = array(
    'http' => $http_settings
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
