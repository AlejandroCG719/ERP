var id_unico = 0; //se usa para la seccion de personal y prestaciones integrales
var id_unico_2 = 0; // se usa para materiales y envios
var id_unico_3 = -1; // se usa para salario dominical
var id_unico_4 = 0; // se usa para la seccion de otros
var id_unico_5 =0; // se usa para degustaciones
var id_unico_6 = 0 // se usa para incentivos
var id_unico_7 = 0 // se usa para pasivo laboral
var borrar_seccion = "";
var personal_activo = 1;
var dominical_activo = 1;
var otros_activo = 1;
var materiales_activo = 1;
var degustaciones_activo = 1;
var pago_proveedor = 1;
var incentivo = 1;
var pasivo_laboral = 1;
$(document).ready(function() {
  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd'
  });
  $('[data-toggle="tooltip"]').tooltip();
  $("#plaza").select2({width: "resolve", tags:["Aguascalientes", "Baja California", "Baja California Sur", "Campeche", "Chiapas", "Chihuahua", "Ciudad de México", "Coahuila", "Colima", "Durango", "Estado de México", "Guanajuato", "Guerrero", "Hidalgo", "Jalisco", "Michoacán", "Morelos", "Nayarit", "Nuevo León", "Oaxaca", "Puebla", "Querétaro", "Quintana Roo", "San Luis Potosí", "Sinaloa", "Sonora", "Tabasco", "Tamaulipas", "Tlaxcala", "Veracruz", "Yucatán", "Zacatecas"]});
  submit();
  loadClientes();
  loadEstadosCotizacion();
  loadMateriales();
  noPresupuesto();
  loadDegustaciones();
});

