<?php

class TMENU
{
    var $collapse = 1;
    var $start = 1;
    var $stop = -1;
    var $depth = -1;
    var $wrapAll = "<ul>|</ul>";
    var $wrapItem = "<li>|</li>";

    var $site = null;
    var $currentPage = null;
    var $desiredPath = null;
    var $config = null;

    
    function makeLink(&$po)
    {
        return "<a href='".$this->config->docroot."index.php/".$po->path.".html'>".$po->attributes['name']."</a>";
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

        if ($this->stop == -1 ||($depth-abs($this->stop))<=0)
        {

        //Is $depth correct and $start too
        if (($this->depth == -1 || $depth <= $this->depth) && $this->start <= $depth)
        {

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
                        $output = $item[0].$this->makeLink($po)."\n";
                        $output.= ($d2-abs($this->stop))<=0 ? $wraps[0]."\n" :"";
                        //Get Subsections
                        foreach ($po->subs as $po2) {

                            $output.="\t".$this->getEntries($po2,$d2);

                        }
                        $output.= ($d2-abs($this->stop))<=0 ? $wraps[1]."\n" :"";
                        $output.= "\n".$item[1];
                        //Return formated output
                        return $output;
                       
                   } else {
                       
                       //Item is not in list return only name
                       return $item[0].$this->makeLink($po).$item[1]."\n";   
                   }
                   
                    
                    
                } else {
                    
                    //Increase depth
                    $d2 = $depth + 1;
                    $output = $item[0].$this->makeLink($po).$wraps[0];
                    //Get Subsections
                    foreach ($po->subs as $po2) {
                    	
                        $output.=$this->getEntries($po2,$d2);
                        
                    }
                    
                    $output.=$wraps[1].$item[1];
                    return $output;
                }

            } else {
             
                if (in_array($po->attributes['inMenu'], array("on", "true")) && $po->attributes['draft'] != 'on' )
                    return $item[0].$this->makeLink($po).$item[1]."\n";   
                else    
                    return "";
                
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
        $output = $wraps[0]."\n";
        
        foreach ($this->site as $po) {
        	
            $output.=$this->getEntries($po, 1);
            
        }
        
        $output.=$wraps[1]."\n";
        return $output;
        
    }
}


/**
* Diese funktion erzeugt ein Textmenu
*
*
*/
function smarty_function_tmenu($params, &$smarty)
{
    
    //Registrieren der Basisparameter
    $tmenu = new TMENU();
    


    foreach ($params as $key => $item) {
        $tmenu->$key = $item;
    }

    return $tmenu->getMenu();

}

?>
