<html>
<head>
    <title>Miplex2 - Administrationsmenü {$title}</title>
    <link rel="stylesheet" type="text/css" media="screen" href="tpl/admin/admin.css" />
    
    {if $hta==1}
    <script type="text/javascript">
        _editor_lang = "de";
        _editor_url = "/miplex2/lib/htmlarea";
    </script>
    <script type="text/javascript" src="/miplex2/lib/htmlarea/htmlarea.js"></script>
    {literal}
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
		
                config.pageStyle = "@import url(tpl/admin/admin.css);";

                var editor = new HTMLArea("htmlarea");
                editor.config = config;
                editor.registerPlugin(ContextMenu);
                editor.registerPlugin(TableOperations);
                editor.registerPlugin(ImageManager);
                editor.registerPlugin(InsertFile);
                editor.registerPlugin(MiplexLink);
                
                editor.generate();
                //HTMLArea.replaceAll(config);
                
            };
            
    </script>
    {/literal}
    {/if}
    
</head>
<body {if $hta == 1}onload="init()"{/if}>
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
        
        {*Content Spalte*}
        <td class="adminContent">
        {include file=$content_tpl}
        </td>
    </tr>
</table>
</body>
</html>
