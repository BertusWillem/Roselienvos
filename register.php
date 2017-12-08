<?php
session_start();
$page = "inloggen";

include 'header.php';

if (isset($_SESSION['userid'])){
  header("Location: profile.php");
  exit();
}
?>

<section class="body-container">
  <section class="container">
    <div class="input-window">
      <h1>Registreren</h1 >
<?php
  if (isset($_GET['error'])){
    if ($_GET['error'] === "empty"){
    print("<p style='color:red;'>- Vul alle velden in!</p>");
    }
    if ($_GET['error'] === "email"){
    print("<p style='color:red;'>- Het ingevulde email lijkt geen email te zijn.</p>");
    }
    if($_GET['error'] === "notmatch"){
    print("<p style='color:red;'>- De ingevulde wachtwoorden komen niet overeen!");
    }
    if($_GET['error'] === "passwordstr"){
    print("<p style='color:red;'>- Het wachtwoord is niet strek genoeg.   Het wachtwoord moet voldoen aan:<br>
    - Minimaal 8 letters<br>
    - Minimaal 1 teken<br>");
    }
    if($_GET['error'] === "known"){
    print("<p style='color:red;'>- Dit email adres is al bij ons bekend");
    }
}
?>
      <form action="includes/register.inc.php" method="POST">
        <input type="text" name="reg_fn" placeholder="Voornaam">
        <input type="text" name="reg_ln" placeholder="Achternaam">
        <input type="text" name="reg_addr" placeholder="Adres">
        <input type="text" name="reg_pcode" placeholder="Postcode">
        <input type="text" name="reg_woonpl" placeholder="Woonplaats">
        <input type="email" name="reg_un" placeholder="Email adres">
        <input type="password" name="reg_pw" placeholder="Wachtwoord">
        <input type="password" name="reg_confpw" placeholder="Bevestig wachtwoord">
        <input type="submit" value="Aanmelden">
        <a href="login.php">Al wel een account? Inloggen!</a>
      </form>
    </div>
  </section>
</section>

<?php
include 'footer.php';
 ?>
