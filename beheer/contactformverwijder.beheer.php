<?php
session_start();
$page = "Contact";
include 'header.beheer.php';
include '../includes/dbh.php';
?>

<?php
// Controleer of er daadwerkelijk een integer (geheel getal) binnen is gekomen
if ( isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT )){
	$id = $_GET['id'];
// Deze query verwijdert het door de gebruiker aangewezen bericht uit de database
	$query = "DELETE FROM contactformulier WHERE id = ? ";
	$stmt = $dbh->prepare($query);
	$stmt->execute(array($id));
	// Als het verwijderen van één bericht is gelukt, verschijnt er een Alert box met de melding dat het verwijderen is gelukt
	echo '<div class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
  <strong>&#10004; De reactie is verwijderd!
</div>';
// Als het verwijderen van één bericht wel glukt, wordt de gebruiker automatisch weer teruggestuurd naar contactform.beheer.php, ook staat er een link om terug te keren
	echo '<BR> <p style="text-align: center;">U wordt automatisch weer teruggestuurd, gebeurt er niks? <a href="contactform.beheer.php">Klik dan hier</a></p>';
// Script dat de gebruiker automatisch weer naar de contactform.beheer.php stuurt
header("Refresh:2; url=contactform.beheer.php"); }
	else {
		// Als het verwijderen van één bericht niet is gelukt, verschijnt er een Alert box met de melding dat het verwijderen niet is gelukt
	echo '<div class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
  <strong>&#88; Verwijderen van reactie is niet gelukt.
</div>';
// Als het verwijderen van één bericht niet is glukt, wordt de gebruiker automatisch weer teruggestuurd naar contactform.beheer.php, ook staat er een link om terug te keren
	echo '<BR> <p style="text-align: center;">U wordt automatisch weer teruggestuurd, gebeurt er niks? <a href="contactform.beheer.php">Klik dan hier</a></p>';
	// Script dat de gebruiker automatisch weer naar de contactform.beheer.php stuurt
	header("Refresh:2; url=contactform.beheer.php"); }
?>

<?php include ('../footer.php');?>
