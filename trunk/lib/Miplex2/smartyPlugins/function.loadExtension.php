<?php
function smarty_function_loadExtension($params, &$smarty)
{
    //fetch plugin name
    $extName = $params['name'];
    $config =& $params['config'];

    if (empty($extName))
        return "No Extension selected";
        
    
    // now we got the name and the params so lets include and pass
    require_once($config->miplexDir."ExtensionManager.class.php");

    $extManager = new ExtensionManager($config);
    
    $ext = $extManager->loadExtension($extName);
    
    if ($ext != false)
        return $ext->main($extParams);
    else 
        return "Plugin not Found";
}
?>