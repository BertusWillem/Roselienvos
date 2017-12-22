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

function halfHourTimes() {
  $formatter = function ($time) {
    if ($time % 3600 == 0) {
      return date('G', $time);
    } else {
      return date('G:i', $time);
    }
    
  };
  $halfHourSteps = range(30*900, 76*900, 900);
  
  return array_map($formatter, $halfHourSteps);
  
}

var_dump(halfHourTimes());
 ?>
