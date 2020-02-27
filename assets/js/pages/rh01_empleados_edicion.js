var curp_chk = 0;
var nss_chk = 0;
var cel_chk = 0;
var recados_chk = 0;
var casa_chk = 0;
var cuenta_chk = 0;
var clabe_chk = 0;
var infonavit_chk = 0;
$(document).ready(function() {
  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd'
  });
  validarCurp();
  nssValida();
  loadPuestos();
  loadEstadosMexico();
  submit();
});
function loadPuestos(){
  var idP= $("#puesto").val();
  $.ajax({
    data: {tabla:"cat_puestos"},
    type: "post",
    dataType: "json",
    url: "model/load_catalogo.php",
    success: function (data) {
      for (var i = 0; i < data.length; i++) {
        if (data[i].id == idP) {
          $("#id_puesto").append(
            '<option value="'+data[i].id+'" title="'+data[i].caracteristica+'" selected>'+data[i].nombre+'</option>'
          );
        }else {
          $("#id_puesto").append(
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
  $('#frm-empleado').on('submit', function(event) {
    if (curp_chk == 0) {
      console.log("error en curp");
      error = true;
    }
    if (nss_chk == 0) {
      console.log("error en nss");
      error = true;
    }
    if (error == false) {
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
        url: "model/edit_empleado.php",
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
function loadEstadosMexico(){
  var idEstadoMexico= $("#estadoMexico").val();
  $.ajax({
    data: {tabla:"cat_estados_mexico"},
    type: "post",
    dataType: "json",
    url: "model/load_catalogo.php",
    success: function (data) {
      for (var i = 0; i < data.length; i++) {
        if (data[i].id == idEstadoMexico) {
          $(".load-estados-mex").append(
            '<option value="'+data[i].id+'" title="'+data[i].caracteristica+'" selected>'+data[i].nombre+'</option>'
          );
        }else {
          $(".load-estados-mex").append(
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
function loadMunicipios(id_in, id_out ){
  var valor= $("#"+id_in).val();
  var municipio = $("#id_municipio_mexico").val();
  $.ajax({
    data: {tabla:"cat_municipios_mexico", valor:valor},
    type: "post",
    dataType: "json",
    url: "model/load_catalogo.php",
    success: function (data) {
      $("#"+id_out).empty();
      $("#"+id_out).append(
        '<option selected disabled>Selecciona un municipio</option>'
      );
      for (var i = 0; i < data.length; i++) {
        if (data[i].id == municipio) {
          $("#"+id_out).append(
            '<option value="'+data[i].id+'" title="'+data[i].caracteristica+'" selected>'+data[i].nombre+'</option>'
          );
        }else {
          $("#"+id_out).append(
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
function hijosShow(val){
  var elementos = document.getElementsByClassName("hijos");
  if (val == 1) {
    $("#nombre_hijos").val("");
  }else {
    $("#cant_hijos").val("0");
  }
}
function estadoCivil(){
  var id = $("#id_estado_civil").val();
  if (id == 1 || id == 4 || id == 5) {
    $('#conyugue').val("N/A");
  }else {
    $('#conyugue').val("");
  }
}

function validarCurp() {
  var curp = $("#curp").val();
	var curp = curp.toUpperCase(),
  resultado = $("#res_curp");
  valido = '<i style="color: red;" class="fa fa-times"></i>';
  curp_chk = 0;
  if (curpValida(curp)) {
  	valido = '<i style="color: #08c51f;" class="fa fa-check"></i>';
    curp_chk = 1;
  }
  resultado.empty();
  resultado.append (valido);
}
function curpValida(curp) {
	var re = /^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0\d|1[0-2])(?:[0-2]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/,
  validado = curp.match(re);

  if (!validado)  //Coincide con el formato general?
  	return false;

  //Validar que coincida el dígito verificador
  function digitoVerificador(curp17) {
    //Fuente https://consultas.curp.gob.mx/CurpSP/
    var diccionario  = "0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ",
    lngSuma      = 0.0,
    lngDigito    = 0.0;
    for(var i=0; i<17; i++)
      lngSuma= lngSuma + diccionario.indexOf(curp17.charAt(i)) * (18 - i);
      lngDigito = 10 - lngSuma % 10;
      if(lngDigito == 10)
        return 0;

      return lngDigito;
  }
  if (validado[2] != digitoVerificador(validado[1]))
  	return false;

	return true; //Validado
}

function nssValida() {
  resultado = $("#res_nss");
  var nss = $("#nss").val()
  if (nss.length == 11) {
    valido = '<i style="color: #08c51f;" class="fa fa-check"></i>';
    curp_chk = 1;
  }else {
    valido = '<i style="color: red;" class="fa fa-times"></i>';
    curp_chk = 0;
  }
  resultado.empty();
  resultado.append (valido);
}

function validarTel(id, resultado){
  resultado = $(resultado);
  var cel = $(id).val();
  if (cel.length == 10) {
    valido = '<i style="color: #08c51f;" class="fa fa-check"></i>';
    if (id == "#tel_cel") {
      cel_chk = 1;
    }else if (id == "#tel_recados") {
      recados_chk = 1;
    }else if (id == "#tel_casa") {
      casa_chk = 1;
    }
  }else {
    valido = '<i style="color: red;" class="fa fa-times"></i>';
    if (id == "#tel_cel") {
      cel_chk = 0;
    }else if (id == "#tel_recados") {
      recados_chk = 0;
    }else if (id == "#tel_casa") {
      casa_chk = 0;
    }
  }
  resultado.empty();
  resultado.append (valido);
}
function validarCuenta(){
  resultado = $("#res_cuenta");
  var cuenta = $("#num_cuenta").val();
  if (cuenta.length > 9 && cuenta.length < 12) {
    valido = '<i style="color: #08c51f;" class="fa fa-check"></i>';
    cuenta_chk = 1;
  }else {
    valido = '<i style="color: red;" class="fa fa-times"></i>';
    cuenta_chk = 0;
  }
  resultado.empty();
  resultado.append (valido);
}
function validarClabe(){
  resultado = $("#res_clabe");
  var clabe = $("#clabe").val();
  if (clabe.length == 18) {
    valido = '<i style="color: #08c51f;" class="fa fa-check"></i>';
    clabe_chk = 1;
  }else {
    valido = '<i style="color: red;" class="fa fa-times"></i>';
    clabe_chk = 0;
  }
  resultado.empty();
  resultado.append (valido);
}
function validarInfonavit(){
  resultado = $("#res_infonavit");
  var cred_infonavit = $("#cred_infonavit").val();
  console.log($("#infonavit"));
  console.log(cred_infonavit);
  if ($("#infonavit").val() != 4) {
    if (cred_infonavit.length == 10) {
      valido = '<i style="color: #08c51f;" class="fa fa-check"></i>';
      clabe_chk = 1;
    }else {
      valido = '<i style="color: red;" class="fa fa-times"></i>';
      clabe_chk = 0;
    }
    resultado.empty();
    resultado.append (valido);
  }else {
    resultado.empty();
    $("#cred_infonavit").val("N/A");
    $("#descuento_infonavit").val(0);
  }
}
