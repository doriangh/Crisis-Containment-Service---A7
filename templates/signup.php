<?php

    $db = mysqli_connect ("golar3.go.ro", "tw", "59885236", "CriC");
    
    if (!$db) {
        die ("Connection failed: " . mysqli_connect_error());
    } 
//    else {
//        echo('Success');
//    }


    if (isset($_POST['sign-up'])) {

        $email = htmlspecialchars($_POST['email']);
        $oras = htmlspecialchars($_POST['oras']);
        
    
    }

    $sql = "INSERT INTO signup(mail, oras) VALUES ('$email', '$oras')";

    $subj = "Abonare la newsletter";
    $msg = "V-ati abonat cu succes la newsletter-ul site-ului !\nOrasul dumneavoastra este: $oras";
    mail($email,$subj,$msg,'From: crisis.containment@gmail.com');

    mysqli_query ($db, $sql);

    header ('Location: ../index.php');


?>
