<?php

    require_once("lib/XPath/XPath.class.php");
    require_once("lib/Miplex2/M2UserManager.class.php");
    require_once("lib/Miplex2/BeautifyXML.class.php");
    
    
    
    $xPath = new XPath();
    $bf  = new BeautifyXML();
    
    $uManager = new M2UserManager("config/user.xml", $xPath, $bf);
    
    $user['name'] = "gregor";
    $user['mail'] = "grund@me.de";
    
    $rights['Admin']['create'] = 1;
    
    
    $uManager->addUser($user, $rights);
    
    //$uManager->addGroup("Admin");
    
    //$uManager->deleteGroup("Admin");
    
    //$uManager->addRight("read", "boolean");
    //$uManager->addRight("create", "boolean");
    
    //$uManager->deleteRight("create");
    //var_dump($uManager->checkIfRightIsUsed("create"));
    
    //var_dump($uManager->fetchGroupMembers("Admin"));
    
    //$uManager->getUser("name", "Martin");
    
    //$uManager->deleteUser("name", "Gregor");
    
    
    
    
    
    print_r($uManager->user);
    
    ?>