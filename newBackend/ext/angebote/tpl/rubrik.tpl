<h4>Die Rubrik <em>{$rubrikname}</em></h4>

<div class="fuss-links" style="width: 45%; text-align: right; float:left;">
		{if $zurueckLink neq ""}
			<a href="{$zurueckLink}" title="vorheriges Angebot betrachen">
				<img src="/img/gallerynavi/rsl.png" alt="zur�ck" title="Zum vorherigen Angebot..." style="float:right;"/>
			</a>
		{/if}
		&nbsp;
	</div>
	<div class="fuss-mitte" style="width: 10%; text-align: center; float:left;">
		<a href="{$Uebersicht}" title="Zur�ck zur �bersicht...">
			<img src="/img/gallerynavi/r.png" alt="zur �bersicht" title="" />
		</a>
	</div>
	<div class="fuss-rechts" style="width: 45%; text-align: left; float:right;">
		{if $vorLink neq ""}
			<a href="{$vorLink}" title="das n�chste Bild betrachen">
				<img src="/img/gallerynavi/rsr.png" alt="vor" title="Zum n�chsten Angebot..." style="float:left;"/>
			</a>
		{/if}
	</div>

<br style="clear:both;" />
