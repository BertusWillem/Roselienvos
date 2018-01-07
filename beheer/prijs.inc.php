<?php
include '../includes/dbh.php';
$page = "prijs beheer new line";
session_start();
if(isset($_GET["newline"])){
  if(isset($_GET["behandellist"])){
    $sth = $dbh ->prepare("SELECT `behandeling_id` FROM `behandeling` WHERE titel = ?");
    $sth -> execute(array($_GET["behandellist"]));
    $result = $sth ->fetch(PDO::FETCH_ASSOC);
    $number = $_GET["aantal"];
    while ($number > 0) {
      $sth2 = $dbh ->prepare("INSERT INTO `prijs`(`behandeling_id`) VALUES (?)");
      $sth2 -> execute(array($result["behandeling_id"]));
      $result2 = $sth2 ->fetch(PDO::FETCH_ASSOC);
      $number = $number - 1;
    }
   header ("Location: prijs.beheer.php");

}else{
  include "header.beheer.php";
  echo("<section class='body-container'>
    <section class='container'>");

    echo('<form id="box"> <p>Selecteer de lijst waar lege velden aan toegevoegd moeten worden:</p>
    <select style="margin: auto; width: 33%;" name="behandellist">');

      $sth = $dbh ->prepare("SELECT titel FROM behandeling");
      $sth -> execute(array());
    while($result = $sth ->fetch(PDO::FETCH_ASSOC)){
      echo("<option value=".$result['titel'].">".$result['titel']."</option>");
    }
    echo('</select>');
    echo("</br><p>selecteer het aantal lege velden:</p>");
    $number = 1;
    echo('<select name="aantal">');
    while($number < 6){
      echo("<option value=".$number.">".$number."</option>");
      $number++;
    }

    echo('<input type=hidden name=newline value='.($_GET["newline"]).'>
    <input type=submit value=opslaan name=versturen></form>');
}}else{





$id=$_GET["id"];

if(isset($_GET["type"]) && $_GET["type"] == "verwijderen"){
  echo ("laden...");
  $sth2 = $dbh ->prepare("DELETE FROM `prijs` WHERE prijs_id = :id");
  $sth2 -> execute(array(':id' => $id));
  $sth2 ->fetch(PDO::FETCH_ASSOC);

}
//else{
//$sth2 = $dbh ->prepare("INSERT INTO prijs (behandeling_id) VALUES (:id)");
//$sth2 -> execute(array(':id' => $id));
//$sth2 ->fetch(PDO::FETCH_ASSOC);
//}
header("Refresh:0; url=prijs.beheer.php");
}
 ?>
