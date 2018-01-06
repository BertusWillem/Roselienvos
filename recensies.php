<?php
$page = "Recensies";
session_start();
include 'header.php';
?>
<script src='https://www.google.com/recaptcha/api.js'></script>
<section class="body-container">
    <section class="container">
        <div class="recensie-container">
          <?php
          if (isset($_GET['message'])) {
              if ($_GET['message'] === "empty") {
                  print("<p style='color:red;'>- Vul alle velden in!</p>");
              }
              if ($_GET['message'] === "captcha") {
                  print("<p style='color:red;'>- De captcha is niet geldig voltooid, probeer het opnieuw.</p>");
              }
              if ($_GET['message'] === "succes") {
                  print("<p style='color:green;'>- Recensie wordt nu beoordeeld.");
              }
          }
          ?>
          <div class="recensies" id="box" style="width: 100%!important;">
              <h1 onclick="recensieOpen()">Zelf een recensie schrijven</h1>
              <div class="input-window" id="open" style="display: none;">
                  <form action="includes/recensie.inc.php" method="POST">
                    <input type="text" name="titel" <?php if (!isset($_SESSION['re_title'])){print ("placeholder='Titel'");}
                                                          else{print("value='".$_SESSION['re_title']."'");}?>>
                    <?php
                    print('
                    <input type="text" name="autheur"
                    ');
                    if (!isset($_SESSION['userid'])) {
                      if (!isset($_SESSION['re_name'])){
                        print ("placeholder='Naam'>");
                      }
                      else{
                        print("value='".$_SESSION['re_name']."'>");
                    }
                    }

                    ?>

                    <input type="number" name="rate" min="1" max="5" <?php if (!isset($_SESSION['re_rate'])){print ("placeholder='Cijfer'");}
                                                                          else{print("value='".$_SESSION['re_rate']."'");}?>>
                    <textarea rows="4" name="toelichting" <?php if (!isset($_SESSION['re_note'])){print ("placeholder='Uw bericht.'>");}
                                                                          else{print(">".$_SESSION['re_note']);}?></textarea>
                    <div class="g-recaptcha" data-sitekey="6LePlD0UAAAAABr32fFpeLtjEWkKfzXkFoUmHXhY"></div>
                    <div class="submit"><input type="submit" value="Recensie versturen"></div>
                </form>
            </div>
        </div>

<?php
include 'includes/dbh.php';
$stmt = $dbh->prepare("SELECT * FROM recensie WHERE status = 1 ORDER BY recensieid DESC");
$stmt->execute();
while ($rows = $stmt->fetch()) {
    print ("
    <div class='recensies' id='box'>
      <h1>" . ucfirst(strtolower($rows['titel'])) . "</h1>
      <table>
        <tr>
          <td id='left'>Datum:</td>
          <td>" . $rows['datum'] . "</td>
        </tr>
        <tr>
          <td>Door:</td>
          <td>" . ucfirst(strtolower($rows['autheur'])) . "</td>
        </tr>
        <tr>
          <td>Beoordeling:</td>
          <td style='color:#4daebd;'>");
    for ($i = 0; $i < $rows['rate']; $i++) {
        print("&#9733");
    }
    for ($j = 0; $j < 5 - $rows['rate']; $j++) {
        print("&#9734;");
    }
    print("</td>
        </tr>
        <tr>
          <td>Toelichting:</td>
          <td>" . ucfirst(strtolower($rows['toelichting'])) . "</td>
        </tr>
      </table>
    </div>
    ");
}
?>

        </div>
    </section>
</section>

<!--Javascript om de recensieknop te openen en te sluiten-->
<script>
    function recensieOpen() {
        var x = document.getElementById("open");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
</script>

<?php
include ('footer.php');
