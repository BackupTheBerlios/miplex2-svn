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
			<p title="{$i18ns->get("basenameTitle")}">
				<label class="required" for="data_baseName">{$i18ns->get('basename')}*<sup>1</sup>:</label>
					<input class="text" type="text" name="data[baseName]" id="data_baseName" value="{$config->baseName}" />
			</p>

			<p title="{$i18ns->get("contentfilenameTitle")}">
				<label class="required" for="data_contentFileName">{$i18ns->get('contentfilename')}*<sup>2</sup>:</label>
					<input class="text" type="text" name="data[contentFileName]" id="data_contentFileName" value="{$config->contentFileName}" />
			</p>

			<p title="{$i18ns->get("usehtmlareaTitle")}">
				<label for="data_useHtmlArea">{$i18ns->get('usehtmlarea')}:</label>
					<input type="checkbox" name="data[useHtmlArea]" id="data_useHtmlArea" {if $config->useHtmlArea}checked="checked"{/if} />
			</p>
		</fieldset>
	</div>

	<div class="right">
		<fieldset>
			<legend>{$i18ns->get("designGroup")}</legend>
			<p title="{$i18ns->get("themeTitle")}">
				<label class="required" for="data_theme">{$i18ns->get('theme')}*<sup>3</sup>:</label>
					<input class="text" type="text" name="data[theme]" id="data_theme" value="{$config->theme}" />
			</p>

			<p title="{$i18ns->get("positionTitle")}">
				<label class="required" for="data_position">{$i18ns->get('position')}**:</label>
					<input class="text" type="text" name="data[position]" id="data_position" value="{$config->position}" />
			</p>

			<p title="{$i18ns->get("defaultpositionTitle")}">
				<label class="required" for="data_defaultPosition">{$i18ns->get('defaultposition')}**:</label>
					<input class="text" type="text" name="data[defaultPosition]" id="data_defaultPosition" value="{$config->defaultPosition}" />
			</p>
		</fieldset>
	</div>

	<fieldset style="clear: both;" title="{$i18ns->get("metaGroupTitle")}">
		<legend>{$i18ns->get("metaGroup")}</legend>
		<p title="{$i18ns->get("keywordsTitle")}">
			<label for="data_keywords">{$i18ns->get('keywords')}:</label>
				<input size="70" maxlength="255" class="text" type="text" name="data[keywords]" id="data_keywords" value="{$config->keywords}" />
		</p>

		<p title="{$i18ns->get("descriptionTitle")}">
			<label for="data_description">{$i18ns->get('description')}:</label>
				<input size="70" maxlength="255" class="text" type="text" name="data[description]" id="data_description" value="{$config->description}" />
		</p>

		<p title="{$i18ns->get("titleTitle")}">
			<label for="data_title">{$i18ns->get('title')}:</label>
				<input size="70" maxlength="255" class="text" type="text" name="data[title]" id="data_title" value="{$config->title}" />
		</p>
	</fieldset>

{* Switch back *}
{if isset($oldConf)}
	{assign var="config" value=$oldConf}
{/if}

	{if $error neq ""}
		<p class="error">{$i18ns->get($error)}</p>
	{/if}

	<p id="ok">
	    <input type="submit" class="ok" name="save" value="{$i18ns->get("save")}" />
	</p>
	<p id="cancel">
		<input type="reset" class="cancel" name='cancel' value="{$i18ns->get("abort")}" />
	</p>
	<br class="clearer" />

	<p class="hinweis">
		* {$i18ns->get("onestar")}<br />
		<sup>1</sup>: <code>{$sup1}</code> - <sup>2</sup>: <code>{$sup2}</code> - <sup>3</sup>: <code>{$sup3}</code>
	</p>

	<p class="hinweis">
		** {$i18ns->get("twostars")}
	</p>
</form>
