<?php
    $part = $_GET['part'];
    $action = $_GET['action'];
    $value = $_GET['value'];

        
    $session->smarty->assign("i18n", $session->i18n);
    $session->smarty->assign("content", "admin/user/main.tpl");
    
    switch ($action) {
    	case "add":
    	
    	    $session->smarty->assign("user_content", "admin/user/add.tpl");	
    	
    		break;
    
    	case "del":
    	   	break;
    	   	
    	case "edit":
    	    break;
    	    
    	case "list":
    	    break;
    	
    }
    
?>