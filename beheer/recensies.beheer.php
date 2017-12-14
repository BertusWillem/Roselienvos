<?php
session_start();
$page = "Recensies";
include 'header.beheer.php';
include '../includes/dbh.php';
?>

<section class='body-container'>
  <section class='container'>
    <div class='recensie-container'>
      <div class='input-window' id='box' style='width: 100%!important';>
        <form action='recensies.beheer.php' method='GET'>
        <select name='review' style="margin-bottom: 0;">
          <option value ="" >Selecteer een overzicht</option>
          <option value ="1">Goedgekeurd</option>
          <option value ="2">Afgekeurd</option>
          <option value ="0">Openstaand</option>
        </select>
        <input type="submit" value="Zoeken" style="margin-bottom: 25px;">
      </div>

<?php
if (isset($_GET['message'])){
  if ($_GET['message'] === "success"){
    print("<p style='color:green; width:100%;'>- De recensie is succesvol goedgekeurd/afgekeurd</p>");
  }
}
if (isset($_GET['review'])){
$stmt = $dbh->prepare("SELECT * FROM recensie WHERE accepted = :val");
$stmt->execute(array(':val' => $_GET['review']));

while ($rows = $stmt->fetch()){
  print ("
  <div class='recensies' id='box'>
    <h1>".ucfirst(strtolower($rows['title']))."</h1>
    <table>
      <tr>
        <td>Auteur</td>
        <td>".ucfirst(strtolower($rows['author']))."</td>
      </tr><tr>
        <td>Beoordeling</td>
        <td>".ucfirst(strtolower($rows['rate']))."</td>
      </tr><tr>
        <td>Toelichting</td>
        <td>".ucfirst(strtolower($rows['note']))."</td>
      </tr><tr>
        <td id='goed'><a href='includes/approve.inc.php?approve=".$rows['recensieid']."'>Goedkeuren</a></td>
        <td id='fout'><a href='includes/approve.inc.php?deny=".$rows['recensieid']."'>Afkeuren</a></td>
      </tr>
    </table>
  </div>
  ");
  }
}?>

</div>
</section>
</section>

<?php include ('../footer.php');
