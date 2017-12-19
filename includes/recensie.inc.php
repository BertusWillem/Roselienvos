<?php
session_start();
$title = $_POST['title'];
$author = $_POST['author'];
$rate = $_POST['rate'];
$note = $_POST['note'];
$date = date("Y/m/d");
include 'dbh.php';

if (empty($title) || empty($author) || empty($rate) || empty($note)){
  header("Location: ../recensie.php?message=empty");
}


$stmt = $dbh->prepare("INSERT INTO recensie (titel, autheur, rate, toelichting, datum)
                       VALUES (:title, :author, :rate, :note, :date);");
$stmt->execute(array(':title' => $title, ':author' => $author,
                     ':rate' => $rate, ':note' => $note, ':date' => $date));

header ("Location: ../recensies.php");
