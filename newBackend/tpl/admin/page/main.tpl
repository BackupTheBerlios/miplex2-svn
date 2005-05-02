{assign var=i18nsection value=$i18n->getSection("section")}
<table width="100%" border="0" class="pageMain">

    <tr valign="top">
        {*Baumansicht der Seite*}
        <td class="pageMainMenu">
            <div style="margin:20px;">
            {$page_list}
            </div>
        </td>
    
        {*Contentbereich*}
        <td>
            <div>{$error}</div>
            <div style="margin:20px;">
            {include file=$content}
            <div>
        </td>
    </tr>
    
</table>