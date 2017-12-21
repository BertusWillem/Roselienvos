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

// Script dat de gebruiker automatisch weer naar de contactform.beheer.php stuurt
header("location: contactform.beheer.php?error=1");}
?>

<?php include ('../footer.php');?>
