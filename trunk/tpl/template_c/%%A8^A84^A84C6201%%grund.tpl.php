<?php /* Smarty version 2.6.3, created on 2004-11-11 10:54:29
         compiled from grund.tpl */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'tmenu', 'grund.tpl', 19, false),)), $this); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>

    <head>
       <link rel="stylesheet" href="/miplex2/tpl/default.css" type="text/css" />
       <title>Miplex 2 - <?php echo $this->_tpl_vars['pageObject']->getTitle(); ?>
</title>
       <?php echo $this->_tpl_vars['header']; ?>

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
                <?php echo smarty_function_tmenu(array('config' => $this->_tpl_vars['config'],'currentPage' => $this->_tpl_vars['pageObject'],'site' => $this->_tpl_vars['site'],'wrapAll' => "<ul class='menu-level1'>|</ul>",'collapse' => 0), $this);?>

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
                <?php echo $this->_tpl_vars['pageObject']->getContentOfPage(); ?>

                </div>
            </div>
        </div>
    </div>

</body>

</html>