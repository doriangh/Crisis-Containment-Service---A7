        
        var query = window.location.search;

    if (query.substring(0, 1) == '?') {
        query = query.substring(1);
    }

    var data = query.split('=');
        document.getElementById('header').innerHTML = data[1];
    
