{foreach item=maingroup key=name from=$elemente}
{*Hauptgruppen*}
	<h4>{$name}</h4>
	{foreach item=element from=$maingroup}
	{*Gruppen*}
		{if $element.typ eq "special"}
			<div style="margin: 20px; border: 2px solid #E0BC75; padding: 0px;">
			{if $element.title neq ""}
				<h4 style="color: #003366; text-align: center; margin: 0px; padding: 5px;">{$element.title}</h4>
			{/if}
			<p style="padding: 5px; margin: 0px;">{$element.text}</p>
			</div>
		{elseif $element.typ eq "anotation"}
			<div style="margin: 0px 10px 5px 10px; color: #999999; font-size: 0.8em;">
			<p><strong>Anmerkung: 
			{if $element.title neq ""}
				<em>{$element.title}</em>
			{/if}</strong>
			{$element.text}</p>
			</div>
		{else}
			<fieldset style="margin-bottom: 2px;">
			{if $element.name neq ""}
			<legend>{$element.name}</legend>
			{/if}
			{foreach item=position from=$element.positions}
				<div style="margin: 5px; clear:both; padding: 2px;">
					<div style="float:left;">{$position.desc} :</div>
					<div style="float:right; font-weight: bold">{$position.price}</div>
				</div>
			{/foreach}
			</fieldset>
		{/if}
	{/foreach}
{/foreach}