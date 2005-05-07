<h2>{$i18n->get("section.deletePage")}</h2>

<div style="text-align:center;">
	<h3>{$path}</h3>

	<p>{$i18n->get("section.deletePageHinweis")}</p>

	<form action="?module=page&amp;part=page&amp;path={$path}&amp;action=save" method="post">
		<p id="ok">
			<input class="ok" type="submit" name="savePage" value="{$i18n->get("section.yes")}" />
		</p>
		<p id="cancel">
			<input class="cancel" type="submit" name="cancel" value="{$i18n->get("section.no")}" />
		</p>
		<input type="hidden" name="type" value="delete" />
		<input type="hidden" name="path" value="{$path}" />
	</form>
</div>