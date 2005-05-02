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
    /* @var $userDatabase M2UserManager */
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
        require_once("lib/Miplex2/M2UserManager.class.php");
        if ($this->userDatabase==null)
        {
            //load new db
            $handle = new XPath();
            $this->userDatabase = new M2UserManager("config/user.xml", $handle);
            //$this->userDatabase->loadDatabase();
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
    * Laden der Headerinformationen für die HTML-Asugabe
    */
    function setHeader()
    {
        $page = $this->getActPage();
        $this->header = '<title>'.$this->config->title.$page->getTitle().'</title>'."\n";
        $this->header.= '   <meta name="generator" content="Miplex2" />'."\n";
        $this->header.= '   <meta name="keywords" Content="'.$this->config->keywords.'" />'."\n";
        $this->header.= '   <meta name="description" content="'.$this->config->description.'" />'."\n";
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
            
            $this->smarty->template_dir = "tpl/";
            $this->smarty->compile_dir = "tpl/template_c";
            $this->smarty->cache_dir = "tpl/cache";
            $this->smarty->config_dir = "tpl/config";
            //$this->smarty->debugging = true;
            $this->smarty->plugins_dir = array("lib/smarty/libs/plugins", "lib/Miplex2/smartyPlugins");
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
        
        // remove $_GET-Parameters
        $requestUri = preg_replace("/\?.*/i", "", $requestUri);
        
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
            $tmpSite = $this->getRequestedPage($tmpUri);
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
    function getRequestedPage($tmpUri)
    {
        //Das Array ist der Pfad zu dem richtigen Page Object

        $site = $this->site;
        $oldsite = $site;
        $id = 0;
        $oldid = $id;
        $tmpUri = array_reverse($tmpUri);
        $error = false;

        while (!empty($tmpUri) && !$error)
        {
            // Get requested ID
            $alias =  array_pop($tmpUri);
            $oldid = $id;
            $id = $this->getArrayId($site, $alias);
            $error = ($id == -1);

            if (!is_array($site[$id]->subs))
                break;

            if (!empty($tmpUri) && !$error && is_array($site[$id]->subs))
            {
                $oldsite = $site;
                $site = $site[$id]->subs;
            }
        }

        $this->act = $site[$id];
        
        // Handle Shortcuts and Params if ($this->type == "frontend")
        if ($this->type == "frontend")
        {
            // Hier sind wir, wenn schon der Seiteneinstieg nicht gefunden werden konnte
            // oder wenn eine Seite, die Unterseiten hat, Parameter bekommen hat
            if (empty($this->act))
            {
                $this->act = $oldsite[$oldid];
                array_push($tmpUri, $alias);
            }

            // add params if submitted
            if (is_array($tmpUri))
            {
                // Entfernt leere Parameter
                $uri = array();
                foreach($tmpUri as $str)
                    if ((strlen($str) > 0)) 
                        array_push($uri, $str);

                $this->act->params = implode("/", array_reverse($uri));
            }

            if (!empty($this->act->attributes['shortcut']))
            {
                //Go to shortcut
                header("Location: ".$this->config->docroot.$this->config->baseName."/".$this->act->attributes['shortcut'].(strlen($this->act->params)>0 ? "/".$this->act->params: ".html"));
            }
        }


        return $this->act;
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
        
        $this->setConfig("config/config.ser");
        
        return $bool;
    }
}



?>
