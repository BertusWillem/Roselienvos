  <?php
  $firstname = $_POST['reg_fn'];
  $lastname = $_POST['reg_ln'];
  $email = $_POST['reg_un'];
  $password = $_POST['reg_pw'];
  $confirm = $_POST['reg_confpw'];
  $adres = $_POST['reg_addr'];
  $postcode = $_POST['reg_pcode'];
  $woonplaats = $_POST['reg_woonpl'];
  //De variabelen zijn gedefinieerd, deze zijn doorgestuurd met POST vanuit de login.php?aanm=register

  if (empty($firstname) || empty($lastname)){
    header("Location:../register.php?error=empty");
    exit();
  }
  if (empty($email) || empty($password) || empty($confirm)){
    header("Location:../register.php?error=empty");
    exit(); //Als er velden niet zijn ingevuld wordt de bezoeker teruggestuurd met een melding
  }

  if ($password !== $confirm){
      header("Location:../register.php?error=notmatch");
      exit; //Als de twee wachtwoorden niet overeen komen wordt er een melding teruggestuurd
  }

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  header("Location:../register.php?error=email");
  exit();
      }

  if (strlen($password) < 8) {
    header("Location:../register.php?error=passwordstr");
         exit();
     }

  if (!preg_match("#[0-9]+#", $password)) {
  header("Location:../register=error=passwordstr");
  exit();
  }

  if (!preg_match("#[a-zA-Z]+#", $password)) {
  header("Location:../login.php?error=passwordstr");
  exit();
  }

else
  {
include 'loginsystem.func.php';
registerRequest($firstname, $lastname, $email, $password, $adres, $postcode, $woonplaats);
}
