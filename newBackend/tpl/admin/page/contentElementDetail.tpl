{assign var=get value=$value-1}
{*In Get steht die Nummer des CEs*}
{assign var="ce" value=$page->content.$get}
{assign var=i18nce value=$i18n->getSection("ce")}

<h2>
{php}
	if ($_GET['action'] == "edit")
	{
{/php}
	{$i18n->get("ce.edit")}
{php}
	}
	else
	{
{/php}
	{$i18n->get("ce.new")}
{php}
	}
{/php}
: "{$path}"</h2>

{*Editieren des Elements*}
<form action="?module=page&amp;part=ce&amp;action=save&amp;path={$path}" method="post">
	<div class="ceSingleAttr">

		<div class="left exception">
			<fieldset>
				<legend>{$i18n->get('ce.general')}</legend>

				<p><label for="attributes_name" class="required">{$i18n->get('ce.name')}*:</label>
						<input size="35" class="text" type="text" value="{$ce.attributes.name}" name="attributes[name]" id="attributes_name" />
				</p>

				<p><label for="attributes_alias" class="required">{$i18n->get('ce.alias')}*:</label>
						<input class="text" type="text" value="{$ce.attributes.alias}" name="attributes[alias]" id="attributes_alias" />
				</p>

				<p><label for="attributes_position">{$i18n->get('ce.position')}:</label>
						<select name='attributes[position]' id="attributes_position">{html_options values=$position output=$position selected=$ce.attributes.position}</select>
				</p>
			</fieldset>
		</div>
		<div class="right">
			<fieldset>
				<legend>{$i18n->get('ce.visibility')}</legend>

				<p><label for="attributes_visibleFrom">{$i18n->get('ce.visibleFrom')}**:</label>
						<input class="text" type="text" value="{$ce.attributes.visibleFrom}" name="attributes[visibleFrom]" id="attributes_visibleFrom" />
				</p>

				<p><label for="attributes_visibleTill">{$i18n->get('ce.visibleTill')}**:</label>
						<input class="text" type="text" value="{$ce.attributes.visibleTill}" name="attributes[visibleTill]" id="attributes_visibleTill" />
				</p>

				{if $ce.attributes.draft=="on"}
				{assign var=check value="checked=\"checked\" "}
				{/if}
				<p><label for="attributes_draft">{$i18nce->get('draft')}:</label>
						<input type="checkbox" {$check} name="attributes[draft]" id="attributes_draft" />
				</p>
			</fieldset>
		</div>

		<br style="clear:both;" />
		{*Hidden Elements*}
		<input type="hidden" name="path" value="{$path}" />
		<input type="hidden" name="ceKey" value="{$value}" />
		<input type="hidden" name="type" value="{$type}" />
		<input type="hidden" name="attributes[ceType]" value="{$selectedType}" />

		<textarea id='htmlarea' name="data" cols="40" rows="25">{$ce.data|strip}</textarea>
	</div>


	<p id="ok">
    	<input class="ok" type="submit" name="saveCE" value="{$i18n->get("ce.ok")}" />
    </p>
    <p id="cancel">
    	<input class="cancel" type="submit" name="cancel" value="{$i18n->get("ce.cancel")}" />
    </p>

    <p class="hinweis">{$i18n->get("ce.oneStar")}</p>
    <p class="hinweis">{$i18n->get("ce.twoStars")}</p>

</form>
