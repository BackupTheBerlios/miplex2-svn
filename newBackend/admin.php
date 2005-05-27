<?php

    function getErrorHandler($errno, $errmsg, $filename, $linenum) {
        if ($errno & error_reporting())
        {
            $error = "Zeit: " .date("Y-m-d H:i:s"). "\n";
            $error .= "Meldung: " .$errmsg. "\n";
            $error .= "Datei: " .$filename. "\n";
            $error .= "Zeile: " .$linenum;
            print_r(array("error@schmidtwisser.de", "Fehler auf wbg-dahmeland.de", $error, "From: Entwickler"));
         }
    } 

//    error_reporting (E_ALL);
//    set_error_handler("getErrorHandler");

    function Nz($arg0, $arg1 = "")
    {
        return isset($arg0) ? $arg0 : $arg1;
    }


    // Setting this var to TRUE will trigger clearing the Smarty Cache
    $clear_cache = false;

    function login()
    {
        // Diese Globalen Variablen brauche ich
        global $ScreenName, $session;

        // Anfrage und Überprüfung der Daten
        if (isset($_GET["module"]) && ($_GET["module"] == "logout") && isset($_SESSION['ScreenName']))
        { 
            unset ($_SESSION['ScreenName']);
        }

    // Überprüfen von Benutzername und Passwort (solange, bis sie stimmen)
        while (!isset($_SESSION['ScreenName']))
        {
            if (isset($_POST['username']) && isset($_POST['password']) 
             && $session->userDatabase->login($_POST['username'], $_POST['password']))
            {
            // Setzen des ScreenNames - damit ist man eingeloggt
                $ScreenName = $_POST['username'];
                $_SESSION['ScreenName'] = $_POST['username'];
            }
            else
            {
                // Login-Formular ausgeben
                $session->smarty->assign("error", isset($_POST['username']));
                $session->smarty->assign("i18n", $session->i18n);
                $session->smarty->display('admin/login.tpl');
                die ();
            }
        }
        return true;
    }

    
    session_start();
    require_once("lib/Miplex2/Session.class.php");
    
    $session = new Session("config/config.ser", "backend");
    $session->loadUserDatabase();
    
    $session->smarty->assign("miplexVersion", file_get_contents("VERSION"));
    
    // Only registered users may pass this line
    login();
    // Restricted Area !!!

    if (!isset ($_GET['module'])) $_GET['module'] = 'start';
    switch ($_GET['module'])
    {
        case 'page':
            $session->smarty->assign("pageIsActive", "class=\"active\"");
            require_once("lib/Miplex2/admin/admin.page.php");
            break;
        
        case 'ext':
            $session->smarty->assign("extIsActive", "class=\"active\"");
            require_once("lib/Miplex2/admin/admin.extensions.php");
            break; 
        
        case 'settings':
            $session->smarty->assign("settingsIsActive", "class=\"active\"");
            require_once("lib/Miplex2/admin/admin.settings.php");
            break;
            
        default:
            $session->smarty->assign("startIsActive", "class=\"active\"");
            require_once("lib/Miplex2/admin/admin.start.php");
            break;
            
    }

    if ($clear_cache)
        $session->smarty->clear_all_cache();
        
    $session->smarty->assign("i18n", $session->i18n);
    $session->smarty->assign("config", $session->config);   
    $session->smarty->display("admin/admin.tpl");
       
?>
