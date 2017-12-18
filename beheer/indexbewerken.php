<?php
session_start();

$page = "Overzicht";
include 'header.beheer.php';

include '../includes/dbh.php';
$stmt = $dbh->prepare("SELECT * FROM pagina p LEFT JOIN afbeeldingen a ON p.afbeelding=a.afbeeldingid");
$stmt->execute();
while ($rows = $stmt->fetch()){
print('
<table border=1px>
  <tr>
    <td>Titel</td>
    <td>'.$rows['titel'].'</td>
  </tr>
  ');
  print('
  <tr>
  <td>test</td>
  <td><a href=paginabewerk.php?pagina='.$rows['pagina_id'].'">Bewerken</td>
  <tr>
  </table><br><br>
  ');
}
?>
