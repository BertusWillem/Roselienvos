<?php
session_start();
session_destroy();
header("Location:".$_SERVER['HTTP_REFERER']."?message=logout");
exit();
//De bestaande sessie wordt gedestroyed en je wordt doorverwezen naar de index.php
