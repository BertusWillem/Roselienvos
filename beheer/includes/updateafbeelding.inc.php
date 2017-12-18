<?php
$tabel = $_GET['tabel'];
$pagina = $_GET['pagina'];

include '../../includes/dbh.php';

// update een afbeelding op basis van de tabel naam
if ($tabel == 'behandeling'){
  $stmt = $dbh->prepare("UPDATE behandeling SET afbeelding = :afbeelding WHERE behandeling_id = :pagina;");
  $stmt->execute(array(':afbeelding' => $_GET['afbeelding'], ':pagina' => $_GET['pagina']));
} elseif ($tabel == 'nieuws'){
  $stmt = $dbh->prepare("UPDATE nieuws SET afbeelding = :afbeelding WHERE nieuws_id = :pagina;");
  $stmt->execute(array(':afbeelding' => $_GET['afbeelding'], ':pagina' => $_GET['pagina']));
} elseif ($tabel == 'pagina'){
  $stmt = $dbh->prepare("UPDATE pagina SET afbeelding = :afbeelding WHERE pagina_id = :pagina;");
  $stmt->execute(array(':afbeelding' => $_GET['afbeelding'], ':pagina' => $_GET['pagina']));
}

// verwijst je weer terug naar de oorspronkelijke pagina
header ("Location: ../paginabewerk.beheer.php?tabel=$tabel&&pagina=$pagina");
?>
