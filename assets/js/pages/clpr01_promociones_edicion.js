$(document).ready(function() {
  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd'
  });
  $('[data-toggle="tooltip"]').tooltip();
  loadClientes();
  submit();
  noPromocion();
});
function loadClientes(){
  var id_cliente= $("#cliente").val();
  $.ajax({
    data: {},
    type: "post",
    dataType: "json",
    url: "model/load_clientes.php",
    success: function (data) {
      $("#id_cliente").append(
        '<option selected disabled>Seleccione un Cliente</option>'
      );
      for (var i = 0; i < data.length; i++) {
        if (id_cliente == data[i].id) {
          $("#id_cliente").append(
            '<option value="'+data[i].id+'" title="'+data[i].caracteristica+'" selected>'+data[i].nombre+'</option>'
          );
        }else {
          $("#id_cliente").append(
            '<option value="'+data[i].id+'" title="'+data[i].caracteristica+'">'+data[i].nombre+'</option>'
          );
        }
      }
    },
    error: function (data) {
      console.log("error al cargar los clientes");
      console.log(data);
    }
  });
}
function submit(){
  $('#frm-empleado').on('submit', function(event) {
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
      url: "model/edit_promocion.php",
      success: function (data) {
        console.log(data);
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
        document.getElementById("saveButton").setAttribute("disabled", "");
        $('html, body').animate({scrollTop: 0}, 'slow');
        console.log(data);
      },
      error: function (data) {
        $("#message").append(
          '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert">&times;</a>Ocurrio un Error, por favor verifique e intente nuevamente.</div>'
        )
        console.log("error");
        console.log(data);
      }
    });
  });
}
function noPromocion(){

  if ($("#valor").val() == "") {
    $.ajax({
      data: {last_id:1},
      type: "post",
      dataType: 'json',
      url: 'model/load_promociones.php',
      success: function (data) {
        var promocion = new Date();
        var dia = promocion.getDate();
        var mes = promocion.getMonth()+1; //January is 0!
        var ano = (promocion.getFullYear().toString().substr(-2));
        if(dia<10){
          dia='0'+dia;
        }
        if(mes<10){
          mes='0'+mes;
        }
        var presupuesto = "PM"+ano+mes+dia;
        if (data.length>0) {
          data[0].id++;
          if (data[0].id < 10) {
            presupuesto = presupuesto+"00"+data[0].id;
          }else if (data[0].id < 100) {
            presupuesto = presupuesto+"0"+data[0].id;
          }
        }else {
          presupuesto = presupuesto+"001";
        }
        $("#valor").val(presupuesto);
      },
      error: function (data) {
        console.log("error generar el presupuesto");
        console.log(data);
      }
    });
  }
}
