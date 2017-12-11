<?php
session_start();
//Hier worden alle variablelen vanuit changeinfo.php gedefinieerd.
//De informatie hoeft niet persee ingevuld te worden, het is optioneel.
$userid = $_SESSION['userid'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$adres = $_POST['adres'];
$postcode = $_POST['postcode'];
$woonplaats = $_POST['woonplaats'];


//De verschillende velden worden geupdate in de databba
include 'dbh.php';

$stmt = $dbh->prepare("UPDATE gebruikers SET firstname = :firstname, lastname = :lastname
                       WHERE userid = :userid;");
$stmt->execute(array(':firstname' => $firstname, ':lastname' => $lastname, ':userid' => $userid));


$stmt = $dbh->prepare("UPDATE gegevens SET adres = :adres, postcode = :postcode,
                      woonplaats = :woonplaats WHERE added_by = :userid;");
$stmt->execute(array(':adres' => $adres, ':postcode' => $postcode, ':woonplaats' => $woonplaats, ':userid' => $userid));

header("Location: ../profile.php?message=infoupdated");
?>
