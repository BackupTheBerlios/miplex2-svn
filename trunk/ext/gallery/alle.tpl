<div class="gallery" style="text-align: center;">
{foreach key=schluessel item=wert from=$Images}
	{$wert}
{/foreach}
<div class="fuss-links" style="width: 48%; text-align:right; float:left;">
	{if $zurueckLink neq ""}
		<a href="{$zurueckLink}" title="vorherige Bilder betrachen">zur�ck</a>
	{/if}
</div>
<div class="fuss-rechts" style="width: 48%; text-align:left; float:right;">
	{if $vorLink neq ""}
		<a href="{$vorLink}" title="die n�chsten Bilder betrachen">vor</a>
	{/if}
</div>
</div>