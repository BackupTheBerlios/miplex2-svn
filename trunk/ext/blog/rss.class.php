<?php

    class blogFeed
    {
        
        var $config;
        var $xclass;
        var $blog;
        
        
        function blogFeed($type,$filename)
        {
            $this->blog = $filename;
        }
        
        /**
        * Kofiguration laden
        * @param array $config Konfiguration
        */
        function setConfig($config)
        {
            $this->config = $config;            
        }
        
        
        /**
        * FUnktion zum Vorbereiten der XML Datei
        */
        function prepareXML()
        {
            $bnode = "<?xml version=\"1.0\" encoding=\"iso-8859-1\" ?>";
            $bnode.= "<rss version=\"2.0\">\n<channel>";
            
            $bnode.="<title>".$this->config['params']['blogTitle']."</title>";
            $bnode.="<link>".$this->config['params']['blogURL']."</link>";
            $bnode.="<description>".$this->config['params']['description']."</descripion>";
            $bnode.="<language>de</language>";
            $bnode.="<generator>Miplex2Blog</generator>";
            
            
            $enode ="</channel></rss>";
            
            return $bnode.$enode;
        }
        
        /**
        * Funktion zum generieren von einem RSS 2.0 feed
        */
        function generateRSS($ype="html")
        {
            //Einf�gen des Basiswertes
            include_once("lib/XPath/XPath.class.php");
            include_once("ext/blog/blog.class.php");
            
            $xml = new XPath();
            $xml->importFromString($this->prepareXML());
            
            
            //Konfiguration einf�gen
            foreach ($this->config['rss'] as $key => $value) {
                
                if (!empty($value))
                {
                    $data= "\n<$key>$value</$key>\n";
                    $xml->appendChild("/rss[1]/channel[1]",$data);
                }
            	
            }
            
            //So nun die letzten 10 Eintr�ge aus dem Blog einf�gen
            $blog = new weblog($this->blog);
            $entryArray = $blog->getLastXEntries(10);
            
            foreach ($entryArray as $entry)
            {
                $item="\n<item>
                        <title>".$entry['attributes']['title']."</title>
                        <link>http://www.grundprinzip.de/blog/single/".$entry['number'].".html</link>
                        <author>".$entry['attributes']['mail']."</author>
                        <category>".$entry['attributes']['category']."</category>
                        <description>".$entry['teaser']."</description>
                        </item>\n";
                $xml->appendChild("/rss[1]/channel[1]", $item);
            }
            
            return $xml->exportAsXml();
        }
        
    }
    
?>