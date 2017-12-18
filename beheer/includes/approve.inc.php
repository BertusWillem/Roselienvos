<?php
session_start();
if ($_SESSION['role'] !== "admin"){
  header("Location: ../../login.php");
}

$approve = $_GET['approve'];
$deny = $_GET['deny'];
$delete = $_GET['delete'];

include '../../includes/dbh.php';
if (isset($approve)){
$stmt = $dbh->prepare("UPDATE recensie SET status = 1
                       WHERE recensieid = :id;");
$stmt->execute(array(':id' => $approve));
}

elseif (isset($deny)){
$stmt = $dbh->prepare("UPDATE recensie SET status = 2
                       WHERE recensieid = :id;");
$stmt->execute(array(':id' => $deny));
}
elseif(isset($delete)){
    $stmt = $dbh->prepare("DELETE FROM recensie WHERE recensieid = :id;");
$stmt->execute(array(':id' => $delete));
}

header("Location: ".$_SERVER['HTTP_REFERER']."&&message=success");
?>
