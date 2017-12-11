<?php
session_start();
$page = "Wachtwoord herstel";
if (isset($_SESSION['userid'])){
  header("Location: login.php?message=error");
}
$password = $_GET['p'];
$userid = $_GET['u'];
$_SESSION['changeid'] = $_GET['u'];

include 'includes/dbh.php';
$stmt = $dbh->prepare("SELECT * FROM gebruikers WHERE userid = :userid AND password = :password");
$stmt->execute(array(':userid' => $userid, ':password' => $password));
$rows = $stmt ->fetch();

if (empty($rows)){
  print("Deze link is niet (meer geldig) als u uw wachtwoord nog niet heeft aangepast, probeer
  opnieuw een wachtwoord hersel mail aan te vragen
  <a href='forgot.php'>Wachtwoord vergeten</a>
");
}

else {
  include 'header.php';
  print('
  <section class="body-container">
    <section class="container">
      <div class="input-window">
        <h1>Wachtwoord herstel</h1>
        <form action="includes/pwdrecovery.inc.php" method="POST">
          <input type="password" name="new_pwd" placeholder="Wachtwoord">
          <input type="password" name="conf_pwd" placeholder="Bevestig wachtwoord">
          <input type="submit" name="recovery" value="Stel wachtwoord in">
        </form>
      </div>
    </section>
  </section>
  ');
}

?>
