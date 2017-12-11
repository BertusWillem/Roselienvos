<?php
include 'dbh.php';

$sth = $dbh->prepare("SELECT email FROM contactgegevens");
            $sth -> execute();
            
            $result = $sth->fetch(PDO::FETCH_ASSOC);
            $emailontvanger=(implode($result));
            
$sth = $dbh->prepare("SELECT telnummer FROM contactgegevens");
            $sth -> execute();
            
            $result = $sth->fetch(PDO::FETCH_ASSOC);
            $telnummer=(implode($result));

$sth = $dbh->prepare("SELECT adres FROM contactgegevens");
            $sth -> execute();
            
            $result = $sth->fetch(PDO::FETCH_ASSOC);
            $adres=(implode($result));
            

