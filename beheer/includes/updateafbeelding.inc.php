<?php
$tabel = $_GET['tabel'];
$pagina = $_GET['pagina'];
//Kon geen _id achter een var plaatsen in een query. Maar dit werkt ook, vies he?
$id = $tabel.'_id';

include '../../includes/dbh.php';

include '../../dbh.php';
$stmt = $dbh->prepare("UPDATE $tabel SET afbeelding = :afbeelding WHERE $id = :pagina;");
$stmt->execute(array(':afbeelding' => $_GET['afbeelding'], ':pagina' => $_GET['pagina']));

header ("Location: ../paginabewerk.beheer.php?tabel=$tabel&&pagina=$pagina");
?>
