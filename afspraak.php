<?php
session_start();
$page = "Afspraak maken";
include 'header.php';
include 'includes/dbh.php';
include 'calCalender.php';
?>
<body>
    <p> <?php  ?> </p
<button onclick="offset = prevmonth(offset);   calendar(offset);">Vorige maand</button>
<button onclick="offset = nextmonth(offset);   calendar(offset);">Volgende maand</button>
<div id="calendar">

</div>
<div id="tijd">

</div>

<script language = "javascript" type = "text/javascript">
var offset = 0;


function prevmonth(offset){
if(offset != 0){
  offset = offset -1;
  return(offset);
}
else{
  offset = 0;
  return(offset);
}
}
function nextmonth(offset){

  offset = offset +1;
  return(offset);

}

calendar(offset);


function calendar(offset){

            var ajaxRequest;  //Maak een lege variabele aan voor het gebruik van ajax

            try { //check voor een goede werkende code met de browser
               // Opera 8.0+, Firefox, Safari
               ajaxRequest = new XMLHttpRequest();
            } catch (e) {

               // Internet Explorer Browsers
               try {
                  ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
               } catch (e) {

                  try {
                     ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
                  } catch (e) {
                     //niet werkende browser
                     alert("Er is iets fout gegeaan, probeer een andere browser of probeer het later opnieuw.");
                     return false;
                  }
               }
            }

            ajaxRequest.onreadystatechange = function() {

                         if(ajaxRequest.readyState == 4) {
                            var ajaxDisplay = document.getElementById('calendar');
                            ajaxDisplay.innerHTML = ajaxRequest.responseText;
                         }
                      }

          ajaxRequest.open("GET", "includes/calender.php?offset="+offset, true);
          ajaxRequest.send(null);
                   }






















function selectday(dag, maand, jaar){

            var ajaxRequest;  //Maak een lege variabele aan voor het gebruik van ajax

            try { //check voor een goede werkende code met de browser
               // Opera 8.0+, Firefox, Safari
               ajaxRequest = new XMLHttpRequest();
            } catch (e) {

               // Internet Explorer Browsers
               try {
                  ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
               } catch (e) {

                  try {
                     ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
                  } catch (e) {
                     //niet werkende browser
                     alert("Er is iets fout gegeaan, probeer een andere browser of probeer het later opnieuw.");
                     return false;
                  }
               }
            }

            ajaxRequest.onreadystatechange = function() {

                         if(ajaxRequest.readyState == 4) {
                            var ajaxDisplay = document.getElementById('tijd');
                            ajaxDisplay.innerHTML = ajaxRequest.responseText;
                         }
                      }

          ajaxRequest.open("GET", "includes/afspraak.inc.php?dag="+dag+"&&maand="+maand+"&&jaar="+jaar, true);
          ajaxRequest.send(null);
                   }





  </script>
</body>
<?php
include 'footer.php';
