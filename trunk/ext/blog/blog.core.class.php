<?php
/*
  This is an XML based Weblog Library to add weblog functionality to your website.
  Copyright (C) 2004  Martin Grund

  This library is free software; you can redistribute it and/or
  modify it under the terms of the GNU Lesser General Public
  License as published by the Free Software Foundation; either
  version 2.1 of the License, or (at your option) any later version.

  This library is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
  Lesser General Public License for more details.

  You should have received a copy of the GNU Lesser General Public
  License along with this library; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

  Private Funktionen
  ------------------
  
  String stripCdata(string $string) 
  Nimmt einen String auf und entfernt daraus das umschließende CDATA Tag
  
  bool checkDate() - Überprüft einen String, ob es ein korrektes Datum ist
  
  Öffentliche Funktionen
  ----------------------
  
  array getEntryBydate() - Liefert alle Entries zu einem Datum

  array getEtnryByNumberOrContext() - Liefert alle Einträge passend zu genau einer Nummer oder Kontext

  array getEntry() - Liefert alle Einträg z.B. ab einem Startwert und eine bestimmte Anzahl

  array getCategories() - Liefert alle verwendeten Kategorien

  array getEntryByCategory() - Lifert einen Eintrag passend zu einer Kategorie

  bool addEntry() - Einen Eintrag zinzufügen

  bool addComment() - Ein Kommentar hinzufügen


*/


    class weblog
    {
        //Handle auf XML Object
        var $xclass;
        //Handle auf dei XML Datei
        var $xmlfile;
        var $error;
        
        
        ###########################################################################################
        function stripCdata($string)
        {
        	$stripCDATA = array("<![CDATA[" => "", "]]>" =>"");
            $teasertext = strtr($string, $stripCDATA);
            return $teasertext;
        }
        
        /**
        * Funktion prüft Datum auf korrekte Eingabe
        * @param date $date Eingabedatum (Format: mm-dd-yyyy)
        * @return bool
        */
        function checkDate($date)
        {
            $dateArray = explode("-", $date);

            //print_r($dateArray);

            //Algemeine Überprüfung
            if (count($dateArray)!=3)
                return FALSE;

            //Überprüfen des Monats
            if (!is_int($dateArray[0]) || $dateArray[0] < 1 || $dateArray[0] > 12)
                //return FALSE;

            if (!is_int($dateArray[1]) || $dateArray[1] < 1 || $dateArray[1] > 31)
                //return FALSE;

            if (!is_int($dateArray[2]) || $dateArray[2] < 1900 || $dateArray[2] > 3000);
                //return FALSE;
            
            return TRUE;

        }

        /**
        Funktion zum Sortieren eines multidimensionalen Arrays
        */
        function array_csort() {  //coded by Ichier2003
    	   $args = func_get_args();
    	   $marray = array_shift($args);
    	
    	   $msortline = "return(array_multisort(";
    	   foreach ($args as $arg) {
    	       $i++;
    	       if (is_string($arg)) {
    	           foreach ($marray as $row) {
    	               $sortarr[$i][] = $row[$arg];
    	           }
    	       } else {
    	           $sortarr[$i] = $arg;
    	       }
    	       $msortline .= "\$sortarr[".$i."],";
    	   }
    	   $msortline .= "\$marray));";
    	
    	   eval($msortline);
    	   return $marray;
    	}


        ###########################################################################################
        /**
        * CONSTRUCTOR
        * Erzeugen des XML Object
        * registrieren der Variablen
        */
        function weblog($xmlfile, $xclass, $lang = "de")
        {
            
            if (is_file("ext/blog2/lang/$lang.inc.php"))
            {
                include_once("ext/blog/lang/$lang.inc.php");
            }

            $this->xmlfile = $xmlfile;
            $this->xclass = $xclass;
        	
            $this->xclass->reset();
            $this->xclass->importFromFile($xmlfile);
        	
        }
       
        /**
        * Alle Einträge von bis
        * @param date $von Startdatum
        * @param date $bis="" Enddatum standardmäßig leer
        * @return array $dateEntries Die passenden Einträge zur Abfrage
        */
        function getEntryByDate($von, $bis="", $onlyStart=true ,$count=-1)
        {
            //Überprüfen der Daten
            if ($onlyStart == TRUE)
            {
                if ($this->checkDate($von))
                {
                    $dateEval = $this->xclass->evaluate("/weblog/entry[@date='$von']");
                    
                    for ($i = 0; $i < count($dateEval) ; $i++)
                    {
                        $dateEntries[] = $this->getEntryByNumberOrContext($dateEval[$i]);
                    }
                    
                    return $dateEntries;

                } else
                {
                	$this->error = NO_VALID_PARAM;
                	return false;
                }
            }

        }
        
        /**
        * Gibt eintrag mit bestimmter Nummer Zurück
        * Sinnvoll wäre eine alternative Übergabe des passenden Kontextes
        * @param int $number Die Nummer des Eintrages innerhalb des XML Files /weblog[1]/entry[1..n]
        */
        function getEntryByNumberOrContext($number)
        {
        	if (is_int($number))
        	{
                $evalResult = $this->xclass->evaluate("/weblog/entry");
                $evalContext = $evalResult[$number];
            } else if (is_string($number))
            {
            	//Laden des Kontext
            	$evalContext = $number;
            } else
            {
            	$this->error = NO_VALID_PARAM;
            	return FALSE;
            }

        	//Wenn es einen Eintrag gibt auswerten
        	if (!empty($evalContext))
        	{
        		//Attribute auswerten
        		$returnArray = array();
        		$returnArray['attributes'] = $this->xclass->getAttributes($evalContext);
        		$returnArray['context'] = $evalContext;
        		$returnArray['number'] = $evalContext{strlen($evalContext)-2};

                //Teaser auswerten
                $resTeaser = $this->xclass->evaluate($evalContext."/header[1]/teaser[1]");

                $returnArray['teaser'] = stripslashes($this->stripCdata($this->xclass->getData($resTeaser[0])));
                
                //Body auslesen
                //$resBody = $this->xclass->evaluate("/weblog/entry[@id='$number']/header/body");
                $resBody = $this->xclass->evaluate($evalContext."/header[1]/body[1]");
                $returnArray['body'] = stripslashes($this->stripCdata($this->xclass->getData($resBody[0])));

                //Nun alle Kommentare hintenanhängen
                $resComments = $this->xclass->evaluate($evalContext."/comments[1]/commententry");
                $numberOfComments = count($resComments)>0?count($resComments):0;
                
                $returnArray['numberOfComments'] = $numberOfComments;
                for ($i = 0; $i < count($resComments); $i++)
                {
                    //Attribute des Kommentars auslesen und Ihanlt auslesen
                    $commentArray['attributes']=$this->xclass->getAttributes($resComments[$i]);
                    $commentArray['content']= $this->stripCdata($this->xclass->getData($resComments[$i]));
                    $returnArray['comments'][]= $commentArray;
                    //echo $this->stripCdata($this->xclass->getData($resComments[$i]));
                }

        		
        		return $returnArray;

        	} else
            {
            	//Konnte kein Ergebnis gefunden werden.
            	$this->error=NO_ENTRY_FOUND;
            	return FALSE;

            }

        }
        
        /**
        * Gibt anzahl von Einträgen zurück
        * @param int count = -1 --> alle Einträge
        * @param int count = int --> Anzahl der Einträge
        * @param int start --> Startwert
        *
        * Wenn count von start länger als Array, wird bis ende gemacht
        */
        function getEntry( $start=0 , $count=-1)
        {
            $evalResult = $this->xclass->evaluate("/weblog/entry");

            if (!empty($evalResult))
            
            {
                //Wenn alle angezeigt werden sollen, dann anzahl bestimmen
            	  $count = $count < 0 ? count($evalResult):$count;
            	  //Wenn count größer als Anzahl, dann auf das richtige begrenzen
            	  $count = $count > count($evalResult)?count($evalResult):$count;
            	  //Start kleiner 0
            	  $start = $start < 0 ? 0:$start;

                for ($i = $start; $i < $count ; $i++)
                {

                    //Alle Ausgeben, die benötigt ==> Achtung Problem mit 0 und 1 Start des Arrays
                    $returnArray[]=$this->getEntryByNumberOrContext($i);
                }

                return $returnArray;
            } else
            {
                $this->error=NO_ENTRY_FOUND;
                return FALSE;
            }
        }

        /**
      	* Funktion zum Speichern eines Kommentars
      	* TODO Überpüfen der Position der Kommentare
      	* @param int $numberOfEntry Die Nummer des Eintrages oder der Kontext
      	* @param array $commentArray Das Array mit allen wichtigen Werten des Kommentars
      	*    - author, date, mail, content
      	*/
      	function addComment($numberOfEntry, $commentArray)
      	{

      		if ((is_array($commentArray)))
      		{
      			if (is_int($numberOfEntry))
      			{
      			    $numberOfEntry++;
      			    $context = "/weblog[1]/entry[$numberOfEntry]/comments[1]/commententry";
      			    
      			} else 
      			   $context = $numberOfEntry."/comments[1]/commententry";

      			
      			   
      			//XML String bauen
      			$author = $commentArray['author'];
      			$date = $commentArray['date'];
      			$mail = $commentArray['mail'];
      			$content = $commentArray['content'];
      			$www = $commentArray['www'];
      			$notify = $commentArray['notify'];

      			$newXmlString = "\n\n        <commententry author='$author' date='$date' mail='$mail' www='$www' notify='$notify'>\n            <![CDATA[$content]]>\n        </commententry>\n\n";

      			$evalComments = $this->xclass->evaluate($context);
      			

      			if (empty($evalComments))
      			{
      				
      			    //kein Kommentar bis jetzt
      				//$evalComments = $this->xclass->evaluate($context);
      				$contextNew = preg_replace("/\/commententry/","", $context);
      				//$res = $this->xclass->appendData($evalComments[0], $newXmlString );
                    $res = $this->xclass->appendData($contextNew, $newXmlString );
                    if ($res == false)
                    {
                    	$this->error = NO_INSERT_COMMENT;
                    	return false;
                    }


      			} else
      			{
                    //Neuen Kommentar ganz hinten anfügen
                    
      			    $this->xclass->insertChild($evalComments[count($evalComments)-1],$newXmlString, false);
      			}

                $file =  $this->xclass->exportAsXML();
                
                
                if ($fid = fopen($this->xmlfile,"w"))
                {
                    if (!fwrite($fid, $file ))
                    {
                        $this->error = NO_WRITE_FILE;
                        return false;
                    }
                }
                
                return true;


      		} else
            {
            	$this->error = NO_VALID_PARAM;
            	return FALSE;
            }
    

        }

  	    /**
  	    * Funktion zum hinzufügen von Einträgen in das Blog
  	    * @param array entryArray array mit allen Informationen
  	    * - attributes -> author, mail, date, category...
  	    * - teaser, body
  	    */
  	    function addEntry($entryArray)
  	    {
            $attributes = $entryArray['attributes'];

            $xmlEntry ="\n\n    <entry />\n";
            $xmlHeader="\n    <header>\n        <teaser>\n            <![CDATA[".$entryArray['teaser']."]]>\n        </teaser>\n        <body>\n            <![CDATA[".$entryArray['body']."]]>\n        </body>\n    </header>\n    <comments />\n";
            
            $resEntries = $this->xclass->evaluate("/weblog[1]/entry");
            $this->xclass->insertChild($resEntries[count($resEntries)-1], $xmlEntry, false);
            
            $resEntries = $this->xclass->evaluate("/weblog[1]/entry");
            $this->xclass->setAttributes($resEntries[count($resEntries)-1], $attributes);
            $this->xclass->appendData($resEntries[count($resEntries)-1], $xmlHeader);
            
            $file =  $this->xclass->exportAsXML();
            

            if ($fid = fopen($this->xmlfile,"w"))
            {
                if (!fwrite($fid, $file ))
                {
                    $this->error = NO_WRITE_FILE;
                    return false;
                }
            }
            
            //unlink("index.xml");
            return true;

  	    }
  	    
  	    /**
  	    * Dies Funktion gibt zu den Einrägen alle verwendeten Kategorien zurück
  	    * Funktionalität ist fraglich, da ja nict alle Kategorien benutzt werden müssen
  	    */
  	    function getCategories()
  	    {
  	    	$xQuery = "/weblog/entry";
  	    	$catResult = $this->xclass->evaluate();
  	    	
  	    	return $catResult;
  	    }
  	    
  	    
  	    /**
        * Diese Funktion gibt zum übergenen Namen der kategorie die passenden Einträge im Weblog zurük
        * @param string $catName Der Name der gesuchten Kategorie
        * @return array catEntries Die gefundenn Einträge im Weblog
        */
        function getEntryByCategory($catName)
        {
        	$xQuery = "/weblog/entry[@category='$catName']";
        	
        	
        	//Auswerten des Ausdrucks
        	$catEval = $this->xclass->evaluate($xQuery);
        	
        	
        	if (!empty($catEval))
        	{
        		//Alle gefundenn Auswerten
        		for ($i = 0; $i < count($catEval); $i++)
                {
                	$catEntries[] = $this->getEntryByNumberOrContext($catEval[$i]);
                }

                return $catEntries;

        	} else {

                $this->error = NO_ENTRY_FOUND;
                return FALSE;
        	}
        }
        
        /**
        * Gibt die Anzahl der Einträge zurück
        * @return int Anzahl
        */
        function countEntries()
        {
            $evalResult = $this->xclass->evaluate("/weblog/entry");
            return count($evalResult);
        }
        
        /**
        * Gibt die letzten x Einträge des Weblogs aus
        * @param int $count Anzahl
        * @return array 
        */
        function getLastXEntries($count)
        {
            
            $returnArray = $this->getEntry($this->countEntries()-$count);
            
            $returnArray = array_reverse($returnArray);
            
            return $returnArray;
        }
        
        
        /**
        * Funktione die die aktivsten Einträge anzeigt
        * @param int $atLease Mindestanzahl der Kommentare
        * @param int $maxDisplay Zeige maximal X Einträge
        */
        function getMostActiveEntries($atLeast = 3, $maxDisplay = 5)
        {
            $Entries = $this->xclass->evaluate("/weblog/entry/comments[count(*)>=$atLeast]");
            
            //Alle Einträge mit mehr als x Kommentaren erfasst
            foreach ($Entries as $entry)
            {
                $parts = explode("/", $entry);
                $newContext = "/".$parts[1]."/".$parts[2];
                
                $entryArray = $this->getEntryByNumberOrContext($newContext);
                $returnArray[] = $entryArray;
            }
            
            return $returnArray;
        }
        
        /**
        * Funktion verschickt nach einem Kommentar wenn gewünscht eine Mail
        *
        */
        function getMailFromBlogEntry($context)
        {
            $entry = $this->getEntryByNumberOrContext($context);
            $mailRegexp = "/[a-zA-z0-9\.\_\-]*@[a-zA-z0-9\.\_\-]{3,}\.[a-zA-z]{2,3}/";
            if (!empty($entry['comments']))
            {
                foreach ($entry['comments'] as $co) {
                	
                    if ($co['attributes']['notify']=='on' && preg_match($mailRegexp, $co['attributes']['mail']))
                    {
                        //Eine Mail schicken
                        $recipients[$co['attributes']['author']]=$co['attributes']['mail'];
                    }
                    
                }
            }
            return $recipients;
        }


    }


?>
