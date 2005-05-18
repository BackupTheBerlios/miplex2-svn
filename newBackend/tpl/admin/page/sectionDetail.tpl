{assign var=i18ns value=$i18n->getSection("section")}

<h2>
	{if $type eq "edit"}
		{$i18n->get("section.editPage")}
	{else}
		{$i18n->get("section.newPageAfter")}
	{/if}
	: "{$path}"</h2>

<div id="sectionAttr">
	<form action='?module=page&amp;part=page&amp;path={$path}&amp;action=save' method="post">

		<div class="general">
			<fieldset>
				<legend>{$i18ns->get("general")}</legend>
				<p>
					<label for="attributes_name" class="required">{$i18ns->get("name")}*:</label>
						<input class="text" type="text" name="attributes[name]" id="attributes_name" value="{$page->attributes.name}" />
				</p>

				<p>
					<label for="attributes_desc">{$i18ns->get("desc")}:</label>
						<textarea cols="55" rows="2" name="attributes[desc]" id="attributes_desc">{$page->attributes.desc}</textarea>
				</p>
			</fieldset>
		</div>

		<div class="left">
			<fieldset>
				<legend>{$i18ns->get("visibility")}</legend>
				<p>
					<label for="attributes_visibleFrom">{$i18ns->get("visibleFrom")}**:</label>
						<input class="text" type="text" name="attributes[visibleFrom]" id="attributes_visibleFrom" value="{$page->attributes.visibleFrom}" />
				</p>

				<p>
					<label for="attributes_visibleTill">{$i18ns->get("visibleTill")}**:</label>
						<input class="text" type="text" name="attributes[visibleTill]" id="attributes_visibleTill" value="{$page->attributes.visibleTill}" />
				</p>

				<p>
					<label for="attributes_draft">{$i18ns->get("draft")}:</label>
						<input type="checkbox" name="attributes[draft]" id="attributes_draft"{if $page->attributes.draft neq ""} checked="checked"{/if} />
				</p>
			</fieldset>
		</div>

		<div class="middle">
			<fieldset>
				<legend>{$i18ns->get("menuProperties")}</legend>
				<p>
					<label for="attributes_alias">{$i18ns->get("alias")}*:</label>
						<input class="text" type="text" name="attributes[alias]" id="attributes_alias" value="{$page->attributes.alias}" />
				</p>

				<p>
					<label for="attributes_shortcut">{$i18ns->get("shortcut")}:</label>
						<input class="text" type="text" name="attributes[shortcut]" id="attributes_shortcut" value="{$page->attributes.shortcut}" />
				</p>

				<p>
					<label for="attributes_inMenu">{$i18ns->get("inMenu")}:</label>
						<input type="checkbox" name="attributes[inMenu]" id="attributes_inMenu"{if $page->attributes.inMenu neq ""} checked="checked"{/if} />
				</p>
			</fieldset>
		</div>

		<div class="right">
			<fieldset>
				<legend>{$i18ns->get("dynamics")}</legend>
				<p>
					<label for="attributes_allowExtension">{$i18ns->get("allowExtension")}:</label>
						<input type="checkbox" name="attributes[allowExtension]" id="attributes_allowExtension"{if $page->attributes.allowExtension neq ""} checked="checked"{/if} />
				</p>

				<p>
					<label for="attributes_allowScript">{$i18ns->get("allowScript")}:</label>
						<input type="checkbox" name="attributes[allowScript]" id="attributes_allowScript"{if $page->attributes.allowScript neq ""} checked="checked"{/if} />
				</p>
			</fieldset>
		</div>

			<input type="hidden" name="path" value="{$path}" />
			<input type="hidden" name="type" value="{$type}" />

		<br class="clearer" />

		{foreach from=$errors item=error}
		<p class="error">{$i18ns->get($error)}</p>
		{/foreach}



		<p id="ok">
			<input type="submit" class="ok" name='savePage' value="{$i18n->get("section.save")}" />
		</p>
		<p id="cancel">
			<input type="submit" class="cancel" name='cancel' value="{$i18n->get("section.abort")}" />
		</p>
	</form>
	<br style="clear: both;" />

	<p class="hinweis">{$i18n->get("section.oneStar")}</p>
	<p class="hinweis">{$i18n->get("section.twoStars")}</p>
</div>