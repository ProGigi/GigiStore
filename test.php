<?php
   $header = "From: gigi@pim.usermd.net \nContent-Type:".
             ' text/plain;charset="UTF-8"'.
             "\nContent-Transfer-Encoding: 8bit";
   $to = "jaworski.gerard@gmail.com";
   $subject = "Wiadomość testowa";
   $message = "Witaj to wiadomość testowa";
   mail($to, $subject, $message, $header);
    echo "sadasdasd";

   ?>