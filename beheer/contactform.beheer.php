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
    						echo ("
                  <div class='recensies' id='box' style='color: black!important;'>
                    <table>
                    <h1></h1>
                    <tr><td>van:</td><td>".$row["naam"]."</td></tr>
                    <tr><td>bericht:</td><td>" . $row["inhoud"]  . "</td></tr>
                    <tr><td>op:</td><td>" . $row["datum"]  . "</td></tr>
                    <tr><td id='fout'><a href='contactform.beheer.php?id=" . $row["id"]  . "'>verwijder</a></td><td id='goed'><a href='mailto:" . $row["email"] . "'>beantwoorden</td></tr>
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

<?php
// Controleer of we daadwerkelijk een integer (geheel getal) hebben binnen gekregen
if ( isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT )){
	$id = $_GET['id'];

	// Verbinding maken met de database

	$query = "DELETE FROM contactformulier WHERE id = ? ";
	$stmt = $dbh->prepare($query);
	$stmt->execute(array($id));
	echo '<div class="alert-box success"><span> </span>De reactie is verwijderd!</div><br  />';
	echo 'Ga terug naar de <a href="contactform.beheer.php">reacties</a>.<br />';
} else {
	echo "Ongeldige aanvraag";
}
?>

<?php include ('../footer.php');?>
