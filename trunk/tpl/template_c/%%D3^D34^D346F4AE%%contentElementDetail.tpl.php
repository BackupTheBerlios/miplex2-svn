<?php /* Smarty version 2.6.3, created on 2004-10-13 14:35:36
         compiled from admin/page/contentElementDetail.tpl */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'admin/page/contentElementDetail.tpl', 17, false),array('modifier', 'strip', 'admin/page/contentElementDetail.tpl', 21, false),)), $this); ?>
<?php $this->assign('get', $this->_tpl_vars['value']-1);  $this->assign('ce', $this->_tpl_vars['page']->content[$this->_tpl_vars['get']]);  $this->assign('i18nce', $this->_tpl_vars['i18n']->getSection('ce')); ?>

<form action="?module=page&part=ce&action=save&path=<?php echo $this->_tpl_vars['path']; ?>
" method="POST">
    
    <p><?php echo $this->_tpl_vars['i18nce']->get('name'); ?>
: <input type="text" value="<?php echo $this->_tpl_vars['ce']['attributes']['name']; ?>
" name="attributes[name]" /></p>
    <p><?php echo $this->_tpl_vars['i18nce']->get('alias'); ?>
: <input type="text" value="<?php echo $this->_tpl_vars['ce']['attributes']['alias']; ?>
" name="attributes[alias]" /></p>
    <p><?php echo $this->_tpl_vars['i18nce']->get('start'); ?>
: <input type="text" value="<?php echo $this->_tpl_vars['ce']['attributes']['visibleFrom']; ?>
" name="attributes[visibleFrom]" />
    <?php echo $this->_tpl_vars['i18nce']->get('stop'); ?>
:  <input type="text" value="<?php echo $this->_tpl_vars['ce']['attributes']['visibleTill']; ?>
" name="attributes[visibleTill]" /></p>
    <?php if ($this->_tpl_vars['ce']['attributes']['draft'] == 'on'): ?>
    <?php $this->assign('check', "checked=checked "); ?>
    <?php endif; ?>
    <p><?php echo $this->_tpl_vars['i18nce']->get('draft'); ?>
: <input type="checkbox" <?php echo $this->_tpl_vars['check']; ?>
 name="attributes[draft]" />
    <p><?php echo $this->_tpl_vars['i18nce']->get('position'); ?>
: <select name='attributes[position]'><?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['position'],'output' => $this->_tpl_vars['position'],'selected' => $this->_tpl_vars['ce']['attributes']['position']), $this);?>
</select></p>
    <p><?php echo $this->_tpl_vars['i18nce']->get('content'); ?>
:</p>
    
    
    <p><div style="width:550px;"><textarea id='htmlarea' name="data" cols="40" rows="25"><?php echo ((is_array($_tmp=$this->_tpl_vars['ce']['data'])) ? $this->_run_mod_handler('strip', true, $_tmp) : smarty_modifier_strip($_tmp)); ?>
</textarea></div></p>
    
        <input type="hidden" name="path" value="<?php echo $this->_tpl_vars['path']; ?>
" />
    <input type="hidden" name="ceKey" value="<?php echo $this->_tpl_vars['value']; ?>
" />
    <input type="hidden" name="type" value="<?php echo $this->_tpl_vars['type']; ?>
" />
    <input type="hidden" name="attributes[ceType]" value="<?php echo $this->_tpl_vars['selectedType']; ?>
" />
    
    <input type="submit" name="saveCE" value="Speichern">
    
</form>
        