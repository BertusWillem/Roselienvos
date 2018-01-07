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

if (preg_match("/([%\$#\*\>\<]+)/", $firstname) || preg_match("/([%\$#\*\>\<]+)/", $lastname) || preg_match("/([%\$#\*\>\<]+)/", $adres) ||
preg_match("/([%\$#\*\>\<]+)/", $postcode) || preg_match("/([%\$#\*\>\<]+)/", $woonplaats)){
  $_SESSION['fn'] = $_POST['reg_fn'];
  $_SESSION['ln'] = $_POST['reg_ln'];
  $_SESSION['email'] = $_POST['reg_un'];
  $_SESSION['addr'] = $_POST['reg_addr'];
  $_SESSION['pcode'] = $_POST['reg_pcode'];
  $_SESSION['woonpl'] = $_POST['reg_woonpl'];
  header("Location:../changeinfo.php?error=character");
  exit();
}

//De verschillende velden worden geupdate in de databba
include 'dbh.php';

$stmt = $dbh->prepare("UPDATE gebruiker SET firstname = :firstname, lastname = :lastname
                       WHERE userid = :userid;");
$stmt->execute(array(':firstname' => $firstname, ':lastname' => $lastname, ':userid' => $userid));


$stmt = $dbh->prepare("UPDATE adres SET adres = :adres, postcode = :postcode,
                      woonplaats = :woonplaats WHERE added_by = :userid;");
$stmt->execute(array(':adres' => $adres, ':postcode' => $postcode, ':woonplaats' => $woonplaats, ':userid' => $userid));

header("Location: ../profile.php?message=infoupdated");
?>
