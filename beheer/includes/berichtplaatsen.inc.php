<?php
include '../../includes/dbh.php';
$tabel = $_GET['tabel'];
$page = $_GET['page'];
$date = date("d-m-Y");
$id = $tabel.'_id';

// voegt een nieuw nieuwsbericht toe
if ($tabel === 'nieuws'){
	$sth = $dbh->prepare("INSERT INTO nieuws (afbeelding, datum) VALUES (0,'$date')");
	$sth->execute();

	$stmt = $dbh->prepare("SELECT MAX($id) FROM nieuws");
}

// voegt een nieuwe behandeling toe
if ($tabel === 'behandeling'){
	$sth = $dbh->prepare("INSERT INTO behandeling (afbeelding) VALUES (0)");
	$sth->execute();

	$stmt = $dbh->prepare("SELECT MAX($id) FROM behandeling");
}

// haalt het max ID op
$stmt->execute();
$nummer = $stmt->fetch();
$pagina = $nummer['MAX('.$id.')'];

// verwijst je naar de pagina die je net hebt aangemaakt
header ("Location: ../paginabewerk.beheer.php?tabel=$tabel&&pagina=$pagina");
