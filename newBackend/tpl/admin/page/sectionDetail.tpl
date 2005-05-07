<h2>
{php}
	if ($_GET['action'] == "edit")
	{
{/php}
	{$i18n->get("section.editPage")}
{php}
	}
	else
	{
{/php}
	{$i18n->get("section.newPageAfter")}
{php}
	}
{/php}
: "{$path}"</h2>

{assign var=linkp value="?module=page&amp;part=page&amp;path=$path"}
<div id="sectionAttr">
	<form action='{$linkp}&amp;action=save' method="post">

		{sectionForm page=$page link=$linkp path=$path}

			<input type="hidden" name="path" value="{$path}" />
			<input type="hidden" name="type" value="{$type}" />

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