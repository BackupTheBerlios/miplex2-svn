{if $blog != ""}
    <div class='blogTitle'>{$blog.attributes.title}</div>
    <div class="blogTeaser">{$blog.teaser}</div>
    <div class="blogBody">{$blog.body}</div>
    <div class='blogFooter'>- veröffentlicht am {$blog.attributes.date} in {$blog.attributes.category}-</div>
    <div class="blogFooter"><a href="{$url}&part=edit&nr={$blog.number}">Bearbeiten</a> Löschen Ausblenden</div>
{/if}