<?php
        include ("dbh.php");

        function alinea($result){
            $var = $result['inhoud'];
            $alinea = nl2br($var);                                              // wordt de tekst voorzien van <br>'s
            $alinea = str_replace("<br />", "</p><p>", $alinea);                // de <br>'s worden vervangen door <p>'s zodat er bij enters in de tekst een nieuwe alinea wordt gevormd.
            $alinea = "<p>" . $alinea . "</p>";
            return $alinea;

            }

            function inhoudCall(PDO $dbh, $page){
            if ($page == "Over mij"){
                $sth = $dbh->prepare("SELECT inhoud FROM pagina WHERE titel = ?");      //De tekst voor de Over mij pagina wordt opgevraagd. De tekst staat in tabel pagina met de column inhoud.
                $sth -> execute(array($page));

                $result = $sth->fetch(PDO::FETCH_ASSOC);
                if($result['inhoud'] != NULL){                                          // Als de inhoud niet leeg is en er een tekst opgehaald kan worden
//                    $var = $result['inhoud'];
//                    $alinea = nl2br($var);                                              // wordt de tekst voorzien van <br>'s
//                    $alinea = str_replace("<br />", "</p><p>", $alinea);                // de <br>'s worden vervangen door <p>'s zodat er bij enters in de tekst een nieuwe alinea wordt gevormd.
//                    $alinea = "<p>" . $alinea . "</p>";
                    $alinea = alinea($result);
                    echo ("<div class=\"left\"><h1>Over mij</h1>$alinea</div>");        // Een koptitel + de inhoud word ge-echoed en in een <div> geplaatst.
                }
                else {
                    echo ("Geen inhoud beschikbaar");                                     // Als er geen inhoud beschikbaar is wordt de foutmelding ge-echoed.
                }

                // Het standaard principe hoe de afbeeldingen worden geladen
                // $plaatjes= ('12.6.8.11');
                // $afbeeldingen = explode(".", $plaatjes);
                //
                // foreach ($afbeeldingen as $afbeelding) {
                //   print("<li>$afbeelding</li>");
                // }

                $sth2 = $dbh->prepare("SELECT afbeelding FROM pagina WHERE titel = ?"); //de afbeelding wordt uit de datbase opgevraagd, voor de pagina Over Mij
                $sth2 -> execute(array($page));
                while ($result2 = $sth2 ->fetch(PDO::FETCH_ASSOC)){
                  echo ('<div class="right"><section class="gallery">');
                  $plaatjes= ($result2['afbeelding']); // pakt de cijfers uit de database
                  $afbeeldingen = explode(".", $plaatjes); // zorgt ervoor dat elk cijfer apart in een array kom te staan

                  // voor elk cijfer achter de comma een plaatje tonen.
                  foreach ($afbeeldingen as $afbeelding) {
                    $sth = $dbh->prepare("SELECT afbeelding FROM afbeelding WHERE afbeeldingid = $afbeelding"); // selecteerd de afbeeldingen in de afbeelding tabel per cijfer
                    $sth -> execute(array($page));
                    $result = $sth ->fetch(PDO::FETCH_ASSOC);
                    if($result['afbeelding'] != NULL){ // toond de afbeelding, bestaat de afbeelding niet meer? Dan wordt dat getoond door een 'deze afbeelding bestaant niet meer' afbeelding.
                      echo ('<div style="margin-bottom: 10px;"><img src="'.substr($result['afbeelding'], 3).'"> alt="afbeelding"></div>'); // laat de afbeelding zien per result
                    } else{
                      echo ('<div style="margin-bottom: 10px;"><img src="../image/error.jpg" alt="afbeelding"></div>');
                    }
                  }
                  echo ('</section></div>'); // sluit de image gallery
                }
            }

            elseif ($page == "Behandeling"){
                if(!isset($_GET["behandeling"])){ //is er een Behandel_ID meegegeven
                     header ("Location: behandeling.php");//Zo niet, ga terug naar de vorige pagina
                }
                else {//zo wel, voer een sql statement uit die de behandel info van de betreffende bandeling uit de DB haalt aan de hand van een behandel_ID
                    $sth = $dbh->prepare("SELECT titel, inhoud FROM behandeling WHERE behandeling_id = ?"); //De tekst en behandeltitel voor de behandeling pagina wordt opgevraagd.
                    $sth -> execute(array($_GET["behandeling"]));

                    $result = $sth->fetch(PDO::FETCH_ASSOC);
                    if($result['inhoud'] != NULL){                                                         // Als de inhoud niet leeg is en er een tekst opgehaald kan worden
                    $alinea = alinea($result);                                                        // Speciale tekens worden overgezet naar UTF-8.
                    echo ("<div class=\"left\"><h1>".$result['titel']."</h1>$alinea</div>");
                }
                else {
                    echo "Geen inhoud beschikbaar";                                                         // Als er geen inhoud beschikbaar is komt deze foutmelding.
                }
										// div left eindigen na de while en beginnen met de div right voor afspraken maken.
										$sth = $dbh->prepare("SELECT titel, inhoud, pagina_id FROM pagina WHERE pagina_id = 5");
										$sth -> execute(array($page));

										while($result = $sth->fetch(PDO::FETCH_ASSOC)){
											echo ("<div class='right' id='afspraak'><h1>".$result['titel']."</h1> <table><tr><td><p>".$result['inhoud']."</p></td></tr> <tr><td><a href='afspraak.php'>Klik hier om een afspraak te maken</a></td></tr></table></div>");
										}

                    $sth = $dbh ->prepare("SELECT prijsnaam, prijs, omschrijving FROM prijs WHERE behandeling_id = ? ");    // De prijstabel inhoud word opgehaald.
                    $sth -> execute(array($_GET["behandeling"]));
                    echo ("<div class='right' id='box'><h1>Prijzen</h1><table>");                                           // Prijstabel word gevormd.
                    while ($result = $sth ->fetch(PDO::FETCH_ASSOC)){
                        echo ("<tr><td>" . utf8_encode($result['prijsnaam']) . "</br>" .utf8_encode($result['omschrijving']) .  "</td><td> " . $result["prijs"] . "</td></tr>");      // Prijstabel word ingevuld
                    }
                    echo ("<tr class='nopadding'></tr></table></div>");                                                                                  // Prijstabel word gesloten + een link naar contact / afspraak maken.
                }
            }
              elseif ($page == "Prijzen") {
                // hier wordt de behandel beschrijving geplaatst.
                $sth = $dbh->prepare("SELECT titel, inhoud FROM pagina WHERE titel = ?");
                $sth -> execute(array($page));

                while($result = $sth->fetch(PDO::FETCH_ASSOC)){
                    echo ("<div class='left'><h1>" . $result["titel"] . "</h1> <p>" . $result["inhoud"] . "</p></div>");
                }

                // div left eindigen na de while en beginnen met de div right voor afspraken maken.
                $sth = $dbh->prepare("SELECT titel, inhoud, pagina_id FROM pagina WHERE pagina_id = 5");
                $sth -> execute(array($page));

                while($result = $sth->fetch(PDO::FETCH_ASSOC)){
                  echo ("<div class='right' id='afspraak'><h1>".$result['titel']."</h1> <table><tr><td><p>".$result['inhoud']."</p></td></tr> <tr><td><a href='afspraak.php'>Klik hier om een afspraak te maken</a></td></tr></table></div>");
                }

                $sth2 = $dbh ->prepare("SELECT behandeling_id FROM behandeling");
                $sth2 -> execute(array());
                while($result2 = $sth2 ->fetch(PDO::FETCH_ASSOC)){

                $sth = $dbh ->prepare("SELECT titel FROM behandeling where behandeling_id = ?");
                $sth -> execute(array($result2["behandeling_id"]));
                $result = $sth ->fetch(PDO::FETCH_ASSOC);
                echo ("<div class='prijs' id='box'><h1>" . $result["titel"] . "</h1><table>");

                $sth = $dbh ->prepare("SELECT prijsnaam, prijs, omschrijving FROM prijs where behandeling_id = ?");
                    $sth -> execute(array($result2["behandeling_id"]));
                    while ($result = $sth ->fetch(PDO::FETCH_ASSOC)){
                        echo ("<tr><td>" . utf8_encode($result['prijsnaam']) . "</br>" .utf8_encode($result['omschrijving']) .  "</td><td> " . $result["prijs"] . "</td></tr>");
                    }
                    echo ("<tr class='nopadding'></tr></table></div>");
            }
            }
						elseif ($page == "Behandelingen"){
								// div left openen voor de while.
								echo ("<div class='left'>");

								// hier wordt de behandel beschrijving geplaatst.
                $sth = $dbh->prepare("SELECT titel, inhoud FROM pagina WHERE titel = ?");
                $sth -> execute(array($page));

                while($result = $sth->fetch(PDO::FETCH_ASSOC)){
                    echo ("<h1>" . $result["titel"] . "</h1> <p>" . $result["inhoud"] . "</p></div>");
                }

								// div left eindigen na de while en beginnen met de div right voor afspraken maken.
								$sth = $dbh->prepare("SELECT titel, inhoud, pagina_id FROM pagina WHERE pagina_id = 5");
								$sth -> execute(array($page));

								while($result = $sth->fetch(PDO::FETCH_ASSOC)){
									echo ("<div class='right' id='afspraak'><h1>".$result['titel']."</h1> <table><tr><td><p>".$result['inhoud']."</p></td></tr> <tr><td><a href='afspraak.php'>Klik hier om een afspraak te maken</a></td></tr></table></div>");
								}

								// hier worden de behandelingen geladen.
                $sth = $dbh->prepare("SELECT titel, inhoud, behandeling_id, a.afbeelding FROM behandeling b LEFT JOIN afbeelding a ON a.afbeeldingid = b.afbeelding");
                $sth -> execute(array($page));

                while($result = $sth->fetch(PDO::FETCH_ASSOC)){
                    echo ("<div class='behandeling'><div class='behandeling-text'><h1>" . $result['titel'] ."</h1>"); if($result['afbeelding'] != NULL){ print('<img src="'.substr($result['afbeelding'], 3).'" alt="Nieuws item">');} echo("<p>".$result['inhoud']."</p><a href='behandeling-overzicht.php?behandeling=" .$result['behandeling_id'] ."'>Lees meer</a></div></div>");
                }                                                                                                  // een if statement of er wel een plaatje is. // substr 3 vanwegen de ../ in de database
            }
            elseif ($page == "Behandelingen-beheer"){
                $sth = $dbh->prepare("SELECT titel, behandeling_id, korte_omschrijving, a.afbeelding, a.naam FROM behandeling b LEFT JOIN afbeelding a ON a.afbeeldingid = b.afbeelding");
                $sth -> execute(array($page));
                while($result = $sth->fetch(PDO::FETCH_ASSOC)){
                    echo ("<div class='behandeling'><div style='background-color: White!important;' class='behandeling-text'><h1>" . $result['titel'] ."</h1><img src='" . $result['afbeelding'] . "'alt='" . $result["naam"] . "'><p>".$result['korte_omschrijving']."</p><a href='behandeling-aanpassen.php?behandeling=" .$result['behandeling_id'] ."'>Aanpassen --></a></div></div>");
                }
            }
            elseif ($page == "Nieuws-item"){
								// div left eindigen na de while en beginnen met de div right voor afspraken maken.
								$sth = $dbh->prepare("SELECT titel, inhoud, pagina_id FROM pagina WHERE pagina_id = 5");
								$sth -> execute(array($page));

								while($result = $sth->fetch(PDO::FETCH_ASSOC)){
									echo ("<div class='right' id='afspraak'><h1>".$result['titel']."</h1> <table><tr><td><p>".$result['inhoud']."</p></td></tr> <tr><td><a href='afspraak.php'>Klik hier om een afspraak te maken</a></td></tr></table></div>");
								}

                $sth = $dbh->prepare("SELECT afbeelding, titel, inhoud FROM nieuws WHERE nieuws_id = :nieuwsitem"); //de afbeelding, titel en inhoud wordt uit de datbase opgevraagd, voor het gerelateerde nieuwsitem
                $sth -> execute(array(':nieuwsitem' => $_GET['nieuwsitem']));
                while ($result = $sth ->fetch(PDO::FETCH_ASSOC)){
                    $alinea = alinea($result);
                    echo ('<div class="left"><h1>'.$result['titel'].'</h1>'.$alinea.'</div>');
                    echo ('<div class="right"><section class="gallery">');
                    $plaatjes= ($result['afbeelding']); // pakt de cijfers uit de database
                    $afbeeldingen = explode(".", $plaatjes); // zorgt ervoor dat elk cijfer apart in een array kom te staan

                  // voor elk cijfer achter de comma een plaatje tonen.
                  foreach ($afbeeldingen as $afbeelding) {
                    $sth = $dbh->prepare("SELECT afbeelding FROM afbeelding WHERE afbeeldingid = $afbeelding"); // selecteerd de afbeeldingen in de afbeelding tabel per cijfer
                    $sth -> execute(array($page));
                    $result = $sth ->fetch(PDO::FETCH_ASSOC);
                    if($result['afbeelding'] != NULL){ // toond de afbeelding, bestaat de afbeelding niet meer? Dan wordt dat getoond door een 'deze afbeelding bestaant niet meer' afbeelding.
                      echo ('<div style="margin-bottom: 10px;"><img src="'.substr($result['afbeelding'], 3).'"> alt="afbeelding"></div>'); // laat de afbeelding zien per result
                    } else{
                      echo ('<div style="margin-bottom: 10px;"><img src="../image/error.jpg" alt="afbeelding"></div>');
                    }
                  }
                  echo ('</section></div>'); // sluit de image gallery
                }
                                                                                                                                                      // een if statement of er wel een plaatje is. // substr 3 vanwegen de ../ in de database
            }
            elseif ($page == "Nieuws"){
                $sth = $dbh->prepare("SELECT titel, inhoud FROM pagina WHERE titel = ?"); // Gedetailieerde gegevens worden opgrevraagd voor het nieuwsitem waar naar gelinkt is via de overzicht pagina.
                $sth -> execute(array($page));
                while($result = $sth->fetch(PDO::FETCH_ASSOC)){
                    $alinea = alinea($result);
                    echo ("<div class='left'><h1>" . $result["titel"] . "</h1> " . $alinea . "</div>");  // het nieuwsitem word ge-echoed.
                }

								// div left eindigen na de while en beginnen met de div right voor afspraken maken.
								$sth = $dbh->prepare("SELECT titel, inhoud, pagina_id FROM pagina WHERE pagina_id = 5");
								$sth -> execute(array($page));

								while($result = $sth->fetch(PDO::FETCH_ASSOC)){
									echo ("<div class='right' id='afspraak'><h1>".$result['titel']."</h1> <table><tr><td><p>".$result['inhoud']."</p></td></tr> <tr><td><a href='afspraak.php'>Klik hier om een afspraak te maken</a></td></tr></table></div>");
								}

                $stmt = $dbh->prepare("SELECT * FROM nieuws n LEFT JOIN afbeelding a ON n.afbeelding=a.afbeeldingid WHERE n.done = 1"); // als nieuwsitem gepubliceerd is dan word
                $stmt->execute();
                while ($rows = $stmt->fetch()){ //Er word een overzicht gemaakt voor elk nieuwsitem + link naar een gedetaileerde pagina per nieuwsitem.
                print('<div class="behandeling"><div class="behandeling-text"><h1>'.$rows['titel']. '</h1> '); if($rows['afbeelding'] != NULL){ print('<img src="'.substr($rows['afbeelding'], 3).'" alt="Nieuws item">'); } print(' <p>'.$rows['inhoud'].'</p><p class="datum">'.$rows['datum'].'</p><a href="nieuws-overzicht.php?nieuwsitem='.$rows['nieuws_id'].'">Lees meer ></a></div></div>');
                }                                                                                           // een if statement of er wel een plaatje is. // substr 3 vanwegen de ../ in de database
            }

            elseif ($page == "Recensies"){
                $stmt = $dbh->prepare("SELECT * FROM recensie WHERE accepted = 1 ORDER BY recensieid DESC"); //De gegevens van recensies die geaccepteerd zijn worden opgevraagd.
                $stmt->execute();
                while ($rows = $stmt->fetch()){ //de recensies worden geprint onder elkaar.
                    print ("<div class='recensies' id='box'><h1>".ucfirst(strtolower($rows['title']))."</h1><table><tr><td id='left'>Datum:</td><td>".$rows['date']."</td></tr><tr><td>Door:</td><td>".ucfirst(strtolower($rows['author']))."</td></tr><tr><td>Beoordeling:</td><td style='color:#4daebd;'>");
                        for($i=0; $i<$rows['rate']; $i++){  //De sterretjes van de rating worden geprint.
                          print("&#9733");
                        }
                        for ($j=0; $j<5-$rows['rate']; $j++){
                          print("&#9734;");
                        }
                        print("</td></tr><tr><td>Toelichting:</td><td>".ucfirst(strtolower($rows['note']))."</td></tr></table></div>"); //de recensie word gesloten.
            }
        }
        }

        function contactgegeven($dbh, $page){
              // div left eindigen na de while en beginnen met de div right voor afspraken maken.
              $sth = $dbh->prepare("SELECT titel, inhoud, pagina_id FROM pagina WHERE pagina_id = 5");
              $sth -> execute(array($page));

              while($result = $sth->fetch(PDO::FETCH_ASSOC)){
                echo ("<div class='right' id='afspraak'><h1>".$result['titel']."</h1> <table><tr><td><p>".$result['inhoud']."</p></td></tr> <tr><td><a href='afspraak.php'>Klik hier om een afspraak te maken</a></td></tr></table></div>");
              }

              $sth = $dbh->prepare("SELECT email, telnummer, adres FROM contactgegeven");
              $sth -> execute();
              $result = $sth->fetch(PDO::FETCH_ASSOC);
              return($result);
            }


?>
