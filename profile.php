<?php
session_start();

if (!isset($_SESSION['userid'])){ //Deze pagina is alleen beschikbaar als je bent ingelogd.
  header("Location: login.php"); // Anders wordt je doorverwezen naar login.php
}

$userid = $_SESSION['userid'];
include 'includes/loginsystem.func.php';
requestProfile($userid, "fullProfile");
include 'header.php';
?>

<!--body-->
<section class="body-container">
  <section class="container">
    <div class="profile">
      <h1>Mijn account</h1>
      <div class="desktop" id="box">
      <?php
      if (isset($_GET['message'])){
        if ($_GET['message'] === "login"){
          print("<p style='color:green; text-align:center;'>- U bent succesvol ingelogd!</p>");
          }
        if ($_GET['message'] === "infoupdated"){
          print("<p style='color:green; text-align:center;'>- Uw gebruikersinformatie is bijgewerkt</p>");
          }
        if ($_GET['message'] === "pwdupdated"){
          print("<p style='color:green; text-align:center;'>- Uw wachtwoord is bijgewerkt</p>");
          }
      }
      ?>
        <table>
          <tr>
            <td>Email adres</td>
            <td><?php print($email);?></td>
          </tr>
          <tr>
            <td>Voornaam</td>
            <td><?php print($firstname);?></td>
          </tr>
          <tr>
            <td>Achternaam</td>
            <td><?php print($lastname);?></td>
          </tr>
          <tr>
            <td>Adres</td>
            <td><?php print($adres);?></td>
          </tr>
          <tr>
            <td>Postcode</td>
            <td><?php print($postcode);?></td>
          </tr>
          <tr>
            <td>Woonplaats</td>
            <td><?php print($woonplaats);?></td>
          </tr>
          <tr class="nopadding">
            <td id="button"><a href="changeinfo.php">Gegevens wijzigen</a></td>
            <td id="button"><a href="changepwd.php">Wachtwoord wijzigen</a></td>
          </tr>
        </table>
      </div>

      <div class="mobiel" id="box">
        <table>
          <tr>
            <td>Email adres</td>
          </tr><tr>
            <td><?php print($email);?></td>
          </tr>
          <tr>
            <td>Voornaam</td>
          </tr><tr>
            <td><?php print($firstname);?> </td>
          </tr>
          <tr>
            <td>Achternaam</td>
          </tr><tr>
            <td><?php print($lastname);?></td>
          </tr>
          <tr>
            <td>Adres</td>
          </tr><tr>
            <td><?php print($adres);?></td>
          </tr>
          <tr>
            <td>Postcode</td>
          </tr><tr>
            <td><?php print($postcode);?> </td>
          </tr>
          <tr>
            <td>Woonplaats</td>
          </tr><tr>
            <td><?php print($woonplaats);?></td>
          </tr>
          <tr class="nopadding">
            <td id="button"><a href="changeinfo.php">Gegevens wijzigen</a></td>
          </tr><tr class="nopadding">
            <td id="button"><a href="changepwd.php">Wachtwoord wijzigen</a></td>
          </tr>
        </table>
    </div>
  </section>
</section>

<?php include ('footer.php');
