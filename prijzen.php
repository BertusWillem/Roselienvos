<?php
session_start();
$page = "Prijzen";
include 'includes/dbh.php';
include 'includes/paginalader.inc.php';
include 'header.php';
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

