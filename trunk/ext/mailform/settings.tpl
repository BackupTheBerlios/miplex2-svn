<h1>Kontaktformular</h1>

<form action='{$url}' method="POST">
<p>Absenderadresse: <input type="text" name="data[from]" value="{$extConfig.from}" /></p>

<p>Empfängeradresse: <input type="text" name="data[to]" value="{$extConfig.to}"/></p>

<p>Betreffzeile: <input type="text" name="data[subject]" value="{$extConfig.subject}"/></p>
<input type="submit" name="save" value="speichern" />
</form>