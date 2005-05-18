<?php
/**
* Diese Klasse dient als Verwalter der Erweiterungen, damit
* lassen sich bestimmen, welche Erweiterungen vorhanden sind und ihre
* Konfigurationen auslesen. Desweiteren lässt sich eine bestimmte Erweiterung laden.
*
*/
class ExtensionManager
{
    var $extensions = null;
    var $config = null;
    var $xpath = null;
    
    /**
    * Der Konstruktor der Klasse, übergeben wird eine Konfiguration
    * um ein neues XPath Objekt zu erzeugen und bereitzustellen
    * @param MiplexConfig $config Die Konfiguration von Miplex2
    *
    */
    function ExtensionManager(&$config)
    {
        $this->config =& $config;
//        require_once($this->config->xpathDir."XPath.class.php");
        require_once("lib/XPath/XPath.class.php");
        $this->xpath = new XPath();
    }
    
    
    /**
    * Diese Funkion liest das Verzeichnis der Erweiterungen aus und erzeugt
    * ein Array in dem diese gespeichert werden. Dabei wird überprüft ob
    * in jedem Verzeichnis der Erweiterung eine Datei namens config.xml
    * liegt, die die Konfiguration der Erweiterung beinhaltet.
    */
    function getAllAvailableExtensions()
    {
        
        //Walk throug extDir and fetch all Extensions
//        $extDir = opendir($this->config->extDir);
        $extDir = opendir("ext/");
                
        while (false !== ($file = readdir ($extDir))) 
        {
//            $extConfigFile = $this->config->extDir.$file."/config.xml";
            $extConfigFile = "ext/".$file."/config.xml";
            if ($file != "." && $file != ".." && is_file($extConfigFile) && is_readable($extConfigFile))
            {
                //now we've got an extension with a config file
                //lets try to parse it
            // XPath-Objekt zurücksetzen, sonst schlägt wiederholtes Laden fehl
                $this->xpath->reset();
                $this->xpath->importFromFile($extConfigFile);
                $ext['author'] = $this->getValue("author");
                $ext['mail'] = $this->getValue("mail");
                $ext['version'] = $this->getValue("version");
                $ext['dependsOn'] = $this->getValue("dependsOn");
                $ext['extName'] = $this->getValue("extName");
                $ext['params'] = $this->getParams();
                $ext['basename'] = $file;
                
                $this->extensions[$ext['basename']] = $ext;
            }
        }
        return $this->extensions;
    }
    
    /**
    * Dies ist ein Hilfsfunktion für den externen Zugriff um eine Konfigurations-
    * datei explizit auszulesen. Übergeben wird als Parameter der Basename der Erweiterung
    * @param String $file Der Basename der Erweiterung
    * @return Array Die Konfiguration
    */
    function getExtensionConfig($file)
    {
//        $extConfigFile = $this->config->extDir.$file."/config.xml";
        $extConfigFile = "ext/".$file."/config.xml";
        if ($file != "." && $file != ".." && is_file($extConfigFile) && is_readable($extConfigFile))
        {
            //now we've got an extension with a config file
            //lets try to parse it
            $this->xpath->reset();
            $this->xpath->importFromFile($extConfigFile);
            $ext['author'] = $this->getValue("author");
            $ext['mail'] = $this->getValue("mail");
            $ext['version'] = $this->getValue("version");
            $ext['dependsOn'] = $this->getValue("dependsOn");
            $ext['extName'] = $this->getValue("extName");
            $ext['params'] = $this->getParams();
            $ext['basename'] = $file;
            
            $this->extensions[$ext['basename']] = $ext;
        }
        
        return $ext;
    }
    
    /**
    * In der Konfiguration wird unterschieden zwischen einfachen Werten und
    * Parametern. Sie unterscheiden sich nur durch die Schachtelungstiefe.
    * Diese Funktion liest einface Werte aus.
    * @param String $value Der auszulesende Wert
    * @return String der Inhalt der Variable
    */
    function getValue($value)
    {
        $eval = $this->xpath->evaluate("/config/$value");
        $string = $this->xpath->getData($eval[0]);
        return $string;
       
    }
    
    /**
    * Diese Funkion liest die Parameter aus, die in der Erweiterung gespeichert werden.
    * @return Array Die Parameter als Array
    *
    *
    */
    function getParams()
    {
        $params = array();
        $eval = $this->xpath->evaluate("/config/params/*");
        
        foreach ($eval as $item) {
            $params[$this->xpath->nodeName($item)] = $this->xpath->getData($item);
        }
        
        return $params;
    }
    
    /**
    * Anhand des Basenamens der Erweituerng wird nun diese
    * geladen. Dabei wird ein neues Objekt der Erweiterung
    * erzeugt und die nötigen Parameter übergeben.
    * @see Extension
    * @param String $basename Der eindeutige Bezeichner der Erweiterung
    */
    function loadExtension($basename)
    {
        if (!empty($this->extensions[$basename]))
            $ext = $this->extensions[$basename];
        else    
            $ext = $this->getExtensionConfig($basename);
        
        if (!empty($ext))
        {
//            require_once($this->config->miplexDir."Extension.class.php");
//            require_once($this->config->extDir.$basename."/".$basename.".class.php");
            require_once("lib/Miplex2/Extension.class.php");
            require_once("ext/".$basename."/".$basename.".class.php");
            $obj = new $basename($this->config, $ext);
            
            return $obj;
        } 
        else 
            return false;       
    }   
}
?>