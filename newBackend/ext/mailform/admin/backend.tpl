<h2>{$extMeta.extName} <small>({$extMeta.basename})</small></h2>

<form action='{$url}' method="post">

	<fieldset style="margin: auto; width:37em; margin-top: 1em;">
		<legend>Einstellungen</legend>
		<p><label for="from" style="float: left; display: block; width: 10em;">Absenderadresse:</label>
			<input class="text" type="text" size="50" id="from" name="data[from]" value="{$extConfig.from}" />
		</p>

		<p><label for="to" style="float: left; display: block; width: 10em;">Empfängeradresse:</label>
			<input class="text" type="text" size="50" id="to" name="data[to]" value="{$extConfig.to}"/>
		</p>

		<p><label for="subject" style="float: left; display: block; width: 10em;">Betreffzeile:</label>
			<input class="text" type="text" size="50" name="data[subject]" value="{$extConfig.subject}"/>
		</p>
	</fieldset>

	{if $allesOk}
		<p class="hinweis" style="text-align: center;">Ihre Eingaben wurden gespeichert.</p>
	{/if}

	{if $error neq ""}
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