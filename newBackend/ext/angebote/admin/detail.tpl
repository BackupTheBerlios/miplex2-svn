<form action='{$url}&amp;mode=rubrik&amp;rid={$myRubrik.name}&amp;aid={$myAngebot.id}' method="POST">

		<div style="width:200px; float:left;">Start (TT.MM.JJJJ): </div>
		<div style="float:left;"><input type="text" size="20" name="data[start]" value="{$myAngebot.start}"/></div>
		<br style="clear:both; margin: 5px;" />

		<div style="width:200px; float:left;">Ende (TT.MM.JJJJ): </div>
		<div style="float:left;"><input type="text" size="20" name="data[ende]" value="{$myAngebot.ende}"/></div>
		<br style="clear:both; margin: 5px;" />
		
		<div style="width:200px; float:left;">Titel: </div>
		<div style="float:left;"><input type="text" size="50" name="data[titel]" value="{$myAngebot.titel}"/></div>
		<br style="clear:both; margin: 5px;" />

		<div style="width:200px; float:left;">Adresse: </div>
		<div style="float:left;">
			<textarea name="data[adresse]" cols="50" rows="10">{$myAngebot.adresse}</textarea>
		</div>
		<br style="clear:both; margin: 5px;" />

		<div style="width:200px; float:left;">Kurzbeschreibung: </div>
		<div style="float:left;">
			<textarea name="data[kurzbeschreibung]" cols="50" rows="10">{$myAngebot.kurzbeschreibung}</textarea>
		</div>
		<br style="clear:both; margin: 5px;" />

		<div style="width:200px; float:left;">Objektbeschreibung: </div>
		<div style="float:left;">
			<textarea name="data[objektbeschreibung]" cols="50" rows="10">{$myAngebot.objektbeschreibung}</textarea>
		</div>
		<br style="clear:both; margin: 5px;" />

		<div style="width:200px; float:left;">Ausstattung: </div>
		<div style="float:left;">
			<textarea name="data[ausstattung]" cols="50" rows="10">{$myAngebot.ausstattung}</textarea>
		</div>
		<br style="clear:both; margin: 5px;" />

		<div style="width:200px; float:left;">Lage: </div>
		<div style="float:left;">
			<textarea name="data[lage]" cols="50" rows="10">{$myAngebot.lage}</textarea>
		</div>
		<br style="clear:both; margin: 5px;" />

		<div style="width:200px; float:left;">Sonstiges: </div>
		<div style="float:left;">
			<textarea name="data[sonstiges]" cols="50" rows="10">{$myAngebot.sonstiges}</textarea>
		</div>
		<br style="clear:both; margin: 5px;" />

		{if $aid eq "new"}
			<input type="hidden" name="new" />
		{else}
			<div style="float:right;"><input type="submit" name="delete" value="Löschen" /></div>
		{/if}
		<div style="float:right;"><input type="submit" name="save" value="Speichern" /></div>
</form>

{if $aid neq "new"}
	
	<hr style="clear:both" />
	<h2>Bilder</h2>
	{foreach from=$myAngebot.bilder item=bild}
		<form action='{$url}&amp;mode=rubrik&amp;rid={$myRubrik.name}&amp;aid={$myAngebot.id}' method="POST" style="width: 500px;">
			<div style="width:200px; float:left;">Pfad: </div>
			<div style="float:left;"><input type="text" size="30" name="data[src]" value="{$bild.src}"/></div>
			<br style="clear:left; margin: 5px;" />
			
			<div style="width:200px; float:left;">Titel (QuickInfo): </div>
			<div style="float:left;"><input type="text" size="30" name="data[title]" value="{$bild.title}"/></div>
			<br style="clear:left; margin: 5px;" />
			
			<div style="width:200px; float:left;">Alternativer Text: </div>
			<div style="float:left;"><input type="text" size="30" name="data[alt]" value="{$bild.alt}"/></div>
			<br style="clear:both; margin: 5px;" />
			
			<input type="hidden" name="src" value="{$bild.src}" />
			
			<div style="float:right;"><input type="submit" name="imgDelete" value="Löschen" /></div>
			<div style="float:right;"><input type="submit" name="imgEdit" value="Speichern" /></div>
			<br style="clear:both; margin: 5px;" />
		</form>
	{/foreach}
	
	<hr style="clear:both" />
	<h2>Neues Bild</h2>
		<form action='{$url}&amp;mode=rubrik&amp;rid={$myRubrik.name}&amp;aid={$myAngebot.id}' method="POST" style="width: 500px;">
			<div style="width:200px; float:left;">Pfad: </div>
			<div style="float:left;"><input type="text" size="30" name="data[src]" value=""/></div>
			<br style="clear:left; margin: 5px;" />
			
			<div style="width:200px; float:left;">Titel (QuickInfo): </div>
			<div style="float:left;"><input type="text" size="30" name="data[title]" value=""/></div>
			<br style="clear:left; margin: 5px;" />
			
			<div style="width:200px; float:left;">Alternativer Text: </div>
			<div style="float:left;"><input type="text" size="30" name="data[alt]" value=""/></div>
			<br style="clear:both; margin: 5px;" />
			
			<div style="float:right;"><input type="submit" name="imgAdd" value="Speichern" /></div>
			<br style="clear:both; margin: 5px;" />
		</form>
{/if}