<?php

/**
* Diese Klasse dient dazu die Konfiguration von Miplex zu speichern
* 
*/
class MiplexConfig
{
    //Serverbeschreibung
    var $docroot = "";
    var $fileSystemRoot = "";
    var $server = "";
    
    //Templateauswahl
    var $theme = "";
    
    //ImageFolder
    var $imageFolder = "";
    
    //Metatags
    var $keywords = "";
    var $description = "";
    var $title = "";
    
    //Directories used in Miplex
    var $extDir = "";
    var $libDir = "";
    var $htmlAreaDir = "";
    var $smartyDir = "";
    var $xpathDir = "";
    var $configDir = "";
    var $miplexDir = "";

    var $tplDir = "";   
    
    //Content
    var $contentFileName = "";
    var $contentDir= "";
    var $position = "normal";
    var $defaultPosition = "normal";
    
    var $baseName="index.php";
    var $useHtmlArea = 1;
    
    
    
    function MiplexConfig()
    {
    }
    
    
    
}


?>