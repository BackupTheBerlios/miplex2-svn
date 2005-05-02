<?php
    require_once("startup.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
    <title>MiplexLink</title>
    
    <script type="text/javascript" src="js/popup.js"></script>
    <script type="text/javascript" src="js/dialog.js"></script>

    <script language="JavaScript" type="text/JavaScript">
    /*<![CDATA[*/
        var preview_window = null;

        function Init() {
            window.resizeTo(750, 570);
            __dlg_init();
            window.resizeTo(750, 570);
            onIntern();
        };
        
        function onCancel() {
          if (preview_window) {
            preview_window.close();
          }
          __dlg_close(null);
          return false;
        };
        
        function onOK()
        {
            var param = new Object();
            
            param['link'] = "hier";

            __dlg_close(param);
            return false;
        }
        
        function onOKi()
        {
            var param = new Object();
            var link = document.getElementById("form1").elements["iTo"].value;
            var title = document.getElementById("form1").elements["iTitle"].value;

            param['link'] = link;
            param['title'] = title;

            __dlg_close(param);
            return false;
        }
        
        function onIntern()
        {
            //document.getElementById("form1").elements["iTo"].value = path;
            var ls = location.search;
            var query = ls.substring(1, ls.length);

            //get beginning of path
            var start = query.indexOf("=",0);
            var ende = query.indexOf("&", start+1);

            if (ende == -1)
            {
               ende = query.length;

            }else
            {
                var key = query.substring(query.indexOf("=", ende)+1,query.length);

            }

            //and path is...
            var path = query.substring(start+1,ende);

            if (key != null)
                path = path + ".html" + "#" + key;
            else
                path = path + ".html";


            document.getElementById("form1").elements["iTo"].value=path;


        }

    /*]]>*/
    </script>
    <style type="text/css">
        html, body {
          background: ButtonFace;
          color: ButtonText;
          font: 11px Tahoma,Verdana,sans-serif;
          margin: 0px;
          padding: 0px;
        }
        body { padding: 5px; }
        table {
          font: 11px Tahoma,Verdana,sans-serif;
        }
        form p {
          margin-top: 5px;
          margin-bottom: 5px;
        }
        fieldset { padding: 0px 10px 5px 5px; }
        select, input, button { font: 11px Tahoma,Verdana,sans-serif; }
        button { width: 70px; }

        .title { background: #ddf; color: #000; font-weight: bold; font-size: 120%; padding: 3px 10px; margin-bottom: 10px;
        border-bottom: 1px solid black; letter-spacing: 2px;
        }
        form { padding: 0px; margin: 0px; }
        a { padding: 2px; border: 1px solid ButtonFace; }
        a img   { border: 0px; vertical-align:bottom; }
        a:hover { border-color: ButtonShadow ButtonHighlight ButtonHighlight ButtonShadow;}
        li { margin:10px;}
        .list {
        padding: 4px;
        background-color:#fff;
        float: left;
        /*width: 400px;*/
        }

        .ce
        {
            background-color:#fff;
            width:100%;
            align:left;
            vertival-align:top;
        }
        
    </style>
    </head>
    <body onload="Init();">
    <form action='' method='post' name='form1' id ='form1' >
    <table width='100%'>
        <tr>
            <td>
                <p class='title'>Interner Link:</p>
            </td>
            <td>
                <p class='title'>Externer Link</p>
            </td>
        </tr>
        <tr>
        <td style="border: 1px solid gray;">
            <table>
                <tr>
                    <td class='ce'>
                        <div class='list'>
                            <h5>Menüpunkt</h5>
                            <?php echo getAll(); ?>
                        </div>
                    </td>
                    <td valign="top">
                        <table>
                            <tr>
                                <td class='ce'>
                                    <h5>Textfeld</h5>
                                    <?php echo getCe(); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>Ziel: <input type='text' name='iTo' size='40'> Titel:<input type='text' name='iTitle' size='40'></p>

                                    <p><button type="button" name="ok" onclick="return onOKi();">Ok</button>
                                       <button type="button" name="cancel" onclick="return onCancel();">Cancel</button></p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
        <td style="border: 1px solid gray; vertical-align:top;">
            <p>Adresse:</p>
                <input type='text' name='to' size='40' /><br />
            <p>Titel:</p>
                <input type='text' name='title' size='40' /><br />
            <br />
            <button type="button" name="ok" onclick="return onOK();">Ok</button>
            <button type="button" name="cancel" onclick="return onCancel();">Cancel</button>
        </td>
        </form>
    </body>
</html>
