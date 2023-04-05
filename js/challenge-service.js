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

  test: function(a, b, c){
    console.log("here");
    var formData = $("#addChallengeForm")[0];
    var entity = Object.fromEntries((new FormData(formData)).entries());
    ChallengeService.add(entity);

  },


  list: function(){
    $.get("rest/challenges", function(data) {
      $("#challengeField").html("");
      var html = "";
      for(let i = 0; i < data.length; i++){
        html += `
        <div>
        
        <input class="form-check-input" type="checkbox" value="" id="check" required>
        <p class="d-inline" id="description">`+data[i].description+`</p>
        <div class="btn-group float-right" role="group" >
  <button type="button" class="btn btn-outline-dark float-right btn-sm challenge-btn" onclick="ChallengeService.get(`+data[i].id+`)" >Edit</button>
  <button type="button" class="btn btn-outline-dark float-right btn-sm challenge-btn" onclick="ChallengeService.delete(`+data[i].id+`)" >Delete</button>
</div>
       
      </div>
        `;
      }
      $("#challengeField").html(html);
    });
  },

  

  get: function(id){
    $('.challenge-btn').attr('disabled', true);
    $.get('rest/challenges/'+id, function(data){
      $("#id").val(data.id);
      $("#description").val(data.description);
      $("#editChallengeModal").modal("show");
      $('.challenge-btn').attr('disabled', false);
    })
  },

  add: function(challenges){
    $.ajax({
      url: 'rest/challenges',
      type: 'POST',
      data: JSON.stringify(challenges),
      contentType: "application/json",
      dataType: "json",
      success: function(result) {
          $("#challengeField").html('<div class="spinner-border" role="status"> <span class="sr-only"></span>  </div>');
          ChallengeService.list(); // perf optimization
          $("#ChallengeModal").modal("hide");
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
      contentType: "application/json",
      dataType: "json",
      success: function(result) {
          $("#editChallengeModal").modal("hide");
          $('.save-challenge-button').attr('disabled', false);
          $("#challengeField").html('<div class="spinner-border" role="status"> <span class="sr-only"></span>  </div>');
          ChallengeService.list(); // perf optimization
      }
    });
  },

  delete: function(id){
    $('.challenge-btn').attr('disabled', true);
    $.ajax({
      url: 'rest/challenges/'+id,
      type: 'DELETE',
      success: function(result) {
          $("#challengeField").html('<div class="spinner-border" role="status"> <span class="sr-only"></span>  </div>');
          ChallengeService.list();
      }
    });
  },

  
}