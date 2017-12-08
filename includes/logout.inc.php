<?php
session_start();
session_destroy();
header("Location: ../index.php?message=logout");
exit();
//De bestaande sessie wordt gedestroyed en je wordt doorverwezen naar de index.php
