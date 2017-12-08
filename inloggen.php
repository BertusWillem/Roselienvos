<?php
session_start();
print("<p>Inloggen, even geduld aub... Deel uw wachtwoord nooit met iemand!</p>");

if ($_SESSION['role'] === "admin")
{
  header("Refresh:2; url=beheer/?message=login");
}
else
{
  header("Refresh:2; url=profile.php?message=login");
}

?>
