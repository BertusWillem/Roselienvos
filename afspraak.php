<?php
session_start();
$page = "Afspraak maken";
include 'header.php';
include 'includes/dbh.php';





if (!isset($_GET["behandeling"]) && !isset($_GET["verstuurbehandeling"])){

    print("<form>");
    print("<div id=\"behandelingbox\">");
    
$sth = $dbh->prepare("SELECT titel FROM behandel");
            $sth -> execute();
       
            

while($result = $sth->fetch(PDO::FETCH_ASSOC)){
    
    $behandeling = implode($result);
    
    
    print("<input type=\"radio\" value=\"" . $behandeling . "\" name=\"behandeling\">" . $behandeling . " <br>");   
}         
     

    
print("</div>");
    print("<input type=\"submit\" name=\"verstuurbehandeling\" value=\"Verstuur\">");
print("</form>");

}
elseif(!isset($_GET["verstuurcontact"]) || (isset($_GET["verstuurcontact"]) && (!isset($_GET["naam"])) || !isset($_GET["email"]) || !isset($_GET["telnummer"])) || !isset($_GET["woonplaats"])){
    print("<form>");
    print("<input type=\"hidden\" name=\"behandeling\" value=\"". $_GET["behandeling"] . "\">");
    print("<input type=\"input\" name=\"naam\" placeholder=\"naam...\">");
    print("<input type=\"input\" name=\"email\" placeholder=\"email...\">");
    print("<input type=\"input\" name=\"telnummer\" placeholder=\"telefoon nummer...\">");
    print("<input type=\"input\" name=\"woonplaats\" placeholder=\"woonplaats...\">");
    print("<input type=\"submit\" name=\"verstuurcontact\" value=\"Verstuur\">");
    print("</form>");
    print($_GET["behandeling"]);   
}
else{
    print_r($_GET);
}

include 'footer.php';