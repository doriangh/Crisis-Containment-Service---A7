  function onSignIn(googleUser) {
  var profile = googleUser.getBasicProfile();
  console.log('ID: ' + profile.getId()); 
  console.log('Name: ' + profile.getName());
  console.log('Image URL: ' + profile.getImageUrl());
  console.log('Email: ' + profile.getEmail());
  
  var myUserEntity = {};
  myUserEntity.Id = profile.getId();
  myUserEntity.Name = profile.getName();
  
  //Store the entity object in sessionStorage where it will be accessible from all pages of your site.
  sessionStorage.setItem('myUserEntity',JSON.stringify(myUserEntity));
    
     var id = profile.getId();
    
    if (profile.getName()){
//        document.getElementById('status').style.display = 'block';
//        document.getElementById("status").innerHTML = profile.getName() + ' ' + id;
        document.getElementById('titlu').innerHTML = "Buna, " + profile.getName();
        document.getElementById('id').value = profile.getId();
        document.getElementById('name').value = profile.getName();
        document.getElementById("report").style.display = 'block';
        document.getElementById('signout').style.display = 'block';
        document.getElementById('signin').style.display = 'none';
    }
    else{
        
        document.getElementById('status').innerHTML = 'error';
        document.getElementById('report').style.display = 'none';
        document.getElementById('signout').style.display = 'none';
        
    }
    
//  alert(profile.getName() + ', you can now report!');   
    

}
     

function renderButton() {
    gapi.signin2.render('my-signin2', {
        'scope' : 'profile email',
        'width' : 240,
        'height' : 50,
        'longtitle' : false,
        'theme' : 'light',
        'onsuccess' : onSignIn,
        'text' : 'kdkadk'

    });
}



      function checkLogin() {
          if (sessionStorage.getItem('myUserEntity') == null) {
              window.location.href = '../templates/index.php';
              document.getElementById('status') = nope;
          } else {
              var userEntity = {};
              userEntity = JSON.parse(sessionStorage.getItem('myUserEntity'));
          }
      }
      
   
function signOut() {
    
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
        document.getElementById('titlu').innerHTML = "Ultimele noutati";
        document.getElementById('report').style.display = 'none';
        document.getElementById('status').style.display = 'none';
        document.getElementById('signout').style.display = 'none';
        document.getElementById('signin').style.display = 'block';
        console.log('User signed out.');
    });
    
}

