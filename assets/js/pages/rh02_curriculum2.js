var cv_chk = 0, nss_chk = 0, cv = 0, ban = 0;

$(document).ready(function() {
  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd'
  });
  $('[data-toggle="tooltip"]').tooltip();
  submit();
  loadEstadosMexico();
  loadDatos();
});

function submit(){
  $('#frm-empleado').on('submit', function(event) {
    event.preventDefault();
    $(document).skylo('start');
    setTimeout(function () {
      $(document).skylo('set', 50);
    }, 150);
    var id_solicitud = $("#id_solicitud_empleo").val();
    var form = document.forms.namedItem("fileinfo");
    var oOutput = document.getElementById("output"), oData = new FormData(document.forms.namedItem("fileinfo"));
    oData.append("FileName", $("#curp").val());
    var oReq = new XMLHttpRequest();
    if (cv == 1) {
      if (cv_chk == 1 && nss_chk == 1) {
        oReq.open("POST", "model/fileupload.php", true);
        oReq.onload = function(oEvent) {
          if (oReq.status == 200) {
            console.log("Uploaded!");
            //insertar ajax para los datos
            submitForm();
            //fin  ajax para los datos
          } else {
            console.log("Error " + oReq.status + " occurred uploading your file");
          }
        };
        oReq.send(oData);
      }else {
        console.log("formato invalido");
      }
    }else {
      submitForm();
    }
  });
}
function submitForm(){
  boletinado($("#curp").val());
  console.log(ban);
  var data_form = $('#frm-empleado').serializeArray();
  var campos = document.getElementsByClassName("form-control");
  for (var i = 0; i < campos.length; i++) {
    campos[i].removeAttribute("disabled");
  }
  console.log(data_form);
  $.ajax({
    data: data_form,
    type: "post",
    dataType: "text",
    url: "model/edit_solicitud.php",
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
        for (var i = 0; i < campos.length; i++) {
          //campos[i].setAttribute("disabled", "");
        }
        //document.getElementById("saveButton").setAttribute("disabled", "");
        if (ban == 1) {
          $("#message").append(
            '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a>Estamos validando tu información. Nosotros Nos Comunicamos Contigo/div>'
          );
        }else {
          $("#message").append(
            '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a>Felicidades tu registro se guardo con éxito./div>'
          );
        }
      }
      $('html, body').animate({scrollTop: 0}, 'slow');
    },
    error: function (data) {
      console.log("error");
      console.log(data);
    }
  });
}
function numeros(id){
  var num = $(id).val().replace(/\D+/g,"");
  $(id).val(num);
}
function loadEstadosMexico(){
  var id_nac= $("#estado_lugar_nac_id").val();
  var id_dir= $("#estado_dir_id").val();
  $.ajax({
    data: {tabla:"cat_estados_mexico"},
    type: "post",
    dataType: "json",
    url: "model/load_catalogo.php",
    success: function (data) {
      for (var i = 0; i < data.length; i++) {
        if (data[i].id == id_nac) {
          $("#id_estado_lugar_nac").append(
            '<option value="'+data[i].id+'" title="'+data[i].caracteristica+'" selected>'+data[i].nombre+'</option>'
          );
          loadMunicipios('id_estado_lugar_nac' , 'id_municipio_lugar_nac');
        }else {
          $("#id_estado_lugar_nac").append(
            '<option value="'+data[i].id+'" title="'+data[i].caracteristica+'">'+data[i].nombre+'</option>'
          );
        }
        if (data[i].id == id_dir) {
          $("#id_estado_dir").append(
            '<option value="'+data[i].id+'" title="'+data[i].caracteristica+'" selected>'+data[i].nombre+'</option>'
          );
          loadMunicipios('id_estado_dir', 'id_municipio_dir');
        }else {
          $("#id_estado_dir").append(
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
  var id_muni_nac = $("#municipio_lugar_nac_id").val();
  var id_muni_dir = $("#municipio_dir_id").val();
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
        if (id_in == "id_estado_lugar_nac") {
          if (data[i].id == id_muni_nac) {
            $("#"+id_out).append(
              '<option value="'+data[i].id+'" title="'+data[i].caracteristica+'" selected>'+data[i].nombre+'</option>'
            );
          }else {
            $("#"+id_out).append(
              '<option value="'+data[i].id+'" title="'+data[i].caracteristica+'">'+data[i].nombre+'</option>'
            );
          }
        }else if (id_in == "id_estado_dir") {
          if (data[i].id == id_muni_dir) {
            $("#"+id_out).append(
              '<option value="'+data[i].id+'" title="'+data[i].caracteristica+'" selected>'+data[i].nombre+'</option>'
            );
          }else {
            $("#"+id_out).append(
              '<option value="'+data[i].id+'" title="'+data[i].caracteristica+'">'+data[i].nombre+'</option>'
            );
          }
        }


      }
    },
    error: function (data) {
      console.log("error");
      console.log(data);
    }
  });
}
function validarCurp() {
  var curp = $("#curp").val();
	var curp = curp.toUpperCase();
  $("#curp").val(curp);

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
function boletinado(curp){
  $.ajax({
    data: {curp:curp},
    type: "post",
    dataType: "json",
    url: "model/check_boletinado.php",
    success: function (data) {
      if (data[0].error==true) {
        console.log("1");
        ban = 1;
      }
    },
    error: function (data) {
      console.log("error");
      console.log(data);
    }
  });
}
function validarNss() {
  var nss = $("#nss").val().replace(/\D+/g,""), resultado = $("#res_nss"), valido;
  $("#nss").val(nss);
  if (nssValido(nss)) { // ⬅️ Acá se comprueba
  	valido = '<i style="color: #08c51f;" class="fa fa-check"></i>';
    nss_chk = 1;
  } else {
    valido = '<i style="color: red;" class="fa fa-times"></i>';
    nss_chk = 0;
  }
  resultado.empty();
  resultado.append (valido);
}
function nssValido(nss) {
  const re = /^(\d{2})(\d{2})(\d{2})\d{5}$/, validado = nss.match(re);
  if (!validado)  // 11 dígitos y subdelegación válida?
    return false;
  const subDeleg = parseInt(validado[1],10), anno = new Date().getFullYear() % 100;
  var annoAlta = parseInt(validado[2],10), annoNac  = parseInt(validado[3],10);
  //Comparar años (excepto que no tenga año de nacimiento)
  if (subDeleg != 97) {
    if (annoAlta <= anno) annoAlta += 100;
    if (annoNac  <= anno) annoNac  += 100;
    if (annoNac  >  annoAlta)
	    return false; // Err: se dio de alta antes de nacer!
  }
  return luhn(nss);
}
function luhn(nss) {
  var suma = 0, par = false, digito;
  for (var i = nss.length - 1; i >= 0; i--) {
    var digito = parseInt(nss.charAt(i),10);
    if (par)
    	if ((digito *= 2) > 9)
        digito -= 9;
    par = !par;
    suma += digito;
  }
  return (suma % 10) == 0;
}

function calcEdad(){
  var fecha_nac = $("#fecha_nac").val();
  fecha_nac = fecha_nac.replace(/-/gi, "/");
  fecha_nac = new Date(fecha_nac);
  var hoy = new Date();
  var years = hoy.getFullYear() - fecha_nac.getFullYear();
  fecha_nac.setFullYear(hoy.getFullYear());
  if (hoy < fecha_nac) {
      years--;
  }
  $("#edad").val(years);
}
function validarEmail(){
  resultado = $("#res_correo");
  var email = $("#email").val();
  var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  if(email.match(mailformat)) {
    valido = '<i style="color: #08c51f;" class="fa fa-check"></i>';
  }else {
    valido = '<i style="color: red;" class="fa fa-times"></i>';
  }
  resultado.empty();
  resultado.append (valido);
}
function validarRfc() {
  resultado = $("#res_rfc");
  var rfc = $("#rfc").val()
  rfc = rfc.toUpperCase();
  $("#rfc").val(rfc);
  if (rfc.length == 10 || rfc.length == 13) {
    valido = '<i style="color: #08c51f;" class="fa fa-check"></i>';
    curp_chk = 1;
  }else {
    valido = '<i style="color: red;" class="fa fa-times"></i>';
    curp_chk = 0;
  }
  resultado.empty();
  resultado.append (valido);
}
function validarTel(id, resultado) {
  var num = $(id).val().replace(/\D+/g,"");
  $(id).val(num);
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
function tallaChk(val){
  if (val == 1) {
    $("#talla").val("N/A");
  }else {
    $("#talla").val("");
  }
}

var myfile="";
function validarCV(){
  myfile= $("#archivo").val();
  resultado = $("#res_cv");
  if(myfile.length>0){
    var ext = myfile.split('.').pop();
    if(ext=="pdf" || ext=="PDF" || ext=="docx" || ext=="DOCX" || ext=="doc" || ext=="DOC"){
      valido = '<i style="color: #08c51f;" class="fa fa-check"></i>';
      $("#ext").val(ext);
      cv_chk = 1;
      cv = 1;
      $("#cv").val(cv);
    } else{
      valido = '<i style="color: red;" class="fa fa-times"></i>';
      cv_chk = 0;
    }
    resultado.empty();
    resultado.append (valido);
  }else {
    cv = 0;
    $("#cv").val(cv);
    $("#ext").val('null');
    resultado.empty();
  }
}

function uperCase(id){
  var dato = $(id).val();
  dato = dato.toUpperCase();
  // Quitamos acentos
  dato = dato.replace(/Á/gi,"A");
  dato = dato.replace(/É/gi,"E");
  dato = dato.replace(/Í/gi,"I");
  dato = dato.replace(/Ó/gi,"O");
  dato = dato.replace(/Ú/gi,"U");
  // Quitamos dieresis
  dato = dato.replace(/Ä/gi,"A");
  dato = dato.replace(/Ë/gi,"E");
  dato = dato.replace(/Ï/gi,"I");
  dato = dato.replace(/Ö/gi,"O");
  dato = dato.replace(/Ü/gi,"U");
  //dato = dato.normalize('NFD').replace(/[\u0300-\u036f]/g, "");
  dato = dato.replace(/\#/g, '');
  dato = dato.replace(/\-/g, '');
  dato = dato.replace(/\_/g, '');
  dato = dato.replace(/\,/g, '');
  dato = dato.replace(/\./g, '');
  dato = dato.replace(/\//g, '');
  dato = dato.replace(/\@/g, '');
  dato = dato.toUpperCase();
  $(id).val(dato);
}

function loadDatos(){
  var id = $("#id_solicitud_empleo").val();
  if (id!= 0) {
    document.getElementById('estado_civil').value=$("#id_estado_civil").val();
    $("#seccion_cv").empty();
    calcEdad();
    validarNss();
    validarRfc();
    validarCurp();
    validarEmail();
    validarTel('#tel_cel', '#res_cel');
    validarTel('#tel_casa', '#res_tel');
    validarTel('#emergencia_tel', '#res_emergencia_tel');
    document.getElementById("rh").removeAttribute("hidden");
  }
}
