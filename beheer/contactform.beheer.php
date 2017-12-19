<?php
session_start();
$page = "Contact";
include 'header.beheer.php';
include '../includes/dbh.php';
?>

<html>
<body>
 <section class="body-container">
    <section class="container">
        <div class="input-window">
            <h1 style="background: white!important;">Terug naar contactbeheer</h1>
            <a href="contact.beheer.php">
              <div class="input-window" id="box" style="width: 100%!important; margin-bottom: 0;">
                <input type="submit" value="Naar contactbeheer">
        </div>
				<table>

				<?php
					//selecteer alle reacties met id, naam, email, inhoud en datum van de auteur
					$query = 	"SELECT id, naam, email, inhoud, datum
								FROM contactformulier
								ORDER BY datum desc";
					$result = $dbh->query($query);
					while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
						echo "<tr><td>van <a href='mailto:" . $row["email"] . "'>" . $row["naam"] . "</a></td>
							  <td>op " . $row["datum"]  . "</td></tr>\n";
						echo "<tr><td colspan='2'>" . $row["inhoud"]  . "</td></tr>\n";
						echo "<tr><td colspan='2'><a href='contactformverwijder.beheer.php?id=" . $row["id"]  . "'>
						verwijder</a></td></tr>\n";
						echo "<tr><td colspan='2'>&nbsp;</td></tr>\n";
					}
				?>
				</table>
    </section>
</section>
</body>
</html>

<?php include ('../footer.php');?>
