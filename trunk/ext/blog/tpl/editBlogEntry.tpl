<form action="{$url}" method="POST">
<table>
    <tr>
        <td>Kategorie:</td>
        <td><select name="blog[attributes][category]">
        {html_options values=$cats output=$cats selected=$blog.attributes.category}
        </select>
        </td>
    </tr>
    <tr><td>Titel:</td><td><input type="text" name="blog[attributes][title]"  value="{$blog.attributes.title}"/></td></tr>
    <tr><td>Autor:</td><td><input type="text" name="blog[attributes][author]"  value="{$blog.attributes.author}"/></td></tr>
    <tr><td>Datum:</td><td><input type="text" name="blog[attributes][date]"  value="{$blog.attributes.date}"/></td></tr>
    <tr><td>Mail:</td><td><input type="text" name="blog[attributes][mail]"  value="{$blog.attributes.mail}"/></td></tr>
    <tr><td>Teaser:</td><td><textarea id="htmlarea" name="blog[teaser]" cols="40" rows="10">{$blog.teaser}</textarea></td></tr>
    <tr><td>Text:</td><td><textarea id="htmlarea" name="blog[body]" cols="40" rows="20">{$blog.body}</textarea></td></tr>
</table>
<input type="submit" name="save" value="Speichern" />
<input type="hidden" name="context" value="{$blog.context}" />
<input type="hidden" name="action" value="editEntry" />
<input type="hidden" name="part" value="Blog" />
</form>