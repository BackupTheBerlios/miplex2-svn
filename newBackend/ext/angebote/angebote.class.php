<?php

class angebote extends Extension 
{
    var $urlbase;   // gibt die url-Basis an, an die die 'internen'-Links angehängt werden
    var $typ;       // 'suche', 'rubrik', 'detail', 'pdf', 'allg' : nur für den 'lang'-Teil
    var $params;    // enthält alle URL-Parameter, die hinter '$typ/' kamen
    var $database;  // enthält die geparste XML-Struktur
    var $modus;     // 'kurz' oder 'lang': sagt ob ich die Box oder die große Seite anzeigen muss
    var $drin;      // Bool: für 'kurz' - entscheidet, ob die Teaser, oder die Suche angezeigt werden
                    // sollen
    
    
    /**
    * Gibt die formatierte Liste mit dem angeforderten Name als PDF zurück.
    * 
    * Stößt Dateitransfer an (wie auch immer, das gehen wird)
    */    
    function _pdfAusgeben()
    {
        if (sizeof($this->params) > 0)
        {
        // Überprüfen der Parameter
            $params = explode(".", $this->params[0]);
            $id = $params[0];
            $filename = $this->params[0];
            
        // Finde das passende Angebot
            foreach ($this->database as $rubrik) 
            {
                foreach ($rubrik['angebote'] as $angebot) {
                    if ($angebot['id'] == $id) 
                    {
                        $myAngebot = $angebot;
                        break;
                    }
                }
            }
            
            if (!isset($myAngebot)) return $this->_allgAusgeben();
        
        // Erzeugen des pdf
            require_once("ext/angebote/myFpdf.class.php");
            
            // Instanz erzeugen ( Hochformat DinA4, Angaben in milimeter) 
            $pdf=new myFpdf('P','mm','A4');
            
            // Stammdaten festlegen
            $pdf->SetTitle($angebot['titel']);
            $pdf->SetAuthor(stripslashes($this->extConfig['params']['author']));
            $pdf->SetSubject(stripslashes($this->extConfig['params']['subject']));
            $pdf->SetCreator('FPDF Version 1.52');

        	global $REQUEST_URI;            
            $url = explode(".", $REQUEST_URI);
            array_pop($url);
            $pdf->SetUrl($this->config->server.implode(".", $url).".html");
        
            // Definieren des Platzhalters für die Seitenanzahl
            $pdf->AliasNbPages();
            // eine Seite erzeugen
            $pdf->AddPage();
            
            // Zeige Titel der Liste an
            $pdf->PutTitle();

        // Füllen des PDFs
        
            // Kurzbeschreibung 
            if (strlen($myAngebot['kurzbeschreibung']) > 1)
                $pdf->Special("Kurzbeschreibung", $myAngebot['kurzbeschreibung']);
            
            // Adresse
            if (strlen($myAngebot['adresse']) > 1)
                $pdf->Adresse($myAngebot['adresse']);
            
            // Objektbeschreibung
            if (strlen($myAngebot['objektbeschreibung']) > 1)
            {
                $pdf->PutSubtitle("Objektbeschreibung");
                $pdf->Paragraph($myAngebot['objektbeschreibung']);
            }
            
            // Ausstattung
            if (strlen($myAngebot['ausstattung']) > 1)
            {
                $pdf->PutSubtitle("Ausstattung");
                $pdf->Paragraph($myAngebot['ausstattung']);
            }
            
            // Lage
            if (strlen($myAngebot['lage']) > 1)
            {
                $pdf->PutSubtitle("Lage");
                $pdf->Paragraph($myAngebot['lage']);
            }
            
            // Sonstiges
            if (strlen($myAngebot['sonstiges']) > 1)
            {
                $pdf->PutSubtitle("Sonstiges");
                $pdf->Paragraph($myAngebot['sonstiges']);
            }
            
            // Bilder
            if (sizeof($myAngebot['bilder']) > 0)
            {
                $pdf->AddPage();
                $pdf->PutSubtitle("Bilder");
                foreach ($myAngebot['bilder'] as $bild)
                {
                    $pdf->Bild($bild);
                }
            }
     
        // Kontaktinformationen anfügen
			$pdf->addPage();
            $pdf->PutSubtitle("Kontaktinformationen");

            $pagecount = $pdf->setSourceFile("ext/angebote/kontakt.pdf");
			$tplidx = $pdf->ImportPage(1);
			$pdf->useTemplate($tplidx);
            
               
        // Ausgeben des PDF
            // Und das ganze als '*.pdf' an den Browser senden
            $pdf->CleanOutput($filename, 'D');
        
        }
        else 
            return $this->_allgAusgeben();
    }
    
