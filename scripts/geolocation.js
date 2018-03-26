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

function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 47.1739724, lng: 27.5749111},
          zoom: 10
        });
        var geocoder = new google.maps.Geocoder();
          
            geocodeAddress(geocoder, map);
          
      }

      function geocodeAddress(geocoder, resultsMap) {
          
        var query = window.location.search;
        var data = query.split('=');

        var address = data[1];
        geocoder.geocode({'address': address}, function(results, status) {
          if (status === 'OK') {
            resultsMap.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
              map: resultsMap,
              position: results[0].geometry.location
            });
          } else {
            alert('Geocode was not successful for the following reason: ' + status);
          }
        });
      }