<?php

    if ($_POST['save'])
    {
        $newConf = new MiplexConfig();
        foreach ($_POST['data'] as $key => $val) {
        	$newConf->$key = stripslashes($val);
        }
        $string = serialize($newConf);
        $fp = fopen("config/config.ser","w");
        $ret = fwrite($fp, $string);
        fclose($fp);
        
    }
    $session->saveAndResetSite();
    $session->smarty->assign("config", $session->config);
    $session->smarty->assign("content", "admin/settings/settings.tpl");

?>