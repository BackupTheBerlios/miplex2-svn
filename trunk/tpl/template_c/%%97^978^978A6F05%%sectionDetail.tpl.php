<?php /* Smarty version 2.6.3, created on 2004-09-23 07:28:09
         compiled from admin/page/sectionDetail.tpl */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sectionForm', 'admin/page/sectionDetail.tpl', 7, false),)), $this); ?>
Hinzufügen einer Seite nach dem Pfad: <?php echo $this->_tpl_vars['path']; ?>


<?php $this->assign('linkp', "?module=page&part=page&path=".($this->_tpl_vars['path'])); ?>

<form action='<?php echo $this->_tpl_vars['linkp']; ?>
&action=save' method="POST">

    <?php echo smarty_function_sectionForm(array('page' => $this->_tpl_vars['page'],'link' => $this->_tpl_vars['linkp'],'path' => $this->_tpl_vars['path']), $this);?>

    
    <input type="hidden" name="path" value="<?php echo $this->_tpl_vars['path']; ?>
" />
    <input type="hidden" name="type" value="<?php echo $this->_tpl_vars['type']; ?>
" />
    
    <input type="submit" name='savePage' value="Speichern" />
    <input type="submit" name='cancel' value="Abbrechen" />
</form>