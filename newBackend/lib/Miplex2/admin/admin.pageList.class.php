<?php

class pageList 
{
    var $collapse = 1;
    var $start = 1;
    var $depth = -1;
    var $wrapAll = '<ul>|</ul>';
    var $wrapItem = "<li class=\"|\">|</li>";
    
    var $site = null;
    var $currentPage = null;
    var $desiredPath = null;
    var $config = null;
    
    var $module = null;
    
    
    function makeLink(&$po)
    {
        $tmp = "<a href='".$this->config->docroot."admin.php?module=".$this->module."&amp;path=".$po->path."' title='alias:".$po->attributes['alias']."'>";
        $tmp.= $po->attributes['name']."</a>";
        
        return $tmp;
    }
    
    /**
    * Zerlegt den Pfad der Seite in
    * ein Array
    * @param String $path Ein Pfad
    * @return Array Anhand der Slashes zerlegter Pfad
    */
    function getNodeList($path)
    {
        $tmp = explode("/", $path);
        return $tmp;
    }
    
    
    /**
    * Diese Funktion wird rekursiv aufgerufen um das Menü zu erstellen
    * dabei werden die Parameter $depth (die Tiefe), $start (In welcher
    * Ebene angefangen werden soll), $collapse (Sollen nur eigene Ebenen
    * ausgeklappt werden) überprüft. Die Stringformatierung geschieht anhand
    * der in der Klasse definierten Variablen $wrapAll und $wrapItem
    * @param PageObject $po ein PageObject
    * @param Integer $depth die aktuelle Tiefe
    * @return String die Formatierte ausgabe
    */
    function getEntries($po, $depth)
    {
        $item = explode("|", $this->wrapItem);
        $wraps = explode("|", $this->wrapAll);
        
        //Is $depth correct and $start too
        if (($this->depth == -1 || $depth <= $this->depth) && $this->start <= $depth )
        {
            $class=0;
            
            if (isset($po->attributes['draft']) && $po->attributes['draft'] == "on")
                $class+=4;
                
         /* Berechne Zeitstempel um zu ermitteln, ob die Seite im Frontend angezeigt wird */
            $visibleFromArray = explode(".", $po->attributes['visibleFrom']);
            if (sizeof ($visibleFromArray) == 3)
                $visibleFromTimeStamp = mktime (0,0,0,$visibleFromArray[1], $visibleFromArray[0], $visibleFromArray[2]);
            if (!isset($visibleFromTimeStamp) || $visibleFromTimeStamp == -1)
                $visibleFromTimeStamp = time() - 2000;

            $visibleTillArray = explode(".", $po->attributes['visibleTill']);
            if (sizeof ($visibleTillArray) == 3)
                $visibleTillTimeStamp = mktime (0,0,0,$visibleTillArray[1], $visibleTillArray[0], $visibleTillArray[2]);
            if (!isset($visibleTillTimeStamp) || $visibleTillTimeStamp == -1)
                $visibleTillTimeStamp = time() + 2000;
                
           
            if ($visibleFromTimeStamp > time() && $class != 4)
                $class+=4;
            
            if ($visibleTillTimeStamp < time() && $class != 4)
                $class+=4;
            
            
                
            if (strlen($po->attributes['shortcut']) > 1)
                $class+=2;
                
            if (!isset($po->attributes['inMenu']) || $po->attributes['inMenu'] != "on" )
                $class+=1;
            
            if ($po->hasChildPage == 1)
            {
                //We have to check if collapse=1 if the subpages of this page
                //are in the desired path
                
                if ($this->collapse==1)
                {
                    
                   //Get List of Nodes in desiredPath 
                   $nodes = $this->getNodeList($this->desiredPath);
                   if (in_array($po->attributes['alias'], $nodes))
                   {
                       //Increase depth
                        $d2 = $depth + 1;
                        $output = $item[0]."type".$class.$item[1].$this->makeLink($po)."\n".$wraps[0]."\n";
                        //Get Subsections
                        foreach ($po->subs as $po2) {
                            
                            $output.=$this->getEntries($po2,$d2);
                            
                        }
                        
                        $output.=$wraps[1]."\n".$item[2];
                        //Return formated output
                        return $output;
                       
                   } else {
                       
                       //Item is not in list return only name
                       return $item[0]."type".$class.$item[1].$this->makeLink($po).$item[2];
                   }
                   
                    
                    
                } else {
                    
                    //Increase depth
                    $d2 = $depth + 1;
                    $output = $item[0]."type".$class.$item[1].$this->makeLink($po).$wraps[0];
                    //Get Subsections
                    foreach ($po->subs as $po2) {
                        
                        $output.=$this->getEntries($po2,$d2);
                        
                    }
                    
                    $output.=$wraps[1].$item[2];
                    return $output;
                }
                
            } else {
             
                return $item[0]."type".$class.$item[1].$this->makeLink($po).$item[2]."\n";
                
            }
          
        // We have not already started output      
        } else if ($this->start > $depth)
        {
            //Check if page contains child pages
            if ($po->hasChildPage == 1)
            {
                //check if output is collapsed
                if ($this->collapse == 1)
                {
                    
                    $nodes = $this->getNodeList($this->desiredPath);
                    if (in_array($po->attributes['alias'], $nodes))
                    {
                        
                        $output = "";
                        $d2 = $depth + 1;
                        foreach ($po->subs as $po2) {
                            $output.=$this->getEntries($po2, $d2);
                        }
                        
                        return $output;
                        
                    }
                    
                    
                } else 
                {
                    $output = "";
                    $d2 = $depth + 1;
                    foreach ($po->subs as $po2) {
                        $output.=$this->getEntries($po2, $d2);
                    }
                    
                    return $output;
                }
            }
        }
        
    }
    
    /**
    * Dient zum erstellen eines Textmenüs aus der Seitenstruktur
    * dabei wird mit den ersten Elementen angefangen und danach wird
    * rekursive der Baum durchgegangen
    * 
    * @return String Die Ausgabe aus dem Menü
    */
    function getMenu()
    {
        
        $this->desiredPath = $this->currentPage->path;
        
        $wraps = explode("|", $this->wrapAll);
        $output = "<ul id=\"pagelist\">\n";
        
        foreach ($this->site as $po) {
            
            $output.=$this->getEntries($po, 1);
            
        }
        
        $output.= "</ul>\n";
        return $output;
        
    }
    
    function pageList(&$site, &$config, $module)
    {
        $this->site = $site;
        $this->config = $config;
        $this->module = $module;
    }
}
?>