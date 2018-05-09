<?php

    $db = mysqli_connect ("golar3.go.ro", "tw", "59885236", "CriC");
    
    if (!$db) {
        die ("Connection failed: " . mysqli_connect_error());
    } 
//    else {
//        echo('Success');
//    }


    if (isset($_POST['sign-up'])) {

        $email = ($_POST['email']);
        $oras = ($_POST['oras']);
        
    
    }

    $sql = "INSERT INTO signup(mail, oras) VALUES ('$email', '$oras')";

    mysqli_query ($db, $sql);

    header ('Location: ../templates/index.php');


?>
