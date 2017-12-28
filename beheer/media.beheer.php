<?php
session_start();
$page = "Media";
include 'header.beheer.php';
include '../includes/dbh.php';
$uitvoering = $_GET['uitvoering'];

$stmt = $dbh->prepare("SELECT * FROM afbeelding;");
$stmt->execute();
$rows = $stmt->fetch();
?>

<section class="body-container">
  <section class="container">

    <?php
      // Afbeelding uploaden
      Print('
      <div class="input-window" id="box">
        <form action="includes/afbeeldingmedia.inc.php?uitvoering='.$uitvoering.'" method="post" enctype="multipart/form-data">
          <input type="file" name="fileToUpload" id="fileToUpload" style="color: black; margin-bottom: 0;">
          <input type="submit" name="submit" value="Afbeelding uploaden">
        </form>
      </div> ');

    // feedback berichten
    if (isset($_GET['error'])){
      if ($_GET['error'] === "1"){
        print("<p style='color:red;'>- Bestand is geen afbeelding.</p>");
      }
      if ($_GET['error'] === "2"){
        print("<p style='color:red;'>- Sorry, dit bestand bestaat al.</p>");
      }
      if ($_GET['error'] === "3"){
        print("<p style='color:red;'>- Sorry, dit bestand is te groot.</p>");
      }
      if ($_GET['error'] === "4"){
        print("<p style='color:red;'>- Sorry, het is niet toegestaan andere extensies te gebruiken dan: JPG, JPEG, PNG & GIF</p>");
      }
      if ($_GET['error'] === "5"){
        print("<p style='color:red;'>- Sorry, er ging iets mis.</p>");
      }
    }
    elseif(isset($_GET['bericht'])){
      if($_GET['bericht'] === "1"){
        print("<p style='color:green;'>- Afbeelding is succesvol toegevoegd.");
      }
      if($_GET['bericht'] === "2"){
        print("<p style='color:green;'>- Afbeelding is succesvol verwijderd.");
      }
    }
    ?>

    <div class="recensie-container">

    <?php
    // Geen afbeelding selecteren, laat een knop zien waarbij je geen afbeelding kunt kiezen.
    if ($uitvoering == 'kiezen'){
      $pagina = $_GET['pagina'];

      print('
      <div class="block">
      <div class="image-view-container">
        <h2>Geen afbeelding</h2>
        <a href="includes/updateafbeelding.inc.php?uitvoering=kiezen&&tabel='.$_GET['tabel'].'&&pagina='.$_GET['pagina'].'&&afbeelding=0&&page='.$_SERVER['HTTP_REFERER'].'"><div class="image-view">
          <p>KIEZEN</p>
        </div></a>
        </div>
      </div>');
    }

    // Afbeelding kiezen
    while ($uitvoering == 'kiezen' && $rows = $stmt->fetch()){
      // oude afbeeldingen bekijken
      $sth = $dbh->prepare("SELECT afbeelding FROM pagina WHERE pagina_id = :pagina");
      $sth -> execute(array(':pagina' => $_GET['pagina']));
      $result = $sth ->fetch(PDO::FETCH_ASSOC);

      print('
        <div class="block" id="imageblock">
        <div class="image-view-container">
          <img src="'.$rows['afbeelding'].'" alt="Plaatje" />
          <a href="includes/updateafbeelding.inc.php?uitvoering=kiezen&&tabel='.$_GET['tabel'].'&&pagina='.$_GET['pagina'].'&&old='.$result['afbeelding'].'&&afbeelding='.$rows['afbeeldingid'].'&&page='.$_SERVER['HTTP_REFERER'].'"><div class="image-view">
            <p>KIEZEN</p>
          </div></a>
          </div>
        </div>
    ');}

    // Afbeelding wijzigen
    while ($uitvoering == 'wijzigen' && $rows = $stmt->fetch()){
      // oude afbeeldingen bekijken
      $sth = $dbh->prepare("SELECT afbeelding FROM pagina WHERE pagina_id = :pagina");
      $sth -> execute(array(':pagina' => $_GET['pagina']));
      $result = $sth ->fetch(PDO::FETCH_ASSOC);

      print('
        <div class="block" id="imageblock">
        <div class="image-view-container">
          <img src="'.$rows['afbeelding'].'" alt="Plaatje" />
          <a href="includes/updateafbeelding.inc.php?uitvoering=kiezen&&tabel='.$_GET['tabel'].'&&pagina='.$_GET['pagina'].'&&old='.$result['afbeelding'].'&&afbeelding='.$rows['afbeeldingid'].'&&page='.$_SERVER['HTTP_REFERER'].'"><div class="image-view">
            <p>KIEZEN</p>
          </div></a>
          </div>
        </div>
    ');}

    // laad de plaatjes
    while ($uitvoering == 'beheer' && $rows = $stmt->fetch()){
    // Afbeelding verwijderen, deze optie werkt alleen in de beheer verzie
    print('
      <div class="block" id="imageblock">
      <div class="image-view-container">
        <img src="'.$rows['afbeelding'].'" alt="Plaatje" />
        <a href="includes/afbeeldingmedia.inc.php?uitvoering=verwijderen&&afbeelding='.$rows['afbeeldingid'].'"><div class="image-view">
          <p id="important">VERWIJDEREN!</p>
        </div></a>
        </div>
      </div>
    ');
    }
    ?>

    </div>
  </section>
</section>

<?php include ('../footer.php');
