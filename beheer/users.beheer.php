<?php
session_start();
$page = "Gebruikers";
include 'header.beheer.php';

include '../includes/dbh.php';
$stmt = $dbh->prepare("SELECT userid, email, firstname, lastname, last_seen FROM gebruiker WHERE rol = 0");
$stmt->execute();
print('
  <section class="body-container">
    <section class="container">
      <div class="desktop" id="box">
        <table border=1px;>
          <tr>
            <th>Email</th>
            <th>Voornaam</th>
            <th>Achternaam</th>
            <th>Laatst gezien</th>
            <th>Actie</th>
      </tr>
        ');
while ($rows = $stmt->fetch()){
print("<tr>
    <tr>
      <td>".$rows['email']."</td>
      <td>".$rows['firstname']."</td>
      <td>".$rows['lastname']."</td>
      <td>".$rows['last_seen']."</td>
      <td id='fout'><a class='echo_link' href='includes/deluser.inc.php?user=".$rows['userid']."' onclick='return confirm(\"Weet u zeker dat u "
      .$rows['firstname']." ".$rows['lastname']." wilt verwijderen?\")'> Verwijderen </a></td>");
}
print("</tr></table></section></section></div>");

include '../footer.php';
?>
