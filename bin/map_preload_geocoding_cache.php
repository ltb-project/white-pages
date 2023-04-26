#!/usr/bin/php
<?php
/*
 * Geocode addresses for all entries and preload geocoding cache, respecting geocoding API rate limits of maximum 1 req/s
 */

$result = "";
$entries = array();
$size_limit_reached = false;

require_once("conf/config.inc.php");
require __DIR__ . '/../vendor/autoload.php';

$opts = array(
    'http' => array(
        # Set timeout to 5 seconds
        'timeout' => 5,
        'user_agent' => "LTB White-Pages address geocoding/1.0"
    )
);
$context = stream_context_create($opts);

function array_flatten($arr, $flat = [])
{
    if (is_array($arr)) {
        foreach ($arr as $item) {
            $flat = array_flatten($item, $flat);
        }
    } else {
        array_push($flat, $arr);
    }
    return $flat;
}

# Connect to LDAP
$ldap_connection = \Ltb\Ldap::connect($ldap_url, $ldap_starttls, $ldap_binddn, $ldap_bindpw, $ldap_network_timeout);

$ldap = $ldap_connection[0];
$result = $ldap_connection[1];

$ldap_search_base = $ldap_user_base;
$ldap_search_filter = $ldap_user_filter;
if (isset($map_user_filter)) {
    $ldap_search_filter = $map_user_filter;
}
# Search for users in group
if (isset($_GET['groupdn'])) {
    $ldap_search_filter = "(&" . $ldap_search_filter . "(memberOf=" . $_GET['groupdn'] . "))";
}
$result_items = array_flatten($map_address_format);

if ($ldap) {

    # Search attributes
    foreach ($result_items as $item)
        $attributes[] = $attributes_map[$item]['attribute'];

    # Search for entries
    $search = ldap_search($ldap, $ldap_search_base, $ldap_search_filter, $attributes, 0, $ldap_size_limit);

    $errno = ldap_errno($ldap);

    if ($errno == 4) {
        $size_limit_reached = true;
    }
    if ($errno != 0 and $errno != 4) {
        $result = "ldaperror";
        error_log("LDAP - Search error $errno  (" . ldap_error($ldap) . ")");
    } else {
        # Get search results
        if (ldap_count_entries($ldap, $search) === 0) {
            $result = "noentriesfound";
        } else {
            $entries = ldap_get_entries($ldap, $search);
            unset($entries["count"]);
        }
    }
}
$interestPoints = array();
foreach ($entries as $entry) {

    $addressBits = array();
    foreach ($map_address_format as $item) {
        if (is_array($item)) {
            foreach ($item as $subitem) {
                $key = $attributes_map[$subitem]['attribute'];
                if (array_key_exists($key, $entry)) {
                    array_push($addressBits, $entry[$key][0]);
                }
            }
        } else {
            $key = $attributes_map[$item]['attribute'];
            if (array_key_exists($key, $entry)) {
                array_push($addressBits, $entry[$key][0]);
            }
        }
    }

    $address = implode(' ', $addressBits);
    if ($address === "") {
        continue;
    }

    print(". geocode and store address if needed: " . $address . "\n");
    $URL = $http_url . '/geocode.php?preload=1&q=' . urlencode($address);
    $json = file_get_contents($URL, false, $context);
    if ($json === false || strpos($json, 'Location not found') === 0) {
        print("  . Location not found\n");
        continue;
    }

    if (strpos($json, 'Already in cache') === 0) {
        print("  . Already in cache, skipping rate limit wait\n");
        continue;
    }

    // Sleep to respect geocoding API rate limit
    sleep(1);
}

?>
