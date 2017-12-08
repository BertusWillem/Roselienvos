<?php
session_start();
if (!isset($_SESSION['userid'])){
  header("Location: login.php");
  exit();
}
else {
$page = "Wachtwoord wijzigen";
include 'header.php';
}
if ($_GET[error] === "empty"){
  print ("<script type='text/javascript'>alert('Vul alle velden in!')</script>");
}

if ($_GET[error] === "notmatch"){
  print ("<script type='text/javascript'>alert('De wachtwoorden komen niet overeen!')</script>");
}

if ($_GET[error] === "match"){
  print ("<script type='text/javascript'>alert('Het nieuwe wachtwoord mag niet hetzelfde zijn als het oude wachtwoord!')</script>");
}

?>
  <section class="body-container">
    <section class="container">
      <div class="input-window">
        <h1>Wachtwoord wijzigen</h1>
        <form action="includes/changepwd.inc.php" method="POST">
          <input type="password" name="old_pwd" placeholder="Oude wachtwoord">
          <input type="password" name="new_pwd" placeholder="Nieuwe wachtwoord">
          <input type="password" name="conf_pwd" placeholder="Bevestig nieuwe wachtwoord">
          <div class="submit"><input type="submit" value="Wijzig mijn wachtwoord"></div>
        </form>
      </div>
    </section>
  </section>

<?php include 'footer.php'; ?>
