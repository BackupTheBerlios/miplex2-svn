{if sizeof($ergebnisse) neq 0}
<ul class="ergebnisse">
{foreach item=element from=$ergebnisse}
	<li><strong><a href="{$element.url}" title="Dieses Angebot genauer ansehen...">{$element.title}</a></strong>
		<br />
		{$element.shortdesc}
	</li>
{/foreach}
</ul>
{else}
	<p>Es wurden keine Angebote gefunden, die Ihrer Anfrage entsprechen. Bitte verallgemeinern Sie 
	die Anfrage oder nutzen Sie <a href="/cms/aktangebote.html" title="Zur Rubrikenübersicht...">die Möglichkeit
	alle Angebote</a> zu durchblättern.</p>
{/if}