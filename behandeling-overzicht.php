<?php
session_start();
$page = "Behandeling";
include ('header.php');
include ('includes/paginalader.inc.php');
?>
    <!--body-->
    <section class="body-container">
      <section class="container">
        
          <?php 
          inhoudCall($dbh, $page);
          ?>  
            
            
            
        
        <div class="right" id="box">
          <h1>Prijzen</h1>
            <table>
              <tr>
                <td>10 minuten</td>
                <td>25,-</td>
              </tr>
              <tr>
                <td>30 minuten</td>
                <td>50,-</td>
              </tr>
              <tr>
                <td>2 uur</td>
                <td>100,-</td>
              </tr>
              <tr>
                <td>afspraak niet nakomen</td>
                <td>15,-</td>
              </tr>
              <tr class="nopadding">
                <td id="button"><a href="contact.php">Contact</a></td>
                <td id="button"><a href="afspraak.php">Afspraak maken</a></td>
              </tr>
            </table>

        </div>
      </section>
    </section>

  <?php include ('footer.php');
