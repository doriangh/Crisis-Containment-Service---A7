<?php

session_start();
    
    $db = mysqli_connect ("golar3.go.ro", "tw", "59885236", "CriC");
    
    if (!$db) {
        die ("Connection failed: " . mysqli_connect_error());
    } 
//    else {
//        echo('Success');
//    }




//    print_r($_FILES);
//    print_r($_POST);

    $id = $_POST["id"];
    $name = $_POST["name"];
    $slide = $_POST["slide"];
        
//     echo $id . ' ' . $name . ' ' . $slide . ' ';

    $checkid = "SELECT id FROM report WHERE id = '$id'";
    
    $val = mysqli_query ($db, $checkid);
    
    
    $checkname = "SELECT name FROM report WHERE name = '$name'";

    $valname = mysqli_query ($db, $checkname);

    
    $checkslide = "SELECT slide FROM report WHERE name = '$name' AND slide = '$slide'";

    $valslide = mysqli_query ($db, $checkslide);

    
    $max = "SELECT id FROM form ORDER BY 1 DESC LIMIT 1;";

    $valmax = mysqli_query ($db, $max);
    $result = mysqli_fetch_assoc ($valmax);
//    echo $result;

    $test[] = $result["id"];
//    print_r($test[0]);

    $val = $test[0] + 1;

//    echo $val . ' ' . $slide;
//
//
//    $testing = "SELECT * FROM form where ID = ($val - $slide);";
//    $valtest = mysqli_query ($db, $testing);
//    $resulttest = mysqli_fetch_assoc ($valtest);
//    
//    echo '       fdaf   ' . $resulttest["ID"] . ' ' . $resulttest["nume"];
// 






   if ($valname->num_rows && $valslide->num_rows){
       echo "<script> alert('Ati raportat deja!');
               window.location.href='../templates/index.php'</script>";

   }else{
       
       $sql = "INSERT INTO report (id, name, slide) VALUES ('$id', '$name', '$slide')";
       mysqli_query ($db, $sql);
       
       $sql2 = "UPDATE form SET report = (report + 1) WHERE ID = ($val- $slide);";
       mysqli_query ($db, $sql2);

       echo "<script> alert('Ati raportat cu succes articolul " . $slide . "');
               window.location.href='../templates/index.php'</script>";

   }

        

    

?>