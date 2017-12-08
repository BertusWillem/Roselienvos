<?php
session_start();
$password = $_POST['new_pwd'];
$confirm = $_POST['conf_pwd'];
$userid = $_SESSION['changeid'];
//Eerst worden de variablen aangemaakt
if (empty($password) || (empty($confirm))){
header('Location: ' . $_SERVER['HTTP_REFERER'] . '&message=empty');
exit();
//Als er velden niet ingevuld zijn wordt je terug verwezen naar de vorige URL.
//omdat in deze URL de hash code en de userid staat kan je niet gewoon ../pwdrecovery.php
}

if ($password !== $confirm){
header('Location: ' . $_SERVER['HTTP_REFERER'] . '&message=notmatch');
exit();
//Als de twee wachtwoorden niet overeenkomen wordt je terug verwezen naar de vorige URL.
//omdat in deze URL de hash code en de userid staat kan je niet gewoon ../pwdrecovery.php
}

else {
  include 'dbh.php';
  $passwordHash = password_hash($password, PASSWORD_BCRYPT, array("cost" => 12));
  //Het wachtwoord wordt gehasht en het wachtwoord wordt geupdate in de database
  $stmt = $dbh->prepare("UPDATE gebruikers SET password = :password WHERE userid = :userid");
  $stmt->execute(array(':password' => $passwordHash, ':userid' => $userid));
  $rows = $stmt ->fetch();
}
//Na het updaten wordt je doorgestuurd naar de login pagina.
header ("Location: ../login.php?message=changed");

?>
