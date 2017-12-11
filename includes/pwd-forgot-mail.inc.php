
<?php
session_start();
if (isset($_SESSION['userid'])){
  header("Location: ../profile.php?message=error");
}
//De pagina is alleen beschikbaar voor gebruikers die NIET zijn ingelogd.
//Anders wordt je doorverwezen naar de profile.php
$email = $_POST['email'];
//Het email adres wordt hier in een variable gestopt
if (empty($email)){
header("Location: ../forgot.php?message=empty");
exit();
}
//Het veld moet ingevuld zijn, anders wordt er een error message gegenereerd
include 'dbh.php';
$stmt = $dbh->prepare("SELECT * FROM gebruikers WHERE email = :email");
$stmt->execute(array(':email' => $email));
$rows = $stmt ->fetch();
//Er wordt in de database gezocht naar het ingevulde email adres
  if(empty($rows)){
    header("Location: ../forgot.php?notfound");
    exit();
    //Als het email adres niet gevonden is wordt er een error message gegenereerd
  }
  else {




  $mailreceiver = $email;
  $mailsubject = "Wachtwoord vergeten - Pedicure Roselien Vos";
  $mailcontent = ("<p>Beste " .$rows['firstname'].",</p><br>
  Er is een wachtwoord wijzigings verzoek ingediend via de website van pedicure vd Vos.<br>
  Gebruik de volgende
  <a href='https://kbs.xgiox.com/pwdrecovery.php?p=".$rows['password']."&u=".$rows['userid']."'>link</a>
  om uw wachtwoord te wijzigen.<br>
  Als u dit verzoek niet ingediend hebt, kunt u deze email negeren.
  <br><br><br>
  Met vriendelijke groet.
  </p>");

include'mail.php';

header("Location: ../login.php?message=forgotmail");
exit();
}
header("Location: ../login.php?error=unknown");
exit();
?>
