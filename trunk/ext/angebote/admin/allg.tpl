<h2>Allgemein</h2>

{if $msg eq "ok"}
	<p>Die Änderungen wurden gespeichert.</p>
{/if}

<form action='{$url}&amp;mode=allg' method="POST">
	<div style="float:left; width: 500px;">
	
		<div style="width:150px; float:left;"><p style="margin-top: 0px;">Miplex-Pfad zur Seite mit den Details*: </p></div>
		<div style="float:left;"><input type="text" size="50" name="data[path]" value="{$extConfig.path}" /></div>
		<br style="clear:both;" />
		
		<div style="width:150px; float:left;"><p>Betreff**: </p></div>
		<div style="float:left;"><input type="text" size="50" name="data[subject]" value="{$extConfig.subject}"/></div>
		<br style="clear:both;" />
		
		<div style="width:150px; float:left;"><p>Author**: </p></div>
		<div style="float:left;"><input type="text" size="50" name="data[author]" value="{$extConfig.author}"/></div>
		<br style="clear:both;" />
		
		
		<div style="float:right;"><input type="submit" name="save" value="speichern" /></div>
	</div>
</form>


<br style="clear:both; margin: 15px;" />
<br style="clear:both;" />

<p>*: Der Pfad ist im selben Format anzugeben, wie im Falle eines <em>Shortcuts</em>. Es ist die Seite
  innerhalb der Seitenstruktur anzugeben, auf der diese Extension eingebunden wird, damit die Detailseiten
  angezeigt werden können.</p></div>
<p>**: Dieser Inhalt wird in den erzeugten pdf-Dateien in der Kopfzeile angezeigt.</p>