<?php
    $part = $_GET['part'];
    $action = $_GET['action'];
    $value = $_GET['value'];

        
    $session->smarty->assign("i18n", $session->i18n);
    $session->smarty->assign("content", "admin/user/main.tpl");


    //fetch all POST Actions
    if ($_POST['save'])
    {
        
        switch ($_POST['type']) {

            case 'addUser':
                //Procedure to add User to System 
                $user = $_POST['user'];
                if (!empty($user['attributes']['username']) && !empty($user['attributes']['password']))
                {
                   $done = $session->userDatabase->addUser($user['attributes'], array());
                   
                } else {
                    echo "Falsch!!"; 
                }
                break;
        }
    }
    
    //now proceed...
    switch ($action) {
    	case "add":
    	
            //Load Template to add User
    	    $session->smarty->assign("user_content", "admin/user/add.tpl");	
    	
 	    break;
    
    	case "del":
    	    break;
    	   	
    	case "edit":
    	    break;
    	    
    	case "list":
            //Load Template to list all Users
            $user = $session->userDatabase->user;
            $session->smarty->assign("users", $user);
            $session->smarty->assign("user_content", "admin/user/list.tpl");
    	    break;

        default:
            $session->smarty->assign("user_content", "admin/user/default.tpl");
    	
    }
    
?>
