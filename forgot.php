<?php
session_start();
if (isset($_SESSION['userid'])){
  header("Location: profile.php?message=error");
  exit();
}
else {
$page = "Wachtwoord wijzigen";
include 'header.php';
}
if (isset($_GET['error']) && $_GET['error'] === "empty"){
  print ("<script type='text/javascript'>alert('Vul alle velden in!')</script>");
}

?>
  <section class="body-container">
    <section class="container">
      <div class="input-window">
        <h1>Wachtwoord vergeten</h1>
        <form action="includes/pwd-forgot-mail.inc.php" method="POST">
          <input type="email" name="email" placeholder="Email adres">
          <div class="submit"><input type="submit" value="Stuur mij een mail"></div>
        </form>
      </div>
    </section>
  </section>

<?php include 'footer.php'; ?>
