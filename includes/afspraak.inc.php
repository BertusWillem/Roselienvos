<?php
include 'dbh.php';
$dag = $_GET["dag"];
$maand = $_GET["maand"];
$jaar = $_GET["jaar"];
$datum = $jaar . "-" . $maand . "-" . $dag;

$sth = $dbh->prepare("SELECT tijd FROM afspraak WHERE datum = ?"); //De tekst en behandeltitel voor de behandeling pagina wordt opgevraagd.
$sth -> execute(array($datum));

while ($result = $sth->fetch(PDO::FETCH_ASSOC)){

print_r($result);

}



 ?>
