<br style="clear:both; margin-top: 5px;" />
<div class="gallery" style="text-align: center;">
	{$Image}

	<br style="clear:both; margin-top: 5px;" />
	<br style="clear:both; margin-top: 5px;" />
	
	<div class="fuss-links" style="width: 45%; text-align: right; float:left;">
		{if $zurueckLink neq ""}
			<a href="{$zurueckLink}" title="vorheriges Bild betrachen">
				<img src="/img/gallerynavi/dsl.png" alt="zur�ck" title="Zum vorherigen Bild..." style="float:right;"/>
			</a>
		{/if}
		&nbsp;
	</div>
	<div class="fuss-mitte" style="width: 10%; text-align: center; float:left;">
		<a href="{$Uebersicht}" title="Zur�ck zur �bersicht...">
			<img src="/img/gallerynavi/o.png" alt="zur �bersicht" title="" />
		</a>
	</div>
	<div class="fuss-rechts" style="width: 45%; text-align: left; float:right;">
		{if $vorLink neq ""}
			<a href="{$vorLink}" title="das n�chste Bild betrachen">
				<img src="/img/gallerynavi/dsr.png" alt="vor" title="Zum n�chsten Bild..." style="float:left;"/>
			</a>
		{/if}
	</div>
</div>
<br style="clear:both;" />