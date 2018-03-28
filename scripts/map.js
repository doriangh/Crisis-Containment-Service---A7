document.addEventListener('DOMContentLoaded', function() {
    
   if (document.querySelectorAll('#map').length > 0){
       
       if (document.querySelector('html').lang)
           lang = document.querySelector('html').lang;
       else
           lang = 'en';
   
    
    var js_file = document.createElement('script');
    js_file.type = 'text/javascript';
    js_file.src = 'https://maps.googleapis.com/maps/api/js?callback=initMap&signed_in=true&language=' + lang;
    document.getElementsByTagName('head')[0].appendChild(js_file);

   }
});

var js_file = document.createElement('script');
js_file.type = 'text/javascript';
js_file.src = 'https://maps.googleapis.com/maps/api/js?callback=initMap&signed_in=true&key=AIzaSyA43_YU5c2vAR-_xUelUAoMIiRPI42ByNU&language=' + lang;
document.getElementsByTagName('head')[0].appendChild(js_file);

var map, infoWindow;
      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 47.1739724, lng: 27.5749111},
          zoom: 20
        });
          
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
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {

          handleLocationError(false, infoWindow, map.getCenter());
        }
          
          var continut = 'Hello!';
          
          var pozitie = {
              lat: 47.1650759,
              lng: 27.5817583
          }
          
           var marker = new google.maps.Marker({
            position: pozitie, 
            map: map,
            title: 'Testing markers!'
            
        });
          marker.addListener ('click', function() {
            infoWindow.open(map, marker);
        });
          
          
      }

      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
      }
      