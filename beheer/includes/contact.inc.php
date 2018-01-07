<?php


include '../../includes/dbh.php';

$sth = $dbh->prepare("SELECT email FROM contactgegeven"); //selecteer het oude emailadres
            $sth -> execute();

            $result = $sth->fetch(PDO::FETCH_ASSOC);
            $email=(implode($result));
function validate($data) { //Filtert de input
    $data = trim($data); //Haalt Spaties voor en achter weg uit de input
    $data = stripslashes($data); //haalt backslash weg uit de input
    $data = htmlspecialchars($data); //Convert speciale leesttekens naar HTML code
    return $data; //stuurt gefilterde input terug
   }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $newemail = validate($_POST["email"]); //filter de input om cross scripting te voorkomen
     $newtelnummer = validate($_POST["telefoonnummer"]); //filter de input om cross scripting te voorkomen
     $newadres = validate($_POST["adres"]); //filter de input om cross scripting te voorkomen

    if (!filter_var($email, FILTER_VALIDATE_EMAIL))  //controleert of het emailadres geldig opgebouwd is
            {
                print ("<script type='text/javascript'>alert('Het Emailadres is niet geldig!')</script>"); //Error popup met foutmelding geen geldig emailadres

            }
    else { //is het email geldig
        $sth = $dbh->prepare("UPDATE contactgegeven SET email=:newemail, telnummer=:telnummer, adres=:adres WHERE email=:email"); //update de oude gegevens in de database
            $sth->execute(array(':newemail' => $newemail, ':telnummer' => $newtelnummer, ':adres' => $newadres, ':email' => $email));




    }
 }

header ("Location: ../contact.beheer.php");
