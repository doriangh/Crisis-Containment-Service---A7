<!DOCTYPE html>
<html lang="ro">
<head>
    
    <!-- Link la diferite surse/fisiere -->
	<meta charset="UTF-8">
    <meta name="description" content="Crisis Containment Service">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>CriC</title>
	<link rel="stylesheet" type="text/css" href="../styles/style.css">

    <script src="../scripts/slide-show.js" type="text/javascript"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
    
    <script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
    
    <meta name="google-signin-client_id" content="580134955331-dsvnpsi07grklncod32u8cj2j13hm826.apps.googleusercontent.com"> 
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css">
    <script src="https://apis.google.com/js/api:client.js"></script>
    
    <script type="text/javascript" src="../google.js"></script>
    

</head>
    
<body>
    <!-- Meniul -->
     <div class="topnav">
            <a class="active" href="../index.php">Acasa</a>
            <a href="../templates/inundatii.html">Inundatii</a>
            <a href="../templates/cutremure.html">Cutremure</a>
            <a href="../templates/incendii.html">Incendii</a>
            <a href="../templates/arhiva.php">Arhiva</a>
            <a href="../templates/new-harta.php">Harta</a>
            <a href="../templates/adauga.html" class="button" style="color: white;font-size: 15px;width: 170px;margin-left: 5px;">+Adauga Eveniment</a>
         
            <form id="searchBtn" class="top-form" action="../templates/search-map.html" method="GET">
<!--                <script type="text/javascript" src="../scripts/search-autocomplete.js"></script>-->
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
    
    <h1 id="titlu">Ultimele Noutati</h1>
    
</header>

 <div class="sectiune_text">
     <br>
     
<!--
     <div class="articol">
         
        
<?php

session_start();
    
         
    $db = mysqli_connect ("golar3.go.ro", "tw", "59885236", "CriC");
    
    if (!$db) {
        die ("<p style=\"background-color: red;color:white;\">Connection failed: " . mysqli_connect_error() . "</p> <br>");
    } else {
        echo("<p style=\"background-color: green;color:white;\">Conectat la server</p> <br>");
    }
         
?>
         
     </div>
-->
     
     <div class="articol">
         
         <!-- Sign In/Up (Maybe) -->
<!--
   <div class="clearfix">  
         <button onclick="document.getElementById('login').style.display='block'; var modal=document.getElementById('login');" style="width:auto;">Login</button>

         <div id="login" class="modal">
             
             <span onclick="document.getElementById('login').style.display='none'" class="close" title="Close Modal">&times;</span>

             <form class="modal-content animate">

                <div class="container">

                    <label for="uname"><b>Username</b></label>
                    <input type="textbox" placeholder="Enter Username" name="uname" required>

                    <label for="pwd"><b>Password</b></label>
                    <input type="password" placeholder="Enter Password" name="pwd" required>

                    <button type="submit">Login</button>
                    <label>
                        <input type="checkbox" checked="checked" name="remember">Remember Me
                    </label>

                 </div>

             </form>

         </div>
       
       
       
       <button onclick="document.getElementById('signup').style.display='block'" style="width:auto;">Sign Up</button>
       
       <div id="signup" class="modal">
       
           <span onclick="document.getElementById('signup').style.display='none'; var modal = document.getElementById('signup');" class="close" title="Close Modal">&times;</span>
           
           <form class="modal-content animate">
            
                <div class="container">
                
                    <h1>Sign Up</h1>
                    <span>Please fill in the form</span>
                    <hr>
                    <label for="email"><b>Email</b></label>
                    <input type="textbox" placeholder="Enter Email" name="email" required>
                    
                    <label for="pwd"><b>Password</b></label>
                    <input type="password" placeholder="Enter Password" name="pwd" required>
                    
                    <label for="pwd-repeat"><b>Repeat Password</b></label>
                    <input type="password" placeholder="Repeat Password" name="pwd-repeat" required>
                    
                    <div class="clearfix">
                    
                        <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
                        <button type="submit" class="adaugabtn">Sign Up</button>
                    
                    </div>
                    
                </div>
           
           </form>
       
       
       </div>
       
     </div>
-->
        
