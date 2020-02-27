var id_unico = 0;
var b = 0 ;
var arreglo_beneficiarios = new Array();
$(document).ready(function() {
  $.ajax({
    data: {tabla:"cat_subconcepto_pagos"},
    type: "POST",
    dataType: "json",
    url: "model/load_catalogo.php",
    success: function (data) {
        for (var i = 0; i < data.length; i++) {
          arreglo_beneficiarios[i]= data[i].nombre;
        }
        $('#beneficiario').typeahead({
            name: 'beneficiario',
            local: arreglo_beneficiarios
          });
    },
    error: function (data) {
      console.log("error al cargar beneficiarios");
    }
  });

  $('#plaza').typeahead({
      name: 'plaza',
      local: ['AGU','BCN','BCS','CAM','CHP','CHH','COA','COL','CDMX','DUR','GUA','GRO','HID','JAL','MEX','MIC','MOR','NAY','NLE','OAX','PUE','QUE','ROO','SLP','SIN','SON','TAB','TAM','TLA','VER','YUC','ZAC']
    });

  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd'
  });
  $('[data-toggle="tooltip"]').tooltip();


  submit();
  loadBancos();
  loadConceptosPagos();
  loadEstadoPago();
  loadPromociones();
  folio();
  if ($('#id_finanzas_pago').val() != "") {
    loadPagos();
    loadInfoPagos();
  }
});

function submit(){
  $('#frm-empleado').on('submit', function(event) {
    $("#indice_pagos").val(id_unico);
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
    console.log(data_form);
    $.ajax({
      data: data_form,
      type: "post",
      dataType: "text",
      url: "model/edit_pago.php",
      success: function (data) {
        setTimeout(function () {
          $(document).skylo('end');
        }, 300);
        $('html, body').animate({scrollTop: 0}, 'slow');
        $("#message").empty();
        if (data[0].error==true) {
          $("#message").append(
            '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert">&times;</a>Ocurrio un Error, por favor verifique e intente nuevamente.</div>'
          );
        }else {
          document.getElementById("saveButton").setAttribute("disabled", "");
          $("#message").append(
            '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a>El Registro se Guardo con Éxito.</div>'
          );
          for (var i = 0; i < elementos.length; i++) {
            elementos[i].setAttribute("disabled", "");
          }
        }
      },
      error: function (data) {
        console.log("error");
        console.log(data);
      }
    });
  });
}

