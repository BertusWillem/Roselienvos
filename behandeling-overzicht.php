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
      </section>
    </section>

  <?php include ('footer.php');