    function stripCdata($text)
    {
        $stripCDATA = array("<![CDATA[ " => "", " ]]>" => "", "<br />" => "");
        return strtr($text, $stripCDATA);
    }

    function _datenLesen($backend = false)
    {
        $this->xpath = new xpath("ext/angebote/angebote.xml");
        
        $res = $this->xpath->evaluate("/angebote/rubrik[@name]");
        
        $rubriken = array();
        // Durchlaufe alle Rubriken
        foreach ($res as $rubrikPath) 
        {
            $resAngebote = $this->xpath->evaluate($rubrikPath."/angebot");
            
            $attr = $this->xpath->getAttributes($rubrikPath);
            
            $rubrik['name'] = $attr['name'];
            
            $angebote = array();
            
            foreach ($resAngebote as $angebotPath)
            {// Durchlaufe alle Angebote
                $attr = $this->xpath->getAttributes($angebotPath);
                
            // Bestimme Timestamps                
                $start = $this->makeDate($attr['start']);
                $ende = $this->makeDate($attr['ende']);
                $now = time();

                $start = ($start == -1) ? $now - 1 : $start;
                $ende = ($ende == -1) ? $now + 1 : $ende;
                
                // Wenn das Angebot gültig ist, so wird es in die Liste aufgenommen
                if ((($start < $now) && ($ende > $now)) || $backend)
                {
                    $angebot['start'] = $attr['start'];
                    $angebot['ende'] = $attr['ende'];
                    $angebot['id'] = $attr['id'];
                    
                    // Alle Unterknoten Speichern
                    $angebot['adresse'] = $this->stripCdata($this->xpath->getData($angebotPath."/adresse"));
                    $angebot['titel'] = $this->stripCdata($this->xpath->getData($angebotPath."/titel"));
                    $angebot['kurzbeschreibung'] = $this->stripCdata($this->xpath->getData($angebotPath."/kurzbeschreibung"));
                    $angebot['objektbeschreibung'] = $this->stripCdata($this->xpath->getData($angebotPath."/objektbeschreibung"));
                    $angebot['ausstattung'] = $this->stripCdata($this->xpath->getData($angebotPath."/ausstattung"));
                    $angebot['lage'] = $this->stripCdata($this->xpath->getData($angebotPath."/lage"));
                    $angebot['sonstiges'] = $this->stripCdata($this->xpath->getData($angebotPath."/sonstiges"));
                    
                    // alle Bilder speichern

                    $bilderPath = $this->xpath->evaluate($angebotPath."/bild");
                    $bilder = array();
                    
                    foreach ($bilderPath as $bild)
                    { 
                        $attrBild = $this->xpath->getAttributes($bild);
                        $bildchen['src'] = $attrBild['src'];
                        
                        $bildchen['alt'] = $this->xpath->getData($bild."/alt[1]");
                        $bildchen['title'] = $this->xpath->getData($bild."/title[1]");
                        
                        array_push($bilder, $bildchen);
                    }
                    $angebot['bilder'] = $bilder;
                    
                    array_push($angebote, $angebot);
                }
            }
            
            $rubrik['angebote'] = $angebote;
            
            array_push($rubriken, $rubrik);
        }
        
        $this->database = $rubriken;
    }

    function _getParams()
    {
        global $session, $REQUEST_URI;

        $begriffe = explode("/", $session->currentPage->params);
        
        switch ($begriffe[0]) {
            case 'suche':
                $this->typ = 'suche';
                break;
            case 'rubrik':
                $this->typ = 'rubrik';
                break;
            case 'detail':
                $this->typ = 'detail';
                $tmp = explode(".", $REQUEST_URI);
                if (!strcasecmp("pdf", $tmp[sizeof($tmp)-1]))
                    $this->typ = 'pdf';
                break;
            default:
                break;
        }

        for ($i = 1; $i < sizeof($begriffe); $i++)
            $this->params[$i-1] = $begriffe[$i];
    }
    
