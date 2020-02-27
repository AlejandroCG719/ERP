<?php
  session_start();
  require("includes/main.php");
  require("classes/InfoGen.php");
  $oEmpleado = new InfoGen();
  $oEmpleado->setConsulta($_SESSION['id_empleado']);
	if($_SESSION['bandera_inicio']!=1){
		header("Location: login.php");
	}
  //paginas con breadcrumbs
  require("classes/Breadcrumb.php");
  $oBreadcrumb = new Breadcrumb();
  $oBreadcrumb->setConsulta($_SESSION['id_perfil']);

  //paginas con carga de info
  require("classes/Empleado.php");
  $oDatos = new Empleado();
  if (isset($_GET['id_empleado'])) {
    $oDatos->setConsulta($_GET['id_empleado']);
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
		<link rel="icon" href="<?php echo PATH; ?>images/favicon.png">

	  <!-- <link href="assets/less/styles.less" rel="stylesheet/less" media="all">  -->
	  <link rel="stylesheet" href="assets/css/styles.css?=121">
	  <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>
	  <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='styleswitcher'>
	  <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='headerswitcher'>

		<link rel='stylesheet' type='text/css' href='assets/plugins/codeprettifier/prettify.css' />
		<link rel='stylesheet' type='text/css' href='assets/plugins/form-toggle/toggles.css' />
		<link rel='stylesheet' type='text/css' href='assets/plugins/progress-skylo/skylo.css' />
		<script type="text/javascript" src="assets/js/less.js"></script>
	</head>
	<body>
	  <?php require("snippets/header.php"); ?>
	  <div id="page-container">
			<?php require("snippets/sidebars.php"); ?>
			<div id="page-content">
				<div id='wrap'>
					<div id="page-heading">
						<ol class="breadcrumb">
							<li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
							<li><a href="rh01_empleados_listado.php"><i class="<?= $oBreadcrumb->getImagen() ?>"></i> Empleados</a></li>
							<li class="active">Edición de Empleado</li>
						</ol>
						<h1>Registro de Empleados</h1>
						<div class="options">
							<div class="btn-toolbar">
								<div class="btn-group hidden-xs">
									<!--a href='#' class="btn btn-default dropdown-toggle" data-toggle='dropdown'><i class="fa fa-cloud-download"></i><span class="hidden-sm"> Export as  </span><span class="caret"></span></a-->
									<ul class="dropdown-menu">
										<li><a href="#">Text File (*.txt)</a></li>
										<li><a href="#">Excel File (*.xlsx)</a></li>
										<li><a href="#">PDF File (*.pdf)</a></li>
									</ul>
								</div>
								<a href='rh01_empleados_edicion.php' class="btn btn-default"><i class="fa fa-plus"></i><span class="hidden-sm"> Nuevo empleado</span></a>
							</div>
						</div>
					</div>
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<div id="message">
									<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert">&times;</a>Los Datos marcados con <strong>(*) son obligatorios.</strong></div>
								</div>
                <form  action="" class="form-horizontal row-border" method="post" id="frm-empleado" name="formEmpleado">
  								<div class="panel panel-midnightblue">
                    <input type="hidden" id="puesto" value="<?= $oDatos->getPuesto() ?>" />
                    <input type="hidden" id="id_empleado" name="id_empleado" value="<?= $oDatos->getId() ?>">
                    <div class="panel-heading">
                      <h4>
                        Datos Personales
                      </h4>
                      <div class="options">
                        <a href="javascript:;"><i class="fa fa-cog"></i></a>
                        <!--a href="javascript:;" onclick="loadModulos()"><i class="fa fa-refresh"></i></a-->
                        <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                      </div>
                    </div>
                    <div class="panel-body collapse in">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
														<label class="col-sm-4 control-label">Fecha Nacimiento*</label>
														<div class="col-sm-7">
															<div class="input-group date datepicker">
																<input type="text" class="form-control" id="fecha_nac" name="fecha_nac" value="<?= $oDatos->getFechaNac() ?>" placeholder="Seleccione la fecha de nacimiento del empleado" title="Seleccione la fecha de nacimiento del empleado" tabindex="7" required />
																<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
															</div>
														</div>
													</div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Nombre(s)*</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" id="nombres" name="nombres" value="<?= $oDatos->getNombres() ?>" placeholder="Ingrese el/los nombre(s) del empleado" title="Ingrese el/los nombre(s) del empleado" tabindex="1" required />
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Apellido Materno</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" id="apm" name="apm" value="<?= $oDatos->getApm() ?>" placeholder="Ingrese el apellido materno del empleado" title="Ingrese el apellido paterno del empleado" tabindex="3" />
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Sexo*</label>
                            <div class="col-sm-7">
                              <label class="radio-inline">
                                <input type="radio" name="optionsRadios" id="optionsRadios1" value="1" checked="">Hombre
                              </label>
                              <label class="radio-inline">
                                <input type="radio" name="optionsRadios" id="optionsRadios2" value="2"> Mujer
                              </label>
                            </div>
                          </div>
													<div class="form-group">
                            <label class="col-sm-4 control-label">Curp*</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" id="curp" name="curp" pattern=".{18,18}" value="<?= $oDatos->getCurp() ?>" placeholder="Ingrese el curp del empleado" title="Ingrese el curp del empleado" tabindex="4" onchange="validarCurp()" required />
                            </div>
                            <label class="col-sm-1 control-label" id="res_curp"></label>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">NSS*</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" id="nss" name="nss" value="<?= $oDatos->getNSS() ?>" placeholder="Ingrese el NSS del empleado" title="Ingrese el NSS del empleado (11 digitos)" pattern=".{11,11}" tabindex="6" onchange="nssValida()" required />
                            </div>
                            <label class="col-sm-1 control-label" id="res_nss"></label>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Delegación o Municipio*</label>
                            <div class="col-sm-7">
                              <select class="input-small form-control" id="id_municipio_dir" name="id_municipio_dir" >
                                <option selected disabled>seleccione un estado</option>
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Calle*</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" id="calle" name="calle" value="<?= $oDatos->getDir() ?>" placeholder="Ingrese la calle donde vive el empleado" title="Ingrese la calle donde vive el empleado" tabindex="9" required />
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">No. Int</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" id="no_int" name="no_int" value="<?= $oDatos->getNSS() ?>" placeholder="Ingrese el NSS del empleado" title="Ingrese el NSS del empleado" tabindex="6"/>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Teléfono Celular</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" id="tel_cel" name="tel_cel" value="<?= $oDatos->getTel() ?>" placeholder="Ingrese el teléfono del empleado" title="Ingrese el telefono del empleado (10 digitos)" pattern=".{10,10}" tabindex="8" onchange="validarTel('#tel_cel','#res_cel')" required />
                            </div>
                            <label class="col-sm-1 control-label" id="res_cel"></label>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Escolaridad</label>
                            <div class="col-sm-7">
                              <select class="input-small form-control" id="id_municipio_dir" name="id_municipio_dir" >
                                <option selected disabled>seleccione una opcion</option>
                                <option>Primaria</option>
                                <option>Secundaria</option>
                                <option>Secundaria(Trunca)</option>
                                <option>Preparatoria</option>
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Banco</label>
                            <div class="col-sm-7">
                              <select class="form-control" id="tel_cel" name="tel_cel" title="Seleccione un banco" tabindex="8" required >
                                <option selected disabled>Seleccione un banco</option>
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Clabe Interbancaria</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" id="clabe" name="clabe" value="<?= $oDatos->getTel() ?>" placeholder="Ingrese la clabe interbancaria" title="Ingrese el telefono del empleado" pattern=".{18,18}" tabindex="8" onchange="validarClabe()" required />
                            </div>
                            <label class="col-sm-1 control-label" id="res_clabe"></label>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">No. Crédito (Infonavit)</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" id="cred_infonavit" name="cred_infonavit" value="<?= $oDatos->getTel() ?>" placeholder="Ingrese el número de cuenta" title="Ingrese el número de cuenta" tabindex="8" onchange="validarInfonavit()" required/>
                            </div>
                            <label class="col-sm-1 control-label" id="res_infonavit"></label>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Lugar de Nacimiento*</label>
                            <div class="col-sm-7">
                              <div class="input-daterange input-group datepicker">
                                <select class="input-small form-control load-estados-mex" id="id_estado_lugar_nac" name="id_estado_lugar_nac" onchange="loadMunicipios('id_estado_lugar_nac' , 'id_municipio_lugar_nac')">
                                  <option selected disabled>seleccione un estado</option>
                                </select>
                                <span class="input-group-addon">Municipio</span>
                                <select class="input-small form-control" id="id_municipio_lugar_nac" name="id_municipio_lugar_nac" >
                                  <option selected disabled>seleccione un estado</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Apellido Paterno*</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" id="app" name="app" value="<?= $oDatos->getApp() ?>" placeholder="Ingrese el apellido parterno del empleado" title="Ingrese el apellido paterno del empleado" tabindex="2" required />
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Nacionalidad*</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" id="nacionalidad" name="nacionalidad" value="<?= $oDatos->getRFC() ?>" placeholder="Ingrese la nacionalidad del empleado" title="Ingrese el RFC del empleado" tabindex="5" required />
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Estado Civil*</label>
                            <div class="col-sm-7">
                              <select class="form-control" id="id_estado_civil" name="id_estado_civil" value="<?= $oDatos->getRFC() ?>" placeholder="Ingrese la nacionalidad del empleado" title="Ingrese el RFC del empleado" tabindex="5" onchange="estadoCivil()" required >
                                <option selected disabled>Seleccione una opción</option>
                                <option value="1">Soltero(a)</option>
                                <option value="2">Casado(a)</option>
                                <option value="3">Union libre</option>
                                <option value="4">Viudo(a)</option>
                                <option value="5">Divorciado(a)</option>
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">RFC*</label>
                            <div class="col-sm-7">
                              <div class="input-group">
                                <input type="text" class="form-control" id="rfc" name="rfc" value="<?= $oDatos->getRFC() ?>" placeholder="Ingrese el RFC del empleado" title="Ingrese el RFC del empleado" pattern=".{10,10}" tabindex="5" required />
                                <span class="input-group-addon">Homoclave</span>
                                <input type="text" class="form-control" id="rfc_homoclave" name="rfc_homoclave" value="<?= $oDatos->getRFC() ?>" placeholder="Ingrese el RFC del empleado" title="Ingrese el RFC del empleado" pattern=".{3,3}" tabindex="5"/>
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Estado:*</label>
                            <div class="col-sm-7">
                              <select class="form-control load-estados-mex" id="id_estado_dir" name="id_estado_dir" onchange="loadMunicipios('id_estado_dir', 'id_municipio_dir')" value="<?= $oDatos->getTel() ?>" title="Seleccione un estado" tabindex="8" required>
                                <option selected disabled>seleccione un estado</option>
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Colonia:*</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" id="colonia" name="colonia" value="<?= $oDatos->getTel() ?>" placeholder="Ingrese el teléfono del empleado" title="Ingrese el telefono del empleado" tabindex="8" required />
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">No. Ext*</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" id="no_ext" name="no_ext" value="<?= $oDatos->getNSS() ?>" placeholder="Ingrese el NSS del empleado" title="Ingrese el NSS del empleado" tabindex="6" required />
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Teléfono Casa</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" id="tel_casa" name="tel_casa" value="<?= $oDatos->getTel() ?>" placeholder="Ingrese el teléfono del empleado" title="Ingrese el telefono del empleado" pattern=".{10,10}" tabindex="8" onchange="validarTel('#tel_casa','#res_casa')" required />
                            </div>
                            <label class="col-sm-1 control-label" id="res_casa"></label>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Teléfono Recados</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" id="tel_recados" name="tel_recados" value="<?= $oDatos->getTel() ?>" placeholder="Ingrese el teléfono del empleado" title="Ingrese el telefono del empleado" pattern=".{10,10}" tabindex="8" onchange="validarTel('#tel_recados','#res_recados')" required />
                            </div>
                            <label class="col-sm-1 control-label" id="res_recados"></label>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Carrera </label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" id="carrera" name="carrera" value="<?= $oDatos->getTel() ?>" placeholder="Ingrese el teléfono del empleado" title="Ingrese el telefono del empleado" tabindex="8" required />
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Número de Cuenta</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" id="num_cuenta" name="num_cuenta" value="<?= $oDatos->getTel() ?>" placeholder="Ingrese el número de cuenta" title="Ingrese el número de cuenta" pattern=".{10,11}" tabindex="8" onchange="validarCuenta()" required />
                            </div>
                            <label class="col-sm-1 control-label" id="res_cuenta"></label>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Infonavit</label>
                            <div class="col-sm-7">
                              <select type="text" class="form-control" id="infonavit" name="infonavit" title="Seleccione " tabindex="8" required onchange="validarInfonavit()">
                                <option selected disabed>Seleccione una opción</option>
                                <option value="1">Veces salario minimo</option>
                                <option value="2">Cuota Fija</option>
                                <option value="3">Porcentaje</option>
                                <option value="4">N/A</option>
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Factor de descuento</label>
                            <div class="col-sm-7">
                              <input type="number" class="form-control" id="descuento_infonavit" name="descuento_infonavit" placeholder="Ingrese el monto" title="Ingrese el monto" step="0.01" min="0" tabindex="8" required />
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-midnightblue">
                    <input type="hidden" id="puesto" value="<?= $oDatos->getPuesto() ?>" />
                    <input type="hidden" id="id_empleado" name="id_empleado" value="<?= $oDatos->getId() ?>">
                    <div class="panel-heading">
                      <h4>
                        Datos Familiares
                      </h4>
                      <div class="options">
                        <a href="javascript:;"><i class="fa fa-cog"></i></a>
                        <!--a href="javascript:;" onclick="loadModulos()"><i class="fa fa-refresh"></i></a-->
                        <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                      </div>
                    </div>
                    <div class="panel-body collapse in">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group" >
                            <label class="col-sm-4 control-label">Nombre del Padre*</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" id="nombre_padre" name="nombre_padre" value="<?= $oDatos->getNombres() ?>" placeholder="Nombre completo del padre del empleado" title="Ingrese el nombre completo del padre del empleado" tabindex="1" required />
                            </div>
                          </div>
                          <div class="form-group" >
                            <label class="col-sm-4 control-label">Nombre de Conyugue*</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" id="conyugue" name="conyugue" value="<?= $oDatos->getNombres() ?>" placeholder="Nombre completo del padre del empleado" title="Ingrese el nombre completo del padre del empleado" tabindex="1" required />
                            </div>
                          </div>
                          <div class="form-group hijos">
                            <label class="col-sm-4 control-label">Cuantos*</label>
                            <div class="col-sm-7">
                              <input type="number" class="form-control" id="cant_hijos" name="cant_hijos" value="<?= $oDatos->getNombres() ?>" placeholder="Ingrese el número de hijos" title="Ingrese el número de hijos" tabindex="1"  required />
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
													<div class="form-group">
														<label class="col-sm-4 control-label">Nombre de la Madre*</label>
														<div class="col-sm-7">
															<input type="text" class="form-control" id="nombre_madre" name="nombre_madre" value="<?= $oDatos->getFechaNac() ?>" placeholder="Nombre completo de la madre del empleado" title="Ingrese el nombre completo de la madre del empleado" tabindex="7" required />
														</div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Hijos*</label>
                            <div class="col-sm-7">
                              <label class="radio-inline">
                                <input type="radio" name="hijos" id="hijos" value="1" onchange="hijosShow(1)">Si
                              </label>
                              <label class="radio-inline">
                                <input type="radio" name="hijos" id="hijos" value="2" onchange="hijosShow(2)"> No
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-midnightblue">
                    <input type="hidden" id="puesto" value="<?= $oDatos->getPuesto() ?>" />
                    <input type="hidden" id="id_empleado" name="id_empleado" value="<?= $oDatos->getId() ?>">
                    <div class="panel-heading">
                      <h4>
                        Datos Medicos y Contacto de Emergencia del Empleado
                      </h4>
                      <div class="options">
                        <a href="javascript:;"><i class="fa fa-cog"></i></a>
                        <!--a href="javascript:;" onclick="loadModulos()"><i class="fa fa-refresh"></i></a-->
                        <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                      </div>
                    </div>
                    <div class="panel-body collapse in">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group" >
                            <label class="col-sm-4 control-label">Tipo de Sangre</label>
                            <div class="col-sm-7">
                              <select class="form-control" id="id_tipo_sangre" name="id_tipo_sangre" value="<?= $oDatos->getNombres() ?>" title="Seleccione un tipo de sangre" tabindex="1" required>
                              </select>
                            </div>
                          </div>
                          <div class="form-group" >
                            <label class="col-sm-4 control-label">Enfermedad o Padecimiento</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" id="enfermedad_padecimiento" name="enfermedad_padecimiento" value="<?= $oDatos->getNombres() ?>" placeholder="Ingrese la enfermedad o padecimiento del empleado"  title="Ingrese la enfermedad o padecimiento" tabindex="1" required>
                            </div>
                          </div>
                          <div class="form-group" >
                            <label class="col-sm-4 control-label">Contacto de Emergencia</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" id="contacto_emergencia" name="contacto_emergencia" value="<?= $oDatos->getNombres() ?>" placeholder="Ingrese el contacto de emergencia" title="Ingrese el contacto de emergencia" tabindex="1" required>
                            </div>
                          </div>
                          <div class="form-group" >
                            <label class="col-sm-4 control-label">Telefono(s)</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" id="contacto_emergencia" name="contacto_emergencia" value="<?= $oDatos->getNombres() ?>" placeholder="Ingrese el/los telefonos del contacto de emergencia" title="Ingrese el contacto de emergencia" tabindex="1" required>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
														<label class="col-sm-4 control-label">Alergias</label>
														<div class="col-sm-7">
															<input type="text" class="form-control" id="alergias" name="alergias" value="<?= $oDatos->getFechaNac() ?>" placeholder="Ingrese la alergia del empleado" title="Ingrese la alergia del empleado" tabindex="7" required />
														</div>
													</div>
                          <div class="form-group" style="height:89px !important"></div>
                          <div class="form-group" >
                            <label class="col-sm-4 control-label">Parentesco</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" id="contacto_parentesco" name="contacto_parentesco" value="<?= $oDatos->getNombres() ?>" placeholder="Ingrese el parentesco con el empleado" title="Ingrese el contacto de emergencia" tabindex="1" required>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-midnightblue">
                    <input type="hidden" id="puesto" value="<?= $oDatos->getPuesto() ?>" />
                    <input type="hidden" id="id_empleado" name="id_empleado" value="<?= $oDatos->getId() ?>">
                    <div class="panel-heading">
                      <h4>
                        Datos de la Empresa
                      </h4>
                      <div class="options">
                        <a href="javascript:;"><i class="fa fa-cog"></i></a>
                        <!--a href="javascript:;" onclick="loadModulos()"><i class="fa fa-refresh"></i></a-->
                        <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                      </div>
                    </div>
                    <div class="panel-body collapse in">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group" >
                            <label class="col-sm-4 control-label">ID (No. Empleado)*</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" id="no_empleado" name="no_empleado" value="<?= $oDatos->getNombres() ?>" placeholder="Ingrese el/los nombre(s) del empleado" title="Ingrese el/los nombre(s) del empleado" tabindex="1" required />
                            </div>
                          </div>
                          <div class="form-group">
														<label class="col-sm-4 control-label">Fecha Ingreso*</label>
														<div class="col-sm-7">
															<div class="input-group date datepicker">
																<input type="text" class="form-control" id="fecha_alta" name="fecha_alta" value="<?= $oDatos->getFechaAlta() ?>" placeholder="Seleccione la fecha de ingreso del empleado" title="Seleccione la fecha de ingreso del empleado" tabindex="11" required />
																<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
															</div>
														</div>
													</div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Tipo de Contrato*</label>
                            <div class="col-sm-7">
                              <select class="form-control" id="id_puesto" name="id_puesto" tabindex="10" required >
                                <option disabled selected>Seleccione un tipo de contrato</option>
                                <option value="1">Determinado</option>
                                <option value="2">Indeterminado</option>
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Puesto*</label>
                            <div class="col-sm-7">
                              <select class="form-control" id="id_puesto" name="id_puesto" tabindex="10" required >
																<option selected disabled>Seleccione un Puesto</option>
															</select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Sueldo Mensual Neto*</label>
                            <div class="col-sm-7">
                              <input type="number" class="form-control" id="id_puesto" name="id_puesto" tabindex="10" required />
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Tipo de Movimiento*</label>
                            <div class="col-sm-7">
                              <select class="form-control" id="estado" name="estado" tabindex="12" required >
																<option selected disabled>Seleccione una Opción</option>
                                <option value="1" <?=($oDatos->getEstado() == 1) ? 'selected' : ''; ?>>Alta</option>
                                <option value="2" <?=($oDatos->getEstado() == 2) ? 'selected' : ''; ?>>Baja</option>
															</select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Empresa (Contrato)*</label>
                            <div class="col-sm-7">
                              <select class="form-control" id="estado" name="estado" tabindex="12" required >
																<option selected disabled>Seleccione una Opción</option>
															</select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Ubicación (Oficina)*</label>
                            <div class="col-sm-7">
                              <select class="form-control" id="id_puesto" name="id_puesto" tabindex="10" required >
																<option selected disabled>Seleccione un Puesto</option>
															</select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Jefe Directo*</label>
                            <div class="col-sm-7">
                              <select class="form-control" id="id_puesto" name="id_puesto" tabindex="10" required />
																<option selected disabled>Seleccione el jefe directo</option>
															</select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Periodo de Inscripción al  Fondo  de Ahorro*</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" id="id_puesto" name="id_puesto" tabindex="10" required >
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="panel-footer">
                      <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
                          <div class="btn-toolbar">
                            <button type="submit" class="btn-primary btn btn-label" id="saveButton" tabindex="13"><i class="fa fa-save"></i> Guardar</button>
                            <button type="button" class="btn-default btn" onclick="window.location = 'rh01_empleados_listado.php'" tabindex="14">Cancelar</button>
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
			</div> <!-- page-content -->
			<footer role="contentinfo">
				<div class="clearfix">
					<ul class="list-unstyled list-inline pull-left">
						<li>Top MKT &copy; 2018</li>
					</ul>
					<button class="pull-right btn btn-inverse-alt btn-xs hidden-print" id="back-to-top"><i class="fa fa-arrow-up"></i></button>
				</div>
			</footer>
		</div> <!-- page-container -->

		<!--
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

		<script>!window.jQuery && document.write(unescape('%3Cscript src="assets/js/jquery-1.10.2.min.js"%3E%3C/script%3E'))</script>
		<script type="text/javascript">!window.jQuery.ui && document.write(unescape('%3Cscript src="assets/js/jqueryui-1.10.3.min.js'))</script>
		-->

		<script type='text/javascript' src='assets/js/jquery-1.10.2.min.js'></script>
		<script type='text/javascript' src='assets/js/jqueryui-1.10.3.min.js'></script>
		<script type='text/javascript' src='assets/js/bootstrap.min.js'></script>
		<script type='text/javascript' src='assets/js/enquire.js'></script>
		<script type='text/javascript' src='assets/js/jquery.cookie.js'></script>
		<script type='text/javascript' src='assets/js/jquery.nicescroll.min.js'></script>
		<script type='text/javascript' src='assets/plugins/codeprettifier/prettify.js'></script>
		<script type='text/javascript' src='assets/plugins/easypiechart/jquery.easypiechart.min.js'></script>
		<script type='text/javascript' src='assets/plugins/sparklines/jquery.sparklines.min.js'></script>
		<script type='text/javascript' src='assets/plugins/form-toggle/toggle.min.js'></script>
		<!--
		<script type='text/javascript' src='assets/plugins/form-multiselect/js/jquery.multi-select.min.js'></script>
		<script type='text/javascript' src='assets/plugins/quicksearch/jquery.quicksearch.min.js'></script>
		<script type='text/javascript' src='assets/plugins/form-typeahead/typeahead.min.js'></script>
		<script type='text/javascript' src='assets/plugins/form-select2/select2.min.js'></script>
		<script type='text/javascript' src='assets/plugins/form-autosize/jquery.autosize-min.js'></script>
		<script type='text/javascript' src='assets/plugins/form-colorpicker/js/bootstrap-colorpicker.min.js'></script>
		<script type='text/javascript' src='assets/plugins/jqueryui-timepicker/jquery.ui.timepicker.min.js'></script>
		<script type='text/javascript' src='assets/plugins/form-daterangepicker/daterangepicker.min.js'></script>-->
		<script type='text/javascript' src='assets/plugins/form-datepicker/js/bootstrap-datepicker.js'></script>
		<!--
		<script type='text/javascript' src='assets/plugins/form-daterangepicker/moment.min.js'></script>
		<script type='text/javascript' src='assets/plugins/form-fseditor/jquery.fseditor-min.js'></script>
		<script type='text/javascript' src='assets/plugins/form-jasnyupload/fileinput.min.js'></script>
		<script type='text/javascript' src='assets/plugins/form-tokenfield/bootstrap-tokenfield.min.js'></script> --> <!-- dejara de servir enero 2018 -->
		<script type='text/javascript' src='assets/js/placeholdr.js'></script>
		<script type='text/javascript' src='assets/js/application.js'></script>
		<script type='text/javascript' src='assets/demo/demo.js'></script>
		<script type='text/javascript' src='assets/plugins/progress-skylo/skylo.js'></script>
    <script type='text/javascript' src='assets/js/pages/rh01_empleados_edicion.js'></script>

	</body>
</html>
