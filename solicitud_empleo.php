<?php
  require("classes/SolicitudEmpleo.php");
  $oDatos = new SolicitudEmpleo();
  if (isset($_GET['id'])) {
    session_start();
    require("includes/main.php");
    if($_SESSION['bandera_inicio']!=1){
      header("Location: login.php");
    }else {
      $oDatos->setConsulta($_GET['id']);
    }
  }
?>

<!DOCTYPE html>
  <html lang="es-MX">
  <head>
    <meta charset="utf-8">
      <title>Enterprise Resource Planning.</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Avant">
    <meta name="author" content="The Red Team">

    <link rel="stylesheet" href="assets/css/styles.css?=121">
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>
    <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='styleswitcher'>
    <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='headerswitcher'>
    <link rel='stylesheet' type='text/css' href='assets/plugins/form-select2/select2.css' />
    <link rel='stylesheet' type='text/css' href='assets/plugins/codeprettifier/prettify.css' />
    <link rel='stylesheet' type='text/css' href='assets/plugins/form-toggle/toggles.css' />
    <link rel='stylesheet' type='text/css' href='assets/plugins/progress-skylo/skylo.css' />
    <script type="text/javascript" src="assets/js/less.js"></script>
    <style>
      .borde{
        border-top: 1px solid #e6e7e8;
        padding-top: 15px;
      }
    </style>
  </head>
  <body style="padding-top: 0px !important">
    <div id="page-container">
      <div id='wrap'>
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <h1>Registro de Candidatos</h1>
              <div id="message">
                <div class="alert alert-info"><a href="#" class="close" data-dismiss="alert">&times;</a>Los Datos marcados con <strong>(*) son obligatorios.</strong></div>
              </div>
              <form  class="form-horizontal row-border" method="post" enctype="multipart/form-data" name="fileinfo" id="frm-empleado">
                <input type="hidden" id="cv_chk" name="cv_chk">
                <input type="hidden" id="cv" name="cv" value="0">
                <input type="hidden" id="id_solicitud_empleo" name="id_solicitud_empleo" value="<?= ($oDatos->getId() > 0) ? $oDatos->getId() : 0 ?>">
                <input type="hidden" id="ext" name="ext" value="<?= ($oDatos->getExt() == "") ? 'null' : $oDatos->getExt() ?>">
                <div class="panel panel-midnightblue"> <!-- Solicitud de empleo -->
                  <div class="panel-heading">
                    <h4>
                      Solicitud de Empleo
                    </h4>
                    <div class="options">
                      <a href="javascript:;"><i class="fa fa-cog"></i></a>
                      <a href="javascript:;" onclick=""><i class="fa fa-times"></i></a>
                      <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                    </div>
                  </div>
                  <div class="panel-body collapse in">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Fecha*</label>
                        <div class="col-sm-6">
                          <div class="input-group date ">
                            <input type="text" class="form-control" value="<?= ($oDatos->getFecha() == "") ? date("Y-m-d") : $oDatos->getFecha() ?>" disabled>
                            <input type="hidden" name="fecha" value="<?= ($oDatos->getFecha() == "") ? date("Y-m-d") : $oDatos->getFecha() ?>">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                          </div>
                        </div>
                        <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Fecha de hoy">
                          <span class="fa fa-info-circle"></span>
                        </a>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Puesto Deseado*</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="puesto" name="puesto" value="<?= $oDatos->getPuesto() ?>" placeholder="Ingrese el puesto deseado" title="Ingrese el puesto deseado" tabindex="1" onchange="uperCase('#puesto')" required/>
                        </div>
                        <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el puesto deseado">
                          <span class="fa fa-info-circle"></span>
                        </a>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Sueldo Mensual Bruto*</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="sueldo_bruto" name="sueldo_bruto" value="<?= $oDatos->getSueldoBruto() ?>" placeholder="Sueldo Mensual Bruto" title="Sueldo bruto deseado" tabindex="2" onchange="numeros('#sueldo_bruto')"  required/>
                        </div>
                        <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Sueldo Mensual Bruto">
                          <span class="fa fa-info-circle"></span>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="panel panel-midnightblue"> <!-- Datos Personales Candidato -->
                  <div class="panel-heading">
                    <h4>
                       Información del candidato
                    </h4>
                    <div class="options">
                      <a href="javascript:;"><i class="fa fa-cog"></i></a>
                      <!--a href="javascript:;" onclick="()"><i class="fa fa-refresh"></i></a-->
                      <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                    </div>
                  </div>
                  <div class="panel-body collapse in">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Nombre(s)*</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $oDatos->getNombre() ?>" placeholder="Ingrese su Nombre(s)" title="Nombre del candidato" tabindex="3" onchange="uperCase('#nombre')" required/>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Nombre del candidato">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Apellido Paterno*</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="app" name="app" value="<?= $oDatos->getApp() ?>" placeholder="Ingrese su apellido paterno" title="Ingrese su apellido paterno" tabindex="4" onchange="uperCase('#app')" required/>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese su apellido paterno">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Apellido Materno*</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="apm" name="apm" value="<?= $oDatos->getApm() ?>" placeholder="Ingrese su  Apellido Materno " title="Ingrese su apellido materno" tabindex="5" onchange="uperCase('#apm')" required/>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese su apellido materno">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Fecha de Nacimiento*</label>
                          <div class="col-sm-6">
                            <div class="input-group date datepicker">
                              <input type="text" class="form-control" id="fecha_nac" name="fecha_nac" value="<?= $oDatos->getFechaNac() ?>" placeholder="Seleccione su fecha de nacimiento" title="Seleccione su fecha de nacimiento" tabindex="6" onchange="calcEdad()" required/>
                              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione su fecha de nacimiento">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Lugar de Nacimiento*</label>
                          <div class="col-sm-6">
                            <div class="input-daterange input-group datepicker">
                              <input type="hidden" id="estado_lugar_nac_id" value="<?= $oDatos->getEstadoNac() ?>">
                              <select class="input-small form-control" id="id_estado_lugar_nac" name="id_estado_lugar_nac" tabindex="7" onchange="loadMunicipios('id_estado_lugar_nac' , 'id_municipio_lugar_nac')" required>
                                <option selected disabled>seleccione un estado</option>
                              </select>
                              <span class="input-group-addon">Municipio</span>
                              <input type="hidden" id="municipio_lugar_nac_id" value="<?= $oDatos->getMunicipioNac() ?>">
                              <select class="input-small form-control" id="id_municipio_lugar_nac" name="id_municipio_lugar_nac" tabindex="8" required>
                                <option selected disabled>seleccione un estado</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Estado Civil*</label>
                          <div class="col-sm-6">
                            <input type="hidden" id="id_estado_civil" value="<?= $oDatos->getEstadoCivil() ?>">
                            <select class="form-control" id="estado_civil" name="estado_civil" tabindex="9" required/>
                              <option selected disabled>Seleccione una Opción</option>
                              <option value="1" >SOLTERO</option>
                              <option value="2" >CASADO</option>
                              <option value="3" >CONCUBINATO(UNION LIBRE)</option>
                            </select>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione su estado civil">
                              <span class="fa  fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Estado*</label>
                          <div class="col-sm-6">
                            <input type="hidden" id="estado_dir_id" value="<?= $oDatos->getEstadoDir() ?>">
                            <select class="form-control" id="id_estado_dir" name="id_estado_dir" onchange="loadMunicipios('id_estado_dir', 'id_municipio_dir')" title="Seleccione el estado en donde vive" tabindex="10" required>
                            </select>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione el estado en donde vive">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Delegación o Municipio*</label>
                          <div class="col-sm-6">
                            <input type="hidden" id="municipio_dir_id" value="<?= $oDatos->getMunicipioDir() ?>">
                            <select class="input-small form-control" id="id_municipio_dir" name="id_municipio_dir" title="Seleccione la delegación o municipio donde vive" tabindex="11" required>
                              <option selected disabled>seleccione un estado</option>
                            </select>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione la delegación o municipio donde vive">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Calle *</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="calle" name="calle" value="<?= $oDatos->getCalle() ?>" placeholder="Ingrese la Calle" title="Ingrese el nombre de la calle en donde vive" tabindex="12" onchange="uperCase('#calle')" required/>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Nombre de la calle en donde vive">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Colonia *</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="colonia" name="colonia" value="<?= $oDatos->getColonia() ?>" placeholder="Colonia" title="Ingrese la colonia donde vive" tabindex="13" onchange="uperCase('#colonia')" required/>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese la colonia donde vive">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">C.P.*</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="cp" name="cp" value="<?= $oDatos->getCP() ?>" placeholder="Ingrese el código postal" title="Ingrese el código postal" tabindex="14" onchange="numeros('#cp')" required/>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el código postal">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">¿Has trabajado con nosotros?*</label>
                          <div class="col-sm-6">
                            <div class="radio-inline">
                              <label>
                                <input type="radio" name="antiguedad" id="antiguedad1" value="1" tabindex="15" <?= ($oDatos->getAntiguedad() == 1) ? "checked" : "" ?> required>Si
                              </label>
                            </div>
                            <div class="radio-inline">
                              <label>
                                <input type="radio" name="antiguedad" id="antiguedad2" value="2" tabindex="16" <?= ($oDatos->getAntiguedad() == 2) ? "checked" : "" ?>  required>No
                              </label>
                            </div>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="¿Has trabajado con nosotros?">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Edad*</label>
                          <div class="col-sm-6">
                            <input type="number" class="form-control" id="edad" value="" placeholder="Ingrese su edad" title="Ingrese su edad" min="18" tabindex="17" required/>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese su edad">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Sexo*</label>
                          <div class="col-sm-6">
                            <div class="radio-inline">
                              <label>
                                <input type="radio" name="sexo" id="sexo1" onchange="tallaChk(1)" value="1" tabindex="18" <?= ($oDatos->getSexo() == 1) ? "checked" : "" ?> required>Hombre
                              </label>
                            </div>
                            <div class="radio-inline">
                              <label>
                                <input type="radio" name="sexo" id="sexo2" onchange="tallaChk(2)" value="2" tabindex="19" <?= ($oDatos->getSexo() == 2) ? "checked" : "" ?> required>Mujer
                              </label>
                            </div>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Selecciona tu sexo">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">N.S.S.*</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="nss" name="nss" value="<?= $oDatos->getNSS() ?>" placeholder="Número de seguridad social" title="Ingrese su NSS" tabindex="20" onchange="validarNss()" required/>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese número de seguridad social (11 digitos)">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                          <label id="res_nss"></label>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">RFC*</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="rfc" name="rfc" value="<?= $oDatos->getRFC() ?>" placeholder="Ingrese el RFC" title="Ingrese el RFC" tabindex="21"  onchange="validarRfc()" required/>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el RFC(10 dig sin homoclave, 13 con homoclave)">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                          <label id="res_rfc"></label>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">CURP*</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="curp" name="curp" value="<?= $oDatos->getCurp() ?>" placeholder="Ingrese su CURP" title="Ingrese su CURP" tabindex="22" onchange="validarCurp()" required/>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese su CURP">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                          <label id="res_curp"></label>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Correo Electrónico*</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="email" name="email" value="<?= $oDatos->getEmail() ?>" placeholder="ejemplo@correo.com" title="Ingrese su correo electrónico" tabindex="23" onchange="validarEmail()" required/>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese su correo electrónico (ejemplo@correo.com)">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                          <label id="res_correo"></label>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Celular Personal*</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="tel_cel" name="tel_cel" value="<?= $oDatos->getTelCel() ?>" placeholder="Ingrese su numero de celular" title="Ingrese su numero de celular" tabindex="24"  onchange="validarTel('#tel_cel', '#res_cel')" required/>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese su numero de celular (10 digitos)">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                          <label id="res_cel"></label>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Teléfono Particular*</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="tel_casa" name="tel_casa" value="<?= $oDatos->getTelCasa() ?>" placeholder="Ingrese su teléfono personal" title="Ingrese el código postal" tabindex="25"  onchange="validarTel('#tel_casa', '#res_tel')" required/>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese su teléfono personal (10 digitos)">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                          <label id="res_tel"></label>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">No. Int y Ext.*</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="num_int_ext" name="num_int_ext" value="<?= $oDatos->getNumIntExt() ?>" placeholder="Número interior y/o exterior" title="Numero interior y/o exterior" tabindex="26" required/>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Número interior y/o exterior">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Talla (solo mujeres)*</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="talla" name="talla" value="<?= $oDatos->getTalla() ?>" placeholder="Ingrese su talla" title="Ingrese su talla" tabindex="27" onchange="uperCase('#talla')" required/>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese su talla (solo mujeres)">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">¿Tienes hijos?*</label>
                          <div class="col-sm-6">
                            <div class="radio-inline">
                              <label>
                                <input type="radio" name="hijos" id="hijos1" value="1" tabindex="28" <?= ($oDatos->getHijos() == 1) ? "checked" : "" ?> required>Si
                              </label>
                            </div>
                            <div class="radio-inline">
                              <label>
                                <input type="radio" name="hijos" id="hijos2" value="2" tabindex="29" <?= ($oDatos->getHijos() == 2) ? "checked" : "" ?> required>No
                              </label>
                            </div>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="¿Tiene hijos?">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Número Crédito Infonavit(solo si tiene)</label>
                          <div class="col-sm-6">
                            <input type="text" name="credito_infonavit" id="credito_infonavit" class="formm-control" value="" tabindex="29" onchange="numeros('#credito_infonavit')">
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="¿Tiene hijos?">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="panel panel-midnightblue"> <!-- Información Médica -->
                  <div class="panel-heading">
                    <h4>
                      Información Médica
                    </h4>
                    <div class="options">
                      <a href="javascript:;"><i class="fa fa-cog"></i></a>
                      <!--a href="javascript:;" onclick="()"><i class="fa fa-refresh"></i></a-->
                      <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                    </div>
                  </div>
                  <div class="panel-body collapse in">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Enfermedades Crónicas*</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="enfermedades_cronicas" name="enfermedades_cronicas" value="<?= $oDatos->getEnfermedadesCronicas() ?>" placeholder="Enfermedades Crónicas" title="Enfermedades Crónicas" tabindex="30" onchange="uperCase('#enfermedades_cronicas')" required/>
                        </div>
                        <div class="col-sm-1">
                          <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Enfermedades Crónicas">
                            <span class="fa fa-info-circle"></span>
                          </a>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Medicamentos o Tratamientos*</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="med_tratamiento" name="med_tratamiento" value="<?= $oDatos->getMedTratamientos() ?>" placeholder="Medicamentos o tratamientos" title="Medicamento o tratamiento" tabindex="31" onchange="uperCase('#med_tratamiento')"  required>
                        </div>
                        <div class="col-sm-1">
                          <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="">
                            <span class="fa fa-info-circle"></span>
                          </a>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Operaciones Quirurgicas*</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="op_quirurgicas" name="op_quirurgicas" value="<?= $oDatos->getOpQuirurgicas() ?>" placeholder="Operaciones Quirurjicas" title="Operaciones Quirurgicas" tabindex="32" onchange="uperCase('#op_quirurgicas')" required>
                        </div>
                        <div class="col-sm-1">
                          <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="">
                            <span class="fa fa-info-circle"></span>
                          </a>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Alergias/Padecimientos*</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="alergias_padecimientos" name="alergias_padecimientos" value="<?= $oDatos->getAlergiasPadecimientos() ?>" placeholder="Alergia o Padecimiento" title="Alergia o Padecimiento" tabindex="33" onchange="uperCase('#alergias_padecimientos')" required/>
                        </div>
                        <div class="col-sm-1">
                          <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Alergia o Padecimiento">
                            <span class="fa fa-info-circle"></span>
                          </a>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Tipo Sanguineo*</label>
                        <div class="col-sm-6">
                          <select type="text" class="form-control" id="tipo_sangre" name="tipo_sangre" value="" title="Seleccione su tipo de sangre" tabindex="34" required>
                            <option selected disabled>Seleccione una opción</option>
                            <option value="1" <?= ($oDatos->getTipoSangre() == 1) ? "selected" : "" ?>>A+</option>
                            <option value="2" <?= ($oDatos->getTipoSangre() == 2) ? "selected" : "" ?>>A-</option>
                            <option value="3" <?= ($oDatos->getTipoSangre() == 3) ? "selected" : "" ?>>B+</option>
                            <option value="4" <?= ($oDatos->getTipoSangre() == 4) ? "selected" : "" ?>>B-</option>
                            <option value="5" <?= ($oDatos->getTipoSangre() == 5) ? "selected" : "" ?>>AB+</option>
                            <option value="6" <?= ($oDatos->getTipoSangre() == 6) ? "selected" : "" ?>>AB-</option>
                            <option value="7" <?= ($oDatos->getTipoSangre() == 7) ? "selected" : "" ?>>O+</option>
                            <option value="8" <?= ($oDatos->getTipoSangre() == 8) ? "selected" : "" ?>>O-</option>
                            <option value="9" <?= ($oDatos->getTipoSangre() == 9) ? "selected" : "" ?>>No Sabe</option>
                          </select>
                        </div>
                        <div class="col-sm-1">
                          <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione su tipo de sangre">
                            <span class="fa fa-info-circle"></span>
                          </a>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Contacto de Emergencia*</label>
                        <div class="col-sm-6">
                          <div class="input-group">
                            <input type="text" class="input-small form-control" id="contacto_emergencia" name="contacto_emergencia" value="<?= $oDatos->getContactoEmergencia() ?>" placeholder="Contacto de emergencia" title="Contacto de emergencia" tabindex="35"  onchange="uperCase('#contacto_emergencia')" required>
                            <span class="input-group-addon">Teléfono</span>
                            <input type="text" class="form-control" id="emergencia_tel" name="emergencia_tel" value="<?= $oDatos->getEmergenciaTel() ?>" placeholder="Ingrese teléfono" title="Ingrese el  teléfono" tabindex="35"  onchange="validarTel('#emergencia_tel', '#res_emergencia_tel')" required/>
                          </div>
                        </div>
                        <label id="res_emergencia_tel"></label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="panel panel-midnightblue"> <!-- Estudios Generales -->
                  <div class="panel-heading">
                    <h4>
                      Estudios Generales
                    </h4>
                    <div class="options">
                      <a href="javascript:;"><i class="fa fa-cog"></i></a>
                      <!--a href="javascript:;" onclick="()"><i class="fa fa-refresh"></i></a-->
                      <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                    </div>
                  </div>
                  <div class="panel-body collapse in">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Último Grado de Estudios*</label>
                          <div class="col-sm-6">
                            <select class="form-control" id="grado_estudios" name="grado_estudios" tabindex="36" required/>
                              <option selected disabled>Seleccione una Opción</option>
                              <option value="1" <?= ($oDatos->getGradoEstudios() == 1) ? "selected" : "" ?>>PRIMARIA</option>
                              <option value="2" <?= ($oDatos->getGradoEstudios() == 2) ? "selected" : "" ?>>SECUNDARIA</option>
                              <option value="3" <?= ($oDatos->getGradoEstudios() == 3) ? "selected" : "" ?>>PREPARATORIA</option>
                              <option value="4" <?= ($oDatos->getGradoEstudios() == 4) ? "selected" : "" ?>>CARRERA TÉCNICA</option>
                              <option value="5" <?= ($oDatos->getGradoEstudios() == 5) ? "selected" : "" ?>>LICENCIATURA</option>
                            </select>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione el grado de estudios">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Escuela*</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="escuela" name="escuela" value="<?= $oDatos->getEscuela() ?>" placeholder="Ingrese el nombre de la escuela" title="Nombre del candidato" tabindex="37" onchange="uperCase('#escuela')" required/>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Nombre de la escuela del ultimo grado de estudios">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Periodo*</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="periodo" name="periodo" value="<?= $oDatos->getPeriodo() ?>" placeholder="Ingrese el periodo" title="Nombre del candidato" tabindex="38" required/>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el peridodo (2012-2016)">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Título Obtenido*</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="titulo" name="titulo" value="<?= $oDatos->getTitulo() ?>" placeholder="Ingrese el titulo obtenido" title="Ingrese el titulo obtenido" tabindex="39" onchange="uperCase('#titulo')" required/>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el titulo obtenido">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="panel panel-midnightblue"> <!-- Otros -->
                  <div class="panel-heading">
                    <h4>
                      Otros
                    </h4>
                    <div class="options">
                      <a href="javascript:;"><i class="fa fa-cog"></i></a>
                      <!--a href="javascript:;" onclick="()"><i class="fa fa-refresh"></i></a-->
                      <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                    </div>
                  </div>
                  <div class="panel-body collapse in">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Software que Manejas*</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="software" name="software" value="<?= $oDatos->getSoftware() ?>" placeholder="Ingrese el software que maneja" title="Ingrese el software que maneja" tabindex="40" onchange="uperCase('#software')" required/>
                        </div>
                        <div class="col-sm-1">
                          <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el software que maneja">
                            <span class="fa fa-info-circle"></span>
                          </a>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Nivel de Manejo*</label>
                        <div class="col-sm-6">
                          <select class="form-control" id="nivel_software" name="nivel_software" title="Seleccione el nivel de manejo" tabindex="42" required>
                            <option selected disabled>Seleccione una opción</option>
                            <option value="1" <?= ($oDatos->getNivelSoftware() == 1) ? "selected" : "" ?>>BÁSICO</option>
                            <option value="2" <?= ($oDatos->getNivelSoftware() == 2) ? "selected" : "" ?>>MEDIO</option>
                            <option value="3" <?= ($oDatos->getNivelSoftware() == 3) ? "selected" : "" ?>>ALTO</option>
                            <option value="4" <?= ($oDatos->getNivelSoftware() == 4) ? "selected" : "" ?>>AVANZADO</option>
                          </select>
                        </div>
                        <div class="col-sm-1">
                          <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el software que maneja">
                            <span class="fa fa-info-circle"></span>
                          </a>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Tipo de Smartphone*</label>
                        <div class="col-sm-6">
                          <select class="form-control" id="tipo_smartphone" name="tipo_smartphone" title="Seleccione una opción" tabindex="41" required>
                            <option selected disabled>Seleccione una opción</option>
                            <option value="1" <?= ($oDatos->getTipoSmartphone() == 1) ? "selected" : "" ?>>NO TENGO</option>
                            <option value="2" <?= ($oDatos->getTipoSmartphone() == 2) ? "selected" : "" ?>>ANDROID</option>
                            <option value="3" <?= ($oDatos->getTipoSmartphone() == 3) ? "selected" : "" ?>>IOS (IPHONE)</option>
                          </select>
                        </div>
                        <div class="col-sm-1">
                          <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="">
                            <span class="fa fa-info-circle"></span>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="panel panel-midnightblue"> <!-- Referencias Personales -->
                  <div class="panel-heading">
                    <h4>
                      Referencias Personales
                    </h4>
                    <div class="options">
                      <a href="javascript:;"><i class="fa fa-cog"></i></a>
                      <a href="javascript:;" onclick=""><i class="fa fa-times"></i></a>
                      <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                    </div>
                  </div>
                  <div class="panel-body collapse in">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Nombre*</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="referencia_nombre_1" name="referencia_nombre_1" value="<?= $oDatos->getRefNom1() ?>" placeholder="Ingrese Nombre" title="Ingrese Nombre" tabindex="43" onchange="uperCase('#referencia_nombre_1')" required/>
                        </div>
                        <div class="col-sm-1">
                          <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el nombre">
                            <span class="fa fa-info-circle"></span>
                          </a>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Teléfono*</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="referencia_tel_1" name="referencia_tel_1" value="<?= $oDatos->getRefTel1() ?>" placeholder="Ingrese teléfono" title="Ingrese el  teléfono" tabindex="44"  onchange="validarTel('#referencia_tel_1', '#res_ref_tel_1')" required/>
                        </div>
                        <div class="col-sm-1">
                          <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el teléfono">
                            <span class="fa fa-info-circle"></span>
                          </a>
                        </div>
                        <label id="res_ref_tel_1"></label>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Parentesco*</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="parentesco_1" name="parentesco_1" value="<?= $oDatos->getParentesco1() ?>" placeholder="Ingrese su parentesco" title="Ingrese el código postal" tabindex="45" onchange="uperCase('#parentesco_1')" required/>
                        </div>
                        <div class="col-sm-1">
                          <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese su parentesco">
                            <span class="fa fa-info-circle"></span>
                          </a>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Nombre*</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="referencia_nombre_2" name="referencia_nombre_2" value="<?= $oDatos->getRefNom2() ?>" placeholder="Ingrese Nombre" title="Ingrese Nombre" tabindex="46" onchange="uperCase('#referencia_nombre_2')" required/>
                        </div>
                        <div class="col-sm-1">
                          <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el nombre">
                            <span class="fa fa-info-circle"></span>
                          </a>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Teléfono*</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="referencia_tel_2" name="referencia_tel_2" value="<?= $oDatos->getRefTel2() ?>" placeholder="Ingrese teléfono" title="Ingrese el  teléfono" tabindex="47"  onchange="validarTel('#referencia_tel_2', '#res_ref_tel_2')" required/>
                        </div>
                        <div class="col-sm-1">
                          <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el teléfono">
                            <span class="fa fa-info-circle"></span>
                          </a>
                        </div>
                        <label id="res_ref_tel_2"></label>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Parentesco*</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="parentesco_2" name="parentesco_2" value="<?= $oDatos->getParentesco2() ?>" placeholder="Ingrese su parentesco" title="Ingrese el código postal" tabindex="48" onchange="uperCase('#parentesco_2')" required/>
                        </div>
                        <div class="col-sm-1">
                          <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese su parentesco">
                            <span class="fa fa-info-circle"></span>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="panel panel-midnightblue"> <!-- Empleo Anterior/Experiencia -->
                  <div class="panel-heading">
                    <h4>
                      Empleo Anterior/Experiencia
                    </h4>
                    <div class="options">
                      <a href="javascript:;"><i class="fa fa-cog"></i></a>
                      <!--a href="javascript:;" onclick="()"><i class="fa fa-refresh"></i></a-->
                      <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                    </div>
                  </div>
                  <div class="panel-body collapse in">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Empresa*</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="eAnterior_empresa" name="eAnterior_empresa" value="<?= $oDatos->getEAnteriorEmpresa() ?>" placeholder="Ingrese nombre de la empresa" title="Ingrese nombre de la empresa" tabindex="49" onchange="uperCase('#eAnterior_empresa')"  required/>
                        </div>
                        <div class="col-sm-1">
                          <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Nombre del candidato">
                            <span class="fa fa-info-circle"></span>
                          </a>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Fecha de Ingreso*</label>
                        <div class="col-sm-6">
                          <div class="input-group date datepicker">
                            <input type="text" class="form-control" id="eAnterior_fecha_ingreso" name="eAnterior_fecha_ingreso" placeholder="Seleccione la fecha de ingreso" title="Seleccione la fecha" value="<?= $oDatos->getEAnteriorFechaIngreso() ?>" tabindex="50" required/>
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                          </div>
                        </div>
                        <div class="col-sm-1">
                          <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione la fecha">
                            <span class="fa fa-info-circle"></span>
                          </a>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Puesto*</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="eAnterior_puesto" name="eAnterior_puesto" value="<?= $oDatos->getEAnteriorPuesto() ?>" placeholder="Ingrese puesto" title="Ingrese puesto" tabindex="51" onchange="uperCase('#eAnterior_puesto')" required/>
                        </div>
                        <div class="col-sm-1">
                          <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese puesto">
                            <span class="fa fa-info-circle"></span>
                          </a>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Nombre de Jefe Inmediato*</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="eAnterior_jefe" name="eAnterior_jefe" value="<?= $oDatos->getEAnteriorJefe() ?>" placeholder="Ingrese nombre del jefe inmediato" title="Ingrese nombre del jefe inmediato" tabindex="52" onchange="uperCase('#eAnterior_jefe')" required/>
                        </div>
                        <div class="col-sm-1">
                          <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese nombre del jefe inmediato">
                            <span class="fa fa-info-circle"></span>
                          </a>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Teléfono</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="eAnterior_tel" name="eAnterior_tel" value="<?= $oDatos->getEAnteriorTel() ?>" placeholder="Ingrese télefono " title="Ingrese télefono " tabindex="53"  onchange="validarTel('#eAnterior_tel', '#res_empleo_ant_tel')" required/>
                        </div>
                        <div class="col-sm-1">
                          <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Teléfono del empleo anterior">
                            <span class="fa fa-info-circle"></span>
                          </a>
                        </div>
                        <label id='res_empleo_ant_tel'></label>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Fecha de Salida*</label>
                        <div class="col-sm-6">
                          <div class="input-group date datepicker">
                            <input type="text" class="form-control" id="eAnterior_fecha_salida" name="eAnterior_fecha_salida" placeholder="Seleccione la fecha de salida" title="Seleccione la fecha e salida" value="<?= $oDatos->getEAnteriorFechaSalida() ?>" tabindex="54" required/>
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                          </div>
                        </div>
                        <div class="col-sm-1">
                          <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione la fecha de salida">
                            <span class="fa fa-info-circle"></span>
                          </a>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Motivo de Salida*</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="eAnterior_motivo_salida" name="eAnterior_motivo_salida" value="<?= $oDatos->getEAnteriorMotivoSalida() ?>" placeholder="Ingrese motivo de salida" title="Ingrese motivo de salida" tabindex="55"  onchange="uperCase('#eAnterior_motivo_salida')" required/>
                        </div>
                        <div class="col-sm-1">
                          <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese su motivo de salida">
                            <span class="fa fa-info-circle"></span>
                          </a>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Puesto de Jefe Inmediato*</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="eAnterior_puesto_jefe" name="eAnterior_puesto_jefe" value="<?= $oDatos->getEAnteriorPuestoJefe() ?>" placeholder="Ingrese nombre del jefe inmediato" title="Ingrese nombre del jefe inmediato"  tabindex="56" onchange="uperCase('#eAnterior_puesto_jefe')" required/>
                        </div>
                        <div class="col-sm-1">
                          <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese nombre del jefe inmediato">
                            <span class="fa fa-info-circle"></span>
                          </a>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12" id="seccion_cv">
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Curriculum</label>
                        <div class="col-sm-9">
                          <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="input-group">
                              <div class="form-control uneditable-input" data-trigger="fileinput">
                                <i class="fa fa-file fileinput-exists"></i>&nbsp;<span class="fileinput-filename"></span>
                              </div>
                              <span class="input-group-addon btn btn-default btn-file">
                                <span class="fileinput-new">Seleccione un archivo</span>
                                <span class="fileinput-exists">Cambiar</span>
                                <input type="file" id="archivo" name="archivo" onchange="validarCV()" tabindex="57">
                              </span>
                              <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Quitar</a>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-1">
                          <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="formatos permitidos(pdf, doc , docx)">
                            <span class="fa fa-info-circle"></span>
                            <label id="res_cv"></label>
                          </a>
                        </div>
                      </div>
                    </div>
                    <!--
                  <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Introduce el texto de la imagen  *</label>
                      <div class="col-sm-6">
                        <img  id="captcha" src="securimage/securimage_show.php" alt="CAPTCHA Image" />
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="text" name="captcha_code" size="10" maxlength="6"  required />
                      <a href="#" onclick="document.getElementById('captcha').src = 'securimage/securimage_show.php?' + Math.random(); return false">[ Cambiar la imagen  ]</a>
                    </div>
                  </div>-->
                  <div class="col-md-12" id="rh" hidden>
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Estado Solicitud*</label>
                        <div class="col-sm-9">
                          <input type="hidden" id="id_estado_civil" value="<?= $oDatos->getEstadoCivil() ?>">
                          <select class="form-control" id="status" name="status" tabindex="9" required/>
                            <option selected disabled>Seleccione una Opción</option>
                            <option value="1" <?= ($oDatos->getStatus() == 1) ? "selected" : "" ?>>Abierto</option>
                            <option value="2" <?= ($oDatos->getStatus() == 2) ? "selected" : "" ?>>En proceso</option>
                            <option value="3" <?= ($oDatos->getStatus() == 3) ? "selected" : "" ?>>Contratado</option>
                            <option value="4" <?= ($oDatos->getStatus() == 4) ? "selected" : "" ?>>Rechazado</option>
                          </select>
                        </div>
                        <div class="col-sm-1">
                          <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione su estado civil">
                            <span class="fa  fa-info-circle"></span>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="panel-footer">
                    <div class="alert alert-info" style="margin-top:15px">
                      <p align="center">
                        <strong align="center">Aviso de Privacidad.</strong></br>
                      </p>
                      <p align="justify">
                        Sustentado en los artículos 15 y 16 de  la Ley Federal de Protección de Datos Personales en Posesión de Particulares hacemos de su conocimiento que TOPMKT, S.A. DE C.V. es responsable de recabar sus datos personales, del uso que se les da a los mismos y de su protección. Es importante informarle que usted tiene derecho al Acceso, Rectificación y Cancelación de sus datos personales, a Oponerse al tratamiento de los mismos o a revocar el consentimiento que para dicho fin nos haya otorgado. Para ello, es necesario que envié la solicitud en los términos que marca la Ley en su Art. 29 al LETICIA PEREZ VENEGAS, responsable de nuestro departamento de protección de Datos Personales, ubicado en HALLEY No.3 COL. ANZURES DEL. MIGUEL HIDALGO C.P.11590 HALLEY, MEXICO D.F., o bien, se comunique  al teléfono  5591126192 o vía correo electrónico a leticia.perez@topmkt.com.mx, el cual solicitamos confirme vía telefónica para garantizar su correcta recepción. En caso de que no obtengamos su oposición expresa para que sus datos personales sean transferidos en la forma y términos antes descrita, entenderemos que ha otorgado su consentimiento en forma táctica para ello.
                      </p>
                    </div>
                    <div class="alert alert-danger" style="margin-top:15px">
                      <center>
                        <strong>ATENCION.</strong></br>
                        Al dar click en <strong>GUARDAR</strong> esta <strong>ACEPTANDO</strong> el aviso de privacidad.
                      </center>
                    </div>
                    <div class="row">
                      <div class="col-sm-6 col-sm-offset-3">
                        <div class="btn-toolbar">
                          <button type="submit" class="btn-primary btn btn-label" id="saveButton" tabindex="58"><i class="fa fa-save"></i> Guardar</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div> <!-- container -->
      </div> <!--wrap -->
      <footer role="contentinfo">
        <div class="clearfix">
          <ul class="list-unstyled list-inline pull-left">
            <li>Top MKT &copy; 2018</li>
          </ul>
          <button class="pull-right btn btn-inverse-alt btn-xs hidden-print" id="back-to-top"><i class="fa fa-arrow-up"></i></button>
        </div>
      </footer>
    </div> <!-- page-container -->
    <script type='text/javascript' src='assets/js/jquery-1.10.2.min.js'></script>
    <script type='text/javascript' src='assets/js/jqueryui-1.10.3.min.js'></script>
    <script type='text/javascript' src='assets/js/bootstrap.min.js'></script>
    <script type='text/javascript' src='assets/js/enquire.js'></script>
    <script type='text/javascript' src='assets/js/jquery.cookie.js'></script>
    <script type='text/javascript' src='assets/js/jquery.nicescroll.min.js'></script>
    <script type='text/javascript' src='assets/plugins/codeprettifier/prettify.js'></script>
    <script type='text/javascript' src='assets/plugins/sparklines/jquery.sparklines.min.js'></script>
    <script type='text/javascript' src='assets/plugins/form-toggle/toggle.min.js'></script>
    <script type='text/javascript' src='assets/plugins/form-select2/select2.min.js'></script>
    <script type='text/javascript' src='assets/plugins/form-daterangepicker/daterangepicker.min.js'></script>
    <script type='text/javascript' src='assets/plugins/form-datepicker/js/bootstrap-datepicker.js'></script>
    <script type='text/javascript' src='assets/plugins/form-jasnyupload/fileinput.min.js'></script>
    <script type='text/javascript' src='assets/js/placeholdr.js'></script>
    <script type='text/javascript' src='assets/js/application.js'></script>
    <script type='text/javascript' src='assets/demo/demo.js'></script>
    <script src="assets/js/noty/js/noty/packaged/jquery.noty.packaged.min.js" type="text/javascript"></script>
    <script type='text/javascript' src='assets/plugins/progress-skylo/skylo.js'></script>
    <script type='text/javascript' src='assets/js/pages/rh02_curriculum2.js'></script>
  </body>
</html>
