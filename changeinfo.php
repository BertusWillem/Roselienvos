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


  ?>

  <section class="body-container">
    <section class="container">
      <div class="input-window">
        <?php if($_GET['error'] === "character"){
        print("<p style='color:red;'>- Er zitten ongeldige characters in de gegevens.");
      } ?>
        <form action="includes/changeinfo.inc.php" method="POST">
          <br>
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
