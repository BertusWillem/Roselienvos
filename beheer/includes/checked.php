<?php
include ("../../includes/dbh.php");

if($_GET["checkChecked"] == "true"){ //moet het artikel gepubliceerd worden of juist niet?

    if($_GET["tabel"] == "nieuws"){ //is het een nieuws artikel?
        $stmt = $dbh->prepare("UPDATE nieuws SET done = 1 WHERE nieuws_id = :pagina"); //publiceer het artikel via het id wat met GET is meegegeven
	$stmt->execute(array(':pagina' => $_GET["tabelid"]));
	$rows = $stmt -> fetch();
    }
    if($_GET["tabel"] == "behandeling"){ //is het een behandeling?
        $stmt = $dbh->prepare("UPDATE behandeling SET done = 1 WHERE behandeling_id = :pagina"); //publiceer de behandeling via het id wat met GET is meegegeven
	$stmt->execute(array(':pagina' => $_GET["tabelid"]));
	$rows = $stmt -> fetch();
    }


}
else{ //het artikel moet verborgen worden

    if($_GET["tabel"] == "nieuws"){
        $stmt = $dbh->prepare("UPDATE nieuws SET done = 0 WHERE nieuws_id = :pagina"); //verberg het artikel via het id wat met GET is meegegeven
	$stmt->execute(array(':pagina' => $_GET["tabelid"]));
	$rows = $stmt -> fetch();
    }
    if($_GET["tabel"] == "behandeling"){
        $stmt = $dbh->prepare("UPDATE behandeling SET done = 0 WHERE behandeling_id = :pagina"); //verberg de behandeling via het id wat met GET is meegegeven
	$stmt->execute(array(':pagina' => $_GET["tabelid"]));
	$rows = $stmt -> fetch();
    }
}
