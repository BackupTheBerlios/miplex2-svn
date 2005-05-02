    <!-- Hauptteil -->
<table width="100%" class="blogTable">

    <tr>

    {* Anzeige Teil f�r die Daten *}
    <td width="75%">{include file=$content}</td>
    
    {* Anzeige Teil f�r das Menu *}
    <td>
    
        <div class='blogTitle'><a href='{$url}.html'>{$config.blogTitle}</a></div>
        
        <p>Hei�e Eisen</p>
            {foreach item=entry from=$weblog->getMostActiveEntries()}
                <div class='blogActiveEntry'><a href="{$url}//single/{$entry.number}.html">{$entry.attributes.title}({$entry.numberOfComments})</a></div>
            {/foreach}
        
        {* Ausgabe der Kategorien *}
        <p>Kategorien</p>
            <ul>
            {foreach item=mi from=$categories}
                <li><a href="{$url}//cat/{$mi}.html">{$mi}</a></li>
            {/foreach}
            </ul>
        <p>Die Letzten
            {foreach item=entry from=$weblog->getlastXEntries(5)}
                <div class='blogActiveEntry'><a href="{$url}//single/{$entry.number}.html">{$entry.attributes.title}({$entry.numberOfComments})</a></div>
            {/foreach}    
        </p>
    
        
        

    <p>Feeds:
    <div><a href='{$config.root}/index.xml'>RSS 2.0 Feed</a></div></p>
    </td>
    
    </tr>
    
</table>
