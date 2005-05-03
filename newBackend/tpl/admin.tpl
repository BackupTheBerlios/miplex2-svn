<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
    <title>{$i18n->get("admin.title")}</title>
    <meta name="robots" content="noindex, nofollow" />
    <meta name="generator" content="Miplex2" />

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

<body{if $hta == 1} onload="init()"{/if}>
	<div id="all">
		<h1>{$i18n->get("admin.title")}</h1>
		<ul id="menu">
			<li><a href="?module=start" title="{$i18n->get("admin.startTitle")}">{$i18n->get("admin.start")}</a></li>
			<li><a href="?module=page" title="{$i18n->get("admin.pageTitle")}">{$i18n->get("admin.page")}</a></li>
			<li><a href="?module=ext" title="{$i18n->get("admin.extensionTitle")}">{$i18n->get("admin.extension")}</a></li>
			<li><a href="?module=settings" title="{$i18n->get("admin.settingsTitle")}">{$i18n->get("admin.settings")}</a></li>
			<li class="right"><a href="?module=logout" title="{$i18n->get("admin.logoutTitle")}" class="red">{$i18n->get("admin.logout")}</a></li>
			<li class="right"><a href="{$config->baseName}" title="{$i18n->get("admin.frontendTitle")}" class="green">{$i18n->get("admin.frontend")}</a></li>
		</ul>
		<div id="allcontent">
        	{include file=$content_tpl}

        	<br style="clear: both;" />
		</div>

	</div>
</body>
</html>
