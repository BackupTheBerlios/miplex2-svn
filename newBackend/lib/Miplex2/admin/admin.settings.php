<?php

    $part = Nz(&$_GET['part']);
    $action = Nz(&$_GET['action']);
    $value = Nz(&$_GET['value']);


    switch ($part) {
        case 'settings':
            require_once($session->config->miplexDir."admin/admin.settings.base.php");
        break;
    
        case 'user':
            require_once($session->config->miplexDir."admin/admin.user.php");
        break;
            
        default:
            $session->smarty->assign("content", "admin/settings/start.tpl");
        break;
    }
    
    $session->smarty->assign("i18n", $session->i18n);
    $session->smarty->assign("content_tpl", "admin/settings/main.tpl");

?>