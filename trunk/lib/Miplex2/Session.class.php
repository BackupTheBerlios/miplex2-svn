<?php

class Session
{
    //Site stuff 
    var $site;
    var $config;
    var $currentPage;
    var $mdb = null;
    
    //System stuff
    var $i18n;
    var $user = "nobody";
    var $smarty = false;
    //var $actPage = null;
    var $lang = "de";
    
    var $act;
    var $type = "frontend";
    
    var $header = "";
    
    //user management
    var $userDatabase = null;
    
    /**
    * Konstruktor der Klasse, initialisieren der Seite und der Konfiguration
    * laden des Smarty Objects
    * @param String $configFile Pfad zur Konfigurationsdatei
    */
    function Session($configFile, $type="frontend")
    {
        $this->setConfig($configFile);
        
        $this->setSite();
        $this->getSmartyObject();
        
        $this->type = $type;
        
        require_once($session->config->miplexDir."M2Translator.class.php");
        $this->i18n = new M2Translator("de");
    }
   
    /**
    * This function is called by the backend to load the UserDatabase
    * and inject it in the session. 
    *
    */
    function loadUserDatabase()
    {
        require_once($session->config->miplexDir."M2UserManager.class.php");
        if ($this->userDatabase==null)
        {
            //load new db
            $this->userDatabase = new M2UserManager("config/user.xml", $this->mdb->xPathHandle);
            $this->userDatabase->loadDatabase();
            return true; 
        }
        //was already loaded
        return true;
    }
   
    /**
    * Laden der Seitenstruktur
    *
    */
    function setSite()
    {
        require_once($this->config->miplexDir."MiplexDatabase.class.php");
        
        $site = new MiplexDatabase($this->config, 1);
        $this->mdb = $site;
        $this->site = $site->getSiteStructure();
        
    }
    
    /**
    * Laden der Konfiguration
    * @param string $configFile Pfad zur Konfigurationsdatei
    */
    function setConfig($configFile)
    {
        require_once("lib/Miplex2/MiplexConfig.class.php");
        $this->config = unserialize(file_get_contents($configFile));
    }
    
    /**
    * Erstellen eines neuen Smarty Objects mit den
    * passenden Variablen
    *
    */
    function getSmartyObject()
    {
        if (!is_object($this->smarty))
        {
            require_once($this->config->smartyDir."Smarty.class.php");
            $this->smarty = new Smarty();
            
            $this->smarty->template_dir = $this->config->tplDir;
            $this->smarty->compile_dir = $this->config->tplDir."template_c";
            $this->smarty->cache_dir = $this->config->tplDir."cache";
            $this->smarty->config_dir = $this->config->tplDir."config";
            //$this->smarty->debugging = true;
            $this->smarty->plugins_dir = array($this->config->smartyDir."/plugins", $this->config->miplexDir."smartyPlugins");
        }
    }
    
    /**
    * Liefert die aktuelle Seite zurück als PageObjekt
    * @return PageObject Die Seite
    */
    function getActPage($requestUri = null)
    {
        global  $HTTP_SERVER_VARS;
        $docroot = $this->config->docroot;
        
        if ($requestUri == null)        
            $requestUri = $HTTP_SERVER_VARS['REQUEST_URI'];
            
        //remove .html
        $requestUri = preg_replace("/\.html/i", "", $requestUri);
        
        //get params of site and remove params for internal use
        //question is how to separate the params from the rest
        //we use double slashes to separate --> this schould be well indexed by 
        //the search engines
        preg_match("/\/\/(.*)$/i", $requestUri, $matches);
        array_shift($matches);
        $requestUri = preg_replace("/\/\/(.*)$/i", "", $requestUri);
        
        //prepare arrays
        $tmpRoot = explode("/", $docroot);
        $cntRoot = count($tmpRoot);
        
        //remove as much elements as m2 is placed in document root
        $tmpUri = explode("/", $requestUri);
        for ($i=0; $i < $cntRoot; $i++)
        {
            array_shift($tmpUri);
        }
        
        if (!empty($tmpUri))
        {
            //get requested Page
            $tmpSite = $this->getRequestedPage($tmpUri, $matches);
            $this->currentPage = $tmpSite;
            
            return $tmpSite;
        } else 
        {
            //We should get the first page in site
            
            return $this->site[0];
        }
        
    }
    
    
    /**
    * Funktion übergibt array aus dem Pfad, Zurückgegeben wird die gewünschte Seite
    * @param Array $tmpUri Der Pfad als Array
    * @return PageObject Die gewünschte Seite
    */
    function getRequestedPage($tmpUri, $matches = null)
    {
        //Das Array ist der Pfad zu dem richtigen Page Object
        
        $site = $this->site;
        $tmpUri = array_reverse($tmpUri);
        $error = false;
        
        while (!empty($tmpUri) && $error != true)
        {
            //Get requested ID 
            $alias =  array_pop($tmpUri);
            $id = $this->getArrayId($site, $alias);
            $error = $id == -1 ? true : false;
            
            //If we are going to next level select 
            if (count($tmpUri)>0 && $error != true)
            {
                $site = $site[$id]->subs;
                
            }
            
        }
        //add params if submitted
        $site[$id]->params = $matches[0];
        $retPage = $site[$id];
        $this->act = $retPage;
        
        //Handle Shortcut if $this->type = Frontend
        if ($this->type == "frontend")
        {
            if (!empty($retPage->attributes['shortcut']))
            {
                //Go to shortcut
                header("Location: ".$this->config->docroot.$this->config->baseName."/".$retPage->attributes['shortcut'].".html");
            }
        }
        
        if ($error == true)
            return false;
        else 
            return $retPage;
    }
    
    function getArrayId($pageObjects, $alias)
    {
        $matchedPO = -1;
        foreach ($pageObjects as $key => $po) {
        	
            if ($po->attributes['alias']== $alias)
                $matchedPO = $key;
        }
    
        
        return $matchedPO;
    }
    
    function saveAndResetSite()
    {
        $bool = $this->mdb->saveXML();
        $this->mdb->reset();
        $this->site = $this->mdb->getSiteStructure();
        
        $this->setConfig($this->config->configDir."config.ser");
        
        return $bool;
    }
}



?>
