<?php

class sitemap extends Extension 
{
    var $urlbase;

    function erstelleStruktur($site)
    {
        $jn = $jm = 0;
        for ($i = 0; $i < sizeof($site); $i++)
        {
            $po = $site[$i];
            
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
            {   // Seite wird dargestellt
                if (in_array($po->attributes['inMenu'], array("on", "true")))
                {
                    // Seite ist im Menü
                    $menu[$jm]['name'] = $po->attributes['name'];
                    $menu[$jm]['desc'] = $po->attributes['desc'];
                    $menu[$jm]['link'] = $this->urlbase.$po->path.".html";

                    $subs = $this->erstelleStruktur($po->subs);
                    if (is_array($subs["menu"]))
                        $menu[$jm]['subs'] = $subs["menu"];
                        
                    $jm++;
                }
                else
                {
                    // Seite liegt außerhalb des Menüs
                    $nomenu[$jn]['name'] = $po->attributes['name'];
                    $nomenu[$jn]['desc'] = $po->attributes['desc'];
                    $nomenu[$jn++]['link'] = $this->urlbase.$po->path.".html";
                }
            }
        }
        
        $struktur["menu"] = $menu;
        $struktur["nomenu"] = $nomenu;
        
        return $struktur;
    }
    
    function main($params)
    {
        global $session;
        $site = $session->site;
        
        $this->urlbase = $session->currentPage->config->docroot.$session->currentPage->config->baseName."/";
        
        $struktur = $this->erstelleStruktur($site);
       
        $this->smarty->assign("Site", $struktur['menu']);
        $this->smarty->assign("noSite", $struktur['nomenu']);
        $out = $this->smarty->fetch('../ext/sitemap/sitemap.tpl');
        
        return $out;
    }

    function getBackend()
    {
        return "Keine Einstellungen möglich.";
    }
    
}

?>