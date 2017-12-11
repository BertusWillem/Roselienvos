<?php
include '../../includes/dbh.php';
$tabel = $_GET['tabel'];
$page = $_GET['page'];
$date = date("d-m-Y");

//Kon geen _id achter een var plaatsen in een query. Maar dit werkt ook, vies he?
$id = $tabel.'_id';

if ($tabel === 'nieuws'){
	$sth = $dbh->prepare("INSERT INTO $tabel (afbeelding, datum) VALUES (0,'$date')");
	$sth->execute();
}

if ($tabel === 'behandel'){
	$sth = $dbh->prepare("INSERT INTO $tabel (afbeelding) VALUES (0)");
	$sth->execute();
}

$stmt = $dbh->prepare("SELECT MAX($id) FROM $tabel");
$stmt->execute();
$nummer = $stmt->fetch();

$pagina = $nummer['MAX('.$id.')'];


header ("Location: ../paginabewerk.beheer.php?tabel=$tabel&&pagina=$pagina");