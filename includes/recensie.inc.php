<?php
session_start();
$title = $_POST['titel'];
$author = $_POST['autheur'];
$rate = $_POST['rate'];
$note = $_POST['toelichting'];
$date = date("Y/m/d");
include 'dbh.php';

if (empty($title) || empty($author) || empty($rate) || empty($note)){
  header("Location: ../recensies.php?message=empty");
}
else{

$stmt = $dbh->prepare("INSERT INTO recensie (titel, autheur, rate, toelichting, datum)
                       VALUES (:title, :author, :rate, :note, :date);");
$stmt->execute(array(':title' => $title, ':author' => $author,
                     ':rate' => $rate, ':note' => $note, ':date' => $date));

header ("Location: ../recensies.php?message=succes");
}