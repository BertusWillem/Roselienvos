<?php
session_start();
$page = "inloggen";

include 'header.php';

if (isset($_SESSION['userid'])){
  header("Location: profile.php");
  exit();
}
?>
<script src='https://www.google.com/recaptcha/api.js'></script>
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
    if($_GET['error'] === "captchaerror"){
    print("<p style='color:red;'>- De captcha is niet geldig voltooid, probeer het opnieuw.");
    }
}
?>
<form action="includes/register.inc.php" method="POST">
        <input type="text" name="reg_fn" <?php if (!isset($_SESSION['fn'])){print ("placeholder='Voornaam'");}
                                                else{print("value='".$_SESSION['fn']."'");}?>>
        <input type="text" name="reg_ln" <?php if (!isset($_SESSION['ln'])){print ("placeholder='Achternaam'");}
                                               else{print("value='".$_SESSION['ln']."'");}?>>
        <input type="text" name="reg_addr" <?php if (!isset($_SESSION['addr'])){print ("placeholder='Adres'");}
                                            else{print("value='".$_SESSION['addr']."'");}?>>
        <input type="text" name="reg_pcode" <?php if (!isset($_SESSION['pcode'])){print ("placeholder='Postcode'");}
                                                  else{print("value='".$_SESSION['pcode']."'");}?>>
        <input type="text" name="reg_woonpl" <?php if (!isset($_SESSION['woonpl'])){print ("placeholder='Woonplaats'");}
                                                   else{print("value='".$_SESSION['woonpl']."'");}?>>
        <input type="email" name="reg_un" <?php if (!isset($_SESSION['email'])){print ("placeholder='Email adres'");}
                                                else{print("value='".$_SESSION['email']."'");}?>>
        <input type="password" name="reg_pw" placeholder="Wachtwoord">
        <input type="password" name="reg_confpw" placeholder="Bevestig wachtwoord">
        
        <div class="g-recaptcha" data-sitekey="6LePlD0UAAAAABr32fFpeLtjEWkKfzXkFoUmHXhY"></div>
        <input type="submit" value="Aanmelden">
        <a href="login.php">Al wel een account? Inloggen!</a>
      </form>



    </div>
  </section>
</section>


<?php

include 'footer.php';
 
