<?php
#==============================================================================
# LTB White Pages
#
# Copyright (C) 2016 Clement OUDOT
# Copyright (C) 2016 LTB-project.org
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# GPL License: http://www.gnu.org/licenses/gpl.txt
#
#==============================================================================

#==============================================================================
# All the default values are kept here, you should not modify it but use
# config.inc.local.php file instead to override the settings from here.
#==============================================================================

# Authentication
$require_auth = false;
$auth_type = "ldap"; # "ldap" or "header"
#$auth_header_name_user = "Auth-User";

# LDAP
$ldap_url = "ldap://localhost";
$ldap_starttls = false;
$ldap_binddn = "cn=manager,dc=example,dc=com";
$ldap_bindpw = "secret";
$ldap_base = "dc=example,dc=com";
$ldap_user_base = "ou=users,".$ldap_base;
$ldap_user_filter = "(objectClass=inetOrgPerson)";
$ldap_login_attribute = "uid";
$ldap_login_filter = "(&$ldap_user_filter($ldap_login_attribute={login}))";
#$ldap_user_regex = "/,ou=users,/i";
$ldap_scope = "sub"; # possible values: sub, one, base
$ldap_group_base = "ou=groups,".$ldap_base;
$ldap_group_filter = "(|(objectClass=groupOfNames)(objectClass=groupOfUniqueNames))";
$ldap_size_limit = 100;
#$ldap_network_timeout = 10;

# How display attributes
$attributes_map = array(
    'businesscategory' => array( 'attribute' => 'businesscategory', 'faclass' => 'briefcase', 'type' => 'text' ),
    'carlicense' => array( 'attribute' => 'carlicense', 'faclass' => 'car', 'type' => 'text' ),
    'created' => array( 'attribute' => 'createtimestamp', 'faclass' => 'clock-o', 'type' => 'date' ),
    'description' => array( 'attribute' => 'description', 'faclass' => 'info-circle', 'type' => 'text' ),
    'displayname' => array( 'attribute' => 'displayname', 'faclass' => 'user-circle', 'type' => 'text' ),
    'employeenumber' => array( 'attribute' => 'employeenumber', 'faclass' => 'hashtag', 'type' => 'text' ),
    'employeetype' => array( 'attribute' => 'employeetype', 'faclass' => 'id-badge', 'type' => 'text' ),
    'fax' => array( 'attribute' => 'facsimiletelephonenumber', 'faclass' => 'fax', 'type' => 'tel' ),
    'firstname' => array( 'attribute' => 'givenname', 'faclass' => 'user-o', 'type' => 'text' ),
    'fullname' => array( 'attribute' => 'cn', 'faclass' => 'user-circle', 'type' => 'text' ),
    'guid' => array( 'attribute' => 'objectguid', 'faclass' => 'user', 'type' => 'guid' ),
    'identifier' => array( 'attribute' => 'uid', 'faclass' => 'user-o', 'type' => 'text' ),
    'l' => array( 'attribute' => 'l', 'faclass' => 'globe', 'type' => 'text' ),
    'lastname' => array( 'attribute' => 'sn', 'faclass' => 'user-o', 'type' => 'text' ),
    'mail' => array( 'attribute' => 'mail', 'faclass' => 'envelope-o', 'type' => 'mailto' ),
    'mailquota' => array( 'attribute' => 'gosamailquota', 'faclass' => 'pie-chart', 'type' => 'bytes' ),
    'manager' => array( 'attribute' => 'manager', 'faclass' => 'user-circle-o', 'type' => 'dn_link' ),
    'member' => array( 'attribute' => 'member', 'faclass' => 'user', 'type' => 'usergroup_dn_link' ),
    'memberof' => array( 'attribute' => 'memberof', 'faclass' => 'users', 'type' => 'group_dn_link' ),
    'mobile' => array( 'attribute' => 'mobile', 'faclass' => 'mobile', 'type' => 'tel' ),
    'modified' => array( 'attribute' => 'modifytimestamp', 'faclass' => 'clock-o', 'type' => 'date' ),
    'organization' => array( 'attribute' => 'o', 'faclass' => 'building', 'type' => 'text' ),
    'organizationalunit' => array( 'attribute' => 'ou', 'faclass' => 'building-o', 'type' => 'text' ),
    'pager' => array( 'attribute' => 'pager', 'faclass' => 'mobile', 'type' => 'tel' ),
    'phone' => array( 'attribute' => 'telephonenumber', 'faclass' => 'phone', 'type' => 'tel' ),
    'postaladdress' => array( 'attribute' => 'postaladdress', 'faclass' => 'map-marker', 'type' => 'address' ),
    'postalcode' => array( 'attribute' => 'postalcode', 'faclass' => 'globe', 'type' => 'text' ),
    'secretary' => array( 'attribute' => 'secretary', 'faclass' => 'user-circle-o', 'type' => 'dn_link' ),
    'state' => array( 'attribute' => 'st', 'faclass' => 'globe', 'type' => 'text' ),
    'street' => array( 'attribute' => 'street', 'faclass' => 'map-marker', 'type' => 'text' ),
    'title' => array( 'attribute' => 'title', 'faclass' => 'certificate', 'type' => 'text' ),
    'uniquemember' => array( 'attribute' => 'uniquemember', 'faclass' => 'user', 'type' => 'usergroup_dn_link' ),
);

