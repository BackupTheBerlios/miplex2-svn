<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>

    <head>
       <link rel="stylesheet" href="{$config->docroot}tpl/default.css" type="text/css" />
       <title>Miplex 2 - {$pageObject->getTitle()}</title>
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
                <div class="news-box">

                </div>
                <div class="navibox">
                    <div class="navielem">
                        <form action="#" method="post">
                            <input type="text" class="text" name="search" size="12" />
                            <input type="hidden" name="function" value="search" />
                            <input type="submit" class="submit" value="suche" />
                        </form><br /></div>
                    <div class="navielem"></div>
                    <div class="navielem"></div>
                </div>
            </div>
            <div class="adminbox">

            </div>
            <div class="path">

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
