$(document).ready(function() {
  loadSuperModulos();
  submit();
});
function loadSuperModulos(){
  var idSm = $("#id_supermod").val();
  $.ajax({
    data: {},
    type: "post",
    dataType: "json",
    url: "model/load_superModulos.php",
    success: function (data) {
      for (var i = 0; i < data.length; i++) {
        if (data[i].id_supermodulo == idSm) {
          $("#id_supermodulo").append(
            '<option value="'+data[i].id_supermodulo+'" title="'+data[i].descripcion+'" data-icon="'+data[i].imagen+'" selected>'+data[i].nombre+'</option>'
          );
        }else {
          $("#id_supermodulo").append(
            '<option value="'+data[i].id_supermodulo+'" title="'+data[i].descripcion+'" data-icon="'+data[i].imagen+'">'+data[i].nombre+'</option>'
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
  $('#frm-modulo').on('submit', function(event) {
    $(document).skylo('start');
    setTimeout(function () {
      $(document).skylo('set', 50);
    }, 150);
    event.preventDefault();
    var error = false;
    var data_form = $(this).serializeArray();
    $.ajax({
      data: data_form,
      type: "post",
      dataType: "json",
      url: "model/edit_modulo.php",
      success: function (data) {
        $('html, body').animate({scrollTop: 0}, 'slow');
        setTimeout(function () {
          $(document).skylo('end');
        }, 300);
        $("#message").empty();
        if (data[0].error == true) {
          $("#message").append(
            '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert">&times;</a>Ocurrio un Error, por favor verifique e intente nuevamente.</div>'
          );
          console.log(data);
        }else {
          $("#message").append(
            '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a>El Registro se Guardo con Éxito.</div>'
          );
        }
      },
      error: function (data) {
        console.log("error");
        console.log(data);
      }
    });
  });
}
