<?php

    //switch page action
    switch ($action) {
        case 'inner':
               //insert new page after this page
                $session->smarty->assign("content", "admin/page/sectionDetail.tpl");
                $session->smarty->assign("type", "inner");         
            break;
    
        case 'after':
        
               //insert new page after this page
               $session->smarty->assign("content", "admin/page/sectionDetail.tpl");
               $session->smarty->assign("type", "after");
            break;
            
        
        case 'save':
        
           //Handler all save actions on page
           if (isset($_POST['savePage']))
           {
               
               switch ($_POST['type']) {

                   //Insert Page after
                   case 'after':
                    
                       $attributes = $_POST['attributes'];
                       $ctx = $session->mdb->getContextFromPath($path);
                       
                       $newPath = $session->mdb->addSection($ctx, "after", $attributes);
                       $session->saveAndResetSite();

                       $newPath = $_GET['path']."/".$_POST['attributes']['alias'];
                       break;
                       
                   //Insert inner page
                   case 'inner':
                   
                       $attributes = $_POST['attributes'];
                       $ctx = $session->mdb->getContextFromPath($path);
                       $newPath = $session->mdb->addSection($ctx, "inner", $attributes);
                       $session->saveAndResetSite();

                       $newPath = $_GET['path']."/".$_POST['attributes']['alias'];
                       break;
                  
                  //delete page     
                  case 'delete':
                   
                    $ctx = $session->mdb->getContextFromPath($_POST['path']);
                    $del = $session->mdb->removeChild($ctx);
                    if ($del == true)
                    {
                        $session->saveAndResetSite();
                        //Get parent site
                        $path = explode("/",$_POST['path']);
                        array_pop($path);
                        $newPath = join("/", $path);
                    }
                    break;
                   
                  //Edit page attributes    
                  case 'edit':
                       
                       $ctx = $session->mdb->getContextFromPath($_POST['path']);
                       $edit = $session->mdb->editSectionAttributes($ctx, $_POST['attributes']);
                       
                       if ($edit == true)
                           $session->saveAndResetSite();
                           
                       $newPath = $path;
                                               
                       break;
               
               }
           } 
           elseif (isset($_POST['cancel']))
           {
                $newPath = $_GET['path'];
           }

           
           //Display page with changed attributes and pages
           $pageList->site =& $session->site;
           $tmpUri = explode("/", $newPath);
           $page = $session->getRequestedPage($tmpUri);
           $session->smarty->assign("page", $page);
           $session->smarty->assign("content", "admin/page/pageMain.tpl");
           
           break;
           
        case 'delete':
        
           $session->smarty->assign("content", "admin/page/deleteSection.tpl");
           break;
           
           
        case 'edit':
                //Edit Page
                $session->smarty->assign("page", $page);
                $session->smarty->assign("content", "admin/page/sectionDetail.tpl");
                $session->smarty->assign("type", "edit");
            break;
            
            
        case 'up':
        
            $ctx = $session->mdb->getContextFromPath($path);
            if ($session->mdb->moveContent($ctx, 1))
            {
                $session->saveAndResetSite();
            }
            
            $pageList->site =& $session->site;
            $page = $session->getRequestedPage($tmpUri);
            $session->smarty->assign("page", $page);
            $session->smarty->assign("content", "admin/page/pageMain.tpl");
        
            break;
            
        case 'down':
        
            $ctx = $session->mdb->getContextFromPath($path);
            if ($session->mdb->moveContent($ctx, -1))
            {
                $session->saveAndResetSite();
            }
            
            $pageList->site =& $session->site;
            $page = $session->getRequestedPage($tmpUri);
            $session->smarty->assign("page", $page);
            $session->smarty->assign("content", "admin/page/pageMain.tpl");
            
            break;
        
           
    }
    
    

?>