<?php /* Smarty version 2.6.3, created on 2004-09-23 08:19:59
         compiled from admin/page/deleteSection.tpl */ ?>
Wollen Sie dieses Seite mit allen Inhaltselementen löschen?

<form action="?module=page&part=page&action=save" method="POST">
    <input type="submit" name="savePage" value="Ja" />
    <input type="submit" name="cancelPage" value="Nein" />
    <input type="hidden" name="type" value="delete" />
    <input type="hidden" name="path" value="<?php echo $this->_tpl_vars['path']; ?>
" />
</form>