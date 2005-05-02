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
            
            if (false)//(checkdnsrr($mailDomain, "MX")) 
            {

         // eMail-Adresse des Absenders zusammensetzen
             // this is a valid email domain!
                $sender = $mail['add'];

             // Eventuell den Namen f�r das From-Statement davorkleben
                if (sizeof($mail['name']) > 0)
                    $fullsender = '"'.$mail['name'].'" <'.$sender.'>';

             // eMail-Adresse des Empf�ngers
                $mailto = $this->extConfig['params']['to'];

             // Betreffzeile zusammenbauen
                $subject = $mail['subject']."(".$this->extConfig['params']['subject'].")";

             // Header zusammenbasteln
                $header = 'Content-Type: text/plain; charset="us-ascii"'."\n";
                $header .= 'Content-Transfer-Encoding: 7bit'."\n";
                $header .= 'FROM: '.$fullsender."\n"; 

             // Message eintragen
                $msg = $mail['text']."\n\n";

             // Infos �ber den Nutzer sammeln
                $msg.= "Zusätzliche Informationen:\n\n";

                $referer = $mail['referer'];
                if (sizeof($referer) > 0)
                    $msg.= "Der Kunde hat das Formular von dieser Adresse aus aufgerufen: ".$referer."\n";

                $browser = $_SERVER['HTTP_USER_AGENT'];
                if (sizeof($browser) > 0)
                    $msg.= "Der Kunde benutzte diesen Browser: ".$browser."\n";

                $ip = $_SERVER['REMOTE_ADDR'];
                $host = gethostbyaddr($ip);
                if (sizeof($host) > 0)
                    $msg.= "Der Kunde kommt �ber diesen Rechner ins Internet: ".$host."\n";


                mail($mailto, $subject, $msg, $header);
                
                return $this->smarty->fetch("mailform/sended.tpl");
            }
            else 
                $this->smarty->assign("referer", $mail['referer']);
                $this->smarty->assign("name", $mail['name']);
                $this->smarty->assign("add", "UNG�LTIGE E-MAIL");
                $this->smarty->assign("subject", $mail['subject']);
                $this->smarty->assign("text", $mail['text']);                

                return $this->smarty->fetch("mailform/mailform.tpl");
        } 
        else 
        {
            $this->smarty->assign("self", $_SERVER['REQUEST_URI']);
            $this->smarty->assign("referer", $_SERVER['HTTP_REFERER']);

            return $this->smarty->fetch("mailform/mailform.tpl");
        }
    }
    
    
    function getBackend()
    {
        if (!$_POST['save'])
        {
            $this->smarty->assign("url", $this->getCurrentURL());
            $this->smarty->assign("extConfig", $this->extConfig['params']);
            return $this->smarty->fetch("mailform/backend.tpl");
            
        } else 
        {
            $this->extConfig['params']['subject'] = $_POST['data']['subject'];
            $this->extConfig['params']['from'] = $_POST['data']['from'];
            $this->extConfig['params']['to'] = $_POST['data']['to'];
            
            $this->saveConfiguration($this->extConfig);
            
            return $this->smarty->fetch("mailform/saved.tpl");
        }
        
    }
    
}

?>