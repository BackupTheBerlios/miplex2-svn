<?php

function smarty_function_loadPlugin($params, &$smarty)
{
    
    //fetch plugin name
    $extName = $params['name'];
    $config =& $params['config'];
    
    if (empty($extName))
        return "No Plugin selected";
        
    
    //now we got the name and the params so lets include and pass
    require_once($this->config->miplexDir."ExtensionManager.class.php");
    $extManager = new ExtensionManager($this->config);
    
    $ext = $extManager->loadExtension($extName);
    if ($ext != false)
        $ret = $ext->main($extParams);
    else 
        $ret = "Plugin not found";
    
    return $ret;
    
}


?>