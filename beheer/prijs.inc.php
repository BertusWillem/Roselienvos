<?php
include '../includes/dbh.php';
$page = "prijs beheer new line";
session_start();
if(isset($_GET["newline"])){ //moeten er nieuwe regels in de database worden gestopt?
  if(isset($_GET["behandellist"])){ //is er al een aantal geselecteerd of moet dit nog gebeuren
    $sth = $dbh ->prepare("SELECT `behandeling_id` FROM `behandeling` WHERE titel = ?"); //selecteer de behandeling_id die bij de titel hoort
    $sth -> execute(array($_GET["behandellist"]));
    $result = $sth ->fetch(PDO::FETCH_ASSOC);
    $number = $_GET["aantal"]; //defineer hoe vaak er een lege regel moet worden toegevoegd
    while ($number > 0) { //terwijl nummer groter is dan 0
      $sth2 = $dbh ->prepare("INSERT INTO `prijs`(`behandeling_id`) VALUES (?)"); //voeg een nieuwe regel toe bij de juiste behandeling_id
      $sth2 -> execute(array($result["behandeling_id"]));
      $result2 = $sth2 ->fetch(PDO::FETCH_ASSOC);
      $number = $number - 1; //haal een van het overgebleven aantal af
    }
   header ("Location: prijs.beheer.php"); //je wordt nu terug gestuurd naar de prijs beheer pagina

}else{ //is het aantal nieuwe regels nog niet bepaald?
  include "header.beheer.php"; //laad de header
  echo("<section class='body-container'>
    <section class='container'>");

    echo('<form id="box"> <p>Selecteer de lijst waar lege velden aan toegevoegd moeten worden:</p>
    <select style="margin: auto; width: 33%;" name="behandellist">'); //maak een dropdown selector om te kiezen welke behandeling lege rijen krijgt

      $sth = $dbh ->prepare("SELECT titel FROM behandeling"); //laad de behandelingen uit de database
      $sth -> execute(array());
    while($result = $sth ->fetch(PDO::FETCH_ASSOC)){
      echo("<option value=".$result['titel'].">".$result['titel']."</option>"); //stop de titels van de behandelingen in een dropdown
    }
    echo('</select>');
    echo("</br><p>selecteer het aantal lege velden:</p>"); //maak een dropdown om het aantal lege velden te kiezen
    $number = 1;
    echo('<select name="aantal">');
    while($number < 6){ //print 5 keer de code
      echo("<option value=".$number.">".$number."</option>"); //voeg het nummer toe aan de dropdown list
      $number++;
    }

    echo('<input type=hidden name=newline value='.($_GET["newline"]).'>
    <input type=submit value=opslaan name=versturen></form>'); //stuur een verborgen waarde mee als er op opslaan wordt geklikt
}}else{





$id=$_GET["id"]; //geef de variabele id de waarde die in de GET is meegegeven

if(isset($_GET["type"]) && $_GET["type"] == "verwijderen"){ //moet er iets verwijderd worden?
  echo ("laden..."); //laat laden zien tijden het korte moment dat er een witte pagina is
  $sth2 = $dbh ->prepare("DELETE FROM `prijs` WHERE prijs_id = :id"); //verwijder de geselecteerde prijs
  $sth2 -> execute(array(':id' => $id));
  $sth2 ->fetch(PDO::FETCH_ASSOC);

}

header("Refresh:0; url=prijs.beheer.php"); //stuur terug naar de vorige pagina
}
 ?>
