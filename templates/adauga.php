<?php

 session_start();
    
    $db = mysqli_connect ("golar3.go.ro", "tw", "59885236", "CriC");
    
    if (!$db) {
        die ("Connection failed: " . mysqli_connect_error());
    } 
//    else {
//        echo('Success');
//    }

    function geocode ($address){
        
        $address = urlencode($address);
        
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=AIzaSyAayHIe6ZzIMchpW9ro_gEkgQOoI9jjt3g";
        
        $resp_json = file_get_contents($url);
        
        $resp = json_decode($resp_json, true);
        
        if ($resp['status'] == 'OK') {
            
            $lati = isset($resp['results'][0]['geometry']['location']['lat']) ? $resp['results'][0]['geometry']['location']['lat'] : "";
            
            $longi = isset($resp['results'][0]['geometry']['location']['lng']) ? $resp['results'][0]['geometry']['location']['lng'] : "";
            
            $formatted_address = isset($resp['results'][0]['formatted_address']) ? $resp['results'][0]['formatted_address'] : "";
            
            if ($lati && $longi && $formatted_address) {
                
                $data_arr = array();
                
                array_push ($data_arr, $lati, $longi, $formatted_address);
                return $data_arr;
            
            } else {
                return false;
            }
            
        }
        
        else {
            echo "\nError: {$resp['status']}";
            return false;
        }
    }

    if (isset($_POST['adaugabtn'])) {

        $nume = htmlspecialchars($_POST['nume']);
        $prenume = htmlspecialchars($_POST['prenume']);
//        $oras = ($_POST['oras']);
        $sesizari = htmlspecialchars($_POST['sesizari']);
        $descriere = htmlspecialchars($_POST['descriere']);
        //$director = addslashes (file_get_contents($_FILES['imagine']['tmp_name']));
        
        
        $data_arr = geocode ($_POST['adresa']);
        
        if ($data_arr) {
            $latitude = $data_arr[0];
            $longitude = $data_arr[1];
            $address = $data_arr[2];
        }
        
    
    }

//    echo $latitude . $longitude . $address . $nume;

    $max = "SELECT max(id) from form;";
    $max1 = mysqli_query($db, $max);
    $max2 = mysqli_fetch_assoc($max1);
    $max3 = $max2["max(id)"];
    $max4 = $max3 + 1;

    if ($latitude != 0 || $longitude != 0){
        
        $update = "ALTER TABLE form AUTO_INCREMENT = $max4";
        mysqli_query ($db, $update);
        
        $sql = "INSERT INTO form (nume, prenume, adresa, sesizari, descriere, latitude, longitude) VALUES ('$nume', '$prenume', '$data_arr[2]', '$sesizari', '$descriere',  '$data_arr[0]', '$data_arr[1]')";

        mysqli_query ($db, $sql);

        
        header ('Location: ../index.php');
        
        
        
    } else {
        
        echo "<script> alert('Locatie incorecta');
                window.location.href='../templates/adauga.html'</script>";   
    }
    

?>
