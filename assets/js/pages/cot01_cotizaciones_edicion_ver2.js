/**
* JS cot01_cotizaciones_edicion_ver2,brindr funcionalidades para cotizacion y peticiones hacia el servidor.
* ERP
* @author Ing. Jun Komatzu Chávez.
* @author Ing. Armando Peña González.
* @version 1.0
* @package js
* @final
*/

/**
 *Variable publica para  el contador de seccion de personal y prestaciones integrales.
 *@access public
 *var cont_personal
 */
var cont_personal = 0;
/**
 *Variable publica para contener las secciones que existen de personal.
 *@access public
 *var cont_secc_personal
 */
var cont_secc_personal = 0;
/**
 *Variable publica para el contador de la seccion prima dominical.
 *@access public
 *var cont_prima_dom
 */
var cont_prima_dom = -1; // se usa para salario dominical
var cont_incentivos = 0;
var cont_otros = 0;
var cont_materiales = 0;
var cont_degu = 0;
var cont_pl = 0;
var borrar_seccion = "";
var personal_activo = 1;


$(document).ready(function() {

  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd'
  });
  $('[data-toggle="tooltip"]').tooltip();
  $("#plaza").select2({width: "resolve", tags:["Aguascalientes", "Baja California", "Baja California Sur", "Campeche", "Chiapas", "Chihuahua", "Ciudad de México", "Coahuila", "Colima", "Durango", "Estado de México", "Guanajuato", "Guerrero", "Hidalgo", "Jalisco", "Michoacán", "Morelos", "Nayarit", "Nuevo León", "Oaxaca", "Puebla", "Querétaro", "Quintana Roo", "San Luis Potosí", "Sinaloa", "Sonora", "Tabasco", "Tamaulipas", "Tlaxcala", "Veracruz", "Yucatán", "Zacatecas"]});
  noPresupuesto();
  loadClientes();
  loadEstadosCotizacion();
  loadMateriales();
  loadDegustaciones();

  submit();
});
/**
 * Funcion Listener asignar numero de presupuesto AJAX.
 */
