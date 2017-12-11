<?php
$tabel = $_GET['tabel'];
$pagina = $_GET['pagina'];
//Kon geen _id achter een var plaatsen in een query. Maar dit werkt ook, vies he?
$id = $tabel.'_id';

include '../../includes/dbh.php';

if ($tabel == 'behandel'){
  $stmt = $dbh->prepare("UPDATE behandel SET afbeelding = :afbeelding WHERE behandel_id = :pagina;");
  $stmt->execute(array(':afbeelding' => $_GET['afbeelding'], ':pagina' => $_GET['pagina']));
} elseif ($tabel == 'nieuws'){
  $stmt = $dbh->prepare("UPDATE nieuws SET afbeelding = :afbeelding WHERE nieuws_id = :pagina;");
  $stmt->execute(array(':afbeelding' => $_GET['afbeelding'], ':pagina' => $_GET['pagina']));
} elseif ($tabel == 'pagina'){
  $stmt = $dbh->prepare("UPDATE pagina SET afbeelding = :afbeelding WHERE pagina_id = :pagina;");
  $stmt->execute(array(':afbeelding' => $_GET['afbeelding'], ':pagina' => $_GET['pagina']));
}

header ("Location: ../paginabewerk.beheer.php?tabel=$tabel&&pagina=$pagina");
?>
