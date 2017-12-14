<?php
if ($_SESSION['role'] !== "1"){
  header ("Location: ../login.php?error=permission");
  exit();
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php print($page);?> | Beheer paneel</title>
    <link rel="stylesheet" href="../css/master.css">
    <link rel="stylesheet" href="css/beheer.css">
  </head>

  <!--header-->
  <body>
    <section class="top" id="sticky" style="position: sticky;">
      <section class="top-container">
        <div class="dropdown" onclick="mobileMenu()">
          <div class="mobile-menu" id="openMenu" style="display: none;">
            <ul>
              <?php if (!isset($_SESSION['userid']))
              {
                print('<li><a href="../login.php">Aanmelden</a></li>');
              }
              else{
                print('<li><a href="../includes/logout.inc.php">Uitloggen</a></li>');
                print('<li><a href="../profile.php">Profiel</a></li>');
                if ($_SESSION['role'] === "1"){
                  print('<li><a href="index.php">Beheer pagina</a></li>');
                }
              }?>
              <li><a href="index.php">over mij</a></li>
              <li><a href="afspraak.php">Afspraak maken</a></li>
              <li><a href="behandeling.php">Behandelingen</a></li>
              <li><a href="nieuws.php">Nieuws</a></li>
              <li><a href="recensies.php">Recensies</a></li>
              <li><a href="contact.php">Contact</a></li>
            </ul>
          </div>
        </div>

        <a href="index.php">
          <div class="logo">
            <img src="image/logo.png">
            <h1>Beheer paneel</h1>
          </div>
        </a>

        <div class="login">
          <?php
          if (!isset($_SESSION['userid']))
          {
            print('<a href="../login.php">Aanmelden</a>');
          }
          else{
            print('<a href="../includes/logout.inc.php">Uitloggen</a>');
            if ($_SESSION['role'] === "1"){
              print('<a>|</a>');
              print('<a href="../profile.php">Terug naar de website</a>');
            }
            else{
              print('<a href="../profile.php">Profiel</a>');
            }
          }
          ?>
        </div>
      </section>
    </section>

    <!--Laat een terugknop zien op elke pagina exclusief de overzicht pagina-->
    <?php
    if ($page !== "Overzicht"){
    print('
      <section class="body-container" style="min-height: auto;">
        <section class="container" style="padding-bottom: 0;">
          <a href="index.php"><div class="input-window" id="box" style="width: 100%!important; margin-bottom: 0;">
            <input type="submit" value="Terug naar beheer paneel">
          </div></a>
        </section>
      </section>
    ');}
    ?>

    <!--Javascript om het mobiele menu te openen en te sluiten-->
    <script>
      function mobileMenu() {
        var x = document.getElementById("openMenu");
        var y = document.getElementById("sticky");
        if (x.style.display === "none") {
          x.style.display = "block";
        } else {
          x.style.display = "none";
        }

        if (y.style.position === "sticky"){
          y.style.position = "relative";
        } else {
          y.style.position = "sticky";
        }
      }
    </script>
