function initMap() {
                var uluru = {
                    lat: -28. 024,
                    lng: 140.044
                };
                
                var map = new google.maps.Map(document.getElementById('map'),
                {
                    
                    zoom: 4,
                    center: uluru
                }
                                             
                                );
                
                var marker = new google.maps.Marker({
                    position: uluru,
                    map: map
                });
            }