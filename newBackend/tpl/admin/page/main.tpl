{assign var=i18nsection value=$i18n->getSection("section")}

{*Baumansicht der Seite*}
	{$page_list}

{*Contentbereich*}
	<div id="content">
		{include file=$content}
	</div>

<br style="clear: both;"/>