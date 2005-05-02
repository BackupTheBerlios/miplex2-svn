<div class="gallery" style="text-align: center;">
<div class="kopf">
	<a href="{$Uebersicht}" title="zurück zur Übersicht">nach oben</a>
</div>
	{$Image}
<div class="fuss-links" style="width: 48%; text-align:right; float:left;">
	{if $zurueckLink neq ""}
		<a href="{$zurueckLink}" title="vorheriges Bild betrachen">zurück</a>
	{/if}
</div>
<div class="fuss-rechts" style="width: 48%; text-align:left; float:right;">
	{if $vorLink neq ""}
		<a href="{$vorLink}" title="das nächste Bild betrachen">vor</a>
	{/if}
</div>
</div>