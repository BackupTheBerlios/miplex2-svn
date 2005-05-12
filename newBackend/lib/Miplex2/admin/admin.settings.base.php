<?php
    function clean($string)
    {
        // clean up pasted string - so they don't break any HTML
        return htmlentities(stripslashes($string), ENT_QUOTES);
    }


    if ($_POST['save'])
    {
        $newConf = new MiplexConfig();
        
// Determine default parameters as far as we are able to do alone
        $newConf->docroot = substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'], "admin.php"));
        $newConf->server = "http://".$_SERVER['SERVER_NAME'];
        $newConf->fileSystemRoot = $_SERVER['DOCUMENT_ROOT'];

// Deprecated parameters - someone might need that .. although she/he shouldn't
        $newConf->extDir        = "ext/";
        $newConf->libDir        = "lib/";
        $newConf->htmlAreaDir   = "lib/htmlarea/";
        $newConf->smartyDir     = "lib/smarty/libs/";
        $newConf->xpathDir      = "lib/XPath/";
        $newConf->miplexDir     = "lib/Miplex2/";
        $newConf->tplDir        = "tpl/";
        $newConf->imageFolder   = "img/";
        $newConf->configDir     = "config/";
        $newConf->contentDir    = "content/";
        
// Save all submitted parameters
    // Check if files exist
        // baseName
        if (strlen($_POST['data']['baseName']) > 0 && file_exists($_POST['data']['baseName']))
            $newConf->baseName = $_POST['data']['baseName'];
        else
        {
            $newConf->baseName = $session->config->baseName;
            $session->smarty->assign("error", "baseNameNotFound");
        }
    
        // contentFile
        if (strlen($_POST['data']['contentFileName']) > 0 && file_exists("content/".$_POST['data']['contentFileName']))
        {
            if (is_writeable("content/".$_POST['data']['contentFileName']))
                $newConf->contentFileName = $_POST['data']['contentFileName'];
            else
            {
                $newConf->contentFileName = $session->config->contentFileName;
                $session->smarty->assign("error", "contentFileNotWriteable");
            }
        }
        else
        {
            $newConf->contentFileName = $session->config->contentFileName;
            $session->smarty->assign("error", "contentFileNotFound");
        }
        
        // theme
        if (strlen($_POST['data']['theme']) > 0 && file_exists("tpl/".$_POST['data']['theme']))
            $newConf->theme = $_POST['data']['theme'];
        else
        {
            $newConf->theme = $session->config->theme;
            $session->smarty->assign("error", "themeNotFound");
        }
    
    
    // Check whether defaultPosition is part of position and none of them is empty
        if (strlen($_POST['data']['position']) > 0)
        {
            $newConf->position = clean($_POST['data']['position']);
            $positions = explode(",", clean($_POST['data']['position']));
            foreach ($positions as $position)
            {
                if (strcmp(trim($position), clean($_POST['data']['defaultPosition'])) == 0)
                {
                    $newConf->defaultPosition = clean($_POST['data']['defaultPosition']);
                }
            }
            if (strlen($newConf->defaultPosition) == 0)
            {
                $newConf->defaultPosition = $session->config->defaultPosition;
                $session->smarty->assign("error", "defaultPositionNotPartOfPosition");
            }
            
        }
        else
        {
            $newConf->position = $session->config->position;
            $newConf->defaultPosition = $session->config->defaultPosition;
            $session->smarty->assign("error", "positionEmpty");
        }
        

    // Accept anyway - what shall I check ??
        $newConf->useHtmlArea = $_POST['data']['useHtmlArea'];
        $newConf->keywords = clean($_POST['data']['keywords']);
        $newConf->description = clean($_POST['data']['description']);
        $newConf->title = clean($_POST['data']['title']);


        if (strlen($session->smarty->_tpl_vars['error']) > 0)
        {
        // Error occured
            // Put new conf into Template - so the user doesn't need to change everything twice
            $session->smarty->assign("newConf", $newConf);
        }
        else
        {
        // Save the new configuration
            $string = serialize($newConf);
            
            $filename = "config/config.ser";
            
            // file already exists - check if its writable
            if ( (file_exists($filename) && is_writable($filename)) 
            // file does not exist - check if directory is writable
              || (!file_exists($filename) && is_writable("config")) )
            { 
                $fp = fopen($filename,"w");
                $ret = fwrite($fp, $string);
                fclose($fp);

            }
            else
                $session->smarty->assign("error", "configNotWritable");
                // Not necessary to handle the error, since I can't save anyway :(

            $session->saveAndResetSite();      
            $session->smarty->assign("config", $session->config);
        }
    }
    else 
    { // We are here for the first time or user decided to abort
        $session->smarty->assign("config", $session->config);
    }
    
    $session->smarty->assign("content", "admin/settings/settings.tpl");
?>