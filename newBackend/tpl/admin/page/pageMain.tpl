{*Display Page Attributes*}
{assign var=linkce value="?module=page&amp;part=ce&amp;path=$path"}
{assign var=linkp value="?module=page&amp;part=page&amp;path=$path"}

<div id="sectionTop">
	<h2>{$i18n->get("section.site")}: {$page->attributes.name}</h2>
	<ul>
		<li><a href='{$linkp}&amp;action=edit' title="{$i18n->get("section.editTitle")}"><img src="tpl/admin/grafiken/trans.gif" alt="{$i18n->get("section.editTitle")}" class="edit" /></a></li>
		<li><a href="{$linkp}&amp;action=inner" title="{$i18n->get("section.innerTitle")}"><img src="tpl/admin/grafiken/trans.gif" alt="{$i18n->get("section.innerTitle")}" class="inner" /></a></li>
		<li><a href="{$linkp}&amp;action=after" title="{$i18n->get("section.afterTitle")}"><img src="tpl/admin/grafiken/trans.gif" alt="{$i18n->get("section.afterTitle")}" class="after" /></a></li>
		<li><a href="{$linkp}&amp;action=up" title="{$i18n->get("section.upTitle")}"><img src="tpl/admin/grafiken/trans.gif" alt="{$i18n->get("section.upTitle")}" class="up" /></a></li>
		<li><a href="{$linkp}&amp;action=down" title="{$i18n->get("section.downTitle")}"><img src="tpl/admin/grafiken/trans.gif" alt="{$i18n->get("section.downTitle")}" class="down" /></a></li>
		<li><a href='?module=page&amp;part=page&amp;action=delete&amp;path={$path}' title="{$i18n->get("section.delTitle")}"><img src="tpl/admin/grafiken/trans.gif" alt="{$i18n->get("section.delTitle")}" class="del" /></a></li>
	</ul>
	<br style="clear:both;"/>
</div>

