var ChallengeService = {
  init: function(){
    $('#addChallengeForm').validate({
      debug: true,
      submitHandler: function(form) {
        var entity = Object.fromEntries((new FormData(form)).entries());
        ChallengeService.add(entity);
      }
    });
     ChallengeService.list();

  },

  submit: function(a, b, c){
    console.log("here");
    var formData = $("#addChallengeForm")[0];
    var entity = Object.fromEntries((new FormData(formData)).entries());
    ChallengeService.add(entity);
    $('#addChallengeForm').trigger("reset");

  },


  list: function(){
    $.ajax({
      url: `rest/user/${window.localStorage.getItem('userId')}/challenge`,
      type: "GET",
      beforeSend: function(xhr){
        xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
      },
      success: function(data) {
      $("#challengeField").html("");
      var html = "";
      for(let i = 0; i < data.length; i++){
        html += `
        
        <div>
        <input class="form-check-input" type="checkbox" value="" id="check" required>
        <p class="d-inline" id="xdescription">`+data[i].description+`</p>
        <div class="btn-group float-end" role="group" >
  <button type="button" class="btn btn-outline-dark float-right btn-sm challenge-btn" onclick="ChallengeService.get(`+data[i].id+`)" >Edit</button>
  <button type="button" class="btn btn-outline-danger" float-right btn-sm challenge-btn" onclick="ChallengeService.delete(`+data[i].id+`)" >Delete</button>
  </div>

</div>
      
        `;
      }
      $("#challengeField").html(html);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      toastr.error(XMLHttpRequest.responseJSON.message);
      UserService.logout();
    }
    });
  },

  

  get: function(id){
    $('.challenge-btn').attr('disabled', true);
    $.ajax({
      url: "rest/challenges/"+id,
      type: "GET",
      beforeSend: function(xhr){
        xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
      },
      success: function(data){
      $("#id").val(data.id);
      $("#description").val(data.description);
      $("#editChallengeModal").modal("show");
      $('.challenge-btn').attr('disabled', false);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      toastr.error(XMLHttpRequest.responseJSON.message);
      UserService.logout();
    },
  });
  },

  add: function(challenges){
    challenges["user_id"] = window.localStorage.getItem('userId');
    
    $.ajax({
      url: 'rest/challenges',
      type: 'POST',
      beforeSend: function(xhr){
        xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
      },
      data: JSON.stringify(challenges),
      contentType: "application/json",
      dataType: "json",
      success: function(result) {
          $("#challengeField").html('<div class="spinner-border" role="status"> <span class="sr-only"></span>  </div>');
          ChallengeService.list(); // perf optimization  
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        toastr.error(XMLHttpRequest.responseJSON.message);
        UserService.logout();
      }
    });
  },

  update: function(){
    $('.save-challenge-button').attr('disabled', true);
    var challenges = {};

    challenges.description = $('#description').val();
    
   

    $.ajax({
      url: 'rest/challenges/'+$('#id').val(),
      type: 'PUT',
      data: JSON.stringify(challenges),
      beforeSend: function(xhr){
        xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
      },
      contentType: "application/json",
      dataType: "json",
      success: function(result) {
          $("#editChallengeModal").modal("hide");
          $('.save-challenge-button').attr('disabled', false);
          $("#challengeField").html('<div class="spinner-border" role="status"> <span class="sr-only"></span>  </div>');
          ChallengeService.list(); // perf optimization
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        toastr.error(XMLHttpRequest.responseJSON.message);
        UserService.logout();
      }
    });
  },

  delete: function(id){
    $('.challenge-btn').attr('disabled', true);
    $.ajax({
      url: 'rest/challenges/'+id,
      type: 'DELETE',
      beforeSend: function(xhr){
        xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
      },
      success: function(result)  {
          $("#challengeField").html('<div class="spinner-border" role="status"> <span class="sr-only"></span>  </div>');
          ChallengeService.list();
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        toastr.error(XMLHttpRequest.responseJSON.message);
        UserService.logout();
      }
    });
  },

  
}