<?php

class preisliste extends Extension 
{
    var $urlbase;
    var $name;
    var $groups;
    var $elemente = array();
    var $title;
    var $subject;
    var $author;
    
	/**
	* Gibt die formatierte Liste mit dem angeforderten Name als PDF zur�ck.
	* 
	* St��t Dateitransfer an (wie auch immer, das gehen wird)
	*/    
    function _pdfAusgeben()
    {
		require_once("ext/preisliste/myFpdf.class.php");
		
		// Instanz erzeugen ( Hochformat DinA4, Angaben in milimeter) 
		$pdf=new myFpdf('P','mm','A4');
		
		// Stammdaten festlegen
		$pdf->SetTitle($this->title);
		$pdf->SetAuthor($this->author);
		$pdf->SetSubject($this->subject);
		$pdf->SetCreator('FPDF Version 1.52');

    	global $REQUEST_URI;            
        $url = explode("/", $REQUEST_URI);
        array_pop($url);
        $pdf->SetUrl($this->config->server.implode("/", $url).".html");
		
		
		// Definieren des Platzhalters f�r die Seitenanzahl
		$pdf->AliasNbPages();
		// eine Seite erzeugen
		$pdf->AddPage();
		
		// Zeige Titel der Liste an
		$pdf->PutTitle();

		// durchlaufe alle Elemente und zeige die entsprechenden Dinge an
		print_r ($this->elemente);
		foreach ($this->elemente as $maingroupname => $maingroup) 
		{
			$pdf->PutSubtitle($maingroupname);
			
			foreach($maingroup as $grouporspecial)
			{
				if ($grouporspecial['typ'] == 'special')
				{
					// Special ausgeben
					$pdf->Special($grouporspecial['title'], $grouporspecial['text']);
				}
				elseif ($grouporspecial['typ'] == 'anotation')
				{
					// Anmerkung ausgeben
					$pdf->Anotation($grouporspecial['title'], $grouporspecial['text']);
				}
				else 
				{
					// Gruppen ausgeben

					// Gruppenname ausgeben
						$pdf->PutSubSubtitle($grouporspecial['name']);
					// Tabelle ausgeben
						$pdf->FancyTable($grouporspecial['positions']);
				}
			}
		}


    // Kontaktinformationen anf�gen
		$pdf->addPage();
        $pdf->PutSubtitle("Kontaktinformationen");

        $pagecount = $pdf->setSourceFile("ext/preisliste/kontakt.pdf");
		$tplidx = $pdf->ImportPage(1);
		$pdf->useTemplate($tplidx);
		
		
		$filename = explode("/", $REQUEST_URI);
		$filename = explode(".", $filename[sizeof($filename)-1]);
		array_pop($filename);
		$filename = implode(".", $filename).".pdf";
		// Und das ganze als 'bootshaus.pdf' an den Browser senden zum Speichern
		$pdf->CleanOutput($filename, 'D');
		
    }
    
	/**
	* Gibt die formatierte Liste mit dem angeforderten Name als HTML zur�ck.
	*
	* @return string
	*/    
    function _htmlAusgeben()
    {
//    	print_r($this->elemente);
    	
  		$this->smarty->assign("elemente", $this->elemente);  	
        return $this->smarty->fetch('../ext/preisliste/tpl/allg.tpl');
    }

    function _datenLesen()
    {
        $this->xpath = new xpath("ext/preisliste/preise.xml");

        // Urspung f�r mich finden
        $res = $this->xpath->evaluate("/prices/list[@name='".$this->name."']");
        $this->basepath = $res[0];
        
        $attr = $this->xpath->getAttributes($this->basepath);
        
        $this->author = $attr['author'];
        $this->title = $attr['title'];
        $this->subject = $attr['subject'];
        
        
        // Alle Specials und Gruppen finden
        $res = $this->xpath->evaluate($this->basepath."/*");
        
        foreach ($res as $majorgroup) {
        	$major = $this->xpath->evaluate($majorgroup."/*");
        	
        	$attr = $this->xpath->getAttributes($majorgroup);
        	
        	$name = $attr['name'];
        	
        	$KindervonMajorgroupX = array();
       
	        foreach ($major as $key => $teil)
	        {
	        	$teile = explode("/", $teil);
	
	        	$element = array();
	
	        	// Bestimmen des Elements
	        	if (preg_match("/special\[[0-9]*\]/i", $teile[sizeof($teile)-1])) {
	    			$element['typ'] = "special";
	    			// Title und Text einlesen
	    			$element['title'] = $this->xpath->getData($teil."/title");
	    			$element['text'] = $this->xpath->getData($teil."/text");
	        	}
	        	elseif (preg_match("/anotation\[[0-9]*\]/i", $teile[sizeof($teile)-1])) {
	    			$element['typ'] = "anotation";
	    			// Title und Text einlesen
	    			$attr = $this->xpath->getAttributes($teil);
	    			$element['title'] =$attr['name'];
	    			$element['text'] =  str_replace("\\n", "\n", $this->xpath->getData($teil));
	        	}
	        	else {
	        		$element['typ'] = "group";
	        		
	        		// Bestimme Name dieser Gruppe
	        		$attr = $this->xpath->getAttributes($teil);
	        		$element['name'] = $attr['name'];
	        		
	        		// Alle Positionen einlesen
	        		$positionen = array();
	        		
	        		$positionPfade = $this->xpath->evaluate($teil."/position");
	        		
	        		foreach ($positionPfade as $nr => $position)
	        		{
	        			$pos['desc'] = $this->xpath->getData($position."/desc");
	        			$pos['price'] = number_format($this->xpath->getData($position."/price"), 2, ",", ".")." �";
	        			
	        			array_push($positionen, $pos);
	        		}
	        		
	        		$element['positions'] = $positionen;
	        	}
	    		array_push($KindervonMajorgroupX, $element);
	        }
        	$this->elemente[$name] = $KindervonMajorgroupX;
        }
    }

    function main($params)
    {
        global $session;
        global $REQUEST_URI;
        
        $this->urlbase = $session->currentPage->config->docroot.$session->currentPage->config->baseName."/".$session->currentPage->path;
        
        // Wenn kein Parameter aus dem Extensionaufruf mitkommt, breche ich gleich ab.
        if (strlen ($params['name']) > 1) 
            $this->name = $params['name'];
        else
            return $this->smarty->fetch('preiliste/tpl/noname.tpl');
            
        // Preisliste einlesen
        $this->_datenLesen();
        
        $tmp = explode(".", $REQUEST_URI);

        if (!strcasecmp("pdf", $tmp[sizeof($tmp)-1]))
            return $this->_pdfAusgeben();
        else
            return $this->_htmlAusgeben();
    }

    function getBackend()
    {
    	if (strlen($_POST['content']) > 0)
    	{
    		if (!$file = fopen("ext/preisliste/preise.xml", "w"))
    		{
    			$this->smarty->assign("msg", "Kann Datei nicht �ffnen.");
    		}
    		elseif (!fwrite($file, stripslashes($_POST['content'])) )
    		{
    			$this->smarty->assign("msg", "Kann Datei nicht schreiben.");
    		}
    		else 
    		{
    			$this->smarty->assign("msg", "�nderungen gespeichert.");
    			fclose($file);
    			global $clear_cache; $clear_cache = true;
    		}
    	}
    	
    	$this->smarty->assign("content", file_get_contents("ext/preisliste/preise.xml"));
        return $this->smarty->fetch('preisliste/admin/main.tpl');
    }
}
?>