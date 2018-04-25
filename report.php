<?php

session_start();
    
    $db = mysqli_connect ("golar3.go.ro", "tw", "59885236", "CriC");
    
    if (!$db) {
        die ("Connection failed: " . mysqli_connect_error());
    } else {
        echo('Success');
    }




    $id = $_POST["id"];
    $name = $_POST["name"];
    // $index = $_POST["index"];
        
    // echo $id . ' ' . $name . ' ' . $index;

    $checkid = "SELECT id FROM report WHERE id = '$id'";
    
    $val = mysqli_query ($db, $checkid);
    
    
    $checkname = "SELECT name FROM report WHERE name = '$name'";

    $valname = mysqli_query ($db, $checkname);




   if ($val->num_rows || $valname->num_rows){
       echo "<script> alert('deja existent');
               window.location.href='../templates/index.php'</script>";

   }else{
       $sql = "INSERT INTO report (id, name) VALUES ('$id', '$name')";
       mysqli_query ($db, $sql);
       echo "<script> alert('ai fost adaugat cu succes');
               window.location.href='../templates/index.php'</script>";

   }

        

    

?>