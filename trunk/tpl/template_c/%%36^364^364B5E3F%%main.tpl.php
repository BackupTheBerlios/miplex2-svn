<?php /* Smarty version 2.6.3, created on 2004-09-22 11:45:12
         compiled from admin/page/main.tpl */ ?>
<?php $this->assign('i18nsection', $this->_tpl_vars['i18n']->getSection('section')); ?>
<table width="100%" border="0" class="pageMain">

    <tr valign="top">
                <td class="pageMainMenu">
            <div style="margin:20px;">
            <?php echo $this->_tpl_vars['page_list']; ?>

            </div>
        </td>
    
                <td>
            <div><?php echo $this->_tpl_vars['error']; ?>
</div>
            <div style="margin:20px;">
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['content'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <div>
        </td>
    </tr>
    
</table>