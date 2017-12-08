<?php
session_start();
$page = "Inloggen";

include 'header.php';

if (isset($_SESSION['userid'])){
  header("Location: profile.php");
  exit();
}
?>
<section class="body-container">
  <section class="container">
    <div class="input-window">
      <h1>Aanmelden</h1>
<?php
if (isset($_GET['error'])){
  if ($_GET['error'] === "empty"){
    print("<p style='color:red;'>- Vul alle velden in!</p>");
    }
  if($_GET['error'] === "incorrect"){
    print("<p style='color:red;'>- De ingevulde gebruikersnaam of wachtwoord is niet correct");
    }

}
elseif(isset($_GET['message'])){
  if($_GET['message'] === "forgotmail"){
    print("<p style='color:green;'>- Er is een mail gestuurd naar het ingevulde email adres");
    }
  if ($_GET['message'] == "created"){
    print("<p style='color:green;'>- Uw account is aangemaakt, u kunt hieronder inloggen");
  }
}
?>
      <form action="includes/login.inc.php" method="POST">
        <input type="text" name="email" placeholder="Email adres">
        <input type="password" name="password" placeholder="Wachtwoord">
        <input type="submit" name="login" value="Aanmelden">
        <a href="register.php">Nog geen account? Registreer hier!</a><br>
        <a href="forgot.php">Wachtwoord vergeten?</a>
      </form>
    </div>
  </section>
</section>

<?php
include ('footer.php');
?>
