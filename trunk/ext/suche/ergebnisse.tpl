<ul class="ergebnisse">
{foreach item=element from=$Ergebnisse}
	<li><strong><a href="{$element.link}" title="{$element.desc}">{$element.name}</a></strong>
		<br />
		{$element.desc}
	</li>
{/foreach}
</ul>