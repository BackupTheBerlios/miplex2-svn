<h1>Bildergalerie</h1>

<form action='{$url}' method="POST">
	<div style="float:left; width: 450px;">
		<div style="width:300px; float:left;">Bilderordner*: </div>
		<div style="float:left;"><input type="text" size="20" name="data[folder]" value="{$extConfig.folder}" /></div>
		<br style="clear:both; margin: 5px;" />
		
		<div style="width:300px; float:left;">Maximale Bildbreite*/***: </div>
		<div style="float:left;"><input type="text" size="20" name="data[maxwidth]" value="{$extConfig.maxwidth}"/></div>
		<br style="clear:both; margin: 5px;" />
		
		<div style="width:300px; float:left;">Maximale Bildh�he*/***: </div>
		<div style="float:left;"><input type="text" size="20" name="data[maxheight]" value="{$extConfig.maxheight}"/></div>
		<br style="clear:both; margin: 5px;" />

		<div style="width:300px; float:left;">Vorschaubilderordner**: </div>
		<div style="float:left;"><input type="text" size="20" name="data[thumbfolder]" value="{$extConfig.thumbfolder}"/></div>
		<br style="clear:both; margin: 5px;" />
		
		<div style="width:300px; float:left;">Vorschaubildbreite***: </div>
		<div style="float:left;"><input type="text" size="20" name="data[thumbwidth]" value="{$extConfig.thumbwidth}"/></div>
		<br style="clear:both; margin: 5px;" />
		
		<div style="width:300px; float:left;">Vorschaubildh�he***: </div>
		<div style="float:left;"><input type="text" size="20" name="data[thumbheight]" value="{$extConfig.thumbheight}"/></div>
		<br style="clear:both; margin: 5px;" />
		
		<div style="width:300px; float:left;">Anzahl der Vorschaubilder je �bersichtsseite: </div>
		<div style="float:left;"><input type="text" size="20" name="data[thumbcount]" value="{$extConfig.thumbcount}"/></div>
		<br style="clear:both; margin: 5px;" />
		
		<div style="float:right;"><input type="submit" name="save" value="speichern" /></div>
	</div>
</form>

<br style="clear:both; margin: 15px;" />
<br style="clear:both;" />

<p>*: Diese Angaben dienen dazu, zu gro�e Bilder, die eventuell nicht vollst�ndig angezeigt werden k�nnen, zu erkennen und nicht in die Gallerie auf zu nehmen.
      Bitte ver�ndern Sie diese Werte nur, wenn Sie sich sicher sind.</p>
<p>**: Angaben relativ zum eingestellten <em>Docroot</em> ohne f�hrendes oder folgendes "/"</p></div>
<p>***: Angaben in ganzen Pixel</p>