{*Einleitung*}
<p>Hier finden Sie stets neue Annoncen von freien Pachtgrundstücken, Grundstücksverkäufen oder
freien Wohnungen. Derzeit befinden sich {$AnzDerAngebote} Angebote in der Datenbank. Die Angebote
für den <a href="/cms/campingplatz/angebote.html" title="Auf die Unterseite von Campingplatz wechseln">Campingplatz 
D69</a> und das <a href="/cms/bootshaus/angebote.html" title="Die Preise und Angebote für das Bootshaus einsehen">Bootshaus 
in Zernsdorf</a> finden Sie auf den entsprechenden Seiten.</p>

{*Mögliche Rubriken*}
<h4>Die Rubriken</h4>
<p>Die Angebote sind in mehrere Rubriken unterteilt, die sich nicht überschneiden. Um eine Offerte
zu finden, die Sie interessiert können Sie die Rubriken durchblättern. Im Folgenden sind alle Rubriken
aufgelistet. Der Wert in Klammern hinter dem Rubrikname entspricht der Anzahl der Annoncen in dieser
Rubrik.</p>
<ul>
	{foreach item=rubrik from=$rubriken}
		<li>
		{if $rubrik.count neq "0"}<a href="{$rubrik.url}" title="Die Rubrik '{$rubrik.name}' durchblättern">{/if}
			{$rubrik.name}{if $rubrik.count neq "0"}</a>{/if} ({$rubrik.count} Einträge)</li>
	{/foreach}
</ul>

{*Hinweis zur Suche*}
<h4>Die Suche</h4>
<p>Wenn Sie bereits genau wissen, was Sie suchen, so können Sie auch das Suchformular auf der rechten
Seite verwenden. Geben Sie einfach ihre Begriffe in das Feld ein, wählen Sie aus, in welcher Rubrik Sie
suchen möchten und dann werden Ihnen die Treffer angezeigt.</p>

<p>Bei Fragen zu den Angeboten oder der Funktionsweise zögern Sie bitte nicht und setzen Sie sich über die
<a href="/cms/kontakt.html" title="Hier können Sie uns Fragen stellen">Kontaktmöglichkeiten</a> mit uns in Verbindung setzen</p>