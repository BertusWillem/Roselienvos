<?php
$id=$_GET["id"];

$sth2 = $dbh ->prepare("INSERT INTO prijs (behandeling_id) VALUES (:id)");
$sth2 -> execute(array(':id' => $id));
$sth2 ->fetch(PDO::FETCH_ASSOC);

header("Refresh:0; url=prijs.beheer.php");
 ?>
