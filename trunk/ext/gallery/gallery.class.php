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
        $out = $this->smarty->fetch('../ext/gallery/einzeln.tpl');

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
        $out = $this->smarty->fetch('../ext/gallery/alle.tpl');

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
    
    
    function getBackend()
    {
        return "Noch nicht implementiert.";
    }
}
?>