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

#==============================================================================
# Smarty
#==============================================================================
require_once(SMARTY);

$smarty = new Smarty();

$smarty->setTemplateDir('../templates/');
$smarty->setCompileDir('../templates_c/');
$smarty->setConfigDir('../configs/');
$smarty->setCacheDir('../cache/');
$smarty->debugging = $debug;

# Assign configuration variables
$smarty->assign('logo',$logo);
$smarty->assign('background_image',$background_image);
$smarty->assign('attributes_map',$attributes_map);
$smarty->assign('search_result_items',$search_result_items);
$smarty->assign('search_result_title',$search_result_title);
$smarty->assign('search_result_show_undefined',$search_result_show_undefined);
$smarty->assign('search_result_box_height',$search_result_box_height);
$smarty->assign('search_result_truncate_value_after',$search_result_truncate_value_after);
$smarty->assign('display_items',$display_items);
$smarty->assign('display_title',$display_title);
$smarty->assign('display_photo_height',$display_photo_height);

# Assign messages
$smarty->assign('lang',$lang);
foreach ($messages as $key => $message) {
    $smarty->assign('msg_'.$key,$message);
}

# Other assignations
$search = "";
if (isset($_REQUEST["search"]) and $_REQUEST["search"]) { $search = htmlentities($_REQUEST["search"]); }
$smarty->assign('search',$search);

#==============================================================================
# Route to page
#==============================================================================
$result = "";
$page = "welcome";
if (isset($_GET["page"]) and $_GET["page"]) { $page = $_GET["page"]; }
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
