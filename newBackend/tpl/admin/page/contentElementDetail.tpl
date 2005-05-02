{assign var=get value=$value-1}
{*In Get steht die Nummer des CEs*}
{assign var="ce" value=$page->content.$get}
{assign var=i18nce value=$i18n->getSection("ce")}

{*Editieren des Elements*}
<form action="?module=page&amp;part=ce&amp;action=save&amp;path={$path}" method="POST">

    <p>{$i18nce->get('name')}: <input type="text" value="{$ce.attributes.name}" name="attributes[name]" /></p>
    <p>{$i18nce->get('alias')}: <input type="text" value="{$ce.attributes.alias}" name="attributes[alias]" /></p>
    <p>{$i18nce->get('start')}: <input type="text" value="{$ce.attributes.visibleFrom}" name="attributes[visibleFrom]" />
    {$i18nce->get('stop')}:  <input type="text" value="{$ce.attributes.visibleTill}" name="attributes[visibleTill]" /></p>
    {if $ce.attributes.draft=="on"}
    {assign var=check value="checked=checked "}
    {/if}
    <p>{$i18nce->get('draft')}: <input type="checkbox" {$check} name="attributes[draft]" />
    <p>{$i18nce->get('position')}: <select name='attributes[position]'>{html_options values=$position output=$position selected=$ce.attributes.position}</select></p>
    <p>{$i18nce->get('content')}:</p>


    <p><div style="width:550px;"><textarea id='htmlarea' name="data" cols="40" rows="25">{$ce.data|strip}</textarea></div></p>

    {*Hidden Elements*}
    <input type="hidden" name="path" value="{$path}" />
    <input type="hidden" name="ceKey" value="{$value}" />
    <input type="hidden" name="type" value="{$type}" />
    <input type="hidden" name="attributes[ceType]" value="{$selectedType}" />

    <input type="submit" name="saveCE" value="Speichern">

</form>
