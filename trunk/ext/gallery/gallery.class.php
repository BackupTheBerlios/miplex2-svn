<?php

class gallery extends Extension 
{
    var $stdParams;
    var $dynParams;
    var $urlbase;


    function ausgabeEinzeln()
    {
        // Durchlaufe den Ordner
        $imgDir = opendir($this->stdParams['folder']);

        $out = "";
        
        $gefunden = false;
        
        while (false !== ($file = readdir ($imgDir))) 
        {
            if (($file != ".") && ($file != ".."))// && is_readable($file))
            {
                if ((strpos($file, ".JPG") !== false) || 
                    (strpos($file, ".jpg") !== false) || 
                    (strpos($file, ".PNG") !== false) || 
                    (strpos($file, ".png") !== false))
                {
                    // erstelle Objekt der Klasse Image
                    $img = new Image($this->stdParams['folder'], $file);
                    
                    if ($gefunden)
                    {
                        $weiter = $img->getNumber($this->urlbase);
                        break;
                    }
                    
                    // Ermittle String für Thumb-Anzeige
                    if ($img->getNumber() == $this->dynParams[1])
                    {
                        $out = $img->getImageTag($this->urlbase);
                        $gefunden = true;
                    }

                    if (!$gefunden)
                        $vorher = $img->getNumber($this->urlbase);
                }
            }
        }

        if (strlen($vorher) > 0)
        {
            $this->smarty->assign("zurueckLink", $this->urlbase."/einzel/".$vorher.".html");
        }

        if (strlen($weiter) > 0)
        {
            $this->smarty->assign("vorLink", $this->urlbase."/einzel/".$weiter.".html");
        }

        // out an Smarty-Objekt geben und ausgeben
        $this->smarty->assign("Uebersicht", $this->urlbase."/alle.html");
        $this->smarty->assign("Image", $out);
        $out = $this->smarty->fetch('gallery/tpl/einzeln.tpl');

        return $out;
    }
    
    function ausgabeAlle($anfang = 1, $ende = 0)
    {
        $imgDir = opendir($this->stdParams['folder']);
        
        $i = 1;
        $out = "";

        $Bilder = array();
        
        // Bestimme alle vorhandenen Bilder
        while (false !== ($file = readdir ($imgDir)) && $i > 0) 
        {
            if (($file != ".") && ($file != ".."))// && is_readable($file))
            {
                if ((strpos($file, ".JPG") !== false) || 
                    (strpos($file, ".jpg") !== false) || 
                    (strpos($file, ".PNG") !== false) || 
                    (strpos($file, ".png") !== false))
                {
                    // Merk dir den Dateiname
                    array_push ($Bilder, $file);
                }
            }
        }
        
        // Array sortieren
        sort($Bilder, SORT_STRING);
        
        // Gewünschte Auswahl ausgeben
        $anfang = ($anfang < 1) ? 1 : $anfang;
        $ende = ($ende == 0) ? sizeof($Bilder) : $ende;
        $ende = ($ende > sizeof($Bilder)) ? sizeof($Bilder) : $ende;

        for ($i = $anfang - 1; $i < $ende; $i++)
        {
            $img = new Image($this->stdParams['folder'], $Bilder[$i], $i + 1);
            $out[$i + 1] = $img->getThumbTag($this->urlbase, $this->stdParams['thumbwidth'], $this->stdParams['thumbheight']);
        }
        
        if ($anfang > 1)
        {
            $this->smarty->assign("zurueckLink", $this->urlbase."/alle/".($this->dynParams[1] - 1).".html");
        }

        if ($ende != sizeof($Bilder))            
        {
            $next = (is_null($this->dynParams[1]) ? 2 : $this->dynParams[1] + 1);
            $this->smarty->assign("vorLink", $this->urlbase."/alle/".$next.".html");
        }

        // out an Smarty-Objekt geben und ausgeben
        $this->smarty->assign("Images", $out);
        $out = $this->smarty->fetch('gallery/tpl/alle.tpl');

        return $out;
    }

