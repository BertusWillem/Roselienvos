<?php
$page = "Recensies";
session_start();
include 'header.php';
?>

<section class="body-container">
  <section class="container">
  <div class="recensie-container">
  <div class="recensies" id="box" style="width: 100%!important;">
    <h1 onclick="recensieOpen()">Zelf een recensie schrijven</h1>
    <div class="input-window" id="open" style="display: none;">
      <form action="includes/recensie.inc.php" method="POST">
        <input type="text" name="title" placeholder="Titel">
		 	<?php
			print('
				<input type="text" name="author"
				');
				if(!isset($_SESSION['userid'])){ 
					print('placeholder="Naam">');
				}
				else {
					print('value="'.$_SESSION['firstname'].'">');
				}
			?>
        <input type="number" name="rate" min="1" max="5" placeholder="Cijfer">
        <textarea rows="4" name="note" placeholder="Uw bericht."></textarea>
        <div class="submit"><input type="submit" value="Recensie versturen"></div>
      </form>
    </div>
  </div>

  <?php
  include 'includes/dbh.php';
  $stmt = $dbh->prepare("SELECT * FROM recensie WHERE accepted = 1 ORDER BY recensieid DESC");
  $stmt->execute();
  while ($rows = $stmt->fetch()){
    print ("
    <div class='recensies' id='box'>
      <h1>".ucfirst(strtolower($rows['title']))."</h1>
      <table>
        <tr>
          <td id='left'>Datum:</td>
          <td>".$rows['date']."</td>
        </tr>
        <tr>
          <td>Door:</td>
          <td>".ucfirst(strtolower($rows['author']))."</td>
        </tr>
        <tr>
          <td>Beoordeling:</td>
          <td style='color:#4daebd;'>");
          for($i=0; $i<$rows['rate']; $i++){
            print("&#9733");
          }
          for ($j=0; $j<5-$rows['rate']; $j++){
            print("&#9734;");
          }
          print("</td>
        </tr>
        <tr>
          <td>Toelichting:</td>
          <td>".ucfirst(strtolower($rows['note']))."</td>
        </tr>
      </table>
    </div>
    ");
  }?>

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

<?php include ('footer.php');
