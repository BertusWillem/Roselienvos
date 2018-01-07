<?php
include 'dbh.php';
$dag = $_GET["dag"];
$maand = $_GET["maand"];
$jaar = $_GET["jaar"];
$datum = $jaar . "-" . $maand . "-" . $dag;

$sth = $dbh->prepare("SELECT tijd FROM afspraak WHERE datum = ?"); //De tekst en behandeltitel voor de behandeling pagina wordt opgevraagd.
$sth -> execute(array($datum));

$result = $sth->fetch(PDO::FETCH_ASSOC);

    



function tijdprint() {
  $opmaak = function ($time) {
    if ($time % 3600 == 0) {
      return date('G', $time);
    } else {
      return date('G:i', $time);
    }

  };
  $timeprint = range(30*900, 76*900, 900);

  return array_map($opmaak, $timeprint);

}

$tijden = tijdprint();
$count = 0;


foreach ($tijden as $index => $tijd) {
if (strlen($tijd) == 1 || strlen($tijd) == 2){
  $tijd = $tijd.":00:00";
}
else {
  $tijd = $tijd.":00";
}


if(is_array($result) && (in_array($tijd, $result) || $count != 0)){
  $count++;
  if ($count == 3){
    $count = 0;
  }
}
  else{
    print($tijd . "</br>");
  }
}

 ?>
