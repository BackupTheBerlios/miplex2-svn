{*add new User*}
<h2>{$user->get("edit")}</h2>
<form action="{$baseUrl}" method="post">
    <table>
        <tr>
            <td>{$user->get("username")}:</td>
            <td><input type="text" name="user[attributes][username]" value="{$user_item.username}" /></td>
        </tr>
        <tr>
            <td>{$user->get("password")}:</td>
            <td><input type="text" name="user[attributes][password]" value="{$user_item.password}" /></td>
        </tr>
        <tr>
            <td>{$user->get("email")}:</td>
            <td><input type="text" name="user[attributes][email]" value="{$user_item.email}" /></td>
        </tr>
        <tr>
            <td>{$user->get("group")}</td>
            <td><select name="user[group]">{html_options values=$groups output=$groups selected=$user_item.group}</select></td>
        </tr>
    </table>
    <input type='submit' name='save' value='{$user->get('save')}' />
    <input type='submit' name='cancel' value='{$user->get('cancel')}' />
    <input type='hidden' name='type' value='editUser' />
    <input type="hidden" name="key" value="{$key}" />
</form>
