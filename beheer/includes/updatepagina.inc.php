<?php
include '../../includes/dbh.php';
$pagina = $_GET['pagina'];
$tabel = $_GET['tabel'];

$sth = $dbh->prepare("SELECT * FROM pagina");
$sth -> execute();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $newtitel = $_POST["titel"];
  $newinhoud= $_POST["inhoud"];

  if ($tabel == 'behandel') {
    $sth = $dbh->prepare("UPDATE behandel SET titel=:newtitel, inhoud=:newinhoud WHERE behandel_id = :pagina");
  } elseif ($tabel == 'nieuws') {
    $sth = $dbh->prepare("UPDATE nieuws SET titel=:newtitel, inhoud=:newinhoud WHERE nieuws_id = :pagina");
  } elseif ($tabel == 'pagina') {
    $sth = $dbh->prepare("UPDATE pagina SET titel=:newtitel, inhoud=:newinhoud WHERE pagina_id = :pagina");
  }
  $sth->execute(array(':newtitel' => $newtitel, ':newinhoud' => $newinhoud, ':pagina' => $pagina));
}

header ("Location: ../paginabewerk.beheer.php?tabel=$tabel&&pagina=$pagina");
