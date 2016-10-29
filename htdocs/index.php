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
$smarty->assign('search_result_map',$search_result_map);
$smarty->assign('search_result_title_id',$search_result_title_id);

# Assign messages
$smarty->assign('lang',$lang);
foreach ($messages as $key => $message) {
    $smarty->assign('msg_'.$key,$message);
}

# Other assignations
$search = "";
if (isset($_POST["search"]) and $_POST["search"]) { $search = htmlentities($_POST["search"]); }
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
