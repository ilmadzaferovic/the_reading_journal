var RegisterService = {
    init: function(){
      $('#registerForm').validate({
        debug: true,
        submitHandler: function(form) {
          var entity = Object.fromEntries((new FormData(form)).entries());
          RegisterService.add(entity);
        }
      });
  
    },
  
    submit: function(a, b, c){
      console.log("here");
      var formData = $("#registerForm")[0];
      var entity = Object.fromEntries((new FormData(formData)).entries());
      RegisterService.add(entity);
  
    },
  
    add: function(user){
      $.ajax({
        url: 'rest/register',
        type: 'POST',
        data: JSON.stringify(user),
        contentType: "application/json",
        dataType: "json",
        success: function(result) {
            setTimeout(() => {
              window.location.replace("login.html");
            }, 1000);
        }
      });
    },
  
   
  
    
  }