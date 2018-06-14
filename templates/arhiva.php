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
            <a href="../templates/adauga.html" class="button" style="color: white;font-size: 20px;width: 100%;">+ Adaugă Eveniment</a>
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
        <option value="Cutremur">Cutremure</option>
        <option value="Incendiu">Incendii </option>
        <option value="Inundatii">Inundații</option>
        <option value="Altceva">Altceva</option>
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
  $sql = " SELECT * from form order by added desc ";
  if(isset($_GET['page']) && is_numeric($_GET['page'])) {
        $currentpage = (int) $_GET['page'];  
        //$sql= "SELECT * FROM form where added>'$data' order by added desc";
      }
      else
	  {
        $currentpage=1;
	  }
	  if(isset($_GET['lastIndex'])){
	  $ultimulIndex =  $_GET['lastIndex'];
	  $sql=" SELECT * FROM form where ID<'$ultimulIndex'-1 order by added desc";
	  }
	  else
	  {
	  $ultimulIndex=0;
	  }
	  
if(isset($_POST['submit']) && $currentpage==1)
        {
          if($_POST['values'] == 'Cutremur')
          {
              $sql  = "SELECT * FROM form WHERE filter='cutremure' order by added desc";
          } 
          elseif ($_POST['values'] == 'Inundatie') {
             $sql  = "SELECT * FROM form WHERE filter='inundatii' order by added desc";
         }
          elseif ($_POST['values'] == 'Incendiu') {
             $sql  = "SELECT * FROM form WHERE filter='incendii' order by added desc";
         }
          elseif ($_POST['values']=='Altceva'){
             $sql  = "SELECT * FROM form WHERE filter='other' order by added desc";
         }
          else{
        $sql = " SELECT * from form";
      }
      }
if(isset($_GET['tip']) && $_GET['tip']!=".")
	{
	$tipNou=$_GET['tip'];
	$sql=" SELECT * FROM form where ID<'$ultimulIndex'-1 and filter = '$tipNou' order by added desc";
    } 
    $result = mysqli_query ($db, $sql);

    //Stabilim cate linii vrem sa fie afisate pe pagina
    $rowperpage = 10;

    //Aflam numarul evenimentelor(liniilor) din baza de date
    $cou = mysqli_num_rows($result);

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


        //Algoritmul folosit pentru a se afisa indexul potrivit fiecarui eveniment
        if($page1 == 0) $ind = 1;
          else     $ind=($page1-1)*10 + 1;


        while ($row = mysqli_fetch_assoc ($result)) {
		if($row["images"]){
           echo "<article class=\"mySlides\" style=\"display:block;\"><br>  
                    <HR WIDTH=98%; SIZE=10; COLOR=grey><br>
                    <h5 id=\"autor\">Autor: " . $row["nume"] . " " . $row["prenume"] . "<br>Data: " . $row["added"] .  "<br>Numar Raportari: " . $row["report"] . "<br>Tipul Evenimentului: " . $row["filter"] . "</h5>
                    <h3>" . $row["sesizari"] . "</h3>
                    <h4 style=\"padding: 0; font-size: 10px;\"> Locatie: " .$row["adresa"] ." </h4>
					<img src=\"uploads/" . $row["images"] . " \" style=\"width:100%;height:50%\" />
                    <p>" . $row["descriere"] . " <br> " . $ind." </p> 
                  </article>";
            echo "<br>";
			if($ind%10==0)break;
            $ind++;
			$last=$row["ID"];
			}
			else
			{
			echo "<article class=\"mySlides\" style=\"display:block;\"><br>  
                    <HR WIDTH=98%; SIZE=10; COLOR=grey><br>
                    <h5 id=\"autor\">Autor: " . $row["nume"] . " " . $row["prenume"] . "<br>Data: " . $row["added"] .  "<br>Numar Raportari: " . $row["report"] . "<br>Tipul Evenimentului: " . $row["filter"] . "</h5>
                    <h3>" . $row["sesizari"] . "</h3>
                    <h4 style=\"padding: 0; font-size: 10px;\"> Locatie: " .$row["adresa"] ." </h4>
                    <p>" . $row["descriere"] . " <br> " . $ind." </p> 
                  </article>";
            echo "<br>";
			if($ind%10==0)break;
            $ind++;
			$last=$row["ID"];	
			}
		}
	if(isset($_POST['submit']) && $currentpage==1)
        {
          if($_POST['values'] == 'cutremure')
          {
              $sql  = "SELECT * FROM form WHERE filter='cutremure' order by added desc";

          } 
          elseif ($_POST['values'] == 'inundatii') {
             $sql  = "SELECT * FROM form WHERE filter='inundatii' order by added desc";

         }
          elseif ($_POST['values'] == 'incendii') {
             $sql  = "SELECT * FROM form WHERE filter='incendii' order by added desc";

         }
          elseif ($_POST['values']=='other'){
             $sql  = "SELECT * FROM form WHERE filter='other' order by added desc";

         }
          else
		  {
        $sql = " SELECT * from form";
		 }
      }
	else
		{
		if(isset($_GET['tip']) && $_GET['tip']!=".")
			{
			$tipNou=$_GET['tip'];
			$sql=" SELECT * FROM form where filter = '$tipNou' order by added desc";
			
			}
		}
$result = mysqli_query ($db, $sql);	
$cou = mysqli_num_rows($result);
$totalpages = (int) ($cou / $rowperpage);
    $c=$cou % $rowperpage;
    if($c)
    {     
         $totalpages= $totalpages+1;
    }	
	if(isset($_GET['tip']) && $_GET['tip']!='.')
		{
		if($currentpage!=(int)$totalpages)
			{
			printf('<a href="arhiva.php?%s"><button type="button" style="background-color: red;">Next</button></a>',
				http_build_query(array('page' => $currentpage+1, 'lastIndex' => $last, 'tip' => $_GET['tip']) + $_GET));
			}
		}
	else
    if(isset($_POST['submit']))
      {
	  $tipCategorie=$_POST['values'];
	  if($currentpage!=(int)$totalpages)
			{
          printf('<a href="arhiva.php?%s"><button type="button" style="background-color: red;">Next</button></a>',
			http_build_query(array('page' => $currentpage+1, 'lastIndex' => $last, 'tip' => $tipCategorie) + $_GET));
			}
      }
      else
	  {
		  if($currentpage!=(int)$totalpages)
		  {
			printf('<a href="arhiva.php?%s"><button type="button" style="background-color: red;">Next</button></a>',
			  http_build_query(array('page' => $currentpage+1, 'lastIndex' => $last, 'tip' => '.') + $_GET));
		  }
	  }
    
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