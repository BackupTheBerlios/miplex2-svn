{foreach item=ce from=$page->content key=schl}
{assign var=schl value=$schl+1}

    {if $filter == "all"}
    <div class='ceMain' style="">
        <div class="ceHeadLink" style=''>
            <a href='?module=page&part=ce&action=new&value={$schl}&path={$path}' title='Neues Element danach'>{$i18n->get('ce.new')}</a>
            <a href="?module=page&part=ce&action=edit&value={$schl}&path={$path}" title='Element bearbeiten'>{$i18n->get('ce.edit')}</a>
            <a href="?module=page&part=ce&action=delete&value={$schl}&path={$path}" title="Element löschen">{$i18n->get('ce.delete')}</a>
            <a href="?module=page&part=ce&action=up&value={$schl}&path={$path}" title="Element nach oben bewegen">{$i18n->get('ce.moveup')}</a>
            <a href="?module=page&part=ce&action=down&value={$schl}&path={$path}" title="Element nach unten bewegen">{$i18n->get('ce.movedown')}</a>
        </div>
        <div class="ceHead">
        <strong>{$ce.attributes.name}</strong>
        </div>
        
        <div class="ceHead">
            {$i18n->get('ce.start')}: {$ce.attributes.visibleFrom}<br>
            {$i18n->get('ce.stop')}:  {$ce.attributes.visibleTill}<br>
            {$i18n->get('ce.position')}:  {$ce.attributes.position}<br>
        </div>
        {*first part of content*}
        <div class="ceBody">{$ce.data|strip_tags}</div>
    </div>
    {else}
        {if $filter == $ce.attributes.position}
            <div class='ceMain' style="">
                <div class="ceHeadLink" style=''>
                    <a href='?module=page&part=ce&action=new&value={$schl}&path={$path}' title='Neues Element danach'>{$i18n->get('ce.new')}</a>
                    <a href="?module=page&part=ce&action=edit&value={$schl}&path={$path}" title='Element bearbeiten'>{$i18n->get('ce.edit')}</a>
                    <a href="?module=page&part=ce&action=delete&value={$schl}&path={$path}" title="Element löschen">{$i18n->get('ce.delete')}</a>
                    <a href="?module=page&part=ce&action=up&value={$schl}&path={$path}" title="Element nach oben bewegen">{$i18n->get('ce.moveup')}</a>
                    <a href="?module=page&part=ce&action=down&value={$schl}&path={$path}" title="Element nach unten bewegen">{$i18n->get('ce.movedown')}</a>
                </div>
                <div class="ceHead">
                <strong>{$ce.attributes.name}</strong>
                </div>
                
                <div class="ceHead">
                    {$i18n->get('ce.start')}: {$ce.attributes.visibleFrom}<br>
                    {$i18n->get('ce.stop')}:  {$ce.attributes.visibleTill}<br>
                    {$i18n->get('ce.position')}:  {$ce.attributes.position}<br>
                </div>
                {*first part of content*}
                <div class="ceBody">{$ce.data|strip_tags}</div>
            </div>
        {/if}
    {/if}
    
{/foreach}