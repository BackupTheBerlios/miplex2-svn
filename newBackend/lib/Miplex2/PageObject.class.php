<?php

    /**
    * Diese Klasse ist die direkte Repräsentation einer darzustellenden Seite im Frontend.
    * 
    *
    */
    class PageObject
    {
        
        var $attributes = array();
        var $hasChildPage = 0;
        
        var $subs = null;
        var $content = array();
        
        var $path = null;
        
        var $params = null;
        var $config = null;
        
        var $ext = 0;
        
        
        /**
        * Konstruktor des Pageobjekts
        */
        function PageObject()
        {
        }
      
        /**
        * Diese FUnktion ermittelt den Titel anhand der in der Sektion vorgegebenen Namens
        * @return String Titel
        */  
        function getTitle()
        {
            return $this->attributes['name'];
        }
        
        /**
        * Evaluate Extension by getting the name and the params
        * ###mailform(param=value, param=value)###
        *
        * @param String $string The content to parse
        */
        function evaluateExtension($string)
        {
            $regex = "/###Ext:(.*)###/";
            $regex2 = "/^(.*)\((.*)\)$/";
            
            preg_match($regex, $string, $matches);
            
            if (!empty($matches[1]))
            {
                preg_match($regex2, $matches[1], $params);
                
                if (!empty($params[1]))
                {
                    $extName = $params[1];
                    $tmpParams = $params[2];
                    
                    //Explode Params
                    $tmpParams = explode("," , $tmpParams);
                    foreach ($tmpParams as $val) {
                    	
                        $para = explode("=", $val);
                        $extParams[trim($para[0])]=trim($para[1]);
                    }
                    
                    //now we got the name and the params so lets include and pass
                    require_once($this->config->miplexDir."ExtensionManager.class.php");
                    $extManager = new ExtensionManager($this->config);
                    
                    $ext = $extManager->loadExtension($extName);
                    
                    if ($ext != false)
                    {
                        $ret = $ext->main($extParams);
                        $this->ext = 1;
                        
                    }
                    else 
                        $ret = "Plugin not Found";
                    
                    $string = preg_replace($regex, $ret, $string);
                }
                
            }
            
            return $string;
        }
        
        /**
        * Diese Funktion dient dazu, PHP auszuführen, welches syntaktisch korrekt innerhalb des Content
        * Elements stehen muss.
        * @param String $string Der Inhalt des CE
        * @retrun String der String ausgewertet
        */
        function evaluatePhp($string)
        {
            $regex = "/<\?php(.*)\?>/i";
            //PHP Code finden
            preg_match($regex, $string, $matches);
            
            //Vorbereiten des Output Bufferings
            $part1 = "ob_start();";
            $part2 = "\$ret = ob_get_contents();ob_end_clean();";
            
            //nur wenn PHP Code gefunden auswerten
            if (!empty($matches[1]))
            {
                //Auswertrn mit Output Buffering
                eval($part1.$matches[1].$part2);
                //Das ausgewertete in dem CE ersetzen.
                $string = preg_replace($regex, $ret, $string);
            }
            
            return $string;
        }
        
        /**
        * Diese Funktion wird vom Template aus aufgerufen um den Seiteninhalt auszugeben
        * Dabei werden alle in diesem Objekt gespeicherten Felder ausgegeben. Des weiteren werden
        * aber nur die Felder ausgegeben, die der Position entsprechen, die gewünscht ist und
        * es wird überprüft, ob die Seite überhaupt sichtbar ist (draft)
        * @param String $positoin Die Position die ausgegeben werden soll
        * @return String Die Ausgabe der Seite
        */
        function getContentOfPage($position = "default")
        {
            if ($this->attributes['draft'] != 'on')
            {
                if ($position == "default")
                {
                    $position = $this->config->defaultPosition;
                }
                
                foreach ($this->content as $key => $co) {
                	
                    if (empty($co['attributes']['position']))
                       $this->content[$key]['attributes']['position'] = $this->config->defaultPosition;
                        
                    $output.=$this->getSingleContent($key, $position);
                    
                }
                
                return $output;
            }
        }
        
        /**
        * Get single Content from Element. Watch attributes like
        * start stop, extensions and php code
        *
        *
        */
        function getSingleContent($id, $position)
        {
            
            if ($position == $this->content[$id]['attributes']['position'])
            {
                //Check Attributes
                $visibleFrom = $this->makeDate($this->content[$id]['attributes']['visibleFrom']);
                $visibleTill = $this->makeDate($this->content[$id]['attributes']['visibleTill']);
                
                $now = mktime(0,0,0, date("m"), date("d"), date("Y"));
                
                if ($now >= $visibleFrom && $now <= $visibleTill && $this->content[$id]['attributes']['draft']!='on')
                {
                    $cnt = "<div class='content'><h1 id='".$this->content[$id]['attributes']['alias']."'>".$this->content[$id]['attributes']['name']."</h1>\n";
                    $cnt.= "<div class='contentBody'>".$this->content[$id]['data']."</div></div>";
                        
                } else 
                    $cnt = "";
                
                    
                //now seach for exzendsions and php code   
                if ($this->attributes['allowScript']=='on' || $this->attributes['allowScript']=='true')  
                {
                    $cnt = $this->evaluatePhp($cnt);    
                }
    
                if ($this->attributes['allowExtension']=='on' || $this->attributes['allowExtension']=='true')  
                {
                    $cnt = $this->evaluateExtension($cnt);    
                }
                
                        
                return $cnt;
            }
            
        }
        
        
        /**
        * Erzeugt aus einem String der Form dd.mm.YYYY ein korrekten Timestamp,
        * der verglichen werden kann.
        * @param String $string Das Datum als String
        */
        function makeDate($string)
        {
            $string = empty($string)? date("d.m.Y") : $string;
            $date = explode(".", $string);
            $time = mktime(0,0,0,$date[1], $date[0],$date[2]);
            return $time;
        }
        
        
    }


?>