    function _allgAusgeben()
    {
        // allgemeine Seite ausgeben
        $AnzDerAngebote = 0;
        $rubriken = array();
        foreach ($this->database as $rubrik) {
            $rubrikout['name'] = $rubrik['name'];
            $rubrikout['url'] = $this->urlbase."/rubrik/".$rubrik['name'].".html";
            $rubrikout['count'] = sizeof($rubrik['angebote']);
            $AnzDerAngebote += sizeof($rubrik['angebote']);
            array_push($rubriken, $rubrikout);
        }
        $this->smarty->assign("rubriken", $rubriken);
        $this->smarty->assign("AnzDerAngebote", $AnzDerAngebote);
            
        return $this->smarty->fetch('angebote/tpl/allg.tpl');
    }
    
    function _findeBegriffInAngebot($begriff, $angebot)
    {
        foreach ($angebot as $key => $attribut)
        {
            if ($key == 'bilder')
                foreach ($attribut as $bild) {
                    foreach ($bild as $bildattribut) {
                        if (strlen($bildattribut)> 1 && @preg_match("/".$begriff."/i", $bildattribut))
                            return true;
                    }
                }
            else
                if (strlen($attribut)> 1 && @preg_match("/".$begriff."/i", $attribut))
                    return true;
        }
        return false;
    }
    
    
    function _sucheAusgeben()
    {
        if (strlen($_GET['s']) > 1)
        {
            // Finde die passende Rubrik und fasse event. alle Angebote zu einer Liste zusammen
            foreach ($this->database as $rubrik) {
                if ($rubrik['name'] == $_GET['r'])
                {
                    $myRubrik = $rubrik;
                    break;
                }
            }

            if (!isset($myRubrik))
            {
                $myRubrik['name'] = '_alle';
                $myRubrik['angebote'] = array();
                // Linearisiere alle Rubriken
                foreach ($this->database as $rubrik) {
                    foreach ($rubrik['angebote'] as $angebot) {
                        array_push($myRubrik['angebote'], $angebot);
                    }
                }
            }
            
            $angebote = $myRubrik['angebote'];
            // Durchsuche für jeden Suchbegriff die Liste und behalte gültige Angebote
            
            $this->params = explode(" ", $_GET['s']);
            
            foreach ($this->params as $begriff) {
                $treffer = array();
                
                foreach ($angebote as $angebot) {
                    if ($this->_findeBegriffInAngebot($begriff, $angebot))
                        array_push($treffer, $angebot);
                }
                
                $angebote = $treffer;
            }
            
            // Bereite die Ergebnisse auf
            $ergebnisse = array();
            foreach ($treffer as $einzeltreffer) {
                $ergebnis['title'] = trim($einzeltreffer['titel']);
                $ergebnis['shortdesc'] = trim($einzeltreffer['kurzbeschreibung']);
                $ergebnis['url'] = $this->urlbase."/detail/".$einzeltreffer['id'].".html";
                
                array_push($ergebnisse, $ergebnis);
            }
            
            // Übergebe die Ergebnisse an Smarty
            
            $this->smarty->assign("ergebnisse", $ergebnisse);
            
            // Gib Smarty-Template aus
            return $this->smarty->fetch('angebote/tpl/suche.tpl');
        }
        else 
            // Suche, aber keine Suchanfragen => gib allgemein aus
            return $this->_allgAusgeben();
    }

    function _rubrikAusgeben()
    {
        if (sizeof($this->params) > 0)
        {
            // Einzelne Rubrik ausgeben
            // Finde aktuelle Rubrik
            foreach ($this->database as $rubrik) {
                if ($rubrik['name'] == $this->params[0])
                {
                    $myRubrik = $rubrik;
                    break;
                }
            }
            
            if (!isset($myRubrik))
                //Schreien und wegrennen - falsche Rubrik angegeben
                exit;
                        
            // Finde aktuelles Angebote
            $nummer = (isset($this->params[1])) ? $this->params[1] : 1;
            
            if (!(is_numeric($nummer) && $nummer > 0 && $nummer <= sizeof($myRubrik['angebote'])))
                $nummer = 1;
            
            $myAngebot = $myRubrik['angebote'][$nummer - 1];
            
            if ($nummer > 1)
                $this->smarty->assign("zurueckLink", $this->urlbase."/rubrik/".$myRubrik['name']."/".($nummer-1).".html");
                
            if ($nummer < sizeof($myRubrik['angebote']))
                $this->smarty->assign("vorLink", $this->urlbase."/rubrik/".$myRubrik['name']."/".($nummer+1).".html");

            $this->smarty->assign("Uebersicht", $this->urlbase.".html");
                
            $this->smarty->assign("rubrikname", $this->params[0]);
            
            return $this->smarty->fetch('../ext/angebote/tpl/rubrik.tpl').$this->_detailAusgeben($myAngebot['id']);

        }
        else 
            // Rubrik, aber kein Rubrikname => gib allgemein aus
            return $this->_allgAusgeben();
    }
    
