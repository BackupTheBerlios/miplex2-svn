{*add new User*}
<h2>{$user->get("add")}</h2>
<form action="{$baseUrl}" method="post">
    <table>
        <tr>
            <td>{$user->get("username")}:</td>
            <td><input type="text" name="user[attributes][username]" value="" /></td>
        </tr>
        <tr>
            <td>{$user->get("password")}:</td>
            <td><input type="text" name="user[attributes][password]" value="" /></td>
        </tr>
        <tr>
            <td>{$user->get("email")}:</td>
            <td><input type="text" name="user[attributes][email]" value="" /></td>
        </tr>
        <tr>
            <td>{$user->get("group")}</td>
            <td><select name="group">{html_options values=$groups output=$groups}</select></td>
        </tr>
    </table>
    <input type='submit' name='save' value='{$user->get('save')}' />
    <input type='submit' name='cancel' value='{$user->get('cancel')}' />
    <input type='hidden' name='type' value='addUser' />
</form>
