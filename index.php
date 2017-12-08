<?php
session_start();
$page = "Over mij";
include ('includes/paginalader.inc.php');
include ('header.php');
?>
    <!--body-->
    <section class="body-container">
      <section class="container">
        <?php inhoudcall($dbh, $page); ?>
      </section>
    </section>
  <?php include ('footer.php');