    function _detailAusgeben($id)
    {
        global $session;
                
        if (sizeof($this->params) > 0)
        {
            // Einzelnes Angebot ausgeben
            foreach ($this->database as $rubrik) 
            {
                foreach ($rubrik['angebote'] as $angebot) {
                    if ($angebot['id'] == $id) 
                    {
                        $myAngebot = $angebot;
                        break;
                    }
                }
            }
            
            $this->smarty->assign("adresse", nl2br(htmlentities($myAngebot['adresse'])));
            $this->smarty->assign("titel", nl2br(htmlentities($myAngebot['titel'])));
            $this->smarty->assign("kurzbeschreibung", nl2br(htmlentities($myAngebot['kurzbeschreibung'])));
            $this->smarty->assign("objektbeschreibung", nl2br(htmlentities($myAngebot['objektbeschreibung'])));
            $this->smarty->assign("ausstattung", nl2br(htmlentities($myAngebot['ausstattung'])));
            $this->smarty->assign("lage", nl2br(htmlentities($myAngebot['lage'])));
            $this->smarty->assign("sonstiges", nl2br(htmlentities($myAngebot['sonstiges'])));

            $this->smarty->assign("pdflink", $this->urlbase."/detail/".$myAngebot['id'].".pdf");
            
            if (is_array ($myAngebot['bilder']))
            {
                $bilder = array();
                foreach ($myAngebot['bilder'] as $bild) 
                {

                    $bild_o['src'] = $session->currentPage->config->docroot.$bild['src'];
                    $bild_o['title'] = $bild['title'];
                    $bild_o['alt'] = $bild['alt'];

                    array_push($bilder, $bild_o);
                }
            }
            
            $this->smarty->assign("bilder", $bilder);
            
            return $this->smarty->fetch('angebote/tpl/details.tpl');
        }
        else 
            // Angebot, aber keine Angebots-ID => gib allgemein aus
            return $this->_allgAusgeben();
    }
    
    function _menu()
    {
		$out = "<ul>\n";
    	foreach ($this->database as $rubrik) {
    		$out .= "\t<li>";
    		$out .= "<a href=\"".$this->urlbase."/rubrik/".$rubrik['name'].".html\" title=\"Die Rubrik '".$rubrik['name']."' durchblättern...\"><strong>".$rubrik['name']."</strong>";
    		$out .= " - Diese Rubrik genauer betrachten</a>";
    		$out .= "</li>\n";
        }
    	$out .= "</ul>\n";
    	
    	return $out;
    }
    
    function _kurz()
    {
        global $session;

        if ($this->drin)
        {   // Suchformular ausgeben
            // currentUrl
            $url = $session->config->docroot.$session->config->baseName."/".$this->extConfig['params']['path']."/suche.html";
            $this->smarty->assign("currentUrl", $url);
    		
            global $REQUEST_URI;
            
            // alteBegriffe übergeben
            if (stristr ($REQUEST_URI, "suche"))
	            $this->smarty->assign("alteBegriffe", $_GET['s']);
            
            // Rubriken übergeben
            $rubriken['_alle']['bez'] = "(Rubrik)";
            $rubriken['_alle']['selected'] = "";

            foreach ($this->database as $rubrik) {
                $rubriken[$rubrik['name']]['bez'] = $rubrik['name'];
                if ($_GET['r'])
                	$rubriken[$rubrik['name']]['selected'] = ($_GET['r'] == $rubrik['name']) ? 'selected' : '';
                else
                	$rubriken[$rubrik['name']]['selected'] = (stristr ($REQUEST_URI, $rubrik['name'])) ? 'selected' : '';
            }
            
            $this->smarty->assign("rubriken", $rubriken);
                
            return $this->smarty->fetch('angebote/tpl/formular.tpl');
        }
        else 
        {
            // Kurzangebote ausgeben

            // Erzeuge flachen Teilbaum aus $this->database
            $myDatabase = array();
            foreach ($this->database as $teilbaum) 
                foreach ($teilbaum['angebote'] as $angebot)
                    array_push($myDatabase, $angebot);
            
            // Bestimme zufälliges Angebot
            // seed with microseconds since last "whole" second
            mt_srand((double)microtime()*1000000);
            $randval = mt_rand() % sizeof($myDatabase);

            // kurz.tpl ausgeben von $myDatabase[$randval];
            $angebot = $myDatabase[$randval];
            
            $this->smarty->assign("title", $angebot['titel']);
            $this->smarty->assign("shortdesc", $angebot['kurzbeschreibung']);
            $this->smarty->assign("url", $this->urlbase."/detail/".$angebot['id'].".html");
            
            return $this->smarty->fetch('../ext/angebote/tpl/kurz.tpl');
        }
    }
    
