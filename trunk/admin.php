<?php

    session_start();
    ob_start();

    require_once("lib/Miplex2/Session.class.php");
    
    $session = new Session("config/config.ser", "backend");
    
    $session->loadUserDatabase();

    
    if (!is_string($_GET['module']))
    {
        $_GET['module'] = "start";
    }
    
    switch ($_GET['module'])
    {
     
        case 'page':
        
            require_once($session->config->miplexDir."admin/admin.page.php");
            break;
        
        
        case 'ext':
            require_once($session->config->miplexDir."admin/admin.extensions.php");
            break; 
            
        
        case 'settings':
            require_once($session->config->miplexDir."admin/admin.settings.php");
            break;
        
        case 'start':
            break;
        
        
    }
    
    
    $session->smarty->display("admin.tpl");
    
    
    ob_end_flush();

?>
