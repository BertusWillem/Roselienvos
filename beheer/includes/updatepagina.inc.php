<?php
include '../../includes/dbh.php';
$pagina = $_GET['pagina'];
$tabel = $_GET['tabel'];

//Kon geen _id achter een var plaatsen in een query. Maar dit werkt ook, vies he?
$id = $tabel.'_id';

$sth = $dbh->prepare("SELECT * FROM pagina");
$sth -> execute();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $newtitel = $_POST["titel"];
  $newinhoud= $_POST["inhoud"];

  $sth = $dbh->prepare("UPDATE $tabel SET titel=:newtitel, inhoud=:newinhoud WHERE $id = $pagina");
  $sth->execute(array(':newtitel' => $newtitel, ':newinhoud' => $newinhoud));
}

header ("Location: ../paginabewerk.beheer.php?tabel=$tabel&&pagina=$pagina");
