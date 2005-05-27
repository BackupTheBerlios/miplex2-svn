<?php
class mailform extends Extension 
{
    var $from;
    var $to;
    
    function main($params)
    {
        
        if ($_POST['send'])
        {
            $mail = $_POST['mail'];
            list($userName, $mailDomain) = split("@", $mail['add']);
            
            if (checkdnsrr($mailDomain, "MX")) 
            {

         // eMail-Adresse des Absenders zusammensetzen
             // this is a valid email domain!
                $sender = $mail['add'];

             // Eventuell den Namen für das From-Statement davorkleben
                if (sizeof($mail['name']) > 0)
                    $fullsender = '"'.$mail['name'].'" <'.$sender.'>';

             // eMail-Adresse des Empfängers
                $mailto = $this->extConfig['params']['to'];

             // Betreffzeile zusammenbauen
                $subject = $this->extConfig['params']['subject'].": ".$mail['subject'];

             // Header zusammenbasteln
                $header = 'Content-Type: text/plain; charset="us-ascii"'."\n";
                $header .= 'Content-Transfer-Encoding: 7bit'."\n";
                $header .= 'FROM: '.$fullsender."\n"; 

             // Message eintragen
                $msg = $mail['text']."\n\n";

             // Infos über den Nutzer sammeln
                $msg.= "Zusätzliche Informationen (maschinell gesammelt):\n\n";
                $msg.= "Sollten Sie die Antworten-Funktion Ihres Mailprogramms nutzen, so achten Sie\n";
                $msg.= "darauf, dass die folgenden Informationen nicht zum Kunden gesendet werden.\n";
                $msg.= "Er hat sie zwar freiwillig angegeben,ist sich dessen aber wahrscheinlich nicht \n";
                $msg.= "bewußt. Er würde sich mit Sicherheit über die Erhebung dieser Daten wundern.\n\n";

                $referer = $mail['referer'];
                if (strlen($referer) > 0)
                    $msg.= "Der Kunde hat das Formular von dieser Adresse aus aufgerufen: ".$referer."\n";

                $browser = $_SERVER['HTTP_USER_AGENT'];
                if (strlen($browser) > 0)
                    $msg.= "Der Kunde benutzte diesen Browser: ".$browser."\n";

                $ip = $_SERVER['REMOTE_ADDR'];
                $host = gethostbyaddr($ip);
                if (strlen($host) > 0)
                    $msg.= "Der Kunde kommt über diesen Rechner ins Internet: ".$host." (".$ip.")\n";

                mail($mailto, $subject, $msg, $header);
                
                return $this->smarty->fetch("mailform/tpl/sended.tpl");
            }
            else 
                $this->smarty->assign("referer", $mail['referer']);
                $this->smarty->assign("name", $mail['name']);
                $this->smarty->assign("add", "UNGÜLTIGE E-MAIL");
                $this->smarty->assign("subject", $mail['subject']);
                $this->smarty->assign("text", $mail['text']);                

                return $this->smarty->fetch("mailform/tpl/mailform.tpl");
        } 
        else 
        {
            $this->smarty->assign("self", $_SERVER['REQUEST_URI']);
            $this->smarty->assign("referer", $_SERVER['HTTP_REFERER']);

            return $this->smarty->fetch("mailform/tpl/mailform.tpl");
        }
    }
    
    
    function getBackend()
    {
        if (isset($_POST['save']))
        {
            $this->extConfig['params']['from'] = stripslashes($_POST['data']['from']);
            $this->extConfig['params']['to'] = stripslashes($_POST['data']['to']);
            $this->extConfig['params']['subject'] = htmlentities(stripslashes($_POST['data']['subject']));
            
            $this->saveConfiguration($this->extConfig);
            
            $this->smarty->assign("allesOk", true);
        }
        
        $this->smarty->assign("extMeta", $this->extConfig);
        $this->smarty->assign("url", $this->getCurrentURL());
        $this->smarty->assign("extConfig", $this->extConfig['params']);
        return $this->smarty->fetch("mailform/admin/backend.tpl");
    }
}
?>