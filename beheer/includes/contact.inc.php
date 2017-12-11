<?php


include '../../includes/dbh.php';

$sth = $dbh->prepare("SELECT email FROM contactgegevens");
            $sth -> execute();

            $result = $sth->fetch(PDO::FETCH_ASSOC);
            $email=(implode($result));


if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $newemail = $_POST["email"];
     $newtelnummer = $_POST["telefoonnummer"];
     $newadres = $_POST["adres"];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL))  //controleerd of het emailadres geldig opgebouwd is
            {
                print ("<script type='text/javascript'>alert('Het Emailadres is niet geldig!')</script>"); //Error popup met foutmelding geen geldig emailadres

            }
    else {
        $sth = $dbh->prepare("UPDATE contactgegevens SET email=:newemail, telnummer=:telnummer, adres=:adres WHERE email=:email");
            $sth->execute(array(':newemail' => $newemail, ':telnummer' => $newtelnummer, ':adres' => $newadres, ':email' => $email));




    }
 }

header ("Location: ../../contact.php");
