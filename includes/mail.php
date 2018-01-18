<?php
require 'PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                           //laat een debug output zien in de browser



//Maakt verbinden met de smtp server
$mail->isSMTP();
$mail->Host = 'smtp.strato.com';
$mail->SMTPAuth = true;
$mail->Username = 'kbs@xmusic.live';
$mail->Password = 'Roselienvoskbs22';
$mail->SMTPSecure = 'SSL';
$mail->Port = 465;


$mail->setFrom('noReply@pedicureroselien.nl', 'Roselixmusic.liveen Vos'); //stelt de naam van de verstuurder in
$mail->addAddress($mailreceiver);     // voegt een ontvanger toe


$mail->isHTML(true);

$mail->Subject = $mailsubject;
$mail->Body    = $mailcontent;




if(!$mail->send()) { //is de mail NIET verzonden?
    print ("<script type='text/javascript'>alert('Er is een fout opgetreden. probeer het later opnieuw')</script>");

} else {
    print ("<script type='text/javascript'>alert('Bericht succesvol verstuurd!')</script>");
}
