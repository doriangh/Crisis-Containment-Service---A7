<?php

    session_start();
    
    $db = mysqli_connect ("localhost", "root", "PAROLA_TA_AICI", "CriC");
    
    if (!$db) {
        die ("Connection failed: " . mysqli_connect_error());
    } else {
        echo('Success');
    }


    if (isset($_POST['adaugabtn'])) {

        $nume = ($_POST['nume']);
        $prenume = ($_POST['prenume']);
        $adresa = ($_POST['adresa']);
        $oras = ($_POST['oras']);
        $sesizari = ($_POST['sesizari']);
        $descriere = ($_POST['descriere']);
    
    }

    $sql = "INSERT INTO form(nume, prenume, adresa, oras, sesizari, descriere) VALUES ('$nume', '$prenume', '$adresa', '$oras', '$sesizari', '$descriere')";

    mysqli_query ($db, $sql);


    header ('Location: ../templates/index.html');


    $_SESSION['name'] = $nume;
    $_SESSION['surname'] = $prenume;
    $_SESSION['address'] = $adresa; 
    $_SESSION['city'] = $oras;
    $_SESSION['title'] = $sesizari;
    $_SESSION['desc'] = $descriere;
    

?>