$attributes_list = array();
$dn_link_label_attributes = array("cn");
#$dn_link_search_display_macro = "%fullname% (%mail%)";
$dn_link_search_min_chars = 3;
$dn_link_search_size_limit = 10;
$group_dn_link_label_attributes = array("description","cn");
$usergroup_dn_link_label_attributes = array("description","cn");

# Quick search
$use_quick_search = true;
$quick_search_attributes = array('uid', 'cn', 'mail');
$quick_search_use_substring_match = true;

# Advanced search
$use_advanced_search = true;
$advanced_search_criteria = array('firstname', 'lastname', 'mail', 'title', 'businesscategory', 'employeetype', 'created', 'modified');
$advanded_search_display_search_objects = true;

# Results display
$results_display_mode = "boxes";  // boxes or table
$search_result_items = array('mail', 'phone', 'mobile');
$search_result_group_items = array('fullname','description');
$search_result_title = "fullname";
$search_result_sortby = "lastname";
$search_result_linkto = array("fullname");
$search_result_show_undefined = true;
$search_result_bootstrap_column_class = "col-md-4";
$search_result_truncate_value_after = 20;
$search_result_truncate_title_after = 30;

# Listing display (search results with 'table' & directory)
$use_datatables = true;
$datatables_page_length_choices = array(10, 25, 50, 100, -1);
$datatables_page_length_default = 10;
$datatables_print_all = true;
$datatables_print_page = true;
$datatables_auto_print = true;

# Full display
$display_items = array('firstname', 'lastname', 'title', 'businesscategory', 'employeenumber', 'employeetype', 'mail', 'mailquota', 'phone', 'mobile', 'fax', 'postaladdress', 'street', 'postalcode', 'l', 'state', 'manager', 'secretary', 'organizationalunit', 'organization', 'description', 'memberof');
$display_title = "fullname";
$display_show_undefined = false;
$display_group_items = array('fullname', 'description', 'member', 'uniquemember', 'memberof');

# Gallery
$use_gallery = true;
$gallery_title = "fullname";
$gallery_sortby = "lastname";
$gallery_bootstrap_column_class = "col-xs-6 col-sm-4 col-md-3";
$gallery_truncate_title_after = 25;
#$gallery_user_filter = "(&".$ldap_user_filter."(jpegPhoto=*))";

# Directory
$use_directory = true;
$directory_items = array('firstname', 'lastname', 'mail', 'organization');
$directory_group_items = array('fullname', 'description');
$directory_linkto = array('firstname', 'lastname');
$directory_group_linkto = array('fullname');
$directory_sortby = "lastname";
$directory_group_sortby = "fullname";
$directory_show_undefined = false;
$directory_truncate_value_after = 30;
$directory_display_search_objects = true;

# Map
$use_map = false;
#$map_user_filter = "(&".$ldap_user_filter."(jpegPhoto=*))";
$map_tileserver = 'https://tile.openstreetmap.org/{z}/{x}/{y}.png';
$map_attribution = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';
$map_fullname_items = array('firstname', 'lastname');
# Additional items to show below name in map popup
$map_additional_items = array('title');
# Address display format is an array, one item per line. If a line is an array, it will include multiple items separated by a space.
$map_address_format = array('street', array('l', 'postalcode'), 'state');
$map_display_photos_as_marker = true;
# Geocoding API. Use %s as the address to geocode. API should return a json list of {lat, lon} objects
$map_geocode_url = 'https://nominatim.openstreetmap.org/search?format=json&limit=1&q=%s';
# Place someone with no adddress info in ldap entry to a default location
$map_no_location_show_on_default = false;
$map_default_location_lat = 48.6882405;
$map_default_location_long = -32.6412127;

