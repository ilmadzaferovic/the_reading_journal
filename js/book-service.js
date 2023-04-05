var BookService = {
  init: function(){
    $('#addBookForm').validate({
      debug: true,
      submitHandler: function(form) {
        var entity = Object.fromEntries((new FormData(form)).entries());
        BookService.add(entity);
      }
    });
     BookService.list();

  },

  test: function(a, b, c){
    console.log("here");
    var formData = $("#addBookForm")[0];
    var entity = Object.fromEntries((new FormData(formData)).entries());
    BookService.add(entity);

  },


  list: function(){
    $.get("rest/book", function(data) {
      $("#book-card").html("");
      var html = "";
      for(let i = 0; i < data.length; i++){
        html += `
        <div class="col-lg-3">
          <div class="card">
            <img id="cover-image" class="card-img-top" src="" alt="Card image cap">
            <div class="card-body">
            <strong class="d-inline-block mb-2 text-primary">`+ data[i].genre +`</strong>
            <h3 class="mb-0">`+ data[i].title +`</h3>
            <div class="mb-1 text-muted">`+ data[i].published +`</div>
            <p class="card-text mb-auto">`+ data[i].author +`</p>
              <div class="btn-group" role="group">
              
              <button type="button" class="btn btn-outline-primary"  onclick="ReviewService.list_by_book_id(`+data[i].id+`)">Manage Reviews</button>
              <button type="button" class="btn btn-outline-primary book-button" data-bs-toggle="modal" data-bs-target="#editBookModal" onclick="BookService.get(`+data[i].id+`)">Edit</button>
              <button type="button" class="btn btn-outline-danger btn-sm book-button" onclick="BookService.delete(`+data[i].id+`)">Delete</button>
              </div>
          </div>
        </div>
        </div>
        `;
      }
      $("#book-card").html(html);
    });
  },

  get: function(id){
    $('.book-button').attr('disabled', true);
    $.get('rest/book/'+id, function(data){
      $("#id").val(data.id);
      $("#genre").val(data.genre);
      $("#title").val(data.title);
      $("#published").val(data.published);
      $("#author").val(data.author);
      $("#editBookModal").modal("show");
      $('.book-button').attr('disabled', false);
    })
  },

  add: function(book){
    $.ajax({
      url: 'rest/book',
      type: 'POST',
      data: JSON.stringify(book),
      contentType: "application/json",
      dataType: "json",
      success: function(result) {
          $("#book-card").html('<div class="spinner-border" role="status"> <span class="sr-only"></span>  </div>');
          BookService.list(); // perf optimization
          $("#addBookModal").modal("hide");
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
      data: JSON.stringify(book),
      contentType: "application/json",
      dataType: "json",
      success: function(result) {
          $("#editBookModal").modal("hide");
          $('.save-book-button').attr('disabled', false);
          $("#book-card").html('<div class="spinner-border" role="status"> <span class="sr-only"></span>  </div>');
          BookService.list(); // perf optimization
      }
    });
  },

  delete: function(id){
    $('.book-button').attr('disabled', true);
    $.ajax({
      url: 'rest/book/'+id,
      type: 'DELETE',
      success: function(result) {
          $("#book-card").html('<div class="spinner-border" role="status"> <span class="sr-only"></span>  </div>');
          BookService.list();
      }
    });
  },

  
}