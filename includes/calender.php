<?php

if (isset($_GET["offset"])){
  $maandofset = $_GET["offset"];
}
else{
  $maandofset = 0;
}


 //zet de actuele datum in een variabele
 $date =time () ;
 //scheid de variabele in dag, maand en jaar
 $year = date('Y', $date);
 $day = date('d', $date);
 $month = date('m', $date);

print($maandofset);

 while($maandofset != 0) {
   $month = $month + 1;
   if($month == 13) {
     $year = $year + 1;
     $month = 1;
   }
   $maandofset = $maandofset - 1;
 }

 //kijkt naar de eerste dag van de maan
 $first_day = mktime(0,0,0,$month, 1, $year) ;

 //dit geeft de naam van de maand
 $title = date('F', $first_day);

 //de eerste dag van de maand
 $day_of_week = date('D', $first_day) ;


//kijkt hoeveel lege dagen er voor de eerste dag moeten
 switch($day_of_week){
     case "Sun": $blank = 0; break;
     case "Mon": $blank = 1; break;
     case "Tue": $blank = 2; break;
     case "Wed": $blank = 3; break;
     case "Thu": $blank = 4; break;
     case "Fri": $blank = 5; break;
     case "Sat": $blank = 6; break;
 }

 //kijkt hoeveel dagen er in de maand zitten

 $days_in_month = cal_days_in_month(0, $month, $year);




 //de kop van de tabel
 echo "<table border= solid;>";
 echo "<tr><th colspan=7> $title $year</th></tr>";
 echo "<tr>
 <td>Zo</td>
 <td>Ma</td>
 <td>Di</td>
 <td>Wo</td>
 <td>Do</td>
 <td>Vr</td>
 <td>Za</td>
 </tr>";

 //houd bij of er al een nieuwe week gestart moet worden
 $day_count = 1;

 echo "<tr>";
 //eerst worden de lege vakjes ingevuld
 while ( $blank > 0 )
 {
     echo "<td></td>";
     $blank = $blank-1;
     $day_count++;
 }


 $day_num = 1;


 while ( $day_num <= $days_in_month )
 {
    if($day_count == 1 || $day_count == 7){
      echo "<td id='disabled'>$day_num</td>";
      $day_num++;
      $day_count++;
    }
    else{
     echo "<td id='enabled' onclick='selectday($day_num, $month, $year)'> $day_num</td>";
     $day_num++;
     $day_count++;
   }
     //aan het einde van de week een nieuwe tablerow
     if ($day_count > 7)
     {
         echo "</tr>";
         $day_count = 1;
     }
 }




 while ( $day_count >1 && $day_count <=7 )
 {
     echo "<td> </td>";
     $day_count++;
 }

 echo "</tr></table>";



?>
