<?php

    function login(){
        // Diese Globalen Variablen brauche ich
        global $_SERVER,$_SESSION, $_GET, $session;
        
        // Anfrage und Überprüfung der Daten
        if (!isset($_SERVER['PHP_AUTH_USER']) || ($_GET["module"] == "logout" && isset($_SESSION['ScreenName'])))
        { // Das erstemal auf der Seite oder auf "Logout" gedrückt
            session_unregister("ScreenName");
            Header("WWW-Authenticate: Basic realm=\"Miplex CMS Login\"");
            Header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        else
        { 
            // Überprüfen von Benutzername und Passwort (solange, bis sie stimmen)

            $bool = $session->userDatabase->login($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);           
            if (!$bool)
                return false;
            
            // Setzen des ScreenNames
            $ScreenName = $_SERVER['PHP_AUTH_USER'];
            
            if (!session_is_registered("ScreenName"))
                session_register("ScreenName");

            return true;
        }
    }

    
    session_start();
    require_once("lib/Miplex2/Session.class.php");
    
    $session = new Session("config/config.ser", "backend");
    $session->loadUserDatabase();
    
    
    if (!login()) die('
    <h1>Zugriff verweigert</h1>
    <p>Bitte loggen Sie sich erst ein. Wenn Sie hier nur irrtümlich sind, dann benutzen Sie
    bitte den <a href="/" title="Zur Hauptseite">Vordereingang</a>.</p>
    ');

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
    	
    $session->smarty->assign("config", $session->config);	
    $session->smarty->display("admin.tpl");
    
    
?>
