
var js_file = document.createElement('script');
js_file.type = 'text/javascript';
js_file.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyA43_YU5c2vAR-_xUelUAoMIiRPI42ByNU&libraries=places';
document.getElementsByTagName('head')[0].appendChild(js_file);

function initialize() {
    var input = document.getElementById("adresa");
    var autocomplete = new google.maps.places.Autocomplete(input);
}

    google.maps.event.addDomListener(window, 'load', initialize);

