{*add new User*}
<h2>{$group->get("add")}</h2>
<form action="{$baseUrl}" method="post">
    <table>
        <tr>
            <td>{$group->get("name")}:</td>
            <td><input type="text" name="group[name]" value="" style="width:200px;"/></td>
        </tr>
        <tr>
            <td>{$right->get("rights")}</td>
            <td><select name="group[rights][]" size="10" multiple="yes" style="width:200px;">
            {html_options from=$allRights output=$allRights values=$allRights}
            </select></td>
        </tr>
    </table>
    <input type='submit' name='save' value='{$user->get('save')}' />
    <input type='submit' name='cancel' value='{$user->get('cancel')}' />
    <input type='hidden' name='type' value='addGroup' />
</form>
