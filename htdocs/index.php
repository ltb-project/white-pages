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

# Assign messages
foreach ($messages as $key => $message) {
    $smarty->assign('msg_'.$key,$message);
}

#==============================================================================
# Route to page
#==============================================================================
$page = "welcome";
if (isset($_GET["page"]) and $_GET["page"]) { $page = $_GET["page"]; }
if ( file_exists($page.".php") ) { require_once($page.".php"); }

# Display
$smarty->assign('page',$page);
$smarty->display('index.tpl');

?>
