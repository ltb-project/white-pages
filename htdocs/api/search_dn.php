<?php
if (isset($_POST["search"]) and $_POST["search"]) {

    $filter_escape_chars = "";
    if (!$search_use_substring_match) { $filter_escape_chars = "*"; }

    $search_query = ldap_escape($_POST["search"], $filter_escape_chars, LDAP_ESCAPE_FILTER);

    # Search filter
    $ldap_filter = "(&".$ldap_user_filter."(|";
    foreach ($quick_search_attributes as $attr) {
        $ldap_filter .= "($attr=*$search_query*)";
    }
    $ldap_filter .= "))";

    # Search attributes
    $attributes = array('cn');

    [$ldap,$result,$nb_entries,$entries,$size_limit_reached] = $ldapInstance->search($ldap_filter, $attributes, $attributes_map, $search_result_title, $search_result_sortby, $search_result_items, $ldap_scope);

    if ($nb_entries) {
        foreach($entries as $entry) {
            $data["entries"][] = array( "dn" => $entry["dn"], "display" => $entry["cn"][0]);
        }
    }

    if ($result) {
        $data["error"] = $messages[$result];
    }

    if ($size_limit_reached) {
        $data["warning"] = $messages["sizelimit"];
    }
}
?>
