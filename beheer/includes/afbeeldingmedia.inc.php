<?php
$uitvoering = $_GET['uitvoering'];

// verwijderen van een afbeelding
if ($uitvoering == 'verwijderen'){
  include '../../includes/dbh.php';
  $afbeelding = $_GET['afbeelding'];

  // voert de query uit om het afbeeldingspad te selecteren
  $del = $dbh->prepare("SELECT afbeelding FROM afbeeldingen WHERE afbeeldingid = :afbeelding");
  $del->execute(array(':afbeelding' => $afbeelding));
  $rows = $del->fetch();

  // geeft het pad op waar de afbeelding staat
  $bestand = ('../'.$rows['afbeelding']);

  // verwijderd de afbeelding in de map
  unlink($bestand);

  // verwijderd het afbeeldingspad uit de database
  $sth = $dbh->prepare("DELETE FROM afbeeldingen WHERE afbeeldingid = :afbeelding");
  $sth->execute(array(':afbeelding' => $afbeelding));

  // verwijst je terug naar de media pagina
  header ("Location: ../media.beheer.php?uitvoering=beheer");
}

// plaatsen van een afbeelding
else {
  include '../../includes/dbh.php';

  $target_dir = "../../uploads/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

  $upl = $dbh->prepare("INSERT INTO afbeeldingen (afbeelding) VALUE (:bestand)");

  // Controleerd of het bestand wel echt een afbeelding is
  if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
      echo "Bestand is een afbeelding - " . $check["mime"] . ".";
      $uploadOk = 1;
    } else {
      echo "Bestand is geen afbeelding.";
      $uploadOk = 0;
    }
  }

  // Controleerd of het bestand al bestaat.
  if (file_exists($target_file)) {
    echo "Sorry, dit bestand bestaat al.";
    $uploadOk = 0;
  }

  // Controleerd de grote van het bestand.
  if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, dit bestand is te groot.";
    $uploadOk = 0;
  }

  // Controleerd het bestandstype.
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ){
    echo "Sorry, het is niet toegestaan andere extensies te gebruiken dan: JPG, JPEG, PNG & GIF";
    $uploadOk = 0;
  }

  // Controleren of $uploadOk naar 0 is gezet door een error.
  if ($uploadOk == 0) {
    echo "Sorry, er ging iets mis.";

  // als alles correct is proberen het bestand te uploaden.
  } else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      echo "Het bestand ". basename( $_FILES["fileToUpload"]["name"]). " is geupload.";

      // upload de afbeelding locatie in de database
      $upl -> execute(array(':bestand' => '../uploads/'.basename($_FILES["fileToUpload"]["name"])));
    } else {
      echo "Sorry, er ging iets mis.";
    }
  }

  // verwijst je terug naar de media pagina
  header ("Location: ../media.beheer.php?uitvoering=beheer");
}
