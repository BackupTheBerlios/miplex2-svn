<?php

class blog extends Extension {

    var $categories = array();
    var $baseUri = "";
    var $blogClass = null;
    
    function main()
    {
    }
    
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
        print_r($this->extConfig);
        $this->extConfig['params'] = $params;
        $this->saveConfiguration($this->extConfig);
    }
    
}

?>