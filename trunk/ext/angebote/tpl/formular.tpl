<h3>Aktuelle Angebote</h3>
<div id="suchFormular">
<form action="{$currentUrl}" method="get" title="Nach Angeboten suchen..">
	<input type="text" class="text" size="25" maxlength="255" name="s" value="{$alteBegriffe}" title="Bitte geben Sie hier ihren Suchbegriff ein" />
	
	<select name="r" size="1" style="margin-top: 10px; float:right;">
	{foreach key=rubrikvar item=rubrik from=$rubriken}
		<option value="{$rubrikvar}" {$rubrik.selected}>{$rubrik.bez}</option>
	{/foreach}
	</select>
	<br style="clear:both;" />
	<input type="submit" class="submit" value="Suchen" />
	
</form>
</div>