function loadBancos(){
  var banco = $("#banco").val();
  var banco_solicitante = $("#solicitante_banco").val();
  $.ajax({
    data: {tabla:"cat_bancos"},
    type: 'POST',
    dataType: 'json',
    url: 'model/load_catalogo.php',
    success: function (data) {
      $("#banco_solicitante").empty();
      $("#banco_solicitante").append('<option selected disabled>Seleccione un banco*</option>');
      for (var i = 0; i < data.length; i++) {
        if (banco == data[i].id) {
          $("#id_banco_"+id_unico).append(
            '<option value="'+data[i].id+'" title="'+data[i].caracteristica+'" selected>'+data[i].nombre+'</option>'
          );
          loadBancoCuentas();
        }else {
          $("#id_banco_"+id_unico).append(
            '<option value="'+data[i].id+'" title="'+data[i].caracteristica+'">'+data[i].nombre+'</option>'
          );
        }
        if (banco_solicitante == data[i].id) {
          $("#banco_solicitante").append(
            '<option value="'+data[i].id+'" title="'+data[i].caracteristica+'" selected>'+data[i].nombre+'</option>'
          );
        }else {
          $("#banco_solicitante").append(
            '<option value="'+data[i].id+'" title="'+data[i].caracteristica+'">'+data[i].nombre+'</option>'
          );
        }
      }
      loadFormaPago();
    },
    error: function (data) {
      console.log("error al cargar los bancos");
      console.log(data);
    }
  });

}
function loadBancoCuentas(id){
  console.log(id);
  var valor = $("#id_banco_"+id).val();
  console.log(valor);
  var banco_cuenta = $("#banco_cuenta_"+id).val();
  console.log(banco_cuenta);
  $.ajax({
    data: {tabla:"cat_banco_cuentas",valor:valor},
    type: "POST",
    dataType: "json",
    url: "model/load_catalogo.php",
    success: function (data) {
      var seccion = "";
      var band = 0;
      $('#id_cuenta_banco_'+id).empty();
      if (data != null){
        $('#id_cuenta_banco_'+id).append('<option value="" selected disabled>Seleccione una Opción</option><optgroup label="Tarjetas de Credito" id="credito_'+id+'"></optgroup><optgroup label="Cuentas" id="cuenta_'+id+'"></optgroup>');
        for (var i = 0; i < data.length; i++) {
          band = 0;
          seccion = "";
          for (var j = 0; j < data[i].caracteristica.length; j++) {
            if (data[i].caracteristica[j] != " " && band == 0) {
              seccion += data[i].caracteristica[j];
            } else {
              band = 1;
            }
          }
          console.log(seccion);
          if (banco_cuenta == data[i].id) {
            if (seccion == "Tarjeta") {
              $('#credito_'+id).append('<option value="'+data[i].id+'" title="'+data[i].caracteristica+'" selected>'+data[i].nombre+'</option>');
            }else {
              $('#cuenta_'+id).append('<option value="'+data[i].id+'" title="'+data[i].caracteristica+'" selected>'+data[i].nombre+'</option>');
            }
          }else {
            if (seccion == "Tarjeta") {
              $('#credito_'+id).append('<option value="'+data[i].id+'" title="'+data[i].caracteristica+'">'+data[i].nombre+'</option>');
            }else {
              $('#cuenta_'+id).append('<option value="'+data[i].id+'" title="'+data[i].caracteristica+'">'+data[i].nombre+'</option>');
            }

          }
        }
      }else{
        $('#id_cuenta_banco_'+id).append('<option value="0" selected disabled>N/A</option>');
      }
    },
    error: function (data) {
      $('#mensajes').append("<div class='alert alert-dismissable alert-danger'> <strong>Oops!</strong> inténtalo de nuevo . <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button> </div>");
    }
  });
}
function loadConceptosPagos(){
  var concepto = $("#concepto_pago").val();
  $.ajax({
    data: {tabla:"cat_concepto_pagos"},
    type: 'POST',
    dataType: 'json',
    url: 'model/load_catalogo.php',
    success: function (data) {
      for (var i = 0; i < data.length; i++) {
        if (concepto == data[i].id) {
          $("#id_concepto_pago").append(
            '<option value="'+data[i].id+'" title="'+data[i].caracteristica+'" selected>'+data[i].nombre+'</option>'
          );
          loadSubconceptosPagos();
        }else {
          $("#id_concepto_pago").append(
            '<option value="'+data[i].id+'" title="'+data[i].caracteristica+'">'+data[i].nombre+'</option>'
          );
        }
      }
    },
    error: function (data) {
      console.log("error al cargar los bancos");
      console.log(data);
    }
  });
}
function loadSubconceptosPagos(){
  var valor = $("#id_concepto_pago").val();
  var subconcepto = $("#subconcepto_pago").val();
  $.ajax({
    data: {tabla:"cat_subconcepto_pagos",valor:valor},
    type: "POST",
    dataType: "json",
    url: "model/load_catalogo.php",
    success: function (data) {
      $('#id_subconcepto').empty();
      if (data != null){
        $('#id_subconcepto').append('<option value="" selected disabled>Seleccione una Opción</option>');
        for (var i = 0; i < data.length; i++) {
          if (subconcepto == data[i].id) {
            $('#id_subconcepto').append('<option value="'+data[i].id+'" title="'+data[i].caracteristica+'"selected>'+data[i].nombre+'</option>');
          }else {
            $('#id_subconcepto').append('<option value="'+data[i].id+'" title="'+data[i].caracteristica+'">'+data[i].nombre+'</option>');
          }
        }
      }else{
        $('#id_subconcepto').append('<option value="0" selected disabled>N/A</option>');
      }
    },
    error: function (data) {
      console.log("error al cargar subconceptos gastos");
      console.log(data);
    }
  });
}
function loadEstadoPago(){
  var estado = $("#estado").val();
  $.ajax({
    data: {tabla:"cat_estado_pagos"},
    type: 'POST',
    dataType: 'json',
    url: 'model/load_catalogo.php',
    success: function (data) {
      for (var i = 0; i < data.length; i++) {
        if (estado == data[i].id) {
          $("#status").append(
            '<option value="'+data[i].id+'" title="'+data[i].caracteristica+'" selected>'+data[i].nombre+'</option>'
          );
        }else {
          $("#status").append(
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
function loadPromociones(){
  var id= $("#promo").val();
  $.ajax({
    data: {},
    type: 'POST',
    dataType: 'json',
    url: 'model/load_promociones.php',
    success: function (data) {
      if(data != null){
        $("#id_promocion").empty();
        $("#id_promocion").append(
          '<option selected disabled>Seleccione una promoción</option>'
        );
        for (var i = 0; i < data.length; i++) {
          if (id == data[i].id) {
            $("#id_promocion").append(
              '<option value = ' + data[i].id + ' selected>' + data[i].nombre + '</option>'
            );
            loadCotizaciones();
          }else {
            $("#id_promocion").append(
              '<option value = ' + data[i].id + '>' + data[i].nombre + '</option>'
            );
          }
        }
      }
    },
    error: function (data) {
      console.log("error al cargar las promociones");
      console.log(data);
    }
  });
}
function loadCotizaciones(){
  var id = $("#id_cot").val();
  var promo = $("#id_promocion").val();
  $.ajax({
    data: {id_promo:promo},
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
          if (id == data[i].id_cotizacion) {
            $("#id_cotizacion").append(
              '<option value = ' + data[i].id_cotizacion + ' selected>' + data[i].no_presupuesto + '</option>'
            );
          }else {
            if ($("#id_pago_solicitud").val()== ""){
              document.getElementById("id_cotizacion").removeAttribute("disabled");
            }
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
function loadFormaPago(){
  //var estado = $("#estado").val();
  $.ajax({
    data: {tabla:"cat_fin_forma_pago"},
    type: 'POST',
    dataType: 'json',
    url: 'model/load_catalogo.php',
    success: function (data) {
      for (var i = 0; i < data.length; i++) {
        if (estado == data[i].id) {
          $("#id_forma_pago_"+id_unico).append(
            '<option value="'+data[i].id+'" title="'+data[i].caracteristica+'" selected>'+data[i].nombre+'</option>'
          );
        }else {
          $("#id_forma_pago_"+id_unico).append(
            '<option value="'+data[i].id+'" title="'+data[i].caracteristica+'">'+data[i].nombre+'</option>'
          );
        }
      }
    },
    error: function (data) {
      console.log("error al cargar forma de pagos");
      console.log(data);
    }
  });
}

function folio(){
  if ($("#id_finanzas_pago").val()==""){
    $.ajax({
      dataType: 'json',
      url: 'model/load_pago_solicitud.php',
      success: function (data) {
        var folio = new Date();
        var dia = folio.getDate();
        var mes = folio.getMonth()+1; //January is 0!
        var ano = (folio.getFullYear().toString().substr(-2));
        if(dia<10){
            dia='0'+dia;
        }
        if(mes<10){
            mes='0'+mes;
        }
        /*Folios segun el id*/
        var recuperado = data[0].id_pago_solicitud++;
        recuperado+=1;
        console.log(recuperado);
        var folio = "FP"+ano+mes+dia+recuperado;

        /*if (data.length>0) {
          data[0].id_pago_solicitud++;
          if (data[0].id_pago_solicitud < 10) {
            folio = folio+"00"+data[0].id_pago_solicitud;
          }else if (data[0].id_pago_solicitud < 100) {
            folio = folio+"0"+data[0].id_pago_solicitud;
          }
        }else {
          folio = folio+"001";
        }*/

        $("#folio").val(folio);
      },
      error: function (data) {
        console.log("error generar el folio");
        console.log(data);
      }
    });
  }
}
function estadoCheck(){
  var elementos = document.getElementsByClassName("sec-2");
  if ($("#status").val() == 2 || $("#status").val() == 4) {
    for (var i = 0; i < elementos.length; i++) {
      elementos[i].removeAttribute("required");
    }
  }else {
    for (var i = 0; i < elementos.length; i++) {
      elementos[i].setAttribute("required", "");
    }
  }
}

function addFormaPago(val){ //agregamos personal y tambien en seccion de prestaciones integrales
  id_unico ++;
  $("#pagos").append(
    '<div class="row borde pago-'+id_unico+'">'+
      '<div class="col-md-3">'+
        '<div class="form-group borde">'+
          '<label class="col-sm-4 control-label">Banco*</label>'+
          '<div class="col-sm-7">'+
            '<input type="hidden" id="banco" value="">'+
            '<select class="form-control selectpicker show-tick sec-2" id="id_banco_'+id_unico+'" name="id_banco_'+id_unico+'" onchange="loadBancoCuentas('+id_unico+')" title="Seleccione un Banco" required tabindex="13">'+
              '<option value="0" selected disabled>Seleccione una Opción</option>'+
            '</select>'+
          '</div>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-3">'+
        '<div class="form-group borde">'+
          '<label class="col-sm-4 control-label">Cuenta banco*</label>'+
          '<div class="col-sm-7">'+
            '<input type="hidden" id="banco_cuenta_'+id_unico+'" value="">'+
            '<select class="form-control selectpicker show-tick sec-2" id="id_cuenta_banco_'+id_unico+'" name="id_cuenta_banco_'+id_unico+'" title="Seleccione una Cuenta" required tabindex="13">'+
              '<option value="0" selected disabled>Seleccione una Opción</option>'+
            '</select>'+
          '</div>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-3">'+
        '<div class="form-group borde">'+
          '<label class="col-sm-4 control-label">Monto*</label>'+
          '<div class="col-sm-7">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="number" class="form-control" id="monto_'+id_unico+'" name="monto_'+id_unico+'" step="0.01" min="0" placeholder="Ingrese el monto" title="Ingrese el monto" tabindex="14" required/>'+
            '</div>'+
          '</div>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-3">'+
        '<div class="form-group borde">'+
          '<label class="col-sm-4 control-label">Forma de pago*</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<select class="form-control" name="id_forma_pago_'+id_unico+'" id="id_forma_pago_'+id_unico+'">'+
                '<option selected disabled>Seleccione una forma de pago</option>'+
              '</select>'+
            '</div>'+
          '</div>'+
          '<div class="col-md-1" id="unico_'+id_unico+'">'+
            '<button type="button" onclick=borrarPago("pago-'+id_unico+'") class="btn btn-danger boton"><i class="fa fa-minus"></i></button>'+
          '</div>'+
        '</div>'+
      '</div>'+
    '</div>'
  );
  if(id_unico>1){
    $("#unico_"+(id_unico-1)).addClass("hidden");
  }
  $("#indice").attr("value", id_unico);
  var indice = $("#indice").val();

  $('[data-toggle="tooltip"]').tooltip();
  if (val != 1) {
    loadBancos();
    loadFormaPago();
  }
}
function borrarPago(id){
  $("."+id).remove();
  id_unico--;
  $("#unico_"+(id_unico)).removeClass("hidden");
  $("#indice").attr("value", id_unico);
}

function loadPagos() {
  var num_pagos = $("#num_pagos").val()-1;
  if (num_pagos > 0) {
    for (var i = 0; i < num_pagos; i++) {
      addFormaPago(1);
    }
  }
}
function loadInfoPagos(){
  var tam = 0;
  var elementos = document.getElementsByClassName("form-control");
  var botones = document.getElementsByClassName("boton");
  var id = $("#id_pago_solicitud").val()
  $.ajax({
    data: {id:id},
    type: "POST",
    dataType: "json",
    url: "model/load_transacciones.php",
    success: function (data) {
      for (var i = 0; i < data.length; i++) {
        $("#id_banco_"+i).empty();
        $("#id_cuenta_banco_"+i).empty();
        $("#id_forma_pago_"+i).empty();
      }
      for (var i = 0; i < data.length; i++) {
        $("#id_banco_"+i).append("<option value='"+data[i].id_banco+" selected'>"+data[i].banco+"</option>");
        $("#id_cuenta_banco_"+i).append("<option value='"+data[i].id_cuenta_banco+" selected'>"+data[i].cuenta+"</option>");
        $("#monto_"+i).val(data[i].monto);
        $("#id_forma_pago_"+i).append("<option value='"+data[i].id_forma_pago+" selected'>"+data[i].forma_pago+"</option>")
      }
    },
    error: function (data) {
      $('#mensajes').append("<div class='alert alert-dismissable alert-danger'> <strong>Oops!</strong> inténtalo de nuevo . <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button> </div>");
    }
  });
  if ($("#id_finanzas_pago").val() != "") {
    for(var i = 0; i < botones.length; i++) {
      botones[i].removeAttribute("onclick");
      botones[i].setAttribute("disabled", "");
    }
    for (var i = 0; i < elementos.length; i++) {
      if (elementos[i].id == "status" && elementos[i].value == 1) {

      }else {
        elementos[i].setAttribute("disabled", "");
        document.getElementById("saveButton").removeAttribute("disabled");
      }
    }
    console.log($("#estado").val());
    if ($("#estado").val() == 1 || $("#estado").val() == 2) {
      document.getElementById("status").removeAttribute("disabled");
      document.getElementById("fecha_deposito").removeAttribute("disabled");
      document.getElementById("saveButton").removeAttribute("disabled")
    }else {
      document.getElementById("saveButton").setAttribute("disabled", "");
    }
  }
}

function noAplica(){
  console.log("entro no aplica");
  var banco_solicitante = $("#banco_solicitante").val();
  if (banco_solicitante == 7) {
    $("#beneficiario").val("N/A");
    $("#cuenta_deposito").val("N/A");
  }
}

/*Seccion de numero a letra */
function Unidades(num){

    switch(num)
    {
        case 1: return 'UN';
        case 2: return 'DOS';
        case 3: return 'TRES';
        case 4: return 'CUATRO';
        case 5: return 'CINCO';
        case 6: return 'SEIS';
        case 7: return 'SIETE';
        case 8: return 'OCHO';
        case 9: return 'NUEVE';
    }

    return '';
}//Unidades()

function Decenas(num){

    let decena = Math.floor(num/10);
    let unidad = num - (decena * 10);

    switch(decena)
    {
        case 1:
            switch(unidad)
            {
                case 0: return 'DIEZ';
                case 1: return 'ONCE';
                case 2: return 'DOCE';
                case 3: return 'TRECE';
                case 4: return 'CATORCE';
                case 5: return 'QUINCE';
                default: return 'DIECI' + Unidades(unidad);
            }
        case 2:
            switch(unidad)
            {
                case 0: return 'VEINTE';
                default: return 'VEINTI' + Unidades(unidad);
            }
        case 3: return DecenasY('TREINTA', unidad);
        case 4: return DecenasY('CUARENTA', unidad);
        case 5: return DecenasY('CINCUENTA', unidad);
        case 6: return DecenasY('SESENTA', unidad);
        case 7: return DecenasY('SETENTA', unidad);
        case 8: return DecenasY('OCHENTA', unidad);
        case 9: return DecenasY('NOVENTA', unidad);
        case 0: return Unidades(unidad);
    }
}//Unidades()

function DecenasY(strSin, numUnidades) {
    if (numUnidades > 0)
        return strSin + ' Y ' + Unidades(numUnidades)

    return strSin;
}//DecenasY()

function Centenas(num) {
    let centenas = Math.floor(num / 100);
    let decenas = num - (centenas * 100);

    switch(centenas)
    {
        case 1:
            if (decenas > 0)
                return 'CIENTO ' + Decenas(decenas);
            return 'CIEN';
        case 2: return 'DOSCIENTOS ' + Decenas(decenas);
        case 3: return 'TRESCIENTOS ' + Decenas(decenas);
        case 4: return 'CUATROCIENTOS ' + Decenas(decenas);
        case 5: return 'QUINIENTOS ' + Decenas(decenas);
        case 6: return 'SEISCIENTOS ' + Decenas(decenas);
        case 7: return 'SETECIENTOS ' + Decenas(decenas);
        case 8: return 'OCHOCIENTOS ' + Decenas(decenas);
        case 9: return 'NOVECIENTOS ' + Decenas(decenas);
    }

    return Decenas(decenas);
}//Centenas()

function Seccion(num, divisor, strSingular, strPlural) {
    let cientos = Math.floor(num / divisor)
    let resto = num - (cientos * divisor)

    let letras = '';

    if (cientos > 0)
        if (cientos > 1)
            letras = Centenas(cientos) + ' ' + strPlural;
        else
            letras = strSingular;

    if (resto > 0)
        letras += '';

    return letras;
}//Seccion()

function Miles(num) {
    let divisor = 1000;
    let cientos = Math.floor(num / divisor)
    let resto = num - (cientos * divisor)

    let strMiles = Seccion(num, divisor, 'UN MIL', 'MIL');
    let strCentenas = Centenas(resto);

    if(strMiles == '')
        return strCentenas;

    return strMiles + ' ' + strCentenas;
}//Miles()

function Millones(num) {
    let divisor = 1000000;
    let cientos = Math.floor(num / divisor)
    let resto = num - (cientos * divisor)

    let strMillones = Seccion(num, divisor, 'UN MILLON DE', 'MILLONES DE');
    let strMiles = Miles(resto);

    if(strMillones == '')
        return strMiles;

    return strMillones + ' ' + strMiles;
}//Millones()

function NumeroALetras(num) {

    let data = {
        numero: num,
        enteros: Math.floor(num),
        centavos: (((Math.round(num * 100)) - (Math.floor(num) * 100))),
        letrasCentavos: '',
        letrasMonedaPlural: 'PESOS ',//'PESOS', 'Dólares', 'Bolívares', 'etcs'
        letrasMonedaSingular:  'PESO ', //'PESO', 'Dólar', 'Bolivar', 'etc'
        letrasMonedaCentavoPlural: '/100',
        letrasMonedaCentavoSingular:  ' /100 '
    };

    if (data.centavos > 0) {
        data.letrasCentavos = ' ' + (function () {
                if (data.centavos == 1)
                  return data.centavos + ' ' + data.letrasMonedaCentavoSingular;
                else
                  return data.centavos + ' ' + data.letrasMonedaCentavoPlural;
            })();
    };

    if(data.enteros == 0)
      $("#monto_letra").val( 'CERO ' + data.letrasMonedaPlural + ' ' + data.letrasCentavos);
    if (data.enteros == 1)
      $("#monto_letra").val( Millones(data.enteros) + ' ' + data.letrasMonedaSingular + ' ' + data.letrasCentavos + ' M.N.');
    else
      $("#monto_letra").val( Millones(data.enteros) + ' ' + data.letrasMonedaPlural + ' ' + data.letrasCentavos + ' M.N.');
}
