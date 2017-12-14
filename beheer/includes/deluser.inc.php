<?php

include '../../includes/dbh.php';
$stmt = $dbh->prepare("DELETE FROM gebruikers WHERE userid = :userid AND rol = 'klant'");
$stmt->execute(array(':userid' => $_GET['user']));

header("Location: ../users.beheer.php");
?>