<div id="sectionTable">
	{if $page->attributes.desc neq ""}
	<fieldset>
		<legend>{$i18n->get("section.desc")}</legend>
		{$page->attributes.desc}
	</fieldset>
	{/if}
	{php}
		$visibleFromArray = explode(".", $this->_tpl_vars['page']->attributes['visibleFrom']);
		$this->_tpl_vars['page']->attributes['visibleFromTimeStamp'] = mktime (0,0,0,$visibleFromArray[1], $visibleFromArray[0], $visibleFromArray[2]);
		if ($this->_tpl_vars['page']->attributes['visibleFromTimeStamp'] == -1)
			$this->_tpl_vars['page']->attributes['visibleFromTimeStamp']= time() - 2000;

		$visibleTillArray = explode(".", $this->_tpl_vars['page']->attributes['visibleTill']);
		$this->_tpl_vars['page']->attributes['visibleTillTimeStamp'] = mktime (0,0,0,$visibleTillArray[1], $visibleTillArray[0], $visibleTillArray[2]);
		if ($this->_tpl_vars['page']->attributes['visibleTillTimeStamp'] == -1)
			$this->_tpl_vars['page']->attributes['visibleTillTimeStamp']= time() + 2000;

	{/php}

	{assign var=sichtbar value="sichtbar"}
	{if $page->attributes.visibleFromTimeStamp > $smarty.now}
		{assign var=sichtbar value="unsichtbar"}
	{/if}
	{if $page->attributes.visibleTillTimeStamp < $smarty.now}
		{assign var=sichtbar value="unsichtbar"}
	{/if}
	{if $page->attributes.draft eq "on"}
		{assign var=sichtbar value="unsichtbar"}
	{/if}
	<div id="sectionAttr">
		<div class="left">
			<fieldset class="{$sichtbar}" {if $sichtbar eq "unsichtbar"}title="{$i18n->get("section.invisble")}"{/if}>
				<legend>{$i18n->get("section.visibility")}</legend>
				<strong>{$i18n->get("section.visibleFrom")}:</strong>
					{if $page->attributes.visibleFrom eq ""}
						<em>{$i18n->get("section.visibleFromUnknown")}</em>
					{else}
						{if $page->attributes.visibleFromTimeStamp > $smarty.now}
							<span style="color:red;">
								{$page->attributes.visibleFrom}
							</span>
						{else}
								{$page->attributes.visibleFrom}
						{/if}
					{/if}<br />
				<strong>{$i18n->get("section.visibleTill")}:</strong>
					{if $page->attributes.visibleTill eq ""}
						<em>{$i18n->get("section.visibleTillUnknown")}</em>
					{else}
						{if $page->attributes.visibleTillTimeStamp < $smarty.now}
							<span style="color:red;">
								{$page->attributes.visibleTill}
							</span>
						{else}
								{$page->attributes.visibleTill}
						{/if}
					{/if}<br />
				<strong>{$i18n->get("section.draft")}:</strong> <img src="tpl/admin/grafiken/trans.gif" alt="{$page->attributes.draft}" class="checkbox {$page->attributes.draft}"/><br />
			</fieldset>
		</div>
		<div class="middle">
			<fieldset>
				<legend>{$i18n->get("section.menuProperties")}</legend>
				<strong>{$i18n->get("section.alias")}:</strong> {$page->attributes.alias}<br />
				<strong>{$i18n->get("section.shortcut")}:</strong> {if $page->attributes.shortcut eq ""}<em>{$i18n->get("section.shortcutUnknown")}</em>{else}{$page->attributes.shortcut}{/if}<br />
				<strong>{$i18n->get("section.inMenu")}:</strong> <img src="tpl/admin/grafiken/trans.gif" alt="{$page->attributes.inMenu}" class="checkbox {$page->attributes.inMenu}" /><br />
			</fieldset>
		</div>
		<div class="right">
			<fieldset>
				<legend>{$i18n->get("section.dynamics")}</legend>
				<strong>{$i18n->get("section.allowExtension")}:</strong> <img src="tpl/admin/grafiken/trans.gif" alt="{$page->attributes.allowExtension}" class="checkbox {$page->attributes.allowExtension}"/><br />
				<strong>{$i18n->get("section.allowScript")}:</strong> <img src="tpl/admin/grafiken/trans.gif" alt="{$page->attributes.allowScript}" class="checkbox {$page->attributes.allowScript}" /><br />
			</fieldset>
		</div>

		<br style="clear:both;" />
		<br style="clear:both;" />
	</div>
</div>

    {*Einbinden der Content Elemente*}
    {if $page->attributes.shortcut eq ""}
	<div id="ceTop">

		<h3>{$i18n->get("ce.ces")}</h3>

		<ul>
			<li>
				<a href="?module=page&amp;part=ce&amp;action=new&amp;value=-1&amp;path={$path}"
				   title="{$i18n->get("ce.newTitle")}">
						<img src="tpl/admin/grafiken/trans.gif"
							 alt="{$i18n->get("ce.newTitle")}"
							 class="new" />
				</a>
			</li>
		</ul>

	    <form action="?module=page&amp;path={$path}" method="get">
			<p>{$i18n->get("ce.filter")}:
				<select name='filter'>
					{html_options values=$position output=$position selected=$ce.attributes.position}
				</select>
				<input type="submit" name="go" value="{$i18n->get("section.submit")}" />
				<input type="hidden" name="module" value="page" />
				<input type="hidden" name="path" value="{$path}" />
			</p>
		</form>

		<br style="clear:both;"/>
	</div>
	    {include file=admin/page/contentElement.tpl linkp=$linkp linkce=$linkce}

    {else}
	<div id="ceTop">

    	<h3>Diese Seite hat keinen eigenen Inhalt</h3>
		<br style="clear:both;"/>
	</div>
    	<p>Der Besucher dieser Seite wird direkt auf die Seite
    	   <strong>{$page->attributes.shortcut}</strong> weitergeleitet. Der Inhalt dieser Seite ist
    	   also unerheblich. Deshalb wird er hier auch nicht angezeigt.</p>

    	<p>Wenn Sie m&ouml;chten, dass diese Seite eigenen Inhalt hat, dann bearbeiten Sie diese Seite
    	   und entfernen den Shortcut. Danach k&ouml;nnen Sie hier den Seiteninhalt bearbeiten.</p>
    {/if}

