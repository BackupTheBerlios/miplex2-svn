<?php /* Smarty version 2.6.3, created on 2004-10-13 14:48:42
         compiled from admin/settings/main.tpl */ ?>
<h1><?php echo $this->_tpl_vars['i18n']->get('settings'); ?>
</h1>
<table width="100%" class="settingsMain">

    <tr>
        <td width="200px">
            <ul>
                <li><a href="?module=settings&part=settings"><?php echo $this->_tpl_vars['i18n']->get("settings.basesettings.name"); ?>
</a></li>
                <li><a href="?module=settings&part=user"><?php echo $this->_tpl_vars['i18n']->get("settings.user.name"); ?>
</a></li>
            </ul>
        </td>
        <td>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['content'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        </td>
    </tr>
</table>