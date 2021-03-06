<!DOCTYPE html>
<html lang="ro">
  <head>
    <meta charset="UTF-8">
    <meta name="description" content="Crisis Containment Service">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      
    <title>Harta</title>
    <link rel="stylesheet" type="text/css" href="../styles/style.css">
    <link rel="stylesheet" type="text/css" href="../styles/harta.css">
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
    <hr>
    <div class="sectiune_text">

        <div id="map"></div>
        <script src="../scripts/new-map.js" defer></script>
        
        <br>
        <a href="harta.html"><button>Mergeti la locatia dvs.</button></a>
    
    </div>
</div>
    
      <footer>
        <h1><u>&copy;Tehnologii Web</u></h1>
      </footer>
      
  </body>
    
    
    <?php
    
     session_start();
    
    $db = mysqli_connect ("golar3.go.ro", "tw", "59885236", "CriC"); //Conectam la BD
    
    $sql = "select * from form";

        //Incepem generarea fisierului JSON
        $intro = "eqfeed_callback("; //Necesitate la inceputul JSON de la Google Maps Api
        $outro = ")";
    
        $address = array();
        $coord = array();
        $geometry = array();
        $response = array();
        $features = array();
    
        $result = mysqli_query($db, $sql); 
    
    while ($row = mysqli_fetch_array($result)) {
        
        $latitude = $row['latitude'];
        $longitude = $row['longitude'];
        $oras = $row['adresa'];
        $sesizare = $row['sesizari'];
        $descriere = $row['descriere'];
        
        
        $coords = array((float)$longitude, (float)$latitude);
        
        if ($longitude && $latitude){
            
            $features = array('coordinates' => $coords, 'id' => $oras, 'sesizare' => $sesizare, 'descriere' => $descriere);
            
            $geometry[] = array('geometry' => $features);
            
        }
        
        $response = array('features' => $geometry);
        
}

    $fp = fopen ('../datafile/oras.js', 'w');
    fwrite($fp, $intro);
    fwrite($fp, json_encode($response));
    fwrite($fp, $outro);
    fclose($fp);


?>
    
</html>