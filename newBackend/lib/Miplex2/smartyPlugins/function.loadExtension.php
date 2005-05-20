<?php
function smarty_function_loadExtension($params, &$smarty)
{
    //fetch plugin name
    $extName = $params['name'];
    $config =& $params['config'];

    if (empty($extName))
        return "No Extension selected";
        

    $extParams = array();
        
    if (isset($params['params']))
    {
        //Explode Params
        $tmpParams = explode("," , $params['params']);
        foreach ($tmpParams as $val) 
        {
            $para = explode("=", $val);
            $extParams[trim($para[0])]=trim($para[1]);
        }
    }
    
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