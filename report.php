<?php

session_start();
    
    $db = mysqli_connect ("golar3.go.ro", "tw", "59885236", "CriC");
    
    if (!$db) {
        die ("Connection failed: " . mysqli_connect_error());
    } 

    $id = $_POST["id"];
    $name = $_POST["name"];
    $slide = $_POST["slide"];

    $checkid = "SELECT id FROM report WHERE id = '$id'";
    
    $val = mysqli_query ($db, $checkid);
    
    
    $checkname = "SELECT name FROM report WHERE name = '$name'";

    $valname = mysqli_query ($db, $checkname);

    
    $checkslide = "SELECT slide FROM report WHERE name = '$name' AND slide = '$slide'";

    $valslide = mysqli_query ($db, $checkslide);

    
    $max = "SELECT id FROM form ORDER BY 1 DESC LIMIT 1;";

    $valmax = mysqli_query ($db, $max);
    $result = mysqli_fetch_assoc ($valmax);


    $test[] = $result["id"];


    $val = $test[0] + 1;

    $curr = $val - $slide;

    /*Luam numarul de reporturi de la articolul curent*/
    $report = "SELECT report FROM form WHERE id = '$curr'";
    $checkreport = mysqli_query ($db, $report);
    $resultreport = mysqli_fetch_assoc ($checkreport);
    $testreport = $resultreport["report"];

    if ($valname->num_rows && $valslide->num_rows){
          echo "<script> alert('Ati raportat deja!');
                   window.location.href='../index.php'</script>";
    } else {
    
    /*Verificam daca are mai putin de 21 de reporturi */
    if ($testreport >= 20){
        
        /*Stergem articolul*/
        $deletearticle = "DELETE FROM form WHERE ID = '$curr'";
        mysqli_query ($db, $deletearticle);
        
        /*Stergem coloana ID*/
        $updatetable = "ALTER TABLE `form` DROP COLUMN `ID`;";
        mysqli_query ($db, $updatetable);
        $commit = "COMMIT;";
        mysqli_query ($db, $commit);
        
        /*Recreem coloana ID pentru a reinitializa indexul*/
        $updateindex = "ALTER TABLE `form` ADD column ID int primary key AUTO_INCREMENT;";
        mysqli_query ($db, $updateindex);
        
        $commit2 = "COMMIT;";
        mysqli_query ($db, $commit2);
        
        echo "<script> alert('Ati raportat cu succes! Articolul a capatat mai mult de 20 de reporturi si a fost sters.');window.location.href='../index.php'</script>";
    
       }else{

           $sql = "INSERT INTO report (id, name, slide) VALUES ('$id', '$name', '$slide')";
           mysqli_query ($db, $sql);

           $sql2 = "UPDATE form SET report = (report + 1) WHERE ID = ($val - $slide);";
           mysqli_query ($db, $sql2);

           echo "<script> alert('Ati raportat cu succes articolul " . $slide . "');
                   window.location.href='../index.php'</script>";

       }
    }

?>