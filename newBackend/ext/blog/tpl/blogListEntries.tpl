<div>
    <form action="{$url}&part=list" method="POST">
    Kategorie: <select name="cname" onchange="submit();">{html_options values=$cats output=$cats selected=$gname}</select>
    <input type="submit" name="s" value="OK" />
    </form>
</div>
{foreach item=entry from=$list}
    
    {include file=blog/tpl/blogEntryBackend.tpl blog=$entry}

{/foreach}