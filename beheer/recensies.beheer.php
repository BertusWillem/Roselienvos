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
  if ($_GET['message'] === "successdel"){
    print("<p style='color:green; width:100%;'>- De recensie is succesvol verwijderd</p>");
  }
  elseif($_GET['message'] === "successapprove"){
    print("<p style='color:green; width:100%;'>- De recensie is succesvol goedgekeurd</p>");
  }
  elseif($_GET['message'] === "successdeny"){
    print("<p style='color:green; width:100%;'>- De recensie is succesvol afgekeurd</p>");
  }
}
if (isset($_GET['review'])){
$stmt = $dbh->prepare("SELECT * FROM recensie WHERE status = :val");
$stmt->execute(array(':val' => $_GET['review']));

while ($rows = $stmt->fetch()){
  print ("
  <div class='recensies' id='box'>
    <h1>".ucfirst(strtolower($rows['titel']))."</h1>
    <table>
      <tr>
        <td>Auteur</td>
        <td>".ucfirst(strtolower($rows['autheur']))."</td>
      </tr><tr>
        <td>Beoordeling</td>
        <td>".ucfirst(strtolower($rows['rate']))."</td>
      </tr><tr>
        <td>Toelichting</td>
        <td>".ucfirst(strtolower($rows['toelichting']))."</td>
      </tr><tr>
      ");
  if ($_GET['review'] == 2){
      print("<td id='goed'><a href='includes/approve.inc.php?approve=".$rows['recensieid']."&&return=2'>Goedkeuren</a></td>");
      print ("<td id='fout'><a class='echo_link' href='includes/approve.inc.php?delete=".$rows['recensieid']."&&return=2' onclick='return verwijderAlert()'> Verwijderen </a></td>");
  }
  elseif ($_GET['review'] == 1){
      print("<td id='fout'><a href='includes/approve.inc.php?deny=".$rows['recensieid']."&&return=1'>Afkeuren</a></td>");
      print("<td id='empty'></td>");
  }
  else {
  print("<td id='goed'><a href='includes/approve.inc.php?approve=".$rows['recensieid']."&&return=0'>Goedkeuren</a></td>");
  print("<td id='fout'><a href='includes/approve.inc.php?deny=".$rows['recensieid']."&&return=0'>Afkeuren</a></td>");
  }

      print("</tr>
    </table>
  </div>
  ");
  }
}?>

</div>
</section>
</section>

<!--code om een alertbox te tonen-->
<script>
function verwijderAlert(){
  var del=confirm("Weet u zeker dat u dit bericht wilt verwijderen?");
  return del;
}
</script>

<!--voeg dit aan het object toe waar je een alert wilt hebben staan.
onclick="return verwijderAlert()" -->

<?php include ('../footer.php');
