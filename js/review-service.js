var ReviewService = {

    init: function(){
      $('#addReviewForm').validate({
        submitHandler: function(form) {
          var entity = Object.fromEntries((new FormData(form)).entries());
          ReviewService.add(entity);
        }
      });
      ReviewService.list();
    },

    list: function(){
        $.get("rest/reviews", function(data) {
          $("#reviewList").html("");
          var html = "";
          for(let i = 0; i < data.length; i++){
            html += `
            <ul class="list-group">
            <li class="list-group-item">I finished this book on:</li>
            <p>`+ data[i].read_date +`</p>
            <li class="list-group-item">Plot Summary</li>
            <p>`+ data[i].plot +`</p>
            <li class="list-group-item">My favourite charachter(s):</li>
            <p>`+ data[i].characters +`</p>
            <li class="list-group-item">Favourite moments:</li>
            <p>`+ data[i].moments +`</p>
            <li class="list-group-item">I rate this book:</li>
            <p>`+ data[i].rating +`</p>
          </ul>
            `;
          }
          $("#reviewList").html(html);
        });
      },

      add: function(reviews){
        $.ajax({
          url: 'rest/reviews',
          type: 'POST',
          data: JSON.stringify(reviews),
          contentType: "application/json",
          dataType: "json",
          success: function(reviews) {
              $("#reviewList").html('<div class="spinner-border" role="status"> <span class="sr-only"></span>  </div>');
              ReviewService.list(); // perf optimization
              $("#addReviewModal").modal("hide");
          }
        });
      },

}