<?php
    
    $query = "SELECT max(ID) FROM form";
    $max = mysqli_query ($db, $query);
    $item = mysqli_fetch_assoc ($max);
    $maxim = $item["max(ID)"];
         
    //Cel mai noua stire     
    $first = "SELECT * FROM form WHERE ID = $maxim";
    $qfirst = mysqli_query ($db, $first);
    $ifirst = mysqli_fetch_assoc ($qfirst);
         
    if ($ifirst["report"] <= 4){
        
        echo "<article class=\"mySlides\"/>
            <h6 id=\"autor\">Autor: " . $ifirst["nume"] . " " . $ifirst["prenume"] . "<br>Data: " . $ifirst["added"] . "<br>Numar Raportari: " . $ifirst["report"] . "</h6>
            <p style=\"background-color:green;color:white;\">Eveniment de Incredere</p>
            <h3>" . $ifirst["sesizari"] . "</h3>
            <h4 style=\"padding: 0; font-size: 10px;\"> Locatie: " .$ifirst["adresa"] ." </h4>
            <p>" . $ifirst["descriere"] . "</p> </article>";
        
    } else if ($ifirst["report"] <= 9) {
        
        echo "<article class=\"mySlides\"/>
            <h6 id=\"autor\">Autor: " . $ifirst["nume"] . " " . $ifirst["prenume"] . "<br>Data: " . $ifirst["added"] . "<br>Numar Raportari: " . $ifirst["report"] . "</h6>
            <p style=\"background-color:yellow;color:black;\">Eveniment Potential Incorect</p>
            <h3>" . $ifirst["sesizari"] . "</h3>
            <h4 style=\"padding: 0; font-size: 10px;\"> Locatie: " .$ifirst["adresa"] ." </h4>
            <p>" . $ifirst["descriere"] . "</p> </article>";
        
    } else {
        
        echo "<article class=\"mySlides\"/>
            <h6 id=\"autor\">Autor: " . $ifirst["nume"] . " " . $ifirst["prenume"] . "<br>Data: " . $ifirst["added"] . "<br>Numar Raportari: " . $ifirst["report"] . "</h6>
            <p style=\"background-color:red;color:white;\">Eveniment Incorect</p>
            <h3>" . $ifirst["sesizari"] . "</h3>
            <h4 style=\"padding: 0; font-size: 10px;\"> Locatie: " .$ifirst["adresa"] ." </h4>
            <p>" . $ifirst["descriere"] . "</p> </article>";
    }
         
         
    $counter = "SELECT * FROM form where ID between $maxim - 9 and $maxim - 1 order by ID desc;";

    $result = mysqli_query ($db, $counter);

         
    if (mysqli_num_rows ($result) > 0) {
        
        while ($row = mysqli_fetch_assoc ($result)) {
            
            if ($row["report"] <= 4) {
            
            echo "<article class=\"mySlides\" style=\"display:none;\">
                    <h6 id=\"autor\">Autor: " . $row["nume"] . " " . $row["prenume"] . "<br>Data: " . $row["added"] .  "<br>Numar Raportari: " . $row["report"] . "</h6>
                    <p style=\"background-color:green;color:white;\">Eveniment de Incredere</p>
                    <h3>" . $row["sesizari"] . "</h3>
                    <h4 style=\"padding: 0; font-size: 10px;\"> Locatie: " .$row["adresa"] ." </h4>
                    <p>" . $row["descriere"] . "</p> </article>";
                
            } else if ($row["report"] <= 9) {
                
                echo "<article class=\"mySlides\" style=\"display:none;\">
                    <h6 id=\"autor\">Autor: " . $row["nume"] . " " . $row["prenume"] . "<br>Data: " . $row["added"] .  "<br>Numar Raportari: " . $row["report"] . "</h6>
                    <p style=\"background-color:yellow;color:black;\">Eveniment Potential Incorect</p>
                    <h3>" . $row["sesizari"] . "</h3>
                    <h4 style=\"padding: 0; font-size: 10px;\"> Locatie: " .$row["adresa"] ." </h4>
                    <p>" . $row["descriere"] . "</p> </article>";
                
            } else {
                
                echo "<article class=\"mySlides\" style=\"display:none;\">
                    <h6 id=\"autor\">Autor: " . $row["nume"] . " " . $row["prenume"] . "<br>Data: " . $row["added"] .  "<br>Numar Raportari: " . $row["report"] . "</h6>
                    <p style=\"background-color:red;color:white;\">Eveniment Incorect</p>
                    <h3>" . $row["sesizari"] . "</h3>
                    <h4 style=\"padding: 0; font-size: 10px;\"> Locatie: " .$row["adresa"] ." </h4>
                    <p>" . $row["descriere"] . "</p> </article>";
                
            }
        }
    }
         

    mysqli_close($db);
         
?>          
      
           
        <p id="status" style="display:none"></p>
         
         <div id='signin' class="g-signin2" data-onsuccess="onSignIn" style="display:block;">
             <button onload="checkLogin"></button>
         </div>
         
         <p id="slideindex" name="slideindex">1</p>
         
        
         <div class="clearfix">
           
         
         <form action="../report.php" method="POST" id="rep">
             <input id="id" style="display:none;" name="id">
             <input id="name" style="display:none" name="name">
             <input id="slide" style="display:none" name="slide" value=1>
             <button id="report" class="adaugabtn" style="display:none;width:50%;margin-bottom:0">Report</button>
         </form>
             

             
              <a href="#" onclick="signOut();"><button class="cancelbtn" href="#"id='signout' style="display:none;width:50%;">Sign Out</button></a>
         </div>
         
         
         
         
         <button class="test-btn black-btn left-display-btn" onclick="plusDivs(-1)">&#10094;</button>
         
         <button class="test-btn black-btn right-display-btn" onclick="plusDivs(1)">&#10095;</button>
         
         
     </div>
     
     
       
     
     
     <form style="border: 1px solid #ccc" class="signup-form" method="POST" action="../templates/signup.php">
         <div class="containter">
            <p>FII la curent!</p>
            <hr>
         
         <input class="signup-input" type="email" placeholder="Email" name="email" pattern="[A-Za-z.@]+" required>
        
             
         <input class="signup-input" type="text" placeholder="Oras" name="oras" required>

         <div class="clearfix">
             
            <button type="submit" class="adaugabtn" name="sign-up" style="border:1px">Sign Up</button>
            <button type="button" class="cancelbtn">Cancel</button>
         
         </div>
         </div>
     </form> 
    <br>
     
 
<!-- Sign In/Up Exit (Maybe) -->
<!--
       <script>
           
           window.onclick = function(event) {
               if (event.target == document.getElementById('login')) {
                   document.getElementById('login').style.display = "none";
               } else
                if (event.target == document.getElementById('signup')) {
                    document.getElementById('signup').style.display = "none";
                }
           }
           
       </script>
-->
     
     
     
    </div>

 	<footer> 
 		<h1><u>&copy;Tehnologii Web</u></h1>
 	</footer>

    </div>
    
    
</body>
</html>