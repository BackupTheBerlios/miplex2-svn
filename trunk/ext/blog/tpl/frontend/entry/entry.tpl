<!-- BLOG Eintrag -->
{foreach item=assoc from=$data}
<div class='blogTitle'><a href="{$url}/single/{$assoc.number}.html">{$assoc.attributes.title}</a></div>

{if $assoc.teaser != "" }
<div class='blogTeaser'>{$assoc.teaser}</div>
{/if}

{if $assoc.body != ""}
<div class='blogBody'>{$assoc.body}</div>
{/if}

<div class='blogFooter'>{$assoc.attributes.author} - {$assoc.attributes.date} ({$assoc.numberOfComments|string_format:"%d"} Kommentare)</div>

{* Anzeigen der Kommentare*}
{if $comments eq 1}
    <p />
    <div class='blogCommentHeader'>Kommentare</div> 
    {foreach item=kommentar from=$assoc.comments}
    
        <div class="blogComment">{$kommentar.content}</div>
        <div class='blogCommentFooter'><a href='{$kommentar.attributes.www}'>{$kommentar.attributes.author}</a> -  {$kommentar.attributes.date}</div>
    
    {/foreach}
    {if $added eq 1}
    <b>Ihr Kommentar wurde eingetragen.</b>
    {/if}
    <p />
    {if $formular eq 1}
    <div class='blogAddComment'>
        <div class="blogCommentHeader">Deine Meinung</div>
        <p />
        <form action='{$url}/add.html' method="POST">
        <table>
        <tr><td>Name:</td><td><input type="text" name="author" value="{$author.author}" /></td></tr>
        <tr><td>Mail:</td><td><input type="text" name="mail" value="{$author.mail}"/></td></tr>
        <tr><td>WWW:</td><td><input type="text" name="www" value="{$author.www}"/></td></tr>
        <tr><td>Notify:</td><td><input type="checkbox" name="notify" {if $author.notify == "on"}checked="on"{/if}/></td></tr>
        <tr><td>Keks:</td><td><input type="checkbox" name="keks" /></td></tr>
        <tr><td colspan="2"><textarea name='content' cols="40" rows="10" ></textarea></td></tr>
        </table>
        <input type="hidden" name="context" value="{$assoc.context}" />
        <input type="submit" name="submit" value="Senden" />
        </form>
    </div>
    {/if}
    

{/if}
{/foreach}
