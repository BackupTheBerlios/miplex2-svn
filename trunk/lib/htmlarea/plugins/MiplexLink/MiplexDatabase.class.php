<?php

/**
* Diese Klasse dient dazu, Daten in die XML Datei zu schreiben bzw
* auszulesen. Wichtig sind dabei das auselesen der Struktur und des Inhaltes
* weiterhin soll an einer Bestimmte Position Inhalt eingefügt oder geändert werden
* @package Miplex2
*/
class MiplexDatabase
{
    
    var $miplexConfiguration = "";
    var $xmlFileName = "";
    var $xPathHandle = "";
    
    var $storeContentInStructure = 0;
    
    var $error = array();
    var $site = array();
    
    var $indent = 4;
    /**
    * Methode dient dazu, die XML Datei zu laden und ein File Handle zu 
    * genereieren
    *
    * @author Martin Grund
    * @param object $config Konfiguration von Miplex2
    * @param integer $storeContentInStructure Inhalt der Element mit auslesen
    */
    function MiplexDatabase($config, $storeContentInStructure = 0)
    {
        //Konfiguration bestimmen
        $this->miplexConfiguration = $config;
        $this->storeContentInStructure = $storeContentInStructure;
        $this->xmlFileName = $this->miplexConfiguration->contentFileName;
        
        //Erstellen des Handles für die XPathKlasse
        require_once("XPath.class.php");
        $this->xPathHandle = new XPath();
        $this->reset();
        
        //Loade Class for Handling PageObjects
        require_once("PageObject.class.php");
        
    }

    /**
    * Sezt die XML Datei zurück und ließt sie neu aus.
    *
    */
    function reset()
    {
        $cPath = $this->miplexConfiguration->contentDir.$this->miplexConfiguration->contentFileName;
        $xmlString = file_get_contents($cPath);
        
        //Erstellen des Handles für die XPathKlasse
        $this->xPathHandle->reset();
        $this->xPathHandle->importFromString($xmlString);
        
    }
    
    
    /**
    * Funktion liest die gesamte Seite aus und speichert sie als PageObjekt ab
    * diese werden dann in einem array das der Struktur der Seite
    * entspricht zurückgegeben
    *
    * @author Martin Grund
    * @return array Struktur der Seite
    */
    function getSiteStructure()
    {
        
        //Wir beginnen im Rootlevel --> Alle obersten Sektions auslesen
        $site = array();
        $rootSections = $this->xPathHandle->evaluate("site/section");
        
        foreach ($rootSections as $section) {
        	$site[] = $this->getSectionRecursive($section, "");
        }
        
        $this->site = $site;
        return $site;
        
    }
    
    /**
    * Rekursives Durchlaufen der Sekions mit einem angegebenen Starounkt
    * @param String $context Der Startpunkt
    * @param String $path Der Startpfad
    */
    function getSectionRecursive($context, $path)
    {
        //Initialize return array
        $sectionArray = array();
        
        $thisPage = $this->getSection($context);
        $thisPage->path.=$path.$thisPage->attributes['alias'];
        
        $sectionArray[] = $thisPage;
        
        //is there a next level?
        if ($thisPage->hasChildPage == 1)
        {
            //Get all Section from next level and get subsection
            $nextLevel = $this->xPathHandle->evaluate("section",$context);
            foreach ($nextLevel as $level) {
            	
                $thisPage->subs[]= $this->getSectionRecursive($level, $thisPage->path."/");
                
            }
            
            return $thisPage;
            
        }
        
        return $thisPage;
        
    }
    
