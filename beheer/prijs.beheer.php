<?php
session_start();
$page = "prijsbeheer";
include 'header.beheer.php';
include "../includes/dbh.php";
echo("<section class='body-container'>
  <section class='container'>");

$sth2 = $dbh ->prepare("SELECT behandeling_id FROM behandeling");
$sth2 -> execute(array());


while($result2 = $sth2 ->fetch(PDO::FETCH_ASSOC)){ //voor elke behandeling moeten er prijzen komen

  $sth = $dbh ->prepare("SELECT titel FROM behandeling where behandeling_id = ?");
  $sth -> execute(array($result2["behandeling_id"]));
  $result = $sth ->fetch(PDO::FETCH_ASSOC);

  echo('<h1 class="prijs" id="box" Onclick="' . $result['titel'] . '()">' . $result['titel'] . '</h1>');
  echo('<script>
  function '.$result['titel'].'(){
    var x = document.getElementById("'.$result['titel'].'");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
  }
  </script>');
  echo ('<div id="'.$result['titel'].'" style="display: block;">');
  echo ("<div id='box' class='prijs'><table>");


  $sth = $dbh ->prepare("SELECT prijsnaam, prijs, omschrijving FROM prijs where behandeling_id = ?");
  $sth -> execute(array($result2["behandeling_id"]));
      echo("<form>");
      while ($result = $sth ->fetch(PDO::FETCH_ASSOC)){

          echo ("<tr><td>" . utf8_encode($result['prijsnaam']) . "</br>" .utf8_encode($result['omschrijving']) .  "</td><td><input type=text name='" . $result["prijs"] ."' value='" . $result["prijs"] ."'></td></tr>");
      }

      echo ("<tr class='nopadding'></tr><input type=submit value='opslaan' name='verstuur'></form></div></div></table>");

}

?>
  </section>
</section>
<?php include ('../footer.php');
