<?php
session_start();
$page = 'bewerken';
include 'header.beheer.php';
$pagina = $_GET['pagina'];
$tabel = $_GET['tabel'];
include '../includes/paginalader.inc.php';
include '../includes/dbh.php';

if(isset($_GET["verwijderen"])) {
	if($tabel == 'nieuws'){
		$sth = $dbh->prepare("DELETE FROM nieuws WHERE nieuws_id=:pagina");
		$sth->execute(array(':pagina' => $pagina));
		header ('Location: pagina.beheer.php?benaming=nieuws&&tabel=nieuws');
	}
	elseif($tabel == 'behandel'){
		$sth = $dbh->prepare("DELETE FROM behandel WHERE behandel_id=:pagina");
		$sth->execute(array(':pagina' => $pagina));
		header ('Location: pagina.beheer.php?benaming=Behandeling&&tabel=behandel');
	}
}

if ($tabel == 'behandel'){
	$stmt = $dbh->prepare("SELECT * FROM behandel JOIN afbeeldingen ON behandel.afbeelding = afbeeldingen.afbeeldingid WHERE behandel_id = :pagina");
	$stmt->execute(array(':pagina' => $pagina));
	$rows = $stmt -> fetch();
}
elseif ($tabel == 'nieuws'){
	$stmt = $dbh->prepare("SELECT * FROM nieuws JOIN afbeeldingen ON nieuws.afbeelding = afbeeldingen.afbeeldingid WHERE nieuws_id = :pagina");
	$stmt->execute(array(':pagina' => $pagina));
	$rows = $stmt -> fetch();
}
elseif ($tabel == 'pagina'){
	$stmt = $dbh->prepare("SELECT * FROM pagina JOIN afbeeldingen ON pagina.afbeelding = afbeeldingen.afbeeldingid WHERE pagina_id = :pagina");
	$stmt->execute(array(':pagina' => $pagina));
	$rows = $stmt -> fetch();
}
?>

<section class="body-container">
  <section class="container">
	  <div class="profile">

    <!--Text-->
    <div class="left">
      <h1 style="margin-bottom: 25px;">Text</h1>
      <form id="box" action="<?php  print('includes/updatepagina.inc.php?tabel='.$tabel.'&&pagina='.$pagina)?>" method="POST">
        <input type="text" name="titel" value="<?php print($rows['titel']);?>">
        <textarea rows="20" cols="50" name="inhoud"><?php print($rows['inhoud']);?></textarea>
        <div class="input-window" id="box"><input type="submit" value="Wijzigen"></div>
		</form>


		<form>
			<div class="input-window" id="box" style="width: 100%!important; margin-bottom: 0; margin-top: 0;">
				<input type="submit" style="background-color: red!important; margin-top: 50px;" name="verwijderen" value="verwijderen">
				<input type="hidden" name="tabel" value="<?php print($tabel); ?>">
				<input type="hidden" name="pagina" value="<?php print($pagina); ?>">
			</div>
		</form>


		  </div>




	  <!--Gallery-->
    <div class="right">
      <h1 style="margin-bottom: 25px;">Afbeelding</h1>
      <section class="gallery">
        <div class="image-view-container" id="image">
          <img src="data:image/png;base64, <?php echo base64_encode($rows['afbeelding']);?>"alt="Plaatje" />
          <a href=kiesafbeelding.beheer.php?tabel=<?php print($tabel.'&&pagina='.$pagina)?> class="image-view">
            <p>Klik hier om de afbeelding te wijzigen.</p>
          </a>
        </div>
      </section>
    </div>
  </section>
</section>

<?php include ('../footer.php');?>
