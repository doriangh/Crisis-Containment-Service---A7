  function onSignIn(googleUser) 
{
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
        document.getElementById("status").innerHTML = profile.getName() + ' ' + id;
        document.getElementById('id').value = profile.getId();
        document.getElementById('name').value = profile.getName();
        document.getElementById("report").style.display = 'block';
    }
    else{
        document.getElementById('status').innerHTML = 'error';
        document.getElementById('report').style.display = 'none';
    }
    
//  alert(profile.getName() + ', you can now report!');   
    
   
    
    $.post("../report.php", id, function (data){
        alert(data);
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
      
      function logout()
      {
          sessionStorage.clear();
      }
      


