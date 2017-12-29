<?php
include '../../includes/dbh.php';
$tabel = $_GET['tabel'];
$pagina = $_GET['pagina'];
$uitvoering = $_GET['kiezen'];

$checkdubbel = explode(".", $_GET['old']); // explode de afbeeldingen.
$check = 0; // zet de check op 0

// bekijkt de geexplode afbeeldingen of er duplicates in zitten.
foreach ($checkdubbel as $dubbel) {
  if ($dubbel == $_GET['afbeelding']){
    $check = 1; // zet check op 1 als er een duplicate is gevonden.
  }
}

if ($check == 1) { // verwijst je weer terug naar de oorspronkelijke pagina met een error
  header ("Location: ../paginabewerk.beheer.php?tabel=$tabel&&pagina=$pagina&&error=1");
}

if ($tabel == 'pagina'){ // update een afbeelding op basis van de tabel naam
  if ($check == 0){
    if ($_GET['old'] != NULL){ // kijkt of er al een afbeelding in staat
      $stmt = $dbh->prepare("UPDATE pagina SET afbeelding = :afbeelding WHERE pagina_id = :pagina;");
      $stmt->execute(array(':afbeelding' => ($_GET['old'].".".$_GET['afbeelding']), ':pagina' => $_GET['pagina']));
    }
    else{ // als er nog geen afbeelding is upload een afbeelding
      $stmt = $dbh->prepare("UPDATE pagina SET afbeelding = :afbeelding WHERE pagina_id = :pagina;");
      $stmt->execute(array(':afbeelding' => $_GET['afbeelding'], ':pagina' => $_GET['pagina']));
    }
  }
}

elseif ($tabel == 'nieuws'){ // update een afbeelding op basis van de tabel naam
  if ($check == 0){
    if ($_GET['old'] != NULL){ // kijkt of er al een afbeelding in staat
      $stmt = $dbh->prepare("UPDATE nieuws SET afbeelding = :afbeelding WHERE nieuws_id = :pagina;");
      $stmt->execute(array(':afbeelding' => ($_GET['old'].".".$_GET['afbeelding']), ':pagina' => $_GET['pagina']));
    }
    else{ // als er nog geen afbeelding is upload een afbeelding
      $stmt = $dbh->prepare("UPDATE nieuws SET afbeelding = :afbeelding WHERE nieuws_id = :pagina;");
      $stmt->execute(array(':afbeelding' => $_GET['afbeelding'], ':pagina' => $_GET['pagina']));
    }
  }
}

// behandeling heeft niet meerdere afbeeldingen nodig en hier wordt dus ook geen rekening mee gehouden.
if ($tabel == 'behandeling'){ // update een afbeelding op basis van de tabel naam
  $stmt = $dbh->prepare("UPDATE behandeling SET afbeelding = :afbeelding WHERE behandeling_id = :pagina;");
  $stmt->execute(array(':afbeelding' => $_GET['afbeelding'], ':pagina' => $_GET['pagina']));
}

if ($check == 0){
  header ("Location: ../paginabewerk.beheer.php?tabel=$tabel&&pagina=$pagina"); // verwijst je weer terug naar de oorspronkelijke pagina
}
?>
