<?php

    function login()
    {
        // Diese Globalen Variablen brauche ich
        global $_SERVER,$_SESSION, $_GET, $_POST, $session;

        // Anfrage und Überprüfung der Daten
        if (($_GET["module"] == "logout") && isset($_SESSION['ScreenName']))
        { 
            unset ($_SESSION['ScreenName']);
        }

    // Überprüfen von Benutzername und Passwort (solange, bis sie stimmen)
        while (!isset($_SESSION['ScreenName']))
        {
            if ($session->userDatabase->login($_POST['username'], $_POST['password']))
            {
            // Setzen des ScreenNames - damit ist man eingeloggt
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
    
    
    if (!login()) die('
    <h1>Zugriff verweigert</h1>
    <p>Bitte loggen Sie sich erst ein. Wenn Sie hier nur irrtümlich sind, dann benutzen Sie
    bitte den <a href="/" title="Zur Hauptseite">Vordereingang</a>.</p>
    ');



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
    $session->smarty->display("admin.tpl");
       
?>
