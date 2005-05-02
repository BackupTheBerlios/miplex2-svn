<h2>Neues Bild</h2>

<form enctype="multipart/form-data" action="{$url}&amp;mode=neu" method="post">
	<div style="width:200px; float:left;">Position: </div>
	<div style="float:left;"><input type="text" size="30" name="data[pos]" value="{$bild.pos}"/></div>
	<br style="clear:left; margin: 5px;" />
	
	<div style="width:200px; float:left;">Titel (QuickInfo): </div>
	<div style="float:left;"><input type="text" size="30" name="data[title]" value="{$bild.title}"/></div>
	<br style="clear:left; margin: 5px;" />
	
	<div style="width:200px; float:left;">Alternativer Text: </div>
	<div style="float:left;"><input type="text" size="30" name="data[alt]" value="{$bild.alt}"/></div>
	<br style="clear:both; margin: 5px;" />
	
	<div style="width:200px; float:left;">Bilddatei: </div>
	<div style="float:left;"><input name="file" size="30" type="file" /></div>
	<br style="clear:left; margin: 5px;" />

	
	<input type="submit" name="neu" value="Speichern">
</form>