    function main($params)
    {
        global $session;
        global $REQUEST_URI;
        
        
        // bestimme die URL auf der meine Parameter sitzen
        $this->urlbase = $session->config->docroot.$session->config->baseName."/".$this->extConfig['params']['path'];

        // bestimme, ob ich mich auf meiner Heinseite befinde, oder ob ich auf einer fremden Seite bin
        $this->drin = ($session->currentPage->path == $this->extConfig['params']['path']) ? true : false;
        
        // Wenn kein Parameter aus dem Extensionaufruf mitkommt, bin ich 'kurz'
        if (strlen ($params['typ']) > 1) 
            $this->modus = $params['typ'];
        else
            $this->modus = 'kurz';
            
        // Preisliste einlesen
        $this->_datenLesen();
       
        // Anzuzeigendes Bestimmen
        $this->_getParams();


        if ($this->modus == 'kurz')
            return $this->_kurz();
        if ($this->modus == 'menu')
            return $this->_menu();
        
        
        // sonst suchst du dir die passende Tätigkeit aus
        switch ($this->typ) {
            case 'suche':
                return $this->_sucheAusgeben();
            case 'rubrik':
                return $this->_rubrikAusgeben();
            case 'detail':
                return $this->_detailAusgeben($this->params[0]);
            case 'pdf':
                return $this->_pdfAusgeben();
            default:
                return $this->_allgAusgeben();
        }
    }

