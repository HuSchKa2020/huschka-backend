<?php

    class MailSender {

        function __construct(){

        }
      function sendVerficationMail($mail, $vorname, $nachname, $vkey) {
        $betreff = "Ihre HuSchKa Verifizierungsmail!";

        //$message = "Hallo '$vorname', bitte klicke <a href="huschka.ddnss.de/jan/verifizierung/verify.php?vkey=$vkey">hier</a> um dich zu verifizieren";
        $message ="huschka.ddnss.de/huschka/verifizierung/verify.php?vkey=$vkey";
        /*$headers = "From: The Sender Name <sender@huebner.de>\r\n";
        $headers .= "Reply-To: reply@jan.de\r\n";
        $headers .= "Content-type = text/html\r\n";
        */
        shell_exec("sendemail -f mail.huschka@gmail.com -t ".$mail." -u ".$betreff." -m ".$message);
      }
    }