   function openNav() {
            document.getElementById("meniu").style.width = "250px";
            document.body.style.backgroundColor = "rgba (0,0,0,0.4)";
        }
        
        function closeNav() {
            document.getElementById("meniu").style.width = "0";
            document.body.style.backgroundColor = "#70665c";
        }
        
        var menu = document.getElementById ("meniu");
        window.onclick = function(event) {
            if (event.target == menu) {
                closeNav();
            }
        }