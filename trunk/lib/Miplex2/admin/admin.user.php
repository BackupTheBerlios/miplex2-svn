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
                   $done = $session->userDatabase->addUser($user['attributes'], $_POST['group']);
                   
                } else {
                    echo "Falsch!!"; 
                }
                break;
                
            case 'editUser':
            
                $user = $_POST['user'];
                $group = "Admin";
                
                $done = $session->userDatabase->saveUser("username", $_POST['key'], $user);
                
            
                break;
            case "addGroup":
                $group = $_POST['group'];
                $done = $session->userDatabase->addGroup($group);
                break;
        }
    }
    
    //now proceed...
    switch ($action) {
    	case "add":
    	
            //Load Template to add User
            $session->smarty->assign("groups", $session->userDatabase->getGroups());
            $session->smarty->assign("user_content", "admin/user/add.tpl");	
    	    
    	
 	    break;
    
    	case "del":
    	    break;
    	   	
    	case "edit":
    	
    	    $username = $_GET['value'];
    	    $user = $session->userDatabase->getUser("username", $username);
    	    
    	    $session->smarty->assign("groups", $session->userDatabase->getGroups());
    	    $session->smarty->assign("user_item", $user);
    	    $session->smarty->assign("key", $username);
    	    $session->smarty->assign("user_content", "admin/user/edit.tpl");
    	
    	    break;
    	    
    	case "list":
            //Load Template to list all Users
            $user = $session->userDatabase->user;
            $session->smarty->assign("users", $user);
            $session->smarty->assign("user_content", "admin/user/list.tpl");
    	    break;

    	case "gadd":
    	    
    	    $session->smarty->assign("allRights", array_keys($session->userDatabase->rights));
    	    $session->smarty->assign("user_content", "admin/user/gadd.tpl");
    	    break;    
    	    
    	case "glist":
    	    $session->smarty->assign("groups", $session->userDatabase->groups);
    	    $session->smarty->assign("user_content", "admin/user/glist.tpl");
    	    break;
    	    
    	case "gedit":
    	    
    	    $session->smarty->assign("allRights", array_keys($session->userDatabase->rights));
    	    
    	    $group = $session->userDatabase->getGroup("name",$_GET['value']);
    	    $groupRights = $session->userDatabase->getGroupRights($_GET['value']);
    	    $session->smarty->assign("groupRights", $groupRights);
    	    $session->smarty->assign("egroup", $group);
    	    $session->smarty->assign("user_content", "admin/user/gedit.tpl");
    	    break;
    	    
        default:
            $session->smarty->assign("user_content", "admin/user/default.tpl");
    	
    }
    
?>
