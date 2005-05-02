<ul class="sitemap-menu">
{foreach item=element from=$Site}
	<li><strong><a href="{$element.link}" title="{$element.desc}">{$element.name}</a></strong>
		<br />
		{$element.desc}
	{if $element.subs neq ""}
		<ul>
		{foreach item=subelement from=$element.subs}
			<li><a href="{$subelement.link}" title="{$subelement.desc}">{$subelement.name}</a></li>
		{/foreach}
		</ul>
	{/if}
	</li>
{/foreach}
</ul>

<ul class="sitemap-nomenu">
{foreach item=element from=$noSite}
	<li><strong><a href="{$element.link}" title="{$element.desc}">{$element.name}</a></strong>
		<br />
		{$element.desc}
	</li>
{/foreach}
</ul>