function noPresupuesto(){
  $.ajax({
    data: {last_id:1},
    type: "post",
    dataType: 'json',
    url: 'model/load_cotizaciones.php',
    success: function (data) {
      var presupuesto = new Date();
      var dia = presupuesto.getDate();
      var mes = presupuesto.getMonth()+1; //January is 0!
      var ano = (presupuesto.getFullYear().toString().substr(-2));
      if(dia<10){
          dia='0'+dia;
      }
      if(mes<10){
          mes='0'+mes;
      }
      var presupuesto = "PP"+ano+mes+dia;
      if (data.length>0) {
        data[0].id_cotizacion++;
        if (data[0].id_cotizacion < 10) {
          presupuesto = presupuesto+"00"+data[0].id_cotizacion;
        }else if (data[0].id_cotizacion < 100) {
          presupuesto = presupuesto+"0"+data[0].id_cotizacion;
        }
      }else {
        presupuesto = presupuesto+"001";
      }
      $("#no_presupuesto").val(presupuesto);
    },
    error: function (data) {
      console.log("error generar el presupuesto");
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

    $("#indice_per").val(cont_personal);
    $("#indice_mat").val(cont_materiales);
    $("#indice_dominical").val(cont_prima_dom);
    $("#indice_otros").val(cont_otros);
    $("#indice_degustaciones").val(cont_degu);
    $("#indice_incentivos").val(cont_incentivos);
    $("#indice_pl").val(cont_pl);
    var elementos = document.getElementsByClassName("form-control");
    for (var i = 0; i < elementos.length; i++) {
      elementos[i].removeAttribute("disabled");
    }
    var sbd = document.querySelectorAll('input[id^="sueldo_base_"]'); //sueldo base diario
    for (var i = 0; i < sbd.length; i++) {
      $("#base_sueldo_"+i).val(sbd[i].value);
    }
    if ($('#desglozado').is(':checked')) {
      $('#desglozado').val(1);
    }else {
      $('#desglozado').val(0);
    }
    var data_form = $(this).serializeArray();
    console.log(data_form);
    $.ajax({
      data: data_form,
      type: "post",
      dataType: "script",
      url: "model/edit_cotizacion.php",
      success: function (data) {
        document.getElementById("saveButton").setAttribute("disabled", "");
        console.log(data);
        setTimeout(function () {
          $(document).skylo('end');
        }, 300);
        $('html, body').animate({scrollTop: 0}, 'slow');

      },
      error: function (data) {
        console.log("error");
        console.log(data);

      }
    });
  });
}

function loadClientes(){
  $.ajax({
    data: {},
    type: "post",
    dataType: "json",
    url: "model/load_clientes.php",
    success: function (data) {
      for (var i = 0; i < data.length; i++) {
        $("#id_cliente").append(
          '<option value="'+data[i].id+'" title="'+data[i].caracteristica+'">'+data[i].nombre+'</option>'
        );
      }
    },
    error: function (data) {
      console.log("error al cargar los clientes");
      console.log(data);
    }
  });
}
function loadPromociones(){

  document.getElementById("id_promocion").removeAttribute("disabled");
  var id = $("#id_cliente").val();
  $.ajax({
    data: {id:id},
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
          $("#id_promocion").append(
            '<option value = ' + data[i].id + '>' + data[i].nombre + '</option>'
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
function loadEstadosCotizacion(){
  $.ajax({
    data: {tabla:"cat_estado_cotizacion"},
    type: 'POST',
    dataType: 'json',
    url: 'model/load_catalogo.php',
    success: function (data) {
      for (var i = 0; i < data.length; i++) {
        $("#id_status").append(
          '<option value="'+data[i].id+'" title="'+data[i].caracteristica+'">'+data[i].nombre+'</option>'
        );
      }
    },
    error: function (data) {
      console.log("error al cargar las promociones");
      console.log(data);
    }
  });
}
function loadComisiones(){
  loadPersonalPL(0);
  var id = $("#id_promocion").val();
  console.log(id);
  $.ajax({
    data: {id:id},
    type: 'POST',
    dataType: 'json',
    url: 'model/load_comisiones.php',
    success: function (data) {
      console.log(data);
      $("#com_ag_fija_0").val(data[0].com_ag_per);
      $("#com_ag_otros").val(data[0].com_ag_otros);
      $("#com_ag_mat").val(data[0].com_ag_mat);
      $("#com_ag_degu").val(data[0].com_ag_degu);
      $("#com_ag_eventos_especiales").val(data[0].com_ag_eventos_especiales);
      $("#com_ag_incentivos").val(data[0].com_ag_incentivo);
      $("#carga_social_incentivos").val(data[0].carga_social_incentivos);
      //$("#carga_social_personal_0_0").val(data[0].carga_social);
      calcPersonal();
      loadPersonal(0);
    },
    error: function (data) {
      console.log("error al cargar comisiones");
      console.log();

    }
  });
}
function loadPersonal(id){
  var idProm = $("#id_promocion").val();
  $.ajax({
    data: {id_promocion:idProm},
    type: 'POST',
    dataType: 'json',
    url: 'model/load_personal_promocion.php',
    success: function (data) {
      $("#id_posicion_"+id+"_"+cont_personal).empty();
      $("#id_posicion_"+id+"_"+cont_personal).append(
        '<option disabled selected>Seleccione una Opción</option>'
      );
      for (var i = 0; i < data.length; i++) {
        $("#id_posicion_"+id+"_"+cont_personal).append(
          '<option value="'+data[i].id+'" title="'+data[i].caracteristica+'">'+data[i].personal+'</option>'
        );
      }

    },
    error: function (data) {
      console.log("error al cargar el personal");
      console.log(data);
    }
  });
}
/**
 * Funcion Listener asignar numero de presupuesto AJAX.
 * @param integer id.
 * @returns void
 */
function loadSueldo(id){
  var val = $("#id_posicion_"+id).val();
  $.ajax({
    data: {tabla:"cat_personal_promocion",id:val},
    type: 'POST',
    dataType: 'json',
    url: 'model/load_personal_promocion.php',
    success: function (data) {
      $("#pos_dom_"+cont_prima_dom).val(data[0].personal);
      $("#sueldo_base_"+id).val(data[0].sueldo_base);
      $("#carga_social_personal_"+id).val(data[0].carga_social);
      calcPersonal();
      datosPI(data, id);
      /// seccion prima dominical
      if (cont_prima_dom >= 0) {
        borrarDominical(id);
      }
      if (data[0].personal.search("PD")>-1) {
        addDominical("id_posicion_"+id);
        $("#pos_dom_"+cont_prima_dom).val(data[0].personal);
        $("#dominical_id_personal_"+cont_prima_dom).val(data[0].id);
        calcPrimaDom();
      }
    },
    error: function (data) {
      console.log("error al cargar el personal");
      console.log(data);
    }
  });
  /*
  $.ajax({
    data: {id:val,tabla:"cat_cot_personal"},
    type: 'POST',
    dataType: 'json',
    url: 'model/load_catalogo.php',
    success: function (data) {

    },
    error: function (data) {
    }
  });
  */
}
function loadMateriales(){
  $.ajax({
    data: {tabla:"cat_cot_mat"},
    type: 'POST',
    dataType: 'json',
    url: 'model/load_catalogo.php',
    success: function (data) {
      $("#id_material_"+cont_materiales).append(
        '<option title="Seleccione una Opción" selected disabled>Seleccione una Opción</option>'
      );
      for (var i = 0; i < data.length; i++) {
        $("#id_material_"+cont_materiales).append(
          '<option value="'+data[i].id+'" title="'+data[i].caracteristica+'">'+data[i].nombre+'</option>'
        );
      }
    },
    error: function (data) {
      console.log("error al cargar el personal");
      console.log(data);
    }
  });
}
function loadArticuloPrecio(id){
  var val = $("#id_material_"+id).val();
  console.log(val);
  $.ajax({
    data: {id:val,tabla:"cat_cot_mat"},
    type: 'POST',
    dataType: 'json',
    url: 'model/load_catalogo.php',
    success: function (data) {
      $("#costo_unitario_"+id).val(data[0].valor);
      calcMat();
    },
    error: function (data) {
    }
  });
}
function loadDegustaciones(){
  $.ajax({
    data: {tabla:"cat_cot_degu"},
    type: 'POST',
    dataType: 'json',
    url: 'model/load_catalogo.php',
    success: function (data) {
      $("#id_degustacion_"+cont_degu).empty();
      $("#id_degustacion_"+cont_degu).append(
        '<option title="Seleccione una Opción" selected disabled>Seleccione una Opción</option>'
      );
      for (var i = 0; i < data.length; i++) {
        $("#id_degustacion_"+cont_degu).append(
          '<option value="'+data[i].id+'" title="'+data[i].caracteristica+'">'+data[i].nombre+'</option>'
        );
      }
    },
    error: function (data) {
      console.log("error al cargar el personal");
      console.log(data);
    }
  });
}
function loadPersonalPL(id){
  var val = $("#id_promocion").val();
  $.ajax({
    data: {id_promocion:val},
    type: 'POST',
    dataType: 'json',
    url: 'model/load_personal_promocion.php',
    success: function (data) {
      $("#id_personal_pl_"+cont_pl).empty();
      $("#id_personal_pl_"+cont_pl).append(
        '<option disabled selected>Seleccione una Opción</option>'
      );
      for (var i = 0; i < data.length; i++) {
        $("#id_personal_pl_"+cont_pl).append(
          '<option value="'+data[i].id+'" title="'+data[i].caracteristica+'">'+data[i].personal+'</option>'
        );
      }
    },
    error: function (data) {
      console.log("error al cargar el personal PL");
      console.log(data);
    }
  });
}
function loadSueldoPL(id){
  var val = $("#id_personal_pl_"+id).val();
  $.ajax({
    data: {id:val},
    type: 'POST',
    dataType: 'json',
    url: 'model/load_personal_promocion.php',
    success: function (data) {
      $("#pl_sueldo_base_"+id).val(parseFloat(data[0].sueldo_base).toFixed(2));
      calcPL();
    },
    error: function (data) {
    }
  });
}

function addSeccionPersonal(){
  cont_secc_personal++;
  cont_personal ++;
  $("#seccion_personal").append(
    '<div class="panel panel-midnightblue" id="secc_personal_'+cont_secc_personal+'">'+
      '<div class="panel-heading">'+
        '<h4>'+
          'Datos Cotización Personal'+
        '</h4>'+
        '<div class="options">'+
          '<a href="#myModal" data-toggle="modal" onclick="borrarSeccion('+"'personal_"+cont_secc_personal+"'"+')"><i class="fa fa-times"></i></a>'+
          '<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>'+
        '</div>'+
      '</div>'+
      '<div class="panel-body collapse in">'+
        '<div class="row">'+
          '<div class="col-md-4">'+
            '<div class="form-group">'+
              '<label class="col-sm-5 control-label">Comision agencia fija</label>'+
              '<div class="col-sm-6">'+
                '<div class="input-group">'+
                  '<input type="number" id="com_ag_fija_'+cont_secc_personal+'" name="com_ag_fija_'+cont_secc_personal+'" step=".01" min="0" class="form-control" onchange="calcPersonal()" placeholder="% comisión de agencia" title="Ingrese la comisión de agencia"/>'+
                  '<span class="input-group-addon">%</span>'+
                '</div>'+
              '</div>'+
              '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Porcentaje comisión agencia">'+
                '<span class="fa fa-info-circle"></span>'+
              '</a>'+
            '</div>'+
          '</div>'+
          '<div class="col-md-4">'+
            '<div class="form-group">'+
              '<label class="col-sm-5 control-label">Comision agencia variable</label>'+
              '<div class="col-sm-6">'+
                '<div class="input-group">'+
                  '<input type="number" id="com_ag_din_'+cont_secc_personal+'" name="com_ag_din_'+cont_secc_personal+'" step=".01" min="0" class="form-control" onchange="calcPersonal()" placeholder="% comisión de agencia" title="Ingrese la comisión de agencia"/>'+
                  '<span class="input-group-addon">%</span>'+
                '</div>'+
              '</div>'+
              '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Porcentaje comisión agencia">'+
                '<span class="fa fa-info-circle"></span>'+
              '</a>'+
            '</div>'+
          '</div>'+
        '</div>'+
        '<div class="row borde">'+
          '<div class="col-md-4">'+
            '<div class="form-group">'+
              '<label class="col-sm-5 control-label" style="height:46px">Posición*</label>'+
              '<div class="col-sm-6">'+
                '<select id="id_posicion_'+cont_secc_personal+'_'+cont_personal+'" name="id_posicion_'+cont_secc_personal+'_'+cont_personal+'" class="form-control selectpicker show-tick" title="Seleccione una posición" onchange="loadSueldo('+"'"+cont_secc_personal+"_"+cont_personal+"'"+')" required/>'+
                '</select>'+
              '</div>'+
              '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione la posición">'+
                '<span class="fa fa-info-circle"></span>'+
              '</a>'+
            '</div>'+
          '</div>'+
          '<div class="col-md-4">'+
            '<div class="form-group">'+
              '<label class="col-sm-5 control-label" style="height:46px">Suledo base</label>'+
              '<div class="col-sm-6">'+
                '<div class="input-group">'+
                  '<span class="input-group-addon">$</span>'+
                  '<input type="number" id="sueldo_base_'+cont_secc_personal+'_'+cont_personal+'" name="sueldo_base_'+cont_secc_personal+'_'+cont_personal+'" step=".01" min="0" class="form-control" onchange="calcPersonal()" placeholder="Sueldo base diario" title="Sueldo base diario"/>'+
                '</div>'+
              '</div>'+
              '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Sueldo base diario del puesto">'+
                '<span class="fa fa-info-circle"></span>'+
              '</a>'+
            '</div>'+
          '</div>'+
          '<div class="col-md-4 ">'+
            '<div class="form-group">'+
              '<label class="col-sm-5 control-label" style="height:46px">Carga social</label>'+
              '<div class="col-sm-6">'+
                '<div class="input-group">'+
                  '<input type="number" id="carga_social_personal_'+cont_secc_personal+'_'+cont_personal+'" name="carga_social_personal_'+cont_secc_personal+'_'+cont_personal+'" step=".01" min="0" class="form-control" onchange="calcPersonal()" />'+
                  '<span class="input-group-addon">%</span>'+
                '</div>'+
              '</div>'+
              '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Porcentaje de carga social">'+
                '<span class="fa fa-info-circle"></span>'+
              '</a>'+
            '</div>'+
          '</div>'+

          '<div class="col-md-4">'+
            '<div class="form-group">'+
              '<label class="col-sm-5 control-label" style="height:46px">Apoyo económico</label>'+
              '<div class="col-sm-6">'+
                '<div class="input-group">'+
                  '<span class="input-group-addon">$</span>'+
                  '<input type="number" id="apoyo_'+cont_secc_personal+'_'+cont_personal+'" name="apoyo_'+cont_secc_personal+'_'+cont_personal+'" step=".01" min="0" class="form-control" onchange="calcPersonal()" placeholder="Apoyo económico" title="Apoyo económico"/>'+
                '</div>'+
              '</div>'+
              '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Sueldo base diario del puesto">'+
                '<span class="fa fa-info-circle"></span>'+
              '</a>'+
            '</div>'+
          '</div>'+

          '<div class="col-md-4">'+
              '<div class="form-group">'+
              '<label class="col-sm-5 control-label" style="height:46px">Sueldo diario integrado</label>'+
              '<div class="col-sm-6">'+
                '<div class="input-group">'+
                  '<span class="input-group-addon">$</span>'+
                  '<input type="text" id="cuota_diaria_'+cont_secc_personal+'_'+cont_personal+'" name="cuota_diaria_'+cont_secc_personal+'_'+cont_personal+'" class="form-control" placeholder="Sueldo diario integrado" disabled/>'+
                '</div>'+
              '</div>'+
              '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Sueldo diario integrado (incluye carga social y comision de agencia)">'+
                '<span class="fa fa-info-circle"></span>'+
              '</a>'+
            '</div>'+
          '</div>'+
        '</div>'+
        '<div class="row">'+
          '<div class="col-md-4">'+
            '<div class="form-group">'+
              '<label class="col-sm-5 control-label" style="height:46px">Cantidad*</label>'+
              '<div class="col-sm-6">'+
                '<input type="number" id="cantidad_'+cont_secc_personal+'_'+cont_personal+'" name="cantidad_'+cont_secc_personal+'_'+cont_personal+'" class="form-control" min="0" onchange="calcPersonal()" required/>'+
              '</div>'+
            '</div>'+
          '</div>'+
          '<div class="col-md-4">'+
            '<div class="form-group">'+
              '<label class="col-sm-5 control-label" style="height:46px">Días laborados*</label>'+
              '<div class="col-sm-6">'+
                '<input type="number" id="num_dias_'+cont_secc_personal+'_'+cont_personal+'" name="dias_'+cont_secc_personal+'_'+cont_personal+'" class="form-control dias-laborados" placeholder="Duración en días" min="0" max="1" onchange="calcPersonal()" required/>'+
              '</div>'+
              '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Días laborados">'+
                '<span class="fa fa-info-circle"></span>'+
              '</a>'+
            '</div>'+
          '</div>'+
          '<div class="col-md-4">'+
            '<div class="form-group">'+
              '<label class="col-sm-5 control-label">Total</label>'+
              '<div class="col-sm-5">'+
                '<div class="input-group">'+
                  '<span class="input-group-addon">$</span>'+
                  '<input type="text" id="total_personal_'+cont_secc_personal+'_'+cont_personal+'" name="total_personal_'+cont_secc_personal+'_'+cont_personal+'" class="form-control" placeholder="Total" value="0" disabled/>'+
                '</div>'+
              '</div>'+
              '<div class="col-md-1">'+
                '<button type="button" onclick="addPersonal('+cont_secc_personal+')" class="btn btn-info"><i class="fa fa-plus"></i></button>'+
              '</div>'+
            '</div>'+
          '</div>'+
        '</div>'+
        '<div id="personal_'+cont_secc_personal+'">'+
        '</div>'+
      '</div>'+
    '</div>'
  );
  loadPersonal(cont_secc_personal);
  addPI();
}
function addPersonal(id){ //agregamos personal y tambien en seccion de prestaciones integrales
  cont_personal ++;
  $("#personal_"+id).append(
    '<div class="row borde personal-unico-'+cont_personal+'">'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Posición</label>'+
          '<div class="col-sm-6">'+
            '<select id="id_posicion_'+id+'_'+cont_personal+'" name="id_posicion_'+id+'_'+cont_personal+'" class="form-control selectpicker show-tick" title="Seleccione una posición" onchange="loadSueldo('+"'"+id+"_"+cont_personal+"'"+')" required/>'+
            '</select>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione la posición">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group personal-unico-'+cont_personal+'">'+
          '<label class="col-sm-5 control-label" style="height:46px">Suledo base</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="number" id="sueldo_base_'+id+'_'+cont_personal+'" name="sueldo_base_'+id+'_'+cont_personal+'"  class="form-control " placeholder="Sueldo base diario" title="Sueldo base diario" disabled/>'+
            '</div>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Sueldo base diario del puesto">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4 ">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Carga social</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<input type="number" id="carga_social_personal_'+id+'_'+cont_personal+'" name="carga_social_personal_'+id+'_'+cont_personal+'" step=".01" min="0" class="form-control" onchange="calcPersonal()" disabled/>'+
              '<span class="input-group-addon">%</span>'+
            '</div>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Porcentaje de carga social">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Apoyo económico</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="number" id="apoyo_'+cont_secc_personal+'_'+cont_personal+'" name="apoyo_'+cont_secc_personal+'_'+cont_personal+'" step=".01" min="0" class="form-control" onchange="calcPersonal()" placeholder="Apoyo económico" title="Apoyo económico"/>'+
            '</div>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Sueldo base diario del puesto">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group personal-unico-'+cont_personal+'">'+
          '<label class="col-sm-5 control-label" style="height:46px">Sueldo diario integrado</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="text" id="cuota_diaria_'+id+'_'+cont_personal+'" name="cuota_diaria_'+id+'_'+cont_personal+'" class="form-control" placeholder="Sueldo diario integrado" disabled/>'+
            '</div>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Costo cuota diaria (incluye carga social y comision de agencia)">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
    '</div>'+
    '<div class="row personal-unico-'+cont_personal+'">'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Cantidad*</label>'+
          '<div class="col-sm-6">'+
            '<input type="number" id="cantidad_'+id+'_'+cont_personal+'" name="cantidad_'+id+'_'+cont_personal+'" class="form-control" min="0" onchange="calcPersonal()" required/>'+
          '</div>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Días laborados*</label>'+
          '<div class="col-sm-6">'+
            '<input type="number" id="num_dias_'+id+'_'+cont_personal+'" name="num_dias_'+id+'_'+cont_personal+'" class="form-control dias-laborados" placeholder="Duración en días" min="0" max="10" onchange="calcPersonal()" required/>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Días laborados">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label">Total</label>'+
          '<div class="col-sm-5">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="text" id="total_personal_'+id+'_'+cont_personal+'" name="total_personal_'+id+'_'+cont_personal+'" class="form-control" placeholder="Total" value="0" disabled/>'+
            '</div>'+
          '</div>'+
          '<div class="col-md-1" id="unico_'+cont_personal+'">'+
            '<button type="button" onclick=borrarPersonal("personal-unico-'+cont_personal+'") class="btn btn-danger"><i class="fa fa-minus"></i></button>'+
          '</div>'+
        '</div>'+
      '</div>'+
    '</div>'
  );
  //escondemos boton
  if(cont_personal>1){
    $("#unico_"+(cont_personal-1)).addClass("hidden");
  }
  $('[data-toggle="tooltip"]').tooltip();
  loadPersonal(id);
  addPI();
}
function addPI(){
  $("#puntualidad").append(
    '<div class="row borde dcp-unico-'+cont_personal+'">'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Posición</label>'+
          '<div class="col-sm-6">'+
            '<input type="text" id="pi_posicion_'+cont_personal+'" class="form-control pi_posicion_'+cont_personal+'" disabled/>'+
          '</div>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Porcentaje</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<input type="number" id="pi_puntualidad_'+cont_personal+'" name="pi_puntualidad_'+cont_personal+'" class="form-control" placeholder="Porcentaje despensa" title="Porcentaje despensa" value="10" onchange="calcPersonal()" min="0" max="15" step=".01"/>'+
              '<span class="input-group-addon">%</span>'+
            '</div>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Costo unitario del artículo">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label">Por día</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="text" id="puntualidad_dia_'+cont_personal+'" name="puntualidad_dia_'+cont_personal+'" class="form-control" placeholder="Total" value="0" disabled/>'+
              '<input type="hidden" id="tot-m-'+cont_personal+'"/>'+
            '</div>'+
          '</div>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label">Total</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="text" id="puntualidad_tot_'+cont_personal+'" name="puntualidad_tot_'+cont_personal+'" class="form-control" placeholder="Total" value="0" disabled/>'+
            '</div>'+
          '</div>'+
        '</div>'+
      '</div>'+
    '</div>'
  );
  $("#asistencia").append(
    '<div class="row borde dcp-unico-'+cont_personal+'">'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Posición</label>'+
          '<div class="col-sm-6">'+
            '<input type="text" id="pi_posicion_'+cont_personal+'" class="form-control pi_posicion_'+cont_personal+'"" disabled/>'+
          '</div>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Porcentaje</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<input type="number" id="pi_asistencia_'+cont_personal+'" name="pi_asistencia_'+cont_personal+'" class="form-control" placeholder="Porcentaje despensa" title="Porcentaje despensa" value="10" onchange="calcPersonal()" min="0" max="15" step=".01"/>'+
              '<span class="input-group-addon">%</span>'+
            '</div>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Porcentaje Asistencia">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label">Por día</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="text" id="asistencia_dia_'+cont_personal+'" name="asistencia_dia_'+cont_personal+'" class="form-control" placeholder="Total" value="0" disabled/>'+
              '<input type="hidden" id="tot-m-0"/>'+
            '</div>'+
          '</div>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label">Total</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="text" id="asistencia_tot_'+cont_personal+'" name="asistencia_tot_'+cont_personal+'" class="form-control" placeholder="Total" value="0" disabled/>'+
            '</div>'+
          '</div>'+
        '</div>'+
      '</div>'+
    '</div>'
  );
  $("#despensa").append(
    '<div class="row borde borde dcp-unico-'+cont_personal+'">'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Posición*</label>'+
          '<div class="col-sm-6">'+
            '<input type="text" class="form-control pi_posicion_'+cont_personal+'" disabled/>'+
          '</div>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">UMA</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="number" id="pi_salario_minimo" name="pi_salario_minimo" class="form-control" placeholder="Salario mínimo" title="Salario mínimo" value="80.60" onchange="calcPersonal()" step=".01"/>'+
            '</div>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Salario mínimo">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Porcentaje</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<input type="number" id="pi_porcentaje_despensa_'+cont_personal+'" name="pi_porcentaje_despensa_'+cont_personal+'" class="form-control" placeholder="Porcentaje despensa" title="Porcentaje despensa" value="40" onchange="calcPersonal()" min="0" max="40" step=".01"/>'+
              '<span class="input-group-addon">%</span>'+
            '</div>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Porcentaje del sueldo diario designado a despensa">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label">Por día</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="text" id="despensa_dia_'+cont_personal+'" name="despensa_dia_'+cont_personal+'" class="form-control" placeholder="Total" value="0" disabled/>'+
            '</div>'+
          '</div>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label">Total</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="text" id="despensa_tot_'+cont_personal+'" name="despensa_tot_'+cont_personal+'" class="form-control" placeholder="Total" value="0" disabled/>'+
            '</div>'+
          '</div>'+
        '</div>'+
      '</div>'+
    '</div>'
  );
}
function addDominical(id_select){
  cont_prima_dom ++;
  $("#dominical").append(
    '<div class="row borde prima_dominical '+id_select+'">'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Posición</label>'+
          '<div class="col-sm-6">'+
            '<input type="text" id="pos_dom_'+cont_prima_dom+'" class="form-control" disabled/>'+
            '<input type="hidden" id="dominical_id_personal_'+cont_prima_dom+'" name="dominical_id_personal_'+cont_prima_dom+'" class="form-control"/>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione la posición">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group dcp-unico-'+cont_prima_dom+'">'+
          '<label class="col-sm-5 control-label" style="height:46px">Suledo base</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="text" id="sb_d_'+cont_prima_dom+'" class="form-control" placeholder="Sueldo base diario" title="Sueldo base diario" value="0" disabled/>'+
              '<input type="hidden" id="sbd_dom_'+cont_prima_dom+'" name="dominical_sueldo_base_'+cont_prima_dom+'"/>'+
            '</div>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Sueldo base diario del puesto">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group dcp-unico-'+cont_prima_dom+'">'+
          '<label class="col-sm-5 control-label" style="height:46px">Cuota diaria</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="text" id="cuota_dom_'+cont_prima_dom+'" class="form-control" placeholder="Costo cuota diaria" disabled/>'+
            '</div>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Costo cuota diaria (incluye carga social y comision de agencia)">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
    '</div>'+
    '<div class="row '+id_select+'">'+
    '<div class="col-md-4">'+
      '<div class="form-group">'+
        '<label class="col-sm-5 control-label">Dias Laborados*</label>'+
        '<div class="col-sm-6">'+
          '<input type="text" id="dias_dom_'+cont_prima_dom+'" name="dias_dom_'+cont_prima_dom+'" class="form-control" placeholder="Total" value="0" onchange="calcPrimaDom()"/>'+
        '</div>'+
      '</div>'+
    '</div>'+
    '<div class="col-md-4">'+
      '<div class="form-group">'+
        '<label class="col-sm-5 control-label">Total</label>'+
        '<div class="col-sm-6">'+
          '<div class="input-group">'+
            '<span class="input-group-addon">$</span>'+
            '<input type="text" id="total_dom_'+cont_prima_dom+'" class="form-control" placeholder="Total" value="0" disabled/>'+
          '</div>'+
        '</div>'+
      '</div>'+
    '</div>'+
  '</div>'
  );
  $('[data-toggle="tooltip"]').tooltip();
}
function addIncentivo(){
  cont_incentivos ++;
  $("#incentivo").append(
    '<div class="row borde incentivo-unico-'+cont_incentivos+'">'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Descripción*</label>'+
          '<div class="col-sm-6">'+
            '<input type="text" id="incentivo_descripcion_'+cont_incentivos+'" name="incentivo_descripcion_'+cont_incentivos+'" class="form-control" required/>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione una artículo">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Número de personal</label>'+
          '<div class="col-sm-6">'+
            '<input type="text" id="incentivos_num_personal_'+cont_incentivos+'" name="incentivos_num_personal_'+cont_incentivos+'" class="form-control" placeholder="Número de personal" title="Número de personal" onchange="calcInc()"/>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Número de Personal">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Costo mensual</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="number" id="incentivos_costo_mensual_'+cont_incentivos+'" name="incentivos_costo_mensual_'+cont_incentivos+'" class="form-control" placeholder="Costo mensual" onchange="calcInc()"/>'+
            '</div>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Costo Mensual">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
    '</div>'+
    '<div class="row incentivo-unico-'+cont_incentivos+'">'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Carga social mensual*</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="number" id="incentivos_carga_social_mensual_'+cont_incentivos+'" class="form-control" disabled/>'+
            '</div>'+
          '</div>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label">Total</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="text" id="total_incentivo_'+cont_incentivos+'" name="total_incentivo_'+cont_incentivos+'" class="form-control" placeholder="Total" value="0" disabled/>'+
              '<input type="hidden" id="tot_incentivo_'+cont_incentivos+'"/>'+
            '</div>'+
          '</div>'+
          '<div class="col-md-1" id="inc_'+cont_incentivos+'">'+
            '<button type="button" onclick=borrarIncentivo("incentivo-unico-'+cont_incentivos+'") class="btn btn-danger"><i class="fa fa-minus"></i></button>'+
          '</div>'+
        '</div>'+
      '</div>'+
    '</div>'
  );
  if(cont_incentivos>1){
    $("#inc_"+(cont_incentivos-1)).addClass("hidden");
  }
  $('[data-toggle="tooltip"]').tooltip();
}
function addOtros(){
  cont_otros ++;
  $("#otros").append(
    '<div class="row borde otros-unico-'+cont_otros+'">'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Concepto*</label>'+
          '<div class="col-sm-6">'+
            '<input type="text" id="otros_concepto_'+cont_otros+'" name="otros_concepto_'+cont_otros+'" class="form-control" title="Ingrese el concepto" required/>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el concepto">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Monto individual*</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="number" id="otros_monto_'+cont_otros+'" name="otros_monto_'+cont_otros+'" class="form-control" placeholder="Ingrese el monto" min="0" onchange="calcOtros()" required />'+
            '</div>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el monto">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Cantidad*</label>'+
          '<div class="col-sm-6">'+
            '<input type="number" id="otros_cantidad_'+cont_otros+'" name="otros_cantidad_'+cont_otros+'" class="form-control" placeholder="Cantidad de personas" min="0" onchange="calcOtros()"  required/>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Cantidad de personas a las que se les otorgará">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Total*</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="number" id="otros_total_'+cont_otros+'" name="otros_total_'+cont_otros+'" class="form-control" placeholder="Cantidad de personas" disabled/>'+
            '</div>'+
          '</div>'+
          '<div class="col-md-1" id="otros_'+cont_otros+'">'+
            '<button type="button" onclick=borrarOtros("otros-unico-'+cont_otros+'") class="btn btn-danger"><i class="fa fa-minus"></i></button>'+
          '</div>'+
        '</div>'+
      '</div>'+
    '</div>'
  );
  if(cont_otros>1){
    $("#otros_"+(cont_otros-1)).addClass("hidden");
  }
  $('[data-toggle="tooltip"]').tooltip();
}
function addMaterial(){
  cont_materiales ++;
  $("#material").append(
    '<div class="row borde mat-unico-'+cont_materiales+'">'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Artículo</label>'+
          '<div class="col-sm-6">'+
            '<select class="form-control selectpicker show-tick" id="id_material_'+cont_materiales+'" name="id_material_'+cont_materiales+'" onchange="loadArticuloPrecio('+cont_materiales+')" title="Seleccione un artículo" required/>'+
            '</select>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione un artículo">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group dcp-unico-'+cont_materiales+'">'+
          '<label class="col-sm-5 control-label" style="height:46px">Costo unitario</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="text" class="form-control" id="costo_unitario_'+cont_materiales+'" name="costo_unitario_'+cont_materiales+'" value="0" placeholder="Costo unitario" title="Costo unitario del articulo" onchange="calcMat()"/>'+
            '</div>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Costo unitario del artículo">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group dcp-unico-'+cont_materiales+'">'+
          '<label class="col-sm-5 control-label" style="height:46px">Comisión agencia</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="number" step="0.01" class="form-control" id="com_ag_'+cont_materiales+'" name="com_ag_'+cont_materiales+'" placeholder="Comisión agencia" disabled/>'+
            '</div>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Comision de agencia">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
    '</div>'+
    '<div class="row mat-unico-'+cont_materiales+'">'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Cantidad</label>'+
          '<div class="col-sm-6">'+
            '<input type="number" class="form-control" id="cant_mat_'+cont_materiales+'" name="cant_mat_'+cont_materiales+'" min="0" onchange="calcMat()" required/>'+
          '</div>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label">Total</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="text" class="form-control" id="total_mat_'+cont_materiales+'" name="total_mat_'+cont_materiales+'" value="0" placeholder="Total" disabled/>'+
            '</div>'+
          '</div>'+
          '<div class="col-md-1" id="mat_'+cont_materiales+'">'+
            '<button type="button" onclick=borrarMaterial("mat-unico-'+cont_materiales+'") class="btn btn-danger"><i class="fa fa-minus"></i></button>'+
          '</div>'+
        '</div>'+
      '</div>'+
    '</div>'
  );
  if(cont_materiales>1){
    $("#mat_"+(cont_materiales-1)).addClass("hidden");
  }
  $('[data-toggle="tooltip"]').tooltip();
  loadMateriales();
}
function addDegustacion(){
  cont_degu ++;
  $("#degustaciones").append(
    '<div class="row borde degustacion-unico-'+cont_degu+'">'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Degustación</label>'+
          '<div class="col-sm-6">'+
            '<select id="id_degustacion_'+cont_degu+'" name="id_degustacion_'+cont_degu+'" class="form-control" title="Ingrese la degustación">'+
              '<option selected disabled>Seleccione una opción</option>'+
              '<option value="1">cafe 1oz</option>'+
              '<option value="2">cafe 3oz</option>'+
              '<option value="3">cafe 5oz</option>'+
            '</select>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el nombre de la degustación">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Degustacions x día*</label>'+
          '<div class="col-sm-6">'+
            '<input type="number" id="degu_cantidad_'+cont_degu+'" name="degu_cantidad_'+cont_degu+'" class="form-control" placeholder="Degustaciones por día" onchange="calcDegu()"  required/>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Degustaciones por día">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Costo por unidad*</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="number" id="degu_costo_unidad_'+cont_degu+'" name="degu_costo_unidad_'+cont_degu+'" class="form-control" title="Ingrese el costo total por unidad" onchange="calcDegu()" required/>'+
            '</div>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el costo total por unidad">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Comision agencia</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="text" id="degustacion_comision_'+cont_degu+'" class="form-control" title="Seleccione una posición" disabled/>'+
            '</div>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione la posición">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Total</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="text" id="degu_total_'+cont_degu+'" class="form-control" title="Seleccione una posición" disabled/>'+
            '</div>'+
          '</div>'+
          '<div class="col-md-1" id="degustacion_'+cont_degu+'">'+
            '<button type="button" onclick=borrarDegustacion("degustacion-unico-'+cont_degu+'") class="btn btn-danger"><i class="fa fa-minus"></i></button>'+
          '</div>'+
        '</div>'+
      '</div>'+
    '</div>'
  );
  if(cont_degu>1){
    $("#degustacion_"+(cont_degu-1)).addClass("hidden");
  }
  $('[data-toggle="tooltip"]').tooltip();
  loadDegustaciones();
}

function datosPI(data,id){
  id = id[id.length-1];
  $(".pi_posicion_"+id).val(data[0].nombre);
}

function borrarPersonal(id){
  $("."+id).remove();
  cont_personal--;
  $("#unico_"+(cont_personal)).removeClass("hidden");
  calcTot();
} // borramos personal
function borrarDominical(id){
  id = "id_posicion_" + id;
  var x = document.getElementsByClassName(id);
  if (x.length>0) {
    $("."+id).remove();
  }
  calcTot();
}
function borrarIncentivo(id){
  $("."+id).remove();
  cont_incentivos--;
  $("#inc_"+(cont_incentivos)).removeClass("hidden");
  calcTot();
}
function borrarOtros(id){
  $("."+id).remove();
  cont_otros--;
  $("#otros_"+(cont_otros)).removeClass("hidden");
  calcTot();
}
function borrarMaterial(id){
  $("."+id).remove();
  cont_materiales--;
  $("#mat_"+(cont_materiales)).removeClass("hidden");
  calcTot();
}
function borrarDegustacion(id){
  $("."+id).remove();
  cont_degu--;
  $("#degustacion_"+(cont_degu)).removeClass("hidden");
  calcTot();
}

function calcPersonal(){
  var caf = 0; //comision de agencia fija
  var cad = 0; //comision de agencia variable
  var cd = 0; // cuota diaria
  var cs = 0; // carga social
  var sbd = 0; // sueldo base diario
  var apoyo = 0;// apoyo económico
  var cant = 0; // cantidad de persnal por puesto
  var dl = 0; // dias laborados por puesto
  var total = 0 // total por posicion
  if ($('#desglozado').is(':checked')) {
    var uma = $("#pi_UMA").val();
    var puntualidad_porc = 0;
    var asistencia_porc = 0;
    var despensa_porc = 0;
    var tot_puntualidad = 0;
    var tot_asistencia = 0;
    var tot_despensa = 0;
    for (var i = 0; i <= cont_secc_personal; i++) { // ciclamos las seccion de personal
      caf = $("#com_ag_fija_"+i).val()/100;
      cad = $("#com_ag_din_"+i).val()/100;
      for (var j = 0; j <= cont_personal; j++) { // ciclo para la cantidad de personal
        //asignacion de valores
        sbd = $("#sueldo_base_"+i+"_"+j).val();
        if (apoyo == "") {
          apoyo = 0;
        }
        puntualidad_porc = $("#pi_puntualidad_"+i).val()/100;
        asistencia_porc = $("#pi_asistencia_"+i).val()/100;
        despensa_porc = $("#pi_porcentaje_despensa_"+i).val()/100;
        cs = $("#carga_social_personal_"+i+"_"+j).val()/100+1;
        cant = $("#cantidad_"+i+"_"+j).val();
        dl = $("#num_dias_"+i+"_"+j).val();
        //calculos
        puntualidad_porc = (sbd * puntualidad_porc).toFixed(2);
        asistencia_porc = (sbd * asistencia_porc).toFixed(2);
        despensa_porc = (despensa_porc * uma).toFixed(2);
        cd =  ((parseFloat(sbd * cs) + parseFloat(puntualidad_porc) + parseFloat(asistencia_porc) + parseFloat(despensa_porc)) * (caf + cad + 1)).toFixed(2);
        total = (cant * dl * cd).toFixed(2);
        tot_asistencia = (asistencia_porc * cant * dl).toFixed(2);
        tot_puntualidad = (puntualidad_porc * cant * dl).toFixed(2);
        tot_despensa = (despensa_porc * cant * dl).toFixed(2);
        //mostramos resultados
        $("#cuota_diaria_"+i+"_"+j).val(cd);
        $("#total_personal_"+i+"_"+j).val(total);
        $("#puntualidad_dia_"+j).val(puntualidad_porc);
        $("#asistencia_dia_"+j).val(asistencia_porc);
        $("#despensa_dia_"+j).val(despensa_porc);
        $("#puntualidad_tot_"+j).val(tot_puntualidad);
        $("#asistencia_tot_"+j).val(tot_asistencia);
        $("#despensa_tot_"+j).val(tot_despensa);
      }
    }
  }else {
    for (var i = 0; i <= cont_secc_personal; i++) { // ciclamos las seccion de personal
      caf = $("#com_ag_fija_"+i).val()/100;
      cad = $("#com_ag_din_"+i).val()/100;
      for (var j = 0; j <= cont_personal; j++) { // ciclo para la cantidad de personal
        //asignacion de valores
        sbd = $("#sueldo_base_"+i+"_"+j).val();
        apoyo = $("#apoyo_"+i+"_"+j).val();
        if (apoyo == "") {
          apoyo = 0;
        }
        cs = $("#carga_social_personal_"+i+"_"+j).val()/100+1;
        cant = $("#cantidad_"+i+"_"+j).val();
        dl = $("#num_dias_"+i+"_"+j).val();
        //calculos
        cd =  ((parseFloat(sbd) + parseFloat(apoyo)) * cs * (caf + cad + 1)).toFixed(2);
        total = (cant * dl * cd).toFixed(2);
        //mostramos resultados
        $("#sueldo_base_"+i+"_"+j).val(sbd);
        $("#cuota_diaria_"+i+"_"+j).val(cd);
        $("#total_personal_"+i+"_"+j).val(total);
      }
    }
  }
  calcPrimaDom();
}
function calcPrimaDom(){
  var b = 0;
  var str = "";
  var id_personal = "";
  var id_dominical = "";
  var secc_per = "";
  var sb = 0;
  var cs = 0;
  var caf = 0;
  var cad = 0;
  var cuota_diaria = 0;
  var cant = 0;
  var dld = 0;
  var tot = 0;
  var spd = document.querySelectorAll('input[id^="cuota_dom"]'); //sueldo prima dominical
  var x = document.getElementsByClassName("prima_dominical");
  for (var i = 0; i < spd.length; i++) {
    b = 0;
    id_personal = "";
    id_dominical = "";
    secc_per = "";
    sb = 0;
    cuota_diaria = 0;
    tot = 0;
    str = spd[i].id;
    for (var j = 0; j < str.length; j++) {
      if (str[j]== 0 || str[j]== 1 || str[j]== 2 || str[j]== 3 || str[j]== 4 || str[j]== 5 || str[j]== 6 || str[j]== 7 || str[j]== 8 || str[j]== 9) {
        id_dominical = id_dominical + "" + str[j];
      }
    }
    str = x[i].classList[3];
    for (var j = 0; j < str.length; j++) {
      if ((str[j]== 0 || str[j]== 1 || str[j]== 2 || str[j]== 3 || str[j]== 4 || str[j]== 5 || str[j]== 6 || str[j]== 7 || str[j]== 8 || str[j]== 9) && b==3) {
        id_personal = id_personal + "" + str[j];
      }else if ((str[j]== 0 || str[j]== 1 || str[j]== 2 || str[j]== 3 || str[j]== 4 || str[j]== 5 || str[j]== 6 || str[j]== 7 || str[j]== 8 || str[j]== 9) && b==2) {
        secc_per = secc_per + "" + str[j];
      }else if (str[j] == "_") {
        b++;
      }
    }
    sb = (parseFloat($("#sueldo_base_"+secc_per+"_"+id_personal).val())*.25).toFixed(2);
    apoyo = (parseFloat($("#apoyo_"+secc_per+"_"+id_personal).val())*.25).toFixed(2);
    cs = $("#carga_social_personal_"+secc_per+"_"+id_personal).val()/100;
    caf = $("#com_ag_fija_"+secc_per).val()/100;
    cad = $("#com_ag_din_"+secc_per).val()/100;
    cuota_diaria = ((parseFloat(sb)+ parseFloat(apoyo)) * (cs + 1) * (caf + cad + 1)).toFixed(2); //obtenemos la cuota diaria dominical
    cant = $("#cantidad_"+secc_per+"_"+id_personal).val(); //obtenemos numero de empleados que se requiere
    dld = $("#dias_dom_"+id_dominical).val();
    tot = cuota_diaria * cant * dld;
    $("#sb_d_"+id_dominical).val((parseFloat(sb)+ parseFloat(apoyo)));
    $("#sbd_dom_"+id_dominical).val((parseFloat(sb)+ parseFloat(apoyo)));
    $("#cuota_dom_"+id_dominical).val(cuota_diaria); // mostramos la cuota diaria dominical
    $("#total_dom_"+id_dominical).val(tot.toFixed(2));
  }
  calcTot();
}
function calcInc(){
  var cm = document.querySelectorAll('input[id^="incentivos_costo_mensual_"]');
  var cs = $("#carga_social_incentivos").val()/100+1;
  var ca = $("#com_ag_incentivo").val()/100+1;
  for (var i = 0; i < cm.length; i++) {
    $("#incentivos_carga_social_mensual_"+i).val(($("#incentivos_costo_mensual_"+i).val()*cs).toFixed(2));
    $("#total_incentivo_"+i).val(($("#incentivos_costo_mensual_"+i).val()*cs*ca*$("#incentivos_num_personal_"+i).val()).toFixed(2));
  }
  calcTot();
}
function calcOtros(){
  var otros = document.querySelectorAll('input[id^="otros_monto_"]'); //sueldo base diario
  for (var i = 0; i < otros.length; i++) {
    $("#otros_total_"+i).val(($("#otros_cantidad_"+i).val()*($("#com_ag_otros").val()/100+1)*$("#otros_monto_"+i).val()).toFixed(2));
  }
  tot_proveedor= ($("#pago_proveedor_monto").val()*1.075)*($("#com_ag_pago_proveedor").val()/100+1);
  $("#pago_proveedor_tot").val(tot_proveedor.toFixed(2));
  calcTot();
}
function calcMat(){
  var cu = document.querySelectorAll('input[id^="costo_unitario_"]');
  var tot = 0;
  var cant = 0;
  var pu = 0;
  var ca = 0;
  for (var i = 0; i < cu.length; i++) {
    ca = $("#com_ag_mat").val()/100;
    cant = $("#cant_mat_"+i).val();
    pu = $("#costo_unitario_"+i).val();
    ca = cu[i].value * ca;
    tot = pu * cant + (ca * cant);
    $("#com_ag_"+i).val(ca);
    $("#total_mat_"+i).val(tot.toFixed(2));
  }
  calcTot();
}
function calcDegu(){
  var degustaciones = document.querySelectorAll('select[id^="id_degustacion_"]');
  for (var i = 0; i < degustaciones.length; i++) {
    porcentaje = $("#com_ag_degu").val()/100;
    $("#degustacion_comision_"+i).val((porcentaje*$("#degu_costo_unidad_"+i).val()).toFixed(2));
    porcentaje = porcentaje+1;
    $("#degu_total_"+i).val((porcentaje * $("#degu_costo_unidad_"+i).val() * $("#degu_cantidad_"+i).val() * $("#degu_dias").val()).toFixed(2));
  }
  calcTot();
}
function calcPagoP(){
  tot_proveedor= ($("#pago_proveedor_monto").val()* ($("#facturaje").val()/100+1))*($("#com_ag_pago_proveedor").val()/100+1);
  $("#pago_proveedor_tot").val(tot_proveedor.toFixed(2));
  calcTot();
}
function calcPL(){
  var cu = document.querySelectorAll('input[id^="pl_num_personal_"]');
  var sb = 0;
  var mm= 0;
  var md = 0;
  var mdp = 0;
  var tot = 0;
  var cant = 0;
  var pu = 0;
  var ca = $("#pl_comision_agencia").val()/100+1;
  var cs = $("#pl_carga_social").val()/100+1;
  for (var i = 0; i < cu.length; i++) {
    sb = $("#pl_sueldo_base_"+i).val();
    $("#pl_monto_meses_"+i).val((sb*$("#meses_liquidacion_"+i).val()*30).toFixed(2));
    $("#pl_monto_dias_"+i).val((sb*$("#dias_x_anio_"+i).val()).toFixed(2));
    $("#pl_monto_dias_prima_"+i).val((sb*$("#dias_prima_vacacional_"+i).val()*.25).toFixed(2));
    mm = $("#pl_monto_meses_"+i).val();
    md = $("#pl_monto_dias_"+i).val();
    mdp = $("#pl_monto_dias_prima_"+i).val();
    tot = parseFloat(mm)+parseFloat(md)+parseFloat(mdp);
    $("#pl_total_unitario_"+i).val(tot.toFixed(2));
    $("#pl_total_cant_"+i).val((tot*$("#pl_num_personal_"+i).val()).toFixed(2));
    $("#pl_total_com_"+i).val((tot*$("#pl_num_personal_"+i).val()*cs).toFixed(2));
  }
  calcTot();
}
function calcTot(){
  //calculo personal
  var tot_personal = 0;
  var totales = document.querySelectorAll('input[id^="total_personal_"]');
  for (var i = 0; i < totales.length; i++) {
    tot_personal += parseFloat(totales[i].value);
  }
  totales = document.querySelectorAll('input[id^="total_dom_"]');
  for (var i = 0; i < totales.length; i++) {
    tot_personal += parseFloat(totales[i].value);
  }
  if(true == isNaN(tot_personal)){
    tot_personal=0;
  }
  $("#total_personal").val(format2(tot_personal,"$"));
  //fin calculo Personal
  //calculo material
  var tot_material = 0;
  totales = document.querySelectorAll('input[id^="total_mat_"]');
  for (var i = 0; i < totales.length; i++) {
    tot_material += parseFloat(totales[i].value);
  }
  if(true == isNaN(tot_material)){
    tot_material=0;
  }
  $("#total_mat").val(format2(tot_material,"$"));
  //fin calculo materiales
  //calculo incentivos
  var tot_incentivos = 0;
  tot_incentivos = parseFloat(tot_incentivos);
  totales = document.querySelectorAll('input[id^="total_incentivo_"]');
  for (var i = 0; i < totales.length; i++) {
    tot_incentivos += parseFloat(totales[i].value);
  }
  if(true == isNaN(tot_incentivos)){
    tot_incentivos=0;
  }
  $("#total_inc").val(format2(tot_incentivos,"$"));
  //fin calculo incentivos
  //calculo otros
  var tot_otros = 0;
  tot_otros = parseFloat(tot_otros);
  totales = document.querySelectorAll('input[id^="otros_total_"]');
  for (var i = 0; i < totales.length; i++) {
    tot_otros += parseFloat(totales[i].value);
  }
  if(true == isNaN(tot_otros)){
    tot_otros=0;
  }
  $("#total_otros").val(format2(tot_otros,"$"));
  // fin calculo otros
  // calculo Degustaciones
  var tot_degustaciones = 0;
  tot_degustaciones = parseFloat(tot_degustaciones);

  totales = document.querySelectorAll('input[id^="degu_total_"]');
  for (var i = 0; i < totales.length; i++) {
    tot_degustaciones += parseFloat(totales[i].value);
  }
  if(true == isNaN(tot_degustaciones)){
    tot_degustaciones=0;
  }
  $("#total_degustaciones").val(format2(tot_degustaciones,"$"));
  // fin calculo degustaciones
  // total pago proveedor
  var tot_pago_proveedor = parseFloat($("#pago_proveedor_tot").val());
  if(true == isNaN(tot_pago_proveedor)){
    tot_pago_proveedor=0;
  }
  $("#total_pago_proveedor").val(format2(tot_pago_proveedor,"$"));
  // fin pago proveedor
  // tot pasivo Laboral
  var tot_pas_lab = 0;
  totales = document.querySelectorAll('input[id^="pl_total_com_"]');
  for (var i = 0; i < totales.length; i++) {
    tot_pas_lab += parseFloat(totales[i].value);
  }
  if(true == isNaN(tot_pas_lab)){
    tot_pas_lab=0;
  }
  $("#total_pasivo_laboral").val(format2(tot_pas_lab,"$"))
  //fin total pasivo Laboral
  var total_final = tot_incentivos + tot_material + tot_personal + tot_otros + tot_degustaciones + tot_pago_proveedor + tot_pas_lab;
  if(true == isNaN(total_final)){
    total_final=0;
  }
  $("#total_final").val(format2(total_final,"$"));

}
function calcCS(){
  var sal_min = 88.36;
  var sbd = 0;
  var sd = 0;
  var sdp = 0;
  var prestaciones = 0;
  var cuota_imss = 0;
  var cuota_inf = 0;
  var aguinaldo = parseFloat($("#dias_aguinaldo").val());
  var gratificacion = parseFloat($("#dias_gratificacion").val());
  var vacaciones = parseFloat($("#dias_vacaciones").val());
  var dias_mes = parseFloat($("#dias_mes").val());
  var riesgo_trabajo = parseFloat(($("#riesgo_trabajo").val()/100).toFixed(7));
  var patronal = 0;
  var subtot = 0;
  for (var i = 0; i <= cont_secc_personal; i++) { // ciclamos las seccion de personal
    for (var j = 0; j <= cont_personal; j++) { // ciclo para la cantidad de personal
      //asignacion de valores
      patronal = 0;
      sbd = $("#sueldo_base_"+i+"_"+j).val();
      if (sbd == "") {
        sbd = 0;
      }
      apoyo = $("#apoyo_"+i+"_"+j).val();
      if (apoyo == "") {
        apoyo = 0;
      }
      sd = parseFloat(sbd) + parseFloat(apoyo);
      prestaciones = parseFloat((((sbd * aguinaldo)/(dias_mes * 12)) + ((sbd * gratificacion)/(dias_mes * 12)) + ((sbd * vacaciones)/(dias_mes * 12)) + (((sbd * vacaciones)/(dias_mes * 12)) * 0.25)).toFixed(2));
      sdp = sd + prestaciones;
      if ( (sdp > (sal_min * 3) )) {
        patronal = parseFloat(((sdp - (sal_min * 3)) * 0.011).toFixed(2));
      }
      cuota_imss = parseFloat(((sdp * riesgo_trabajo) + (sal_min * .2040) + patronal + (sdp * 0.007) + (sdp * 0.0105) + (sdp * 0.0175) + (sdp * 0.01) + (sdp * 0.0315)).toFixed(2));
      cuota_inf = parseFloat(((sdp * 0.05) + (sdp * 0.03) + (sdp * 0.02)).toFixed(2));
      subtot = prestaciones + cuota_imss + cuota_inf;
      $("#carga_social_personal_"+i+"_"+j).val((subtot/sd*100).toFixed(2));
    }
  }
  calcPersonal();
}

function format2(n, currency) {
  return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
}

function Dias(){
  var fechaInicio = new Date($("#fecha_inicio").val()).getTime();
  var fechaFin    = new Date($("#fecha_fin").val()).getTime();
  var diff = fechaFin - fechaInicio;
  dias = (diff/(1000*60*60*24)+1+parseInt($("#dias_capacitacion").val()));
  elementos = document.getElementsByClassName("dias-laborados");
  for (var i = 0; i < elementos.length; i++) {
    elementos[i].setAttribute("max", dias);
  }
}
function borrarSeccion(id){
  borrar_seccion = document.getElementById(id);
  $("#mod-tit").empty()
  $("#mod-tit").append("Esta seguro de borrar la seccion: " + id);
}
function deleteSeccion(){
  borrar_seccion.parentNode.removeChild(borrar_seccion);
  console.log(borrar_seccion.id);
  switch(borrar_seccion.id) {
    case "personal":
      borrar_seccion = document.getElementById("primaDom");
      borrar_seccion.parentNode.removeChild(borrar_seccion);
      personal_activo = 0;
      dominical_activo = 0;
      $("#secc_personal").val(personal_activo);
      $("#secc_dominical").val(dominical_activo);
      break;
    case "Otros":
      otros_activo = 0;
      $("#secc_otros").val(otros_activo);
      $("#inputEscondidos").append('<input type="hidden" name="comision_ag_otros" id="comision_ag_otros" value="0">');
      break;
    case "matEnv":
      materiales_activo = 0;
      $("#secc_mat").val(materiales_activo);
      $("#inputEscondidos").append('<input type="hidden" name="comision_ag_mat" id="comision_ag_mat" value="0">');
      break;
    case "Degustaciones":
      degustaciones_activo = 0;
      $("#secc_degustaciones").val(degustaciones_activo);
      $("#inputEscondidos").append('<input type="hidden" name="comision_ag_degustaciones" id="comision_ag_degustaciones" value="0">');
      $("#inputEscondidos").append('<input type="hidden" name="dias_tot_degustaciones" id="dias_tot_degustaciones" value="0">');

      break;
    case "eventosEspeciales":
      eventos_especiales = 0;
      $("#secc_eventos_especiales").val(eventos_especiales);
      $("#inputEscondidos").append('<input type="hidden" name="comision_ag_eventos_especiales" id="comision_ag_eventos_especiales" value="0">');
      break;
    case "incentivos":
      incentivo = 0;
      $("#secc_incentivos").val(incentivo);
      $("#inputEscondidos").append('<input type="hidden" name="comision_ag_incentivo" id="comision_ag_incentivos" value="0">');
      $("#inputEscondidos").append('<input type="hidden" name ="carga_social_incentivo" id="carga_social_incentivos" class="form-control" title="Carga social incentivos" value="0"/>');
      break;
    case "pasivo_laboral":
      pasivo_laboral = 0;
      $("#secc_pl").val(pasivo_laboral);
      $("#inputEscondidos").append('<input type="hidden" name="carga_social_pl" id="carga_social_pl" class="form-control" value="0"/>');
      $("#inputEscondidos").append('<input type="hidden" name="comision_ag_pl" id="comision_ag_pl" value="0">');
      break;
    case "primaDom":
      primaDom = 0;
      $("#secc_dominical").val(primaDom);
      break;
  }
}
function togglePI() {
  if ($('#desglozado').is(':checked')) {
    var element = document.getElementById("PrestacionesIntegrales");
    element.classList.remove("hidden");
    $('#desglo').val(1);
  }else {
    var element = document.getElementById("PrestacionesIntegrales");
    element.classList.add("hidden");
    $('#desglo').val(0);
  }
  calcPersonal();
}


/*function loadPersonal(id){
  $.ajax({
    data: {tabla:"cat_personal_promocion"},
    type: 'POST',
    dataType: 'json',
    url: 'model/load_personal_promocion.php',
    success: function (data) {
      $("#id_posicion_"+id+"_"+cont_personal).empty();
      $("#id_posicion_"+id+"_"+cont_personal).append(
        '<option disabled selected>Seleccione una Opción</option>'
      );
      for (var i = 0; i < data.length; i++) {
        $("#id_posicion_"+id+"_"+cont_personal).append(
          '<option value="'+data[i].id+'" title="'+data[i].caracteristica+'">'+data[i].nombre+'</option>'
        );
      }
    },
    error: function (data) {
      console.log("error al cargar el personal");
      console.log(data);
    }
  });
}*/