    /**
    * Gibt zu einem bestimmten Kontext innerhalb der XML Datei die Entsprechende
    * Section aus. Der Inhalt wird mit ausgelesen, falls $storeContentInStructure auf
    * 1 gesett ist.
    *
    * @author Martin Grund
    * @param string $context Kontext innerhalb der XML Datei
    * @return PageObject Die Section inklusive Attributen (und Inhalt)
    */
    function getSection($context, $debug = 0)
    {
        
        if (is_string($context))
        {
            $xPath = $this->xPathHandle;
            //The Context is the direct pointer to the location within the XML File                     
            //So we should retreive the Attributes and the content elements
            
            $attrContext = $xPath->evaluate("attributes", $context);
            $contentContext = $xPath->evaluate("content", $context);
            
            //Fetch the child Nodes for the Attributes
            $attributes = $xPath->evaluate("/*", $attrContext[0]);
            
            
            if ($attrContext != null && !empty($attributes))
            {
                
                $page = new PageObject();
                $page->config =& $this->miplexConfiguration;
                foreach ($attributes as $attrXQuery) {
                    $page->attributes[$xPath->nodeName($attrXQuery)]= $xPath->getData($attrXQuery);
                }
                
                //if storeContentInStructure is set to 1 we should also fetch the content of this page
                foreach ($contentContext as $cVal) {
                	
                    $page->content[] = array("data" => null, "context" => $cVal, "attributes" => null);
                }
                
                //Fetch Content
            	if ($this->storeContentInStructure == 1)
            	{
            	    foreach ($page->content as $key => $cObj) {
            	        
            	        //Set Content , strip CDATA
            	        $page->content[$key]['data']= $this->getContentAtPosition($cObj['context']);
            	        
            	        //Fetch Content Attributes
            	        $cAttrContext = $xPath->evaluate("attributes/*", $cObj['context']);
            	        if ($cAttrContext != null)
            	        {
                	        foreach ($cAttrContext as $cAttr) {
                	        	$page->content[$key]['attributes'][$xPath->nodeName($cAttr)] = $xPath->getData($cAttr);
                	        }
            	        }
            	    	
            	    }
            	}
            	
            	//Check if this page contains other sections
            	$childSections = $xPath->evaluate("section",$context);
            	$page->hasChildPage = empty($childSections) ? 0 : 1;
                
                
                return $page;
                
            } else {
             
                //Page is Corrupt
                return false;   
            }
            
            
            
            
        } else 
        {
            //Fehlerbehandlung
            return false;
        }
        
        
    }
    
    /**
    * Diese Funktion ermittelt zu einer Kontextposition den Inhalt
    * des Contentelemnt. Übergeben wird ein Parameter der Form
    * /site[1]/section[1]/content[1]
    * 
    * @author Martin Grund
    * @param string $context Der Kontext der Position
    * @return string Der Text des Content-Elementes ohne CDATA Tag
    */
    function getContentAtPosition($context)
    {
        return trim($this->stripCdata($this->xPathHandle->getData($context."/data[1]")));
    }
    
    
    /**
    * Funktion entfernt CDATA Tags vom Text
    * @author Martin Grund
    * @param string text Text
    * @param string Text ohne CDATA Tag
    */
    function stripCdata($text)
    {
        $stripCDATA = array("<![CDATA[" => "", "]]>" =>"");
        return strtr($text, $stripCDATA);
    }
       
    
    /**
    * Funktion erstezt bestehenden Inhalt durch neuen Inhalt
    * @author Martin Grund
    * @param string $context Kontext des Inhaltselements
    * @param string $content Inhalt des Elements
    */
    function replaceContent($context, $content)
    {
        
        $result = $this->xPathHandle->replaceData($context."/data[1]", $this->cdataSection($content));
        return $result;
        
    }
    
