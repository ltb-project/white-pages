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

    if (isset($_POST["search_type"]) and $_POST["search_type"] == "dn_link") {
        $attributes = $dn_link_label_attributes;
        if ($dn_link_search_display_macro) {
            preg_match_all('/%(\w+)%/', $dn_link_search_display_macro, $matches);
            foreach($matches[1] as $item) {
                $attributes[] = $attributes_map[$item]['attribute'];
            }
        }
    }

    [$ldap,$result,$nb_entries,$entries,$size_limit_reached] = $ldapInstance->search($ldap_filter, $attributes, $attributes_map, $search_result_title, $search_result_sortby, $search_result_items, $ldap_scope);

    if ($nb_entries) {
        foreach($entries as $entry) {
            $display = $entry["cn"][0];
            if (isset($_POST["search_type"]) and $_POST["search_type"] == "dn_link" and $dn_link_search_display_macro) {
                $display = preg_replace_callback('/%(\w+)%/',
                    function ($matches) use ($entry, $attributes_map) {
                        return $entry[ $attributes_map[$matches[1]]['attribute'] ][0];
                    },
                    $dn_link_search_display_macro);
            }
            $data["entries"][] = array( "dn" => $entry["dn"], "display" => $display);
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
