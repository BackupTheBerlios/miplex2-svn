<?php /* Smarty version 2.6.3, created on 2004-09-30 17:39:36
         compiled from admin/page/ce/text.tpl */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'strip', 'admin/page/ce/text.tpl', 1, false),)), $this); ?>
<p><div style="width:550px;"><textarea id='htmlarea' name="data" cols="40" rows="25"><?php echo ((is_array($_tmp=$this->_tpl_vars['ce']['data'])) ? $this->_run_mod_handler('strip', true, $_tmp) : smarty_modifier_strip($_tmp)); ?>
</textarea></div></p>