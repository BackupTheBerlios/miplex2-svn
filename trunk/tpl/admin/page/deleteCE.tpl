Wollen Sie dieses Inhaltselement wirklich l�schen?

<form action="?module=page&part=ce&action=save&path={$path}" method="POST">
    <input type="submit" name="saveCE" value="Ja" />
    <input type="submit" name="cancelCE" value="Nein" />
    <input type="hidden" name="type" value="delete" />
    <input type="hidden" name="path" value="{$path}" />
    <input type="hidden" name="ceKey" value="{$value}" />
</form>