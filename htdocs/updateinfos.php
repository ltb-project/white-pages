<?php

$action = "displayform";
$dn = $_SESSION["userdn"];
$entry = "";
$item_list = array();
$result = "";
$type = "";
$photo_defined = false;

if (isset($_POST["dn"]) and $_POST["dn"]) {
    $action = "updateentry";
    if (isset($_FILES['photo'])) {
      $action = "updatephoto";
    }
    if (isset($_POST['deletephoto']) and $_POST['deletephoto']) {
      $action = "deletephoto";
    }
}

if (!$dn) {
    error_log("No user DN found, abort infos update");
    $result = "dnrequired";
    $action = "displayentry";
}

if ($result === "") {

    require_once("../lib/date.inc.php");

    # Connect to LDAP
    $ldap_connection = $ldapInstance->connect();

    $ldap = $ldap_connection[0];
    $result = $ldap_connection[1];

    if ($ldap) {

        # Find object type
        # 1. Check type parameter
        if (isset($_POST['type'])) {
            $type = $_POST['type'];
        }
        # 2. Use ldap_user_regex
        else if (isset($ldap_user_regex)) {
            if ( preg_match( $ldap_user_regex, $dn) ) {
                $type = "user";
            } else {
                $type = "group";
            }
        }
        # 3. Check LDAP filter on object
        else {
            $user_search = ldap_read($ldap, $dn, $ldap_user_filter, array('1.1'));
            $errno = ldap_errno($ldap);
            if ( $errno ) {
                error_log("LDAP - Object type search error $errno  (".ldap_error($ldap).")");
            } else if ( ldap_count_entries($ldap, $user_search) ) {
                $type = "user";
            }
            $group_search = ldap_read($ldap, $dn, $ldap_group_filter, array('1.1'));
            $errno = ldap_errno($ldap);
            if ( $errno ) {
                error_log("LDAP - Object type earch error $errno  (".ldap_error($ldap).")");
            } else if ( ldap_count_entries($ldap, $group_search) ) {
                $type = "group";
            }
        }

        # Update entry
        if ($action == "updateentry") {

            # Get all data
            $update_attributes = array();
            foreach ($update_items as $item) {
                $values = array();
                $item_keys = preg_grep("/^$item(\d+)$/", array_keys($_POST));
                foreach ($item_keys as $item_key) {
                    if (isset($_POST[$item_key]) and !empty($_POST[$item_key])) {
                        $value = $_POST[$item_key];
                        if ( $attributes_map[$item]['type'] == "date" ||  $attributes_map[$item]['type'] == "ad_date" ) {
                            $value = $directory->getLdapDate(new DateTime($_POST[$item_key]));
                        }
                        $values[] = $value;
                    }
                }

                $update_attributes[ $attributes_map[$item]['attribute'] ] = $values;
            }

            # Use macros
            foreach ($update_items_macros as $item => $macro) {
                $value = preg_replace_callback('/%(\w+)%/',
                    function ($matches) use ($item, $update_attributes, $attributes_map) {
                        return $update_attributes[ $attributes_map[$matches[1]]['attribute'] ][0];
                    },
                    $macro);
                error_log( "Use macro $macro for item $item: $value" );
                $update_attributes[ $attributes_map[$item]['attribute'] ] = $value;
            }

            # Update entry
            if (!ldap_mod_replace($ldap, $dn, $update_attributes)) {
                error_log("LDAP - modify failed for $dn");
                $result = "updatefailed";
                $action = "displayform";
            } else {
                $errno = ldap_errno($ldap);
                if ( $errno ) {
                    error_log("LDAP - modify error $errno (".ldap_error($ldap).") for $dn");
                    $result = "updatefailed";
                    $action = "displayform";
                } else {
                    $result = "updateok";
                    $action = "displayentry";
                }
            }
        }

        # Update photo
        if ($action == "updatephoto") {
            if ( $_FILES['photo']['error'] ) {
                switch( $_FILES['photo']['error']) {
                case 1:
                case 2:
                    $result = "phototoobig";
                    break;
                case 4:
                    $result = "nophoto";
                    break;
                default:
                    $result = "photonotuploaded";
                }
                error_log("Upload photo for $dn failed with error $result (error code ".$_FILES['photo']['error'].")");
                $action = "displayform";
            } elseif (isset($update_photo_maxsize) and (filesize($_FILES['photo']['tmp_name']) >= $update_photo_maxsize)) {
                $result = "phototoobig";
                $action = "displayform";
            } else {

                if ($update_photo_ldap) {
                    $update_attributes = array($photo_ldap_attribute => file_get_contents($_FILES['photo']['tmp_name']));
                    if (!ldap_mod_replace($ldap, $dn, $update_attributes)) {
                        $result = "photonotuploaded";
                        $action = "displayform";
                    } else {
                        $action = "displayentry";
                    }
                }

                if ($update_photo_directory) {
                    $search = ldap_read($ldap, $dn, '(objectClass=*)', array($photo_local_ldap_attribute));
                    $entry = ldap_get_entries($ldap, $search);
                    $photo_name = $entry[0][$photo_local_ldap_attribute][0];
                    if (!move_uploaded_file($_FILES['photo']['tmp_name'], $photo_local_directory . $photo_name . $photo_local_extension )) {
                        $result = "photonotuploaded";
                        $action = "displayform";
                    } else {
                        $action = "displayentry";
                    }
                }
            }
        }

        # Delete photo
        if ($action == "deletephoto") {
            if ($update_photo_ldap) {
                $delete_attributes = array($photo_ldap_attribute => array());
                if (!ldap_mod_del($ldap, $dn, $delete_attributes)) {
                    $result = "photonotdeleted";
                    $action = "displayform";
                } else {
                    $action = "displayentry";
                }
            }

            if ($update_photo_directory) {
                $search = ldap_read($ldap, $dn, '(objectClass=*)', array($photo_local_ldap_attribute));
                $entry = ldap_get_entries($ldap, $search);
                $photo_name = $entry[0][$photo_local_ldap_attribute][0];
                if (!unlink($photo_local_directory . $photo_name . $photo_local_extension)) {
                    $result = "photonotdeleted";
                    $action = "displayform";
                } else {
                    $action = "displayentry";
                }
            }
        }

        # Display form
        if ($action == "displayform") {

            # Search attributes
            $attributes = array();
            $search_items = array_merge($display_items, $update_items);
            foreach( $search_items as $item ) {
                $attributes[] = $attributes_map[$item]['attribute'];
            }
            $attributes[] = $attributes_map[$display_title]['attribute'];
            if ($update_photo and $update_photo_ldap) {
                $attributes[] = $photo_ldap_attribute;
            }
            if ($update_photo and $update_photo_directory) {
                $attributes[] = $photo_local_ldap_attribute;
            }

            # Search entry
            $search = ldap_read($ldap, $dn, $ldap_user_filter, $attributes);
            $errno = ldap_errno($ldap);

            if ( $errno ) {
                $result = "ldaperror";
                error_log("LDAP - Search error $errno  (".ldap_error($ldap).")");
            } else {

                $entries = ldap_get_entries($ldap, $search);
                $entry = $ldapInstance->sortEntry($entries[0], $attributes_map);

                # Compute lists
                foreach ($update_items as $item) {
                    if ( $attributes_map[$item]["type"] === "static_list") {
                        $item_list[$item] = isset($attributes_static_list[$item]) ? $attributes_static_list[$item] : array();
                    }
                    if ( $attributes_map[$item]["type"] === "list") {
                        $item_list[$item] = $ldapInstance->get_list( $attributes_list[$item]["base"], $attributes_list[$item]["filter"], $attributes_list[$item]["key"], $attributes_list[$item]["value"]  );
                    }
                }

                # Look if photo exists
                if ($update_photo_ldap) {
                    $photo_defined = $entry[strtolower($photo_ldap_attribute)] ? true : false;
                }
                if ($update_photo_directory) {
                    $photo_name = $entry[$photo_local_ldap_attribute][0];
                    $photo_defined = file_exists($photo_local_directory . $photo_name . $photo_local_extension);
                }
            }
        }
    }
}

if ( $action == "displayentry" ) {
    $location = 'index.php?page=display&dn='.urlencode($dn).'&updateresult='.$result;
    header('Location: '.$location);
}

$smarty->assign("entry", $entry);
$smarty->assign("dn", $dn);
$smarty->assign("action", $action);

$smarty->assign("item_list", $item_list);

$smarty->assign("card_title", $display_title);
$smarty->assign("card_items", array_unique(array_merge($display_items, $update_items)));
$smarty->assign("update_items", $update_items);
$smarty->assign("show_undef", $display_show_undefined);
$smarty->assign("type", $type);
$smarty->assign("photo_defined", $photo_defined);