    /*
    * Diese Funktion fügt inhalt zu einer Sektion hinzu. Dabei müssen verschiedene Fäller unterschieden
    * werden. Es ist noch keine Inhaltselement vorhanden, das Inhaltselement soll als neues erstes Element
    * eingefügt werden und das Element soll an einer beliebigen anderen Position eingefügt werden. Sind schon
    * andere Elemente enthalten werden die neuen Elemente jeweils hinter dem bestehenden einfgefügt
    *
    * @author Martin Grund
    * @param string $context der Kontext der Sektion
    * @param integer $position die Position des Elements
    * @param string $content der Inhalt des Elements
    * @param array $attributes ein Array mit den Attributen des Elements
    */
    function addContent($context, $position , $content, $attributes, $node = null)
    {
        
        if ($node == null)
            //Prepare the new node
            $node = $this->prepareContentNode($content, $attributes);
        
        //if $position=-1 the new Element should be putted on first
        //place or a new element should be inserted. So we have to
        //evaluate first if any content elements exist
        if ($position == -1)
        {
            
            $evaluateContent = $this->xPathHandle->evaluate("content", $context);
            //if $evalutateContent!=empty there exist other content elements
            //so this is the new first one
            if (empty($evaluateContent))
            {
                //There are no other content Elements so we will insert a new one
                $isInserted = $this->xPathHandle->appendChild($context, $node);
                return $isInserted;
                
            } else 
            {
                
                //Threre are other othe CEs, so we will insert a new first one
                $isInserted = $this->xPathHandle->insertChild($context."/content[1]", $node);
                return $isInserted;
                
            }
            
            
        }
        else 
        {
            //Any other postion
            //So we can always append a child by insertChild($ctx, $node, shiftRight=false)
            $isInserted = $this->xPathHandle->insertChild($context."/content[".$position."]", $node, false);
            return $isInserted;
        }
        
        
        
       
        
    }
    
    
    /**
    * This function adds a new section after the pointed node or places the new node inside
    * the pointed node. To decide wich action to do, the variable $type contains the action
    * todo
    *
    * @param    string  $context    Pointer to desired node
    * @param    string  $type       Type of new node (inner/after)
    * @param    array   $attributes Section attribute array
    *
    */
    function addSection($context, $type, $attributes)
    {
        $node = $this->prepareSectionNode($attributes);
        
        if ($type == "inner")
        {
            $isInserted = $this->xPathHandle->appendChild($context, $node);
            return $isInserted;
            
        }
        elseif ($type == "after")
        {
            
            $isInserted = $this->xPathHandle->insertChild($context, $node, false);
            return $isInserted;
            
        } else 
            return false;
    }
    
    
    /**
    * Die Funktion liefert zu einem bestimmten Content Element
    * die Attribute diese zurück
    *
    * @param string $context Der Kontext des Elements
    */
    function getContentAttributes($context)
    {
        //Evaluate attributes part
        $cAttrContext = $this->xPathHandle->evaluate("attributes/*", $context);
        
        if ($cAttrContext != null)
        {
            //Prepare the attribute array
            $attributes = array();
            //Fetch the attributes
            foreach ($cAttrContext as $cAttr) {
                $attributes[$this->xPathHandle->nodeName($cAttr)]=$this->xPathHandle->getData($cAttr);
            }
            
            return $attributes;
            
        } else 
        {
            return false;
        }
    }
    
    /**
    * Die Funktion liefert zu einer bestimmten Section
    * die Attribute dieser zurück
    *
    * @param string $context Der Kontext des Elements
    */
    function getSectionAttributes($context)
    {
        //Evaluate attributes part
        $cAttrContext = $this->xPathHandle->evaluate("attributes/*", $context);
        
        if ($cAttrContext != null)
        {
            //Prepare the attribute array
            $attributes = array();
            //Fetch the attributes
            foreach ($cAttrContext as $cAttr) {
                $attributes[$this->xPathHandle->nodeName($cAttr)]=$this->xPathHandle->getData($cAttr);
            }
            
            return $attributes;
            
        } else 
        {
            return false;
        }
    }
    
