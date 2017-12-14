<?php
session_start();

$page = "Overzicht";
include 'header.beheer.php';

?>


<section class="body-container">
  <section class="container">
    <div class="recensie-container">
      <a href="../profile.php"><div class="block">
        <div class="image-view-container">
        <h2>Profiel</h2>
          <div class="image-view">
            <p>Klik hier om uw gebruikersprofiel weer te geven.</p>
          </div>
        </div>
      </div></a>

      <div class="block" id="info">
        <div class="image-view-container">
        <?php
		if (isset($_GET['message'])){
			if ($_GET['message'] === "login")
			print("<p style=color:green;>- U bent succesvol ingelogd en kunt de website beheren");
		}
        print ('<p>Welkom ' . $_SESSION["firstname"].' je bent ingelogd als:</p><h1>' . $_SESSION["role"] .'</h1>' );
        print ('<p>Het is momenteel:</p> <iframe src="http://free.timeanddate.com/clock/i5zsc3ou/n1302/fs20/tct/pct/ftb/th1" frameborder="0" width="82" height="24" allowTransparency="true"></iframe>' );
        print("<p>Je bent ingelogd vanaf:</p><h1>" . $_SERVER['REMOTE_ADDR']. "</h1>");
        ?>
        </div>
      </div>

      <a href=paginaoverzicht.beheer.php?benaming=Paginabeheer&&tabel=pagina><div class="block">
        <div class="image-view-container">
        <h2>Pagina's</h2>
          <div class="image-view">
            <p>Klik hier om de pagina's te wijzigen.</p>
          </div>
        </div>
      </div></a>

      <a href="afspraak.beheer.php"><div class="block">
        <div class="image-view-container">
        <h2>Afspraak</h2>
          <div class="image-view">
            <p>Klik hier om uw agenda te bekijken, of om de beschikbare uren te wijzigen.</p>
          </div>
        </div>
      </div></a>

      <a href=pagina.beheer.php?benaming=Behandeling&&tabel=behandel><div class="block">
        <div class="image-view-container">
        <h2>Behandelingen</h2>
          <div class="image-view">
            <p>Klik hier om behandelingen te wijzigen of om extra behandelingen toe te voegen.</p>
          </div>
        </div>
      </div></a>

      <a href=pagina.beheer.php?benaming=Nieuws&&tabel=nieuws><div class="block">
        <div class="image-view-container">
        <h2>Nieuws</h2>
          <div class="image-view">
            <p>Klik hier om nieuws te wijzigen of om extra nieuws items toe te voegen.</p>
          </div>
        </div>
      </div></a>

      <a href="recensies.beheer.php?review=0"><div class="block">
        <div class="image-view-container">
        <h2>Recensies<p>
        <?php
        include '../includes/dbh.php';
        $stmt = $dbh->prepare("SELECT recensieid FROM recensie WHERE accepted = 0;");
        $stmt->execute();
        $aantal = 0;
        while ($rows = $stmt->fetch()){
        $aantal++;
        }
        if ($aantal == 1){
        print($aantal . " nieuwe recensie &#9786;");
        }
        elseif($aantal > 1){
          print($aantal . " nieuwe recensies &#9786;");
        }
        ?>
        </p></h2>
          <div class="image-view">
            <p>Klik hier om recensies te bekijken en beoordelen.</p>
          </div>
        </div>
      </div></a>

      <a href="contact.beheer.php"><div class="block">
        <div class="image-view-container">
        <h2>Contact</h2>
          <div class="image-view">
            <p>Klik hier om uw contact gegevens aan te passen</p>
          </div>
        </div>
      </div></a>

      <a href="media.beheer.php?uitvoering=beheer"><div class="block">
        <div class="image-view-container">
        <h2>Media</h2>
          <div class="image-view">
            <p>Klik hier om afbeeldingen aan uw website toe te voegen of om ze te verwijderen.</p>
          </div>
        </div>
      </div></a>
    </div>
  </section>
</section>

<?php include ('../footer.php');
