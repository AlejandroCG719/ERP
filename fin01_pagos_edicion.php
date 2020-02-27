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
  require("classes/Pago.php");
  $oDatos = new Pago();
  if (isset($_GET['id'])) {
    $b=1;
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
        border-top: 1px solid #e6e7e8 !important;
        padding-top: 20px !important;
        padding-bottom: 20px !important;
        margin-bottom: 0 !important;
        margin-left: -20px !important;
        margin-right: -20px !important;
        padding-left: 10px !important;
        padding-right: 10px !important;
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
							<li><a href="fin01_pagos_listado.php"><i class="<?= $oBreadcrumb->getImagen() ?>"></i> Pagos</a></li>
							<li class="active">Edición de Pagos</li>
						</ol>
						<h1>Registro de Pago</h1>
					</div>
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<div id="message">
									<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert">&times;</a>Los Datos marcados con <strong>(*) son obligatorios.</strong></div>
								</div>
                <form  action="" class="form-horizontal row-border" method="post" id="frm-empleado" name="formEmpleado">
                  <input type="hidden" name="id_pago_solicitud" id="id_pago_solicitud" value="<?= $_GET['id'] ?>">
                  <input type="hidden" name="id_finanzas_pago" id="id_finanzas_pago" value="<?= $oDatos->getIdFinanzaPgo() ?>">
                  <input type="hidden" id="num_pagos" value="<?= $oDatos->getNumPagos() ?>">
                  <input type="hidden" name="indice_pagos" id="indice_pagos">
                  <div class="panel panel-midnightblue">
                    <div class="panel-heading">
                      <h4>
                        Datos del Pago - Solicitante
                      </h4>
                      <div class="options">
                        <a href="javascript:;"><i class="fa fa-cog"></i></a>
                        <!--a href="j avascript:;" onclick="loadModulos()"><i class="fa fa-refresh"></i></a-->
                        <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                      </div>
                    </div>
                    <div class="panel-body collapse in">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Fecha Solicitud</label>
                            <div class="col-sm-6">
                              <div class="input-group date">
                                <input type="text" class="form-control datepicker" name="fecha_solicitud" id="fecha_solicitud" value="<?= ($b == 1) ? $oDatos->getFechaSolicitud() : date("Y-m-d") ?>" <?= ($b == 1) ? 'disabled' : 'required'; ?>>
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="condiciones_almacenamiento">Solicitante*</label>
                            <div class="col-sm-6">
                              <input type="text" value="<?= $oDatos->getSolicitante() ?>" class="form-control sec-1" id="solicitante" name="solicitante" placeholder="Solicitante" title="Ingrese nombre del solicitante" tabindex="1"  <?= ($b == 1) ? 'disabled' : 'required'; ?>/>
                            </div>
                            <a href="#refrigeracion" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el nomnbre del solicitante">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Monto*</label>
                            <div class="col-sm-6">
                              <input type="number" step="0.01" value="<?= $oDatos->getMonto() ?>" onchange="NumeroALetras(this.value)" class="form-control sec-1" id="monto" name="monto" placeholder="Ingrese el monto" title="Ingrese el monto del pago" tabindex="2"  <?= ($b == 1) ? 'disabled' : 'required'; ?>>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Monto del Pago">
                              <span class="fa  fa-info-circle"></span>
                            </a>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Bancos*</label>
                            <div class="col-sm-6">
                              <input type="hidden" value="<?= $oDatos->getIdBanco() ?>"id="solicitante_banco"/>
                              <select class="form-control selectpicker show-tick" id="banco_solicitante" name="banco_solicitante" tabindex="3" <?= ($b == 1) ? 'disabled' : 'required'; ?> onchange="noAplica()">
                                <option selected disabled>Seleccione un banco*</option>
                              </select>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione un banco">
                              <span class="fa  fa-info-circle"></span>
                            </a>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Beneficiario*</label>
                            <div class="col-sm-6">
                              <input type="typeahead" value="<?= $oDatos->getBeneficiario() ?>" class="form-control typeahead sec-1" id="beneficiario" name="beneficiario" maxlength="70" placeholder="Nombre del beneficiario" title="Ingrese el nombre del beneficiario" tabindex="7"  <?= ($b == 1) ? 'disabled' : 'required'; ?>/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el nombre del beneficiario">
                              <span class="fa  fa-info-circle"></span>
                            </a>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="condiciones_almacenamiento">PTTO*</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control sec-1" id="id_cotizacion" name="id_cotizacion" value="<?= $oDatos->getCotizacion() ?>" <?= ($b == 1) ? 'disabled' : 'required'; ?>>
                            </div>
                            <a href="#refrigeracion" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione el PTTO">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Plaza*</label>
                            <div class="col-sm-6">
                              <input type="text" value="<?= $oDatos->getPlaza() ?>" class="form-control sec-1" id="plaza" name="plaza" maxlength="70" placeholder="Ingrese la plaza" title="Ingrese la plaza" tabindex="4"  <?= ($b == 1) ? 'disabled' : 'required'; ?>/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese la plaza">
                              <span class="fa  fa-info-circle"></span>
                            </a>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Folio*</label>
                            <div class="col-sm-6">
                              <input type="text" value="<?= $oDatos->getFolio() ?>" class="form-control sec-1" name="folio" id="folio" placeholder="Número de folio" tabindex="5"  <?= ($b == 1) ? 'disabled' : 'required'; ?>/>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Monto con letra*</label>
                            <div class="col-sm-6">
                              <input type="text" value="<?= $oDatos->getMontoLetra() ?>" class="form-control sec-1" id="monto_letra" name="monto_letra" placeholder="Ingrese el monto con letra" title="Ingrese el monto del pago con letra" tabindex="6"  <?= ($b == 1) ? 'disabled' : 'required'; ?>>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Monto del pago con letra">
                              <span class="fa  fa-info-circle"></span>
                            </a>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Cuenta depósito*</label>
                            <div class="col-sm-6">
                              <input type="text" value="<?= $oDatos->getCuentaDeposito() ?>" class="form-control sec-1" id="cuenta_deposito" name="cuenta_deposito" maxlength="70" placeholder="Cuenta depósito" title="Ingrese la cuenta de depósito" tabindex="6"  <?= ($b == 1) ? 'disabled' : 'required'; ?>/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese la cuenta de depósito">
                              <span class="fa  fa-info-circle"></span>
                            </a>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Promoción*</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" id="id_promocion" name="id_promocion" value="<?= $oDatos->getPromocion() ?>" tabindex="3" <?= ($b == 1) ? 'disabled' : 'required'; ?>>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese la promoción">
                              <span class="fa  fa-info-circle"></span>
                            </a>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Concepto*</label>
                            <div class="col-sm-6">
                              <input type="text" value="<?= $oDatos->getConcepto() ?>" class="form-control sec-1" id="concepto" name="concepto" placeholder="Concepto ej: Compra material" title="Ingrese el concepto del pago" tabindex="8"  <?= ($b == 1) ? 'disabled' : 'required'; ?>/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el concepto ej: Compra material">
                              <span class="fa  fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div <?php if($b==0){ echo 'hidden';}?>>
                    <div class="panel panel-midnightblue">
                    <div class="panel-heading">
                      <h4 onclick="loadModulos()">
                        Datos del Pago - Transferencia
                      </h4>
                      <div class="options">
                        <a href="javascript:;"><i class="fa fa-cog"></i></a>
                        <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                      </div>
                    </div>
                    <div class="panel-body collapse in">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Programación de pago*</label>
                            <div class="col-sm-6">
                              <div class="input-group date">
                                <input type="text" name="programacion_pago" class="form-control datepicker sec-2" value="<?= $oDatos->getProgramacionPago() ?>" tabindex="9" <?= ($b == 0) ? 'disabled' : 'required'; ?>/>
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese la fecha en que se realizó el depósito">
                              <span class="fa  fa-info-circle"></span>
                            </a>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Concepto*</label>
                            <div class="col-sm-6">
                              <input type="hidden" id="concepto_pago" value="<?= $oDatos->getIdConceptoPago() ?>">
                              <select class="form-control selectpicker show-tick sec-2" id="id_concepto_pago" name="id_concepto_pago"  title="Seleccione un Concepto" onchange="loadSubconceptosPagos()" <?= ($b == 0) ? 'disabled' : 'required'; ?> tabindex="13">
                                <option value="" selected disabled>Seleccione una Opción</option>
                                <!-- Cargar catalogo cat_concepto_pagos -->
                              </select>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el concepto del pago ej: Compra de mat expo Chedrahui">
                              <span class="fa  fa-info-circle"></span>
                            </a>
                          </div>
                          <div class="form-group ">
                            <label class="col-sm-3 control-label">Observaciones</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control  " id="observaciones" name="observaciones" placeholder="Observaciones" value="<?= $oDatos->getObservaciones() ?>" title="Ingrese nombre del solicitante" tabindex="16"/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Referencia*</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control sec-2" id="referencia" name="referencia" value="<?= $oDatos->getReferencia() ?>" placeholder="Referencia" title="Ingrese la referencia" tabindex="15" <?php if ($b==0){echo "disabled";}else{echo "required";} ?>/>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Monto del Costo de compra del producto.">
                              <span class="fa  fa-info-circle"></span>
                            </a>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Subconcepto*</label>
                            <div class="col-sm-6">
                              <input type="hidden" id="subconcepto_pago" value="<?= $oDatos->getIdSubconceptoPago() ?>">
                              <select class="form-control selectpicker show-tick sec-2" id="id_subconcepto" name="id_subconcepto_pago" title="Seleccione un Subconcepto" <?= ($b == 0) ? 'disabled' : 'required'; ?> tabindex="13">
                                <option disabled selected>Seleccione un Concepto</option>
                              </select>
                              <!--input type="text" class="form-control" id="concepto_1" name="concepto_1" placeholder="Concepto ej: Compra de mat expo Chedrahui" title="Ingrese concepto del pago" tabindex="15" <?= ($b == 0) ? 'disabled' : 'required'; ?>/-->
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el concepto del pago ej: Compra de mat expo Chedrahui">
                              <span class="fa  fa-info-circle"></span>
                            </a>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Fecha depósito</label>
                            <div class="col-sm-6">
                              <div class="input-group date">
                                <input type="text" name="fecha_deposito" id="fecha_deposito" class="form-control datepicker" value="<?= $oDatos->getFechaDeposito() ?>" tabindex="9"/>
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                              </div>
                            </div>
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese la fecha en que se realizó el depósito">
                              <span class="fa  fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Estado</label>
                            <div class="col-sm-6">
                              <input type="hidden" id="estado" value="<?= $oDatos->getStatus() ?>">
                              <select class="form-control selectpicker show-tick" id="status" name="status" title="Seleccione una opción" onclick="estadoCheck();" <?= ($b == 0) ? 'disabled' : 'required'; ?> tabindex="13">
                                <option value="" selected disabled>Seleccione una Opción</option>
                                <!-- Cargar catalogo cat_estado_pagos -->
                              </select>
                            </div>
                            <a href="#refrigeracion" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el status del pago">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group borde">
                            <label class="col-sm-4 control-label">Banco*</label>
                            <div class="col-sm-7">
                              <input type="hidden" id="banco" value="">
                              <select class="form-control selectpicker show-tick sec-2" id="id_banco_0" name="id_banco_0" onchange="loadBancoCuentas('0')" title="Seleccione un Banco" <?= ($b == 0) ? 'disabled' : 'required'; ?> tabindex="13">
                                <option value="0" selected disabled>Seleccione una Opción</option>
                                <!-- Cargar catalogo cat_bancos -->
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group borde">
                            <label class="col-sm-4 control-label">Cuenta banco*</label>
                            <div class="col-sm-7">
                              <input type="hidden" id="banco_cuenta_0" value="">
                              <select class="form-control selectpicker show-tick sec-2" id="id_cuenta_banco_0" name="id_cuenta_banco_0" title="Seleccione una Cuenta" <?= ($b == 0) ? 'disabled' : 'required'; ?> tabindex="13">
                                <option value="0" selected disabled>Seleccione una Opción</option>
                                <!-- Cargar catalogo cuentas dependeindo el banco -->
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group borde">
                            <label class="col-sm-4 control-label">Monto*</label>
                            <div class="col-sm-7">
                              <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="number" class="form-control" id="monto_0" name="monto_0"  step="0.01" min="0" placeholder="Ingrese el monto" title="Ingrese el monto"   tabindex="14" <?= ($b == 0) ? 'disabled' : 'required'; ?> />
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group borde">
                            <label class="col-sm-4 control-label">Forma de pago*</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <select class="form-control" name="id_forma_pago_0" id="id_forma_pago_0" required>
                                  <option selected disabled>Seleccione una forma de pago</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-1">
        											<button type="button" onclick="addFormaPago()" class="btn btn-info boton"><i class="fa fa-plus"></i></button>
        										</div>
                          </div>
                        </div>
                      </div>
                      <div id="pagos">

                      </div>
                    </div>
                  </div>
                  </div>
                  <div class="panel-footer">
                    <div class="row">
                      <div class="col-sm-6 col-sm-offset-3">
                        <div class="btn-toolbar">
                          <button type="submit" class="btn-primary btn btn-label" id="saveButton" tabindex="13"><i class="fa fa-save"></i> Guardar</button>
                          <button type="button" class="btn-default btn" onclick="window.location = 'fin01_pagos_listado.php'" tabindex="14">Cancelar</button>
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
    <script type='text/javascript' src='assets/plugins/form-typeahead/typeahead.min.js'></script>

		<!--
    <script type='text/javascript' src='assets/plugins/form-select2/select2.min.js'></script>
		<script type='text/javascript' src='assets/plugins/form-multiselect/js/jquery.multi-select.min.js'></script>
		<script type='text/javascript' src='assets/plugins/quicksearch/jquery.quicksearch.min.js'></script>

		<script type='text/javascript' src='assets/plugins/form-autosize/jquery.autosize-min.js'></script>
		<script type='text/javascript' src='assets/plugins/form-colorpicker/js/bootstrap-colorpicker.min.js'></script>
		<script type='text/javascript' src='assets/plugins/jqueryui-timepicker/jquery.ui.timepicker.min.js'></script>
		<script type='text/javascript' src='assets/plugins/form-daterangepicker/daterangepicker.min.js'></script> -->
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
    <script type='text/javascript' src='assets/js/pages/fin01_pagos_edicion.js'></script>

	</body>
</html>
