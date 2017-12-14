<?php
include ("dbh.php");


        function inhoudCall(PDO $dbh, $page){
            if ($page == "Over mij"){
                $sth = $dbh->prepare("SELECT inhoud FROM pagina WHERE titel = ?");
                $sth -> execute(array($page));

                $result = $sth->fetch(PDO::FETCH_ASSOC);
                if($result['inhoud'] != NULL){
                    $var = $result['inhoud'];
                    $alinea = nl2br($var);
                    $alinea = str_replace("<br />", "</p><p>", $alinea);
                    $alinea = "<p>" . $alinea . "</p>";
                    $alinea = utf8_encode($alinea);
                    echo ("<div class=\"left\"><h1>Over mij</h1>$alinea</div>");
                } else {
                    echo "Geen inhoud beschikbaar";
                }
                $sth2 = $dbh->prepare("SELECT a.afbeelding FROM afbeelding a JOIN pagina p ON a.afbeeldingid = p.afbeelding WHERE titel = ?");
                $sth2 -> execute(array($page));
                while ($result2 = $sth2 ->fetch(PDO::FETCH_ASSOC)){
                    echo ('<div class="right"><h1>Foto\'s</h1><section class="gallery"><div><img src="data:image/jpg;base64, ' . base64_encode($result2['afbeelding']) . '" alt="' . $result2['naam'] . '"></div></section></div>');
                }
            }elseif ($page == "Behandeling"){
                if(!isset($_GET["behandeling"])){ //is er een Behandel_ID meegegeven
                     header ("Location: behandeling.php");//Zo niet, ga terug naar de vorige pagina
                }
                else {//zo wel, voer een sql statement uit die de behandel info van de betreffende bandeling uit de DB haalt aan de hand van een behandel_ID
                    $sth = $dbh->prepare("select titel, inhoud FROM behandeling WHERE behandeling_id = ?");
                    $sth -> execute(array($_GET["behandeling"]));

                    $result = $sth->fetch(PDO::FETCH_ASSOC);
                    if($result['inhoud'] != NULL){
                    $var = $result['inhoud'];
                    $alinea = nl2br($var);
                    $alinea = str_replace("<br />", "</p><p>", $alinea);
                    $alinea = "<p>" . $alinea . "</p>";
                    $alinea = utf8_encode($alinea);
                    echo ("<div class=\"left\"><h1>".$result['titel']."</h1>$alinea</div>");
                } else {
                    echo "Geen inhoud beschikbaar";
                }

                    $sth = $dbh ->prepare("select prijsnaam, prijs, omschrijving FROM prijs WHERE behandeling_id = ? ");
                    $sth -> execute(array($_GET["behandeling"]));
                    echo ("<div class='right' id='box'><h1>Prijzen</h1><table>");
                    while ($result = $sth ->fetch(PDO::FETCH_ASSOC)){
                        echo ("<tr><td>" . $result['prijsnaam'] . "</br>" .$result['omschrijving'] .  "</td><td> " . $result["prijs"] . "</td></tr>");
                    }
                    echo ("<tr class='nopadding'>
                    <td id='button'><a href='contact.php'>Contact</a></td>
                    <td id='button'><a href='afspraak.php'>Afspraak maken</a></td>
                    </tr></table></div>");

                }





            }
            elseif ($page == "Prijzen") {

                $sth2 = $dbh ->prepare("SELECT behandeling_id FROM behandeling");
                $sth2 -> execute(array());
                while($result2 = $sth2 ->fetch(PDO::FETCH_ASSOC)){




                $sth = $dbh ->prepare("SELECT titel FROM behandeling where behandeling_id = ?");
                $sth -> execute(array($result2["behandeling_id"]));
                $result = $sth ->fetch(PDO::FETCH_ASSOC);
                echo ("<div class='left' id='box'><h1>" . $result["titel"] . "</h1><table>");


                $sth = $dbh ->prepare("SELECT prijsnaam, prijs, omschrijving FROM prijs where behandeling_id = ?");
                    $sth -> execute(array($result2["behandeling_id"]));
                    while ($result = $sth ->fetch(PDO::FETCH_ASSOC)){


                        echo ("<tr><td>" . $result['prijsnaam'] . "</br>" .$result['omschrijving'] .  "</td><td> " . $result["prijs"] . "</td></tr>");
                    }
                    echo ("<tr class='nopadding'>
                    <td id='button'><a href='contact.php'>Contact</a></td>
                    <td id='button'><a href='afspraak.php'>Afspraak maken</a></td>
                    </tr></table></div>");
            }
            }
            elseif ($page == "Contact"){
              $sth = $dbh->prepare("SELECT email FROM contactgegeven");
                          $sth -> execute();

                          $result = $sth->fetch(PDO::FETCH_ASSOC);
                          $emailontvanger=(implode($result));

              $sth = $dbh->prepare("SELECT telnummer FROM contactgegeven");
                          $sth -> execute();

                          $result = $sth->fetch(PDO::FETCH_ASSOC);
                          $telnummer=(implode($result));

              $sth = $dbh->prepare("SELECT adres FROM contactgegeven");
                          $sth -> execute();

                          $result = $sth->fetch(PDO::FETCH_ASSOC);
                          $adres=(implode($result));
            }


            elseif ($page == "Behandelingen"){
                $sth = $dbh->prepare("SELECT titel, inhoud FROM pagina WHERE titel = ?");
                $sth -> execute(array($page));
                while($result = $sth->fetch(PDO::FETCH_ASSOC)){
                    echo ("<h1>" . $result["titel"] . "</h1> <p>" . $result["inhoud"] . "</p>");
                }

                $sth = $dbh->prepare("SELECT titel, inhoud, behandeling_id, a.afbeelding FROM behandeling b JOIN afbeelding a ON a.afbeeldingid = b.afbeelding");

                $sth -> execute(array($page));
                while($result = $sth->fetch(PDO::FETCH_ASSOC)){
                    echo ("<div class='behandeling'><div class='behandeling-text'><h1>" . $result['titel'] ."</h1><img src='data:image/jpg;base64, " . base64_encode($result['afbeelding']) . "'alt='" . $result["naam"] . "'><p>".$result['inhoud']."</p><a href='behandeling-overzicht.php?behandeling=" .$result['behandeling_id'] ."'>Lees meer</a></div></div>");
                }
            }




            elseif ($page == "Behandelingen-beheer"){
                $sth = $dbh->prepare("SELECT titel, behandeling_id, korte_omschrijving, a.afbeelding, a.naam FROM behandeling b JOIN afbeelding a ON a.afbeeldingid = b.afbeelding");

                $sth -> execute(array($page));
                while($result = $sth->fetch(PDO::FETCH_ASSOC)){
                    echo ("<div class='behandeling'><div style='background-color: White!important;' class='behandeling-text'><h1>" . $result['titel'] ."</h1><img src='data:image/jpg;base64, " . base64_encode($result['afbeelding']) . "'alt='" . $result["naam"] . "'><p>".$result['korte_omschrijving']."</p><a href='behandeling-aanpassen.php?behandeling=" .$result['behandeling_id'] ."'>Aanpassen --></a></div></div>");

                }





                }



                elseif ($page == "Nieuws-item"){
                $stmt = $dbh->prepare("SELECT * FROM nieuws n JOIN afbeelding a ON n.afbeelding=a.afbeeldingid WHERE nieuws_id = :nieuwsitem");
                $stmt->execute(array(':nieuwsitem' => $_GET['nieuwsitem']));
                while ($rows = $stmt->fetch()){
                print('<div class="left"><h1>'.$rows['titel'].'</h1><p>'.$rows['inhoud'].'</p></div><div class="right"><h1>Afbeelding</h1><section class="gallery"><div><img src="data:image/png;base64,'); echo base64_encode($rows['afbeelding']); print('" alt="Nieuws bericht" /></div></section>');
                }
            }

            elseif ($page == "Nieuws"){
                $sth = $dbh->prepare("SELECT titel, inhoud FROM pagina WHERE titel = ?");
                $sth -> execute(array($page));
                while($result = $sth->fetch(PDO::FETCH_ASSOC)){
                    echo ("<h1>" . $result["titel"] . "</h1> <p>" . $result["inhoud"] . "</p>");
                }


                $stmt = $dbh->prepare("SELECT * FROM nieuws n JOIN afbeelding a ON n.afbeelding=a.afbeeldingid WHERE n.done = 1");
                $stmt->execute();
                while ($rows = $stmt->fetch()){
                print('<div class="behandeling"><div class="behandeling-text"><h1>'.$rows['titel']. '</h1><img src="data:image/png;base64,'); echo base64_encode($rows['afbeelding']); print('" alt="Nieuws bericht" /><p>'.$rows['inhoud'].'</p><p class="datum">'.$rows['datum'].'</p><a href="nieuws-overzicht.php?nieuwsitem='.$rows['nieuws_id'].'">Lees meer ></a></div></div>');
                }
            }



            elseif ($page == "Recensies"){
                $stmt = $dbh->prepare("SELECT * FROM recensie WHERE accepted = 1 ORDER BY recensieid DESC");
                $stmt->execute();
                while ($rows = $stmt->fetch()){
                    print ("<div class='recensies' id='box'><h1>".ucfirst(strtolower($rows['title']))."</h1><table><tr><td id='left'>Datum:</td><td>".$rows['date']."</td></tr><tr><td>Door:</td><td>".ucfirst(strtolower($rows['author']))."</td></tr><tr><td>Beoordeling:</td><td style='color:#4daebd;'>");
                        for($i=0; $i<$rows['rate']; $i++){
                          print("&#9733");
                        }
                        for ($j=0; $j<5-$rows['rate']; $j++){
                          print("&#9734;");
                        }
                        print("</td></tr><tr><td>Toelichting:</td><td>".ucfirst(strtolower($rows['note']))."</td></tr></table></div>");
            }
        }
        }

?>
