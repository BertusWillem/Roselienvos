<?php
session_start();
$page = "Kies nieuwe afbeelding";
include 'header.beheer.php';
include '../includes/dbh.php';
$stmt = $dbh->prepare("SELECT * FROM afbeeldingen;");
$stmt->execute();
while ($rows = $stmt->fetch()){
print('
<p>test</p>
<a href="includes/updatebehandelafbeelding.inc.php?behandeling='.$_GET['behandeling'].'&&afbeelding='.$rows['afbeeldingid'].'
&&page='.$_SERVER['HTTP_REFERER'].'">
<img src="data:image/png;base64,'); echo base64_encode($rows['afbeelding']); print('" alt="Nieuws bericht" />
</a>
');
}
?>