    /**
    * Funktion zum Editieren der Attribute der Section, vorhandene Attribute werden gelöscht
    * und durch die neuen Attribute überschrieben. In dem Array der Attribute müssen alle Attribute
    * die die Section bestimmen enthalten sein
    *
    * @author Martin Grund
    * @param string $context Der Kontext der Section
    * @param array $attributes Die Attribute der Sektion
    * @return boolean TRUE wenn alles ok, sonst FALSE
    */
    function editSectionAttributes($context, $attributes)
    {
        //Attribute in Section einfügen
        //We will first try to replace data if this fails we will insert node
        //by fetching the subsec between $attributes and current attributes we will know wich attributes
        //to delete
        
        $keysCurrent = array_keys($this->getSectionAttributes($context));
        $keysNew = array_keys($attributes);
     
        //$attributesToDelete = array_diff($keysCurrent, $keysNew);
        $attributesToDelete = $keysCurrent;
        
        //Delete Attributes
        foreach ($attributesToDelete as $attr) {
            
            $delete = $this->xPathHandle->removeChild($context."/attributes[1]/".$attr."[1]");
            	
        }
        
        //Replace other Attributes
        foreach ($attributes as $key => $attr) {
        	
            $node = "<$key>$attr</$key>";
            $replace = $this->xPathHandle->appendChild($context."/attributes[1]", $node);
            
        }
        
        
        if ($delete == true && $replace == true)
            return true;
        else    
            return false;
        
    }
    
    
    /**
    * Funktion zum Editieren der Attribute des Content Elements, vorhandene Attribute werden gelöscht
    * und durch die neuen Attribute überschrieben. In dem Array der Attribute müssen alle Attribute
    * die das CE bestimmen enthalten sein
    *
    * @author Martin Grund
    * @param string $context Der Kontext des CE
    * @param array $attributes Die Attribute deS CE
    * @return boolean TRUE wenn alles ok, sonst FALSE
    */
    function editContentAttributes($context, $attributes)
    {
        //Attribute in Section einfügen
        //We will first try to replace data if this fails we will insert node
        //by fetching the subsec between $attributes and current attributes we will know wich attributes
        //to delete
        
        $keysCurrent = array_keys($this->getContentAttributes($context));
        $keysNew = array_keys($attributes);
     
        //$attributesToDelete = array_diff($keysCurrent, $keysNew);
        $attributesToDelete = $keysCurrent;
        
        //Delete Attributes
        foreach ($attributesToDelete as $attr) {
            
            $delete = $this->xPathHandle->removeChild($context."/attributes[1]/".$attr."[1]");
            	
        }
        
        //Replace other Attributes
        foreach ($attributes as $key => $attr) {
        	
            $node = "<$key>$attr</$key>";
            $replace = $this->xPathHandle->appendChild($context."/attributes[1]", $node);
            
        }
        
        
        if ($delete == true && $replace == true)
            return true;
        else    
            return false;
    }
    
    /**
    * Abspeichern des Inhaltes der im Speicher liegenden XML Datei
    * 
    * @author Martin Grund
    * @return Boolean Endzustand
    */
    function saveXML($beautify = 1)
    {
        require_once($this->miplexConfiguration->miplexDir."BeautifyXML.class.php");
        
        $bea = new BeautifyXML();
        
        $xml = $this->xPathHandle->exportAsXml();
        //Reformat XML
        $xml = $bea->formatXML($xml);
        
        $hFile = fopen($this->miplexConfiguration->contentDir.$this->miplexConfiguration->contentFileName, "w");
        
        $cnt = fwrite($hFile, $xml);
        
        if ($cnt > 0 )
            return true;
        else 
            return false;
        
        
    }
    
    /**
    * Funktion zum Abspeichern der Änderungen an der XML Datei
    * Danach wird die Seite neu geladen und zur Verfügung gestellt.
    *
    * @author Martin Grund
    * @return array Seitenstruktur
    */
    function saveXMLAndReloadSiteStructure()
    {
        if ($this->saveXML())
        {
            $site = $this->getSiteStructure();
            if ($site != false)
                return $site;
            else 
                return false;
        } else 
            return false;
    }
    
    /**
    * Function adds CDATA Tags to the text
    * @param String $strin Text
    * @return String Text with CDATA Tags
    */
    function cdataSection($string)
    {
        return "<![CDATA[$string]]>";
    }
    
    
    /**
    * Diese Funktion ermittelt zu einem Pfad den korrekten Kontext
    * @param String $path Der Pfad in Sektionen
    * @return String Der korrekt Kontext
    */
    function getContextFromPath($path)
    {
        
        $tmpPath = explode("/", $path);
        $tmpPath = array_reverse($tmpPath);
        $returnContext = "/site[1]";
        
        $error = false;
        while (!empty($tmpPath) && $error != true)
        {
            //get Section from first level
            $tmpSection = $this->xPathHandle->evaluate("section", $returnContext);
            //Whats the alias
            $alias = array_pop($tmpPath);
            //check the correct alias    
            foreach ($tmpSection as $se) {
                
                $tmp = $this->getSection($se);
                //If correct found set new context
            	if ($tmp->attributes['alias']==$alias)
            	   $returnContext = $se;
            }
            
        }
        
        return $returnContext;
    }
    
    
    /**
    * This Funcion edits a content element in the desired context.
    * The content is replaced and the attributes are changed.
    * @param string $context Context
    * @param string $content Content for CE
    * @param array $attributes Array of Attributes
    */
    function editContentElement($context, $content, $attributes, $save = 1)
    {
        
        $this->replaceContent($context, wordwrap($content));
        $this->editContentAttributes($context, $attributes);
        
        if ($save == 1)
        {
            $this->saveXMLAndReloadSiteStructure();
        }
        
    }
    
