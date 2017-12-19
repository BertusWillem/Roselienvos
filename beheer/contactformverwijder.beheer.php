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
	$db = new PDO('mysql:host=localhost;dbname=roselienvos', 'root', '');

	$query = "DELETE FROM contactformulier WHERE id = ? ";
	$stmt = $db->prepare($query);
	$stmt->execute(array($id));
	echo 'De reactie is verwijderd!<br  />';
	echo 'Ga terug naar de <a href="contactform.beheer.php">reacties</a>.<br />';
} else {
	echo "Ongeldige aanvraag";
}
?>
</body>
</html>
