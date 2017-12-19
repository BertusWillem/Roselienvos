<?php
session_start();
$page = "Contact";
include 'header.beheer.php';
include '../includes/paginalader.inc.php';


$result = contactgegeven($dbh);
$email=($result["email"]);
$telnummer=($result["telnummer"]);
$adres=($result["adres"]);
?>

<html>
<body>
 <section class="body-container">
    <section class="container">
        <div class="input-window">
            <h1 style="background: white!important;">Wijzig hier uw contactgegevens</h1>
            <form method="post" action="includes/contact.inc.php">
                <input type="text" name="email" <?php print("value='".$email."'");?>>
                <input type="text" name="telefoonnummer" <?php print("value='".$telnummer."'");?>>
                <input type="text" name="adres" <?php print("value='".$adres."'");?>>
                <div class="input-window" id="box" style="width: 100%!important; margin-bottom: 0;">
                  <input id="Verstuur" type="submit" name="Verstuur" value="Wijzigen">
                </div>
            </form>
            <h1 style="background: white!important; margin-top: 25px;">Berichten inzien</h1>
            <a href="contactform.beheer.php">
              <div class="input-window" id="box" style="width: 100%!important; margin-bottom: 0;">
                <input type="submit" value="Naar berichten">
              </div>
        </div>
    </section>
</section>
</body>
</html>

<?php include ('../footer.php');?>
