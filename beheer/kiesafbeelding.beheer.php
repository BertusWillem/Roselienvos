<?php
session_start();
$page = "Afbeelding";
include 'header.beheer.php';
include '../includes/dbh.php';

$stmt = $dbh->prepare("SELECT * FROM afbeelding;");
$stmt->execute();
?>

<section class="body-container">
  <section class="container">
    <div class="recensie-container">

    <?php
    while ($rows = $stmt->fetch()){
    print('
        <div class="block" style="background: white;">
          <a href="includes/updateafbeelding.inc.php?tabel='.$_GET['tabel'].'&&pagina='.$_GET['pagina'].'&&afbeelding='.$rows['afbeeldingid'].'&&page='.$_SERVER['HTTP_REFERER'].'">
          <img src="'); echo $rows['afbeelding']; print('" alt="Plaatje" />
          </a>
        </div>
    ');}
    ?>

    </div>
  </section>
</section>
