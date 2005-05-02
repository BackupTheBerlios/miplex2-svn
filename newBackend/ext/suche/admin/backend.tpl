<h1>Suche</h1>

<form action='{$url}' method="POST">

<p>Hier können Sie auswählen, welche Position Inhaltselemente haben müssen, damit sie bei der Suche
   berücksichtigt werden. Mehrfachauswahl ist mit Hilfe der &lt;Shift&gt;- oder &lt;Strg&gt;-Taste möglich.</p>
   
<p><select name="searchedCes[]" size="{$AnzahlCes}" multiple>
	{foreach item=auswahl from=$Ces}
		<option value="{$auswahl.value}" 
			{if $auswahl.selected}
				selected
			{/if}
			>{$auswahl.name}</option>
	{/foreach}
	</select>

	<input type="submit" name="save" value="speichern" />
</p>

</form>