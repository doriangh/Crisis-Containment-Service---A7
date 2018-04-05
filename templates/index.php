<!DOCTYPE html>
<html lang="ro">
<head>
	<meta charset="utf-8" content="width=device-width, initial-scale=1">
	<title>CriC</title>
	<link rel="stylesheet" type="text/css" href="../styles/style.css">
<!--    <script src="../scripts/search-autocomplete.js" type="text/javascript"></script>-->
    <script src="../scripts/slide-show.js" type="text/javascript"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
    
    
</head>
<body>
    
     <div class="topnav">
            <a class="active" href="../templates/index.php">Acasa</a>
            <a href="../templates/inundatii.html">Inundatii</a>
            <a href="../templates/cutremure.html">Cutremure</a>
            <a href="../templates/incendii.html">Incendii</a>
            <a href="../templates/harta.html">Harta</a>
            <a href="../templates/adauga.html" class="button" style="color: white;font-size: 15px;width: 170px;margin-left: 5px;">+Adauga Eveniment</a>
         
            <form id="searchBtn" class="top-form" action="../templates/search-map.html" method="GET">
                <input id="adresa" class="search" type="text" name="city" placeholder="Cauta Oras..." required >
                <input class="button-top" type="submit" value="Cauta">
               

        
            </form>
        </div>
    
<div class="main">
    
<!--Imagine sus -->
<div class="top">
        <img src="../images/top-image.jpg" alt="Pamantul" class="responsive">
</div>
    
<header>
    
    <h1>Ultimele Noutati</h1>
    
</header>

 <div class="sectiune_text">
     <br>
     <div class="articol">
         
         
         <?php

session_start();
    
//    $db = mysqli_connect ("localhost", "root", "59885236", "CriC");
         
    $db = mysqli_connect ("golar3.go.ro", "tw", "59885236", "CriC");
    
    if (!$db) {
        die ("<p style=\"background-color: red;color:white;\">Connection failed: " . mysqli_connect_error() . "</p> <br>");
    } else {
        echo("<p style=\"background-color: green;color:white;\">Conectat la server</p> <br>");
    }

         
    $query = "SELECT max(ID) FROM form";
    $max = mysqli_query ($db, $query);
    $item = mysqli_fetch_assoc ($max);
    $maxim = $item["max(ID)"];
         
    //Cel mai noua stire     
    $first = "SELECT * FROM form WHERE ID = $maxim";
    $qfirst = mysqli_query ($db, $first);
    $ifirst = mysqli_fetch_assoc ($qfirst);
    echo "<article class=\"mySlides\"/>
            <h6 id=\"autor\">Autor: " . $ifirst["nume"] . " " . $ifirst["prenume"] . "<br>Data: " . $ifirst["added"] . "</h6>
            <h3>" . $ifirst["sesizari"] . "</h3>
            <h4 style=\"padding: 0; font-size: 10px;\"> Locatie: " .$ifirst["adresa"] ." </h4>
            <p>" . $ifirst["descriere"] . "</p> </article>";
         
         
    $counter = "SELECT * FROM form where ID between $maxim - 9 and $maxim - 1 order by ID desc;";

    $result = mysqli_query ($db, $counter);

    if (mysqli_num_rows ($result) > 0) {
        
        while ($row = mysqli_fetch_assoc ($result)) {
            echo "<article class=\"mySlides\" style=\"display:none;\">
                    <h6 id=\"autor\">Autor: " . $row["nume"] . " " . $row["prenume"] . "<br>Data: 29/04/2018 </h6>
                    <h3>" . $row["sesizari"] . "</h3>
                    <h4 style=\"padding: 0; font-size: 10px;\"> Locatie: " .$row["adresa"] ." </h4>
                    <p>" . $row["descriere"] . "</p> </article>";
         
        }
    }
         

    mysqli_close($db);

?>
         

         <button class="test-btn black-btn left-display-btn" onclick="plusDivs(-1)">&#10094;</button>
         
         <button class="test-btn black-btn right-display-btn" onclick="plusDivs(1)">&#10095;</button>
         
     </div>
     
     <form style="border: 1px solid #ccc" class="signup-form" method="POST" action="../signup.php">
         <div class="containter">
            <p>FII la curent!</p>
            <hr>
         
         <input class="signup-input" type="text" placeholder="Email" name="email" required>
        
             
         <input class="signup-input" type="text" placeholder="Oras" name="oras" required>
    
         
         <div class="clearfix">
            <button type="button" class="cancelbtn">Cancel</button>
             
             <button type="submit" class="adaugabtn" name="sign-up">Sign Up</button>
         
         </div>
         </div>
     </form> 
    <br>
    </div>

 	<footer> 
 		<h1><u>&copy;Tehnologii Web</u></h1>
 	</footer>

    </div>
    
</body>
</html>