<?php
include ("../../includes/dbh.php");

if($_GET["checkChecked"] == "true"){

    if($_GET["tabel"] == "nieuws"){
        $stmt = $dbh->prepare("UPDATE nieuws SET done = 1 WHERE nieuws_id = :pagina");
	$stmt->execute(array(':pagina' => $_GET["tabelid"]));
	$rows = $stmt -> fetch();
    }
    if($_GET["tabel"] == "behandeling"){
        $stmt = $dbh->prepare("UPDATE behandeling SET done = 1 WHERE behandeling_id = :pagina");
	$stmt->execute(array(':pagina' => $_GET["tabelid"]));
	$rows = $stmt -> fetch();
    }


}
else{

    if($_GET["tabel"] == "nieuws"){
        $stmt = $dbh->prepare("UPDATE nieuws SET done = 0 WHERE nieuws_id = :pagina");
	$stmt->execute(array(':pagina' => $_GET["tabelid"]));
	$rows = $stmt -> fetch();
    }
    if($_GET["tabel"] == "behandeling"){
        $stmt = $dbh->prepare("UPDATE behandeling SET done = 0 WHERE behandeling_id = :pagina");
	$stmt->execute(array(':pagina' => $_GET["tabelid"]));
	$rows = $stmt -> fetch();
    }
}
