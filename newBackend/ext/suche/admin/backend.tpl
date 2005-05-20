<h2>{$extMeta.extName} <small>({$extMeta.basename})</small></h2>

<form action='{$url}' method="post">

<p>Hier können Sie auswählen, welche Position Inhaltselemente haben müssen, damit sie bei der Suche
   berücksichtigt werden. Mehrfachauswahl ist mit Hilfe der <code>Shift</code> oder <code>Strg</code> Taste möglich.</p>

<fieldset style="width: 26em; margin: auto;">
	<legend>Such-Einstellungen</legend>

	<p>
		<label for="searchedCes" style="float: left; display: block; width: 13em;">Berücksichtigte Positionen</label>
		<select id="searchedCes" name="searchedCes[]" size="{$AnzahlCes}" multiple>
		{foreach item=auswahl from=$Ces}
			<option value="{$auswahl.value}"
				{if $auswahl.selected}
					selected
				{/if}
				>{$auswahl.name}</option>
		{/foreach}
		</select>
	</p>

	<p>
		<label for="searchurl" style="float: left; display: block; width: 13em;" class="required">Pfad zur Ergebnisseite</label>
		<input id="searchurl" name="searchurl" type="text" class="text" value="{$searchurl}" />
	</p>

</fieldset>

	{if $allesOk}
		<p class="hinweis" style="text-align: center;">Ihre Eingaben wurden gespeichert.</p>
	{/if}

	{if $error eq "noSearchURL"}
		<p class="error">Sie haben keinen gültigen <em>Pfad zur Ergebnisseite</em> angegeben.</p>
	{/if}

	<p id="ok">
	    <input type="submit" class="ok" name="save" value="Speichern" />
	</p>
	<p id="cancel">
		<input type="reset" class="cancel" name='cancel' value="Zurücksetzen" />
	</p>
	<br class="clearer" />
</form>

<p id="extensionFooter">{$extMeta.extName} v{$extMeta.version} &middot; <a href="mailto:{$extMeta.mail}" title="Dem Author dieser Erweiterung eine E-Mail schreiben.">{$extMeta.author}</a></p>