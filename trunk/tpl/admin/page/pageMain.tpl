
{*Display Page Attributes*}
{assign var=linkce value="?module=page&part=ce&path=$path"}
{assign var=linkp value="?module=page&part=page&path=$path"}
<table class="sectionTable">

     <tr>
        <td class='clear'><a href="{$linkp}&action=inner">Neue Seite innerhalb</a></td>
        <td class='clear'><a href="{$linkp}&action=after">Neue Seite danach</a></td>
        <td class='clear'><a href="{$linkp}&action=up">Seite nach oben bewegen</a></td>
        <td class='clear'><a href="{$linkp}&action=down">Seite nach unten bewegen</a></td>
    </tr>

    <tr>
        <td><strong>Start:</strong>{$page->attributes.visibleFrom}</td>
        <td><strong>Name:</strong>{$page->attributes.name}</td>
        <td><strong>Im Menü:</strong>{$page->attributes.inMenu}</td>
        <td><strong>Erweiterungen erlaubt:</strong>{$page->attributes.allowExtension}</td>
    <tr>
    <tr>
        <td><strong>Stop:</strong>{$page->attributes.visibleTill}</td>
        <td><strong>Alias:</strong>{$page->attributes.alias}</td>
        <td><strong>Shortcut:</strong>{$page->attributes.shortcut}</td>
        <td><strong>Skript erlaubt:</strong>{$page->attributes.allowScript}</td>
    <tr>
    <tr>
        <td><a href='?module=page&part=ce&action=new&value=-1&path={$path}' title='Neues Element danach'>Neuer Inhalt</a></td>
        <td><strong>{$i18n->get("section.draft")}:</strong> {$page->attributes.draft}</td>
        <td><a href='{$linkp}&action=edit' title="Seite bearbeiten">Seite bearbeiten</a></td>
        <td><a href='?module=page&part=page&action=delete&path={$path}' title='Diese Seite löschen'>Seite löschen</a></td>
    </tr>
   
</table>

    <form action="?module=page&path={$path}" method="GET">
    <p>{$i18n->get("ce.position")}: <select name='filter'>{html_options values=$position output=$position selected=$ce.attributes.position}</select>
    <input type="submit" name="go" value="Go" /></p>
    <input type="hidden" name="module" value="page" />
    <input type="hidden" name="path" value="{$path}" />
    </form>
    
    {*Einbinden der Content Elemente*}
    {include file=admin/page/contentElement.tpl linkp=$linkp linkce=$linkce}