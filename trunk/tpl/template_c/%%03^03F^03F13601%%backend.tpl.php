<?php /* Smarty version 2.6.3, created on 2004-11-11 16:00:54
         compiled from blog/tpl/backend.tpl */ ?>
<h1>Weblog</h1>
<table width="100%">
    <tr>
        <td>
            <ul>
                <li><a href='<?php echo $this->_tpl_vars['url']; ?>
&part=new'>Neuer Eintrag</a></li>
                <li>Eintrag bearbeiten</li>
                <li>Eintrag löschen</li>
                <li>Einstellungen</li>
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