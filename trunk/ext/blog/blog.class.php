<?php

class blog extends Extension {

    var $categories = array();
    var $baseUri = "";
    var $blogClass = null;
    
    
    /**
    * Call from the Frontend
    */
    
    function main()
    {
        global $HTTP_SERVER_VARS;
        
        
		//Fetch function paramters
        $args = func_get_args();
        
        //switch displaymode :: implemented later
        include("ext/blog/blog.core.class.php");
        $this->blogClass = new weblog("ext/blog/data/data.xml", $this->xpath);
        
        //Weblog Klasse �bergeben
        $this->smarty->assign("weblog", $this->blogClass);
        //Submit configuration and categories
        $this->categories = explode("," ,$this->extConrequire_once("lib/Miplex2/Session.class.php");
    
    $session = new Session("config/config.ser", "backend");
    
    $session->loadUserDatabase();

    
    if (!is_string($_GET['module']))
    {
        $_GET['module'] = "start";
    }
    
    switch ($_GET['module'])
    {
     
        case 'page':
        
            require_once($session->config->miplexDir."admin/admin.page.php");
            break;
        
        
        case 'ext':
            require_once($session->config->miplexDir."admin/admin.extensions.php");
            break; 
            
        
        case 'settings':
            require_once($session->config->miplexDir."admin/admin.settings.php");
            break;
        
        case 'start':
            break;
        
        
    }
    
    
    $session->smarty->display("admin.tpl");fig['params']['categories']);
        foreach ($this->categories as $k => $v) {
        	$this->categories[$k] = stripslashes(trim($v));
        }
        $this->smarty->assign("categories", $this->categories);
        $this->smarty->assign("config", $this->extConfig['params']);
        
        //Submit $url
        $url = $this->po->config->docroot.$this->po->config->baseName."/".$this->po->path;
        $this->smarty->assign("url", $url);
        
        //Fetch disired contet
        $queryString = $this->po->params;
        if ($queryString != "")
        {
            $queryString = explode("/", $queryString);
        }
       
        //fetch what to do 
        $displayGroup = $queryString[0];
        //fetch variable
        $displayVariable = $queryString[1];
        
        switch ($displayGroup) {
        	case 'single':
        		
				//fetch contennt by passed number
        	    $content[] = $this->blogClass->getEntryByNumberOrContext($displayVariable-1);
        	    $this->smarty->assign("data", $content);
        	    $this->smarty->assign("content", "blog/tpl/frontend/entry/".$this->extConfig['params']['entryTpl']);
        	    
        	break;
        
        	case 'cat':
        	
				//fetch content by category passed by link
        	    $content = $this->blogClass->getEntryByCategory($displayVariable);
        	    $this->smarty->assign("data",$content);
                    $this->smarty->assign("content","blog/tpl/frontend/entry/".$this->extConfig['params']['entryTpl']);
        	    break;	
        		
        	default:
        	
				//fetch last x entries, the number of entries is defined in the configuration xml file
        	    $content = $this->blogClass->getLastXEntries($this->extConfig['params']['countDisplay']);
        	    $this->smarty->assign("data", $content);
                    $this->smarty->assign("content", "blog/tpl/frontend/entry/".$this->extConfig['params']['entryTpl']);
        	
       		break;
        }
        
        //return $this->smarty->fetch("blog/tpl/frontend/main/".$this->extConfig['params']['mainTpl']);
    }
    
