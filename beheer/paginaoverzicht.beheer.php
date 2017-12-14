<?php
session_start();
$page = $_GET['benaming'];
include 'header.beheer.php';
$tabel = $_GET['tabel'];

include '../includes/dbh.php';

// Bekijkt in welk tabel je zit.
if ($tabel == 'behandeling'){
  $stmt = $dbh->prepare("SELECT * FROM behandeling");
}elseif ($tabel == 'nieuws'){
  $stmt = $dbh->prepare("SELECT * FROM nieuws");
}elseif ($tabel == 'pagina'){
  $stmt = $dbh->prepare("SELECT * FROM pagina");
}
$stmt->execute();
?>

<section class="body-container">
  <section class="container">
    <div class="profile">
      <?php
      while ($rows = $stmt->fetch()){
      print('
        <h1>'.$rows['titel'].'</h1>
        <div class="mobiel" id="box" style="margin-bottom: 50px;">
          <table border=1px>
            <tr>
              <td>'.$rows['inhoud'].'</td>
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
