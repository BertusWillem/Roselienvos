<?php
require 'PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                           //laat een debug output zien in de browser



//Maakt verbinden met de smtp server
$mail->isSMTP();
$mail->Host = 'mail.kevinthegamer.nl';
$mail->SMTPAuth = true;
$mail->Username = 'kbs@kevinthegamer.nl';
$mail->Password = 'Kbs2017!';
$mail->SMTPSecure = 'TLS';
$mail->Port = 587;


$mail->setFrom('noReply@pedicureroselien.nl', 'Roselien Vos'); //stelt de naam van de verstuurder in
$mail->addAddress($mailreceiver);     // voegt een ontvanger toe


$mail->isHTML(true);

$mail->Subject = $mailsubject;
$mail->Body    = $mailcontent;
//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';



if(!$mail->send()) { //is de mail NIET verzonden?
    print ("<script type='text/javascript'>alert('Er is een fout opgetreden. probeer het later opnieuw')</script>");
    echo 'Mailer Error: ' . $mail->ErrorInfo; //Debug bij een fout
} else {
    print ("<script type='text/javascript'>alert('Bericht succesvol verstuurd!')</script>");
}
