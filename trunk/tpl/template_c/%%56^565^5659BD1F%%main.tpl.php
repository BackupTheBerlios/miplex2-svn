<?php /* Smarty version 2.6.3, created on 2004-11-10 14:51:10
         compiled from admin/user/main.tpl */ ?>
<?php $this->assign('user', $this->_tpl_vars['i18n']->getSection("settings.user")); ?>
<h1>Benutzerverwaltung</h1>


<table class="" width="100%">
    
    <tr>
        <td>
            <ul>
            
                <li><a href='?part='><?php echo $this->_tpl_vars['user']->get('list'); ?>
</a></li>
                <li><a href='?module=settings&part=user&action=add'><?php echo $this->_tpl_vars['user']->get('add'); ?>
</a></li>
                <li><?php echo $this->_tpl_vars['user']->get('edit'); ?>
</li>
                <li><?php echo $this->_tpl_vars['user']->get('delete'); ?>
</li>
            
            </ul>
        
        </td>
        <td>
        
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['user_content'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        
        </td>
    </tr>

</table>