<!DOCTYPE html>
<?php
session_start();
$page = "Contact";
include ('header.php');
include ('includes/paginalader.inc.php');

?>
<script src='https://www.google.com/recaptcha/api.js'></script>
<body>
  <section class="body-container">
    <section class="container">
        <div class="left" id="box">
          <h1>Contact</h1>
          <section class="inner-box">
          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="text" name="naam" <?php if (!isset($_SESSION['userid'])){print ("placeholder='Naam...'");}
                                else{print("value='".$_SESSION['firstname']."'");}?>>
                                <br>
            <input type="text" name="email" <?php if (!isset($_SESSION['userid'])){print ("placeholder='Email...'");}
                                else{print("value='".$_SESSION['email']."'");}?>>
                                <br>
            <!--<select name="onderwerp" style="width: 91%">     moet 1% hoger dan de rest, weet nie waarom....
              <option value="afspraak">Afspraak</option>
              <option value="behandeling">Behandeling</option>
              <option value="prijzen">Prijzen</option>
              <option value="overige">Overige</option>
            </select> -->
            <textarea rows="4" name="inhoud" placeholder="Uw vraag..."></textarea>
            <div class="g-recaptcha" data-sitekey="6LePlD0UAAAAABr32fFpeLtjEWkKfzXkFoUmHXhY"></div>
            <input id="Verstuur" type="submit" name="Verstuur" value="Verstuur">
          </form>
          </section>
        </div>
        <?php
            $result = contactgegeven($dbh, $page);
            $emailontvanger=($result["email"]);
            $telnummer=($result["telnummer"]);
            $adres=($result["adres"]);
        ?>
      <div class="right" id="box">
        <h1>Informatie</h1>
          <table>
            <tr>
              <td>Telefoonnummer</td>
              <td><?php print($telnummer); ?></td>
            </tr>
            <tr>
              <td>Adres</td>
              <td><?php print($adres); ?></td>
            </tr>
          </table>
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d77485.55000691814!2d6.480216465074896!3d52.634262494903204!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xf829940e6037f832!2sPedicure+Roselien!5e0!3m2!1snl!2snl!4v1510756942437" width="505" height="395" frameborder="0" allowfullscreen></iframe>

      </div>


 <?php
       if ($_SERVER["REQUEST_METHOD"] == "POST") { //Is het formulier verzonden?
       $header = 'From: TeamAqua <teamaqua@noreply.com>' . "MIME-Version: 1.0" . "Content-Type: text/html;charset=utf-8"; //Maakt een header voor het email bericht waarin bepaalde dingen worden bepaald


       $naam = validate($_POST["naam"]);
       $email = validate($_POST["email"]);
       $inhoud = validate($_POST["inhoud"]);
        $captcha=$_POST['g-recaptcha-response'];
        $secretKey = "6LePlD0UAAAAAMH3WciNNhYFiil6S-WpD3A2o0qk";
        $ip = $_SERVER['REMOTE_ADDR'];
        $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
        $responseKeys = json_decode($response,true);
        if(intval($responseKeys["success"]) !== 1) {
          print ("<script type='text/javascript'>alert('De captcha is niet geldig voltooid, probeer opnieuw.')</script>"); //Error popup met foutmelding velden leeg
        } 
        else {
         
        


       if (empty($_POST["naam"]) || empty($_POST["email"]) || empty($_POST["inhoud"])) { //controleerd of er velding leeg zijn
            print ("<script type='text/javascript'>alert('Niet alle velden zijn ingevuld!')</script>"); //Error popup met foutmelding velden leeg
       }
       elseif(!isset($_POST['g-recaptcha-response'])){
           print ("<script type='text/javascript'>alert('De captcha is niet voltooid')</script>"); //Error popup met foutmelding velden leeg
       }
       
       else {


            if (!filter_var($email, FILTER_VALIDATE_EMAIL))  //controleerd of het emailadres geldig opgebouwd is
            {
                print ("<script type='text/javascript'>alert('Het Emailadres is niet geldig!')</script>"); //Error popup met foutmelding geen geldig emailadres
            }
            elseif(!preg_match("/^[a-zA-Z ]*$/",$_POST["naam"])) //controleerd of er tekens in de naam voorkomen buiten Letters en spaties om
            {
                print ("<script type='text/javascript'>alert('De naam mag alleen uit letters en spaties bestaan!')</script>"); //Error popup met foutmelding geen geldige naam
            }
            else {

                $mailcontent = ("Het contactformulier is op " . date("d/m/Y") . " Ingevuld door: " . $naam . " met de volgende vraag/opmerking: <br><br>" . $inhoud . "<br><br>U kunt " . $naam . " Bereiken op: " . $email); //maak opmaak voor email
                $mailreceiver = $emailontvanger;
                $mailsubject = "ingevuld contactformulier"; /*.$_GET["onderwerp"];*/
                include 'includes/mail.php';

                //begin bericht opslaan in de databse
                //kijk of een persoon al bestaat
                $query = "SELECT id FROM contactformulier WHERE naam = ? AND email = ? AND inhoud = ?";
                $stmt = $dbh->prepare($query);
                $stmt->execute(array( $naam, $email, $inhoud));

                if ($stmt->rowCount() > 0){
                  $row = $stmt->fetch(PDO::FETCH_ASSOC);
                  $persoon_id	= $row['id'];
                } else { //voeg de naam, e-mail, inhoud en de datum toe in de tabel contactformulier
                  $query = "INSERT INTO contactformulier(naam, email, inhoud, datum) VALUES (?, ?, ?, ?)";
                  $stmt = $dbh->prepare($query);
                  $stmt->execute(array( $naam, $email, $inhoud, date('Y-m-d H:i:s')));

                  //vraag de id van de nieuwe persoon op
                  $persoon_id = $dbh->lastInsertId();
                }
/* SQL NIEUWE TABEL AANMAKEN LOL, gewoon ff laten staan please

  CREATE TABLE `contactformulier` (
  `id` int(11) NOT NULL auto_increment,
  `naam` varchar(50) collate latin1_general_ci NOT NULL,
  `email` varchar(100) collate latin1_general_ci default NOT NULL,
  `inhoud` longtext collate latin1_general_ci default NOT NULL,
  `datum` datetime collate latin1_general_ci default NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

*/
                //eind bericht opslaan in de databse



            }

       }

       }
       }




       function validate($data) { //Filtert de input
         $data = trim($data); //Haalt Spaties voor en achter weg uit de input
         $data = stripslashes($data); //haalt backslash weg uit de input
         $data = htmlspecialchars($data); //Convert speciale leesttekens naar HTML code
         return $data; //stuurt gefilterde input terug
       }



        ?>
            </section>
         </section>
    </body>

<?php include ('footer.php');
