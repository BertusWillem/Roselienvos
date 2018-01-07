<?php
include '../../includes/dbh.php';
$id=$_GET["id"];

if(isset($_GET["type"]) && $_GET["type"] == "verwijderen"){
  print("hi");
  $sth2 = $dbh ->prepare("DELETE FROM `prijs` WHERE prijs_id = :id");
  $sth2 -> execute(array(':id' => $id));
  $sth2 ->fetch(PDO::FETCH_ASSOC);

}
//else{
//$sth2 = $dbh ->prepare("INSERT INTO prijs (behandeling_id) VALUES (:id)");
//$sth2 -> execute(array(':id' => $id));
//$sth2 ->fetch(PDO::FETCH_ASSOC);
//}
header("Refresh:0; url=../prijs.beheer.php");
 ?>
