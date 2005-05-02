<div class="gallery" style="text-align: center;">
{foreach key=schluessel item=wert from=$Images}
	{$wert}
{/foreach}
<div class="fuss-links" style="width: 48%; text-align:right; float:left;">
	{if $zurueckLink neq ""}
		<a href="{$zurueckLink}" title="vorherige Bilder betrachen">zurück</a>
	{/if}
</div>
<div class="fuss-rechts" style="width: 48%; text-align:left; float:right;">
	{if $vorLink neq ""}
		<a href="{$vorLink}" title="die nächsten Bilder betrachen">vor</a>
	{/if}
</div>
</div>