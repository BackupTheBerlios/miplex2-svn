<h2>Bildergalerie</h2>

<a href="{$url}&amp;mode=allg">Allgemein</a> -
<a href="{$url}&amp;mode=bilder">Bilder</a> -
<a href="{$url}&amp;mode=neu">Neue Bilder</a>
<hr />

<div style="padding: 5px;">
{if $mode eq "bilder"}
	{include file="gallery/admin/bilder.tpl"}
{elseif $mode eq "neu"}
	{include file="gallery/admin/neu.tpl"}
{else}
	{include file="gallery/admin/backend.tpl"}
{/if}
</div>