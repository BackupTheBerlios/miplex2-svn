<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
    <title>Miplex2 - Administrationsmen� {$title}</title>
    <link rel="stylesheet" type="text/css" media="screen" href="tpl/admin/admin.css" />

    {if $hta==1}
    <script type="text/javascript">
        _editor_lang = "de";
        _editor_url = "lib/htmlarea";
    </script>
    <script type="text/javascript" src="lib/htmlarea/htmlarea.js"></script>
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
                config.width="585px;";
                config.statusBar = false;
                config.toolbar = [

                ["formatblock", "space", "separator",
                	"bold", "justifyleft", "justifycenter", "justifyright", "separator",
                	"insertorderedlist", "insertunorderedlist", "outdent", "indent", "separator",
                	"createlink", "miplexlink", "insertimage", "insertfile", "inserttable", "separator",
                	"undo", "redo", "separator",
                	"htmlmode", "popupeditor"],
            	["strikethrough","quote"]
                ];

                var editor = new HTMLArea("htmlarea", config);

                editor.registerPlugin(ContextMenu);
                editor.registerPlugin(TableOperations);
                editor.registerPlugin(ImageManager);
                editor.registerPlugin(InsertFile);
                editor.registerPlugin(MiplexLink);

                editor.config.pageStyle = "@import url(/tpl/htmlarea.css);";
                editor.generate();
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
        <div class="tab"><a href='?module=settings'>Einstellungen</a></div>
        <div class="tab right"><a href='?module=logout'>Logout</a></div>
        <div class="tab right"><a href='{$config->baseName}'>Zur Seite</a></div>
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