    function main($params)
    {
        global $session;

        include("ext/gallery/image.class.php");

        // URL-Parameter: $session->currentPage->params) als String
        $this->dynParams = explode("/", $session->currentPage->params);
        
        $this->urlbase = $session->currentPage->config->docroot.$session->currentPage->config->baseName."/".$session->currentPage->path;
        
        // Config-Param.: $this->extConfig["params"]     als Assoziatives Array
        $this->stdParams = $this->extConfig["params"];

        if ($this->dynParams[0] == "einzel")
            return $this->ausgabeEinzeln();
        else
        {
            if (is_numeric($this->dynParams[1]) && ($this->dynParams[1] > 1))
            {
                $start = ($this->dynParams[1]-1) * $this->stdParams["thumbcount"] + 1;
                $ende = $start + $this->stdParams["thumbcount"] - 1;
                return $this->ausgabeAlle($start, $ende);
            }
            else
                return $this->ausgabeAlle(1, $this->stdParams["thumbcount"]);
        }
    }
    
	function _alleBilder()
	{
        $imgDir = opendir($this->stdParams['folder']);
        
        $i = 1;
        $out = "";

        $Bilder = array();
        
        // Bestimme alle vorhandenen Bilder
        while (false !== ($file = readdir ($imgDir)) && $i > 0) 
        {
            if (($file != ".") && ($file != ".."))// && is_readable($file))
            {
                if ((strpos($file, ".JPG") !== false) || 
                    (strpos($file, ".jpg") !== false) || 
                    (strpos($file, ".PNG") !== false) || 
                    (strpos($file, ".png") !== false))
                {
                    // Merk dir den Dateiname
                    array_push ($Bilder, $file);
                }
            }
        }
        
        // Array sortieren
        sort($Bilder, SORT_STRING);
        
        $bilder = array();
        
        include("ext/gallery/image.class.php");

        // Array erzeugen / bearbeiten
        foreach ($Bilder as $Bild)
        {
        	$iBild = new Image($this->stdParams['folder'], $Bild);
        	
        	$bild['name'] = $Bild;
        	$bild['thumb'] = $iBild->getThumbTag("/", $this->stdParams['thumbwidth'], $this->stdParams['thumbwidth'], false);
        	$bild['alt'] = $iBild->alt;
        	$bild['title'] = $iBild->title;
        	$bild['pos'] = $iBild->getNumber();
        	
        	array_push($bilder, $bild);
        }
        
        return $bilder;
	}
    
     
    function getBackend()
    {
        $this->smarty->assign("url", "admin.php?module=ext&amp;id=gallery");
    	$this->smarty->assign("mode", $_GET['mode']);

		$patterns = array('\\', "/", ":", "*", "?", '"', "<", ">", "|", ",");
		$replacements = "";
    	
    	if ($_GET['mode']== 'bilder') 
    	{
			$this->stdParams = $this->extConfig["params"];
    		
    		// Formulare bearbeiten
    		if ($_POST['delete'] && $_POST['name'])
    		{
    			if (file_exists($this->extConfig['params']['folder']."/".$_POST['name']))
    				if (!unlink($this->extConfig['params']['folder']."/".$_POST['name']))
	    				$out .= "<h2>Konnte gewünschtes Bild nicht löschen.</h2><p>Bitte überprüfen Sie, ob Sie die nötigen Dateisystemrechte besitzen.</p>";
	    			else 
	    				$out .= "<p>Das Bild wurde erfolgreich gelöscht.</p>";
    			else
    				$out .= "<h2>Konnte zu löschendes Bild nicht finden.</h2><p>Es ist ein unerwarteter Fehler aufgetreten. Konnte die Datei ".$this->extConfig['params']['folder']."/".$_POST['name']." nicht finden. Bitte versuchen Sie es nochmal.</p>";
    		}
    		
    		if ($_POST['edit'] && $_POST['name'])
    		{
    			// alt, title und pos so bearbeiten, dass es zum Dateinamen werden kann
				$alt = str_replace($patterns, $replacements, stripslashes($_POST['data']['alt']));
				$title = str_replace($patterns, $replacements, stripslashes($_POST['data']['title']));
				$pos = str_replace($patterns, $replacements, stripslashes($_POST['data']['pos']));

    			$type = explode(".", $_POST['name']);
    			$type = $type[sizeof($type)-1];
	    		$size = getimagesize($file);
				
    			if (file_exists($this->extConfig['params']['folder']."/".$_POST['name']))
    				if (!rename($this->extConfig['params']['folder']."/".$_POST['name'], $this->extConfig['params']['folder']."/".$pos.",".$alt.",".$title.".".$type))
	    				$out .= "<h2>Konnte gewünschtes Bild nicht bearbeiten.</h2><p>Bitte überprüfen Sie, ob Sie die nötigen Dateisystemrechte besitzen.</p>";
	    			else 
	    				$out .= "<p>Die Änderungen wurden erfolgreich gespeichert.</p>";
    			else
    				$out .= "<h2>Konnte zu änderndes Bild nicht finden.</h2><p>Es ist ein unerwarteter Fehler aufgetreten. Konnte die Datei ".$this->extConfig['params']['folder']."/".$_POST['name']." nicht finden. Bitte versuchen Sie es nochmal.</p>";
    		}

    		$this->smarty->assign("bilder", $this->_alleBilder());
    	}
		elseif ($_GET['mode'] == 'neu')
    	{
    		global $file_name, $file, $file_size;
			
    		if ($_POST['neu'])
    		{
    			// alt, title und pos so bearbeiten, dass es zum Dateinamen werden kann
				$alt = str_replace($patterns, $replacements, stripslashes($_POST['data']['alt']));
				$title = str_replace($patterns, $replacements, stripslashes($_POST['data']['title']));
				$pos = str_replace($patterns, $replacements, stripslashes($_POST['data']['pos']));

				$bild['title'] = $title;
    			$bild['alt'] = $alt;
    			$bild['pos'] = $pos;
    			
    			$this->smarty->assign("bild", $bild);
    			
    			if ($alt && $title && $pos && !empty($file_name))
	    		{

	    			$type = explode(".", $file_name);
	    			$type = $type[sizeof($type)-1];
		    		$size = getimagesize($file);
					
		    		if ($size[0] <= $this->extConfig['params']['maxwidth'] && $size[1] <= $this->extConfig['params']['maxheight'])
		    		{
		    			if ($type == "jpg" || $type == "png" || $type == "JPG" || $type == "PNG")
		    			{
		    				if (!file_exists($this->extConfig['params'][folder]."/".$pos.",".$alt.",".$title.".".$type))
		    				{
								if(!copy($file, $this->extConfig['params'][folder]."/".$pos.",".$alt.",".$title.".".$type))
									$out .= "<h2>Fehler beim Speichern der Datei.</h2>";
								else 
									$out .= "<p>Das Bild wurde unter dem Namen ".$this->extConfig['params'][folder]."/".$pos.",".$alt.",".$title.".".$type." gespeichert.</p>";
		    				}
							else
			    				$out .= "<h2>Die zu speichernde Datei existiert bereits</h2><p>Der neue Dateiname wird aus den drei Formularfeldern zusammgesetzt. Es existiert bereits eine Datei mit dem generierten Namen. Bitte ändern sie mind. eine der Angaben, so dass das Bild hinzugefügt werden kann.</p>";
		    			}
		    			else 
		    				$out .= "<h2>Die Datei ist vom falschen Typ</h2><p>Für die Galerie können nur Bilder vom Typ \"*.jpg\" und \"*.png\" verarbeitet werden.</p>";
		    		}
		    		else 
		    			$out .= "<h2>Die Dimensionen des Bildes sind zu groß</h2><p>Das Bild überschreitet die maximale Breite oder Höhe, die für diese Galerie festegelegt wurde. Verkleinern Sie das Bild, damit es in die Gallerie aufgenommen werden kann, oder ändern Sie die Parameter in den Allgemeinen Einstellungen. Bedenken Sie, dass zu große Bilder eventuell nicht korrekt dargestellt werden können.</p>";
	    		}
	    		else 
	    			$out .= "<h2>Unvollständige Angaben</h2><p>Bitte füllen Sie alle Felder aus.</p>";
			}
    	}
    	else 
    	{
	        if ($_POST['save'])
	        {
	        	// Überprüfen der Parameter einbauen
	            $this->extConfig['params']['folder'] = $_POST['data']['folder'];
	            $this->extConfig['params']['thumbfolder'] = $_POST['data']['thumbfolder'];
	            $this->extConfig['params']['thumbwidth'] = $_POST['data']['thumbwidth'];
	            $this->extConfig['params']['thumbheight'] = $_POST['data']['thumbheight'];
	            $this->extConfig['params']['thumbcount'] = $_POST['data']['thumbcount'];
	            $this->extConfig['params']['maxwidth'] = $_POST['data']['maxwidth'];
	            $this->extConfig['params']['maxheight'] = $_POST['data']['maxheight'];
	            
	            $this->saveConfiguration($this->extConfig);
	            
	            $out = $this->smarty->fetch("gallery/admin/saved.tpl");
	        }
	        
            $this->smarty->assign("extConfig", $this->extConfig['params']);
    	}
    	
        return $out.$this->smarty->fetch("../ext/gallery/admin/main.tpl");
    	
        
    }
}
?>