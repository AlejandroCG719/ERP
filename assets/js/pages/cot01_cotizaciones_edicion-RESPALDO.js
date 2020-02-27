var id_unico = 0;
var id_unico_2 = 0;
$(document).ready(function() {
  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd'
  });
  $('[data-toggle="tooltip"]').tooltip();
  $("#plaza").select2({width: "resolve", tags:["Aguascalientes", "Baja California", "Baja California Sur", "Campeche", "Chiapas", "Chihuahua", "Ciudad de México", "Coahuila", "Colima", "Durango", "Estado de México", "Guanajuato", "Guerrero", "Hidalgo", "Jalisco", "Michoacán", "Morelos", "Nayarit", "Nuevo León", "Oaxaca", "Puebla", "Querétaro", "Quintana Roo", "San Luis Potosí", "Sinaloa", "Sonora", "Tabasco", "Tamaulipas", "Tlaxcala", "Veracruz", "Yucatán", "Zacatecas"]});
  submit();
  loadClientes();
  loadEstadosCotizacion();
  loadPersonal();
  loadMateriales();
  noPresupuesto();
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
    var data_form = $(this).serializeArray();
    console.log(data_form);
    $.ajax({
      data: data_form,
      type: "post",
      dataType: "script",
      url: "model/edit_cotizacion.php",
      success: function (data) {
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
      var valor = "";
      valor = String(data[0].carga_social);
      $("#carga_social-show").val(valor+"%");
      $("#carga_social").val(data[0].carga_social);
      valor = String(data[0].com_ag_per);
      $("#comision_agencia-show").val(valor+"%");
      $("#comision_agencia").val(data[0].com_ag_per);
      valor = String(data[0].com_ag_mat);
      $("#com-ag-mat-show").val(valor+"%");
      $("#com-ag-mat").val(data[0].com_ag_mat);
      calcCuota();
      calcMatTot();
    },
    error: function (data) {
      console.log("error al cargar comisiones");
    }
  });
}
function loadPersonal(){
  $.ajax({
    data: {tabla:"cat_cot_personal"},
    type: 'POST',
    dataType: 'json',
    url: 'model/load_catalogo.php',
    success: function (data) {
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
      $("#sb-"+id).val(format2(parseFloat(data[0].valor),"$"));
      $("#sbd-"+id).val(data[0].valor);
      $("#pos-dom-"+id).val(data[0].nombre);
      $("#sb-d-"+id).val(format2((parseFloat(data[0].valor)*.25),"$"));
      $("#sbd-dom-"+id).val((data[0].valor*.25).toFixed(2));
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
      $("#costo-unitario-"+id).val(format2(parseFloat(data[0].valor),"$"));
      $("#com-ag-"+id).val(format2(parseFloat(data[0].valor * ($("#com-ag-mat").val()/100)),"$"));
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
      var presupuesto = "pp"+ano+mes+dia;
      if (data.length>0) {
        if (data[0].id_cotizacion < 10) {
          presupuesto = presupuesto+"00"+data[0].id_cotizacion;
        }else if (data[0].id_cotizacion < 100) {
          presupuesto = presupuesto+"0"+data[0].id_cotizacion;
        }
      }else {
        presupuesto = presupuesto+"000";
      }
      $("#no_presupuesto").val(presupuesto);
    },
    error: function (data) {
      console.log("error generar el presupuesto");
      console.log(data);
    }
  });

}

