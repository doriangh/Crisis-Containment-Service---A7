<!DOCTYPE html>
<html lang="ro">
<head>
	<meta charset="UTF-8">
    <meta name="description" content="Crisis Containment Service">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
	<title>Arhiva</title>
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
    
     <div class="topnav">
            <a href="../index.php">Acasa</a>
            <a href="../templates/inundatii.html">Inundatii</a>
            <a href="../templates/cutremure.html">Cutremure</a>
            <a href="../templates/incendii.html">Incendii</a>
            <a class="active"  href="../templates/arhiva.php">Arhiva</a>
            <a href="../templates/new-harta.php">Harta</a>
            <a href="../templates/adauga.html" class="button" style="color: white;font-size: 15px;width: 170px;margin-left: 5px;">+Adauga Eveniment</a>
         
            <form id="searchBtn" class="top-form" action="../templates/search-map.html" method="GET">
                <input id="adresa" class="search" type="text" name="city" placeholder="Cauta Oras..." required >
                <input class="button-top" type="submit" value="Cauta">
               

        
            </form>
        </div>
    
<div class="main">
    
<!--Imagine sus -->
<div class="top">
        <img src="../images/arh.jpg" alt="Pamantul" class="responsive" style="display:block;max-width:100%;height=auto;">
</div>
    
<header>
    
    <h1 id="titlu">Arhiva evenimentelor</h1>
    
</header>

 <div class="sectiune_text">
     <br>
     
     
     
     

     <div class="articol">
         
        
<?php
        
session_start();
     
    //Conectarea la baza noastra de date si la localhost
    $db = mysqli_connect ("golar3.go.ro", "tw", "59885236", "CriC");
    if (!$db) {
        die ("<p style=\"background-color: red;color:white;\">Connection failed: " . mysqli_connect_error() . "</p> <br>");
    } 

    //Luam numarul paginii scris in adresa URl a paginii arhivei    
    
 

    $page1=0;
    if (isset($_GET['page']))
        $page=$_GET['page'];
    else
        $page = '';
    
    if($page=="1" || $page == '')
    {
        $page1=0;
    }  
    else {
        $page1 = ($page+5) - 5;
         }     
    $counter = "SELECT * FROM form order by added desc limit $page1,20; ";

    $result = mysqli_query ($db, $counter);


  
              
    if (mysqli_num_rows ($result) > 0) {
        //Algoritmul folosit pentru a se afisa indexul potrivit fiecarui eveniment
        $ind=$page1*20 + 1;
        while ($row = mysqli_fetch_assoc ($result)) {
           echo "<article class=\"mySlides\" style=\"display:block;\"><br>  
                    <HR WIDTH=98%; SIZE=10; COLOR=grey><br>
                     
                    <h5 id=\"autor\">Autor: " . $row["nume"] . " " . $row["prenume"] . "<br>Data: " . $row["added"] .  "<br>Numar Raportari: " . $row["report"] . "</h5>
                    <h3>" . $row["sesizari"] . "</h3>
                    <h4 style=\"padding: 0; font-size: 10px;\"> Locatie: " .$row["adresa"] ." </h4>
                    <p>" . $row["descriere"] . " <br> " . $ind."</p> 
                  </article>";
            echo "<br>";
            $ind++;
            }
        }

    $counter2 = "SELECT * FROM form ; " ;
    $res1 = mysqli_query($db, $counter2);

    //Aflam numarul evenimentelor din baza de date
    $cou = mysqli_num_rows($res1);

    //Aflam numarul paginilor de va avea arhiva 
    $a = $cou/20;
    $a = ceil($a); 


    //Afisarea listei paginilor in partea de jos a paginii 
    for($b=1; $b <= $a ; $b++)
    {
        ?><a href="arhiva.php?page=<?php echo $b; ?>" style="text-decoration:none "><?php echo $b." "; ?></a> <?php
    }

    //this is for counting number of page
   /* $cou = "SELECT count(id) FROM form;" ;  
    $res = mysql_query($db,$cou);  
    $a = $res/20;
    echo $cou;

            */


    //Deconectarea de la baza de date          
    mysqli_close($db);
         
?>          
      
           
        <p id="status" style="display:none"></p>
 
        
         
        
         <div class="clearfix">
           
         
      <form action="../report.php" method="POST" id="rep">
             <input id="id" style="display:none;" name="id">
             <input id="name" style="display:none" name="name">
         </form>
             

         </div>
         
         
    
         
     </div>
     
     
       
     
     
     <form style="border: 1px solid #ccc" class="signup-form" method="POST" action="../templates/signup.php">
         <div class="containter">
            <p>FII la curent!</p>
            <hr>
         
         <input class="signup-input" type="email" placeholder="Email" name="email" required>
        
             
         <input class="signup-input" type="text" placeholder="Oras" name="oras" required>
    
         
         <div class="clearfix">
             
            <button type="submit" class="adaugabtn" name="sign-up" style="border:1px">Sign Up</button>
            <button type="button" class="cancelbtn">Cancel</button>
         
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