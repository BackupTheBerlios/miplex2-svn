<?php /* Smarty version 2.6.3, created on 2004-11-11 16:28:58
         compiled from blog/tpl/new.tpl */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'blog/tpl/new.tpl', 18, false),)), $this); ?>
<h2>Neuer Eintrag</h2>
<form action="<?php echo $this->_tpl_vars['url']; ?>
" method="POST">
<table>
    <tr>
        <td>Kategorie:</td>
        <td><select name="blog[attributes][category]">
        <?php if (count($_from = (array)$this->_tpl_vars['cats'])):
    foreach ($_from as $this->_tpl_vars['category']):
?>
            <option name="<?php echo $this->_tpl_vars['category']; ?>
"><?php echo $this->_tpl_vars['category']; ?>
</option>
        <?php endforeach; unset($_from); endif; ?>
        </select>
        </td>
    </tr>
    <tr><td>Titel:</td><td><input type="text" name="blog[attributes][title]" /></td></tr>
    <tr><td>Teaser:</td><td><textarea name="blog[teaser]" cols="40" rows="10"></textarea></td></tr>
    <tr><td>Text:</td><td><textarea id="htmlarea" name="blog[body]" cols="40" rows="20"></textarea></td></tr>
</table>
<input type="hidden" name="blog[attributes][author]" value="<?php echo $this->_tpl_vars['config']['params']['author']; ?>
" />
<input type="hidden" name="blog[attributes][date]" value="<?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d-%m-%Y") : smarty_modifier_date_format($_tmp, "%d-%m-%Y")); ?>
" />
<input type="hidden" name="action" value="addEntry" />
<input type="hidden" name="part" value="Blog" />
<input type="submit" name="eintragen" value="Eintragen" />

    
    
</form>
