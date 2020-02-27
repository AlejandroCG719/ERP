$(document).ready(function() {
  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd'
  });
  loadClientes();
  loadEstadoIngreso()
  submit();
});

function loadClientes(){
  var id_cliente= $("#cliente").val();
  var b=0;
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
          b = 1;
        }else {
          $("#id_cliente").append(
            '<option value="'+data[i].id+'" title="'+data[i].caracteristica+'">'+data[i].nombre+'</option>'
          );
        }
      }
      if (b==1) {
        loadCotizaciones();
      }
    },
    error: function (data) {
      console.log("error al cargar los clientes");
      console.log(data);
    }
  });
}
function loadCotizaciones(){
  var id = $("#id_cliente").val();
  var presupuesto = $("#presupuesto").val();
  $.ajax({
    data: {id:id},
    type: 'POST',
    dataType: 'json',
    url: 'model/load_cotizaciones.php',
    success: function (data) {
      $("#id_cotizacion").empty();
      $("#id_cotizacion").append(
        '<option selected disabled>Seleccione una promoción</option>'
      );
      if(data != null){
        for (var i = 0; i < data.length; i++) {
          if (presupuesto == data[i].id_cotizacion) {
            $("#id_cotizacion").append(
              '<option value = ' + data[i].id_cotizacion + ' selected>' + data[i].no_presupuesto + '</option>'
            );
          }else {
            document.getElementById("id_cotizacion").removeAttribute("disabled");
            $("#id_cotizacion").append(
              '<option value = ' + data[i].id_cotizacion + '>' + data[i].no_presupuesto + '</option>'
            );
          }
        }
      }
    },
    error: function (data) {
      console.log("error al cargar las cotizaciones");
      console.log(data);
    }
  });
}
function loadEstadoIngreso(){
  var estado = $("#estado_ingreso").val();
  $.ajax({
    data: {tabla:"cat_estado_ingresos"},
    type: 'POST',
    dataType: 'json',
    url: 'model/load_catalogo.php',
    success: function (data) {
      for (var i = 0; i < data.length; i++) {
        if (estado == data[i].id) {
          $("#id_estado_ingresos").append(
            '<option value="'+data[i].id+'" title="'+data[i].caracteristica+'" selected>'+data[i].nombre+'</option>'
          );
        }else {
          $("#id_estado_ingresos").append(
            '<option value="'+data[i].id+'" title="'+data[i].caracteristica+'">'+data[i].nombre+'</option>'
          );
        }
      }
    },
    error: function (data) {
      console.log("error al cargar las promociones");
      console.log(data);
    }
  });
}

function calcTot(){
  var importe = parseFloat($("#importe").val());
  var iva = parseFloat((importe*.16).toFixed(2));
  var sum = importe + iva;
  $("#total").val(sum);
  $("#iva").val(iva);
}

function submit(){
  $('#frm-ingreso').on('submit', function(event) {
    $(document).skylo('start');
    setTimeout(function () {
      $(document).skylo('set', 50);
    }, 150);
    event.preventDefault();
    var elementos = document.getElementsByClassName("form-control");
    for (var i = 0; i < elementos.length; i++) {
      elementos[i].removeAttribute("disabled");
    }
    var data_form = $(this).serializeArray();
    $.ajax({
      data: data_form,
      type: "post",
      dataType: "json",
      url: "model/edit_ingreso.php",
      success: function (data) {
        setTimeout(function () {
          $(document).skylo('end');
        }, 300);
        $("#message").empty();
        if (data[0].error==true) {
          $("#message").append(
            '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert">&times;</a>Ocurrio un Error, por favor verifique e intente nuevamente.</div>'
          );
        }else {
          $("#message").append(
            '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a>El Registro se Guardo con Éxito.</div>'
          );
          for (var i = 0; i < elementos.length; i++) {
            elementos[i].setAttribute("disabled", "");
          }
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
