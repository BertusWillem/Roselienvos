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
include 'loginsystem.func.php';
changeProfile($userid, $firstname,$lastname,$adres,$postcode,$woonplaats);
