<?php

session_start();
$title = $_POST['titel'];
$author = $_POST['autheur'];
$rate = $_POST['rate'];
$note = $_POST['toelichting'];
$date = date("Y/m/d");
include 'dbh.php';
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
} else {
    if (empty($title) || empty($author) || empty($rate) || empty($note)) {
        header("Location: ../recensies.php?message=empty");
        $_SESSION['re_title'] = $_POST['titel'];
        $_SESSION['re_name'] = $_POST['autheur'];
        $_SESSION['re_rate'] = $_POST['rate'];
        $_SESSION['re_note'] = $_POST['toelichting'];
    } else {

        $stmt = $dbh->prepare("INSERT INTO recensie (titel, autheur, rate, toelichting, datum)
                       VALUES (:title, :author, :rate, :note, :date);");
        $stmt->execute(array(':title' => $title, ':author' => $author,
            ':rate' => $rate, ':note' => $note, ':date' => $date));

        header("Location: ../recensies.php?message=succes");
    }
}
