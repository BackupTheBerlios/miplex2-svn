<?php

    session_start();
    ob_start();

    require_once("lib/Miplex2/Session.class.php");
    
    $session = new Session("config/config.ser", "backend");
    $session->loadUserDatabase();
    
    switch ($_GET['module'])
    {
        case 'page':
//            require_once($session->config->miplexDir."admin/admin.page.php");
            require_once("lib/Miplex2/admin/admin.page.php");
            break;
        
        case 'ext':
//            require_once($session->config->miplexDir."admin/admin.extensions.php");
            require_once("lib/Miplex2/admin/admin.extensions.php");
            break; 
        
        case 'settings':
//            require_once($session->config->miplexDir."admin/admin.settings.php");
            require_once("lib/Miplex2/admin/admin.settings.php");
            break;
        
        default:
//            require_once($session->config->miplexDir."admin/admin.start.php");
            require_once("lib/Miplex2/admin/admin.start.php");
            break;
    }

    if ($clear_cache)
    	$session->smarty->clear_all_cache();
    	
    $session->smarty->display("admin.tpl");
    
    
    ob_end_flush();

?>
