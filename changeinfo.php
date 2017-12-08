<?php
session_start();
$page = "Gegevens wijzigen";
if (!isset($_SESSION['userid'])){
  header("Location: login.php");
  exit();
}
else
{
include 'header.php';
include 'includes/loginsystem.func.php';
requestProfile($_SESSION['userid'],"changeInfo");
}
/*  include 'includes/dbh.php';
  $stmt = $dbh->prepare("SELECT email, firstname, lastname FROM gebruikers WHERE userid = :userid");
  $stmt->execute(array(':userid' => $userid));
  $rows = $stmt ->fetch();
  // Hier haalt php de accountgegevens uit de database

  $stmt = $dbh->prepare("SELECT * FROM gegevens WHERE added_by IN (SELECT userid FROM gebruikers WHERE userid = :userid)");
  $stmt->execute(array(':userid' => $userid));
  $adrow = $stmt ->fetch();
  // Hier haalt php de persoonsgegevens uit de database
  $email = $rows['email'];
  $firstname = ucfirst($rows['firstname']);
  $lastname= ucfirst($rows['lastname']);
  $adres = $adrow['adres'];
  $postcode = $adrow['postcode'];
  $woonplaats = $adrow['woonplaats'];
*/
  ?>

  <section class="body-container">
    <section class="container">
      <div class="input-window">
        <form action="includes/changeinfo.inc.php" method="POST">
          <h1>Voornaam</h1><input type="text" name="firstname" value="<?php print($firstname);?>">
          <h1>Achternaam</h1><input type="text" name="lastname" value="<?php print($lastname);?>">
          <h1>Adres</h1><input type="text" name="adres" value="<?php print($adres);?>">
          <h1>Postcode</h1><input type="text" name="postcode" value="<?php print($postcode);?>">
          <h1>Woonplaats</h1><input type="text" name="woonplaats" value="<?php print($woonplaats);?>">
          <div class="submit"><input type="submit" value="Wijzigen"></div>
        </form>
      </div>
    </section>
  </section>

  <?php include 'footer.php'; ?>
