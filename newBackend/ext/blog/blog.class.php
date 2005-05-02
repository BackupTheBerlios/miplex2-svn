<?php

class blog extends Extension {

    var $categories = array();
    var $baseUri = "";
    var $blogClass = null;
    var $dynParams;
    var $urlbase;
    
    /*@var $smarty Smarty*/
    var $smarty;
    
    /**
    * Call from the Frontend
    */
    
    function main()
    {
        global $HTTP_SERVER_VARS;
        global $session;
        
		//Fetch function paramters
        $args = func_get_args();
        
        //switch displaymode :: implemented later
        include("ext/blog/blog.core.class.php");
        $this->blogClass = new weblog("ext/blog/data/data.xml", $this->xpath);
        
        //Weblog Klasse �bergeben
        $this->smarty->assign("weblog", $this->blogClass);
        //Submit configuration and categories
        $this->categories = explode("," ,$this->extConfig['params']['categories']);
        foreach ($this->categories as $k => $v) {
        	$this->categories[$k] = stripslashes(trim($v));
        }
        $this->smarty->assign("categories", $this->categories);
        $this->smarty->assign("config", $this->extConfig['params']);
        
        //Submit $url
        
        $this->dynParams = explode("/", $session->currentPage->params);
        $this->urlbase = $session->currentPage->config->docroot.$session->currentPage->config->baseName."/".$session->currentPage->path;
        
        $this->smarty->assign("url", $this->urlbase);
        
        //fetch what to do 
        $displayGroup = $this->dynParams[0];
        //fetch variable
        $displayVariable = $this->dynParams[1];
        
        //Kommentare und Formular anzeigen
        $this->smarty->assign("comments","1");
        $this->smarty->assign("formular", "1");
        
        
        switch ($displayGroup) {
        	case 'single':
        		
				//fetch contennt by passed number
        	    $content[] = $this->blogClass->getEntryByNumberOrContext($displayVariable-1);
        	    
        	    //holen des Cookies falls vohanden
        	    if ($_COOKIE['m2blogkeks'])
        	    {
        	        $author['author'] = $_COOKIE['m2blogkeks']['author'];
        	        $author['mail'] = $_COOKIE['m2blogkeks']['mail'];
        	        $author['www'] = $_COOKIE['m2blogkeks']['www'];
        	        $author['notify'] = $_COOKIE['m2blogkeks']['notify'];
        	        
        	        $this->smarty->assign("author", $author);
        	    }
        	    
        	    $this->smarty->assign("data", $content);
        	    $this->smarty->assign("content", "blog/tpl/frontend/entry/".$this->extConfig['params']['entryTpl']);
        	    
        	break;
        
        	case 'cat':
        	
				//fetch content by category passed by link
				$this->smarty->assign("comments", "0");
        	    $content = $this->blogClass->getEntryByCategory($displayVariable);
        	    $this->smarty->assign("data",$content);
                $this->smarty->assign("content","blog/tpl/frontend/entry/".$this->extConfig['params']['entryTpl']);
        	    break;	
        		
        	case 'add':
        	    //Hinzufügen eines Kommentars
        	    $content[] = $this->blogClass->getEntryByNumberOrContext($_POST['context']);
        	    
        	    $comment['author'] = $_POST['author'];
        	    $comment['www'] = $_POST['www'];
        	    $comment['mail'] = $_POST['mail'];
        	    $comment['content'] = $_POST['content'];
        	    $comment['notify'] = $_POST['notify'];
        	    $comment['date'] = date("d.m.Y");
        	    
        	    $done = $this->blogClass->addComment($content[0]['context'], $comment);
        	    $ncnt[] = $this->blogClass->getEntryByNumberOrContext($_POST['context']);
        	    
        	    if ($done)
        	    {
        	        
        	        //Behandeln des Cookies
        	        if ($_POST['keks']=="on" && ! $_COOKIE['m2blogkeks'])
        	        {
        	            setcookie("m2blogkeks[author]", $comment['author'], time()+60*60*24*30, "/");
        	            setcookie("m2blogkeks[mail]", $comment['mail'], time()+60*60*24*30, "/");
        	            setcookie("m2blogkeks[www]", $comment['www'], time()+60*60*24*30, "/" );
        	            setcookie("m2blogkeks[notify]", $comment['notify'], time()+60*60*24*30, "/" );
        	        }
        	        
        	        $this->smarty->assign("data", $ncnt);
            	    $this->smarty->assign("formular", "1");
            	    $this->smarty->assign("added", "1");
        	    }
        	    $this->smarty->assign("content", "blog/tpl/frontend/entry/".$this->extConfig['params']['entryTpl']);
        	
    	    break;
        	    
        	default:
        	
				//fetch last x entries, the number of entries is defined in the configuration xml file
				$this->smarty->assign("comments", "0");
        	    $content = $this->blogClass->getLastXEntries($this->extConfig['params']['countDisplay']);
        	    $this->smarty->assign("data", $content);
                    $this->smarty->assign("content", "blog/tpl/frontend/entry/".$this->extConfig['params']['entryTpl']);
        	
       		break;
        }
        
        return $this->smarty->fetch("blog/tpl/frontend/main/".$this->extConfig['params']['mainTpl']);
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
            	        
            	case 'rss':
            	     require_once("ext/blog/rsscreator.class.php");
            	     $rss = RSSCreator::getInstance('2');
            	     
            	     $channel['title'] = $this->extConfig['params']['blogTitle'];
                     $channel['link'] = $this->extConfig['params']['blogURL'];
                     $channel['description'] = $this->extConfig['params']['description'];
                     $channel['language'] = "de";
                     $channel['date'] = date("d.m.Y H:i:s");
                     $channel['creator'] = $this->extConfig['params']['managingEditor'];
                    
                     $rss->addChannel($channel);
                     
                     $entries = $this->blogClass->getLastXEntries(10);
                     foreach ($entries as $entry) {
    
                         $item = array();
                         $item['category'] = $entry['attributes']['category'];
                         $item['author'] = $entry['attributes']['author'];
                         $item['title'] = $entry['attributes']['title'];
                        
                         $item['date'] = $entry['attributes']['date'];
                         $item['content'] = $entry['teaser'];
                         $item['link'] = $this->extConfig['params']['blogURL']."single/".$entry['number'];
                    	
                         $rss->addItem($item);
                     }
            	     
                     $xml = $rss->outputXML();

                     $h = fopen("index.xml", "w");
                     fwrite($h, $xml);
                     fclose($h);
                     $this->smarty->assign("content", "blog/tpl/rss.tpl");  
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
