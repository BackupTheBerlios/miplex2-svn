<h3>Bildergalerie</h3>

<form action='{$url}' method="post">
	<fieldset style="float: left; width: 45%;">
		<legend>Bilder</legend>
		<p>
			<label style="float: left; display: block; width: 10em;">Bilderordner*:</label>
				<input type="text" size="20" name="data[folder]" value="{$extConfig.folder}" />
		</p>

		<p>
			<label style="float: left; display: block; width: 10em;">Maximale Bildbreite*/***:</label>
				<input type="text" size="20" name="data[maxwidth]" value="{$extConfig.maxwidth}" />
		</p>

		<p>
			<label style="float: left; display: block; width: 10em;">Maximale Bildh�he*/***:</label>
				<input type="text" size="20" name="data[maxheight]" value="{$extConfig.maxheight}" />
		</p>
	</fieldset>

	<fieldset style="float: right; width: 45%;">
		<legend>Vorschau</legend>
		<p>
			<label style="float: left; display: block; width: 14em;">Vorschaubilderordner**:</label>
				<input type="text" size="20" name="data[thumbfolder]" value="{$extConfig.thumbfolder}" />
		</p>

		<p>
			<label style="float: left; display: block; width: 14em;">Vorschaubildbreite***:</label>
				<input type="text" size="20" name="data[thumbwidth]" value="{$extConfig.thumbwidth}" />
		</p>

		<p>
			<label style="float: left; display: block; width: 14em;">Vorschaubildh�he***:</label>
				<input type="text" size="20" name="data[thumbheight]" value="{$extConfig.thumbheight}" />
		</p>

		<p>
			<label style="float: left; display: block; width: 14em;">Anzahl der Vorschaubilder je �bersichtsseite:</label>
				<input type="text" size="20" name="data[thumbcount]" value="{$extConfig.thumbcount}" />
		</p>
	</fieldset>

	{if $allesOk}
		<p class="hinweis" style="text-align: center;">Ihre Eingaben wurden gespeichert.</p>
	{/if}

	{if $error neq ""}
		<p class="error">Sie haben keinen g�ltigen <em>Pfad zur Ergebnisseite</em> angegeben.</p>
	{/if}

	<p id="ok">
		<input type="submit" class="ok" name="save" value="Speichern" />
	</p>
	<p id="cancel">
		<input type="reset" class="cancel" name='cancel' value="Zur�cksetzen" />
	</p>

	<br class="clearer" />
</form>

<br style="clear:both; margin: 15px;" />
<br style="clear:both;" />

<p>*: Diese Angaben dienen dazu, zu gro�e Bilder, die eventuell nicht vollst�ndig angezeigt werden k�nnen, zu erkennen und nicht in die Gallerie auf zu nehmen.
      Bitte ver�ndern Sie diese Werte nur, wenn Sie sich sicher sind.</p>
<p>**: Angaben relativ zum eingestellten <em>Docroot</em> ohne f�hrendes oder folgendes "/"</p></div>
<p>***: Angaben in ganzen Pixel</p>