<?php
session_start();
if ($_SESSION['role'] !== "admin"){
  header("Location: ../../login.php");
}

$approve = $_GET['approve'];
$deny = $_GET['deny'];

include '../../includes/dbh.php';
if (isset($approve)){
$stmt = $dbh->prepare("UPDATE recensie SET accepted = 1
                       WHERE recensieid = :id;");
$stmt->execute(array(':id' => $approve));
}

elseif (isset($deny)){
$stmt = $dbh->prepare("UPDATE recensie SET accepted = 2
                       WHERE recensieid = :id;");
$stmt->execute(array(':id' => $deny));
}

header("Location: ".$_SERVER['HTTP_REFERER']."&&message=success");
?>
