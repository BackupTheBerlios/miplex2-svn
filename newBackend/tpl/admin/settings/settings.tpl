{assign var=i18ns value=$i18n->getSection("settings.basesettings")}
{assign var="path" value="admin.php?module=settings&amp;part=settings"}

<h2>{$i18ns->get('name')}</h2>

<form action="{$path}" method="post" id="settingsForm">

{* Switch between old and new configuration to fill form with new values *}
{if isset($newConf)}
	{assign var="oldConf" value=$config}
	{assign var="config" value=$newConf}
{/if}

	<div class="left">
		<fieldset>
			<legend>{$i18ns->get("contentGroup")}</legend>
			<p>
				<label for="data_baseName">{$i18ns->get('basename')}*<sup>1</sup>:</label>
					<input class="text" type="text" name="data[baseName]" id="data_baseName" value="{$config->baseName}" />
			</p>

			<p>
				<label for="data_contentFileName">{$i18ns->get('contentfilename')}*<sup>2</sup>:</label>
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
				<label for="data_theme">{$i18ns->get('theme')}*<sup>3</sup>:</label>
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

{* Switch back *}
{if isset($oldConf)}
	{assign var="config" value=$oldConf}
{/if}

	<p id="ok">
	    <input type="submit" class="ok" name="save" value="{$i18ns->get("save")}" />
	</p>
	<p id="cancel">
		<input type="submit" class="cancel" name='cancel' value="{$i18ns->get("abort")}" />
	</p>

	{if $error neq ""}
		<p class="hinweis">{$i18ns->get($error)}</p>
	{/if}
</form>
