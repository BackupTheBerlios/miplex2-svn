{*Einleitung*}
<p>Hier finden Sie stets neue Annoncen von freien Pachtgrundst�cken, Grundst�cksverk�ufen oder
freien Wohnungen. Derzeit befinden sich {$AnzDerAngebote} Angebote in der Datenbank. Die Angebote
f�r den <a href="/cms/campingplatz/angebote.html" title="Auf die Unterseite von Campingplatz wechseln">Campingplatz 
D69</a> und das <a href="/cms/bootshaus/angebote.html" title="Die Preise und Angebote f�r das Bootshaus einsehen">Bootshaus 
in Zernsdorf</a> finden Sie auf den entsprechenden Seiten.</p>

{*M�gliche Rubriken*}
<h4>Die Rubriken</h4>
<p>Die Angebote sind in mehrere Rubriken unterteilt, die sich nicht �berschneiden. Um eine Offerte
zu finden, die Sie interessiert k�nnen Sie die Rubriken durchbl�ttern. Im Folgenden sind alle Rubriken
aufgelistet. Der Wert in Klammern hinter dem Rubrikname entspricht der Anzahl der Annoncen in dieser
Rubrik.</p>
<ul>
	{foreach item=rubrik from=$rubriken}
		<li>
		{if $rubrik.count neq "0"}<a href="{$rubrik.url}" title="Die Rubrik '{$rubrik.name}' durchbl�ttern">{/if}
			{$rubrik.name}{if $rubrik.count neq "0"}</a>{/if} ({$rubrik.count} Eintr�ge)</li>
	{/foreach}
</ul>

{*Hinweis zur Suche*}
<h4>Die Suche</h4>
<p>Wenn Sie bereits genau wissen, was Sie suchen, so k�nnen Sie auch das Suchformular auf der rechten
Seite verwenden. Geben Sie einfach ihre Begriffe in das Feld ein, w�hlen Sie aus, in welcher Rubrik Sie
suchen m�chten und dann werden Ihnen die Treffer angezeigt.</p>

<p>Bei Fragen zu den Angeboten oder der Funktionsweise z�gern Sie bitte nicht und setzen Sie sich �ber die
<a href="/cms/kontakt.html" title="Hier k�nnen Sie uns Fragen stellen">Kontaktm�glichkeiten</a> mit uns in Verbindung setzen</p>