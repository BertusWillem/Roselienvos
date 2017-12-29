<?php
session_start();

$page = 'bewerken';
$pagina = $_GET['pagina'];
$tabel = $_GET['tabel'];
$check = 0;

include 'header.beheer.php';
include '../includes/paginalader.inc.php';
include '../includes/dbh.php';

// Query om een bericht te verwijderen
if(isset($_GET["verwijderen"])) {
	if($tabel == 'nieuws'){
		$sth = $dbh->prepare("DELETE FROM nieuws WHERE nieuws_id = :pagina");
		$sth->execute(array(':pagina' => $pagina));
		header ('Location: pagina.beheer.php?benaming=nieuws&&tabel=nieuws');
	}
	elseif($tabel == 'behandeling'){
		$sth = $dbh->prepare("DELETE FROM behandeling WHERE behandeling_id = :pagina");
		$sth->execute(array(':pagina' => $pagina));
		header ('Location: pagina.beheer.php?benaming=Behandeling&&tabel=behandeling');
	}
	if($tabel == 'contact'){
	// Controleer of er daadwerkelijk een integer (geheel getal) binnen is gekomen
	if ( isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT )){
		$id = $_GET['id'];
	// Deze query verwijdert het door de gebruiker aangewezen bericht uit de database
		$query = "DELETE FROM contactformulier WHERE id = ? ";
		$stmt = $dbh->prepare($query);
		$stmt->execute(array($id));

	// Script dat de gebruiker automatisch weer naar de contactform.beheer.php stuurt
	header("location: contactform.beheer.php?error=1");
	} // End script om contactformulier bericht te verwijderen
	}
}

//laad de texten en afbeeldingen zien op basis van de tabel naam
if ($tabel == 'behandeling'){
	$stmt = $dbh->prepare("SELECT * FROM behandeling LEFT JOIN afbeelding ON behandeling.afbeelding = afbeelding.afbeeldingid WHERE behandeling_id = :pagina");
	$stmt->execute(array(':pagina' => $pagina));
	$rows = $stmt -> fetch(PDO::FETCH_ASSOC);
}
elseif ($tabel == 'nieuws'){
	$stmt = $dbh->prepare("SELECT * FROM nieuws LEFT JOIN afbeelding ON nieuws.afbeelding = afbeelding.afbeeldingid WHERE nieuws_id = :pagina");
	$stmt->execute(array(':pagina' => $pagina));
	$rows = $stmt -> fetch(PDO::FETCH_ASSOC);
}
elseif ($tabel == 'pagina'){
	$stmt = $dbh->prepare("SELECT * FROM pagina LEFT JOIN afbeelding ON pagina.afbeelding = afbeelding.afbeeldingid WHERE pagina_id = :pagina");
	$stmt->execute(array(':pagina' => $pagina));
	$rows = $stmt -> fetch(PDO::FETCH_ASSOC);
}
?>

<section class="body-container">
  <section class="container">
	  <div class="profile">


    <?php
		if ($check != 1){ // bekijkt of er wel afbeeldingen op de huidige bewerk pagina mogen komen.
			print('<div class="left">');
		} else {
			print('<div>');
		}

		// tekst veld
		print('
      <h1 style="margin-bottom: 25px;">Text</h1>
      <form id="box" action="includes/updatepagina.inc.php?tabel='.$tabel.'&&pagina='.$pagina.')?>" method="POST">
        <input type="text" name="titel" value="'.$rows['titel'].'">
        <textarea style="margin-bottom: 0;" rows="20" cols="50" name="inhoud">'.$rows['inhoud'].'</textarea>
        <div class="input-window" id="box"><input type="submit" value="Wijzigen"></div>
			</form>
 		</div>
		');

	  // Gallery
		if($check != 1){ // laat alleen de afbeelding optie zien als er daadwerkelijk afbeeldingen op die pagina mogen komen te staan.
			print('
	    <div class="right">
	      <h1 style="margin-bottom: 25px;">Afbeelding</h1>

				<!--Afbeelding toevoegen-->
				<form class="image-view-container" action="media.beheer.php?uitvoering=kiezen&&tabel='.$tabel.'&&pagina='.$pagina.'" method="post">
					<div class="input-window" id="box"><input type="submit" value="Afbeelding toevoegen"></div>
				</form>
				');

				// error feedback!
				if (isset($_GET['error'])){
					if ($_GET['error'] === "1"){
						print("<p style='color:red;'>- Deze afbeelding staat al op de pagina.</p>");
					}
				}

				print('<section class="gallery-beheer">'); // opend de gallery section

					// laad de plaatjes op basis van tabel naam
					if($tabel == 'pagina'){
						$sth2 = $dbh->prepare("SELECT afbeelding FROM pagina WHERE pagina_id=$pagina");
						$sth2 -> execute(array($page));
					}

					if($tabel == 'nieuws'){
						$sth2 = $dbh->prepare("SELECT afbeelding FROM nieuws WHERE nieuws_id=$pagina");
						$sth2 -> execute(array($page));
					}

					if($tabel == 'behandeling'){
						$sth2 = $dbh->prepare("SELECT afbeelding FROM behandeling WHERE behandeling_id=$pagina");
						$sth2 -> execute(array($page));
					}

					while ($result2 = $sth2 ->fetch(PDO::FETCH_ASSOC)){
						$plaatjes= ($result2['afbeelding']); // pakt de cijfers uit de database
						$afbeeldingen = explode(".", $plaatjes); // zorgt ervoor dat elk cijfer apart in een array kom te staan

						// voor elk cijfer achter de punt een plaatje tonen.
						foreach ($afbeeldingen as $afbeelding) {
							$sth = $dbh->prepare("SELECT afbeelding FROM afbeelding WHERE afbeeldingid = $afbeelding"); // selecteerd de afbeeldingen in de afbeelding tabel per cijfer
							$sth -> execute(array($page));
							$result = $sth ->fetch(PDO::FETCH_ASSOC);

							// toond de afbeelding, bestaat de afbeelding niet meer? Dan wordt dat getoond door een 'deze afbeelding bestaant niet meer' afbeelding.
							echo ('<div><img src="'); if($result['afbeelding'] != NULL){echo ($result["afbeelding"]);} else{ echo ('../image/error.jpg');} echo ('" alt="afbeelding">');

							print('
							<form class="image-view-container" action="paginabewerk.beheer.php?tabel='.$tabel.'&&pagina='.$pagina.'&&uitvoering=verwijderen&&plaatje='.$afbeelding.'" method="post">
								<div class="input-window" id="box" style="margin-bottom: 25px; width: 100%;"><input type="submit" value="Afbeelding verwijderen"></div>
							</form></div>
							');
						}
					}
					// sluit gallery section en de div right
					print('
				</section>
	    </div>');
		}

		// Geeft een verwijder optie als de tabel naam geen pagina is
		if ($tabel !== 'pagina'){

			print('
			<div class="input-window" id="box" style="width: 100%!important; max-width: 1280px!important;">
        <form>
				<input type="submit" style="background-color: red!important; margin-top: 50px" name="verwijderen" value="Bericht verwijderen">
				<input type="hidden" name="tabel" value="'.$tabel.'">
				<input type="hidden" name="pagina" value="'.$pagina.'">
        </form>
			</div>
			');
		}
		?>

  </section>
</section>

<?php include ('../footer.php');?>
