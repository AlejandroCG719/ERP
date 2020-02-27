$(document).ready(function() {
  loadPuestos();
  loadEmpleados();
  submit()
});
function loadPuestos(){
  var idP= $("#idP").val();
  $.ajax({
    data: {tabla:"cat_perfiles"},
    type: "post",
    dataType: "json",
    url: "model/load_catalogo.php",
    success: function (data) {
      for (var i = 0; i < data.length; i++) {
        if (data[i].id == idP) {
          $("#id_perfil").append(
            '<option value="'+data[i].id+'" title="'+data[i].caracteristica+'" selected>'+data[i].nombre+'</option>'
          );
        }else {
          $("#id_perfil").append(
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

function loadEmpleados(){
  var idE= $("#idE").val();
  $.ajax({
    data: {},
    type: "post",
    dataType: "json",
    url: "model/load_empleado.php",
    success: function (data) {
      for (var i = 0; i < data.length; i++) {
        if (data[i].id == idE) {
          $("#id_empleado").append(
            '<option value="'+data[i].id+'" title="'+data[i].puesto+'" selected>'+data[i].nombre+'</option>'
          );
        }else {
          $("#id_empleado").append(
            '<option value="'+data[i].id+'" title="'+data[i].puesto+'">'+data[i].nombre+'</option>'
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
  $('#frm-usuario').on('submit', function(event) {
    $(document).skylo('start');
    setTimeout(function () {
      $(document).skylo('set', 50);
    }, 150);
    event.preventDefault();
    var data_form = $(this).serializeArray();
    $.ajax({
      data: data_form,
      type: "post",
      dataType: "json",
      url: "model/edit_usuario.php",
      success: function (data) {
        console.log(data);
        setTimeout(function () {
          $(document).skylo('end');
        }, 300);
        $("#message").empty();
        if (data[0].error== "duplicado") {
          $("#message").append(
            '<div class="alert alert-warning"><a href="#" class="close" data-dismiss="alert">&times;</a>El nombre de usuario ya existe, favor de elegir otro.</div>'
          );
        }else if (data[0].error==true) {
          $("#message").append(
            '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert">&times;</a>Ocurrio un Error, por favor verifique e intente nuevamente.</div>'
          );
        }else {
          $("#message").append(
            '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a>El Registro se Guardo con Éxito.</div>'
          );
        }
        $('html, body').animate({scrollTop: 0}, 'slow');
      },
      error: function (data) {
        console.log("error");
        console.log(data);
      }
    });
  });
}
