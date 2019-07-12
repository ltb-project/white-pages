<?php

#==============================================================================
# Version
#==============================================================================
$version = 0.3;

#==============================================================================
# Configuration
#==============================================================================
require_once("../conf/config.inc.php");

#==============================================================================
# Language
#==============================================================================
require_once("../lib/detectbrowserlanguage.php");
# Available languages
$languages = array();
if ($handle = opendir('../lang')) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
             array_push($languages, str_replace(".inc.php", "", $entry));
        }
    }
    closedir($handle);
}
$lang = detectLanguage($lang, $languages);
require_once("../lang/$lang.inc.php");
if (file_exists("../conf/$lang.inc.php")) {
    require_once("../conf/$lang.inc.php");
}

#==============================================================================
# Smarty
#==============================================================================
require_once(SMARTY);

$smarty = new Smarty();
$smarty->escape_html = true;
$smarty->setTemplateDir('../templates/');
$smarty->setCompileDir('../templates_c/');
$smarty->setCacheDir('../cache/');
$smarty->debugging = $debug;

# Set debug for LDAP
if ($debug) {
    ldap_set_option(NULL, LDAP_OPT_DEBUG_LEVEL, 7);
}

# Default configuration values
if (!isset($results_display_mode)) $results_display_mode = "boxes";
if (!isset($use_datatables)) $use_datatables = true;

# Assign configuration variables
$smarty->assign('ldap_params',array('ldap_url' => $ldap_url, 'ldap_starttls' => $ldap_starttls, 'ldap_binddn' => $ldap_binddn, 'ldap_bindpw' => $ldap_bindpw, 'ldap_user_base' => $ldap_user_base, 'ldap_user_filter' => $ldap_user_filter, 'ldap_group_filter' => $ldap_group_filter));
$smarty->assign('logo',$logo);
$smarty->assign('background_image',$background_image);
$smarty->assign('hover_effect',$hover_effect);
$smarty->assign('custom_css',$custom_css);
$smarty->assign('attributes_map',$attributes_map);
$smarty->assign('date_specifiers',$date_specifiers);
$smarty->assign('use_quick_search',$use_quick_search);
$smarty->assign('use_advanced_search',$use_advanced_search);
$smarty->assign('use_gallery',$use_gallery);
$smarty->assign('use_directory',$use_directory);
$smarty->assign('use_csv',$use_csv);
$smarty->assign('use_vcard',$use_vcard);
$smarty->assign('use_datatables', $use_datatables);
if ($use_datatables) {
    if (is_array($datatables_page_length_choices)) $datatables_page_length_choices = implode(', ', $datatables_page_length_choices);
    $smarty->assign('datatables_page_length_choices', $datatables_page_length_choices);
    $smarty->assign('datatables_page_length_default', $datatables_page_length_default);
    $smarty->assign('datatables_auto_print', $datatables_auto_print);
}
$smarty->assign('version',$version);
$smarty->assign('display_footer',$display_footer);

# Assign messages
$smarty->assign('lang',$lang);
foreach ($messages as $key => $message) {
    $smarty->assign('msg_'.$key,$message);
}

# Other assignations
$search = "";
if (isset($_REQUEST["search"]) and $_REQUEST["search"]) { $search = htmlentities($_REQUEST["search"]); }
$smarty->assign('search',$search);

# Register plugins
require_once("../lib/smarty.inc.php");
$smarty->registerPlugin("function", "get_attribute", "get_attribute");
$smarty->registerPlugin("function", "convert_ldap_date", "convert_ldap_date");
$smarty->registerPlugin("function", "convert_guid_value", "convert_guid_value");

#==============================================================================
# Route to page
#==============================================================================
$result = "";
$page = "welcome";
if (isset($_GET["page"]) and $_GET["page"]) { $page = $_GET["page"]; }
if ( $page === "search" and !$use_quick_search ) { $page = "welcome"; }
if ( $page === "advancedsearch" and !$use_advanced_search ) { $page = "welcome"; }
if ( $page === "directory" and !$use_directory ) { $page = "welcome"; }
if ( $page === "gallery" and !$use_gallery ) { $page = "welcome"; }
if ( file_exists($page.".php") ) { require_once($page.".php"); }
$smarty->assign('page',$page);

if ($result) {
    $smarty->assign('error',$messages[$result]);
} else {
    $smarty->assign('error',"");
}

# Display
$smarty->display('index.tpl');

?>
