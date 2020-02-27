$(document).ready(function() {
  submit();
  loadPromociones();
  loadPuestos();

});
function loadPuestos(){
  var idPersona= $("#personal").val();
  $.ajax({
    data: {tabla:"cat_cot_personal"},
    type: "post",
    dataType: "json",
    url: "model/load_catalogo.php",
    success: function (data) {
      for (var i = 0; i < data.length; i++) {
        if (data[i].id == idPersona) {
          $("#id_personal").append(
            '<option value="'+data[i].id+'" title="'+data[i].caracteristica+'" selected>'+data[i].nombre+'</option>'
          );
        }else {
          $("#id_personal").append(
            '<option value="'+data[i].id+'" title="'+data[i].caracteristica+'">'+data[i].nombre+'</option>'
          );
        }
      }
    },
    error: function (data) {
      console.log("error");
      console.log(data);
    }
  });
}
function loadPromociones(){
  var idP= $("#promo").val();
  $.ajax({
    data: {tabla:"cat_promociones"},
    type: "post",
    dataType: "json",
    url: "model/load_catalogo.php",
    success: function (data) {
      for (var i = 0; i < data.length; i++) {
        if (data[i].id == idP) {
          $("#id_promocion").append(
            '<option value="'+data[i].id+'" title="'+data[i].caracteristica+'" selected>'+data[i].nombre+'</option>'
          );
        }else {
          $("#id_promocion").append(
            '<option value="'+data[i].id+'" title="'+data[i].caracteristica+'">'+data[i].nombre+'</option>'
          );
        }
      }
    },
    error: function (data) {
      console.log("error");
      console.log(data);
    }
  });
}

function submit(){
  var error = false;
  $('#frm-per-prom').on('submit', function(event) {
    if (error == false) {
      $(document).skylo('start');
      setTimeout(function () {
        $(document).skylo('set', 50);
      }, 150);
      event.preventDefault();
      var data_form = $(this).serializeArray();
      console.log(data_form);
      $.ajax({
        data: data_form,
        type: "post",
        dataType: "json",
        url: "model/edit_per_prom.php",
        success: function (data) {
          setTimeout(function () {
            $(document).skylo('end');
          }, 300);
          $("#message").empty();        
          if (data[0].error==true) {
            $("#message").append(
              '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert">&times;</a>Ocurrio un Error, por favor verifique e intente nuevamente.</div>'
            )
          }else {
            $("#message").append(
              '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a>El Registro se Guardo con Éxito.</div>'
            )
          }
          $('html, body').animate({scrollTop: 0}, 'slow');
        },
        error: function (data) {
          console.log("error");
          console.log(data);
        }
      });
    }
  });
}
