<h1>{$i18n->get("settings")}</h1>
<table width="100%" class="settingsMain">

    <tr>
        <td width="200px">
            <ul>
                <li><a href="?module=settings&part=settings">{$i18n->get("settings.basesettings.name")}</a></li>
                <li><a href="?module=settings&part=user">{$i18n->get("settings.user.name")}</a></li>
            </ul>
        </td>
        <td>
        {include file=$content}
        </td>
    </tr>
</table>