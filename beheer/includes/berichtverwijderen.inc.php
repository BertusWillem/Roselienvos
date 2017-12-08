<?php
include '../../includes/dbh.php';
$tabel = $_GET['tabel'];
$pagina = $_GET['pagina'];

//Kon geen _id achter een var plaatsen in een query. Maar dit werkt ook, vies he?
$id = $tabel.'_id';

$sth = $dbh->prepare("DELETE FROM :tabel WHERE :ID=:pagina");
$sth->execute(array(':tabel' => $tabel, ':ID' => $id, ':pagina' => $pagina)

header ("Location: ../index.php");