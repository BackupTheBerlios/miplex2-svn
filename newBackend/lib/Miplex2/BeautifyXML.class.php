<?php

/**
* This class formats a given XML String by evaluating
* the tags so it looks good
* @author Martin Grund <grund@miplex.de> 
*
*/
class BeautifyXML
{
    
    var $inputFile;
    var $inputString;
    var $outputString;
    var $outputFile;
    var $indent; 
    
    /**
    * Constructor of this class
    * @author Martin Grund
    * @param Integer $nr Number of Spaces to indent
    *
    */
    function BeautifyXML($nr = 4)
    {
        $this->indent = $nr;
    }
    
    /**
    * The main Method of this class. It is called to 
    * start the formatting of the given XML String
    * @retrun String 
    *
    */
    function processXML()
    {
        
        $input = $this->inputString;
        
        //Clear all Spaces, Newlines and Tabs and so on...
        $tmpString = explode("\n", $input);
        $tmpString2 = "";
        
        foreach ($tmpString as $line) {
            
            if (isset($line{strlen($line)-1}) && $line{strlen($line)-1} == ">")
                $tmpString2.= trim($line);
            else 
                $tmpString2.= ltrim($line)."\n";
            
        }
        
        $input = $tmpString2;
        
        //Now put all Tags in one Array Element
        $input = preg_replace("/\>\</", ">\n<", $input);
        
        $tagArray = explode("\n", $input);
        
        //Now we have to go through the array and take every item and put it correct into the output
        $depth = 0;
        $output = "";
        foreach ($tagArray as $item) {
            
            
            switch ($this->evalTagType($item)) {
                
                case "OPEN":
                
                    $output.=$this->indent($depth*$this->indent).$item."\n";
                    $depth++;
                    
                    break;
                    
                case "CLOSE":
                
                    $depth--;
                    $output.=$this->indent($depth*$this->indent).$item."\n";
                
                    break;
                 
                case "OPENCLOSE":
                
                    $output.=$this->indent($depth*$this->indent).$item."\n";
                
                    break;
                
                case "HEADER":
                
                    $output.=$this->indent($depth*$this->indent).$item."\n";
                
                    break;
                
                case "COMMENT":
                
                    $output.=$this->indent($depth*$this->indent).$item."\n";
                
                    break;
               
                case "EMPTY":
                
                    $output.=$this->indent($depth*$this->indent).$item."\n";
                
                    break;
                    
                case "CDATA":
                
                    $output.=$this->indent($depth*$this->indent).$item."\n";
                
                    break;
                    
                case "NOTEXT":
                
                    break;
                
                default:
                    $output.=$this->indent($depth*$this->indent).$item."\n";
                    break;
            }
            
            
        }
        
       return $output; 
        
    }
    
    /**
    * This method returns $int number of spaces
    * @param Integer $int Number of Spaces
    * @return String 
    *
    */
    function indent($int)
    {
        $int = is_int($int) && $int >= 0 ? $int : 0;
        return str_repeat(" ", $int);
    }
    
    /**
    * This method evaluates the tag type, if it is an open, close or both or an empty tag
    * @param String $item The line to pare
    * @return String Keyword 
    *
    */
    function evalTagType($item)
    {
        //We have to differ between
        //open, close, Header, CDATA, openclose, empty
        
        //get Tag name
        preg_match_all("/<(\/*)([A-Za-z0-9]*)(\/*)>/i", $item, $matches);
        
        if (empty($matches[1][0]) && empty($matches[3][0]) && !empty($matches[2][0]) && count($matches[2])== 1)
        {
            //open Tag
            return "OPEN";
            
        } elseif (isset($matches[1][0]) && $matches[1][0] == "/" && count($matches[2])== 1)
        {
            return "CLOSE";
            
        } elseif (isset($matches[3][0]) && $matches[3][0] == "/" && count($matches[2])== 1)
        {
            return "EMPTY";
            
        } elseif (count($matches[2]) == 2 && !empty($matches[2][0]))
        {
            return "OPENCLOSE";
        }
        
        
        //All standard Tags done, proceed with none standard
        //Check CDATA
        if (preg_match("/^<!\[CDATA\[(.*)\]>/i", $item))
        {
            return "CDATA";
        }
        
        if (preg_match("/^<\?xml/i", $item))
        {
            return "HEADER";
        }
        
        if (preg_match("/<!--(.*)-->/", $item))
        {
            return "COMMENT";
        }
        
        if (empty($item))
            return "NOTEXT";
        
    }
    
    /**
    * Dummy Method for $this->processXML, the input is given as a parameter
    * @param String $input XML Input
    * @return String Formatted XML
    *
    */
    function formatXML($input)
    {
        $this->inputString = $input;
        
        return $this->processXML();
    }
    
    
    
}


?>