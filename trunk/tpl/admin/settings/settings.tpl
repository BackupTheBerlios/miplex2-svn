{assign var=i18nsettings value=$i18n->getSection("settings.basesettings")}
<h2>{$i18nsettings->get('name')}</h2>

<form action="" method="POST">

    <h3>{$i18nsettings->get('system')}</h3>
    <table class="settings">
    <tr><td class="caption">{$i18nsettings->get('docroot')}: </td><td><input type="text" name="data[docroot]" value="{$config->docroot}" /></td></tr>
    <tr><td class="caption">{$i18nsettings->get('serverroot')}: </td><td> <input type="text" name="data[fileSystemRoot]" value="{$config->fileSystemRoot}" /></td></tr>
    <tr><td class="caption">{$i18nsettings->get('extdir')}: </td><td> <input type="text" name="data[extDir]" value="{$config->extDir}" /></td></tr>
    <tr><td class="caption">{$i18nsettings->get('libdir')}: </td><td> <input type="text" name="data[libDir]" value="{$config->libDir}" /></td></tr>
    <tr><td class="caption">{$i18nsettings->get('htmlareadir')}:</td><td> <input type="text" name="data[htmlAreaDir]" value="{$config->htmlAreaDir}" /></td></tr>
    <tr><td class="caption">{$i18nsettings->get('smartydir')}:</td><td>  <input type="text" name="data[smartyDir]" value="{$config->smartyDir}" /></td></tr>
    <tr><td class="caption">{$i18nsettings->get('xpathdir')}: </td><td> <input type="text" name="data[xpathDir]" value="{$config->xpathDir}" /></td></tr>
    <tr><td class="caption">{$i18nsettings->get('miplexdir')}: </td><td> <input type="text" name="data[miplexDir]" value="{$config->miplexDir}" /></td></tr>
    <tr><td class="caption">{$i18nsettings->get('tpldir')}: </td><td> <input type="text" name="data[tplDir]" value="{$config->tplDir}" /></td></tr>
    <tr><td class="caption">{$i18nsettings->get('server')}: </td><td> <input type="text" name="data[server]" value="{$config->server}" /></td></tr>
    </table>
    
    <h3>{$i18nsettings->get('management')}</h3>
    <table class="settings">
    <tr><td class="caption">{$i18nsettings->get('imagefolder')}: </td><td> <input type="text" name="data[imageFolder]" value="{$config->imageFolder}" /></td></tr>
    <tr><td class="caption">{$i18nsettings->get('configdir')}: </td><td> <input type="text" name="data[configDir]" value="{$config->configDir}" /></td></tr>
    <tr><td class="caption">{$i18nsettings->get('contentdir')}: </td><td> <input type="text" name="data[contentDir]" value="{$config->contentDir}" /></td></tr>
    <tr><td class="caption">{$i18nsettings->get('contentfilename')}: </td><td> <input type="text" name="data[contentFileName]" value="{$config->contentFileName}" /></td></tr>
    <tr><td class="caption">{$i18nsettings->get('basename')}: </td><td> <input type="text" name="data[baseName]" value="{$config->baseName}" /></td></tr>
    <tr><td class="caption">{$i18nsettings->get('usehtmlarea')}: </td><td> <input type="text" name="data[useHtmlArea]" value="{$config->useHtmlArea}" /></td></tr>
    </table>
    
    <h3>{$i18nsettings->get('thememgmt')}</h3>
    
    <table class="settings">
    <tr><td class="caption">{$i18nsettings->get('theme')}: </td><td> <input type="text" name="data[theme]" value="{$config->theme}" /></td></tr>
    </table>
    
    <h3>{$i18nsettings->get('meta')}</h3>
    
    <table class="settings">
    <tr><td class="caption">{$i18nsettings->get('keywords')}: </td><td> <input type="text" name="data[keywords]" value="{$config->keywords}" /></td></tr>
    <tr><td class="caption">{$i18nsettings->get('description')}: </td><td> <input type="text" name="data[description]" value="{$config->description}" /></td></tr>
    <tr><td class="caption">{$i18nsettings->get('title')}: </td><td> <input type="text" name="data[title]" value="{$config->title}" /></td></tr>
    </table>
    
    <h3>{$i18nsettings->get('content')}</h3>
    
    <table class="settings">
    <tr><td class="caption">{$i18nsettings->get('position')}: </td><td> <input type="text" name="data[position]" value="{$config->position}" /></td></tr>
    <tr><td class="caption">{$i18nsettings->get('defaultposition')}: </td><td> <input type="text" name="data[defaultPosition]" value="{$config->defaultPosition}" /></td></tr>
    </table>
    <br />
    <input type="submit" name="save" value="Abspeichern" />
</form>
