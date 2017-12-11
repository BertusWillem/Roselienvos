<?php
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

//Hier worden alle variablelen vanuit changeinfo.php gedefinieerd.
if (empty($email)){
  header("Location: ../login.php?error=empty");
  exit();
}

if (empty($password)){
  header("Location: ../login.php?error=empty");
  exit();
}
//Alle velden moeten ingevuld worden, als dit niet het geval is, worden Hierboven
//error messages gegenereerd
else {
  include 'loginsystem.func.php';
  loginRequest($email, $password);
}
