<h2>{$group->get("list")}</h2>
{if $groups != ""}

    <table width="100%">
        <tr>
            <td>{$group->get("name")}</td>
            <td>{$right->get("rights")}</td>
            <td>&nbsp;</td>
        </tr>
        
        {*For each user display single row*}
        {foreach item=user_item from=$groups}
        <tr>
            <td>{$user_item.name}</td>
            <td>{foreach item=g from=$user_item.rights key=n}
            {$g.name}
            {/foreach}
            </td>
            <td><a href='{$baseUrl}&action=gedit&value={$user_item.name}'>Bearbeiten</a></td>
        </tr>
        {/foreach}
    </table>

{else}
Keine Benutzer vorhanden.
{/if}
