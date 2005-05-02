<div class="gallery" style="margin:20px 0px 0px 20px;">
	{foreach key=schluessel item=wert from=$Images}
		<div style="width:150px; height:150px; float:left; text-align:center; padding: 5px;">
			{$wert}
		</div>
	{/foreach}

	<br style="clear:both;" />

	<div class="fuss-links" style="width: 45%; text-align:right; float:left;">
		{if $zurueckLink neq ""}
			<a href="{$zurueckLink}" title="vorherige Bilder betrachen">
				<img src="/img/gallerynavi/osl.png" alt="vor" title="Zur vorherigen Übersichtsseite..." />
			</a>
		{/if}
		&nbsp;
	</div>
	<div class="fuss-mitte" style="width: 10%; text-align: center; float:left;">
		{if $vorLink neq ""}
			{if $zurueckLink neq ""}
				<img src="/img/gallerynavi/dots.png" alt="..." title="" />
			{/if}
		{/if}
		&nbsp;
	</div>
	<div class="fuss-rechts" style="width: 45%; text-align:left; float:right;">
		{if $vorLink neq ""}
			<a href="{$vorLink}" title="die nächsten Bilder betrachen">
				<img src="/img/gallerynavi/osr.png" alt="vor" title="Zur nächsten Übersichtsseite..." />
			</a>
		{/if}
	</div>
</div>