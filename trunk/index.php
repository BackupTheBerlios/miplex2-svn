<?php
/**
* Hier beginnt Miplex2
* Wenn diese Datei aufgerufen wird, dann ist
* der aktuelle User garantiert nur ein Besucher, und es
* müssen keine Backenddaten geladen werden.
*/

//Starten der Session
session_start();
//Start Output Buffering
ob_start();

    require_once("lib/Miplex2/Session.class.php");
    
    
    //If new to this page start new session
    //if (!session_is_registered("session"))
    //{
        
        $session = new Session("config/config.ser");
    
    //}
    
   $page = &$session->getActPage();
   
   //404 Handling
   if ($page == false)
   {
        header("Location: ".$session->config->docroot.$session->config->baseName."/404.html");
   }
   else 
        $session->smarty->assign("pageObject", $page);      
   
   
   $session->smarty->assign("config",$session->config);
   $session->smarty->assign("site", $session->site);
   $session->smarty->display($session->config->theme);
   
    
ob_end_flush();


?>