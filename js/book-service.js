var BookService = {

    init: function(){
      $('#addBookForm').validate({
        submitHandler: function(form) {
          var entity = Object.fromEntries((new FormData(form)).entries());
          BookService.add(entity);
        }
      });
      BookService.list();
    },
  
    list: function(){
      $.get("rest/book", function(data) {
        $("#book-card").html("");
        var html = "";
        for(let i = 0; i < data.length; i++){
          html += `
          <div class="col-lg-3">
          <div class="card">
            <img class="card-img-top" src="`+ data[i].cover +`" alt="Card image cap">
            <div class="card-body">
            <strong class="d-inline-block mb-2 text-primary">`+ data[i].genre +`</strong>
            <h3 class="mb-0">`+ data[i].title +`</h3>
            <div class="mb-1 text-muted">`+ data[i].published +`</div>
            <p class="card-text mb-auto">`+ data[i].author +`</p>
              <div class="btn-group" role="group">
              <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addReviewModal" >Add Review</button>
              <button type="button" class="btn btn-outline-primary" onclick="BookService.get_reviews(`+data[i].book_id+`)">View Review</button>
              <button type="button" class="btn btn-outline-primary book-button">Edit</button>
              <button type="button" class="btn btn-outline-danger btn-sm book-button" onclick="BookService.delete(`+data[i].book_id+`)">Delete</button>
              </div>
            </div>
          </div>
        </div>
          `;
        }
        $("#book-card").html(html);
      });
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

    get_reviews: function(book_id){
      $("#viewReviewModal").modal('show');
    },

    delete: function(book_id){
      $('.book-button').attr('disabled', true);
      $.ajax({
        url: 'rest/book/'+book_id,
        type: 'DELETE',
        success: function(result) {
            $("#book-card").html('<div class="spinner-border" role="status"> <span class="sr-only"></span>  </div>');
            BookService.list();
        }
      });
    },
  
  }