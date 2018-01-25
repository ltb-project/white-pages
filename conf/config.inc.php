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
# Configuration
#==============================================================================
# LDAP
$ldap_url = "ldap://localhost";
$ldap_starttls = false;
$ldap_binddn = "cn=manager,dc=example,dc=com";
$ldap_bindpw = "secret";
$ldap_base = "dc=example,dc=com";
$ldap_user_base = "ou=users,".$ldap_base;
$ldap_user_filter = "(objectClass=inetOrgPerson)";
$ldap_size_limit = 100;

# How display attributes
$attributes_map = array(
    'businesscategory' => array( 'attribute' => 'businesscategory', 'faclass' => 'briefcase', 'type' => 'text' ),
    'carlicense' => array( 'attribute' => 'carlicense', 'faclass' => 'car', 'type' => 'text' ),
    'created' => array( 'attribute' => 'createtimestamp', 'faclass' => 'clock-o', 'type' => 'date' ),
    'description' => array( 'attribute' => 'description', 'faclass' => 'info-circle', 'type' => 'text' ),
    'displayname' => array( 'attribute' => 'displayname', 'faclass' => 'user-circle', 'type' => 'text' ),
    'employeenumber' => array( 'attribute' => 'employeenumber', 'faclass' => 'hashtag', 'type' => 'text' ),
    'employeetype' => array( 'attribute' => 'employeetype', 'faclass' => 'id-badge', 'type' => 'text' ),
    'fax' => array( 'attribute' => 'facsimiletelephonenumber', 'faclass' => 'fax', 'type' => 'text' ),
    'firstname' => array( 'attribute' => 'givenname', 'faclass' => 'user-o', 'type' => 'text' ),
    'fullname' => array( 'attribute' => 'cn', 'faclass' => 'user-circle', 'type' => 'text' ),
    'identifier' => array( 'attribute' => 'uid', 'faclass' => 'user-o', 'type' => 'text' ),
    'l' => array( 'attribute' => 'l', 'faclass' => 'globe', 'type' => 'text' ),
    'lastname' => array( 'attribute' => 'sn', 'faclass' => 'user-o', 'type' => 'text' ),
    'mail' => array( 'attribute' => 'mail', 'faclass' => 'envelope-o', 'type' => 'mailto' ),
    'manager' => array( 'attribute' => 'manager', 'faclass' => 'user-circle-o', 'type' => 'dn_link' ),
    'mobile' => array( 'attribute' => 'mobile', 'faclass' => 'mobile', 'type' => 'text' ),
    'modified' => array( 'attribute' => 'modifytimestamp', 'faclass' => 'clock-o', 'type' => 'date' ),
    'organization' => array( 'attribute' => 'o', 'faclass' => 'building', 'type' => 'text' ),
    'organizationalunit' => array( 'attribute' => 'ou', 'faclass' => 'building-o', 'type' => 'text' ),
    'pager' => array( 'attribute' => 'pager', 'faclass' => 'mobile', 'type' => 'text' ),
    'phone' => array( 'attribute' => 'telephonenumber', 'faclass' => 'phone', 'type' => 'text' ),
    'postaladdress' => array( 'attribute' => 'postaladdress', 'faclass' => 'map-marker', 'type' => 'text' ),
    'postalcode' => array( 'attribute' => 'postalcode', 'faclass' => 'globe', 'type' => 'text' ),
    'secretary' => array( 'attribute' => 'secretary', 'faclass' => 'user-circle-o', 'type' => 'dn_link' ),
    'state' => array( 'attribute' => 'st', 'faclass' => 'globe', 'type' => 'text' ),
    'street' => array( 'attribute' => 'street', 'faclass' => 'map-marker', 'type' => 'text' ),
    'title' => array( 'attribute' => 'title', 'faclass' => 'certificate', 'type' => 'text' ),
);

# Quick search results
$use_quick_search = true;
$quick_search_attributes = array('uid', 'cn', 'mail');
$search_result_items = array('mail', 'phone', 'mobile');
$search_result_title = "fullname";
$search_result_sortby = "lastname";
$search_result_show_undefined = true;
$search_result_bootstrap_column_class = "col-md-4";
$search_result_truncate_value_after = "20";

# Advanced search
$use_advanced_search = true;
$advanced_search_criteria = array('firstname', 'lastname', 'mail', 'title', 'businesscategory', 'employeetype', 'created', 'modified');

# Results display
$results_display_mode = "boxes";

# Full dislpay
$display_items = array('firstname', 'lastname', 'title', 'businesscategory', 'employeenumber', 'employeetype', 'mail', 'phone', 'mobile', 'fax', 'postaladdress', 'street', 'postalcode', 'l', 'state', 'manager', 'secretary', 'organizationalunit', 'organization', 'description' );
$display_title = "fullname";

# Gallery
$use_gallery = true;
$gallery_title = "fullname";
$gallery_sortby = "lastname";
$gallery_bootstrap_column_class = "col-xs-6 col-sm-4 col-md-3";

# CSV
$use_csv = true;
$csv_filename = "white_pages_export_" . date("Y-m-d") . ".csv";
$csv_items = array('firstname', 'lastname', 'mail','organization');

# vCard
$use_vcard = true;
$vcard_file_extension = "vcf";
$vcard_file_identifier = "identifier";
$vcard_version = "4.0";
$vcard_map = array('FN' => 'fullname', 'N' => 'fullname', 'EMAIL' => 'mail', 'CATEGORIES' => 'businesscategory', 'ORG' => 'organization', 'ROLE' => 'employeetype', 'TEL;TYPE=work,voice;VALUE=uri:tel' => 'phone', 'TEL;TYPE=cell,voice;VALUE=uri:tel' => 'mobile', 'UID' => 'identifier');

# Language
$lang ="en";
$date_specifiers = "%Y-%m-%d %H:%M:%S (%Z)";

# Graphics
$logo = "images/ltb-logo.png";
$background_image = "images/unsplash-space.jpeg";
$default_photo = "images/240px-PICA.jpg";
$hover_effect = "grow";
$custom_css = "";

# Debug mode
$debug = false;

# Smarty
define("SMARTY", "/usr/share/php/smarty3/Smarty.class.php");

?>
