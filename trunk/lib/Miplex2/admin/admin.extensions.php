<?php

//Include Extension Manager
require_once($session->config->miplexDir."ExtensionManager.class.php");
$extManager = new ExtensionManager($session->config);

//get all Extension
$exts = $extManager->getAllAvailableExtensions();

$menu = "<ul class='extension'>";

foreach ($exts as $ext) {
	
    $menu.="<li><a href='?module=ext&id=".$ext['basename']."' title='".$ext['basename']."' class='extLink'>".$ext['extName']."</a></li>";
    
}

$menu .= "</ul>";


//Handling Backendmenu of extension

if (!empty($_GET['id']))
{
    $obj = &$extManager->loadExtension($_GET['id']);
    $session->smarty->assign("content", $obj->getBackend());
    
} else 
{
    $session->smarty->assign("content", "Please Select");
}

//

$session->smarty->assign("menu", $menu);
$session->smarty->assign("i18n", $session->i18n);
$session->smarty->assign("content_tpl", "admin/extensions/main.tpl");
?>