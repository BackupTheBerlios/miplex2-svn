<h2>Rubrik: {$myRubrik.name}</h2>
{if $myRubrik eq ""}
	<form action='{$url}&amp;mode=rubrik&amp;rid={$myRubrik.name}' method="POST">
		<div style="float:left; width: 500px;">

			<div style="width:150px; float:left;"><p style="margin-top: 0px;">Rubrik-Name: </p></div>
			<div style="float:left;"><input type="text" size="50" name="newName" value="{$myRubrik.name}" /></div>
			<br style="clear:both;" />

			{if $myRubrik eq ""}
				<div style="float:right;"><input type="submit" name="addRubrik" value="Anlegen" /></div>
			{else}
				<div style="float:right;"><input type="submit" name="deleteRubrik" value="Löschen" title="Mit der Rubrik werden auch alle Angebote in dieser Rubrik gelöscht."/></div>
				<div style="float:right;"><input type="submit" name="changeName" value="Speichern" /></div>
			{/if}
		</div>
	</form>
<br style="clear:both;" /-->
{/if}

{if $myRubrik neq ""}
	<ul style="font-size: 12px; width: 80%;">
	{foreach from=$myRubrik.angebote key=nummer item=angebot}
		{if $aid eq $angebot.id}
			<li><strong>{$angebot.titel}</strong> - {$angebot.kurzbeschreibung}</li>
		{else}
			<li><a href="{$url}&amp;mode=rubrik&amp;rid={$myRubrik.name}&amp;aid={$angebot.id}">{$angebot.titel}</a> - {$angebot.kurzbeschreibung}</li>
		{/if}
	{/foreach}
		{if $aid eq "new"}
			<li><strong>Neues Angebot erstellen</strong></li>
		{else}
			<li><a href="{$url}&amp;mode=rubrik&amp;rid={$myRubrik.name}&amp;aid=new">Neues Angebot erstellen</a></li>
		{/if}
	</ul>

	{if isset ($aid)}
			<hr />
			{include file="angebote/admin/detail.tpl"}
	{/if}
{/if}

