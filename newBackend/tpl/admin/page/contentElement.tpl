{foreach item=ce from=$page->content key=schl}
{assign var=schl value=$schl+1}

{if ($filter == "all") || ($filter == $ce.attributes.position)}
	<div class="ceSingleTop">
		<h4>{$ce.attributes.name}</h4>
		<ul>
			<li><a href="?module=page&amp;part=ce&amp;action=edit&amp;value={$schl}&amp;path={$path}" title="{$i18n->get('ce.editTitle')}"><img src="tpl/admin/grafiken/trans.gif" alt="{$i18n->get('ce.editTitle')}" class="edit" /></a></li>
			<li><a href="?module=page&amp;part=ce&amp;action=up&amp;value={$schl}&amp;path={$path}" title="{$i18n->get('ce.upTitle')}"><img src="tpl/admin/grafiken/trans.gif" alt="{$i18n->get('ce.upTitle')}" class="up" /></a></li>
			<li><a href="?module=page&amp;part=ce&amp;action=down&amp;value={$schl}&amp;path={$path}" title="{$i18n->get('ce.downTitle')}"><img src="tpl/admin/grafiken/trans.gif" alt="{$i18n->get('ce.downTitle')}" class="down" /></a></li>
			<li><a href="?module=page&amp;part=ce&amp;action=delete&amp;value={$schl}&amp;path={$path}" title="{$i18n->get('ce.delTitle')}"><img src="tpl/admin/grafiken/trans.gif" alt="{$i18n->get('ce.delTitle')}" class="del" /></a></li>
		</ul>
		<br style="clear: both" />
	</div>

	<div class="ceSingleAttr">
		{php}
			$visibleFromArray = explode(".", $this->_tpl_vars['ce']['attributes']['visibleFrom']);
			$this->_tpl_vars['ce']['attributes']['visibleFromTimeStamp'] = mktime (0,0,0,$visibleFromArray[1], $visibleFromArray[0], $visibleFromArray[2]);
			if ($this->_tpl_vars['ce']['attributes']['visibleFromTimeStamp'] == -1)
				$this->_tpl_vars['ce']['attributes']['visibleFromTimeStamp']= time() - 2000;

			$visibleTillArray = explode(".", $this->_tpl_vars['ce']['attributes']['visibleTill']);
			$this->_tpl_vars['ce']['attributes']['visibleTillTimeStamp'] = mktime (0,0,0,$visibleTillArray[1], $visibleTillArray[0], $visibleTillArray[2]);
			if ($this->_tpl_vars['ce']['attributes']['visibleTillTimeStamp'] == -1)
				$this->_tpl_vars['ce']['attributes']['visibleTillTimeStamp']= time() + 2000;

		{/php}

		{assign var=sichtbar value="sichtbar"}
		{if $ce.attributes.visibleFromTimeStamp > $smarty.now}
			{assign var=sichtbar value="unsichtbar"}
		{/if}
		{if $ce.attributes.visibleTillTimeStamp < $smarty.now}
			{assign var=sichtbar value="unsichtbar"}
		{/if}
		{if $ce.attributes.draft eq "on"}
			{assign var=sichtbar value="unsichtbar"}
		{/if}

		<div class="left">
			<fieldset>
				<legend>{$i18n->get('ce.general')}</legend>
				<strong>{$i18n->get('ce.alias')}:</strong> {$ce.attributes.alias}<br />
				<strong>{$i18n->get('ce.position')}:</strong> {$ce.attributes.position}<br />
				<strong>{$i18n->get('ce.lastChanged')}:</strong> {$ce.attributes.lastChanged}<br />
			</fieldset>
		</div>

		<div class="right">
			<fieldset class="{$sichtbar}">
				<legend>{$i18n->get('ce.visibility')}</legend>
				<strong>{$i18n->get('ce.visibleFrom')}:</strong>
					{if $ce.attributes.visibleFrom eq ""}
						<em>{$i18n->get('ce.visibleFromUnknown')}</em>
					{else}
						{if $ce.attributes.visibleFromTimeStamp > $smarty.now}
							<span style="color:red;">
								{$ce.attributes.visibleFrom}
							</span>
						{else}
								{$ce.attributes.visibleFrom}
						{/if}
					{/if}<br />
				<strong>{$i18n->get('ce.visibleTill')}:</strong>
					{if $ce.attributes.visibleTill eq ""}
						<em>{$i18n->get('ce.visibleTillUnknown')}</em>
					{else}
						{if $ce.attributes.visibleTillTimeStamp < $smarty.now}
							<span style="color:red;">
								{$ce.attributes.visibleTill}
							</span>
						{else}
								{$ce.attributes.visibleTill}
						{/if}
					{/if}<br />
				<strong>{$i18n->get('ce.draft')}:</strong> <img src="tpl/admin/grafiken/trans.gif" alt="{$ce.attributes.draft}" class="checkbox {$ce.attributes.draft}" /><br />
			</fieldset>
		</div>
		<br style="clear:both;" />

		<fieldset class="content_{$sichtbar}">
			<legend>{$i18n->get('ce.content')}</legend>
			{$ce.data}
		</fieldset>
		<br style="clear:both;" />
	</div>
	{*first part of content*}
{/if}

{/foreach}