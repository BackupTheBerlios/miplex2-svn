<?php

require_once($system['smarty']['dir']."/libs/Smarty.class.php");

class SmartyFU extends Smarty 
{
    
    function SmartyFU()
    {
        global $system;
        
        
        $this->Smarty();
        $this->template_dir = $system['smarty']['template'];
        $this->compile_dir = $system['smarty']['c'];
        $this->config_dir = $system['smarty']['config'];
        $this->cache_dir = $system['smarty']['cache'];;
        
        //$this->caching = true;
    }
    
}


?>