<?php

    /**
    * Verfügbare Variablen:
    *
    * $session
    *
    */
    
    //Build Page List
    require_once($session->config->miplexDir."admin/admin.pageList.class.php");
    
    $pageList = new pageList($session->site, $session->config, "page");
    $pageList->collapse = 0;
   
    
    //check what action is to be done
    $part = Nz(&$_GET['part']);
    $action = Nz(&$_GET['action']);
    $value = Nz(&$_GET['value']);
    $tmpUri = explode("/", Nz(&$_GET['path']));
    $filter = Nz(&$_GET['filter'], "all");
    
    $page = $session->getRequestedPage($tmpUri);
    $path = Nz(&$_GET['path']);
    
    $session->smarty->assign("filter", $filter);
    $session->smarty->assign("path", $path);
    
    $position = explode(",", $session->config->position);
    foreach ($position as $key => $val) {
        $position[$key] = trim($val);
    }
    
    $position["all"]="all";
    
    $session->smarty->assign("position", $position);
    
    //Switch action part
    switch ($part) {
        
        //There are some page actions
        case 'page':
              require_once($session->config->miplexDir."admin/admin.page.section.php");
            break;
            
        //Action concernign content elements
        case 'ce':
                require_once($session->config->miplexDir."admin/admin.page.ce.php");        
            break;
    
        //No Action defined just display content    
        default:
        
            //Get content for right part
            if (empty($_GET['path']))
            {
                $session->smarty->assign("content", "admin/page/start.tpl");
                
            } else {
                
                //Display ContentElements
                $session->smarty->assign("page", $page);
                $session->smarty->assign("content", "admin/page/pageMain.tpl");
                
            }
        
            break;
    }
    
    
    $session->smarty->assign("i18n", $session->i18n);
    $session->smarty->assign("page_list", $pageList->getMenu());
    $session->smarty->assign("content_tpl", "admin/page/main.tpl"); 
    /**
    * Exit page View
    *
    */
    
?>