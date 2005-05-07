<?php

switch ($action) {
    
    //Create new content element
    case 'new':
    
        $position = explode(",", $session->config->position);
        foreach ($position as $key => $val) {
            $position[$key] = trim($val);
        }
        
        $session->smarty->assign("position", $position);
        $session->smarty->assign("content", "admin/page/contentElementDetail.tpl");
        $session->smarty->assign("value", $value);
        $session->smarty->assign("type", "new");
        
        $session->smarty->assign("hta", $session->config->useHtmlArea);
        break;
        
    //Edit content element
    case 'edit':
    
        $position = explode(",", $session->config->position);
        foreach ($position as $key => $val) {
            $position[$key] = trim($val);
        }
        
        $session->smarty->assign("position", $position);
        $session->smarty->assign("content", "admin/page/contentElementDetail.tpl");
        $session->smarty->assign("page", $page);
        $session->smarty->assign("value", $value);
        $session->smarty->assign("type", "edit");
        
        $session->smarty->assign("hta", $session->config->useHtmlArea);
        break;
    //Move Content element    
    case 'move':
        break;
        
    //delete content element
    case 'delete':
        
        $session->smarty->assign("content", "admin/page/deleteCE.tpl");
        $session->smarty->assign("page", $page);
        $session->smarty->assign("value", $value);
        
        break;
        
    case 'save':
    
        //Check if there is some work to do...
        if (isset($_POST['saveCE']))
        {
            
            switch ($_POST['type']) {
                //Edit CE ->save changes
                case "edit":
                    $context = $session->mdb->getContextFromPath($_POST['path'])."/content[".($_POST['ceKey'])."]";
                    $data = stripslashes($_POST['data']);
                    $attributes=$_POST['attributes'];
                    $attributes['lastChanged'] = date("d.m.y.");
                    
                    $session->mdb->editContentElement($context, $data, $attributes);
                    $session->saveAndResetSite();
                    
                    break;
                    
                case 'new':
                
                    $context = $session->mdb->getContextFromPath($_POST['path']);
                    $data = stripslashes($_POST['data']);
                    
                    $attributes=$_POST['attributes'];
                    $attributes['lastChanged'] = date("d.m.y.");
                    
                    $session->mdb->addContent($context, $_POST['ceKey'], $data, $attributes);
                    $session->saveAndResetSite();
                
                    break;
                    
                    
                case 'delete':
                
                    $context = $session->mdb->getContextFromPath($_POST['path'])."/content[".$_POST['ceKey']."]";
                    $del = $session->mdb->removeChild($context);
                    $session->saveAndResetSite();
                    
                    if ($del == false)
                    {
                        $session->smarty->assign("error", "Das Element konnte nicht gelöscht werden");
                    }
                
                    break;
                
            }
            
            $page = $session->getRequestedPage($tmpUri);
            $session->smarty->assign("page", $page);
            $session->smarty->assign("content", "admin/page/pageMain.tpl");
        }
        else
        {
            $page = $session->getRequestedPage($tmpUri);
            $session->smarty->assign("page", $page);
            $session->smarty->assign("content", "admin/page/pageMain.tpl");
        }
        
        break;
        
        case 'up':
        
            $ctx = $session->mdb->getContextFromPath($path)."/content[".$value."]";
            if ($session->mdb->moveContent($ctx, 1))
            {
                $session->saveAndResetSite();
            }
            
            $page = $session->getRequestedPage($tmpUri);
            $session->smarty->assign("page", $page);
            $session->smarty->assign("content", "admin/page/pageMain.tpl");
        
            break;
            
        case 'down':
        
            $ctx = $session->mdb->getContextFromPath($path)."/content[".$value."]";
            if ($session->mdb->moveContent($ctx, -1))
            {
                $session->saveAndResetSite();
            }
            
            $page = $session->getRequestedPage($tmpUri);
            $session->smarty->assign("page", $page);
            $session->smarty->assign("content", "admin/page/pageMain.tpl");
            
            break;
}
            
?>