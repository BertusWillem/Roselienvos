
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php print($page);?> | Roselien Vos</title>
    <link rel="stylesheet" href="css/master.css">
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
                print('<li><a href="login.php">Aanmelden</a></li>');
              }
              else{
                print('<li><a href="includes/logout.inc.php">Uitloggen</a></li>');
                print('<li><a href="profile.php">Profiel</a></li>');
                if ($_SESSION['role'] === "admin"){
                  print('<li><a href="beheer/index.php">Beheer pagina</a></li>');
                }
              }?>
              <li><a href="index.php">Over mij</a></li>
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
            <h1>Medisch pedicure Roselien</h1>
          </div>
        </a>

        <div class="login">
          <?php
          if (!isset($_SESSION['userid']))
          {
            print('<a href="login.php">Aanmelden</a>');
          }
          else{
            print('<a href="includes/logout.inc.php">Uitloggen</a>');
            if ($_SESSION['role'] === "admin"){
              print('<a>|</a>');
              print('<a href="beheer">Beheer paneel</a>');
            }
            else{
              print('<a href="profile.php">Profiel</a>');
            }
          }
          ?>
        </div>
      </section>
    </section>

    <ul>
      <li class="first"><?php if ($page == "Over mij") {print("<img src=\"image/selection.png\">");} ?><a href="index.php">Over mij</a></li>
      <li><?php if ($page == "Behandelingen") {print("<img src=\"image/selection.png\">");} ?><a href="behandeling.php">Behandelingen</a></li>
      <li><?php if ($page == "Nieuws") {print("<img src=\"image/selection.png\">");} ?><a href="nieuws.php">Nieuws</a></li>
      <li><?php if ($page == "Afspraak maken") {print("<img src=\"image/selection.png\">");} ?><a href="afspraak.php">Afspraak maken</a></li>
      <li><?php if ($page == "Contact") {print("<img src=\"image/selection.png\">");} ?><a href="contact.php">Contact</a></li>
      <li class="last"><?php if ($page == "Recensies") {print("<img src=\"image/selection.png\">");} ?><a href="recensies.php">Recensies</a></li>
    </ul>

    <section class="top-container">
      <div class="header" id="image" style="margin-bottom: 0;">
        <img src="image/Drawing.png">
      </div>
    </section>

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
