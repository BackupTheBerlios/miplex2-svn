<?php /* Smarty version 2.6.3, created on 2004-09-24 11:07:26
         compiled from admin/page/pageMain.tpl */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'admin/page/pageMain.tpl', 36, false),)), $this); ?>

<?php $this->assign('linkce', "?module=page&part=ce&path=".($this->_tpl_vars['path']));  $this->assign('linkp', "?module=page&part=page&path=".($this->_tpl_vars['path'])); ?>
<table class="sectionTable">

     <tr>
        <td class='clear'><a href="<?php echo $this->_tpl_vars['linkp']; ?>
&action=inner">Neue Seite innerhalb</a></td>
        <td class='clear'><a href="<?php echo $this->_tpl_vars['linkp']; ?>
&action=after">Neue Seite danach</a></td>
        <td class='clear'><a href="<?php echo $this->_tpl_vars['linkp']; ?>
&action=up">Seite nach oben bewegen</a></td>
        <td class='clear'><a href="<?php echo $this->_tpl_vars['linkp']; ?>
&action=down">Seite nach unten bewegen</a></td>
    </tr>

    <tr>
        <td><strong>Start:</strong><?php echo $this->_tpl_vars['page']->attributes['visibleFrom']; ?>
</td>
        <td><strong>Name:</strong><?php echo $this->_tpl_vars['page']->attributes['name']; ?>
</td>
        <td><strong>Im Menü:</strong><?php echo $this->_tpl_vars['page']->attributes['inMenu']; ?>
</td>
        <td><strong>Erweiterungen erlaubt:</strong><?php echo $this->_tpl_vars['page']->attributes['allowExtension']; ?>
</td>
    <tr>
    <tr>
        <td><strong>Stop:</strong><?php echo $this->_tpl_vars['page']->attributes['visibleTill']; ?>
</td>
        <td><strong>Alias:</strong><?php echo $this->_tpl_vars['page']->attributes['alias']; ?>
</td>
        <td><strong>Shortcut:</strong><?php echo $this->_tpl_vars['page']->attributes['shortcut']; ?>
</td>
        <td><strong>Skript erlaubt:</strong><?php echo $this->_tpl_vars['page']->attributes['allowScript']; ?>
</td>
    <tr>
    <tr>
        <td><a href='?module=page&part=ce&action=new&value=-1&path=<?php echo $this->_tpl_vars['path']; ?>
' title='Neues Element danach'>Neuer Inhalt</a></td>
        <td><strong><?php echo $this->_tpl_vars['i18n']->get("section.draft"); ?>
:</strong> <?php echo $this->_tpl_vars['page']->attributes['draft']; ?>
</td>
        <td><a href='<?php echo $this->_tpl_vars['linkp']; ?>
&action=edit' title="Seite bearbeiten">Seite bearbeiten</a></td>
        <td><a href='?module=page&part=page&action=delete&path=<?php echo $this->_tpl_vars['path']; ?>
' title='Diese Seite löschen'>Seite löschen</a></td>
    </tr>
   
</table>

    <form action="?module=page&path=<?php echo $this->_tpl_vars['path']; ?>
" method="GET">
    <p><?php echo $this->_tpl_vars['i18n']->get("ce.position"); ?>
: <select name='filter'><?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['position'],'output' => $this->_tpl_vars['position'],'selected' => $this->_tpl_vars['ce']['attributes']['position']), $this);?>
</select>
    <input type="submit" name="go" value="Go" /></p>
    <input type="hidden" name="module" value="page" />
    <input type="hidden" name="path" value="<?php echo $this->_tpl_vars['path']; ?>
" />
    </form>
    
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/page/contentElement.tpl", 'smarty_include_vars' => array('linkp' => $this->_tpl_vars['linkp'],'linkce' => $this->_tpl_vars['linkce'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>