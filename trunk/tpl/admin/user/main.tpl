{assign var=user value=$i18n->getSection("settings.user")}
<h1>Benutzerverwaltung</h1>


<table class="" width="100%">
    
    <tr>
        <td>
            <ul>
            
                <li><a href='?part='>{$user->get("list")}</a></li>
                <li><a href='?module=settings&part=user&action=add'>{$user->get("add")}</a></li>
                <li>{$user->get("edit")}</li>
                <li>{$user->get("delete")}</li>
            
            </ul>
        
        </td>
        <td>
        
            {include file=$user_content}
        
        </td>
    </tr>

</table>