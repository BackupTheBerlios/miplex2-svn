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
        * Funktion zum generieren von einem RSS 2.0 feed
        */
        function generateRSS($ype="html")
        {
            //Einfügen des Basiswertes
            include_once("xml/XPath.class.php");
            include_once("ext/blog2/class/blog.class.php");
            
            $xml = new XPath("ext/blog2/content/rss.xml");
            
            //Konfiguration einfügen
            foreach ($this->config['rss'] as $key => $value) {
                
                if (!empty($value))
                {
                    $data= "\n<$key>$value</$key>\n";
                    $xml->appendChild("/rss[1]/channel[1]",$data);
                }
            	
            }
            
            //So nun die letzten 10 Einträge aus dem Blog einfügen
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