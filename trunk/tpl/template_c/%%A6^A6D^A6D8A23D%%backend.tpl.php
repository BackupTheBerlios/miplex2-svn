<?php /* Smarty version 2.6.3, created on 2004-09-21 21:54:53
         compiled from mailform/backend.tpl */ ?>
<h1>Kontaktformular</h1>

<form action='<?php echo $this->_tpl_vars['url']; ?>
' method="POST">
<p>Absenderadresse: <input type="text" name="data[from]" value="<?php echo $this->_tpl_vars['extConfig']['from']; ?>
" /></p>

<p>Empfängeradresse: <input type="text" name="data[to]" value="<?php echo $this->_tpl_vars['extConfig']['to']; ?>
"/></p>

<p>Betreffzeile: <input type="text" name="data[subject]" value="<?php echo $this->_tpl_vars['extConfig']['subject']; ?>
"/></p>
<input type="submit" name="save" value="speichern" />
</form>