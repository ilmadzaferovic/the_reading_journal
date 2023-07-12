var DnfService = {
  init: function () {

    DnfService.list();

  },

  submit: function (a, b, c) {
    console.log("here");
    var formData = $("#addDnfForm")[0];
    var entity = Object.fromEntries((new FormData(formData)).entries());
    DnfService.add(entity);

  },


  list: function () {
    $.ajax({
      url: `rest/user/${window.localStorage.getItem('userId')}/dnf`,
      type: "GET",
      beforeSend: function (xhr) {
        xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
      },
      success: function (data) {
        $("#dnf-card").html("");
        var html = "";
        for (let i = 0; i < data.length; i++) {
          html += `
          <div class="col-lg-3">
          <div class="card" style="max-width: 18rem;"">
          <img src="`+ data[i].dcover + `" class="card-img-top" id="cover-img" onerror="this.src='images/placeholder.jpg';">
        <div class="card-body">
          <h5 class="card-title">`+ data[i].b_title + `</h5>
          <p class="card-text">Published: `+ data[i].b_published + `</p>
          <p class="card-text">Author: `+ data[i].b_author + `</p>
          <p class="card-text">Genre: `+ data[i].b_genre + `</p>
        </div>
        <hr></hr>
        <div class="card-body">
        <p class="card-text"><b>DNF-ed on: `+ data[i].dnf_date + `</b></p>
        <p class="card-text"><b>Reason: `+ data[i].reason + `</b></p>
        <div class="btn-group" role="group">      
        <button type="button" class="btn btn-outline-danger dnf-button" data-bs-toggle="modal" data-bs-target="#editDnfModal" onclick="DnfService.get(`+ data[i].id + `)">Edit</button>
        <button type="button" class="btn btn-danger  btn-sm dnf-button" onclick="DnfService.delete(`+ data[i].id + `)">Delete</button>
        </div>
        </div>
        </div>
        </div>
          `;
        }
        $("#dnf-card").html(html);
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        //toastr.error(XMLHttpRequest.responseJSON.message);
        UserService.logout();
      }
    });
  },

  get: function (id) {
    $('.dnf-button').attr('disabled', true);
    $.ajax({
      url: "rest/dnf/" + id,
      type: "GET",
      beforeSend: function (xhr) {
        xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
      },
      success: function (data) {
        $("#id").val(data.id);
        $("#b_title").val(data.b_title);
        $("#dnf_date").val(data.dnf_date);
        $("#reason").val(data.reason);
        $("#b_published").val(data.b_published);
        $("#b_author").val(data.b_author);
        $("#b_genre").val(data.b_genre);
        $("#editDnfModal").modal("show");
        $('.dnf-button').attr('disabled', false);
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        toastr.error(XMLHttpRequest.responseJSON.message);
        UserService.logout();
      },
    });
  },

  add: function (dnf) {

    if (dnf.dcover.size = 0) {
      dnf.dcover = null;
      this.sendAddRequest(dnf);
    } else { // convert image to base64 first
      var reader = new FileReader();
      reader.readAsDataURL(dnf.dcover);
      var parent = this;
      reader.onload = function () {
        console.log(reader.result);
        dnf.dcover = reader.result;
        parent.sendAddRequest(dnf);
      };
      reader.onerror = function (error) {
        console.log('Error: ', error);
      };
    }

  },

  sendAddRequest: function (dnf) {
    dnf["user_id"] = window.localStorage.getItem('userId');
    $.ajax({
      url: 'rest/dnf',
      type: 'POST',
      data: JSON.stringify(dnf),
      beforeSend: function (xhr) {
        xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
      },
      contentType: "application/json",
      dataType: "json",
      success: function (result) {
        $("#dnf-card").html('<div class="spinner-border" role="status"> <span class="sr-only"></span>  </div>');
        DnfService.list(); // perf optimization
        $("#addDnfModal").modal("hide");
        $('.modal-backdrop').remove();
        setTimeout(function () {
          $('body').removeAttr('style');
        }, 500);
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        toastr.error(XMLHttpRequest.responseJSON.message);
        UserService.logout();
      },
    });
  },



  update: function () {
    $('.save-dnf-button').attr('disabled', true);
    var dnf = {};


    dnf.b_title = $('#b_title').val();
    dnf.dnf_date = $('#dnf_date').val();
    dnf.reason = $('#reason').val();
    dnf.b_published = $('#b_published').val();
    dnf.b_author = $('#b_author').val();
    dnf.b_genre = $('#b_genre').val();


    $.ajax({
      url: 'rest/dnf/' + $('#id').val(),
      type: 'PUT',
      data: JSON.stringify(dnf),
      beforeSend: function (xhr) {
        xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
      },
      contentType: "application/json",
      dataType: "json",
      success: function (result) {
        $("#editDnfModal").modal("hide");
        $('.save-dnf-button').attr('disabled', false);
        $("#dnf-card").html('<div class="spinner-border" role="status"> <span class="sr-only"></span>  </div>');
        $('.modal-backdrop').remove();
        setTimeout(function () {
          $('body').removeAttr('style');
        }, 500);
        DnfService.list(); // perf optimization
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        toastr.error(XMLHttpRequest.responseJSON.message);
        UserService.logout();
      },
    });
  },

  delete: function (id) {
    $('.dnf-button').attr('disabled', true);
    $.ajax({
      url: 'rest/dnf/' + id,
      type: 'DELETE',
      beforeSend: function (xhr) {
        xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
      },
      success: function (result) {
        $("#dnf-card").html('<div class="spinner-border" role="status"> <span class="sr-only"></span>  </div>');
        DnfService.list();
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        toastr.error(XMLHttpRequest.responseJSON.message);
        UserService.logout();
      },
    });
  },

  redirect: function () {

    window.location.replace("#view_books");
  },

  redirectDnf: function () {

    window.location.replace("dnf.html");
  },


}