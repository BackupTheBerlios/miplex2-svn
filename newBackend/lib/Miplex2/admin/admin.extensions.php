<?php

//Include Extension Manager
require_once($session->config->miplexDir."ExtensionManager.class.php");
$extManager = new ExtensionManager($session->config);

//get all Extension
$exts = $extManager->getAllAvailableExtensions();

$menu = "<ul id=\"extension\">";

foreach ($exts as $ext) {
    
    $menu.="<li><a href='?module=ext&amp;id=".$ext['basename']."' title='".$ext['basename']."' class='extLink'>".$ext['extName']."</a></li>";
    
}

$menu .= "</ul>";


//Handling Backendmenu of extension

if (!empty($_GET['id']))
{
    $obj = &$extManager->loadExtension($_GET['id']);
    $obj->baseSmarty = &$session->smarty;

    $content = $obj->getBackend();
    
    if (!$content)
        $session->smarty->assign("mode", "NoBackend");
    else
    {
        $session->smarty->assign("content", $content);
        $session->smarty->assign("mode", "Backend");
    }
    
} else 
{
    $session->smarty->assign("mode", "NoChoice");
}

//

$session->smarty->assign("menu", $menu);
$session->smarty->assign("i18n", $session->i18n);
$session->smarty->assign("content_tpl", "admin/extensions/main.tpl");
?>