<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>

    <head>
       <link rel="stylesheet" href="{$config->docroot}tpl/default.css" type="text/css" />
       <title>{$config->title} - {$pageObject->getTitle()}</title>
       {$header}
    </head>

<body>
    <div class="all">
        <div class="left-part">
            <div class="dove">
                <br />
            </div>
            <div class="login-box">::</div>
            <div class="menu-box">
                <div class="strecker-menu"><br /></div>
                {tmenu config=$config currentPage=$pageObject site=$site wrapAll="<ul class='menu-level1'>|</ul>" collapse=0}
            </div>
        </div>
        <div class="right-part">
            <div class="top-box">
                <div class="navibox">
                    <div class="navielem">
                    	{loadExtension config=$config name=suche params="formular=anzeigen"}
						<br />
					</div>
                </div>
            </div>
            <div class="white-box">
                <div class="strecker-content"><br /></div>
                <div class="content">
                {$pageObject->getContentOfPage()}
                </div>
            </div>
        </div>
    </div>

</body>

</html>
