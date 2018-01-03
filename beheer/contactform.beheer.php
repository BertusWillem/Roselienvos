<?php
session_start();
$page = "Contact";
include 'header.beheer.php';
include '../includes/dbh.php';
?>

<html>
<body>
 <section class="body-container">
    <section class="container">
        <div class="input-window">
            <h1 style="background: white!important;">Terug naar contactbeheer</h1>

            <?php // feedback bericht als het bericht succesvol is verwijderd.
            if(isset($_GET['error'])){
              if($_GET['error'] === "1"){
                print("<p style='color:green;'>- Bericht is succesvol verwijderd.");
              }
            }
            ?>

            <a href="contact.beheer.php">
              <div class="input-window" id="box" style="width: 100%!important; margin-bottom: 0;">
                <input type="submit" value="Naar contactbeheer">
              </div></a>
        </div>

        <div class="recensie-container">
    				<?php
    					//selecteer alle reacties met id, naam, email, inhoud en datum van de auteur
    					$query = 	"SELECT id, naam, email, inhoud, datum FROM contactformulier ORDER BY datum desc";
    					$result = $dbh->query($query);
    					while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                // De opgevraagde informatie uit de databse wordt uitgeprint in een html tabel
    						echo ("
                  <div class='recensies' id='box' style='color: black!important;'>
                    <table>
                    <h1></h1>
                    <tr><td>van:</td><td>".$row["naam"]."</td></tr>
                    <tr><td>bericht:</td><td>" . $row["inhoud"]  . "</td></tr>
                    <tr><td>op:</td><td>" . $row["datum"]  . "</td></tr>
                    <tr><td id='fout'><a href='paginabewerk.beheer.php?verwijderen=true&&tabel=contact&&id=" . $row["id"]  . "'>verwijder</a></td><td id='goed'><a href='mailto:" . $row["email"] . "'>beantwoorden</td></tr>
                    </table>
                  </div>
                ");
    					}
              ?>
      </div>
    </section>
</section>
</body>
</html>

<?php include ('../footer.php');?>
