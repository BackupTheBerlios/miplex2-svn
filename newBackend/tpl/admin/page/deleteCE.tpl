<h2>{$i18n->get("ce.deleteCe")}</h2>

<p style="text-align:center;">{$i18n->get("ce.deleteHinweis")}</p>

<form action="?module=page&amp;part=ce&amp;action=save&amp;path={$path}" method="post">
	<p id="ok">
    	<input class="ok" type="submit" name="saveCE" value="{$i18n->get("ce.yes")}" />
    </p>
    <p id="cancel">
    	<input class="cancel" type="submit" name="cancelCE" value="{$i18n->get("ce.no")}" />
    </p>

    <input type="hidden" name="type" value="delete" />
    <input type="hidden" name="path" value="{$path}" />
    <input type="hidden" name="ceKey" value="{$value}" />
</form>