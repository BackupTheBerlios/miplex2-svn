<?php

/**
* Diese Klasse dient dazu die Konfiguration von Miplex zu speichern
* 
*/
class MiplexConfig
{
// Determined
        var $docroot;
        var $server;
        var $fileSystemRoot;
    
// Asked
    // Content
        var $baseName;
        var $contentFileName;
        var $useHtmlArea;

    //Templateauswahl
        var $theme;
        var $position;
        var $defaultPosition;

    //Metatags
        var $keywords;
        var $description;
        var $title;

// Set
    //Deprecated Elements
        var $extDir;
        var $libDir;
        var $htmlAreaDir;
        var $smartyDir;
        var $xpathDir;
        var $miplexDir;
        var $tplDir;   
        var $imageFolder;
        var $configDir;
        var $contentDir;

    
    function MiplexConfig()
    {
    }
}
?>