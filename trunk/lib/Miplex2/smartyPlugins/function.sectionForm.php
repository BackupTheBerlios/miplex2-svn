<?php

class SectionForm
{
    
    var $page;
    var $link;
    var $i18n;
    var $path;
    var $vals;
    
    function SectionForm(&$page, $link, $path)
    {
        require_once("lib/Miplex2/M2Translator.class.php");
        
        $this->i18n = new M2Translator("de");
        
        $this->page = &$page;
        $this->link = $link;
        $this->path = $path;
        
    }
    
    function outputForm()
    {
        $output.=$this->getSectionName();
        $output.=$this->getSectionAlias();
        $output.=$this->getSectionDesc();
        $output.=$this->getVisibleFrom();
        $output.=$this->getVisibleTill();
        $output.=$this->getShortcut();
        
        $output.=$this->getInMenu();
        $output.=$this->getAllowExtension();
        $output.=$this->getAllowScript();
        $output.=$this->draftSection();
        
        return $output;
    }
    
    function getSectionName()
    {
        $i18n = $this->i18n;
        $name = $page->attributes['name'];
        return "<p>".$i18n->get("section.name").": <input type='text' name='attributes[name]' value='".$this->page->attributes['name']."' /></p>\n";
    }
    
    function getSectionAlias()
    {
        $i18n = $this->i18n;
        $name = $page->attributes['name'];
        return "<p>".$i18n->get("section.alias").": <input type='text' name='attributes[alias]' value='".$this->page->attributes['alias']."' /></p>\n";
    }

    function getSectionDesc()
    {
        $i18n = $this->i18n;
        $name = $page->attributes['desc'];
        return "<p>".$i18n->get("section.desc").": <input type='text' name='attributes[desc]' value='".$this->page->attributes['desc']."' /></p>\n";
    }
    
    function getVisibleFrom()
    {
        $i18n = $this->i18n;
        $name = $page->attributes['name'];
        return "<p>".$i18n->get("section.visibleFrom").": <input type='text' name='attributes[visibleFrom]' value='".$this->page->attributes['visibleFrom']."' /></p>\n";
    }
    
    function getVisibleTill()
    {
        $i18n = $this->i18n;
        $name = $page->attributes['visibleTill'];
        return "<p>".$i18n->get("section.visibleTill").": <input type='text' name='attributes[visibleTill]' value='".$this->page->attributes['visibleTill']."' /></p>\n";
    }

    function getShortcut()
    {
        $i18n = $this->i18n;
        $name = $page->attributes['shortcut'];
        return "<p>".$i18n->get("section.shortcut").": <input type='text' name='attributes[shortcut]' value='".$this->page->attributes['shortcut']."' /></p>\n";
    }
    
    function getInMenu()
    {
        $i18n = $this->i18n;
        if (!empty($this->page->attributes['inMenu']))
            $checked = " checked='on' ";
        else $checked = "";
        
        return "<p>".$i18n->get("section.inMenu").": <input type='checkbox' $checked name='attributes[inMenu]' /></p>\n";
    }
    
    function getAllowScript()
    {
        $i18n = $this->i18n;
        if (!empty($this->page->attributes['allowScript']))
            $checked = " checked='on' ";
        else $checked = "";
        
        return "<p>".$i18n->get("section.allowScript").": <input type='checkbox' $checked name='attributes[allowScript]' /></p>\n";
    }
    
    function getAllowExtension()
    {
        $i18n = $this->i18n;
        if (!empty($this->page->attributes['allowExtension']))
            $checked = " checked='on' ";
        else $checked = "";
        
        return "<p>".$i18n->get("section.allowExtension").": <input type='checkbox' $checked name='attributes[allowExtension]' /></p>\n";
    }
    
    function draftSection()
    {
        $i18n = $this->i18n;
        if (!empty($this->page->attributes['draft']))
            $checked = " checked='on' ";
        else $checked = "";
        
        return "<p>".$i18n->get("section.draft").": <input type='checkbox' $checked name='attributes[draft]' /></p>\n";
    }
    
    
    
}


function smarty_function_sectionForm($params, &$smarty)
{
    
    $page = $params['page'];
    $link = $params['link'];
    $path = $params['path'];
    
    
    $sf = new SectionForm($page, $link, $path);
    
    return $sf->outputForm();
    
}


?>