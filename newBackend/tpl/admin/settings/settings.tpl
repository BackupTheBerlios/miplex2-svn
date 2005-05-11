{assign var=i18ns value=$i18n->getSection("settings.basesettings")}
{assign var="path" value="admin.php?module=settings&amp;part=settings"}

<h2>{$i18ns->get('name')}</h2>

<form action="{$path}" method="post" id="settingsForm">

	<div class="left">
		<fieldset>
			<legend>{$i18ns->get("contentGroup")}</legend>
			<p>
				<label for="data_contentFileName">{$i18ns->get('contentfilename')}*<sup>1</sup>:</label>
					<input class="text" type="text" name="data[contentFileName]" id="data_contentFileName" value="{$config->contentFileName}" />
			</p>

			<p>
				<label for="data_useHtmlArea">{$i18ns->get('usehtmlarea')}:</label>
					<input type="checkbox" name="data[useHtmlArea]" id="data_useHtmlArea" {if $config->useHtmlArea}checked="checked"{/if} />
			</p>
		</fieldset>
	</div>

	<div class="right">
		<fieldset>
			<legend>{$i18ns->get("designGroup")}</legend>
			<p>
				<label for="data_theme">{$i18ns->get('theme')}*<sup>2</sup>:</label>
					<input class="text" type="text" name="data[theme]" id="data_theme" value="{$config->theme}" />
			</p>

			<p>
				<label for="data_position">{$i18ns->get('position')}**:</label>
					<input class="text" type="text" name="data[position]" id="data_position" value="{$config->position}" />
			</p>

			<p>
				<label for="data_defaultPosition">{$i18ns->get('defaultposition')}**:</label>
					<input class="text" type="text" name="data[defaultPosition]" id="data_defaultPosition" value="{$config->defaultPosition}" />
			</p>
		</fieldset>
	</div>

	<fieldset style="clear: both;">
		<legend>{$i18ns->get("metaGroup")}</legend>
		<p>
			<label for="data_keywords">{$i18ns->get('keywords')}:</label>
				<input size="70" maxlength="255" class="text" type="text" name="data[keywords]" id="data_keywords" value="{$config->keywords}" />
		</p>

		<p>
			<label for="data_description">{$i18ns->get('description')}:</label>
				<input size="70" maxlength="255" class="text" type="text" name="data[description]" id="data_description" value="{$config->description}" />
		</p>

		<p>
			<label for="data_title">{$i18ns->get('title')}:</label>
				<input size="70" maxlength="255" class="text" type="text" name="data[title]" id="data_title" value="{$config->title}" />
		</p>
	</fieldset>


	<p id="ok">
	    <input type="submit" class="ok" name="save" value="{$i18ns->get("save")}" />
	</p>
	<p id="cancel">
		<input type="submit" class="cancel" name='cancel' value="{$i18ns->get("abort")}" />
	</p>

	<p style="display:none;">
		<input type="hidden" name="data[docroot]" value="{$config->docroot}" />
		<input type="hidden" name="data[server]" value="{$config->server}" />
		<input type="hidden" name="data[baseName]" value="{$config->baseName}" />
		<input type="hidden" name="data[fileSystemRoot]" value="{$config->fileSystemRoot}" />
		<input type="hidden" name="data[extDir]" value="{$config->extDir}" />
		<input type="hidden" name="data[libDir]" value="{$config->libDir}" />
		<input type="hidden" name="data[htmlAreaDir]" value="{$config->htmlAreaDir}" />
		<input type="hidden" name="data[smartyDir]" value="{$config->smartyDir}" />
		<input type="hidden" name="data[xpathDir]" value="{$config->xpathDir}" />
		<input type="hidden" name="data[miplexDir]" value="{$config->miplexDir}" />
		<input type="hidden" name="data[tplDir]" value="{$config->tplDir}" />
		<input type="hidden" name="data[imageFolder]" value="{$config->imageFolder}" />
		<input type="hidden" name="data[configDir]" value="{$config->configDir}" />
		<input type="hidden" name="data[contentDir]" value="{$config->contentDir}" />
	</p>
</form>
