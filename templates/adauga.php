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


    $trigger = "CREATE TRIGGER `updateReport`
                BEFORE INSERT ON `form` FOR EACH ROW
                BEGIN
	               UPDATE `report` SET `slide` = `slide` + 1;
                END;";

    mysqli_query($db, $trigger);


	$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
	//Random name
	$numar=rand(10000,999999);
	$numeImg=strval($numar);
	if($imageFileType == "jpg")$numeImg=$numar.'.jpg';
	if($imageFileType == "png")$numeImg=$numar.'.png';
	if($imageFileType == "jpeg")$numeImg=$numar.'.jpeg';
	if($imageFileType == "gif")$numeImg=$numar.'.gif';
	$target_file=$target_dir . $numeImg; 

	// Generate an unused imagine name
	while (file_exists($target_file)) {
		$numar=rand(10000,999999);
		$numeImg=strval($numar);
		$numeImg=$numar.'.jpg';
		$target_file=$target_dir . $numeImg; 
		//echo "Sorry, file already exists.";
		//$uploadOk = 0;
	}
	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 500000) {
		echo "Sorry, your file is too large.";
		$uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
	}
	
    if (isset($_POST['adaugabtn'])) {

        $nume = htmlspecialchars($_POST['nume']);
        $prenume = htmlspecialchars($_POST['prenume']);
//        $oras = ($_POST['oras']);
        $sesizari = htmlspecialchars($_POST['sesizari']);
        $descriere = htmlspecialchars($_POST['descriere']);
        //$director = addslashes (file_get_contents($_FILES['imagine']['tmp_name']));
        $categorie=htmlspecialchars($_POST['categorie']);
        
        
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
        
        if($uploadOk == 0){
        $sql = "INSERT INTO form (nume, prenume, adresa, sesizari, descriere, latitude, longitude, filter) VALUES ('$nume', '$prenume', '$data_arr[2]', '$sesizari', '$descriere',  '$data_arr[0]', '$data_arr[1]', '$categorie')";
		}
		if($uploadOk == 1){
        $sql = "INSERT INTO form (nume, prenume, adresa, sesizari, descriere, latitude, longitude, filter, Images) VALUES ('$nume', '$prenume', '$data_arr[2]', '$sesizari', '$descriere',  '$data_arr[0]', '$data_arr[1]', '$categorie','$numeImg')";
		}
        mysqli_query ($db, $sql);

        if($uploadOk == 0) {
            $fileName = 'sendmail.php';
            $nume = str_replace(" ", "+", $nume);
            $prenume = str_replace(" ", "+", $prenume);
            $address = str_replace(" ", "+", $address);
            $sesizari = str_replace(" ", "+", $sesizari);
            $descriere = str_replace(" ", "+", $descriere);
            exec ("php -f {$fileName} {$nume} {$prenume} {$address} {$sesizari} {$descriere} > nul 2>&1 &");
        }
        else {
            $fileName = 'sendmail.php';
            $nume = str_replace(" ", "+", $nume);
            $prenume = str_replace(" ", "+", $prenume);
            $address = str_replace(" ", "+", $address);
            $sesizari = str_replace(" ", "+", $sesizari);
            $descriere = str_replace(" ", "+", $descriere);
            $target_file = str_replace(" ", "+", $target_file);
            exec ("php -f {$fileName} {$nume} {$prenume} {$address} {$sesizari} {$descriere} {$target_file} > nul 2>&1 &");
        }

        header ('Location: ../index.php');

        
        
    } else {
        
        echo "<script> alert('Locatie incorecta');
                window.location.href='../templates/adauga.html'</script>";   
    }
   
	//			File upload
	$target_dir = "uploads/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}
	}

?>
