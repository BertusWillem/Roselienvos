<?php
session_start();
$page = "Contact";
include 'header.beheer.php';
include '../includes/dbh.php';
?>

<?php
// Controleer of we daadwerkelijk een integer (geheel getal) hebben binnen gekregen
if ( isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT )){
	$id = $_GET['id'];

	// Verbinding maken met de database

	$query = "DELETE FROM contactformulier WHERE id = ? ";
	$stmt = $dbh->prepare($query);
	$stmt->execute(array($id));
	echo '<div class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
  <strong>De reactie is verwijderd!
</div>';
	echo 'Ga terug naar de <a href="contactform.beheer.php">reacties</a>.<br />';
} else {
	echo "Ongeldige aanvraag";
}
?>

<?php include ('../footer.php');?>
