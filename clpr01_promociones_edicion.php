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
  require("classes/Promocion.php");
  $oDatos = new Promocion();
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
							<li><a href="clpr01_promociones_listado.php"><i class="<?= $oBreadcrumb->getImagen() ?>"></i> Promociones</a></li>
							<li class="active">Edición de Promoción</li>
						</ol>
						<h1>Registro de Promoción</h1>
						<div class="options">
							<div class="btn-toolbar">
								<a href='clpr01_promociones_edicion.php' class="btn btn-default"><i class="fa fa-plus"></i><span class="hidden-sm"> Nueva promoción</span></a>
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
                  <input type="hidden" id="cliente" value="<?= $oDatos->getCliente() ?>">
                  <form  action="" class="form-horizontal row-border" method="post" id="frm-empleado" name="formEmpleado">
                    <input type="hidden" id="id" name="id" value="<?= $oDatos->getId() ?>">
                    <div class="panel-heading">
                      <h4 onclick="loadModulos()">
                        Edición de Promoción
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
                            <label class="col-sm-4 control-label">Fecha*</label>
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
                            <label class="col-sm-4 control-label">Promoción*</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $oDatos->getNombre() ?>" placeholder="Ingrese el nombre de la promoción" title="Ingrese el nombre de la promoción" tabindex="2" required />
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el nombre de la promoción">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
													<div class="form-group">
                            <label class="col-sm-4 control-label">Carga Social Personal*</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <input type="text" class="form-control" id="carga_social" name="carga_social" value="<?= $oDatos->getCargaSocial() ?>" placeholder="Ingrese la carga social" title="Ingrese el porcentaje de la carga social" tabindex="3" />
                                <span class="input-group-addon">%</span>
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el porcentaje de la carga social">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Carga Social(Incentivos)*</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <input type="text" class="form-control" id="carga_social_incentivos" name="carga_social_incentivos" value="<?= $oDatos->getCargaSocialIncentivos() ?>" placeholder="Ingrese la carga social" title="Ingrese el porcentaje de la carga social" tabindex="3" />
                                <span class="input-group-addon">%</span>
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el porcentaje de la carga social">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Carga Social(Pasivo Laboral)*</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <input type="text" class="form-control" id="carga_social_pl" name="carga_social_pl" value="<?= $oDatos->getCargaSocialPL() ?>" placeholder="Ingrese la carga social" title="Ingrese el porcentaje de la carga social" tabindex="3" />
                                <span class="input-group-addon">%</span>
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el porcentaje de la carga social">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Comisión Degustaciones*</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <input type="text" class="form-control" id="com_ag_degu" name="com_ag_degu" value="<?= $oDatos->getComisionDegu() ?>" placeholder="Ingrese la comision de agencia" title="Ingrese la comision de agencia" tabindex="3" />
                                <span class="input-group-addon">%</span>
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el porcentaje de la carga social">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
													<div class="form-group">
                            <label class="col-sm-4 control-label">Comisión de Material*</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <input type="text" class="form-control" id="com_ag_mat" name="com_ag_mat" value="<?= $oDatos->getComisionMaterial() ?>" placeholder="Comisión de agencia" title="Ingrese el porcentaje de comisión de agencia" tabindex="4" required />
                                <span class="input-group-addon">%</span>
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el porcentaje de comisión de agencia">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Comisión otros*</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <input type="text" class="form-control" id="com_ag_otros" name="com_ag_otros" value="<?= $oDatos->getComisionOtros() ?>" placeholder="Comisión de agencia" title="Ingrese el porcentaje de comisión de agencia" tabindex="4" required />
                                <span class="input-group-addon">%</span>
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el porcentaje de comisión de agencia">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-6">
													<div class="form-group">
														<label class="col-sm-4 control-label">Num. Promoción*</label>
														<div class="col-sm-6">
															<input type="text" class="form-control" id="valor" name="valor" value="<?= $oDatos->getValor() ?>" placeholder="Número de la promoción" title="Ingrese el número de la promoción"/>
														</div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el número de la promoción">
                              <span class="fa fa-info-circle"></span>
                            </a>
													</div>
													<div class="form-group">
                            <label class="col-sm-4 control-label">Cliente*</label>
                            <div class="col-sm-6">
                              <select id="id_cliente" name="id_cliente" class="form-control selectpicker show-tick" title="Seleccione un Cliente" tabindex="8" required/>
                              </select>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione un cliente">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
													<div class="form-group">
                            <label class="col-sm-4 control-label">Comisión de Personal*</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <input type="text" class="form-control" id="com_ag_per" name="com_ag_per" value="<?= $oDatos->getComisionPersonal() ?>" placeholder="Ingrese la comisión de agencia del personal"  title="Ingrese la comisión de agencia del personal" tabindex="9" required />
                                <span class="input-group-addon">%</span>
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el porcentaje de comisión de agencia">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Comisión de Incentivos*</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <input type="text" class="form-control" id="com_ag_incentivos" name="com_ag_incentivos" value="<?= $oDatos->getComisionIncentivo() ?>" placeholder="Ingrese la  comisión de agencia de incentivos" title="Ingrese la  comisión de agencia de incentivos" tabindex="9" required />
                                <span class="input-group-addon">%</span>
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el porcentaje de comisión de agencia">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Comisión de Pasivo Laboral*</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <input type="text" class="form-control" id="com_ag_pl" name="com_ag_pl" value="<?= $oDatos->getComisionPL() ?>" placeholder="Ingrese la comisión de agencia de pasivo laboral" title="Ingrese la comisión de agencia de pasivo laboral" tabindex="9" required />
                                <span class="input-group-addon">%</span>
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el porcentaje de comisión de agencia">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Comisión de Eventos Especiales*</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <input type="text" class="form-control" id="com_ag_eventos_especiales" name="com_ag_eventos_especiales" value="<?= $oDatos->getComisionEventosEspeciales() ?>" placeholder="Ingrese la comision de Eventos Especiales" title="Ingrese la comision de Eventos Especiales" tabindex="9" required />
                                <span class="input-group-addon">%</span>
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el porcentaje de comisión de agencia">
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
                      </div>
                    </div>
                    <div class="panel-footer">
                      <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
                          <div class="btn-toolbar">
                            <button type="submit" class="btn-primary btn btn-label" id="saveButton" tabindex="13"><i class="fa fa-save"></i> Guardar</button>
                            <button type="button" class="btn-default btn" onclick="window.location = 'clpr01_promociones_listado.php'" tabindex="14">Cancelar</button>
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
    <script type='text/javascript' src='assets/js/pages/clpr01_promociones_edicion.js'></script>
	</body>
</html>
