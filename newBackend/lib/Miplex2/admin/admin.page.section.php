<?php

    //switch page action
    switch ($_GET['action']) {
        case 'inner':
           // insert new page after this page
            $session->smarty->assign("content", "admin/page/sectionDetail.tpl");
            $session->smarty->assign("type", "inner");         
        break;
    
        case 'after':
        
           // insert new page after this page
            $session->smarty->assign("content", "admin/page/sectionDetail.tpl");
            $session->smarty->assign("type", "after");
        break;
            
        
        case 'save':
        
           // Handle all save actions on page
            if (isset($_POST['savePage']))
            {
               // Deleting is easy
                if ($_POST['type'] == 'delete')
                {
                    $ctx = $session->mdb->getContextFromPath($_POST['path']);
                    $del = $session->mdb->removeChild($ctx);
                    if ($del == true)
                    {
                        $session->saveAndResetSite();
                        
                        //Display page with changed attributes and pages
                        $pageList->site =& $session->site;
                        $tmpUri = explode("/", $path);
                        $page = $session->getRequestedPage($tmpUri);
                        $session->smarty->assign("page", $page);
                        $session->smarty->assign("content", "admin/page/start.tpl");    
                    }
                }
                else
                {
                    $errors = array();
                
                // Check all submitted parameters first
                    $attr = $_POST['attributes'];

                    // name
                    $attr['name'] = htmlentities(stripslashes($attr['name']), ENT_QUOTES);
                    if (strlen($attr['name']) == 0)
                    {
                        array_push($errors, "nameEmpty");
                    }
                
                
                    // alias - strip all special chars - to ensure a clean url
                    $attr['alias'] = preg_replace("/[^a-z|0-9|_|-]/i", "", strtolower($attr['alias']));
                    if (strlen($attr['alias']) == 0)
                    {
                        // No Alias submitted -> take the "name" as reference
                        $attr['alias'] = preg_replace("/[^a-z|0-9|_|-]/i", "", strtolower($_POST['attributes']['name']));
                    }
                    // TODO: Check if the Alias isn't used twice

                    
                    // Description
                    $attr['desc'] = htmlentities(stripslashes($attr['desc']), ENT_QUOTES);
                    
                    // Shortcut - strip all disallowed chars
                    $attr['shortcut'] = preg_replace("/[^a-z|0-9|_|-|\/]/i", "", strtolower($attr['shortcut']));
                    if (strlen($attr['alias']) > 0)
                    {
                        // TODO: check if desired site exists
                    }
                    
                    
                    
                    // Check the Dates
                    if (strlen($attr['visibleFrom']) > 0)
                    {
                        $tmp = explode (".", $attr['visibleFrom']);
                        $tmp = @mktime (0, 0, 0, $tmp[1], $tmp[0], $tmp[2]);
                        if ($tmp > 0)
                        {
                            $attr['visibleFrom'] = strftime('%d.%m.%Y', $tmp);
                        }
                        else
                        {
                            array_push($errors, "visibleFromDoesNotMatch");
                        }
                    }

                    if (strlen($attr['visibleTill']) > 0)
                    {
                        $tmp = explode (".", $attr['visibleTill']);
                        $tmp = @mktime (0, 0, 0, $tmp[1], $tmp[0], $tmp[2]);
                        if ($tmp > 0)
                        {
                            $attr['visibleTill'] = strftime('%d.%m.%Y', $tmp);
                        }
                        else
                        {
                            array_push($errors, "visibleTillDoesNotMatch");
                        }
                    }
                    
                    
                // Now we may save them - they are okay
                    if (sizeof($errors) == 0)
                    {
                        switch ($_POST['type']) 
                        {
                            //Edit page attributes    
                            case 'edit':
                                $ctx = $session->mdb->getContextFromPath($_POST['path']);
                                $edit = $session->mdb->editSectionAttributes($ctx, $attr);

                                if ($edit == true)
                                   $session->saveAndResetSite();

                                $newPath = $path;
                            break;

                           //Insert Page after
                            case 'after':
                                $ctx = $session->mdb->getContextFromPath($_POST['path']);
                                $newPath = $session->mdb->addSection($ctx, "after", $attr);
                                $session->saveAndResetSite();
                            break;

                           //Insert inner page
                           case 'inner':
                               $ctx = $session->mdb->getContextFromPath($_POST['path']);
                               $newPath = $session->mdb->addSection($ctx, "inner", $attr);
                               $session->saveAndResetSite();
                           break;
                        } // End Of Switch

                       //Display page with changed attributes and pages
                       $pageList->site =& $session->site;
                       $tmpUri = explode("/", $path);
                       $page = $session->getRequestedPage($tmpUri);
                       $session->smarty->assign("page", $page);
                       $session->smarty->assign("content", "admin/page/pageMain.tpl");

                    }
                    else
                    {
                    // Errors occured - we should inform the user
                        $page->attributes = $attr;
                        
                   //Display form with correct attributes
                         switch ($_POST['type']) 
                         {
                            case 'inner':
                               // insert new page after this page
                                $session->smarty->assign("type", "inner");         
                            break;

                            case 'after':
                               // insert new page after this page
                                $session->smarty->assign("type", "after");
                            break;
                            default:
                                $session->smarty->assign("type", "edit");
                            break;
                        }
                        $session->smarty->assign("errors", $errors);
                        $session->smarty->assign("page", $page);
                        $session->smarty->assign("content", "admin/page/sectionDetail.tpl");
                       
                    } // if (sizeof($errors) == 0)
                    
                    
                } // End of if ($_POST['type'] == 'delete')
           } 
           elseif (isset($_POST['cancel']))
           {
           //Display page with old attributes
               $session->smarty->assign("page", $page);
               $session->smarty->assign("content", "admin/page/pageMain.tpl");
           }
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