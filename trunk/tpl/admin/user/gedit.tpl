{*edit Group*}
<h2>{$group->get("add")}</h2>
<form action="{$baseUrl}" method="post">
    <table>
        <tr>
            <td>{$group->get("name")}:</td>
            <td><input type="text" name="group[name]" value="{$egroup.name}" style="width:200px;"/></td>
        </tr>
        <tr>
            <td>{$right->get("rights")}</td>
            <td><select name="group[rights][]" size="10" multiple="yes" style="width:200px;">
            {foreach item=sr from=$allRights}
                {assign var=sel value=""}
                {foreach item=gr from=$groupRights}
                    {if $gr == $sr}
                        {assign var=sel value=" selected='1'"}
                    {/if}
                {/foreach}
               <option value="{$sr}" {$sel}>{$sr}</option>
            {/foreach}
            </select></td>
        </tr>
    </table>
    <input type='submit' name='save' value='{$user->get('save')}' />
    <input type='submit' name='cancel' value='{$user->get('cancel')}' />
    <input type='hidden' name='type' value='addGroup' />
</form>
