Hinzufügen einer Seite nach dem Pfad: {$path}

{assign var=linkp value="?module=page&part=page&path=$path"}

<form action='{$linkp}&action=save' method="POST">

    {sectionForm page=$page link=$linkp path=$path}
    
    <input type="hidden" name="path" value="{$path}" />
    <input type="hidden" name="type" value="{$type}" />
    
    <input type="submit" name='savePage' value="Speichern" />
    <input type="submit" name='cancel' value="Abbrechen" />
</form>