    /**
    * Erzeugt aus dem Content und den Attributen, die als Parameter übergeben werden,
    * einen XML String, der später in die Datei eingefügt werden kann.
    * @param String $content Der Inhalt des Content Bereichs
    * @param Array $attributes Die Attribute der Content Section
    */
    function prepareContentNode($content, $attributes)
    {
        
        $node = "<content><attributes>";
        foreach ($attributes as $key => $val) {
        	$node.="<$key>$val</$key>";
        }
        $node.="</attributes><data>".$this->cdataSection($content)."</data></content>";
        
        return $node;
        
    }
    
    /**
    * Funktion analaog zu prepareContentNode
    * @see prepareContentNode
    */
    function prepareSectionNode($attributes)
    {
        $node = "<section>";
        $node.="<attributes>";
        foreach ($attributes as $key => $val) {
            $node.="<$key>$val</$key>";        	
        }
        
        $node.="</attributes></section>";
        return $node;
    }
    
    /**
    * This functio removes a special Child element given by special context
    * It doesnt matter if the givven context points to a content element or
    * a section.
    *
    * @param String $context Context of Child Element
    */
    function removeChild($context)
    {
        
        return $this->xPathHandle->removeChild($context);
        
    }
    
    /**
    * This function moves a node from the xml file one step in the desired direction
    * If the direction is -1, then the function is called again with the node beyond and
    * the direction 1. If there is only one node in the context, then nothing is done.
    *
    * @param String     $context    The Context of the element to move
    * @param Integer    $direction  The Direction to move the element 
    * @return Boolean   TRUE if everything went done, FALSE if not
    */
    function moveContent($context, $direction)
    {
        
        //check if given contex is correct
        $evalOriginalNode = $this->xPathHandle->evaluate($context);
        if (!empty($evalOriginalNode))
        {
        
            //We will extract the element id from context
            $tmpContext = explode("/", $context);
            //Retreive last element
            $element = array_pop($tmpContext);
            $regexp = '/\[([0-9]*)\]/';
            //fetch element id
            preg_match($regexp, $element, $match);
            $elementId = $match[1];
            
            //direction descision
            if ($direction == -1)
            {
                //Turn Direction and call again
                //element beyond
                
                $tmpContext = explode("/", $context);
                $elementBeyond = $tmpContext[count($tmpContext)-1];
                $elementBeyond = preg_replace($regexp, "[".($elementId+1)."]", $element);
                $tmpContext[count($tmpContext)-1]=$elementBeyond;
                $contextBeyond = join("/", $tmpContext);
                
                return $this->moveContent($contextBeyond, 1);
                
            } else 
            {
                //Extract the node we will move
                $nodeToMove = $this->xPathHandle->getNode($context);
                
                //check if there is a node above
                //replace Element id in last part
                $tmpContext = explode("/", $context);
                
                $element = $tmpContext[count($tmpContext)-1];
                
                $element = preg_replace($regexp, "[".($elementId-1)."]", $element);
                $tmpContext[count($tmpContext)-1]=$element;
                
                //The node abobe
                $contextAbove = join("/", $tmpContext);
                $evalResult = $this->xPathHandle->evaluate($contextAbove);
                
                //if result is not empty we can go further
                if (!empty($evalResult))
                {
                    
                    $insertPos = $elementId > 2 ? $elementId -2: -1;
                    //Delete
                    $returnDelete = $this->xPathHandle->removeChild($context);
                    //Now we can inseert a node after the second element above
                    $returnInsert = $this->xPathHandle->insertBefore($contextAbove, $nodeToMove);
                    
                    if (!empty($returnInsert) && !empty($returnDelete))
                        return true;
                    else 
                        return false;
                    
                    
                } else 
                    //there is no node above
                    return false;
                
            }
            
        } else 
            return false;
    }
    
}


?>
