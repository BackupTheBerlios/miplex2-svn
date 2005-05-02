<h2>{$user->get("list")}</h2>
{if $users != ""}

    <table width="100%">
        <tr>
            <td>{$user->get("username")}</td>
            <td>{$user->get("group")}</td>
            <td>&nbsp;</td>
        </tr>
        
        {*For each user display single row*}
        {foreach item=user_item from=$users}
        <tr>
            <td>{$user_item.username}</td>
            <td>{$user_item.group}</td>
            <td><a href='{$baseUrl}&action=edit&value={$user_item.username}'>Bearbeiten</a></td>
        </tr>
        {/foreach}
    </table>

{else}
Keine Benutzer vorhanden.
{/if}
