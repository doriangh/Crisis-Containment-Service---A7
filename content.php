<?php

    $db = mysqli_connect ("localhost", "root", "59885236", "CriC");

        if (!$db) {
            die ("Connection failed: " . mysqli_connect_error());
        } else {
            echo('Success');
        }
    

    $sql = "SELECT * FROM form";
        
    $result = mysqli_query ($db, $sql);


    if ($result->num_rows > 0) {
        
        while ($row = $result->fetch_assoc()){
            echo "nume: " . $row["nume"]. "- prenume: " . $row["prenume"] . "<br>";
        }
    } else {
        echo "0 results";
    }


?>