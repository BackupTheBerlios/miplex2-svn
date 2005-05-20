<form action='{$self}' method="post">
<fieldset>
<legend>Absender</legend>
	<span style="margin-top:5px; display:block; width:100px; float:left;">Name:</span>
	<input style="float:left; margin-top:2px;" type="text" name="mail[name]" size="40" value="{$name}" />
	<br style="clear:both" />

	<span style="margin-top:15px; display:block; width:100px; float:left;">E-Mail*:</span>
	<input style="float:left; margin-top:12px;" type="text" name="mail[add]" size="40" value="{$add}" />
	<input type="hidden" name="mail[referer]" value="{$referer}" />
</fieldset>

<fieldset style="margin:10px 0px 10px 0px;">
<legend>Text</legend>
	<span style="margin-top:15px; display:block; width:100px; float:left;">Betreff:</span>
	<input style="float:left; margin-top:12px; margin-bottom:12px;" type="text" size="40" name="mail[subject]" value="{$subject}" />
	<textarea name="mail[text]" cols="59" rows="10">{$text}</textarea>
</fieldset>
<input style="float:right; margin-bottom:10px;" type="submit" name='send' value="Abschicken" />
</form>
