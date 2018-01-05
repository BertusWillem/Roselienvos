<?php
include '../../includes/dbh.php';
$tabel = $_GET['tabel'];
$pagina = $_GET['pagina'];
$uitvoering = $_GET['kiezen'];

$nummer = 0; // wordt gebruikt voor de verwijdering van plaatjes.
$nieuw = 0; // wordt gebruikt voor de verwijdering van plaatjes.
$tel = 0; // wordt gebruikt voor het kijken of er niet te veel afbeeldingen op de pagina komen.

$checkdubbel = explode(".", $_GET['old']); // explode de afbeeldingen.
$check = 0; // zet de check op 0

// bekijkt de geexplode afbeeldingen of er duplicates in zitten.
foreach ($checkdubbel as $dubbel) {
  $tel++;
  if ($dubbel == $_GET['afbeelding']){
    $check = 1; // zet check op 1 als er een duplicate is gevonden.
  }
  if ($tel > 4){
    $check = 3; // zet check op 3 als er meer dan 3 plaatjes op de pagina staan.
  }
}

if ($check == 1) { // verwijst je weer terug naar de oorspronkelijke pagina met een error
  header ("Location: ../paginabewerk.beheer.php?tabel=$tabel&&pagina=$pagina&&error=1");
}

if ($check == 3) { // verwijst je weer terug naar de oorspronkelijke pagina met een error
  header ("Location: ../paginabewerk.beheer.php?tabel=$tabel&&pagina=$pagina&&error=2");
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

// Verwijderen van een afbeelding op deze pagina, welke afbeelding wordt aangegeven door plaatje= in de url
if(isset($_GET["uitvoering"]) && $_GET["uitvoering"] =='verwijderen'){
  // selecteerd de afbeeldingen in de afbeelding tabel per cijfer per tabel
  if($tabel == 'pagina'){ $sth = $dbh->prepare("SELECT afbeelding FROM pagina WHERE pagina_id = $pagina");}
  if($tabel == 'nieuws'){ $sth = $dbh->prepare("SELECT afbeelding FROM nieuws WHERE nieuws_id = $pagina");}
  if($tabel == 'behandeling'){ $sth = $dbh->prepare("SELECT afbeelding FROM behandeling WHERE behandeling_id = $pagina");}
  $sth -> execute();
  while ($result = $sth ->fetch(PDO::FETCH_ASSOC)){
    $afbeeldingen = explode(".", $result['afbeelding']); // zorgt ervoor dat elk cijfer apart in een array kom te staan
    foreach ($afbeeldingen as $afbeelding) { // voor elk cijfer achter de punt een plaatje tonen.
      if($afbeelding == $_GET['plaatje']){ // kijken of een afbeelding overeen komt met het plaatje dat wordt aangegeven in de url.
        $afbeeldingen[$nummer] = ''; // zo ja? zet het plaatje op niks.
      }
      $nummer++;
    }

    // maakt een afbeelding lijstje voor de nieuwe array in de database.
    for ($i = 0, $punt = 0, $a='',$b='',$c='',$d=''; $i < $nummer ; $i++) {
      if ($afbeeldingen[$i] != ''){
        if ($a == ''){
          $a = ($afbeeldingen[$i]); // print nummers zonder punt ervoor
        }
        elseif ($a != '' && $b == ''){ // zorgt ervoor dat het eerste nummer in de rij geen punt ervoor krijgt
          $b = ('.'.$afbeeldingen[$i]); // print nummers met een punt ervoor
        }
        elseif ($a != '' && $b != '' && $c == ''){ // zorgt ervoor dat het eerste nummer in de rij geen punt ervoor krijgt
          $c = ('.'.$afbeeldingen[$i]); // print nummers met een punt ervoor
        }
        elseif ($a != '' && $b != '' && $c != '' && $d == ''){ // zorgt ervoor dat het eerste nummer in de rij geen punt ervoor krijgt
          $d = ('.'.$afbeeldingen[$i]); // print nummers met een punt ervoor
        }
      }
      }

      if ($_GET['plaatje'] == NULL or $_GET['plaatje'] == 0){ // check zodat als er geen afbeelding deze op 0 wordt gezet in de database.
        $a = 0;
      }
    } // einde van de while

    $nieuw = ($a.$b.$c.$d); // maakt de nieuwe afbeeldingenlijst aan.

    // update de database met de nieuwe afbeeldingenlijst per tabel.
    if ($tabel == 'pagina' && $_GET['uitvoering'] == 'verwijderen'){
      $uil = $dbh->prepare("UPDATE pagina SET afbeelding = :nieuw WHERE pagina_id = :pagina");
      $uil -> execute(array(':pagina' => $pagina, ':nieuw' => $nieuw));
      $check = 2;
    }
    if ($tabel == 'nieuws' && $_GET['uitvoering'] == 'verwijderen'){
      $uil = $dbh->prepare("UPDATE nieuws SET afbeelding = :nieuw WHERE nieuws_id = :pagina");
      $uil -> execute(array(':pagina' => $pagina, ':nieuw' => $nieuw));
      $check = 2;
    }
    if ($tabel == 'behandeling' && $_GET['uitvoering'] == 'verwijderen'){
      $uil = $dbh->prepare("UPDATE behandeling SET afbeelding = :nieuw WHERE behandeling_id = :pagina");
      $uil -> execute(array(':pagina' => $pagina, ':nieuw' => $nieuw));
      $check = 2;
    }
} // einde van de if statement

if ($check == 0){
  header ("Location: ../paginabewerk.beheer.php?tabel=$tabel&&pagina=$pagina&&succes=2"); // verwijst je weer terug naar de oorspronkelijke pagina

}
if ($check == 2){
  header ("Location: ../paginabewerk.beheer.php?tabel=$tabel&&pagina=$pagina&&succes=1"); // verwijst je weer terug naar de oorspronkelijke pagina

}
?>
