<h4>{$titel}</h4>

<a href="{$pdflink}" title="Hier können Sie dieses Angebot als 'pdf' auf ihrem Computer speichern.">
	<img src="/img/angebotenavi/pdf.png" alt="Hier können Sie dieses Angebot als 'pdf' auf ihrem Computer speichern" style="float:right;"/>
</a>

<a href="/cms/kontakt.html#mailformular" title="Nehmen Sie bei Interesse Kontakt mit uns auf.">
	<img src="/img/angebotenavi/mail.png" alt="Nehmen Sie bei Interesse Kontakt mit uns auf" style="float:right;"/>
</a>

{if $adresse neq ""}
	<h5>Adresse</h5>
	{$adresse}
{/if}

{if $kurzbeschreibung neq ""}
	<h5>Kurzbeschreibung</h5>
	{$kurzbeschreibung}
{/if}

{if $objektbeschreibung neq ""}
	<h5>Objektbeschreibung</h5>
	{$objektbeschreibung}
{/if}

{if $ausstattung neq ""}
	<h5>Ausstattung</h5>
	{$ausstattung}
{/if}

{if $lage neq ""}
	<h5>Lage</h5>
	{$lage}
{/if}

{if $sonstiges neq ""}
	<h5>Sonstiges</h5>
	{$sonstiges}
{/if}

{if sizeof($bilder) neq 0}
	<h5>Bilder</h5>
	{foreach item=bild from=$bilder}
		<img src="{$bild.src}" title="{$bild.title}" alt="{$bild.alt}" />
	{/foreach}
{/if}