<?php /* Smarty version 2.6.3, created on 2004-10-04 22:51:31
         compiled from admin/settings/settings.tpl */ ?>
<?php $this->assign('i18nsettings', $this->_tpl_vars['i18n']->getSection("settings.basesettings")); ?>
<h2><?php echo $this->_tpl_vars['i18nsettings']->get('name'); ?>
</h2>

<form action="" method="POST">

    <h3><?php echo $this->_tpl_vars['i18nsettings']->get('system'); ?>
</h3>
    <table class="settings">
    <tr><td class="caption"><?php echo $this->_tpl_vars['i18nsettings']->get('docroot'); ?>
: </td><td><input type="text" name="data[docroot]" value="<?php echo $this->_tpl_vars['config']->docroot; ?>
" /></td></tr>
    <tr><td class="caption"><?php echo $this->_tpl_vars['i18nsettings']->get('serverroot'); ?>
: </td><td> <input type="text" name="data[fileSystemRoot]" value="<?php echo $this->_tpl_vars['config']->fileSystemRoot; ?>
" /></td></tr>
    <tr><td class="caption"><?php echo $this->_tpl_vars['i18nsettings']->get('extdir'); ?>
: </td><td> <input type="text" name="data[extDir]" value="<?php echo $this->_tpl_vars['config']->extDir; ?>
" /></td></tr>
    <tr><td class="caption"><?php echo $this->_tpl_vars['i18nsettings']->get('libdir'); ?>
: </td><td> <input type="text" name="data[libDir]" value="<?php echo $this->_tpl_vars['config']->libDir; ?>
" /></td></tr>
    <tr><td class="caption"><?php echo $this->_tpl_vars['i18nsettings']->get('htmlareadir'); ?>
:</td><td> <input type="text" name="data[htmlAreaDir]" value="<?php echo $this->_tpl_vars['config']->htmlAreaDir; ?>
" /></td></tr>
    <tr><td class="caption"><?php echo $this->_tpl_vars['i18nsettings']->get('smartydir'); ?>
:</td><td>  <input type="text" name="data[smartyDir]" value="<?php echo $this->_tpl_vars['config']->smartyDir; ?>
" /></td></tr>
    <tr><td class="caption"><?php echo $this->_tpl_vars['i18nsettings']->get('xpathdir'); ?>
: </td><td> <input type="text" name="data[xpathDir]" value="<?php echo $this->_tpl_vars['config']->xpathDir; ?>
" /></td></tr>
    <tr><td class="caption"><?php echo $this->_tpl_vars['i18nsettings']->get('miplexdir'); ?>
: </td><td> <input type="text" name="data[miplexDir]" value="<?php echo $this->_tpl_vars['config']->miplexDir; ?>
" /></td></tr>
    <tr><td class="caption"><?php echo $this->_tpl_vars['i18nsettings']->get('tpldir'); ?>
: </td><td> <input type="text" name="data[tplDir]" value="<?php echo $this->_tpl_vars['config']->tplDir; ?>
" /></td></tr>
    <tr><td class="caption"><?php echo $this->_tpl_vars['i18nsettings']->get('server'); ?>
: </td><td> <input type="text" name="data[server]" value="<?php echo $this->_tpl_vars['config']->server; ?>
" /></td></tr>
    </table>
    
    <h3><?php echo $this->_tpl_vars['i18nsettings']->get('management'); ?>
</h3>
    <table class="settings">
    <tr><td class="caption"><?php echo $this->_tpl_vars['i18nsettings']->get('imagefolder'); ?>
: </td><td> <input type="text" name="data[imageFolder]" value="<?php echo $this->_tpl_vars['config']->imageFolder; ?>
" /></td></tr>
    <tr><td class="caption"><?php echo $this->_tpl_vars['i18nsettings']->get('configdir'); ?>
: </td><td> <input type="text" name="data[configDir]" value="<?php echo $this->_tpl_vars['config']->configDir; ?>
" /></td></tr>
    <tr><td class="caption"><?php echo $this->_tpl_vars['i18nsettings']->get('contentdir'); ?>
: </td><td> <input type="text" name="data[contentDir]" value="<?php echo $this->_tpl_vars['config']->contentDir; ?>
" /></td></tr>
    <tr><td class="caption"><?php echo $this->_tpl_vars['i18nsettings']->get('contentfilename'); ?>
: </td><td> <input type="text" name="data[contentFileName]" value="<?php echo $this->_tpl_vars['config']->contentFileName; ?>
" /></td></tr>
    <tr><td class="caption"><?php echo $this->_tpl_vars['i18nsettings']->get('basename'); ?>
: </td><td> <input type="text" name="data[baseName]" value="<?php echo $this->_tpl_vars['config']->baseName; ?>
" /></td></tr>
    <tr><td class="caption"><?php echo $this->_tpl_vars['i18nsettings']->get('usehtmlarea'); ?>
: </td><td> <input type="text" name="data[useHtmlArea]" value="<?php echo $this->_tpl_vars['config']->useHtmlArea; ?>
" /></td></tr>
    </table>
    
    <h3><?php echo $this->_tpl_vars['i18nsettings']->get('thememgmt'); ?>
</h3>
    
    <table class="settings">
    <tr><td class="caption"><?php echo $this->_tpl_vars['i18nsettings']->get('theme'); ?>
: </td><td> <input type="text" name="data[theme]" value="<?php echo $this->_tpl_vars['config']->theme; ?>
" /></td></tr>
    </table>
    
    <h3><?php echo $this->_tpl_vars['i18nsettings']->get('meta'); ?>
</h3>
    
    <table class="settings">
    <tr><td class="caption"><?php echo $this->_tpl_vars['i18nsettings']->get('keywords'); ?>
: </td><td> <input type="text" name="data[keywords]" value="<?php echo $this->_tpl_vars['config']->keywords; ?>
" /></td></tr>
    <tr><td class="caption"><?php echo $this->_tpl_vars['i18nsettings']->get('description'); ?>
: </td><td> <input type="text" name="data[description]" value="<?php echo $this->_tpl_vars['config']->description; ?>
" /></td></tr>
    <tr><td class="caption"><?php echo $this->_tpl_vars['i18nsettings']->get('title'); ?>
: </td><td> <input type="text" name="data[title]" value="<?php echo $this->_tpl_vars['config']->title; ?>
" /></td></tr>
    </table>
    
    <h3><?php echo $this->_tpl_vars['i18nsettings']->get('content'); ?>
</h3>
    
    <table class="settings">
    <tr><td class="caption"><?php echo $this->_tpl_vars['i18nsettings']->get('position'); ?>
: </td><td> <input type="text" name="data[position]" value="<?php echo $this->_tpl_vars['config']->position; ?>
" /></td></tr>
    <tr><td class="caption"><?php echo $this->_tpl_vars['i18nsettings']->get('defaultposition'); ?>
: </td><td> <input type="text" name="data[defaultPosition]" value="<?php echo $this->_tpl_vars['config']->defaultPosition; ?>
" /></td></tr>
    </table>
    <br />
    <input type="submit" name="save" value="Abspeichern" />
</form>