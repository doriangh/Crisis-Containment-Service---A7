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
    
    <script type="text/javascript" src="../scripts/sidebar.js"></script>

    
</head>
<body>
    
     <!-- Meniul -->
    <div class="topnav" >
        <span style="font-size:20px;cursor:pointer" onclick="openNav()">&#9776; Meniu</span>
        
          <form id="searchBtn" class="top-form" action="../templates/search-map.html" method="GET">
                <input id="adresa" class="search" type="text" name="city" placeholder="Cauta Oras..." required >
                <input class="button-top" type="submit" value="Cauta">
            </form>
    </div>
    
     <div class="sidenav" id="meniu">
         <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a class="active" href="../index.php">Acasă</a>
            <a href="../templates/inundatii.html">Inundații</a>
            <a href="../templates/cutremure.html">Cutremure</a>
            <a href="../templates/incendii.html">Incendii</a>
            <a href="../templates/arhiva.php">Arhivă</a>
            <a href="../templates/new-harta.php">Hartă</a>
            <a href="../templates/adauga.html" class="button" style="color: white;font-size: 20px;width: 100%;margin-left: 5px;">+ Adaugă Eveniment</a>
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

<form method="post" action="arhiva.php">
    <select name="values">
        <option value="">Selectati filtrul </option>
        <option value="cutremure">Cutremure</option>
        <option value="incendii">Incendii </option>
        <option value="inundatii">Inundatii</option>
        <option value="other">Other</option>
    </select>
    <input type="submit" name="submit" value="Cauta">
     
<div class="articol">




<?php
        
session_start();
    //Conectarea la baza noastra de date si la localhost
    $db = mysqli_connect ("golar3.go.ro", "tw", "59885236", "CriC");
    if (!$db) {
        die ("<p style=\"background-color: red;color:white;\">Connection failed: " . mysqli_connect_error() . "</p> <br>");
    } 
  
 //Filtrarea evenimentelor dupa interes
        $sql = " SELECT * from form";

 if(isset($_POST['submit']))
        {
          if($_POST['values'] == 'cutremure')
          {
              $sql  = "SELECT * FROM form WHERE filter='cutremure' ";
          } 
          elseif ($_POST['values'] == 'inundatii') {
             $sql  = "SELECT * FROM form WHERE filter='inundatii' ";
         }
          elseif ($_POST['values'] == 'incendii') {
             $sql  = "SELECT * FROM form WHERE filter='incendii' ";
         }
          elseif ($_POST['values']=='other'){
             $sql  = "SELECT * FROM form WHERE filter='other' ";
         }
          else{
        $sql = " SELECT * from form";
      }
      }
     

     $sql .= " order by added desc ";
    $result = mysqli_query ($db, $sql);

    //Stabilim cate linii vrem sa fie afisate pe pagina
    $rowperpage = 10;

    //Aflam numarul evenimentelor(liniilor) din baza de date
    $cou = mysqli_num_rows($result);
    echo $cou." ";

    //Aflam numarul total al paginilor
    $totalpages = $cou / $rowperpage;
    $c=$cou % $rowperpage;
    if($c)
    {     
         $totalpages= $totalpages+1;
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
    $counter = "SELECT * FROM form order by added desc limit $page1,10; ";
    $result = mysqli_query ($db, $counter);
  
              
    if (mysqli_num_rows ($result) > 0) {

      //Obtine pagina curenta 
        if(isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
          $currentpage = (int) $_GET['currentpage'];  
        }
        else{
          //pagina de start a arhivei
          $currentpage = 1;
        }


        //Verificam daca pagina curenta are numarul mai mare decat numarul total de pagini
        if($currentpage > $totalpages){
          //setam pagina curenta la ultima pagina
          $currentpage = $totalpages;
        }

        //Verificam daca pagina curenta e mai mica decat prima pagina
        if($currentpage < 1){
          //setam pagina la prima pagina 
          $currentpage = 1;
        }

        //Lista de pagini, in functie de pagina curenta
        $offset = ($currentpage - 1) * $rowperpage;



        //Algoritmul folosit pentru a se afisa indexul potrivit fiecarui eveniment
        if($page1 == 0) $ind = 1;
          else     $ind=($page1-1)*10 + 1;


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
    
    for($b=1; $b <= $totalpages ; $b++)
    {
        ?><a href="arhiva.php?page=<?php echo $b; ?>" style="text-decoration:none "><?php echo $b." "; ?></a> <?php
    }

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