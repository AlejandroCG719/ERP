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
  $b=0;
  require("classes/Ingreso.php");
  $oDatos = new Ingreso();
  if (isset($_GET['id_finanzas_ingresos'])) {
    $b=1;
    $oDatos->setConsulta($_GET['id_finanzas_ingresos']);
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

		<!-- The following CSS are included as plugins and can be removed if unused-->
		<!--
		<link rel='stylesheet' type='text/css' href='assets/plugins/form-select2/select2.css' />
		<link rel='stylesheet' type='text/css' href='assets/plugins/form-multiselect/css/multi-select.css' />
		<link rel='stylesheet' type='text/css' href='assets/plugins/jqueryui-timepicker/jquery.ui.timepicker.css' />
		<link rel='stylesheet' type='text/css' href='assets/plugins/form-daterangepicker/daterangepicker-bs3.css' />
		<link rel='stylesheet' type='text/css' href='assets/plugins/form-fseditor/fseditor.css' />
		<link rel='stylesheet' type='text/css' href='assets/plugins/form-tokenfield/bootstrap-tokenfield.css' />
		<link rel='stylesheet' type='text/css' href='assets/js/jqueryui.css' />-->
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
							<li><a href="fin02_ingresos_listado.php"><i class="<?= $oBreadcrumb->getImagen() ?>"></i> Ingresos</a></li>
							<li class="active">Edición de Ingresos</li>
						</ol>
						<h1>Registro de Ingresos</h1>
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
								<a href='fin02_ingresos_edicion.php' class="btn btn-default"><i class="fa fa-plus"></i><span class="hidden-sm"> Nuevo ingreso</span></a>
							</div>
						</div>
					</div>
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<div id="message">
									<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert">&times;</a>Los Datos marcados con <strong>(*) son obligatorios.</strong></div>
								</div>
								<div class="panel panel-midnightblue">
                  <input type="hidden" id="presupuesto" value="<?= $oDatos->getIdCot() ?>">
                  <input type="hidden" id="cliente" value="<?= $oDatos->getIdCliente() ?>">
                  <input type="hidden" id="estado_ingreso" value="<?= $oDatos->getEstadoIngreso() ?>">
                  <form  action="" class="form-horizontal row-border" method="post" id="frm-ingreso" name="formIngreso">
                    <input type="hidden" id="id_finanzas_ingresos" name="id_finanzas_ingresos" value="<?= $oDatos->getId() ?>">
                    <div class="panel-heading">
                      <h4>
                        Edición de Ingreso
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
                            <label class="col-sm-3 control-label">Fecha*</label>
                            <div class="col-sm-6">
                              <div class="input-group date datepicker">
																<input type="text" class="form-control" id="fecha" name="fecha" value="<?= ($b == 1) ? $oDatos->getFecha() :date("Y-m-d"); ?>" placeholder="Seleccione la fecha de nacimiento del empleado" title="Seleccione la fecha de nacimiento del empleado" tabindex="7" <?= ($b == 1) ? 'disabled' : 'required'; ?> />
																<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
															</div>
                            </div>
                          </div>
                          <!--div class="form-group">
                            <label class="col-sm-3 control-label">PTTO*</label>
                            <div class="col-sm-6">
                              <select class="form-control" id="id_cotizacion" name="id_cotizacion" disabled>
                                <option selected disabled>Seleccione un PPTO</option>
                              </select>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese la promoción">
                              <span class="fa  fa-info-circle"></span>
                            </a>
                          </div-->
                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="condiciones_almacenamiento">Evento*</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" id="evento" value="<?= $oDatos->getEvento() ?>" name="evento" placeholder="Solicitante" title="Ingrese nombre del solicitante" tabindex="1" <?= ($b == 1) ? 'disabled' : 'required'; ?>/>
                            </div>
                            <a href="#refrigeracion" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el nomnbre del solicitante">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Importe*</label>
                            <div class="col-sm-6">
                              <input type="number" step="0.01" value="<?= $oDatos->getImporte() ?>" class="form-control" onchange="calcTot()" id="importe" name="importe" placeholder="Ingrese el monto" title="Ingrese el monto del importe" tabindex="2" <?= ($b == 1) ? 'disabled' : 'required'; ?>/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Monto del importe">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Estado*</label>
                            <div class="col-sm-6">
                              <select class="form-control selectpicker show-tick" id="id_estado_ingresos" name="id_estado_ingresos" title="Seleccione una Plaza" required tabindex="13" <?= ($v == 1) ? 'disabled' : 'required'; ?>>
                                <option value="" selected disabled>Seleccione una Opción</option>
                                <!-- cargar estado ingresos -->
                              </select>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el estado del ingreso">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Cliente*</label>
                            <div class="col-sm-6">
                              <select class="form-control selectpicker show-tick" id="id_cliente" name="id_cliente" title="Seleccione un Cliente" onchange="loadCotizaciones()" required tabindex="13" <?= ($b == 1) ? 'disabled' : 'required'; ?>/>
                                <!-- cargar clientes -->
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label">No. factura*</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" id="no_factura" name="no_factura" value="<?= $oDatos->getNoFactura() ?>" placeholder="Número de factura" title="Ingrese el número de factura" tabindex="6" <?= ($b == 1) ? 'disabled' : 'required'; ?>/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el número de factura">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label">IVA*</label>
                            <div class="col-sm-6">
                              <input type="number" step="0.01" class="form-control" id="iva" value="<?= $oDatos->getIva() ?>" onchange="calcTot()" name="iva" placeholder="Nombre del beneficiario" title="Ingrese el nombre del beneficiario" tabindex="7"  <?= ($b == 1) ? 'disabled' : 'required'; ?>/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el nombre del beneficiario">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Total*</label>
                            <div class="col-sm-6">
                              <input type="number" step="0.01" class="form-control" id="total" name="total" value="<?= $oDatos->getTotal() ?>" placeholder="Total" title="Ingrese el total del ingreso" tabindex="3" <?= ($b == 1) ? 'disabled' : 'required'; ?>/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el total del ingreso">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="panel-footer">
                      <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
                          <div class="btn-toolbar">
                            <button type="submit" class="btn-primary btn btn-label" id="saveButton" tabindex="13"><i class="fa fa-save"></i> Guardar</button>
                            <button type="button" class="btn-default btn" onclick="window.location = 'fin02_ingresos_listado.php'" tabindex="14">Cancelar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
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
    <script type='text/javascript' src='assets/js/pages/fin02_ingresos_edicion.js'></script>

	</body>
</html>
