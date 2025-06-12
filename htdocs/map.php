<?php
/*
 * Display all entries on a world map
 */

$result = "";
$entries = array();
$size_limit_reached = false;

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
$ldap_connection = $ldapInstance->connect();

$ldap = $ldap_connection[0];
$result = $ldap_connection[1];

$ldap_search_filter = $ldap_user_filter;
if (isset($map_user_filter)) {
    $ldap_search_filter = $map_user_filter;
}
# Search for users in group
if (isset($_GET['groupdn'])) {
    $ldap_search_filter = "(&" . $ldap_search_filter . "(memberOf=" . $_GET['groupdn'] . "))";
}
$result_items = array_merge($map_fullname_items, array_flatten($map_address_format), $map_additional_items);

if ($ldap) {

    # Search attributes
    foreach ($result_items as $item)
        $attributes[] = $attributes_map[$item]['attribute'];

    # Search for entries
    [$ldap, $result, $nb_entries, $entries, $size_limit_reached] = $ldapInstance->search($ldap_search_filter, $attributes, $attributes_map, null, null, $result_items);

}

$interestPoints = array();
foreach ($entries as $entry) {

    $fullnameBits = array();
    foreach ($map_fullname_items as $item) {
        $key = $attributes_map[$item]['attribute'];
        if (array_key_exists($key, $entry)) {
            array_push($fullnameBits, $entry[$key][0]);
        }
    }
    $addressBits = array();
    $displayAddress = "";
    foreach ($map_address_format as $item) {
        if (is_array($item)) {
            $displayAddressLine = array();
            foreach ($item as $subitem) {
                $key = $attributes_map[$subitem]['attribute'];
                if (array_key_exists($key, $entry)) {
                    array_push($addressBits, $entry[$key][0]);
                    array_push($displayAddressLine, $entry[$key][0]);
                }
            }
            if ($displayAddressLine) {
                $displayAddress .= implode(' ', $displayAddressLine) . "<br />";
            }
        } else {
            $key = $attributes_map[$item]['attribute'];
            if (array_key_exists($key, $entry)) {
                array_push($addressBits, $entry[$key][0]);
                $displayAddress .= $entry[$key][0] . "<br />";
            }
        }
    }

    $addtional_items = array();
    foreach ($map_additional_items as $item) {
        $key = $attributes_map[$item]['attribute'];
        if (array_key_exists($key, $entry)) {
            array_push($addtional_items, $entry[$key][0]);
        }
    }

    $point = array(
        "fullname" => implode(' ', $fullnameBits),
        "additional_items" => $addtional_items,
        "dn" => $entry["dn"],
        "address" => implode(' ', $addressBits),
        "display_address" => $displayAddress,
    );

    if ($point["address"] != "" and extension_loaded("APCu")) {
        $hashed_address = "geocode_" . hash('sha256', $point["address"]);
        if (apcu_exists($hashed_address)) {
            $location = json_decode(apcu_fetch($hashed_address), true);
            $point["location"] = $location[0];
        }
    }
    array_push($interestPoints, $point);
}

$smarty->assign("size_limit_reached", $size_limit_reached);

$smarty->assign("with_leaflet", true);
$smarty->assign("interest_points", json_encode($interestPoints, JSON_PRETTY_PRINT));

$smarty->assign("map_tileserver", $map_tileserver);
$smarty->assign("map_attribution", $map_attribution);
$smarty->assign("map_display_photos_as_marker", $map_display_photos_as_marker);
$smarty->assign("map_no_location_show_on_default", $map_no_location_show_on_default);
$smarty->assign("map_default_location_lat", $map_default_location_lat);
$smarty->assign("map_default_location_long", $map_default_location_long);
?>
