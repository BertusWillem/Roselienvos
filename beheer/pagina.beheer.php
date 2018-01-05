<?php
session_start();
$page = $_GET['benaming'];
include 'header.beheer.php';
$tabel = $_GET['tabel'];

include '../includes/dbh.php';

// Bekijkt in welk tabel je zit.
if ($tabel == 'behandeling'){
  $stmt = $dbh->prepare("SELECT * FROM behandeling ORDER BY behandeling_id DESC");
}elseif ($tabel == 'nieuws'){
  $stmt = $dbh->prepare("SELECT * FROM nieuws ORDER BY nieuws_id DESC");
}elseif ($tabel == 'pagina'){
  $stmt = $dbh->prepare("SELECT * FROM pagina ORDER BY pagina_id DESC");
}
$stmt->execute();
?>
<div id="test">

</div>
<section class="body-container">
  <section class="container">
    <div class="profile">
	  <?php print('<a href="includes/berichtplaatsen.inc.php?tabel='.$tabel.'&&page='.$page.'">'); ?> <div class="input-window" id="box" style="width: 100%!important; margin-bottom: 0; margin-top: 0;">
	  <input type="submit" value="Nieuw bericht plaatsen">
      </div></a>

      <?php
      while ($rows = $stmt->fetch()){
      print('
        <h1>'.$rows['titel'].'</h1>
        <div class="mobiel" id="box" style="margin-bottom: 50px;">
          <table border=1px>
            <tr>
              <td>'.$rows['inhoud'].'</td>
            ');

      // laat de datum weg als deze er niet in staat.
      if($tabel != 'behandeling'){
      if ($rows['datum'] != NULL){
        print('
        </tr><tr>
          <td>'.$rows['datum'].'
        ');
      }
      }
      if($tabel == 'nieuws'){
        if($rows["done"] == 0){
          print ' <div style="display: inline; float: right; "><label class="switch"><input type="checkbox" id="'.$rows[$tabel.'_id'].'" onclick=\'publiceren("' .$tabel.'",'. $rows[$tabel.'_id'] .')\'><span class="slider"></span></label></div></td>';
        }elseif($rows["done"] == 1){
          print ' <div style="display: inline; float: right; "><label class="switch"><input type="checkbox" id="'.$rows[$tabel.'_id'].'" onclick=\'publiceren("' .$tabel.'",'. $rows[$tabel.'_id'] .')\' checked><span class="slider"></span></label></div></td>';
        }
      }
      if($tabel == 'behandeling'){
          print ('<tr><td>');
          if($rows["done"] == 0){
            print ' <div style="display: inline; float: right; "><label class="switch"><input type="checkbox" id="'.$rows[$tabel.'_id'].'" onclick=\'publiceren("' .$tabel.'",'. $rows[$tabel.'_id'] .')\'><span class="slider"></span></label></div></td>';
          }elseif($rows["done"] == 1){
            print ' <div style="display: inline; float: right; "><label class="switch"><input type="checkbox" id="'.$rows[$tabel.'_id'].'" onclick=\'publiceren("' .$tabel.'",'. $rows[$tabel.'_id'] .')\' checked><span class="slider"></span></label></div></td>';
          }
          print('</td></tr>');
      }

      print('
            </tr><tr class="nopadding">
              <td id="button"><a href="paginabewerk.beheer.php?tabel='.$tabel.'&&pagina='.$rows[$tabel.'_id'].'">Bewerken</td>
            </tr>
          </table>
        </div>
      ');
      }
      ?>

    </div>
  </section>
</section>
<script>
    function publiceren(tabel, tabelid){

        var checkChecked = document.getElementById(tabelid).checked;
        var ajaxRequest;  //Maak een lege variabele aan voor het gebruik van ajax

            try { //check voor een goede werkende code met de browser
               // Opera 8.0+, Firefox, Safari
               ajaxRequest = new XMLHttpRequest();
            } catch (e) {

               // Internet Explorer Browsers
               try {
                  ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
               } catch (e) {

                  try {
                     ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
                  } catch (e) {
                     //niet werkende browser
                     alert("Er is iets fout gegeaan, probeer een andere browser of probeer het later opnieuw.");
                     return false;
                  }
               }
            }
            ajaxRequest.onreadystatechange = function() {

                         if(ajaxRequest.readyState == 4) {
                            var ajaxDisplay = document.getElementById('test');
                            ajaxDisplay.innerHTML = ajaxRequest.responseText;
                         }
                      }
          console.log("GET", "includes/checked.php?checkChecked=" + checkChecked + "&&tabel="+tabel+"&&tabelid="+tabelid)
          ajaxRequest.open("GET", "includes/checked.php?checkChecked=" + checkChecked + "&&tabel="+tabel+"&&tabelid="+tabelid);
          ajaxRequest.send(null);
                   }

</script>

<?php include ('../footer.php');?>
