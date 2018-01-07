<?php
session_start();
$page = "prijsbeheer";
include 'header.beheer.php';
include "../includes/dbh.php";

if (isset($_GET["verstuur"]) || isset($_GET["newline"])){ //moeten de ingevulde gegevens worden opgeslagen?
  $sth = $dbh ->prepare("SELECT prijs_id FROM prijs"); //selecteer alle prijzen bij prijs_id
  $sth -> execute(array());
      while ($result = $sth ->fetch(PDO::FETCH_ASSOC)){ //voor elke prijs_id run de code hieronder
        print("save");

          $sth2 = $dbh ->prepare("UPDATE prijs SET prijs = :prijs WHERE prijs_id = :prijsid"); //update de prijs
          $sth2 -> execute(array(':prijs' => $_GET[$result['prijs_id']], ':prijsid' => $result['prijs_id']));
          $sth2 ->fetch(PDO::FETCH_ASSOC);
          //update statement (update prijs set prijs = $_GET[prijs_id] where prijs_id = $_GET[prijs])

          $sth2 = $dbh ->prepare("UPDATE prijs SET prijsnaam = :titel WHERE prijs_id = :prijsid"); //update de titel
          $sth2 -> execute(array(':titel' => utf8_decode($_GET['titel-'.$result["prijs_id"]]), ':prijsid' => $result['prijs_id']));
          $sth2 ->fetch(PDO::FETCH_ASSOC);
          if (isset($_GET["newline"])){ //moet je worden doorgestuurd naar nieuwe vakken toevoegen?
            header ("Location: prijs.inc.php?newline=true");
          }else{ //of moet je worden teruggestuurd
          header ("Location: prijs.beheer.php");
}
      }
    }





echo("<section class='body-container'>
  <section class='container'>");

$sth2 = $dbh ->prepare("SELECT behandeling_id FROM behandeling");
$sth2 -> execute(array());


while($result2 = $sth2 ->fetch(PDO::FETCH_ASSOC)){ //voor elke behandeling wordt de code hieronder uitgevoert

  $sth = $dbh ->prepare("SELECT titel FROM behandeling where behandeling_id = ?"); //selecteer de titel van de behandeling
  $sth -> execute(array($result2["behandeling_id"]));
  $result = $sth ->fetch(PDO::FETCH_ASSOC);

  echo('<h1 class="prijs" id="box" Onclick="' . $result['titel'] . '()">' . $result['titel'] . '</h1>'); //print een header tekst van de behandeling titel voor elke behandeling
  echo('<script>
  function '.$result['titel'].'(){
    var x = document.getElementById("'.$result['titel'].'");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
  }
  </script>'); //script wat de display veranderd wanneer er op de h1 wordt geklikt
  echo ('<div id="'.$result['titel'].'" style="display: block;">');
  echo ("<div id='box' class='prijs'><table>");


  $sth = $dbh ->prepare("SELECT prijs_id, prijsnaam, prijs, omschrijving FROM prijs where behandeling_id = ?"); // print alle bijbehordende prijzen in een tabel
  $sth -> execute(array($result2["behandeling_id"]));
      echo("<form>");
      while ($result = $sth ->fetch(PDO::FETCH_ASSOC)){

          echo ("<tr><td><input type=text name='titel-".$result["prijs_id"]."' value='".utf8_encode($result['prijsnaam'])."' </br></td><td><input style='width: 75%!important;' type=text name='" . $result["prijs_id"] ."' value='" . $result["prijs"] ."'><a style='color: White!important; margin: 5px; padding: 5px;' id='fout' href=prijs.inc.php?id=".$result["prijs_id"]."&type=verwijderen>Verwijderen</a></td></tr>");//print de prijzen in inputvelden en voegt een knop toe om te verwijderen

      }

          echo ("<tr class='nopadding'></tr></table></div></div>");



}



?>

</br>
          <div id=box>
        <input type=submit name=newline value="nieuwe regels toevoegen"></div>
      </br>
      <div id=box>
      <input type=submit name=verstuur value=opslaan></div>
    </form>
  </section>
</section>
<?php include ('../footer.php');
