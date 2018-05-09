document.addEventListener('DOMContentLoaded', function() {
    
   if (document.querySelectorAll('#map').length > 0){
       
       if (document.querySelector('html').lang)
           lang = document.querySelector('html').lang;
       else
           lang = 'en';
   
    
    var js_file = document.createElement('script');
    js_file.type = 'text/javascript';
    js_file.src = 'https://maps.googleapis.com/maps/api/js?callback=initMap&signed_in=true&key=AIzaSyA43_YU5c2vAR-_xUelUAoMIiRPI42ByNU&language=' + lang;
    document.getElementsByTagName('head')[0].appendChild(js_file);

   }
});

var js_file = document.createElement('script');
js_file.type = 'text/javascript';
js_file.src = 'https://maps.googleapis.com/maps/api/js?callback=initMap&signed_in=true&key=AIzaSyA43_YU5c2vAR-_xUelUAoMIiRPI42ByNU&language=' + lang;
document.getElementsByTagName('head')[0].appendChild(js_file);

var map, infoWindow;
      function initMap() {
        var map = new google.maps.Map(document.getElementById("map"), {
          center: {lat: 47.1740, lng: 27.5749},
          zoom: 15
        });
          
          //Adaugam toate sesizarile din BD
           var script = document.createElement('script');
          
          script.src = '../datafile/oras.js';
          document.getElementsByTagName('head')[0].appendChild(script);
      
          
          window.eqfeed_callback = function (results) {
            for (var i = 0; i < results.features.length; i++) {
                  var coords = results.features[i].geometry.coordinates;
                  var latLng = new google.maps.LatLng(coords[1], coords[0]);
            
        
                var title = results.features[i].geometry.sesizare;
                    
                    var marker = new google.maps.Marker ({
                      position: latLng,
                      map: map,
                      title: name
                  });
                
                
                var content = '<h1> <strong>' + results.features[i].geometry.sesizare + '</strong> </h1> <br>' + results.features[i].geometry.descriere + '<br> <br>';
                
                var infoWindow = new google.maps.InfoWindow()
                  
                google.maps.event.addListener(marker, 'click', (function (marker, content, infoWindow){
                    return function() {
                        infoWindow.setContent (content);
                        infoWindow.open(map, marker);
                    };
                })(marker, content, infoWindow));
                
              }
          }
          
          
          
          //Centram pe pozitia curenta.
          
        infoWindow = new google.maps.InfoWindow;

        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };

            infoWindow.setPosition(pos);
            infoWindow.setContent('Va aflati aici.');
            infoWindow.open(map);
            map.setCenter(pos);
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {

         handleLocationError(false, infoWindow, map.getCenter());
        }
          
          
      }

      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
      }
      