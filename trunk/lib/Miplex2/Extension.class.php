<?php

/**
* Diese Klasse dient als abstrakte Oberklasse dazu, eine 
* art Interface für die Entwicklung bereitzustellen. Innerhalb
* der jeweiligen Erweiterung wird mit dieser Klasse gearbeitet.
*
*/
class Extension
{
    var $config;
    var $extConfig;
    var $smarty;
    var $xpath;
    
    /**
    * Der Konstrultor dient dazu, die Konfiguration der Erweiterung in dem
    * Objekt zu speichern und ein neues Smarty Objekt zu erzeugen, und die
    * Konfiguration des Miplex2 zu speichern
    * @param MiplexConfig $config Die Referenz auf die Konfiguration von Miplex2
    * @param Array $extConfig Die Konfigurationsdatei der Erweiterung
    */
    function extension(&$config, $extConfig)
    {
        $this->config =& $config;
        $this->extConfig = $extConfig;
        
        require_once($this->config->smartyDir."Smarty.class.php");
        $this->smarty = new Smarty();
        
        $this->smarty->template_dir = array($this->config->tplDir, "ext/");
        $this->smarty->compile_dir = $this->config->tplDir."template_c";
        $this->smarty->cache_dir = $this->config->tplDir."cache";
        $this->smarty->config_dir = $this->config->tplDir."config";
        //$this->smarty->debugging = true;
        $this->smarty->plugins_dir = array($this->config->smartyDir."/plugins", $this->config->miplexDir."smartyPlugins");
        
        require_once($this->config->xpathDir."XPath.class.php");
        $this->xpath = new XPath();
        
    }
    
    /**
    * Platzhalter für die Hauptmethode, die vom Frontend aufgerugen wird
    * @return String
    *
    *
    */
    function main()
    {
        return "Please implement main Method";
    }
    
    /**
    * Platzhalter für die Methode, die im Backend aufgerufen wird
    * um die Erweiterung im Backend zu konfigurieren.
    *
    *
    */
    function getBackend()
    {
        return "Got no Backend Module";
    }
    
    
    
    /**
    * Liefert die Url zurück, die gerade aktuell ist. Dies ist nur für
    * das Backend interessant, falls sich die Konfiguration über mehrere
    * Ebenen erstreckt.
    *
    */
    function getCurrentURL()
    {
        global $HTTP_SERVER_VARS;
        
        $url = $this->config->docroot."admin.php?".$HTTP_SERVER_VARS['QUERY_STRING'];
        return $url;
    }
    
    
    /**
    * Diese FUnktion, soll es dem Programmierer erleichtern die Konfigurationsdatei der
    * Erweiterung zu speichern. Übergeben wird dabei ein Array der Konfiguration.
    * Dies wird dann als XML Datei abgespeichert und auf FP geschrieben.
    * @param Array $config Die Konfiguration der Erweiterung
    *
    */
    function saveConfiguration($config)
    {
        
        $configFile = $this->config->extDir.$this->extConfig['basename']."/config.xml";
        require_once($this->config->miplexDir."BeautifyXML.class.php");
        $beauty = new BeautifyXML();
        
        $node = $beauty->formatXML($this->_prepareNode($config));
        
        $fp = fopen($configFile, "w");
        fwrite($fp, $node);
        fclose($fp);
               
    }
    
    /**
    * Diese Methode bereitet das Konfigurationsarray auf das Schreiben als
    * XML String vor, indem es das Array ausliest und als XML String zurückgibt.
    * @param Array $config Die Konfiguraion der Erweiterung
    * @return String XML String der Erweiterung
    */
    function _prepareNode($config)
    {
        $node = "<config>
                <extName>".$config['extName']."</extName>
                <author>".$config['author']."</author>
                <mail>".$config['mail']."</mail>
                <version>".$config['version']."</version>
                <dependsOn>".$config['dependsOn']."</dependsOn>
                <params>";
        
        //insert params
        foreach ($config['params'] as $key => $val) {
        	$node.="<$key>$val</$key>";
        }
        
        
        $node.="</params>
                </config>";
        
        return $node;
    }
}


?>