    /**
    * Diese Methode ist der Aufruf des Backends und managt alle Funktionen
    * die durch das Backend bereitgestellt werden.
    *
    */
    function getBackend()
    {
        
        //Enable HTML Area
        $this->baseSmarty->assign("hta", 1);
        
        //Entering the backend function
        //This retrieves the url now we can simply add our own parametes
        $this->baseUri = "?module=ext&id=blog";
        $url = $this->getCurrentURL();
        //assign it to smarty
        $this->smarty->assign("url", $this->baseUri);
        
        //Fetch the extension configuration
        $config = $this->extConfig;
        $this->categories = explode("," ,$config['params']['categories']);
        foreach ($this->categories as $k => $v) {
        	$this->categories[$k] = stripslashes(trim($v));
        }
        
        //Initialize blog class and send copy to the blog class
        include("ext/blog/blog.core.class.php");
        $this->blogClass = new weblog("ext/blog/data/data.xml", $this->xpath);
        
        //handle post actions
        if ($_POST['action'])
        {
            //blog entry, settings, ...
            $part = $_POST['part'];
            //What to do
            $action = $_POST['action'];
            
            //call neede function
            call_user_method($action.$part, $this);
            
        } else {
        
            //Separate different views
            switch ($_GET['part']) {
            	case "new":
            		
            	    //Assing basic variables like config and categories
            	    $this->smarty->assign("config", $this->extConfig);
            	    $this->smarty->assign("cats", $this->categories);
            	    $this->smarty->assign("url", $this->baseUri);
            	    //Assing template
            	    $this->smarty->assign("content", "blog/tpl/new.tpl");
            	    break;
            	    
            	case 'list':
            	       //List all Entries or by cat
            	       $this->listBlogEntries($_POST['cname']);
            	    break;
            	    
            	case 'edit':
            	
            	     $this->openBlogEntry($_GET['nr']);
            	
            	     break;
            	     
            	case 'delete':
            	
            	     $result = $this->blogClass->deleteBlogEntry($_GET['nr']-1);
            	     $this->smarty->assign("result", $result);
                     $this->smarty->assign("content", "blog/tpl/newConfirmed.tpl");
            	
            	     break;
            
            	case 'settings':
            	
            	     //fetch available entry templates
            	     $entryTpls = $this->fetchTemplates("entry"); 
            	     $commentTpls = $this->fetchTemplates("comment");
            	     $mainTpls = $this->fetchTemplates("main");
            	     
            	     $this->smarty->assign("eTpls", $entryTpls);
            	     $this->smarty->assign("cTpls", $commentTpls);
            	     $this->smarty->assign("mTpls", $mainTpls);
            	     
            	     //Assign Params to template
            	     $this->smarty->assign("params", $this->extConfig['params']);
            	     $this->smarty->assign("content", "blog/tpl/settings.tpl");
            	
            	     break; 
            	         
            	default:
            	    //default action is to display welcome page
            	    $this->smarty->assign("content", "blog/tpl/default.tpl");   
            	    break;
            }
        }
        //This is the last part of this function do nothing beyond...
        return $this->smarty->fetch("blog/tpl/backend.tpl");
        
    }
    
    /**
    * THis functions handles the new blog entry that we should add to the databse
    * It fetches the needed data from the post array
    */
    function addEntryBlog()
    {
        $blogData = $_POST['blog'];
        
        $result = $this->blogClass->addEntry($blogData);
        
        $this->smarty->assign("result", $result);
        $this->smarty->assign("content", "blog/tpl/newConfirmed.tpl");
    }
    
    function editEntryBlog()
    {
        $blogData = $_POST['blog'];
        
        $result = $this->blogClass->updateBlogEntry($_POST['context'], $blogData);
        $this->smarty->assign("result", $result);
        $this->smarty->assign("content", "blog/tpl/newConfirmed.tpl");
    }
    
    /**
    * List all Blogentries and display them in the backend
    *
    */
    function listBlogEntries($catName = "all")
    {
        if ($catName == "")
        
            $entries = $this->blogClass->getEntry();
        else {
            
            $this->smarty->assign("gname", stripslashes($catName));
            $entries = $this->blogClass->getEntryByCategory(stripslashes($catName));
        }
        
        //Data
        $this->smarty->assign("list", $entries);
        $this->smarty->assign("cats", $this->categories);
        //Template
        $this->smarty->assign("content", "blog/tpl/blogListEntries.tpl");
    }
    
    function openBlogEntry($number)
    {
        if (is_numeric($number))
        {
            $entry = $this->blogClass->getEntryByNumberOrContext($number-1);
            $this->smarty->assign("cats", $this->categories);
            $this->smarty->assign("blog", $entry);
            $this->smarty->assign("content", "blog/tpl/editBlogEntry.tpl");
        }
    }
    
    function saveConfigSettings()
    {
        $params = $_POST['blog']['params'];
        $this->extConfig['params'] = $params;
        $this->saveConfiguration($this->extConfig);
        
        //default action is to display welcome page
	    $this->smarty->assign("content", "blog/tpl/default.tpl");   
    }
    
    
    function fetchTemplates($group)
    {
        $return = array();
        
        $tplDir = opendir("ext/blog/tpl/frontend/".$group);
        while (false !== ($file = readdir ($tplDir))) 
        {
            //fetch all TPLs
            if ($file != "." && $file != "..")
            {
                $return[] = $file;
            }
        }
        
        return $return;
    }
    
}

?>
