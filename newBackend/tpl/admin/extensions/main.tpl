	{$menu}

	<div id="content">

		{if $mode eq "NoChoice"}
			<h2>{$i18n->get("extensions.noChoice")}</h2>

			<p>{$i18n->get("extensions.noChoiceText")}</p>
		{elseif $mode eq "NoBackend"}
			<h2>{$i18n->get("extensions.noBackend")}</h2>

			<p>{$i18n->get("extensions.noBackendText")}</p>
		{else}
			{*Aktionsfeld*}
			{$content}
		{/if}

	</div>

<br style="clear: both;"/>