function submit(){
  $('#frm-empleado').on('submit', function(event) {
    $(document).skylo('start');
    setTimeout(function () {
      $(document).skylo('set', 50);
    }, 150);
    event.preventDefault();
    $("#indice_per").val(id_unico);
    $("#indice_mat").val(id_unico_2);
    $("#indice_dominical").val(id_unico_3);
    $("#indice_otros").val(id_unico_4);
    $("#indice_degustaciones").val(id_unico_5);
    $("#indice_incentivos").val(id_unico_6);
    $("#indice_pl").val(id_unico_7);
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
  var id = $("#id_promocion").val();
  $.ajax({
    data: {id:id},
    type: 'POST',
    dataType: 'json',
    url: 'model/load_comisiones.php',
    success: function (data) {
      console.log(data);
      var valor = "";
      valor = String(data[0].carga_social);
      $("#carga_social-show").val(valor);
      $("#carga_social").val(data[0].carga_social);
      valor = String(data[0].com_ag_per);
      $("#comision_agencia-show").val(valor);
      $("#comision_agencia").val(data[0].com_ag_per);
      valor = String(data[0].com_ag_mat);
      $("#com-ag-mat-show").val(valor);
      $("#com-ag-mat").val(data[0].com_ag_mat);
      $("#com_ag_otros").val(data[0].com_ag_otros);
      $("#com-ag-otros").val(data[0].com_ag_otros);
      $("#com_ag_degu").val(data[0].com_ag_degu);
      $("#com-ag-degu").val(data[0].com_ag_degu);
      $("#com_ag_pago_proveedor").val(data[0].com_ag_pago_proveedor);
      $("#com-ag-pago-proveedor").val(data[0].com_ag_pago_proveedor);
      loadPersonal();
      calcCuota();
      calcMatTot();
      loadPersonalPL();
    },
    error: function (data) {
      console.log("error al cargar comisiones");
    }
  });
}
function loadPersonal(){
  var id_promocion = $("#id_promocion").val();
  $.ajax({
    data: {tabla:"cat_cot_personal"},
    type: 'POST',
    dataType: 'json',
    url: 'model/load_catalogo.php',
    success: function (data) {
      $("#id_posicion-"+id_unico).empty();
      $("#id_posicion-"+id_unico).append(
        '<option disabled selected>Seleccione una Opción</option>'
      );
      for (var i = 0; i < data.length; i++) {
        $("#id_posicion-"+id_unico).append(
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
function loadSueldo(id){
  var val = $("#id_posicion-"+id).val();
  $.ajax({
    data: {id:val,tabla:"cat_cot_personal"},
    type: 'POST',
    dataType: 'json',
    url: 'model/load_catalogo.php',
    success: function (data) {
      borrarDominical("id_posicion_"+id);
      $("#sueldo_base_"+id).val(parseFloat(data[0].valor).toFixed(2));
      $("#base_sueldo_"+id).val(parseFloat(data[0].valor).toFixed(2));
      $("#id_posicion_"+id).val(data[0].valor);
      /// seccion prima dominical
      if (data[0].nombre.search("PD")>-1) {
        addDominical("id_posicion_"+id)
        $("#pos-dom-"+id_unico_3).val(data[0].nombre);
        $("#dominical_id_personal_"+id_unico_3).val(data[0].id);

      }
      // fin seccion prima Dominical
      // seccion Prestaiones Integrales
      $(".pi_posicion_"+id).val(data[0].nombre);
      //fin seccion prestaciones integrales
      calcCuota();
    },
    error: function (data) {
    }
  });
}
function loadMateriales(){
  $.ajax({
    data: {tabla:"cat_cot_mat"},
    type: 'POST',
    dataType: 'json',
    url: 'model/load_catalogo.php',
    success: function (data) {
      $("#id_articulo-"+id_unico_2).append(
        '<option title="Seleccione una Opción" selected disabled>Seleccione una Opción</option>'
      );
      for (var i = 0; i < data.length; i++) {
        $("#id_articulo-"+id_unico_2).append(
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
  var val = $("#id_articulo-"+id).val();
  $.ajax({
    data: {id:val,tabla:"cat_cot_mat"},
    type: 'POST',
    dataType: 'json',
    url: 'model/load_catalogo.php',
    success: function (data) {
      $("#costo-unitario-"+id).val(data[0].valor);
      $("#com-ag-"+id).val(parseFloat(data[0].valor * ($("#com-ag-mat").val()/100)));
      $("#c-u-"+id).val(data[0].valor);
      calcMatTot();
    },
    error: function (data) {
    }
  });
}
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
function loadDegustaciones(){
  $.ajax({
    data: {tabla:"cat_cot_degu"},
    type: 'POST',
    dataType: 'json',
    url: 'model/load_catalogo.php',
    success: function (data) {
      $("#id_degustacion_"+id_unico_5).empty();
      $("#id_degustacion_"+id_unico_5).append(
        '<option title="Seleccione una Opción" selected disabled>Seleccione una Opción</option>'
      );
      for (var i = 0; i < data.length; i++) {
        $("#id_degustacion_"+id_unico_5).append(
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
function loadPersonalPL(){
  var id_promocion = $("#id_promocion").val();
  $.ajax({
    data: {tabla:"cat_cot_personal",id_promocion:id_promocion},
    type: 'POST',
    dataType: 'json',
    url: 'model/load_catalogo.php',
    success: function (data) {
      $("#id_personal_pl_"+id_unico_7).empty();
      $("#id_personal_pl_"+id_unico_7).append(
        '<option disabled selected>Seleccione una Opción</option>'
      );
      for (var i = 0; i < data.length; i++) {
        $("#id_personal_pl_"+id_unico_7).append(
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
function loadSueldoPL(id){
  var val = $("#id_personal_pl_"+id).val();
  $.ajax({
    data: {id:val,tabla:"cat_cot_personal"},
    type: 'POST',
    dataType: 'json',
    url: 'model/load_catalogo.php',
    success: function (data) {
      $("#pl_sueldo_base_"+id).val(parseFloat(data[0].valor).toFixed(2));
      calcPLTot();
    },
    error: function (data) {
    }
  });
}

function addPersonal(){ //agregamos personal y tambien en seccion de prestaciones integrales
  id_unico ++;
  $("#personal").append(
    '<div class="row borde dcp-unico-'+id_unico+'">'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Posición</label>'+
          '<div class="col-sm-6">'+
            '<select id="id_posicion-'+id_unico+'" name="id_posicion_'+id_unico+'" class="form-control selectpicker show-tick" title="Seleccione una posición" onchange="loadSueldo('+id_unico+')" required/>'+
            '</select>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione la posición">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group dcp-unico-'+id_unico+'">'+
          '<label class="col-sm-5 control-label" style="height:46px">Suledo base</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="number" id="sueldo_base_'+id_unico+'"  class="form-control sbd" placeholder="Sueldo base diario" title="Sueldo base diario" value="0" disabled/>'+
              '<input type="hidden" id="base_sueldo_'+id_unico+'" name="sueldo_base_'+id_unico+'">'+
            '</div>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Sueldo base diario del puesto">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group dcp-unico-'+id_unico+'">'+
          '<label class="col-sm-5 control-label" style="height:46px">Cuota diaria</label>'+
          '<div class="col-sm-6">'+
            '<input type="text" id="cuota_diaria-'+id_unico+'" name="cuota_diaria-'+id_unico+'" class="form-control" placeholder="Costo cueta diaria" disabled/>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Costo cuota diaria (incluye carga social y comision de agencia)">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
    '</div>'+
    '<div class="row dcp-unico-'+id_unico+'">'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Cantidad*</label>'+
          '<div class="col-sm-6">'+
            '<input type="number" id="cantidad-'+id_unico+'" name="cantidad_'+id_unico+'" class="form-control" min="0" onchange="calcCuota()" required/>'+
          '</div>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Días laborados*</label>'+
          '<div class="col-sm-6">'+
            '<input type="number" id="num_dias_'+id_unico+'" name="dias_'+id_unico+'" class="form-control dias-laborados" placeholder="Duración en días" min="0" max="10" onchange="calcCuota()" required/>'+
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
              '<input type="text" id="total-personal-'+id_unico+'" name="total_'+id_unico+'" class="form-control" placeholder="Total" value="0" disabled/>'+
            '</div>'+
          '</div>'+
          '<div class="col-md-1" id="unico_'+id_unico+'">'+
            '<button type="button" onclick=borrarPersonal("dcp-unico-'+id_unico+'") class="btn btn-danger"><i class="fa fa-minus"></i></button>'+
          '</div>'+
        '</div>'+
      '</div>'+
    '</div>'
  );
  //escondemos boton
  if(id_unico>1){
    $("#unico_"+(id_unico-1)).addClass("hidden");
  }
  // Prestaciones Integrales
  $("#puntualidad").append(
    '<div class="row borde dcp-unico-'+id_unico+'">'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Posición</label>'+
          '<div class="col-sm-6">'+
            '<input type="text" id="pi_posicion_'+id_unico+'" class="form-control pi_posicion_'+id_unico+'" disabled/>'+
          '</div>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Porcentaje</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<input type="number" id="pi_puntualidad_'+id_unico+'" name="pi_puntualidad_'+id_unico+'" class="form-control" placeholder="Porcentaje despensa" title="Porcentaje despensa" value="10" onchange="calcCuota()" min="0" max="15" step=".01"/>'+
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
              '<input type="text" id="puntualidad_dia_'+id_unico+'" name="puntualidad_dia_'+id_unico+'" class="form-control" placeholder="Total" value="0" disabled/>'+
              '<input type="hidden" id="tot-m-'+id_unico+'"/>'+
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
              '<input type="text" id="puntualidad_tot_'+id_unico+'" name="puntualidad_tot_'+id_unico+'" class="form-control" placeholder="Total" value="0" disabled/>'+
            '</div>'+
          '</div>'+
        '</div>'+
      '</div>'+
    '</div>'
  );
  $("#asistencia").append(
    '<div class="row borde dcp-unico-'+id_unico+'">'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Posición</label>'+
          '<div class="col-sm-6">'+
            '<input type="text" id="pi_posicion_'+id_unico+'" class="form-control pi_posicion_'+id_unico+'"" disabled/>'+
          '</div>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Porcentaje</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<input type="number" id="pi_asistencia_'+id_unico+'" name="pi_asistencia_'+id_unico+'" class="form-control" placeholder="Porcentaje despensa" title="Porcentaje despensa" value="10" onchange="calcCuota()" min="0" max="15" step=".01"/>'+
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
              '<input type="text" id="asistencia_dia_'+id_unico+'" name="asistencia_dia_'+id_unico+'" class="form-control" placeholder="Total" value="0" disabled/>'+
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
              '<input type="text" id="asistencia_tot_'+id_unico+'" name="asistencia_tot_'+id_unico+'" class="form-control" placeholder="Total" value="0" disabled/>'+
            '</div>'+
          '</div>'+
        '</div>'+
      '</div>'+
    '</div>'
  );
  $("#despensa").append(
    '<div class="row borde borde dcp-unico-'+id_unico+'">'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Posición*</label>'+
          '<div class="col-sm-6">'+
            '<input type="text" class="form-control pi_posicion_'+id_unico+'" disabled/>'+
          '</div>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">UMA</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="number" id="pi_salario_minimo" name="pi_salario_minimo" class="form-control" placeholder="Salario mínimo" title="Salario mínimo" value="80.60" onchange="calcCuota()" step=".01"/>'+
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
              '<input type="number" id="pi_porcentaje_despensa_'+id_unico+'" name="pi_porcentaje_despensa_'+id_unico+'" class="form-control" placeholder="Porcentaje despensa" title="Porcentaje despensa" value="40" onchange="calcCuota()" min="0" max="40" step=".01"/>'+
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
              '<input type="text" id="despensa_dia_'+id_unico+'" name="despensa_dia_'+id_unico+'" class="form-control" placeholder="Total" value="0" disabled/>'+
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
              '<input type="text" id="despensa_tot_'+id_unico+'" name="despensa_tot_'+id_unico+'" class="form-control" placeholder="Total" value="0" disabled/>'+
            '</div>'+
          '</div>'+
        '</div>'+
      '</div>'+
    '</div>'
  );
  $('[data-toggle="tooltip"]').tooltip();
  loadPersonal();
  // incentivos
}
function borrarPersonal(id){
  $("."+id).remove();
  id_unico--;
  $("#unico_"+(id_unico)).removeClass("hidden");
  calcTot();
}
function addMaterial(){
  id_unico_2 ++;
  $("#material").append(
    '<div class="row borde mat-unico-'+id_unico_2+'">'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Artículo</label>'+
          '<div class="col-sm-6">'+
            '<select class="form-control selectpicker show-tick" id="id_articulo-'+id_unico_2+'" name="id_material_'+id_unico_2+'" onchange="loadArticuloPrecio('+id_unico_2+')" title="Seleccione un artículo" required/>'+
            '</select>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione un artículo">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group dcp-unico-'+id_unico_2+'">'+
          '<label class="col-sm-5 control-label" style="height:46px">Costo unitario</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="text" class="form-control" id="costo-unitario-'+id_unico_2+'" name="costo_unitario_'+id_unico_2+'" value="0" placeholder="Costo unitario" title="Costo unitario del articulo" onchange="calcMatTot()"/>'+
              '<!--input type="hidden" id="c-u-'+id_unico_2+'" /-->'+
            '</div>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Costo unitario del artículo">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group dcp-unico-'+id_unico_2+'">'+
          '<label class="col-sm-5 control-label" style="height:46px">Comisión agencia</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="number" step="0.01" class="form-control" id="com-ag-'+id_unico_2+'" name="com_ag_'+id_unico_2+'" placeholder="Comisión agencia" disabled/>'+
            '</div>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Comision de agencia">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
    '</div>'+
    '<div class="row mat-unico-'+id_unico_2+'">'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Cantidad</label>'+
          '<div class="col-sm-6">'+
            '<input type="number" class="form-control" id="cant-mat-'+id_unico_2+'" name="cant_mat_'+id_unico_2+'" min="0" onchange="calcMatTot()" required/>'+
          '</div>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label">Total</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="text" class="form-control" id="total-mat-'+id_unico_2+'" name="total_mat_'+id_unico_2+'" value="0" placeholder="Total" disabled/>'+
              '<input type="hidden" id="tot-m-'+id_unico_2+'"/>'+
            '</div>'+
          '</div>'+
          '<div class="col-md-1" id="mat_'+id_unico_2+'">'+
            '<button type="button" onclick=borrarMaterial("mat-unico-'+id_unico_2+'") class="btn btn-danger"><i class="fa fa-minus"></i></button>'+
          '</div>'+
        '</div>'+
      '</div>'+
    '</div>'
  );
  if(id_unico_2>1){
    $("#mat_"+(id_unico_2-1)).addClass("hidden");
  }
  $('[data-toggle="tooltip"]').tooltip();
  loadMateriales();
}
function borrarMaterial(id){
  $("."+id).remove();
  id_unico_2--;
  $("#mat_"+(id_unico_2)).removeClass("hidden");
  calcTot();
}
function addDominical(id_select){
  id_unico_3 ++;
  $("#dominical").append(
    '<div class="row borde prima_dominical '+id_select+'">'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Posición</label>'+
          '<div class="col-sm-6">'+
            '<input type="text" id="pos-dom-'+id_unico_3+'" class="form-control" disabled/>'+
            '<input type="hidden" id="dominical_id_personal_'+id_unico_3+'" name="dominical_id_personal_'+id_unico_3+'" class="form-control"/>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione la posición">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group dcp-unico-'+id_unico_3+'">'+
          '<label class="col-sm-5 control-label" style="height:46px">Suledo base</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="text" id="sb-d-'+id_unico_3+'" class="form-control" placeholder="Sueldo base diario" title="Sueldo base diario" value="0" disabled/>'+
              '<input type="hidden" id="sbd-dom-'+id_unico_3+'" name="dominical_sueldo_base_'+id_unico_3+'"/>'+
            '</div>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Sueldo base diario del puesto">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group dcp-unico-'+id_unico_3+'">'+
          '<label class="col-sm-5 control-label" style="height:46px">Cuota diaria</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="text" id="cuota_dom-'+id_unico_3+'" class="form-control" placeholder="Costo cuota diaria" disabled/>'+
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
          '<input type="text" id="dias-dom-'+id_unico_3+'" name="dias_dom_'+id_unico_3+'" class="form-control" placeholder="Total" value="0" onchange="calcCuota()"/>'+
        '</div>'+
      '</div>'+
    '</div>'+
    '<div class="col-md-4">'+
      '<div class="form-group">'+
        '<label class="col-sm-5 control-label">Total</label>'+
        '<div class="col-sm-6">'+
          '<div class="input-group">'+
            '<span class="input-group-addon">$</span>'+
            '<input type="text" id="total-dom-'+id_unico_3+'" class="form-control" placeholder="Total" value="0" disabled/>'+
            '<input type="hidden" id="tot-d-'+id_unico_3+'"/>'+
          '</div>'+
        '</div>'+
      '</div>'+
    '</div>'+
  '</div>'
  );
}
function borrarDominical(id){
  var x = document.getElementsByClassName(id);
  if (x.length>0) {
    $("."+id).remove();
  }
  calcTot();
}
function addOtros(){
  id_unico_4 ++;
  $("#otros").append(
    '<div class="row borde otros-unico-'+id_unico_4+'">'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Concepto*</label>'+
          '<div class="col-sm-6">'+
            '<input type="text" id="otros_concepto_'+id_unico_4+'" name="otros_concepto_'+id_unico_4+'" class="form-control" title="Ingrese el concepto" required/>'+
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
              '<input type="number" id="otros_monto_'+id_unico_4+'" name="otros_monto_'+id_unico_4+'" class="form-control" placeholder="Ingrese el monto" min="0" onchange="calcCuota()" required />'+
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
            '<input type="number" id="otros_cantidad_'+id_unico_4+'" name="otros_cantidad_'+id_unico_4+'" class="form-control" placeholder="Cantidad de personas" min="0" onchange="calcCuota()"  required/>'+
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
              '<input type="number" id="otros_total_'+id_unico_4+'" name="otros_total_'+id_unico_4+'" class="form-control" placeholder="Cantidad de personas" disabled/>'+
            '</div>'+
          '</div>'+
          '<div class="col-md-1" id="otros_'+id_unico_4+'">'+
            '<button type="button" onclick=borrarOtros("otros-unico-'+id_unico_4+'") class="btn btn-danger"><i class="fa fa-minus"></i></button>'+
          '</div>'+
        '</div>'+
      '</div>'+
    '</div>'
  );
  if(id_unico_4>1){
    $("#otros_"+(id_unico_4-1)).addClass("hidden");
  }
  $('[data-toggle="tooltip"]').tooltip();
  loadMateriales();
}
function borrarOtros(id){
  $("."+id).remove();
  id_unico_4--;
  $("#otros_"+(id_unico_4)).removeClass("hidden");
  calcTot();
}
function addDegustacion(){
  id_unico_5 ++;
  $("#degustaciones").append(
    '<div class="row borde degustacion-unico-'+id_unico_5+'">'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Degustación</label>'+
          '<div class="col-sm-6">'+
            '<select id="id_degustacion_'+id_unico_5+'" name="id_degustacion_'+id_unico_5+'" class="form-control" title="Ingrese la degustación">'+
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
            '<input type="number" id="degu_cantidad_'+id_unico_5+'" name="degu_cantidad_'+id_unico_5+'" class="form-control" placeholder="Degustaciones por día" onchange="calcCuota()"  required/>'+
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
              '<input type="number" id="degu_costo_unidad_'+id_unico_5+'" name="degu_costo_unidad_'+id_unico_5+'" class="form-control" title="Ingrese el costo total por unidad" onchange="calcCuota()" required/>'+
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
              '<input type="text" id="degustacion_comision_'+id_unico_5+'" class="form-control" title="Seleccione una posición" disabled/>'+
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
              '<input type="text" id="degu_total_'+id_unico_5+'" class="form-control" title="Seleccione una posición" disabled/>'+
            '</div>'+
          '</div>'+
          '<div class="col-md-1" id="degustacion_'+id_unico_5+'">'+
            '<button type="button" onclick=borrarDegustacion("degustacion-unico-'+id_unico_5+'") class="btn btn-danger"><i class="fa fa-minus"></i></button>'+
          '</div>'+
        '</div>'+
      '</div>'+
    '</div>'
  );
  if(id_unico_5>1){
    $("#degustacion_"+(id_unico_5-1)).addClass("hidden");
  }
  $('[data-toggle="tooltip"]').tooltip();
  loadDegustaciones();
}
function borrarDegustacion(id){
  $("."+id).remove();
  id_unico_5--;
  $("#degustacion_"+(id_unico_5)).removeClass("hidden");
  calcTot();
}
function addIncentivo(){
  id_unico_6 ++;
  $("#incentivo").append(
    '<div class="row borde incentivo-unico-'+id_unico_6+'">'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Descripción</label>'+
          '<div class="col-sm-6">'+
            '<input type="text" id="incentivo_descripcion_'+id_unico_6+'" name="incentivo_descripcion_'+id_unico_6+'" class="form-control" required/>'+
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
            '<input type="text" id="incentivos_num_personal_'+id_unico_6+'" name="incentivos_num_personal_'+id_unico_6+'" class="form-control" placeholder="Número de personal" title="Número de personal" onchange="calcIncTot()"/>'+
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
              '<input type="number" id="incentivos_costo_mensual_'+id_unico_6+'" name="incentivos_costo_mensual_'+id_unico_6+'" class="form-control" placeholder="Costo mensual" onchange="calcIncTot()"/>'+
            '</div>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Costo Mensual">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
    '</div>'+
    '<div class="row incentivo-unico-'+id_unico_6+'">'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Carga social mensual*</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="number" id="incentivos_carga_social_mensual-'+id_unico_6+'" class="form-control" disabled/>'+
              '<input type="hidden" id="incentivos_carga_social_mensual_'+id_unico_6+'" name="incentivos_carga_social_mensual_'+id_unico_6+'"/>'+
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
              '<input type="text" id="total_incentivo_'+id_unico_6+'" name="total_incentivo_'+id_unico_6+'" class="form-control" placeholder="Total" value="0" disabled/>'+
              '<input type="hidden" id="tot_incentivo_'+id_unico_6+'"/>'+
            '</div>'+
          '</div>'+
          '<div class="col-md-1" id="inc_'+id_unico_6+'">'+
            '<button type="button" onclick=borrarIncentivo("incentivo-unico-'+id_unico_6+'") class="btn btn-danger"><i class="fa fa-minus"></i></button>'+
          '</div>'+
        '</div>'+
      '</div>'+
    '</div>'
  );
  if(id_unico_6>1){
    $("#inc_"+(id_unico_6-1)).addClass("hidden");
  }
  $('[data-toggle="tooltip"]').tooltip();
  loadMateriales();
}
function borrarIncentivo(id){
  $("."+id).remove();
  id_unico_6--;
  $("#inc_"+(id_unico_6)).removeClass("hidden");
  calcTot();
}
function addPL(){
  id_unico_7 ++;
  $("#pasivo-laboral").append(
    '<div class="row borde incentivo-unico-'+id_unico_7+'">'+
      '<div class="col-md-6">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Personal</label>'+
          '<div class="col-sm-6">'+
            '<select class="form-control" id="id_personal_pl_0" name="id_personal_pl_0" onchange="loadSueldoPL(0)"  required/>'+
            '</select>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione una artículo">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-6">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Número de personal</label>'+
          '<div class="col-sm-6">'+
            '<input type="text" id="pl_num_personal_0" name="pl_num_personal_0" class="form-control" placeholder="Número de personal" title="Número de personal" onchange="calcPLTot()"/>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Número de Personal">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
    '</div>'+
    '<div class="row">'+
      '<div class="col-md-6">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label">Meses de Liquidación por ley</label>'+
          '<div class="col-sm-6">'+
            '<input type="text" id="meses_liquidacion" name="meses_liquidacion" class="form-control" placeholder="Meses de Liquidación por ley" title="Meses de Liquidación por ley" onchange="calcPLTot()" required/>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Meses de Liquidación por ley">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-6">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Monto</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="hidden" id="pl_sueldo_base_0" name="pl_sueldo_base_0" >'+
              '<input type="number" id="pl_monto_meses_0" name="pl_monto_meses_0" class="form-control" placeholder="Liquidación" disabled/>'+
            '</div>'+
          '</div>'+
          '<a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Costo Mensual">'+
            '<span class="fa fa-info-circle"></span>'+
          '</a>'+
        '</div>'+
      '</div>'+
    '</div>'+
    '<div class="row">'+
      '<div class="col-md-6">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Días por año*</label>'+
          '<div class="col-sm-6">'+
            '<input type="number" id="dias_x_anio" name="dias_x_anio" class="form-control" onchange="calcPLTot()"/>'+
          '</div>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-6">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label">Monto</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="text" id="pl_monto_dias_0" name="pl_monto_dias_0" class="form-control" disabled/>'+
            '</div>'+
          '</div>'+
        '</div>'+
      '</div>'+
    '</div>'+
    '<div class="row">'+
      '<div class="col-md-6">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Días de prima vacacional*</label>'+
          '<div class="col-sm-6">'+
            '<input type="number" id="dias_prima_vacacional_0" name="dias_prima_vacacional_0" class="form-control" onchange="calcPLTot()"/>'+
          '</div>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-6">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label">Monto</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="text" id="pl_monto_dias_prima_0" name="pl_monto_dias_prima_0" class="form-control" disabled/>'+
            '</div>'+
          '</div>'+
        '</div>'+
      '</div>'+
    '</div>'+
    '<div class="row">'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Total unitario</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="text" id="pl_total_unitario_0" class="form-control" disabled/>'+
            '</div>'+
          '</div>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label">Total con 3% rotación</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="text" id="pl_total_cant_0" class="form-control" disabled/>'+
            '</div>'+
          '</div>'+
        '</div>'+
      '</div>'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label">Total con comisión</label>'+
          '<div class="col-sm-6">'+
            '<div class="input-group">'+
              '<span class="input-group-addon">$</span>'+
              '<input type="text" id="pl_total_com_0" name="pl_total_com_0" class="form-control" disabled/>'+
            '</div>'+
          '</div>'+
          '<div class="col-md-1">'+
            '<button type="button" onclick="addIncentivo()" class="btn btn-info"><i class="fa fa-plus"></i></button>'+
          '</div>'+
        '</div>'+
      '</div>'+
    '</div>'
  );
  if(id_unico_6>1){
    $("#inc_"+(id_unico_6-1)).addClass("hidden");
  }
  $('[data-toggle="tooltip"]').tooltip();
  loadMateriales();
}

function calcCuota(){
  var sbd = document.querySelectorAll('input[id^="sueldo_base_"]'); //sueldo base diario
  var dl = document.querySelectorAll('input[id^="num_dias_"]'); //dias laborados
  var otros = document.querySelectorAll('input[id^="otros_monto_"]'); //sueldo base diario
  var carga_social = $("#carga_social").val()/100+1; //carga social
  var comision_agencia = $("#comision_agencia").val()/100+1; //comision agencia
  var tot=0; //total
  var cant =0; //cantidad de empleados
  var sb = 0;
  var prueba = 0;
  var tot_proveedor = 0;
  // calculo pi
  for (var i = 0; i < sbd.length; i++) {
    cant= $("#cantidad-"+i).val(); //obtenemos numero de empleados que se requiere
    if ($('#desglozado').is(':checked')) {
      //calculo de Prestaciones integrales
      sb = (($("#base_sueldo_"+i).val()-($("#pi_salario_minimo").val()*.4))/1.2).toFixed(2);
      $("#puntualidad_dia_"+i).val((sb*.1).toFixed(2));
      $("#puntualidad_tot_"+i).val((sb*.1*cant*dl[i].value).toFixed(2));
      $("#asistencia_dia_"+i).val((sb*.1).toFixed(2));
      $("#asistencia_tot_"+i).val((sb*.1*cant*dl[i].value).toFixed(2));
      $("#despensa_dia_"+i).val(($("#pi_salario_minimo").val()*.4).toFixed(2));
      $("#despensa_tot_"+i).val(($("#pi_salario_minimo").val()*.4*cant*dl[i].value).toFixed(2));
      // calculo cuota cuota_diaria
      tot=(((sb*carga_social)+(sb*.1)+(sb*.1)+($("#pi_salario_minimo").val()*.4))*comision_agencia); //obtenemos cuota diaria
      $("#sueldo_base_"+i).val(sb);
      $("#cuota_diaria-"+i).val(tot.toFixed(2)); //asignamos la cuota diaria
      prueba = 0;
      tot = parseInt(parseInt(tot) * parseInt(dl[i].value) * parseInt(cant));
      prueba = parseInt(parseInt(tot) * parseInt(dl[i].value) * parseInt(cant)); // obtenemos el costo total de una posicion
      $("#total-personal-"+i).val(tot.toFixed(2)); //convertimos la cadena con formato en dinero y mostramos el valor en el input
    }else {
      sb = $("#base_sueldo_"+i).val();
      $("#sueldo_base_"+i).val(sb);
      tot=(sb*carga_social)*comision_agencia; //obtenemos cuota diaria
      $("#cuota_diaria-"+i).val(tot.toFixed(2)); //asignamos la cuota diaria
      tot = tot * dl[i].value * cant; // obtenemos el costo total de una posicion
      $("#total-personal-"+i).val(tot.toFixed(2)); //convertimos la cadena con formato en dinero y mostramos el valor en el input
      //calculo de Prestaciones integrales
      sb = (sbd[i].value-($("#pi_salario_minimo").val()*.4))/1.2;
      $("#puntualidad_dia_"+i).val((sb*.1).toFixed(2));
      $("#puntualidad_tot_"+i).val((sb*.1*cant*dl[i].value).toFixed(2));
      $("#asistencia_dia_"+i).val((sb*.1).toFixed(2));
      $("#asistencia_tot_"+i).val((sb*.1*cant*dl[i].value).toFixed(2));
      $("#despensa_dia_"+i).val(($("#pi_salario_minimo").val()*.4).toFixed(2));
      $("#despensa_tot_"+i).val(($("#pi_salario_minimo").val()*.4*cant*dl[i].value).toFixed(2));
    }
  }
  var degustaciones = document.querySelectorAll('select[id^="id_degustacion_"]');
  for (var i = 0; i < degustaciones.length; i++) {
    // degustaciones
    porcentaje = $("#com_ag_degu").val()/100;
    $("#degustacion_comision_"+i).val((porcentaje*$("#degu_costo_unidad_"+i).val()).toFixed(2));
    porcentaje = porcentaje+1;
    $("#degu_total_"+i).val((porcentaje * $("#degu_costo_unidad_"+i).val() * $("#degu_cantidad_"+i).val() * $("#degu_dias").val()).toFixed(2));
  }
  var spd = document.querySelectorAll('input[id^="cuota_dom"]'); //sueldo prima dominical
  var dias_dom = document.querySelectorAll('input[id^="dias-dom"]');
  // variables dominical
  var str = "";
  var id_personal = "";
  var id_dominical = "";
  var x = document.getElementsByClassName("prima_dominical");
  for (var i = 0; i < spd.length; i++) {
    id_personal = "";
    id_dominical = "";
    str = spd[i].id;
    for (var j = 0; j < str.length; j++) {
      if (str[j]== 0 || str[j]== 1 || str[j]== 2 || str[j]== 3 || str[j]== 4 || str[j]== 5 || str[j]== 6 || str[j]== 7 || str[j]== 8 || str[j]== 9) {
        id_dominical = id_dominical + "" + str[j];
      }
    }
    str = x[i].classList[3];
    for (var j = 0; j < str.length; j++) {
      if (str[j]== 0 || str[j]== 1 || str[j]== 2 || str[j]== 3 || str[j]== 4 || str[j]== 5 || str[j]== 6 || str[j]== 7 || str[j]== 8 || str[j]== 9) {
        id_personal = id_personal + "" + str[j];
      }
    }
    $("#sb-d-"+id_dominical).val((parseFloat($("#base_sueldo_"+id_personal).val())*.25).toFixed(2));
    $("#sbd-dom-"+id_dominical).val((parseFloat($("#base_sueldo_"+id_personal).val())*.25).toFixed(2));
    cant = $("#cantidad-"+id_personal).val(); //obtenemos numero de empleados que se requiere
    //dias_dom = $("#dias_dom_"+i).val();
    tot = ($("#sb-d-"+id_dominical).val() * carga_social * comision_agencia * .25).toFixed(2); //obtenemos la cuota diaria dominical
    prueba = $("#sb-d-"+id_dominical).val() * carga_social ;
    prueba = prueba*comision_agencia;
    tot = prueba.toFixed(2);
    $("#cuota_dom-"+id_dominical).val(tot); // mostramos la cuota diaria dominical
    tot = tot * dias_dom[i].value * cant; // obtenemos el costo total de la cuota diaria dominical por posicion
    $("#total-dom-"+id_dominical).val(tot.toFixed(2));
    $("#tot-d-"+id_dominical).val(tot);
  }
  for (var i = 0; i < otros.length; i++) {
    $("#otros_total_"+i).val(($("#otros_cantidad_"+i).val()*($("#com_ag_otros").val()/100+1)*$("#otros_monto_"+i).val()).toFixed(2));
  }
  tot_proveedor= ($("#pago_proveedor_monto").val()*1.075)*($("#com_ag_pago_proveedor").val()/100+1);
  $("#pago_proveedor_tot").val(tot_proveedor.toFixed(2));
  calcTot();
}
function calcMatTot(){
  var cu = document.querySelectorAll('input[id^="costo-unitario-"]');
  var tot = 0;
  var cant = 0;
  var pu = 0;
  var ca = $("#com-ag-mat").val()/100;
  ca += 1;
  for (var i = 0; i < cu.length; i++) {
    $("#com-ag-"+i).val(($("#costo-unitario-"+i).val()*$("#com-ag-mat").val()/100).toFixed(2));
    cant = $("#cant-mat-"+i).val();
    pu = $("#costo-unitario-"+i).val();
    tot = pu * ca * cant;
    $("#total-mat-"+i).val(tot.toFixed(2));
    $("#tot-m-"+i).val(tot);
  }
  calcTot();
}
function calcIncTot(){
  var cm = document.querySelectorAll('input[id^="incentivos_costo_mensual_"]');
  var tot = 0;
  var cant = 0;
  var pu = 0;
  var cs = $("#incentivos_carga_social").val()/100+1;
  var ca = $("#com-ag-incentivo").val()/100+1;
  for (var i = 0; i < cm.length; i++) {
    $("#incentivos_carga_social_mensual-"+i).val(($("#incentivos_costo_mensual_"+i).val()*cs).toFixed(2));
    $("#total_incentivo_"+i).val(($("#incentivos_costo_mensual_"+i).val()*cs*ca*$("#incentivos_num_personal_"+i).val()).toFixed(2));
  }
  calcTot();
}
function calcPLTot(){
  var cu = document.querySelectorAll('input[id^="pl_num_personal_"]');
  var sb = 0;
  var mm= 0;
  var md = 0;
  var mdp = 0;
  var tot = 0;
  var cant = 0;
  var pu = 0;
  var ca = $("#pl_comision_agencia").val()/100+1;
  var cs = $("#pl_carga_social").val()/1000+1;
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
    /*
    cant = $("#cant-mat-"+i).val();
    pu = $("#costo-unitario-"+i).val();
    tot = pu * ca * cant;
    $("#total-mat-"+i).val(tot.toFixed(2));
    $("#tot-m-"+i).val(tot);
    */
  }
  calcTot();
}
function calcTot(){
  //calculo personal
  var tot_personal = 0;
  tot_personal = parseFloat(tot_personal);
  var totales = document.querySelectorAll('input[id^="total-personal-"]');
  for (var i = 0; i < totales.length; i++) {
    tot_personal = parseFloat(tot_personal) + parseFloat(totales[i].value);
  }
  totales = document.querySelectorAll('input[id^="tot-d"]');
  for (var i = 0; i < totales.length; i++) {
    tot_personal = parseFloat(tot_personal) + parseFloat(totales[i].value);
  }
  if(true == isNaN(tot_personal)){
    tot_personal=0;
  }
  $("#total-personal").val(format2(tot_personal,"$"));
  //fin calculo Personal
  //calculo material
  var tot_material = 0;
  tot_material = parseFloat(tot_material);
  var totales = document.querySelectorAll('input[id^="total-mat-"]');
  for (var i = 0; i < totales.length; i++) {
    tot_material = parseFloat(tot_material) + parseFloat(totales[i].value);
  }
  if(true == isNaN(tot_material)){
    tot_material=0;
  }
  $("#total-mat").val(format2(tot_material,"$"));
  //fin calculo materiales
  //calculo incentivos
  var tot_incentivos = 0;
  tot_incentivos = parseFloat(tot_incentivos);
  var totales = document.querySelectorAll('input[id^="total_incentivo_"]');
  for (var i = 0; i < totales.length; i++) {
    tot_incentivos = parseFloat(tot_incentivos) + parseFloat(totales[i].value);
  }
  if(true == isNaN(tot_incentivos)){
    tot_incentivos=0;
  }
  $("#total-inc").val(format2(tot_incentivos,"$"));
  //fin calculo incentivos
  //calculo otros
  var tot_otros = 0;
  tot_otros = parseFloat(tot_otros);
  var totales = document.querySelectorAll('input[id^="otros_total_"]');
  for (var i = 0; i < totales.length; i++) {
    tot_otros = parseFloat(tot_otros) + parseFloat(totales[i].value);
  }
  if(true == isNaN(tot_otros)){
    tot_otros=0;
  }
  $("#total-otros").val(format2(tot_otros,"$"));
  // fin calculo otros
  // calculo Degustaciones
  var tot_degustaciones = 0;
  tot_degustaciones = parseFloat(tot_degustaciones);

  var totales = document.querySelectorAll('input[id^="degu_total_"]');
  for (var i = 0; i < totales.length; i++) {
    tot_degustaciones = parseFloat(tot_degustaciones) + parseFloat(totales[i].value);
  }
  if(true == isNaN(tot_degustaciones)){
    tot_degustaciones=0;
  }
  $("#total-degustaciones").val(format2(tot_degustaciones,"$"));
  // fin calculo degustaciones
  // total pago proveedor
  var tot_pago_proveedor = parseFloat($("#pago_proveedor_tot").val());
  if(true == isNaN(tot_pago_proveedor)){
    tot_pago_proveedor=0;
  }
  $("#total-pago-proveedor").val(format2(tot_pago_proveedor,"$"));
  // fin pago proveedor
  tot_material = parseFloat(tot_incentivos) + parseFloat(tot_material) + parseFloat(tot_personal) + parseFloat(tot_otros) + parseFloat(tot_degustaciones) + parseFloat(tot_pago_proveedor);
  $("#total-final").val(format2(tot_material,"$"));
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
      break;
    case "matEnv":
      materiales_activo = 0;
      $("#secc_mat").val(materiales_activo);
      break;
    case "Degustaciones":
      degustaciones_activo = 0;
      $("#secc_degu").val(degustaciones_activo);
      break;
    case "pagoProveedor":
      pago_proveedor = 0;
      $("#secc_pago_proveedor").val(pago_proveedor);
      break;
    case "incentivos":
      incentivo = 0;
      $("#secc_incentivos").val(incentivo);
      break;
    case "pasivo_laboral":
      pasivo_laboral = 0;
      $("#secc_pl").val(pasivo_laboral);
      break;
  }
  calcCuota();
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
  calcCuota();
}
