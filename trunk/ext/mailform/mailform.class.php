<?php

class mailform extends Extension 
{
    var $from;
    var $to;
    
    
    function main($params)
    {
        if (!empty($params['to']))
            $this->extConfig['params']['to'] = $params['to'];
        
        if ($_POST['send'])
        {
            
            mail($this->extConfig['params']['to'], $this->extConfig['params']['subject'], $_POST['add']."\n".$_POST['text'], "From: ".$this->extConfig['params']['from']);
            
            
        } else 
            return $this->smarty->fetch("mailform/mailform.tpl");
    }
    
    
    function getBackend()
    {
        if (!$_POST['save'])
        {
            $this->smarty->assign("url", $this->getCurrentURL());
            $this->smarty->assign("extConfig", $this->extConfig['params']);
            return $this->smarty->fetch("mailform/backend.tpl");
            
        } else 
        {
            $this->extConfig['subject'] = $_POST['data']['subject'];
            $this->extConfig['from'] = $_POST['data']['from'];
            $this->extConfig['to'] = $_POST['data']['to'];
            
            $this->saveConfiguration($this->config);
            
            return $this->smarty->fetch("mailform/saved.tpl");
        }
        
    }
    
}

?>