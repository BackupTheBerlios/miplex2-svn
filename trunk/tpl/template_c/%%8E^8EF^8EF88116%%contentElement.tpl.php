<?php /* Smarty version 2.6.3, created on 2004-09-24 11:19:24
         compiled from admin/page/contentElement.tpl */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'strip_tags', 'admin/page/contentElement.tpl', 23, false),)), $this); ?>
<?php if (count($_from = (array)$this->_tpl_vars['page']->content)):
    foreach ($_from as $this->_tpl_vars['schl'] => $this->_tpl_vars['ce']):
 $this->assign('schl', $this->_tpl_vars['schl']+1); ?>

    <?php if ($this->_tpl_vars['filter'] == 'all'): ?>
    <div class='ceMain' style="">
        <div class="ceHeadLink" style=''>
            <a href='?module=page&part=ce&action=new&value=<?php echo $this->_tpl_vars['schl']; ?>
&path=<?php echo $this->_tpl_vars['path']; ?>
' title='Neues Element danach'><?php echo $this->_tpl_vars['i18n']->get('ce.new'); ?>
</a>
            <a href="?module=page&part=ce&action=edit&value=<?php echo $this->_tpl_vars['schl']; ?>
&path=<?php echo $this->_tpl_vars['path']; ?>
" title='Element bearbeiten'><?php echo $this->_tpl_vars['i18n']->get('ce.edit'); ?>
</a>
            <a href="?module=page&part=ce&action=delete&value=<?php echo $this->_tpl_vars['schl']; ?>
&path=<?php echo $this->_tpl_vars['path']; ?>
" title="Element löschen"><?php echo $this->_tpl_vars['i18n']->get('ce.delete'); ?>
</a>
            <a href="?module=page&part=ce&action=up&value=<?php echo $this->_tpl_vars['schl']; ?>
&path=<?php echo $this->_tpl_vars['path']; ?>
" title="Element nach oben bewegen"><?php echo $this->_tpl_vars['i18n']->get('ce.moveup'); ?>
</a>
            <a href="?module=page&part=ce&action=down&value=<?php echo $this->_tpl_vars['schl']; ?>
&path=<?php echo $this->_tpl_vars['path']; ?>
" title="Element nach unten bewegen"><?php echo $this->_tpl_vars['i18n']->get('ce.movedown'); ?>
</a>
        </div>
        <div class="ceHead">
        <strong><?php echo $this->_tpl_vars['ce']['attributes']['name']; ?>
</strong>
        </div>
        
        <div class="ceHead">
            <?php echo $this->_tpl_vars['i18n']->get('ce.start'); ?>
: <?php echo $this->_tpl_vars['ce']['attributes']['visibleFrom']; ?>
<br>
            <?php echo $this->_tpl_vars['i18n']->get('ce.stop'); ?>
:  <?php echo $this->_tpl_vars['ce']['attributes']['visibleTill']; ?>
<br>
            <?php echo $this->_tpl_vars['i18n']->get('ce.position'); ?>
:  <?php echo $this->_tpl_vars['ce']['attributes']['position']; ?>
<br>
        </div>
                <div class="ceBody"><?php echo ((is_array($_tmp=$this->_tpl_vars['ce']['data'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)); ?>
</div>
    </div>
    <?php else: ?>
        <?php if ($this->_tpl_vars['filter'] == $this->_tpl_vars['ce']['attributes']['position']): ?>
            <div class='ceMain' style="">
                <div class="ceHeadLink" style=''>
                    <a href='?module=page&part=ce&action=new&value=<?php echo $this->_tpl_vars['schl']; ?>
&path=<?php echo $this->_tpl_vars['path']; ?>
' title='Neues Element danach'><?php echo $this->_tpl_vars['i18n']->get('ce.new'); ?>
</a>
                    <a href="?module=page&part=ce&action=edit&value=<?php echo $this->_tpl_vars['schl']; ?>
&path=<?php echo $this->_tpl_vars['path']; ?>
" title='Element bearbeiten'><?php echo $this->_tpl_vars['i18n']->get('ce.edit'); ?>
</a>
                    <a href="?module=page&part=ce&action=delete&value=<?php echo $this->_tpl_vars['schl']; ?>
&path=<?php echo $this->_tpl_vars['path']; ?>
" title="Element löschen"><?php echo $this->_tpl_vars['i18n']->get('ce.delete'); ?>
</a>
                    <a href="?module=page&part=ce&action=up&value=<?php echo $this->_tpl_vars['schl']; ?>
&path=<?php echo $this->_tpl_vars['path']; ?>
" title="Element nach oben bewegen"><?php echo $this->_tpl_vars['i18n']->get('ce.moveup'); ?>
</a>
                    <a href="?module=page&part=ce&action=down&value=<?php echo $this->_tpl_vars['schl']; ?>
&path=<?php echo $this->_tpl_vars['path']; ?>
" title="Element nach unten bewegen"><?php echo $this->_tpl_vars['i18n']->get('ce.movedown'); ?>
</a>
                </div>
                <div class="ceHead">
                <strong><?php echo $this->_tpl_vars['ce']['attributes']['name']; ?>
</strong>
                </div>
                
                <div class="ceHead">
                    <?php echo $this->_tpl_vars['i18n']->get('ce.start'); ?>
: <?php echo $this->_tpl_vars['ce']['attributes']['visibleFrom']; ?>
<br>
                    <?php echo $this->_tpl_vars['i18n']->get('ce.stop'); ?>
:  <?php echo $this->_tpl_vars['ce']['attributes']['visibleTill']; ?>
<br>
                    <?php echo $this->_tpl_vars['i18n']->get('ce.position'); ?>
:  <?php echo $this->_tpl_vars['ce']['attributes']['position']; ?>
<br>
                </div>
                                <div class="ceBody"><?php echo ((is_array($_tmp=$this->_tpl_vars['ce']['data'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)); ?>
</div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    
<?php endforeach; unset($_from); endif; ?>