function addPersonal(){
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
            '<input type="text" id="sb-'+id_unico+'" class="form-control sbd" placeholder="Sueldo base diario" title="Sueldo base diario" value="0" disabled/>'+
            '<input type="hidden" id="sbd-'+id_unico+'" name="sueldo_base_'+id_unico+'"/>'+
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
            '<input type="text" id="total-'+id_unico+'" name="total_'+id_unico+'" class="form-control" placeholder="Total" value="0" disabled/>'+
            '<input type="hidden" id="tot-p-'+id_unico+'"/>'+
          '</div>'+
          '<div class="col-md-1" id="unico_'+id_unico+'">'+
            '<button type="button" onclick=borrarPersonal("dcp-unico-'+id_unico+'") class="btn btn-danger"><i class="fa fa-minus"></i></button>'+
          '</div>'+
        '</div>'+
      '</div>'+
    '</div>'
  );
  $("#dominical").append(
    '<div class="row borde dcp-unico-'+id_unico+'">'+
      '<div class="col-md-4">'+
        '<div class="form-group">'+
          '<label class="col-sm-5 control-label" style="height:46px">Posición</label>'+
          '<div class="col-sm-6">'+
            '<input type="text" id="pos-dom-'+id_unico+'" class="form-control" title="Seleccione una posición" disabled/>'+
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
            '<input type="text" id="sb-d-'+id_unico+'" class="form-control" placeholder="Sueldo base diario" title="Sueldo base diario" value="0" disabled/>'+
            '<input type="hidden" id="sbd-dom-'+id_unico+'"/>'+
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
            '<input type="text" id="cuota_dom-'+id_unico+'" class="form-control" placeholder="Costo cuota diaria" disabled/>'+
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
          '<label class="col-sm-5 control-label">Total</label>'+
          '<div class="col-sm-6">'+
            '<input type="text" id="total-dom-'+id_unico+'" class="form-control" placeholder="Total" value="0" disabled/>'+
            '<input type="hidden" id="tot-d-'+id_unico+'"/>'+
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
  loadPersonal();
}
function borrarPersonal(id){
  console.log(id);
  $("."+id).remove();
  id_unico--;
  $("#unico_"+(id_unico)).removeClass("hidden");
  $("#indice").attr("value", id_unico);
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
            '<input type="text" class="form-control" id="costo-unitario-'+id_unico_2+'" value="0" placeholder="Costo unitario" title="Costo unitario del articulo" disabled/>'+
            '<input type="hidden" id="c-u-'+id_unico_2+'" name="costo_unitario_'+id_unico_2+'"/>'+
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
            '<input type="number" step="0.01" class="form-control" id="com-ag-'+id_unico_2+'" name="com_ag_'+id_unico_2+'" placeholder="Comisión agencia" disabled/>'+
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
            '<input type="text" class="form-control" id="total-mat-'+id_unico_2+'" name="total_mat_'+id_unico_2+'" value="0" placeholder="Total" disabled/>'+
            '<input type="hidden" id="tot-m-'+id_unico_2+'"/>'+
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
  $("#indice").attr("value", id_unico_2);
  var indice = $("#indice").val();
  $('[data-toggle="tooltip"]').tooltip();
  loadMateriales();
}
function borrarMaterial(id){
  console.log(id);
  $("."+id).remove();
  id_unico_2--;
  $("#mat_"+(id_unico_2)).removeClass("hidden");
  $("#indice").attr("value", id_unico_2);
  calcTot();
}

function calcCuota(){
  var sbd = document.querySelectorAll('input[id^="sbd-"]');
  var carga_social = $("#carga_social").val()/100+1;
  var comision_agencia = $("#comision_agencia").val()/100+1;
  var tot=0;
  var dias = $("#num_dias").val();
  var cant =0;
  var dias_dom = $("#dias_dom").val();
  for (var i = 0; i < sbd.length; i++) {
    tot=(sbd[i].value*carga_social)*comision_agencia; //obtenemos cuota diaria
    $("#cuota_diaria-"+i).val(format2(tot,"$")); //asignamos la cuota diaria
    cant= $("#cantidad-"+i).val(); //obtenemos numero de empleados que se requiere
    tot = tot * dias * cant; // obtenemos el costo total de una posicion
    $("#total-"+i).val(format2(tot,"$")); //convertimos la cadena con formato en dinero y mostramos el valor en el input
    $("#tot-p-"+i).val(tot);

    /////-------------------------------------prima dominical------------------------------------------------////////
    tot = (sbd[i].value*carga_social)*comision_agencia*.25; //obtenemos la cuota diaria dominical
    $("#cuota_dom-"+i).val(format2(tot,"$")); // mostramos la cuota diaria dominical
    tot = tot * dias_dom * cant; // obtenemos el costo total de la cuota diaria dominical por posicion
    $("#total-dom-"+i).val(format2(tot,"$"));
    $("#tot-d-"+i).val(tot);
  }
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
    $("#com-ag-"+i).val(($("#c-u-"+i).val()*$("#com-ag-mat").val()/100).toFixed(2));
    cant = $("#cant-mat-"+i).val();
    pu = $("#c-u-"+i).val();
    tot = pu * ca * cant;
    $("#total-mat-"+i).val(format2(tot,"$"));
    $("#tot-m-"+i).val(tot);
  }
  calcTot();
}
function calcTot(){
  var tot_personal = 0;
  tot_personal = parseFloat(tot_personal);
  var totales = document.querySelectorAll('input[id^="tot-p"]');
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

  var tot_material = 0;
  tot_material = parseFloat(tot_material);
  var totales = document.querySelectorAll('input[id^="tot-m"]');
  for (var i = 0; i < totales.length; i++) {
    tot_material = parseFloat(tot_material) + parseFloat(totales[i].value);
  }
  if(true == isNaN(tot_material)){
    tot_material=0;
  }
  $("#total-mat").val(format2(tot_material,"$"));
  tot_material = parseFloat(tot_material) + parseFloat(tot_personal);
  $("#total-final").val(format2(tot_material,"$"));
}

function format2(n, currency) {
  return currency + " " + n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
}

/*function Dias(){

 var fechaInicio = new Date($("#fecha_inicio").val()).getTime();
 var fechaFin    = new Date($("#fecha_fin").val()).getTime();
 var diff = fechaFin - fechaInicio;
 dias = (diff/(1000*60*60*24)+1+parseInt($("#dias_capacitacion").val()));
 document.getElementById("num_dias").setAttribute("max", dias);
}*/
