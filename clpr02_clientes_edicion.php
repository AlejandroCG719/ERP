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
  require("classes/Cliente.php");
  $oDatos = new Cliente();
  if (isset($_GET['id'])) {
    $oDatos->setConsulta($_GET['id']);
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
							<li><a href="clpr02_clientes_listado.php"><i class="<?= $oBreadcrumb->getImagen() ?>"></i> Clientes</a></li>
							<li class="active">Edición de Cliente</li>
						</ol>
						<h1>Registro de Cliente</h1>
						<div class="options">
							<div class="btn-toolbar">
								<a href='clpr02_clientes_edicion.php' class="btn btn-default"><i class="fa fa-plus"></i><span class="hidden-sm"> Nuevo cliente</span></a>
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
                  <form  action="" class="form-horizontal row-border" method="post" id="frm-cliente" name="formCliente">
                    <input type="hidden" id="id" name="id" value="<?= $oDatos->getId() ?>">
                    <div class="panel-heading">
                      <h4 onclick="loadModulos()">
                        Edición de Cliente
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
                            <label class="col-sm-4 control-label">Fecha Alta*</label>
                            <div class="col-sm-6">
                              <div class="input-group date datepicker">
																<input type="text" class="form-control" id="fecha" name="fecha" placeholder="Seleccione la fecha" title="Seleccione la fecha" value="<?= $oDatos->getFecha() ?>" tabindex="1" required />
																<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
															</div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione la fecha">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">RFC*</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" id="valor" name="valor" value="<?= $oDatos->getValor() ?>" placeholder="Ingrese el RFC" title="Ingrese el RFC" tabindex="2" required />
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el RFC">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
													<div class="form-group">
                            <label class="col-sm-4 control-label">Dirección *</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" id="dir" name="dir" value="<?= $oDatos->getDir() ?>" placeholder="Ingrese la dirección" title="Ingrese la dirección" tabindex="3" />
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese la dirección">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Estado*</label>
                            <div class="col-sm-6">
                              <select class="form-control" id="estado" name="estado" tabindex="12" required />
																<option selected disabled>Seleccione una Opción</option>
                                <option value="1" <?=($oDatos->getEstado() == 1) ? 'selected' : ''; ?>>Activo</option>
                                <option value="2" <?=($oDatos->getEstado() == 2) ? 'selected' : ''; ?>>Inactivo</option>
															</select>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione el status de la promoción">
                              <span class="fa  fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-6">
													<div class="form-group">
														<label class="col-sm-4 control-label">Nombre*</label>
														<div class="col-sm-6">
															<input type="text" class="form-control" id="nombre" name="nombre" value="<?= $oDatos->getNombre() ?>" placeholder="Nombre de la empresa" title="Nombre de la empresa"/>
														</div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Nombre de la empresa">
                              <span class="fa fa-info-circle"></span>
                            </a>
													</div>
													<div class="form-group">
                            <label class="col-sm-4 control-label">Teléfono*</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" id="telefono" name="telefono" value="<?= $oDatos->getTelefono() ?>" placeholder="Ingrese télefono del contacto" title="Ingrese télefono del contacto" tabindex="8" required/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese télefono del contacto">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
													<div class="form-group">
                            <label class="col-sm-4 control-label">C.P.*</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" id="cp" name="cp" value="<?= $oDatos->getCP() ?>" placeholder="Ingrese el código postal" title="Ingrese el código postal" tabindex="9" required />
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el código postal">
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
                            <button type="button" class="btn-default btn" onclick="window.location = 'clpr02_clientes_listado.php'" tabindex="14">Cancelar</button>
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
		<script type='text/javascript' src='assets/plugins/form-datepicker/js/bootstrap-datepicker.js'></script>
		<script type='text/javascript' src='assets/js/placeholdr.js'></script>
		<script type='text/javascript' src='assets/js/application.js'></script>
		<script type='text/javascript' src='assets/demo/demo.js'></script>
		<script type='text/javascript' src='assets/plugins/progress-skylo/skylo.js'></script>
    <script type='text/javascript' src='assets/js/noty/js/noty/packaged/jquery.noty.packaged.min.js'></script>
    <script type='text/javascript' src='assets/js/pages/clpr02_clientes_edicion.js'></script>
	</body>
</html>
