<?php
/**
* Hier beginnt Miplex2
* Wenn diese Datei aufgerufen wird, dann ist
* der aktuelle User garantiert nur ein Besucher, und es
* m�ssen keine Backenddaten geladen werden.
*/
    function getErrorHandler($errno, $errmsg, $filename, $linenum) {
        $error = "Zeit: " .date("Y-m-d H:i:s"). "\n";
        $error .= "Meldung: " .$errmsg. "\n";
        $error .= "Datei: " .$filename. "\n";
        $error .= "Zeile: " .$linenum;
        mail("error@schmidtwisser.de", "Fehler auf wbg-dahmeland.de", $error, "From: Entwickler");
    } 


    function getmicrotime()
    {
        list($usec, $sec) = explode(" ",microtime());
        return ((float)$usec + (float)$sec);
    }

    $time_start = getmicrotime();

    function can_gzip()
    {
        global $HTTP_SERVER_VARS;
        if (headers_sent() || connection_aborted())
            return 0; 

        if (strpos($HTTP_SERVER_VARS['HTTP_ACCEPT_ENCODING'], 'x-gzip') !== false) return "x-gzip"; 
        if (strpos($HTTP_SERVER_VARS['HTTP_ACCEPT_ENCODING'],'gzip') !== false) return "gzip"; 
    
        return 0;
    } 

    function gz_output($level=9,$debug=0,$speed=0)
    {
        $ENCODE = can_gzip();

        $Contents = ob_get_contents(); 
        ob_end_clean();

        $teaser = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!-- Diese Seite wurde mit dem Open-Source Content Management System (CMS) Miplex2 generiert.
     Ziel dieses CMS ist es, ein m�glichst einfaches, datenbankloses, php-basiertes CMS zu schaffen.
     This site was brought to you by the Open Source Content Management System Miplex.
     The reason to develope this cms was to have a simple to use, database independent and php based cms.
     
     Mehr Informationen �ber Miplex erhalten sie auf den Internetseiten
     You can get more information about Miplex at the following sites
                          +++   http://www.miplex.de  +++
     
     Die Autoren dieses CMS erreichen Sie auf
     The authors of the cms are available at
                        +++  http://www.grundprinzip.de  +++
                       +++  http://www.schmidtwisser.de   +++
';

        if($speed)
        {
            global $time_start;

            $time_end = getmicrotime();
            $time     = $time_end - $time_start;
            $time     = number_format($time,3,',','.');
            $teaser.= '
     + Script Execution time: '.$time." sec\n";
        }

        global $cache;
        if (isset($cache) && $debug)
        {   
            if ($cache)
                $teaser.= "
     + This site is a cached copy.\n";
            else
                $teaser.= "
     + This site has now been cached for the first time.\n";
            
            $teaser.= "        Miplex2 nutzt f�r das Zwischenspeichern von generierten Seiten die Cache-Funktion von Smarty 
        Miplex2 uses the Cache-Function of Smarty to store generated pages.\n";

        }
        
        if ($ENCODE)
        {
            if ($debug)
            {
                $teaser.='
     + Compression Level
        Diese Seite wurde f�r eine schnellere Daten�bertragung GZip-komprimiert zu ihrem Browser
        �bertragen. This site was sent to you gzip compressed to reach a faster delivery.

        uncompressed size : '.sprintf ("%01.2f", ( (strlen($Contents) )/1024 )).' kBytes
        compressed size   : '.sprintf ("%01.2f",( (strlen(gzcompress($Contents,$level)) )/1024))." kBytes\n";
            }

            $Contents = $teaser."-->\n".$Contents;

            header("Content-Encoding: $ENCODE");    
            print "\x1f\x8b\x08\x00\x00\x00\x00\x00"; 
            $Size = strlen($Contents); 
            $Crc = crc32($Contents); 
            $Contents = gzcompress($Contents,$level);
            $Contents = substr($Contents, 0, strlen($Contents) - 4); 
            

            print $Contents;
            print pack('V',$Crc); 
            print pack('V',$Size); 
        
        }
        else 
        {
            echo $teaser."
     Leider unterst�tzt ihr Browser keine GZip-komprimierte �bertragung. Miplex unterst�tzt diese
     Technologie f�r eine schnellere Daten�bertragung. Unfortunately your browser does not support
     gzip compressed transmission. Miplex does support this technology to reach a faster delivery
     of the content. \n-->\n".$Contents;
        }
    }

    ob_start();
    ob_implicit_flush(0);

        require_once("lib/Miplex2/Session.class.php");
        
        $session = new Session("config/config.ser");

        if (strlen($HTTP_SERVER_VARS['REQUEST_URI']) > 0 && sizeof($_POST) == 0 && sizeof($_GET) == 0)
        {
            $session->smarty->caching = true;
            
            if ($clear_cache)
                $session->smarty->clear_all_cache();

            $session->smarty->cache_lifetime = -1;
            
            $cache_id = str_replace("/", "|", $HTTP_SERVER_VARS['REQUEST_URI']);
            
            if ($session->smarty->is_cached($session->config->theme, $cache_id))
            {
                $cache = true;
                $session->smarty->display($session->config->theme, $cache_id);
            }
            else 
            {
                $cache = false;
                $page = &$session->getActPage();
                
                $session->smarty->assign("pageObject", $page);      
                $session->smarty->assign("header", $session->header);
                $session->smarty->assign("config", $session->config);
                $session->smarty->assign("site", $session->site);
                $session->smarty->display($session->config->theme, $cache_id);
            }
        }
        else 
        {
            $page = &$session->getActPage();
            
            $session->smarty->assign("pageObject", $page);      
            $session->smarty->assign("header", $session->header);
            $session->smarty->assign("config", $session->config);
            $session->smarty->assign("site", $session->site);
            //$session->smarty->display($session->config->theme);
        }
   
    gz_output(9, 1, 1); //Compression Level, ShowSpeed, ShowCompression
?>