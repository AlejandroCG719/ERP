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
  require("classes/Usuario.php");
  $oDatos = new Usuario();
  if (isset($_GET['id_usuario'])) {
    $oDatos->setConsulta($_GET['id_usuario']);
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
							<li><a href="cnfg01_usuarios_listado.php"><i class="<?= $oBreadcrumb->getImagen() ?>"></i> Usuarios</a></li>
							<li class="active">Edición de Usuario</li>
						</ol>
						<h1>Registro de Usuarios</h1>
						<div class="options">
							<div class="btn-toolbar">
								<div class="btn-group hidden-xs">
									<a href='cnfg01_usuarios_edicion.php' class="btn btn-default dropdown-toggle"><i class="fa fa-plus"></i><span class="hidden-sm"> Nuevo Usuario  </span></a>
								</div>
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
                  <input type="hidden" id="idP" value="<?= $oDatos->getPerfil() ?>" />
                  <input type="hidden" id="idE" value="<?= $oDatos->getEmpleado() ?>" />
                  <form  action="" class="form-horizontal row-border" method="post" id="frm-usuario" name="formUsuario">
                    <input type="hidden" id="id_usuario" name="id_usuario" value="<?= $oDatos->getId() ?>">
                    <div class="panel-heading">
                      <h4 onclick="loadModulos()">
                        Edición de Módulo
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
                          <div class="form-group" style="height:68px !important">
                            <label class="col-sm-4 control-label">Usuario*</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control" id="usuario" name="usuario" value="<?= $oDatos->getUsuario() ?>" placeholder="Ingrese el nombre usuario " title="Ingrese el nombre de usuario" tabindex="1" required />
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Contraseña*</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control" id="contrasena" name="contrasena" placeholder="Ingrese la contraseña" title="Ingrese la contraseña" tabindex="2" required />
                            </div>
                          </div>
													<div class="form-group">
                            <label class="col-sm-4 control-label">Perfil*</label>
                            <div class="col-sm-8">
                              <select class="form-control" id="id_perfil" name="id_perfil" tabindex="3" required>
                                <option selected disabled>Seleccione un Perfil</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
													<div class="form-group">
														<label class="col-sm-4 control-label">Empleado*</label>
														<div class="col-sm-8">
															<select class="form-control" id="id_empleado" name="id_empleado" tabindex="4" required>
                                  <option selected disabled>Seleccione un Empleado</option>
                              </select>
														</div>
													</div>
													<div class="form-group">
                            <label class="col-sm-4 control-label">Estado*</label>
                            <div class="col-sm-8">
                              <select class="form-control" id="estado" name="estado" tabindex="12" required />
																<option selected disabled>Seleccione una Opción</option>
                                <option value="1" <?=($oDatos->getEstado() == 1) ? 'selected' : ''; ?>>Activo</option>
                                <option value="2" <?=($oDatos->getEstado() == 2) ? 'selected' : ''; ?>>Inactivo</option>
															</select>
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
                            <button type="button" class="btn-default btn" onclick="window.location = 'cnfg01_usuarios_listado.php'" tabindex="14">Cancelar</button>
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
    <script type='text/javascript' src='assets/js/pages/cnfg01_usuarios_edicion.js'></script>

	</body>
</html>
