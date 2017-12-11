<?php
session_start();
$page = $_GET['benaming'];
include 'header.beheer.php';
$tabel = $_GET['tabel'];

//Kon geen _id achter een var plaatsen in een query. Maar dit werkt ook, vies he?
$id = $tabel.'_id';

include '../includes/dbh.php';
$stmt = $dbh->prepare("SELECT * FROM $tabel ORDER BY $id DESC");
$stmt->execute();
?>

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
      if($tabel != 'behandel'){
      if ($rows['datum'] != NULL){
        print('
        </tr><tr>
          <td>'.$rows['datum'].'</td>
        ');
      }
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

<?php include ('../footer.php');?>
