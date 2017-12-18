<?php
session_start();
if (!isset($_SESSION['userid'])){
  header("Location: login.php");
}
print("<p>Inloggen, even geduld aub... Deel uw wachtwoord nooit met iemand!</p>");

include 'includes/dbh.php';
$stmt = $dbh->prepare("DELETE FROM attemts WHERE time < NOW() - INTERVAL 10 MINUTE");
$stmt->execute();

$stmt = $dbh->prepare("DELETE FROM attemts WHERE ip = :ip");
$stmt->execute(array(':ip' => $_SERVER["REMOTE_ADDR"]));

$datu = date("Y/m/d");
$stmt = $dbh->prepare("UPDATE gebruikers SET last_seen = :datu WHERE userid = :userid");
$stmt->execute(array(':datu' => $datu, ':userid' => $_SESSION['userid']));

if ($_SESSION['role'] === "1")
{
  header("Refresh:2; url=beheer/?message=login");
}
else
{
  header("Refresh:2; url=profile.php?message=login");
}

?>
