<!DOCTYPE html>
<html lang="ro">
  <head>
    <title>CriC</title>
    <meta charset="utf-8" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../styles/style.css">
    <link rel="stylesheet" type="text/css" href="../styles/harta.css">
   
  </head>
  <body>
      
      <div class="topnav">
            <a href="../templates/index.php">Acasa</a>
            <a href="../templates/inundatii.html">Inundatii</a>
            <a href="../templates/cutremure.html">Cutremure</a>
            <a href="../templates/incendii.html">Incendii</a>
            <a class="active" href="../templates/new-harta.php">Harta</a>
            <a href="../templates/adauga.html" class="button" style="color: white;font-size: 15px;width: 170px;margin-left: 5px;">+Adauga Eveniment</a>
         
            <form id="searchBtn" class="top-form">
                <input id="textSearch" class="search" type="text" placeholder="Cauta Oras..." required >
                <input class="button-top" type="submit" value="Cauta">
                <script src="../scripts/search-autocomplete.js" defer></script>
            </form>
        </div>
      
<div class="main">
    <hr>
    <div class="sectiune_text">

        <div id="map"></div>
        <script src="../scripts/new-map.js" defer></script>
        <br>
        
        <a href="harta.html"><p>Mergeti la locatia dvs.</p></a>
    
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