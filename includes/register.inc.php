  <?php
  session_start();
  $firstname = $_POST['reg_fn'];
  $lastname = $_POST['reg_ln'];
  $email = $_POST['reg_un'];
  $password = $_POST['reg_pw'];
  $confirm = $_POST['reg_confpw'];
  $adres = $_POST['reg_addr'];
  $postcode = $_POST['reg_pcode'];
  $woonplaats = $_POST['reg_woonpl'];
  //De variabelen zijn gedefinieerd, deze zijn doorgestuurd met POST vanuit de login.php?aanm=register

        $captcha=$_POST['g-recaptcha-response'];
        $secretKey = "6LePlD0UAAAAAMH3WciNNhYFiil6S-WpD3A2o0qk";
        $ip = $_SERVER['REMOTE_ADDR'];
        $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
        $responseKeys = json_decode($response,true);
        if(intval($responseKeys["success"]) !== 1) {
          $_SESSION['fn'] = $_POST['reg_fn'];
          $_SESSION['ln'] = $_POST['reg_ln'];
          $_SESSION['email'] = $_POST['reg_un'];
          $_SESSION['addr'] = $_POST['reg_addr'];
          $_SESSION['pcode'] = $_POST['reg_pcode'];
          $_SESSION['woonpl'] = $_POST['reg_woonpl'];
          header("Location:../register.php?error=captchaerror");
        }
  else{
  if (empty($firstname) || empty($lastname) || empty($adres) || empty($postcode) || empty($woonplaats)){
    $_SESSION['fn'] = $_POST['reg_fn'];
    $_SESSION['ln'] = $_POST['reg_ln'];
    $_SESSION['email'] = $_POST['reg_un'];
    $_SESSION['addr'] = $_POST['reg_addr'];
    $_SESSION['pcode'] = $_POST['reg_pcode'];
    $_SESSION['woonpl'] = $_POST['reg_woonpl'];
    header("Location:../register.php?error=empty");
    exit();
  }
  if (empty($email) || empty($password) || empty($confirm)){
    $_SESSION['fn'] = $_POST['reg_fn'];
    $_SESSION['ln'] = $_POST['reg_ln'];
    $_SESSION['email'] = $_POST['reg_un'];
    $_SESSION['addr'] = $_POST['reg_addr'];
    $_SESSION['pcode'] = $_POST['reg_pcode'];
    $_SESSION['woonpl'] = $_POST['reg_woonpl'];
      header("Location:../register.php?error=empty");
      exit();
  //Als er velden niet zijn ingevuld wordt de bezoeker teruggestuurd met een melding
  }

  if ($password !== $confirm){
    $_SESSION['fn'] = $_POST['reg_fn'];
    $_SESSION['ln'] = $_POST['reg_ln'];
    $_SESSION['email'] = $_POST['reg_un'];
    $_SESSION['addr'] = $_POST['reg_addr'];
    $_SESSION['pcode'] = $_POST['reg_pcode'];
    $_SESSION['woonpl'] = $_POST['reg_woonpl'];
      header("Location:../register.php?error=notmatch");
      exit();//Als de twee wachtwoorden niet overeen komen wordt er een melding teruggestuurd
  }

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['fn'] = $_POST['reg_fn'];
    $_SESSION['ln'] = $_POST['reg_ln'];
    $_SESSION['email'] = $_POST['reg_un'];
    $_SESSION['addr'] = $_POST['reg_addr'];
    $_SESSION['pcode'] = $_POST['reg_pcode'];
    $_SESSION['woonpl'] = $_POST['reg_woonpl'];
  header("Location:../register.php?error=email");
  exit();
    }

  if (strlen($password) < 8) {
    $_SESSION['fn'] = $_POST['reg_fn'];
    $_SESSION['ln'] = $_POST['reg_ln'];
    $_SESSION['email'] = $_POST['reg_un'];
    $_SESSION['addr'] = $_POST['reg_addr'];
    $_SESSION['pcode'] = $_POST['reg_pcode'];
    $_SESSION['woonpl'] = $_POST['reg_woonpl'];
    header("Location:../register.php?error=passwordstr");
    exit();
     }

  if (!preg_match("#[0-9]+#", $password)) {
    $_SESSION['fn'] = $_POST['reg_fn'];
    $_SESSION['ln'] = $_POST['reg_ln'];
    $_SESSION['email'] = $_POST['reg_un'];
    $_SESSION['addr'] = $_POST['reg_addr'];
    $_SESSION['pcode'] = $_POST['reg_pcode'];
    $_SESSION['woonpl'] = $_POST['reg_woonpl'];
  header("Location:../register=error=passwordstr");
  exit();
  }

  if (!preg_match("#[a-zA-Z]+#", $password)) {
    $_SESSION['fn'] = $_POST['reg_fn'];
    $_SESSION['ln'] = $_POST['reg_ln'];
    $_SESSION['email'] = $_POST['reg_un'];
    $_SESSION['addr'] = $_POST['reg_addr'];
    $_SESSION['pcode'] = $_POST['reg_pcode'];
    $_SESSION['woonpl'] = $_POST['reg_woonpl'];
  header("Location:../login.php?error=passwordstr");
  exit();
  }

  if (preg_match("/([%\$#\*\>\<]+)/", $firstname) || preg_match("/([%\$#\*\>\<]+)/", $lastname) || preg_match("/([%\$#\*\>\<]+)/", $adres) ||
  preg_match("/([%\$#\*\>\<]+)/", $postcode) || preg_match("/([%\$#\*\>\<]+)/", $woonplaats)){
    $_SESSION['fn'] = $_POST['reg_fn'];
    $_SESSION['ln'] = $_POST['reg_ln'];
    $_SESSION['email'] = $_POST['reg_un'];
    $_SESSION['addr'] = $_POST['reg_addr'];
    $_SESSION['pcode'] = $_POST['reg_pcode'];
    $_SESSION['woonpl'] = $_POST['reg_woonpl'];
    header("Location:../register.php?error=character");
    exit();
  }

else
  {
include 'loginsystem.func.php';
registerRequest($firstname, $lastname, $email, $password, $adres, $postcode, $woonplaats);
}
        }
