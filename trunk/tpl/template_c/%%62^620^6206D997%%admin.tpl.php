<?php /* Smarty version 2.6.3, created on 2004-11-11 16:38:03
         compiled from admin.tpl */ ?>
<html>
<head>
    <title>Miplex2 - Administrationsmenü <?php echo $this->_tpl_vars['title']; ?>
</title>
    <link rel="stylesheet" type="text/css" media="screen" href="tpl/admin/admin.css" />
    
    <?php if ($this->_tpl_vars['hta'] == 1): ?>
    <script type="text/javascript">
        _editor_lang = "de";
        _editor_url = "/miplex2/lib/htmlarea";
    </script>
    <script type="text/javascript" src="/miplex2/lib/htmlarea/htmlarea.js"></script>
    <?php echo '
    <script type="text/javascript">
            HTMLArea.loadPlugin("ContextMenu");
            HTMLArea.loadPlugin("TableOperations");
            HTMLArea.loadPlugin("ImageManager");
            HTMLArea.loadPlugin("InsertFile");
            HTMLArea.loadPlugin("MiplexLink");
            
            
            function init()
            {
                var config = new HTMLArea.Config();
                config.width="550px";
                config.toolbar = [
                
                ["bold", "italic", "underline","justifyleft", "justifycenter", "justifyright", "justifyfull", "separator", "insertorderedlist", "insertunorderedlist", "outdent", "indent", "separator",
                "forecolor", "hilitecolor", "textindicator", "separator", "createlink", "htmlmode"],
                ["fontname", "space", "fontsize", "space", "formatblock", "space", "insertimage", "miplexlink", "insertfile", "inserttable"]
                ];
		
                config.pageStyle = "@import url(tpl/default.css);";

                var editor = new HTMLArea("htmlarea", config);

		        /*editor.config.pageStyle = "@import url(\\"/miplex2/tpl/default.css\\");";*/
                editor.registerPlugin(ContextMenu);
                editor.registerPlugin(TableOperations);
                editor.registerPlugin(ImageManager);
                editor.registerPlugin(InsertFile);
                editor.registerPlugin(MiplexLink);
                editor.generate();
            };
            
    </script>
    '; ?>

    <?php endif; ?>
    
</head>
<body <?php if ($this->_tpl_vars['hta'] == 1): ?>onload="init()"<?php endif; ?>>
<table width="100%" class="adminMain">

    <tr>
        <td class="logo"></td>    
    </tr>
    <tr>
        <td class="adminmenu">
        <div class="tab"><a href='?module=start'>Start</a></div>
        <div class="tab"><a href='?module=page'>Seite</a></div>
        <div class="tab"><a href='?module=ext'>Extension</a></div>
        <div class="tab"><a href='?module=settings'>Settings</a></div>
        </td>
    </tr>
    <tr valign="top">
        
                <td class="adminContent">
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['content_tpl'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        </td>
    </tr>
</table>
</body>
</html>