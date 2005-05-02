<h1>Aktuelle Angebote</h1>

<a href="{$url}&amp;mode=allg">Allgemein</a>
{foreach from=$rubriken item=rubrik}
	- <a href="{$url}&amp;mode=rubrik&amp;rid={$rubrik.name}">Rubrik: {$rubrik.name}</a>
{/foreach}
- <a href="{$url}&amp;mode=rubrik&amp;rid=new">Neue Rubrik</a>
<hr />

<div style="padding: 5px;">
{if $mode eq "rubrik"}
	{include file="angebote/admin/rubrik.tpl"}
{else}
	{include file="angebote/admin/allg.tpl"}
{/if}
</div>