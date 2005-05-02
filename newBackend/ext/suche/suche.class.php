<?php

class suche extends Extension 
{
    var $urlbase;
    var $begriffe;
    var $searchedCes;

    function linearisiereSite($site)
    {
        $newSite = array();

        foreach ($site as $po)
        {
            array_push($newSite, $po);

            if (is_array($po->subs))
            {
                $subSite = $this->linearisiereSite($po->subs);

                foreach($subSite as $subPo)
                    array_push($newSite, $subPo);
            }
        }

        return $newSite;
    }


    function findeTextinPo($po, $begriff)
    {
    // Durchsuche die Attribute
        foreach($po->attributes as $attribut)
        {
            $text = strip_tags($attribut);
            if (strlen($text)> 1 && @stristr($text, $begriff))
                return true;
        }
        
        
    // Durchsuche die Content-Element
        foreach($po->content as $element)
        {
        // Durchsuche nur die gewünschten Content-Elemente
            if (array_search($element['attributes']['position'], $this->searchedCes) !== false)
            {
            // Bestimme Timestamps                
                $visibleFrom = explode(".", $element['attributes']['visibleFrom']);
                $visibleFrom = mktime(0, 0, 0, $visibleFrom[1], $visibleFrom[0], $visibleFrom[2]);
                $visibleTill = explode(".", $element['attributes']['visibleTill']);
                $visibleTill = mktime(0, 0, 0, $visibleTill[1], $visibleTill[0], $visibleTill[2]);
                $now = time();

                $visibleFrom = ($visibleFrom == -1) ? $now - 1 : $visibleFrom;
                $visibleTill = ($visibleTill == -1) ? $now + 1 : $visibleTill;

            // Überprüfe, ob sie angezeigt werden
                if (($element['attributes']['draft'] != 'on' ) && 
                    ($visibleFrom < $now) &&
                    ($visibleTill > $now)
                   )
                {
                // Überprüfe die Attribute
                    foreach($element['attributes'] as $attribut)
                    {
                        $text = strip_tags($attribut);
                        if (strlen($text)> 1 && @stristr($text, $begriff))
                            return true;
                    }

                // Überprüfe die "data"
                    $text = strip_tags($element['data']);
                    if (strlen($text)> 1 && @stristr($text, $begriff))
                        return true;
                }
            }
        }
        return false;
    }

    function findeErgebnisse($site)
    {
        $j = 0;
        $trefferPos = array();

        foreach($this->begriffe as $begriff)
        {
            foreach ($site as $po)
            {
                $visibleFrom = explode(".", $po->attributes['visibleFrom']);
                $visibleFrom = mktime(0, 0, 0, $visibleFrom[1], $visibleFrom[0], $visibleFrom[2]);
                $visibleTill = explode(".", $po->attributes['visibleTill']);
                $visibleTill = mktime(0, 0, 0, $visibleTill[1], $visibleTill[0], $visibleTill[2]);
                $now = time();

                $visibleFrom = ($visibleFrom == -1) ? $now - 1 : $visibleFrom;
                $visibleTill = ($visibleTill == -1) ? $now + 1 : $visibleTill;

                if (($po->attributes['draft'] != 'on' ) && 
                    ($visibleFrom < $now) &&
                    ($visibleTill > $now)
                   )
                { // Seite wird dargestellt
                    // Finde Treffer
                    if ($this->findeTextinPo($po, $begriff))
                        array_push($trefferPos, $po);
                }
            }
                
            $site = $trefferPos;
            $trefferPos = array();
        }

    // Ergebnisse aufbereiten
        $ergebnisse = array();

        foreach ($site as $po)
        {
            $ergebnis['name'] = $po->attributes['name'];
            $ergebnis['desc'] = $po->attributes['desc'];
            $ergebnis['link'] = $this->urlbase.$po->path.".html";
            array_push($ergebnisse, $ergebnis);
        }

        return $ergebnisse;
    }
    
    function ergebnisse()
    {
        global $session;
        
        $site = $this->linearisiereSite($session->site);
        
        $this->urlbase = $session->currentPage->config->docroot.$session->currentPage->config->baseName."/";

        $this->searchedCes = explode(" ", $this->extConfig['params']['searchedCes']);

    // Ermittle Suchanfrage
        // Get-Parameter: $session->currentPage->params) als String
        $this->begriffe = explode(" ", $_GET['s']);
    
        if (strlen($_GET['s']) > 0)
        {
            $ergebnisse = $this->findeErgebnisse($site);
       
            $this->smarty->assign("Ergebnisse", $ergebnisse);
            $out = $this->smarty->fetch('../ext/suche/tpl/ergebnisse.tpl');
        }
        else
        {
            // Ausgeben der Gebrauchsanweisung
            $out = $this->smarty->fetch('../ext/suche/tpl/keineAnfrage.tpl');
        }
        
        return $out;
    }

    function formular()
    {
        global $session;
        // currentUrl
        $this->smarty->assign("currentUrl", $session->currentPage->config->docroot.$session->currentPage->config->baseName."/".$session->currentPage->path.".html");

        // alteBegriffe
        $this->smarty->assign("alteBegriffe", $_GET['s']);
            
        return $this->smarty->fetch('../ext/suche/tpl/formular.tpl');
    }
    
    function main($params)
    {
        global $session;
    // Behandle das abschicken des Formulars
    	
        if ($params['formular'])
            return $this->formular();
        else
            return $this->ergebnisse();
    }

    function getBackend()
    {
        if (!$_POST['save'])
        {
            $erste = "";
        } 
        else 
        {
            $this->extConfig['params']['searchedCes'] = implode(" ", $_POST['searchedCes']);
            $this->saveConfiguration($this->extConfig);
            global $clear_cache; $clear_cache = true;
            
            $erste = $this->smarty->fetch("suche/admin/saved.tpl");
        }

        
        // Daten für Formular aufbereiten
    	$positions = explode(", ", $this->config->position);
    	
    	$ces =array();
    	foreach ($positions as $position) {
    		$ce['value'] = $position;
    		$ce['name'] = $position;
    		if (strpos($this->extConfig['params']['searchedCes'], $position) === false)
    			$ce['selected'] = false;
    		else 
    			$ce['selected'] = true;
    		
    		array_push($ces, $ce);
    	}
    	
        $this->smarty->assign("url", $this->getCurrentURL());
        $this->smarty->assign("Ces", $ces);
        $this->smarty->assign("AnzahlCes", sizeof($ces) + 1);        
    	
        return $erste.$this->smarty->fetch("suche/admin/backend.tpl");
    }
}
?>