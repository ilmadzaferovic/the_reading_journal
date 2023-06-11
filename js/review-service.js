

var ReviewService = {

  test: function() {
    var formData = $("#addReviewForm")[0];
    var entity = Object.fromEntries((new FormData(formData)).entries());
    this.add(entity);
  }, 

  add: function(reviews){
    $.ajax({
      url: 'rest/reviews',
      type: 'POST',
      beforeSend: function(xhr){
        xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
      },
      data: JSON.stringify(reviews),
      contentType: "application/json",
      dataType: "json",
      success: function(result) {
        // append to the list
        $("#book-review").append(`<div class="list-group-item book-review-`+result.id+`">
          <button type="button" class="btn btn-outline-dark float-right btn-sm book-review-" onclick="ReviewService.get(`+result.id+`)" >Edit</button>
          <button type="button" class="btn btn-outline-dark float-right btn-sm book-review-" onclick="ReviewService.delete(`+result.id+`)" >Delete</button>
          <p class="list-group-item-text">`+result.read_date+`</p>
          <p class="list-group-item-text">`+result.characters+`</p>
          <p class="list-group-item-text">`+result.plot+`</p>
          <p class="list-group-item-text">`+result.moments+`</p>
          <p class="list-group-item-text">`+result.rating+`</p>
        </div>`);
        
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        // toastr.error(XMLHttpRequest.responseJSON.message);
        UserService.logout();
      },
    });
  },

  list_by_book_id: function(book_book_id){
    $("#book-review").html('loading ...');
    $.ajax({
      url: "rest/book/"+book_book_id+"/reviews",
      type: "GET",
      beforeSend: function(xhr){
        xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
      },
      success: function(data) {
      var html = "";
      for(let i = 0; i < data.length; i++){
        html += `<div class="list-group-item book-review-`+data[i].id+`">
          <button type="button" class="btn btn-outline-dark float-right btn-sm book-review-" onclick="ReviewService.get(`+data[i].id+`,` + book_book_id + `)" >Edit</button>
          <button type="button" class="btn btn-outline-danger float-right btn-sm book-review-" onclick="ReviewService.delete(`+data[i].id+`)" >Delete</button>
          <p class="list-group-item-text">I've finished this book on: `+data[i].read_date+`</p>
          <p class="list-group-item-text">Notable characters: `+data[i].characters+`</p>
          <p class="list-group-item-text">Plot summary: `+data[i].plot+`</p>
          <p class="list-group-item-text">Favourite moments: `+data[i].moments+`</p>
          <p class="list-group-item-text">I rate this book: `+data[i].rating+`</p>
        </div>`;
      }
      
      $("#book-review").html(html);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      // toastr.error(XMLHttpRequest.responseJSON.message);
      UserService.logout();
    }
    });

    // note id populate and form validation
    $('#addReviewForm input[name="book_book_id"]').val(book_book_id);
    $('#addReviewForm input[name="read_date"]').val(ReviewService.current_date());

    $('#addReviewForm').validate({
      submitHandler: function(form) {
        var entity = Object.fromEntries((new FormData(form)).entries());
        ReviewService.add(entity);
        $('#addReviewForm input[name="read_date"]').val("");
        $('#addReviewForm input[name="characters"]').val("");
        $('#addReviewForm input[name="plot"]').val("");
        $('#addReviewForm input[name="moments"]').val("");
        $('#addReviewForm input[name="rating"]').val("");
        
      }
    });
    $("#reviewModal").modal('show');
  },

  delete: function(id){
    var old_html = $("#book-review").html();
    $('.book-review-'+id).remove();
   
    $.ajax({
      url: 'rest/reviews/'+id,
      type: 'DELETE',
      beforeSend: function(xhr){
        xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
      },
      success: function(result) {
      
        
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        // toastr.error(XMLHttpRequest.responseJSON.message);
        UserService.logout();
      }
    });
  },

  get: function(id, bookId){
    $('.book-review-').attr('disabled', true);
    $.ajax({
      url: "rest/reviews/"+id,
      type: "GET",
      beforeSend: function(xhr){
        xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
      },
      success: function(data){
      $("#id").val(data.id);
      $("#hiddenBookId").val(bookId);
      $("#read_date").val(data.read_date);
      $("#characters").val(data.characters);
      $("#plot").val(data.plot);
      $("#moments").val(data.moments);
      $("#rating").val(data.rating);
      $("#editReviewModal").modal("show");
      $('.book-review-').attr('disabled', false);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      toastr.error(XMLHttpRequest.responseJSON.message);
      UserService.logout();
    },
  });
  },

  update: function(){
    $('.save-review-button').attr('disabled', true);
    var reviews = {};

    reviews.read_date = $('#read_date').val();
    reviews.characters = $('#characters').val();
    reviews.plot = $('#plot').val();
    reviews.moments = $('#moments').val();
    reviews.rating = $('#rating').val();
   

    $.ajax({
      url: 'rest/reviews/'+$('#id').val(),
      type: 'PUT',
      beforeSend: function(xhr){
        xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
      },
      data: JSON.stringify(reviews),
      contentType: "application/json",
      dataType: "json",
      success: function(result) {
        var bookId = $('#hiddenBookId').val();
          $("#editReviewModal").modal("hide");
          
          $('.save-review-button').attr('disabled', false);
          // $('.modal-backdrop').remove();
          setTimeout(function(){
            $('body').removeAttr( 'style' );
            $('body').addClass('modal-open')
          }, 1000);

          $("#book-review").html('<div class="spinner-border" role="status"> <span class="sr-only"></span>  </div>');
         
          ReviewService.list_by_book_id(bookId); // perf optimization
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        toastr.error(XMLHttpRequest.responseJSON.message);
        UserService.logout();
      },
    });
  },

  current_date: function(){
    const today = new Date();
    const yyyy = today.getFullYear();
    let mm = today.getMonth() + 1; // Months start at 0!
    let dd = today.getDate();

    if (dd < 10) dd = '0' + dd;
    if (mm < 10) mm = '0' + mm;

    return yyyy+"-"+mm+"-"+dd;
  }

}