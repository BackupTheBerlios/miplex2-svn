{if $blog != ""}
    <div class='blogTitle'>{$blog.attributes.title}</div>
    <div class="blogTeaser">{$blog.teaser}</div>
    <div class="blogBody">{$blog.body}</div>
    <div class='blogFooter'>- ver�ffentlicht am {$blog.attributes.date} in {$blog.attributes.category}-</div>
    <div class="blogFooter"><a href="{$url}&part=edit&nr={$blog.number}">Bearbeiten</a> 
                            <a href="{$url}&part=delete&nr={$blog.number}">L�schen</a> 
                            Ausblenden</div>
{/if}