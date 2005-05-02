<h2>Neuer Eintrag</h2>
<form action="{$url}" method="POST">
<table>
    <tr>
        <td>Kategorie:</td>
        <td><select name="blog[attributes][category]">
        {foreach item=category from=$cats}
            <option name="{$category}">{$category}</option>
        {/foreach}
        </select>
        </td>
    </tr>
    <tr><td>Titel:</td><td><input type="text" name="blog[attributes][title]" /></td></tr>
    {if $config.useTeaser eq 1}
    <tr><td>Teaser:</td><td><textarea id="hta2" name="blog[teaser]" cols="40" rows="10"></textarea></td></tr>
    {/if}
    <tr><td>Text:</td><td><textarea id="htmlarea" name="blog[body]" cols="40" rows="20"></textarea></td></tr>
</table>
<input type="hidden" name="blog[attributes][author]" value="{$config.params.author}" />
<input type="hidden" name="blog[attributes][date]" value="{$smarty.now|date_format:"%d-%m-%Y"}" />
<input type="hidden" name="action" value="addEntry" />
<input type="hidden" name="part" value="Blog" />
<input type="submit" name="eintragen" value="Eintragen" />

    
    
</form>

