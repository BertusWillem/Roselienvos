<?php

session_start();
$title = $_POST['titel'];
$author = $_POST['autheur'];
$rate = $_POST['rate'];
$note = $_POST['toelichting'];
$date = date("Y/m/d");
include 'dbh.php';
function validate($data) { //Filtert de input
  $data = trim($data); //Haalt Spaties voor en achter weg uit de input
  $data = stripslashes($data); //haalt backslash weg uit de input
  $data = htmlspecialchars($data); //Convert speciale leesttekens naar HTML code
  return $data; //stuurt gefilterde input terug
}

//De code hieronder heeft te maken met de Google captcha.
$captcha = $_POST['g-recaptcha-response'];
$secretKey = "6LePlD0UAAAAAMH3WciNNhYFiil6S-WpD3A2o0qk";
$ip = $_SERVER['REMOTE_ADDR'];
$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $captcha . "&remoteip=" . $ip);
$responseKeys = json_decode($response, true);
if (intval($responseKeys["success"]) !== 1) {
    Header("Location: ../recensies.php?message=captcha"); //is de captcha niet succesvol? dan wordt de gebruiker teruggestuurd naar de vorige pagina met een error
    $_SESSION['re_title'] = $_POST['titel'];
    $_SESSION['re_name'] = $_POST['autheur'];
    $_SESSION['re_rate'] = $_POST['rate'];
    $_SESSION['re_note'] = $_POST['toelichting'];
    //Er worden session variablelen aangemaakt zodat de velden op de recensie pagina automatisch weer ingevuld worden
}else{
  if (empty($title) || empty($author) || empty($rate) || empty($note))
      {
        header("Location: ../recensies.php?message=empty");
        $_SESSION['re_title'] = $_POST['titel'];
        $_SESSION['re_name'] = $_POST['autheur'];
        $_SESSION['re_rate'] = $_POST['rate'];
        $_SESSION['re_note'] = $_POST['toelichting'];
        //Er worden session variablelen aangemaakt zodat de velden op de recensie pagina automatisch weer ingevuld worden
      }
    //  if (preg_match("/([%\$#\*\>\<]+)/", $title) || preg_match("/([%\$#\<\>\*]+)/", $author) || preg_match("/([%\$#\<\>\*]+)/", $note))
    //  {

      //  header("Location: ../recensies.php?message=character");
  //      $_SESSION['re_title'] = $_POST['titel'];
    //    $_SESSION['re_name'] = $_POST['autheur'];
    //    $_SESSION['re_rate'] = $_POST['rate'];
    //    $_SESSION['re_note'] = $_POST['toelichting'];
        //Er worden session variablelen aangemaakt zodat de velden op de recensie pagina automatisch weer ingevuld worden

    //  } else {
    $title = validate($title);
    $author = validate($author);
    $note = validate($note);

    $stmt = $dbh->prepare("INSERT INTO recensie (titel, autheur, rate, toelichting, datum)
                           VALUES (:title, :author, :rate, :note, :date);");
    $stmt->execute(array(':title' => $title, ':author' => $author,
                          ':rate' => $rate, ':note' => $note, ':date' => $date));
    unset($_SESSION['re_title']);
    unset($_SESSION['re_name']);
    unset($_SESSION['re_rate']);
    unset($_SESSION['re_note']);
    //Alle session variabelen worden geunset zodat de form weer leeg is.
    header("Location: ../recensies.php?message=succes");
    }
