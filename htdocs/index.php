<?php

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

$smarty->setTemplateDir('../templates/');
$smarty->setCompileDir('../templates_c/');
$smarty->setCacheDir('../cache/');
$smarty->debugging = $debug;

# Default configuration values
if (!isset($results_display_mode)) { $results_display_mode = "boxes"; }

# Assign configuration variables
$smarty->assign('ldap_params',array('ldap_url' => $ldap_url, 'ldap_starttls' => $ldap_starttls, 'ldap_binddn' => $ldap_binddn, 'ldap_bindpw' => $ldap_bindpw, 'ldap_user_base' => $ldap_user_base, 'ldap_user_filter' => $ldap_user_filter));
$smarty->assign('logo',$logo);
$smarty->assign('background_image',$background_image);
$smarty->assign('hover_effect',$hover_effect);
$smarty->assign('custom_css',$custom_css);
$smarty->assign('attributes_map',$attributes_map);
$smarty->assign('use_quick_search',$use_quick_search);
$smarty->assign('search_result_items',$search_result_items);
$smarty->assign('search_result_title',$search_result_title);
$smarty->assign('search_result_show_undefined',$search_result_show_undefined);
$smarty->assign('search_result_bootstrap_column_class',$search_result_bootstrap_column_class);
$smarty->assign('search_result_truncate_value_after',$search_result_truncate_value_after);
$smarty->assign('use_advanced_search',$use_advanced_search);
$smarty->assign('advanced_search_criteria',$advanced_search_criteria);
$smarty->assign('results_display_mode',$results_display_mode);
$smarty->assign('display_items',$display_items);
$smarty->assign('display_title',$display_title);
$smarty->assign('use_directory',$use_directory);
$smarty->assign('use_gallery',$use_gallery);
$smarty->assign('gallery_title',$gallery_title);
$smarty->assign('gallery_bootstrap_column_class',$gallery_bootstrap_column_class);
$smarty->assign('date_specifiers',$date_specifiers);
$smarty->assign('use_csv',$use_csv);
$smarty->assign('use_vcard',$use_vcard);

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

#==============================================================================
# Route to page
#==============================================================================
$result = "";
$page = "welcome";
if (isset($_GET["page"]) and $_GET["page"]) { $page = $_GET["page"]; }
if ( $page === "search" and !$use_quick_search ) { $page = "welcome"; }
if ( $page === "advancedsearch" and !$use_advanced_search ) { $page = "welcome"; }
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
