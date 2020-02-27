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
                <!-- modal -->
                <div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none;">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="mod-tit" style="text-align:center !important">Esta seguro de borrar la seccion</h4>
                      </div>
                      <div class="modal-body">
                        <div id="message" style="margin-left: 30px; margin-right:30px">
                          <div class="alert alert-danger" style="text-align:center !important">Esta a punto de <strong>BORRAR</strong> una sección <strong>NO PODRA RESTAURARLA.</strong></div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button class="btn-danger btn btn-label" type="button" onclick="deleteSeccion()" data-dismiss="modal">Borrar <i class="fa fa-times"></i></button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      </div>
                    </div><!-- /.modal-content -->
                  </div><!-- /.modal-dialog -->
                </div>
                <!-- fin modal -->
                <form  action="" class="form-horizontal row-border" method="post" id="frm-empleado" name="formEmpleado">
                  <input type="hidden" name="indice_per" id="indice_per">
                  <input type="hidden" name="indice_mat" id="indice_mat">
                  <input type="hidden" name="indice_otros" id="indice_otros">
                  <input type="hidden" name="indice_degustaciones" id="indice_degustaciones">
                  <input type="hidden" name="indice_dominical" id="indice_dominical">
                  <input type="hidden" name="indice_incentivos" id="indice_incentivos">
                  <input type="hidden" name="indice_pl" id="indice_pl">
                  <input type="hidden" name="desglozado" id="desglo" value="0">
                  <input type="hidden" name="secc_personal" id="secc_personal" value="1">
                  <input type="hidden" name="secc_dominical" id="secc_dominical" value="1">
                  <input type="hidden" name="secc_otros" id="secc_otros" value="1">
                  <input type="hidden" name="secc_mat" id="secc_mat" value="1">
                  <input type="hidden" name="secc_degu" id="secc_degu" value="1">
                  <input type="hidden" name="secc_incentivos" id="secc_incentivos" value="1">
                  <input type="hidden" name="secc_pago_proveedor" id="secc_pago_proveedor" value="1">
                  <input type="hidden" name="secc_pl" id="secc_pl" value="1">
                  <input type="hidden" name="incentivos_carga_social" value="30">
                  <input type="hidden" name="com_ag_pago_proveedor" id="com-ag-pago-proveedor">
                  <input type="hidden" name="com_ag_otros" id="com-ag-otros">
                  <input type="hidden" name="com_ag_degu" id="com-ag-degu">
                  <input type="hidden" name="com_ag_incentivo" id="com-ag-incentivo" value="6">
                  <input type="hidden" name="carga_social" id="carga_social">
                  <input type="hidden" name="comision_ag_per" id="comision_agencia">
                  <input type="hidden" name="comision_ag_mat" id="com-ag-mat" >
                  <input type="hidden" name="pl_carga_social" value="30">
                  <input type="hidden" name="pl_comision_agencia" value="12">

								  <div class="panel panel-midnightblue"> <!-- datos generales -->
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
                              <input type="number" class="form-control" id="dias_capacitacion" name="dias_capacitacion" placeholder="Número de días de capacitación" title="Número de días de capacitación" min="0" value="0" onchange="Dias()">
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el número de días que se capacitará al personal">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-midnightblue" id="personal"> <!-- Datos Cotización Personal -->
                    <div class="panel-heading">
                      <h4>
                        Datos Cotización Personal
                      </h4>
                      <div class="options">
                        <a href="javascript:;"><i class="fa fa-cog"></i></a>
                        <a href='#myModal' data-toggle="modal" onclick="borrarSeccion('personal')"><i class="fa fa-times"></i></a>
                        <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                      </div>
                    </div>
                    <div class="panel-body collapse in">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Carga social</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <input type="text" id="carga_social-show" class="form-control" value="<?= $iva ?>"  disabled/>
                                <span class="input-group-addon">%</span>
                              </div>
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
                              <div class="input-group">
                                <input type="text" id="comision_agencia-show" class="form-control" placeholder="% comisión de agencia" title="Ingrese la comisión de agencia" value="<?= $iva ?>" disabled/>
                                <span class="input-group-addon">%</span>
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Porcentaje comisión agencia">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-6 control-label">Desglozado</label>
                            <div class="col-sm-6">
                              <label class="checkbox-inline">
                                <input type="checkbox" id="desglozado" onchange="togglePI()">
                              </label>
                            </div>
                          </div>
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
                              <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="number" id="sueldo_base_0" name="sueldo_base_0" class="form-control sbd" placeholder="Sueldo base diario" title="Sueldo base diario" value="0" disabled/>
                                <input type="hidden" id="base_sueldo_0" name="sueldo_base_0" >
                              </div>
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
                              <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="text" id="cuota_diaria-0" name="cuota_diaria-0" class="form-control" placeholder="Sueldo diario integrado" disabled/>
                              </div>
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
                              <input type="number" id="num_dias_0" name="dias_0" class="form-control dias-laborados" placeholder="Duración en días" min="0" max="1" onchange="calcCuota()" required/>
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
                              <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="text" id="total-personal-0" name="total_0" class="form-control" placeholder="Total" value="0" disabled/>
                              </div>
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
                  <div class="panel panel-midnightblue hidden" id="PrestacionesIntegrales"> <!-- Prestaciones Integrales -->
                    <div class="panel-heading">
                      <h4>
                        Prestaciones Integrales
                      </h4>
                      <div class="options">
                        <a href="javascript:;"><i class="fa fa-cog"></i></a>
                        <a href="javascript:;" onclick="borrarSeccion('PrestacionesIntegrales')"><i class="fa fa-times"></i></a>
                        <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                      </div>
                    </div>
                    <div class="panel-body collapse in">
                      <div class="col-md-12">
                        <h4>Puntualidad</h4>
                      </div>
                      <div class="row borde"> <!-- Puntualidad -->
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Posición</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control pi_posicion_0" disabled/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Porcentaje</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <input type="number" id="pi_puntualidad_0" name="pi_puntualidad_0" class="form-control" placeholder="Porcentaje despensa" title="Porcentaje despensa" value="10" onchange="calcCuota()" min="0" max="15" step=".01"/>
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
                            <label class="col-sm-5 control-label">Por día</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="text" id="puntualidad_dia_0" name="puntualidad_dia_0" class="form-control" placeholder="Total" value="0" disabled/>
                                <input type="hidden" id="tot-m-0"/>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label">Total</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="text" id="puntualidad_tot_0" name="puntualidad_tot_0" class="form-control" placeholder="Total" value="0" disabled/>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div id="puntualidad"></div>

                      <div class="col-md-12">
                        <h4>Asistencia</h4>
                      </div>
                      <div class="row borde"> <!-- Asistencia -->
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Posición</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control pi_posicion_0" disabled/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Porcentaje</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <input type="number" id="pi_asistencia_0" name="pi_asistencia_0" class="form-control" placeholder="Porcentaje despensa" title="Porcentaje despensa" value="10" onchange="calcCuota()" min="0" max="15" step=".01"/>
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
                            <label class="col-sm-5 control-label">Por día</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="text" id="asistencia_dia_0" name="asistencia_dia_0" class="form-control" placeholder="Total" value="0" disabled/>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label">Total</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="text" id="asistencia_tot_0" name="asistencia_tot_0" class="form-control" placeholder="Total" value="0" disabled/>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div id="asistencia"></div>
                      <div class="col-md-12">
                        <h4>Despensa</h4>
                      </div>
                      <div class="row borde"> <!-- Despensa -->
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Posición*</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control pi_posicion_0" disabled/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">UMA</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="number" id="pi_salario_minimo" name="pi_salario_minimo" class="form-control" placeholder="Salario mínimo" title="Unidad de Medida y Actualización (UMA)" value="80.60" onchange="calcCuota()" step=".01"/>
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Unidad de Medida y Actualización (UMA)">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Porcentaje</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <input type="number" id="pi_porcentaje_despensa_0" name="pi_porcentaje_despensa_0" class="form-control" placeholder="Porcentaje despensa" title="Porcentaje despensa" value="40" onchange="calcCuota()" min="0" max="40" step=".01"/>
                                <span class="input-group-addon">%</span>
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Porcentaje del sueldo diario designado a despensa">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label">Por día</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="text" id="despensa_dia_0" name="despensa_dia_0" class="form-control" placeholder="Total" value="0" disabled/>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label">Total</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="text" id="despensa_tot_0" name="despensa_tot_0" class="form-control" placeholder="Total" value="0" disabled/>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div id="despensa">
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-midnightblue" id="primaDom"> <!-- Prima Dominical -->
                    <div class="panel-heading">
                      <h4>
                        Prima Dominical
                      </h4>
                      <div class="options">
                        <a href="javascript:;"><i class="fa fa-cog"></i></a>
                        <a href='#myModal' data-toggle="modal" onclick="borrarSeccion('primaDom')"><i class="fa fa-times"></i></a>
                        <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                      </div>
                    </div>
                    <div class="panel-body collapse in">

                      <div id="dominical">
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-midnightblue" id="incentivos"> <!-- Incentivos -->
                    <div class="panel-heading">
                      <h4>
                        Incentivos
                      </h4>
                      <div class="options">
                        <a href="javascript:;"><i class="fa fa-cog"></i></a>
                        <a href='#myModal' data-toggle="modal" onclick="borrarSeccion('incentivos')"><i class="fa fa-times"></i></a>
                        <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                      </div>
                    </div>
                    <div class="panel-body collapse in">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label">Carga Social</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <input type="text" id="incentivos_carga_social" class="form-control" title="Carga social incentivos" value="30" disabled/>

                                <span class="input-group-addon">%</span>
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Carga Social Incentivos">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label">Comisión de agencia</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <input type="text" id="incentivos_comision_agencia" class="form-control" title="Comisión de agencia" value="6" disabled/>
                                <span class="input-group-addon">%</span>
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Carga Social Incentivos">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                      </div>
                      <div class="row borde">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Descripción</label>
                            <div class="col-sm-6">
                              <input type="text" id="incentivo_descripcion-0" name="incentivo_descripcion_0" class="form-control" required/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione una artículo">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Número de personal</label>
                            <div class="col-sm-6">
                              <input type="text" id="incentivos_num_personal_0" name="incentivos_num_personal_0" class="form-control" placeholder="Número de personal" title="Número de personal" onchange="calcIncTot()"/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Número de Personal">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Costo mensual</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="number" id="incentivos_costo_mensual_0" name="incentivos_costo_mensual_0" class="form-control" placeholder="Costo mensual" onchange="calcIncTot()"/>
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Costo Mensual">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Carga social mensual*</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="number" id="incentivos_carga_social_mensual-0" class="form-control" disabled/>
                                <input type="hidden" id="incentivos_carga_social_mensual_0" name="incentivos_carga_social_mensual_0"/>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label">Total</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="text" id="total_incentivo_0" name="total_incentivo_0" class="form-control" placeholder="Total" value="0" disabled/>
                                <input type="hidden" id="tot_incentivo_0"/>
                              </div>
                            </div>
                            <div class="col-md-1">
        											<button type="button" onclick="addIncentivo()" class="btn btn-info"><i class="fa fa-plus"></i></button>
        										</div>
                          </div>
                        </div>
                      </div>
                      <div id="incentivo">
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-midnightblue" id="Otros"> <!-- Otros -->
                    <div class="panel-heading">
                      <h4>
                        Otros
                      </h4>
                      <div class="options">
                        <a href="javascript:;"><i class="fa fa-cog"></i></a>
                        <a href='#myModal' data-toggle="modal" onclick="borrarSeccion('Otros')"><i class="fa fa-times"></i></a>
                        <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                      </div>
                    </div>
                    <div class="panel-body collapse in">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label">Comision agencia</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <input type="text" id="com_ag_otros" class="form-control" placeholder="% comisión de agencia" title="Comisión de agencia" value="" disabled/>
                                <span class="input-group-addon">%</span>
                              </div>
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
                            <label class="col-sm-5 control-label" style="height:46px">Concepto*</label>
                            <div class="col-sm-6">
                              <input type="text" id="otros_concepto_0" name="otros_concepto_0" class="form-control" title="Ingrese el concepto" required/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el concepto">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Monto individual*</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="number" id="otros_monto_0" name="otros_monto_0" class="form-control" placeholder="Ingrese el monto" min="0" onchange="calcCuota()"  required/>
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el monto">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Cantidad*</label>
                            <div class="col-sm-6">
                              <input type="number" id="otros_cantidad_0" name="otros_cantidad_0" class="form-control" placeholder="Cantidad de personas" min="0" onchange="calcCuota()"  required/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Cantidad de personas a las que se les otorgará">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Total*</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="number" id="otros_total_0" name="otros_total_0" class="form-control" placeholder="Cantidad de personas" disabled/>
                              </div>
                            </div>
                            <div class="col-md-1">
        											<button type="button" onclick="addOtros()" class="btn btn-info"><i class="fa fa-plus"></i></button>
        										</div>
                          </div>
                        </div>
                      </div>
                      <div id="otros">
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-midnightblue" id="matEnv"> <!-- Materiales y Envíos -->
                    <div class="panel-heading">
                      <h4>
                        Materiales y Envíos
                      </h4>
                      <div class="options">
                        <a href="javascript:;"><i class="fa fa-cog"></i></a>
                        <a href='#myModal' data-toggle="modal" onclick="borrarSeccion('matEnv')"><i class="fa fa-times"></i></a>
                        <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                      </div>
                    </div>
                    <div class="panel-body collapse in">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label">Comision agencia</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <input type="text" id="com-ag-mat-show" class="form-control" placeholder="% comisión de agencia" title="Comisión de agencia" disabled/>
                                <span class="input-group-addon">%</span>
                              </div>
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
                              <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="text" id="costo-unitario-0" name="costo_unitario_0" class="form-control" placeholder="Costo unitario" title="Costo unitario del articulo" value="0" onchange="calcMatTot()"/>
                              </div>
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
                              <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="text" id="com-ag-0" name="com_ag_0" class="form-control" placeholder="Comisión agencia" disabled/>
                              </div>
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
                              <div class="input-group">
                                <input type="text" id="total-mat-0" name="total_mat_0" class="form-control" placeholder="Total" value="0" disabled/>
                                <input type="hidden" id="tot-m-0"/>
                                <span class="input-group-addon">%</span>
                              </div>
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
                  <div class="panel panel-midnightblue" id="Degustaciones"> <!-- Degustaciones -->
                    <div class="panel-heading">
                      <h4>
                        Degustaciones
                      </h4>
                      <div class="options">
                        <a href="javascript:;"><i class="fa fa-cog"></i></a>
                        <a href='#myModal' data-toggle="modal" onclick="borrarSeccion('Degustaciones')"><i class="fa fa-times"></i></a>
                        <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                      </div>
                    </div>
                    <div class="panel-body collapse in">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label">Comision agencia</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <input type="text" id="com_ag_degu" class="form-control" placeholder="% comisión de agencia" title="Comisión de agencia" value="" disabled/>

                                <span class="input-group-addon">%</span>
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Porcentaje comisión agencia">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Dias totales*</label>
                            <div class="col-sm-6">
                              <input type="number" id="degu_dias" name="dias_tot_degustaciones" class="form-control" placeholder="Ingrese los días totales" min="0" onchange="calcCuota()"  required/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese los días totales">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                      </div>
                      <div class="row borde">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Degustación</label>
                            <div class="col-sm-6">
                              <select id="id_degustacion_0" name="id_degustacion_0" class="form-control" title="Ingrese la degustación">
                                <option selected disabled>Seleccione una opción</option>
                                <option value="1">cafe 1oz</option>
                                <option value="2">cafe 3oz</option>
                                <option value="3">cafe 5oz</option>
                              </select>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el nombre de la degustación">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Degustacions x día*</label>
                            <div class="col-sm-6">
                              <input type="number" id="degu_cantidad_0" name="degu_cantidad_0" class="form-control" placeholder="Degustaciones por día" onchange="calcCuota()"  required/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Degustaciones por día">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Costo por unidad*</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="number" id="degu_costo_unidad_0" name="degu_costo_unidad_0" class="form-control" title="Ingrese el costo total por unidad" onchange="calcCuota()" required/>
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el costo total por unidad">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Comision agencia</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="text" id="degustacion_comision_0" class="form-control" title="Seleccione una posición" disabled/>
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione la posición">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Total</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="text" id="degu_total_0" class="form-control" title="Seleccione una posición" disabled/>
                              </div>
                            </div>
                            <div class="col-md-1">
        											<button type="button" onclick="addDegustacion()" class="btn btn-info"><i class="fa fa-plus"></i></button>
        										</div>
                          </div>
                        </div>
                      </div>
                      <div id="degustaciones">
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-midnightblue" id="pagoProveedor"> <!-- Pago a Proveedores -->
                    <div class="panel-heading">
                      <h4>
                        Pago a Proveedores
                      </h4>
                      <div class="options">
                        <a href="javascript:;"><i class="fa fa-cog"></i></a>
                        <a href='#myModal' data-toggle="modal" onclick="borrarSeccion('pagoProveedor')"><i class="fa fa-times"></i></a>
                        <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                      </div>
                    </div>
                    <div class="panel-body collapse in">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label">Comision agencia</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <input type="text" id="com_ag_pago_proveedor" class="form-control" placeholder="% comisión de agencia" title="Comisión de agencia" value="" onchange="calcCuota()"/>
                                <span class="input-group-addon">%</span>
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Porcentaje comisión agencia">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                      </div>
                      <div class="row borde">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Proveedor</label>
                            <div class="col-sm-6">
                              <input type="text" id="proveedor" name="proveedor" class="form-control" title="Ingrese proveedor al que se le va a realizar e pago">
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese proveedor al que se le va a realizar e pago">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Total</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="text" id="pago_proveedor_tot" class="form-control" title="Seleccione una posición" disabled/>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Monto*</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="number" id="pago_proveedor_monto" name="pago_proveedor_monto" class="form-control" placeholder="Monto" onchange="calcCuota()"  required/>
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el Monto">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                      </div>
                      <div id="degustaciones">
                      </div>
                    </div>
                  </div>
                  <!-- -->
                  <div class="panel panel-midnightblue" id="pasivo_laboral"> <!-- Pasivo Laboral -->
                    <div class="panel-heading">
                      <h4>
                        Pasivo Laboral(3% de Rotación)
                      </h4>
                      <div class="options">
                        <a href="javascript:;"><i class="fa fa-cog"></i></a>
                        <a href='#myModal' data-toggle="modal" onclick="borrarSeccion('pasivo_laboral')"><i class="fa fa-times"></i></a>
                        <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                      </div>
                    </div>
                    <div class="panel-body collapse in">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="col-sm-5 control-label">Carga Social</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <input type="text" id="pl_carga_social" class="form-control" title="Carga social " value="30" disabled/>
                                <span class="input-group-addon">%</span>
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Carga Social ">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="col-sm-5 control-label">Comisión de agencia</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <input type="text" id="pl_comision_agencia" class="form-control" title="Comisión de agencia" value="12" disabled/>
                                <span class="input-group-addon">%</span>
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Comisión de Agencia">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                      </div>
                      <div class="row borde">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Personal</label>
                            <div class="col-sm-6">
                              <select class="form-control" id="id_personal_pl_0" name="id_personal_pl_0" onchange="loadSueldoPL(0)"  required/>
                              </select>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione una artículo">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Número de personal</label>
                            <div class="col-sm-6">
                              <input type="text" id="pl_num_personal_0" name="pl_num_personal_0" class="form-control" placeholder="Número de personal" title="Número de personal" onchange="calcPLTot()"/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Número de Personal">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="col-sm-5 control-label">Meses de Liquidación por ley</label>
                            <div class="col-sm-6">
                              <input type="text" id="meses_liquidacion_0" name="meses_liquidacion_0" class="form-control" placeholder="Meses de Liquidación por ley" title="Meses de Liquidación por ley" onchange="calcPLTot()" required/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Meses de Liquidación por ley">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Monto</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="hidden" id="pl_sueldo_base_0" name="pl_sueldo_base_0" >
                                <input type="number" id="pl_monto_meses_0" name="pl_monto_meses_0" class="form-control" placeholder="Liquidación" disabled/>
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Costo Mensual">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Días por año*</label>
                            <div class="col-sm-6">
                              <input type="number" id="dias_x_anio_0" name="dias_x_anio_0" class="form-control" onchange="calcPLTot()"/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="col-sm-5 control-label">Monto</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="text" id="pl_monto_dias_0" name="pl_monto_dias_0" class="form-control" disabled/>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Días de prima vacacional*</label>
                            <div class="col-sm-6">
                              <input type="number" id="dias_prima_vacacional_0" name="dias_prima_vacacional_0" class="form-control" onchange="calcPLTot()"/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="col-sm-5 control-label">Monto</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="text" id="pl_monto_dias_prima_0" name="pl_monto_dias_prima_0" class="form-control" disabled/>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Total unitario</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="text" id="pl_total_unitario_0" class="form-control" disabled/>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label">Total con 3% rotación</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="text" id="pl_total_cant_0" class="form-control" disabled/>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="col-sm-5 control-label">Total con comisión</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="text" id="pl_total_com_0" name="pl_total_com_0" class="form-control" disabled/>
                              </div>
                            </div>
                            <div class="col-md-1" hidden>
        											<button type="button" onclick="addPL()" class="btn btn-info"><i class="fa fa-plus"></i></button>
        										</div>
                          </div>
                        </div>
                      </div>
                      <div id="pasivo-laboral">

                      </div>
                    </div>
                  </div>
                  <!-- -->
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
                        <div class="col-md-4"> <!-- total personal -->
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Total personal</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="text" id="total-personal" class="form-control" disabled>
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Total personal antes de IVA">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4"> <!-- total incentivos -->
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Total incentivos</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="text" id="total-inc" class="form-control" disabled/>
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Total incentivos antes de IVA">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4"> <!-- total materiales -->
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Total materiales/envios</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="text" id="total-mat" class="form-control" disabled/>
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Total materiales antes de IVA">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4"> <!-- total otros -->
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Total Otros</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="text" id="total-otros" class="form-control" disabled/>
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Total materiales antes de IVA">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4"> <!-- total degustaciones -->
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Total Degustaciones</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="text" id="total-degustaciones" class="form-control" disabled/>
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Total materiales antes de IVA">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4"> <!-- total pago proveedor -->
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Total Pago Proveedor</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="text" id="total-pago-proveedor" class="form-control" disabled />
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Total materiales antes de IVA">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-4"> <!-- total final -->
                          <div class="form-group">
                            <label class="col-sm-5 control-label" style="height:46px">Total final</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="text" id="total-final" name="tot-final" class="form-control" placeholder="Total final" disabled/>
                              </div>
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
