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
        $output.=$this->outputGroup($this->i18n->get("section.general"), 
                                                     array($this->getSectionName(),
                                                           $this->getSectionDesc()),
                                                     "general");

        $output.=$this->outputGroup($this->i18n->get("section.visibility"),
                                    array($this->getVisibleFrom(),
                                          $this->getVisibleTill(),
                                          $this->draftSection()),
                                    "left");

        $output.=$this->outputGroup($this->i18n->get("section.menuProperties"), 
                                    array($this->getSectionAlias(),
                                          $this->getShortcut(),
                                          $this->getInMenu()),
                                    "middle");

        $output.=$this->outputGroup($this->i18n->get("section.dynamics"), 
                                    array($this->getAllowExtension(),
                                          $this->getAllowScript()),
                                    "right");
        
        return $output;
    }
    
    function outputGroup($legend, $items, $class="")
    {
        $output = "";
        
        $output.= "<fieldset>\n";

        if (strlen ($legend) > 0)
        {
            $output.="<legend>".$legend."</legend>\n";
        }

        if (is_array($items))
        {
            foreach($items as $item)
            {
                $output.=$item;
            }
        }
        
        $output.= "</fieldset>\n";

        if (strlen($class) > 0)
        {
            $output = "<div class=\"".$class."\">".$output."</div>";
        }
        

        return $output;
    }
    
    function getSectionName()
    {
        $i18n = $this->i18n;
        $name = $page->attributes['name'];
        return "<p><label for=\"attributes_name\" class=\"required\">".$i18n->get("section.name")."*:</label> <input class=\"text\" type='text' name='attributes[name]' id='attributes_name' value='".$this->page->attributes['name']."' /></p>\n";
    }
    
    function getSectionAlias()
    {
        $i18n = $this->i18n;
        $name = $page->attributes['name'];
        return "<p><label for=\"attributes_alias\" class=\"required\">".$i18n->get("section.alias")."*:</label> <input class=\"text\" type='text' name='attributes[alias]' id='attributes_alias' value='".$this->page->attributes['alias']."' /></p>\n";
    }

    function getVisibleFrom()
    {
        $i18n = $this->i18n;
        $name = $page->attributes['name'];
        return "<p><label for=\"attributes_visibleFrom\">".$i18n->get("section.visibleFrom")."**:</label> <input class=\"text\" type='text' name='attributes[visibleFrom]' id='attributes_visibleFrom' value='".$this->page->attributes['visibleFrom']."' /></p>\n";
    }
    
    function getVisibleTill()
    {
        $i18n = $this->i18n;
        $name = $page->attributes['visibleTill'];
        return "<p><label for=\"attributes_visibleTill\">".$i18n->get("section.visibleTill")."**:</label> <input class=\"text\" type='text' name='attributes[visibleTill]' id='attributes_visibleTill' value='".$this->page->attributes['visibleTill']."' /></p>\n";
    }

    function getShortcut()
    {
        $i18n = $this->i18n;
        $name = $page->attributes['shortcut'];
        return "<p><label for=\"attributes_shortcut\">".$i18n->get("section.shortcut").":</label> <input class=\"text\" type='text' name='attributes[shortcut]' id='attributes_shortcut' value='".$this->page->attributes['shortcut']."' /></p>\n";
    }
    
    function getSectionDesc()
    {
        $i18n = $this->i18n;
        $name = $page->attributes['desc'];
        return "<p><label for=\"attributes_desc\">".$i18n->get("section.desc").":</label> <textarea cols=\"55\" rows=\"2\" name='attributes[desc]' id='attributes_desc'>".$this->page->attributes['desc']."</textarea></p>\n";
    }
    
    function getInMenu()
    {
        $i18n = $this->i18n;
        if (!empty($this->page->attributes['inMenu']))
            $checked = " checked='checked' ";
        else 
            $checked = "";
    
    // Default Value is True
        if (!is_array($this->page->attributes))
            $checked = " checked='checked' ";
        
        return "<p><label for=\"attributes_inMenu\">".$i18n->get("section.inMenu").":</label> <input type='checkbox' $checked name='attributes[inMenu]' id='attributes_inMenu' /></p>\n";
    }
    
    function getAllowScript()
    {
        $i18n = $this->i18n;
        if (!empty($this->page->attributes['allowScript']))
            $checked = " checked='checked' ";
        else $checked = "";
        
        return "<p><label for=\"attributes_allowScript\">".$i18n->get("section.allowScript").":</label> <input type='checkbox' $checked name='attributes[allowScript]' id='attributes_allowScript' /></p>\n";
    }
    
    function getAllowExtension()
    {
        $i18n = $this->i18n;
        if (!empty($this->page->attributes['allowExtension']))
            $checked = " checked='checked' ";
        else $checked = "";
        
    // Default Value is True
        if (!is_array($this->page->attributes))
            $checked = " checked='checked' ";
        
        return "<p><label for=\"attributes_allowExtension\">".$i18n->get("section.allowExtension").":</label> <input type='checkbox' $checked name='attributes[allowExtension]' id='attributes_allowExtension' /></p>\n";
    }
    
    function draftSection()
    {
        $i18n = $this->i18n;
        if (!empty($this->page->attributes['draft']))
            $checked = " checked='checked' ";
        else $checked = "";
        
        return "<p><label for=\"attributes_draft\">".$i18n->get("section.draft").":</label> <input type='checkbox' $checked name='attributes[draft]' id='attributes_draft' /></p>\n";
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