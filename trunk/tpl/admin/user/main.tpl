{assign var=user value=$i18n->getSection("settings.user")}
{assign var=group value=$i18n->getSection("settings.group")}
{assign var=right value=$i18n->getSection("settings.right")}

{assign var=baseUrl value="?module=settings&part=user"}
<h1>Benutzerverwaltung</h1>


<table class="" width="100%">
    
    <tr>
        <td align="left" width="30%">
            <ul>
            
                <li><a href='{$baseUrl}&action=list'>{$user->get("list")}</a></li>
                <li><a href='?module=settings&part=user&action=add'>{$user->get("add")}</a></li>
                <li><a href='{$baseUrl}&action=gadd'>{$group->get("add")}</a></li>
                <li><a href='{$baseUrl}&action=glist'>{$group->get("list")}</a></li>
            </ul>
        
        </td>
        <td align="left">
            
            {include file=$user_content}
        
        </td>
    </tr>

</table>