    function getBackend()
    {
        $this->_datenLesen(true);

        // Modus bestimmen
        if ($_GET['mode'] == "rubrik")
        {
            $patterns = array('\\', "/", ":", "*", "?", '"', "<", ">", "|", ",");
            $replacements = "";

            if ($_POST['changeName'])
            {
                // TODO: Neuen Rubriknamen speichern
                // Neuen Knoten von ungültigen Zeichen befreien
                $neu = str_replace($patterns, $replacements, stripslashes($_POST['newName']));
                
                if (htmlentities($neu) == $neu)
                {
                    if ($neu)
                    {
                        $this->xpath->setAttribute("/angebote/rubrik[@name='".$_GET['rid']."']", "name", $neu);

                        if ($this->xpath->exportToFile(getcwd()."/ext/angebote/angebote.xml"))
                        {
                            $out .= "<p>Änderungen erfolgreich gespeichert.</p>";
                            $_GET['rid'] = $neu;
                            $this->_datenLesen(true);
                            global $clear_cache; $clear_cache = true;
                        }
                        else 
                            $out .= "<h2>Beim Speichern ist ein Fehler aufgetreten</h2><p>Bitte überprüfen Sie ihre Dateisystemrechte und versuchen Sie es erneut.</p>";
                    }
                    else 
                        $out .= "<h2>Zu kurzer Rubrikname</h2><p>Bitte geben Sie einen längeren Rubriknamen ein. Leere Namen sind nicht erlaut.</p>";
                }
                else
                    $out .= "<h2>Ungültiger Rubrikname</h2><p>Leider darf der Rubrikname keinerlei Sonderzeichen enthalten. Bitte geben Sie einen anderen Namen ein.</p>";
            }
            
            if ($_POST['addRubrik'])
            {
                $neu = str_replace($patterns, $replacements, stripslashes($_POST['newName']));

                if (htmlentities($neu) == $neu)
                {
                    if ($neu)
                    {
                        $this->xpath->appendChild("/angebote", "\n<rubrik name=\"".$neu."\"/>\n");

                        if ($this->xpath->exportToFile(getcwd()."/ext/angebote/angebote.xml"))
                        {
                            $out .= "<p>Die Rubrik wurde erfolgreich angelegt.</p>";
                            $_GET['rid'] = $neu;
                            $this->_datenLesen(true);
                            global $clear_cache; $clear_cache = true;
                        }
                        else 
                            $out .= "<h2>Beim Speichern ist ein Fehler aufgetreten</h2><p>Bitte überprüfen Sie ihre Dateisystemrechte und versuchen Sie es erneut.</p>";
                    }
                    else 
                        $out .= "<h2>Zu kurzer Rubrikname</h2><p>Bitte geben Sie einen längeren Rubriknamen ein. Leere Namen sind nicht erlaut.</p>";
                }
                else
                    $out .= "<h2>Ungültiger Rubrikname</h2><p>Leider darf der Rubrikname keinerlei Sonderzeichen enthalten. Bitte geben Sie einen anderen Namen ein.</p>";
            }

            if ($_POST['deleteRubrik'])
            {
                if (($this->xpath->removeChild("/angebote/rubrik[@name=\"".$_GET['rid']."\"]"))
                && ($this->xpath->exportToFile(getcwd()."/ext/angebote/angebote.xml")))
                {
                    $out .= "<p>Rubrik erfolgreich gelöscht.</p>";
                    $_GET['mode'] = "allg";
                    $this->_datenLesen(true);
                    global $clear_cache; $clear_cache = true;
                }
                else 
                    $out .= "<h2>Beim Löschen ist ein Fehler aufgetreten</h2><p>Bitte überprüfen Sie ihre Dateisystemrechte und versuchen Sie es erneut.</p>";
            }
            
            if ($_POST['save'])
            {
                // Überprüfen und Berichtigen der Parameter
                $fehler = "";
                
                if (preg_match("/^[0-9][0-9]\.[0-9][0-9]\.[0-9][0-9][0-9][0-9]$/", $_POST['data']['start']))
                    $start = $_POST['data']['start'];
                else    
                    $fehler .= "<li>Ungültiges Start-Datum</li>";

                if (preg_match("/^[0-9][0-9]\.[0-9][0-9]\.[0-9][0-9][0-9][0-9]$/", $_POST['data']['ende']))
                    $ende = $_POST['data']['ende'];
                else    
                    $fehler .= "<li>Ungültiges End-Datum</li>";
                    
                if ($_POST['data']['titel'])
                    $titel = "<![CDATA[ ".nl2br(stripslashes($_POST['data']['titel']))." ]]>";
                else 
                    $fehler .= "<li>Fehlender Titel</li>";

                if ($_POST['data']['adresse'])
                    $adresse = "<![CDATA[ ".nl2br(stripslashes($_POST['data']['adresse']))." ]]>";
                else 
                    $fehler .= "<li>Fehlende Adresse</li>";
                    
                if ($_POST['data']['kurzbeschreibung'])
                    $kurzbeschreibung = "<![CDATA[ ".nl2br(stripslashes($_POST['data']['kurzbeschreibung']))." ]]>";
                else 
                    $fehler .= "<li>Fehlende Kurzbeschreibung</li>";

                if ($_POST['data']['objektbeschreibung'])
                    $objektbeschreibung = "<![CDATA[ ".nl2br(stripslashes($_POST['data']['objektbeschreibung']))." ]]>";
                else 
                    $fehler .= "<li>Fehlende Objektbeschreibung</li>";

                if ($_POST['data']['ausstattung'])
                    $ausstattung = "<![CDATA[ ".nl2br(stripslashes($_POST['data']['ausstattung']))." ]]>";

                if ($_POST['data']['lage'])
                    $lage = "<![CDATA[ ".nl2br(stripslashes($_POST['data']['lage']))." ]]>";

                if ($_POST['data']['sonstiges'])
                    $sonstiges = "<![CDATA[ ".nl2br(stripslashes($_POST['data']['sonstiges']))." ]]>";

                $node = '
            start="'.$start.'"
            ende="'.$ende.'">
            <adresse>'.$adresse.'</adresse>
            <titel>'.$titel.'</titel>
            <kurzbeschreibung>'.$kurzbeschreibung.'</kurzbeschreibung>
            <objektbeschreibung>'.$objektbeschreibung.'</objektbeschreibung>
'.($ausstattung ? '         <ausstattung>'.$ausstattung.'</ausstattung>' : '').'        
'.($lage ?        '         <lage>'.$lage.'</lage>' : '').'     
'.($sonstiges ?   '         <sonstiges>'.$sonstiges.'</sonstiges>' : '').'      
';
                    
                if (strlen($fehler) == 0)
                {
                    if (isset($_POST['new']))
                    {
                        $id = $_GET['rid'].(time()-1100000000);
                        $node = "\n     <angebot id=\"".$id.'" '.$node."\n      </angebot>";
                        
                        $this->xpath->appendChild("/angebote/rubrik[@name=\"".$_GET['rid']."\"]", $node);
                        
                        if ($this->xpath->exportToFile(getcwd()."/ext/angebote/angebote.xml"))
                        {
                            $out .= "<p>Das Angebot wurde erfolgreich angelegt.</p>";
                            $_GET['aid'] = $id;
                            $this->_datenLesen(true);
                            global $clear_cache; $clear_cache = true;
                        }
                        else 
                            $out .= "<h2>Beim Speichern ist ein Fehler aufgetreten</h2><p>Bitte überprüfen Sie ihre Dateisystemrechte und versuchen Sie es erneut.</p>";

                    }
                    else 
                    {
                        $node = "\n     <angebot id=\"".$_GET['aid'].'" '.$node;
                        
                        // Bilder auch behalten
                        $bilder = $this->xpath->evaluate("/angebote/rubrik[@name=\"".$_GET['rid']."\"]/angebot[@id=\"".$_GET['aid']."\"]/bild");
                        foreach ($bilder as $bild) {
                            $node .= $this->xpath->exportAsXml($bild);
                        }
                        
                        
                        $this->xpath->replaceChild("/angebote/rubrik[@name=\"".$_GET['rid']."\"]/angebot[@id=\"".$_GET['aid']."\"]", $node."\n      </angebot>");
                        
                        if ($this->xpath->exportToFile(getcwd()."/ext/angebote/angebote.xml"))
                        {
                            $out .= "<p>Das Angebot wurde erfolgreich bearbeitet.</p>";
                            $this->_datenLesen(true);
                            global $clear_cache; $clear_cache = true;
                        }
                        else 
                            $out .= "<h2>Beim Speichern ist ein Fehler aufgetreten</h2><p>Bitte überprüfen Sie ihre Dateisystemrechte und versuchen Sie es erneut.</p>";
                    }
                }
                else
                    $out .= "<h2>Ungültige Eingaben.</h2><p>Bitte überprüfen Sie ihre Angaben.</p><ul>".$fehler."</ul>";
                
                $this->smarty->assign("myAngebot", $_POST['data']);
            }
            
            if ($_POST['delete'])
            {
                if (($this->xpath->removeChild("/angebote/rubrik[@name=\"".$_GET['rid']."\"]/angebot[@id=\"".$_GET['aid']."\"]"))
                && ($this->xpath->exportToFile(getcwd()."/ext/angebote/angebote.xml")))
                {
                    $out .= "<p>Angebot erfolgreich gelöscht.</p>";
                    unset($_GET['aid']);
                    $this->_datenLesen(true);
                    global $clear_cache; $clear_cache = true;
                }
                else 
                    $out .= "<h2>Beim Löschen ist ein Fehler aufgetreten</h2><p>Bitte überprüfen Sie Ihre Dateisystemrechte und versuchen Sie es erneut.</p>";
            }
            
            if ($_POST['imgDelete'])
            {
                if ($_POST['src'])
                {
                    if (($this->xpath->removeChild("/angebote/rubrik[@name=\"".$_GET['rid']."\"]/angebot[@id=\"".$_GET['aid']."\"]/bild[@src=\"".$_POST['src']."\"]"))
                    && ($this->xpath->exportToFile(getcwd()."/ext/angebote/angebote.xml")))
                    {
                        $out .= "<p>Bild erfolgreich gelöscht.</p>";
                        $this->_datenLesen(true);
                        global $clear_cache; $clear_cache = true;
                    }
                    else 
                        $out .= "<h2>Beim Löschen ist ein Fehler aufgetreten</h2><p>Bitte überprüfen Sie Ihre Dateisystemrechte und versuchen Sie es erneut.</p>";
                }
                else 
                    $out .= "<h2>Unerwarteter Fehler</h2>";
            }

            if ($_POST['imgAdd'])
            {
                $fehler = "";
                
                if (file_exists($_POST['data']['src']))
                    $src = $_POST['data']['src'];
                else 
                    $fehler = "(Die angegebene Datei existiert nicht.)";
                    
                
                $title = htmlentities($_POST['data']['title']);
                $alt = htmlentities($_POST['data']['alt']);
                
                $node ='
            <bild src="'.$src.'">
                <title>'.$title.'</title>
                <alt>'.$alt.'</alt>
            </bild>
';
                if (strlen($fehler) == 0 && strlen($title) > 0 && strlen($alt) > 0)
                {
                    $this->xpath->appendChild("/angebote/rubrik[@name=\"".$_GET['rid']."\"]/angebot[@id=\"".$_GET['aid']."\"]", $node);
                    if ($this->xpath->exportToFile(getcwd()."/ext/angebote/angebote.xml"))
                    {
                        $out .= "<p>Bild erfolgreich eingefügt.</p>";
                        $this->_datenLesen(true);
                        global $clear_cache; $clear_cache = true;
                    }
                    else 
                        $out .= "<h2>Beim Speichern ist ein Fehler aufgetreten</h2><p>Bitte überprüfen Sie Ihre Dateisystemrechte und versuchen Sie es erneut.</p>";
                }
                else 
                    $out.= "<h2>Fehlerhafte Angaben</h2><p>Bitte Überprüfen Sie ihre Angaben. ".$fehler."</p>";
            }
            if ($_POST['imgEdit'])
            {
                if ($_POST['src'])
                {
                    $fehler = "";
                    
                    if (file_exists($_POST['data']['src']))
                        $src = $_POST['data']['src'];
                    else 
                        $fehler = "(Die angegebene Datei existiert nicht.)";
                        
                    
                    $title = htmlentities($_POST['data']['title']);
                    $alt = htmlentities($_POST['data']['alt']);
                    
                    $node ='
            <bild src="'.$src.'">
                <title>'.$title.'</title>
                <alt>'.$alt.'</alt>
            </bild>
';
                    if (strlen($fehler) == 0 && strlen($title) > 0 && strlen($alt) > 0)
                    {
                        $this->xpath->replaceChild("/angebote/rubrik[@name=\"".$_GET['rid']."\"]/angebot[@id=\"".$_GET['aid']."\"]/bild[@src=\"".$_POST['src']."\"]", $node);
                        if ($this->xpath->exportToFile(getcwd()."/ext/angebote/angebote.xml"))
                        {
                            $out .= "<p>Bild erfolgreich bearbeitet.</p>";
                            $this->_datenLesen(true);
                            global $clear_cache; $clear_cache = true;
                        }
                        else 
                            $out .= "<h2>Beim Bearbeiten ist ein Fehler aufgetreten</h2><p>Bitte überprüfen Sie Ihre Dateisystemrechte und versuchen Sie es erneut.</p>";
                    }
                    else 
                        $out.= "<h2>Fehlerhafte Angaben</h2><p>Bitte Überprüfen Sie ihre Angaben. ".$fehler."</p>";
                }
                else 
                {
                    $out .= "<h2>Unerwarteter Fehler</h2>";
                }
            }
            
            $this->smarty->assign("mode", $_GET['mode']);
            
            foreach ($this->database as $rubrik) {
                if ($rubrik['name'] == $_GET['rid'])
                    $gefunden = $rubrik;
            }
            
            if (is_array($gefunden))
                $this->smarty->assign("myRubrik", $gefunden);
            
            if (isset($_GET['aid']))
            {
            	if (strlen($_GET['aid']) > 0)
            	{
            		$this->smarty->assign("aid", $_GET['aid']);
            		foreach ($gefunden['angebote'] as $Angebot)
            		{
            			if ($Angebot['id'] == $_GET['aid'])
            				$this->smarty->assign("myAngebot", $Angebot);
            		}
            	}
            	else
            	{
                	$this->smarty->assign("aid", "new");
            	}
            }
        }

        if ($_GET['mode'] == "allg")
        {
            // Formular behandeln
            if ($_POST['save'])
            {
                $this->extConfig['params']['path'] = $_POST['data']['path'];
                $this->extConfig['params']['author'] = $_POST['data']['author'];
                $this->extConfig['params']['subject'] = $_POST['data']['subject'];
                
                $this->saveConfiguration($this->extConfig);
                
                $this->smarty->assign("msg", "ok");
            }

            // Ausgabe vorbereiten
            $this->smarty->assign("mode", $_POST['mode']);
            
            foreach ($this->extConfig['params'] as $parakey => $para) {
                $paras[$parakey] = htmlentities(stripslashes($para));
            }
            
            $this->smarty->assign("extConfig", $paras);
        }

        $this->smarty->assign("url", "/admin.php?module=ext&amp;id=angebote");
        $this->smarty->assign("rubriken", $this->database);     

        return $out.$this->smarty->fetch('angebote/admin/main.tpl');
    }
    
    /**
    * Erzeugt aus einem String der Form dd.mm.YYYY ein korrekten Timestamp,
    * der verglichen werden kann.
    * @param String $string Das Datum als String
    * @return UnixTimeStamp des übergebenen Datums
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