# Update infos (requires authentication)
$use_updateinfos = false;
$update_items = array('firstname', 'lastname', 'mail', 'phone', 'mobile');
$update_items_macros = array('fullname' => '%firstname% %lastname%');

# HTTP
$http_url = "http://localhost/wp";

# CSV
$use_csv = true;
$csv_filename = "white_pages_export_" . date("Y-m-d") . ".csv";
$csv_items = array('firstname', 'lastname', 'mail','organization');

# vCard
$use_vcard = true;
$vcard_file_extension = "vcf";
$vcard_file_identifier = "identifier";
$vcard_version = "4.0";
$vcard_user_map = array('FN' => 'fullname', 'N' => 'fullname', 'EMAIL' => 'mail', 'CATEGORIES' => 'businesscategory', 'ORG' => 'organization', 'ROLE' => 'employeetype', 'TEL;TYPE=work,voice;VALUE=uri:tel' => 'phone', 'TEL;TYPE=cell,voice;VALUE=uri:tel' => 'mobile', 'UID' => 'identifier');
$vcard_group_map = array('FN' => 'fullname', 'N' => 'fullname', 'EMAIL' => 'mail', 'CATEGORIES' => 'businesscategory', 'MEMBER' => 'member', 'ORG' => 'organization', 'ROLE' => 'employeetype', 'TEL;TYPE=work,voice;VALUE=uri:tel' => 'phone', 'TEL;TYPE=cell,voice;VALUE=uri:tel' => 'mobile', 'UID' => 'identifier');

# Photo
$use_gravatar = false;
$default_photo = "images/240px-PICA.jpg";
$photo_ldap_attribute = "jpegPhoto";
$photo_fixed_width = 240;
$photo_fixed_height = 240;
#$photo_local_directory = "../photos/";
#$photo_local_ldap_attribute = "uid";
#$photo_local_extension = ".jpg";

# Language
$lang ="en";
$allowed_lang = array();
$date_specifiers = "%Y-%m-%d %H:%M:%S (%Z)";

# Graphics
$logo = "images/ltb-logo.png";
$background_image = "images/unsplash-space.jpeg";
$favicon = "images/favicon.ico";
$hover_effect = "grow";
$custom_css = "";
$display_footer = true;
$default_page = "welcome";
#$logout_link = "http://auth.example.com/logout";
$display_myaccount_menu = false;

# Customized template directory: to override some templates files
$custom_tpl_dir = "";

# Debug mode
$debug = false;

# Cache directory
#$smarty_compile_dir = "/var/cache/white-pages/templates_c";
#$smarty_cache_dir = "/var/cache/white-pages/cache";

# Smarty debug mode - will popup debug information on web interface
$smarty_debug = false;

# The name of an HTTP Header that may hold a reference to an extra config file to include.
#$header_name_extra_config="WP-Extra-Config";

# Allow to override current settings with local configuration
if (file_exists (dirname (__FILE__) . '/config.inc.local.php')) {
    include dirname (__FILE__) . '/config.inc.local.php';
}

# Smarty
if (!defined("SMARTY")) {
    define("SMARTY", "/usr/share/php/smarty3/Smarty.class.php");
}

# Allow to override current settings with an extra configuration file, whose reference is passed in HTTP_HEADER $header_name_extra_config
if (isset($header_name_extra_config)) {
    $extraConfigKey = "HTTP_".strtoupper(str_replace('-','_',$header_name_extra_config));
    if (array_key_exists($extraConfigKey, $_SERVER)) {
        $extraConfig = preg_replace("/[^a-zA-Z0-9-_]+/", "", filter_var($_SERVER[$extraConfigKey], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH));
        if (strlen($extraConfig) > 0 && file_exists (__DIR__ . "/config.inc.".$extraConfig.".php")) {
            require  __DIR__ . "/config.inc.".$extraConfig.".php";
        }
    }
}

?>
