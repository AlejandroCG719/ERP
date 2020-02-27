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
  /*
  //paginas con carga de info
  require("classes/Empleado.php");
  $oDatos = new Empleado();
  if (isset($_GET['id_empleado'])) {
    $oDatos->setConsulta($_GET['id_empleado']);
  }*/
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

		<!-- The following CSS are included as plugins and can be removed if unused-->

		<link rel='stylesheet' type='text/css' href='assets/plugins/form-select2/select2.css' />
		<!--<link rel='stylesheet' type='text/css' href='assets/plugins/form-multiselect/css/multi-select.css' />
		<link rel='stylesheet' type='text/css' href='assets/plugins/jqueryui-timepicker/jquery.ui.timepicker.css' />
		<link rel='stylesheet' type='text/css' href='assets/plugins/form-daterangepicker/daterangepicker-bs3.css' />
		<link rel='stylesheet' type='text/css' href='assets/plugins/form-fseditor/fseditor.css' />
		<link rel='stylesheet' type='text/css' href='assets/plugins/form-tokenfield/bootstrap-tokenfield.css' />
		<link rel='stylesheet' type='text/css' href='assets/js/jqueryui.css' />-->
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
	<body>
	  <?php require("snippets/header.php"); ?>
	  <div id="page-container">
			<?php require("snippets/sidebars.php"); ?>
			<div id="page-content">
				<div id='wrap'>
					<div id="page-heading">
						<ol class="breadcrumb">
							<li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
							<li><a href="cot01_cotizaciones_listado.php"><i class="<?= $oBreadcrumb->getImagen() ?>"></i> Cotizaciones</a></li>
							<li class="active">Edición de Cotizaciones</li>
						</ol>
						<h1>Registro de Cotización</h1>
					</div>
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<div id="message">
									<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert">&times;</a>Los Datos marcados con <strong>(*) son obligatorios.</strong></div>
								</div>
                <form  action="" class="form-horizontal row-border" method="post" id="frm-empleado" name="formEmpleado">
                  <input type="hidden" name="indice_per" id="indice_per">
                  <input type="hidden" name="indice_mat" id="indice_mat">
								  <div class="panel panel-midnightblue">
                    <div class="panel-heading">
                      <h4>
                        Datos Cotización General
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
                            <label class="col-sm-3 control-label">Fecha*</label>
                            <div class="col-sm-6">
                              <div class="input-group date datepicker">
																<input type="text" class="form-control" id="fecha" name="fecha" placeholder="Seleccione la fecha de nacimiento del empleado" title="Seleccione la fecha de nacimiento del empleado" value="<?= date("Y-m-d"); ?>" tabindex="7" required />
																<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
															</div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione la fecha">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="condiciones_almacenamiento">Cliente*</label>
                            <div class="col-sm-6">
                              <select id="id_cliente" name="id_cliente" class="form-control selectpicker show-tick" title="Seleccione un Cliente" onchange="loadPromociones()" required/>
                                <option  selected disabled>Seleccione una Opción</option>
                              </select>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione un cliente">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Plaza*</label>
                            <div class="col-sm-6">
                              <input type="hidden" id="plaza" name="plaza" style="width:100%" required/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione una o varias plazas">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Estado*</label>
                            <div class="col-sm-6">
                              <select id="id_status" name="id_status" class="form-control selectpicker show-tick" title="Seleccione una Plaza" required/>
                                <option  selected disabled>Seleccione una Opción</option>
                              </select>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el status de la cotización">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="col-sm-3 control-label">No. presupuesto*</label>
                            <div class="col-sm-6">
                              <input type="text" id="no_presupuesto" name="no_presupuesto" class="form-control sec-1" placeholder="Número de presupuesto" value="<?= $folio?>" required/>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Promoción*</label>
                            <div class="col-sm-6">
                              <!--input type="text" id="id_promocion" name="id_promocion"  class="form-control sec-1" placeholder="Promoción" title="Nombre de la promoción" value="<?= $cuenta_deposito ?>" required/-->
                              <select class="form-control" id="id_promocion" name="id_promocion" onchange="loadComisiones()" disabled>
                                <option selected disabled>Seleccione un  cliente*</option>
                              </select>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese la promoción">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Periodo*</label>
                            <div class="col-sm-6">
                              <div class="input-daterange input-group datepicker">
                                <input type="text" class="input-small form-control" id="fecha_inicio" name="fecha_inicio" value="<?= date('Y-m-d'); ?>" onchange="Dias()"/>
                                <span class="input-group-addon">al</span>
                                <input type="text" class="input-small form-control" id="fecha_fin" name="fecha_fin" value="<?= date('Y-m-d'); ?>" onchange="Dias()" />
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione el rango de fechas">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Días Capacitación*</label>
                            <div class="col-sm-6">
                              <!--input type="text" id="id_promocion" name="id_promocion"  class="form-control sec-1" placeholder="Promoción" title="Nombre de la promoción" value="<?= $cuenta_deposito ?>" required/-->
                              <input type="number" class="form-control" id="dias_capacitacion" name="dias_capacitacion" placeholder="Número de días de capacitación" title="Número de días de capacitación" value="0" onchange="Dias()">
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el número de días que se capacitará al personal">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-midnightblue"> <!-- Datos Cotización Personal -->
                    <div class="panel-heading">
                      <h4>
                        Datos Cotización Personal
                      </h4>
                      <div class="options">
                        <a href="javascript:;"><i class="fa fa-cog"></i></a>
                        <!--a href="javascript:;" onclick="()"><i class="fa fa-refresh"></i></a-->
                        <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                      </div>
                    </div>
                    <div class="panel-body collapse in">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Carga social</label>
                            <div class="col-sm-6">
                              <input type="text" id="carga_social-show" class="form-control" placeholder="% carga social" title="Ingrese el total del ingreso" step="0.01" min="30" max="50" value="<?= $iva ?>"  disabled/>
                              <input type="hidden" id="carga_social" name="carga_social" onchange="calcCuota()" value="<?= $iva ?>" />
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Porcentaje de carga social">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label">Comision agencia</label>
                            <div class="col-sm-6">
                              <input type="text" id="comision_agencia-show" class="form-control" placeholder="% comisión de agencia" title="Ingrese la comisión de agencia" value="<?= $iva ?>" disabled/>
                              <input type="hidden" id="comision_agencia" name="comision_ag_per" class="form-control" placeholder="% comisión de agencia" title="Ingrese la comisión de agencia" step="0.01" min="0" onchange="calcCuota()" value="<?= $iva ?>" required/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Porcentaje comisión agencia">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4">
                        </div>
                      </div>
                      <div class="row borde">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Posición*</label>
                            <div class="col-sm-6">
                              <select id="id_posicion-0" name="id_posicion_0" class="form-control selectpicker show-tick" title="Seleccione una posición" onchange="loadSueldo(0)" required/>
                                <option  selected disabled>Seleccione una Opción</option>
                                <!-- cargar tabla cat_cot_personal-->
                              </select>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione la posición">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Suledo base</label>
                            <div class="col-sm-6">
                              <input type="text" id="sb-0" class="form-control sbd" placeholder="Sueldo base diario" title="Sueldo base diario" value="0" disabled/>
                              <input type="hidden" id="sbd-nor-0" name="sueldo_base_0" value="0"/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Sueldo base diario del puesto">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Sueldo diario integrado</label>
                            <div class="col-sm-6">
                              <input type="text" id="cuota_diaria-0" name="cuota_diaria-0" class="form-control" placeholder="Sueldo diario integrado" disabled/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Sueldo diario integrado (incluye carga social y comision de agencia)">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Cantidad*</label>
                            <div class="col-sm-6">
                              <input type="number" id="cantidad-0" name="cantidad_0" class="form-control" min="0" onchange="calcCuota()" value="<?= $iva ?>" required/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Días laborados*</label>
                            <div class="col-sm-6">
                              <input type="number" id="num_dias_0" name="dias_0" class="form-control dias-laborados" placeholder="Duración en días" min="0" max="10" onchange="calcCuota()" required/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Días laborados">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label">Total</label>
                            <div class="col-sm-5">
                              <input type="text" id="total-0" name="total_0" class="form-control" placeholder="Total" value="0" disabled/>
                              <input type="hidden" id="tot-p-0"/>
                            </div>
                            <div class="col-md-1">
        											<button type="button" onclick="addPersonal()" class="btn btn-info"><i class="fa fa-plus"></i></button>
        										</div>
                          </div>
                        </div>
                      </div>
                      <div id="personal">
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-midnightblue"> <!-- Prima Dominical -->
                    <div class="panel-heading">
                      <h4>
                        Prima Dominical
                      </h4>
                      <div class="options">
                        <a href="javascript:;"><i class="fa fa-cog"></i></a>
                        <!--a href="javascript:;" onclick="()"><i class="fa fa-refresh"></i></a-->
                        <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                      </div>
                    </div>
                    <div class="panel-body collapse in">
                      <!--div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Prima dominical</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" title="Prima dominical" value="25%" disabled/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Prima dominical 25%">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Días*</label>
                            <div class="col-sm-6">
                              <input type="number" id="dias_dom" name="dias_dom" class="form-control" placeholder="Duración en días" min="0" onchange="calcCuota()"  required/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Duración en días">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                      </div>
                      <div class="row borde">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Posición</label>
                            <div class="col-sm-6">
                              <input type="text" id="pos-dom-0" class="form-control" title="Seleccione una posición" disabled/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione la posición">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Suledo base</label>
                            <div class="col-sm-6">
                              <input type="text" id="sb-d-0" class="form-control" placeholder="Sueldo base diario" title="Sueldo base diario" value="0" disabled/>
                              <input type="hidden" id="sbd-dom-0"/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Sueldo base diario del puesto">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Cuota diaria</label>
                            <div class="col-sm-6">
                              <input type="text" id="cuota_dom-0" class="form-control" placeholder="Costo cueta diaria" value="<?= $iva ?>" disabled/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Costo cuota diaria (incluye carga social y comision de agencia)">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label">Total</label>
                            <div class="col-sm-6">
                              <input type="text" id="total-dom-0" class="form-control" placeholder="Total" value="0" disabled/>
                              <input type="hidden" id="tot-d-0"/>
                            </div>
                          </div>
                        </div>
                      </div-->
                      <div id="dominical">
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-midnightblue"> <!-- Prestaciones Integrales -->
                    <div class="panel-heading">
                      <h4>
                        Prestaciones Integrales
                      </h4>
                      <div class="options">
                        <a href="javascript:;"><i class="fa fa-cog"></i></a>
                        <a href="javascript:;" onclick=""><i class="fa fa-times"></i></a>
                        <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                      </div>
                    </div>
                    <div class="panel-body collapse in">
                      <div class="row borde"> <!-- Puntualidad -->
                        <div class="col-md-12">
                          Puntualidad
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Posición*</label>
                            <div class="col-sm-6">
                              <select id="pi_id_posicion_0" name="pi_id_posicion_0" class="form-control selectpicker show-tick pi_id_posicion_0" disabled/>
                                <!-- cargar catalogo  cat_cot_mat -->
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Porcentaje</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <input type="number" id="pi_porcentaje_despensa" name="pi_porcentaje_despensa" class="form-control" placeholder="Porcentaje despensa" title="Porcentaje despensa" value="10" onchange="" min="0" max="15" step=".01"/>
                                <span class="input-group-addon">%</span>
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Costo unitario del artículo">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label">Total</label>
                            <div class="col-sm-6">
                              <input type="text" id="total-mat-0" name="total_mat_0" class="form-control" placeholder="Total" value="0" disabled/>
                              <input type="hidden" id="tot-m-0"/>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row borde"> <!-- Asistencia -->
                        <div class="col-md-12">
                          Asistencia
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Posición*</label>
                            <div class="col-sm-6">
                              <select class="form-control selectpicker show-tick pi_id_posicion_0" disabled/>
                                <!-- cargar catalogo  cat_cot_mat -->
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Porcentaje</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <input type="number" id="pi_porcentaje_despensa" name="pi_porcentaje_despensa" class="form-control" placeholder="Porcentaje despensa" title="Porcentaje despensa" value="10" onchange="" min="0" max="15" step=".01"/>
                                <span class="input-group-addon">%</span>
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Costo unitario del artículo">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label">Total</label>
                            <div class="col-sm-6">
                              <input type="text" id="total-mat-0" name="total_mat_0" class="form-control" placeholder="Total" value="0" disabled/>
                              <input type="hidden" id="tot-m-0"/>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row borde"> <!-- Despensa -->
                        <div class="col-md-12">
                          Despensa
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Posición*</label>
                            <div class="col-sm-6">
                              <select class="form-control selectpicker show-tick pi_id_posicion_0" disabled/>
                                <!-- cargar catalogo  cat_cot_mat -->
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Porcentaje</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <input type="number" id="pi_porcentaje_despensa" name="pi_porcentaje_despensa" class="form-control" placeholder="Porcentaje despensa" title="Porcentaje despensa" value="10" onchange="" min="0" max="15" step=".01"/>
                                <span class="input-group-addon">%</span>
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Costo unitario del artículo">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label">Total</label>
                            <div class="col-sm-6">
                              <input type="text" id="total-mat-0" name="total_mat_0" class="form-control" placeholder="Total" value="0" disabled/>
                              <input type="hidden" id="tot-m-0"/>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div id="material">
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
                      <!--div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Prima dominical</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" title="Prima dominical" value="25%" disabled/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Prima dominical 25%">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Días*</label>
                            <div class="col-sm-6">
                              <input type="number" id="dias_dom" name="dias_dom" class="form-control" placeholder="Duración en días" min="0" onchange="calcCuota()"  required/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Duración en días">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                      </div>
                      <div class="row borde">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Posición</label>
                            <div class="col-sm-6">
                              <input type="text" id="pos-dom-0" class="form-control" title="Seleccione una posición" disabled/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione la posición">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Suledo base</label>
                            <div class="col-sm-6">
                              <input type="text" id="sb-d-0" class="form-control" placeholder="Sueldo base diario" title="Sueldo base diario" value="0" disabled/>
                              <input type="hidden" id="sbd-dom-0"/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Sueldo base diario del puesto">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Cuota diaria</label>
                            <div class="col-sm-6">
                              <input type="text" id="cuota_dom-0" class="form-control" placeholder="Costo cueta diaria" value="<?= $iva ?>" disabled/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Costo cuota diaria (incluye carga social y comision de agencia)">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label">Total</label>
                            <div class="col-sm-6">
                              <input type="text" id="total-dom-0" class="form-control" placeholder="Total" value="0" disabled/>
                              <input type="hidden" id="tot-d-0"/>
                            </div>
                          </div>
                        </div>
                      </div-->
                      <div id="dominical">
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-midnightblue"> <!-- Materiales y Envíos -->
                    <div class="panel-heading">
                      <h4>
                        Materiales y Envíos
                      </h4>
                      <div class="options">
                        <a href="javascript:;"><i class="fa fa-cog"></i></a>
                        <!--a href="javascript:;" onclick="()"><i class="fa fa-refresh"></i></a-->
                        <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                      </div>
                    </div>
                    <div class="panel-body collapse in">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label">Comision agencia</label>
                            <div class="col-sm-6">
                              <input type="text" id="com-ag-mat-show" class="form-control" placeholder="% comisión de agencia" title="Comisión de agencia" disabled/>
                              <input type="hidden" id="com-ag-mat" name="comision_ag_mat" class="form-control" onchange="calcCuota()" value=""/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Porcentaje comisión agencia">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                      </div>
                      <div class="row borde">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Artículo*</label>
                            <div class="col-sm-6">
                              <select id="id_articulo-0" name="id_material_0" class="form-control selectpicker show-tick" title="Seleccione un artículo" onchange="loadArticuloPrecio(0)" required/>
                                <!-- cargar catalogo  cat_cot_mat -->
                              </select>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione una artículo">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Costo unitario</label>
                            <div class="col-sm-6">
                              <input type="text" id="costo-unitario-0" name="costo_unitario_0" class="form-control" placeholder="Costo unitario" title="Costo unitario del articulo" value="0" onchange="loadComisiones()"/>
                              <!--input type="hidden" id="c-u-0" name="costo_unitario_0" value="0"/-->
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Costo unitario del artículo">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Comisión agencia</label>
                            <div class="col-sm-6">
                              <input type="text" id="com-ag-0" name="com_ag_0" class="form-control" placeholder="Comisión agencia" disabled/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Comision de agencia">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Cantidad*</label>
                            <div class="col-sm-6">
                              <input type="number" id="cant-mat-0" name="cant_mat_0" class="form-control" min="0" onchange="calcMatTot()"  required/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label">Total</label>
                            <div class="col-sm-6">
                              <input type="text" id="total-mat-0" name="total_mat_0" class="form-control" placeholder="Total" value="0" disabled/>
                              <input type="hidden" id="tot-m-0"/>
                            </div>
                            <div class="col-md-1">
        											<button type="button" onclick="addMaterial()" class="btn btn-info"><i class="fa fa-plus"></i></button>
        										</div>
                          </div>
                        </div>
                      </div>
                      <div id="material">
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-midnightblue"> <!-- Degustaciones -->
                    <div class="panel-heading">
                      <h4>
                        Degustaciones
                      </h4>
                      <div class="options">
                        <a href="javascript:;"><i class="fa fa-cog"></i></a>
                        <!--a href="javascript:;" onclick="()"><i class="fa fa-refresh"></i></a-->
                        <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                      </div>
                    </div>
                    <div class="panel-body collapse in">
                      <!--div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Prima dominical</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" title="Prima dominical" value="25%" disabled/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Prima dominical 25%">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Días*</label>
                            <div class="col-sm-6">
                              <input type="number" id="dias_dom" name="dias_dom" class="form-control" placeholder="Duración en días" min="0" onchange="calcCuota()"  required/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Duración en días">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                      </div>
                      <div class="row borde">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Posición</label>
                            <div class="col-sm-6">
                              <input type="text" id="pos-dom-0" class="form-control" title="Seleccione una posición" disabled/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione la posición">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Suledo base</label>
                            <div class="col-sm-6">
                              <input type="text" id="sb-d-0" class="form-control" placeholder="Sueldo base diario" title="Sueldo base diario" value="0" disabled/>
                              <input type="hidden" id="sbd-dom-0"/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Sueldo base diario del puesto">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Cuota diaria</label>
                            <div class="col-sm-6">
                              <input type="text" id="cuota_dom-0" class="form-control" placeholder="Costo cueta diaria" value="<?= $iva ?>" disabled/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Costo cuota diaria (incluye carga social y comision de agencia)">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label">Total</label>
                            <div class="col-sm-6">
                              <input type="text" id="total-dom-0" class="form-control" placeholder="Total" value="0" disabled/>
                              <input type="hidden" id="tot-d-0"/>
                            </div>
                          </div>
                        </div>
                      </div-->
                      <div id="dominical">
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-midnightblue"> <!-- Totales -->
                    <div class="panel-heading">
                      <h4>
                        Totales
                      </h4>
                      <div class="options">
                        <a href="javascript:;"><i class="fa fa-cog"></i></a>
                        <!--a href="javascript:;" onclick="()"><i class="fa fa-refresh"></i></a-->
                        <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                      </div>
                    </div>
                    <div class="panel-body collapse in">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Total personal</label>
                            <div class="col-sm-6">
                              <input type="text" id="total-personal" class="form-control" disabled>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Total personal antes de IVA">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Total materiales/envios</label>
                            <div class="col-sm-6">
                              <input type="text" id="total-mat" class="form-control" disabled/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Total materiales antes de IVA">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Total final</label>
                            <div class="col-sm-6">
                              <input type="text" id="total-final" name="tot-final" class="form-control" placeholder="Total final" disabled/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Toatal final antes de IVA">
                              <span class="fa fa-info-circle"></span>
                            </a>
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
                          <button type="button" class="btn-default btn" onclick="window.location = 'cot01_cotizaciones_listado.php'" tabindex="14">Cancelar</button>
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
    <script type='text/javascript' src='assets/plugins/form-select2/select2.min.js'></script>
		<!--
		<script type='text/javascript' src='assets/plugins/form-multiselect/js/jquery.multi-select.min.js'></script>
		<script type='text/javascript' src='assets/plugins/quicksearch/jquery.quicksearch.min.js'></script>
		<script type='text/javascript' src='assets/plugins/form-typeahead/typeahead.min.js'></script>
		<script type='text/javascript' src='assets/plugins/form-autosize/jquery.autosize-min.js'></script>
		<script type='text/javascript' src='assets/plugins/form-colorpicker/js/bootstrap-colorpicker.min.js'></script>
		<script type='text/javascript' src='assets/plugins/jqueryui-timepicker/jquery.ui.timepicker.min.js'></script-->
		<script type='text/javascript' src='assets/plugins/form-daterangepicker/daterangepicker.min.js'></script>
		<script type='text/javascript' src='assets/plugins/form-datepicker/js/bootstrap-datepicker.js'></script>
		<!--
		<script type='text/javascript' src='assets/plugins/form-daterangepicker/moment.min.js'></script>
		<script type='text/javascript' src='assets/plugins/form-fseditor/jquery.fseditor-min.js'></script>
		<script type='text/javascript' src='assets/plugins/form-jasnyupload/fileinput.min.js'></script>
		<script type='text/javascript' src='assets/plugins/form-tokenfield/bootstrap-tokenfield.min.js'></script> --> <!-- dejara de servir enero 2018 -->
		<script type='text/javascript' src='assets/js/placeholdr.js'></script>
		<script type='text/javascript' src='assets/js/application.js'></script>
		<script type='text/javascript' src='assets/demo/demo.js'></script>
    <script src="assets/js/noty/js/noty/packaged/jquery.noty.packaged.min.js" type="text/javascript"></script>
		<script type='text/javascript' src='assets/plugins/progress-skylo/skylo.js'></script>
    <script type='text/javascript' src='assets/js/pages/cot01_cotizaciones_edicion.js'></script>

	</body>
</html>
