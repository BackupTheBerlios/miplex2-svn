<h3>Alle Bilder</h3>
{foreach from=$bilder item=bild}
	<form action='{$url}&amp;mode=bilder' method="POST" style="width: 620px;">
		<div style="float:right;">{$bild.thumb}</div>

		<div style="width:200px; float:left;">Position*: </div>
		<div style="float:left;"><input type="text" size="30" name="data[pos]" value="{$bild.pos}"/></div>
		<br style="clear:left; margin: 5px;" />

		<div style="width:200px; float:left;">Titel (QuickInfo)**: </div>
		<div style="float:left;"><input type="text" size="30" name="data[title]" value="{$bild.title}"/></div>
		<br style="clear:left; margin: 5px;" />

		<div style="width:200px; float:left;">Alternativer Text***: </div>
		<div style="float:left;"><input type="text" size="30" name="data[alt]" value="{$bild.alt}"/></div>
		<br style="clear:both; margin: 5px;" />

		<input type="hidden" name="name" value="{$bild.name}" />

		<div style="float:right;"><input type="submit" name="delete" value="Löschen" /></div>
		<div style="float:right;"><input type="submit" name="edit" value="Speichern" /></div>
		<br style="clear:both; margin: 5px;" />
	</form>
{/foreach}

<br style="clear:both; margin: 15px;" />
<br style="clear:both;" />

<p>*: Dieses Feld dient dazu, die Reihenfolge der Bilder innerhalb der Gallerie festzulegen. Die Bilder werden anhand dieses Feldes sortiert.</p>
<p>**: Dieses Feld wird angezeigt, wenn der Besucher die Maus längere Zeit über dem Bild hält.</p>
<p>***: Dieses Feld ist für sehbehinderte Nutzer und solche, die die Anzeige von Bilder deaktiviert haben. Hier sollte eine kurze Beschreibung des Bildinhalts angegeben werden.</p>
