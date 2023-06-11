var BookService = {
  init: function(){
    // $('#addBookForm').validate({
    //   debug: true,
    //   submitHandler: function(form) {
    //     var entity = Object.fromEntries((new FormData(form)).entries());
    //     BookService.add(entity);
    //   }
    // });
     BookService.list();

  },

  submit: function(a, b, c){
    console.log("here");
    var formData = $("#addBookForm")[0];
    var entity = Object.fromEntries((new FormData(formData)).entries());
    BookService.add(entity);

  },


  list: function(){
    $.ajax({
      url: "rest/book",
      type: "GET",
      beforeSend: function(xhr){
        xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
      },
      success: function(data) {
      $("#book-card").html("");
      var html = "";
      for(let i = 0; i < data.length; i++){
        html += `
        <div class="col-lg-3">
          <div class="card" style="max-width: 18rem;"">
            <img src="`+ data[i].cover +`" class="card-img-top" id="cover-img" onerror="this.src='images/placeholder.jpg';">
            <div class="card-body">
              <h5 class="card-title">`+ data[i].title +`</h5>
              <p class="card-text">Published on: `+ data[i].published +`</p>
              <p class="card-text">Author: `+ data[i].author +`</p>
              <p class="card-text">Genre: `+ data[i].genre +`</p>
            </div>
            <div class="card-body">
            <div class="btn-group" role="group">
              
            <button type="button" class="btn btn-dark"  onclick="ReviewService.list_by_book_id(`+data[i].id+`)">Manage Reviews</button>
            <button type="button" class="btn btn-outline-dark book-button" data-bs-toggle="modal" data-bs-target="#editBookModal" onclick="BookService.get(`+data[i].id+`)">Edit</button>
            <button type="button" class="btn btn-outline-danger btn-sm book-button" onclick="BookService.delete(`+data[i].id+`)">Delete</button>
            </div>
            </div>
            </div>
          </div>
        `;
      }
      $("#book-card").html(html);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      toastr.error(XMLHttpRequest.responseJSON.message);
      UserService.logout();
    }
    });
  },

  get: function(id){
    $('.book-button').attr('disabled', true);
    $.ajax({
      url: "rest/book/"+id,
      type: "GET",
      beforeSend: function(xhr){
        xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
      },
      success: function(data){
      $("#id").val(data.id);
      $("#genre").val(data.genre);
      $("#title").val(data.title);
      $("#published").val(data.published);
      $("#author").val(data.author);
      $("#editBookModal").modal("show");
      $('.book-button').attr('disabled', false);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      toastr.error(XMLHttpRequest.responseJSON.message);
      UserService.logout();
    },
  });
  },

  add: function(book){

    if(book.cover.size = 0) {
      book.cover = null;
      this.sendAddRequest(book);
    } else { // convert image to base64 first
      var reader = new FileReader();
      reader.readAsDataURL(book.cover);
      var parent = this;
      reader.onload = function () {
        console.log(reader.result);
        book.cover = reader.result;
        parent.sendAddRequest(book);
      };
      reader.onerror = function (error) {
        console.log('Error: ', error);
      };
    }
    
  },

  sendAddRequest: function(book){
    $.ajax({
      url: 'rest/book',
      type: 'POST',
      beforeSend: function(xhr){
        xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
      },
      data: JSON.stringify(book),
      contentType: "application/json",
      dataType: "json",
      success: function(result) {
          $("#book-card").html('<div class="spinner-border" role="status"> <span class="sr-only"></span>  </div>');
          BookService.list(); // perf optimization
          $("#addBookModal").modal("hide");
          $('.modal-backdrop').remove();
          setTimeout(function(){
            $('body').removeAttr( 'style' );
          }, 500);
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        toastr.error(XMLHttpRequest.responseJSON.message);
        UserService.logout();
      }
    });
  },

  update: function(){
    $('.save-book-button').attr('disabled', true);
    var book = {};

    
    book.genre = $('#genre').val();
    book.title = $('#title').val();
    book.published = $('#published').val();
    book.author = $('#author').val();
   

    $.ajax({
      url: 'rest/book/'+$('#id').val(),
      type: 'PUT',
      beforeSend: function(xhr){
        xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
      },
      data: JSON.stringify(book),
      contentType: "application/json",
      dataType: "json",
      success: function(result) {
          $("#editBookModal").modal("hide");
          $('.save-book-button').attr('disabled', false);
          $("#book-card").html('<div class="spinner-border" role="status"> <span class="sr-only"></span>  </div>');
          $('.modal-backdrop').remove();
          setTimeout(function(){
            $('body').removeAttr( 'style' );
          }, 500);
          BookService.list(); // perf optimization
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        // toastr.error(XMLHttpRequest.responseJSON.message);
        UserService.logout();
      }
    });
  },

  delete: function(id){
    $('.book-button').attr('disabled', true);
    $.ajax({
      url: 'rest/book/'+id,
      type: 'DELETE',
      beforeSend: function(xhr){
        xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
      },
      success: function(result) {
          $("#book-card").html('<div class="spinner-border" role="status"> <span class="sr-only"></span>  </div>');
          BookService.list();
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        toastr.error(XMLHttpRequest.responseJSON.message);
        UserService.logout();
      }
    });
  },

 

  
}