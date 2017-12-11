<?php
session_start();
//Hier worden alle variablelen vanuit changepwd.php gedefinieerd.
$userid = $_SESSION['userid'];
$oldpassword = $_POST['old_pwd'];
$newpassword = $_POST['new_pwd'];
$confirmpassword = $_POST['conf_pwd'];
//alle velden moeten ingevuld zijn, anders wordt er een error gegenereerd
if (empty($oldpassword) || empty($newpassword) || empty($confirmpassword))
{
  header("Location: ../changepwd.php?error=empty");
  exit();
}
//Als het nieuwe wachtwoord en het wachtwoord ter bevestiging niet overeen komen
//wordt er een error message gegenereerd
if ($newpassword !== $confirmpassword){
  header("Location: ../changepwd.php?error=notmatch");
  exit();
}
//Als het nieuwe wachtwoord gelijk is aan het oude wachtwoord, wordt er ook een
//error message gegenereerd
if ($oldpassword === $newpassword){
  header("Location: ../changepwd.php?error=match");
  exit();
}
//Wanneer alles goed is wordt er een SELECT statement gedaan met het userid
else {
  include 'dbh.php';
  $stmt = $dbh->prepare("SELECT * FROM gebruikers WHERE userid = :userid");
  $stmt->execute(array(':userid' => $userid));
  $rows = $stmt ->fetch();
  //TODO:Misshien nog een error message maken voor als $rows leeg is
  $validPassword = password_verify($oldpassword, $rows['password']);
  //Het wachtwoord wordt geconteroleerd met de hash in de database
      if (!$validPassword){
      header("Location: ../changepwd.php?message=incorrect");
      exit();
      //Als dit niet overeen komt, wordt er een error message gegenereerd
      }
      else{
      //Als alles wel klopt, wordt het wachtwoord gehasht en geupdate in de database
        $passwordHash = password_hash($newpassword, PASSWORD_BCRYPT, array("cost" => 12));
        $stmt = $dbh->prepare("UPDATE gebruikers SET password = :password WHERE userid = :userid");
        $stmt->execute(array(':password' => $passwordHash, ':userid' => $userid));
        $rows = $stmt ->fetch();
      }

    }
    //Na het successvol doorlopen van de bovenstaande stappen wordt je naar je profiel gestuurd
header("Location: ../profile.php?message=pwdupdated");

?>
