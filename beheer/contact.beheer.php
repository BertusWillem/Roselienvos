<?php
session_start();
$page = "Contact";
include 'header.beheer.php';
include '../includes/dbh.php';


$sth = $dbh->prepare("SELECT email FROM contactgegevens");
            $sth -> execute();

            $result = $sth->fetch(PDO::FETCH_ASSOC);
            $email=(implode($result));

$sth = $dbh->prepare("SELECT telnummer FROM contactgegevens");
            $sth -> execute();

            $result = $sth->fetch(PDO::FETCH_ASSOC);
            $telnummer=(implode($result));

$sth = $dbh->prepare("SELECT adres FROM contactgegevens");
            $sth -> execute();

            $result = $sth->fetch(PDO::FETCH_ASSOC);
            $adres=(implode($result));
?>

 <section class="body-container">
    <section class="container">
        <div class="input-window">
            <h1 style="background: white!important;">Wijzig hier uw contactgegevens</h1>
            <form method="post" action="includes/contact.inc.php">
                <input type="text" name="email" <?php print("value='".$email."'");?>>
                <input type="text" name="telefoonnummer" <?php print("value='".$telnummer."'");?>>
                <input type="text" name="adres" <?php print("value='".$adres."'");?>>
                <input id="Verstuur" type="submit" name="Verstuur" value="Wijzigen">
            </form>
        </div>
    </section>
</section>

<?php include ('../footer.php');
