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
  require("classes/Catalogo.php");
  $oCatalogo = new Catalogo();
  if (isset($_GET['id'])) {
    $oCatalogo->setConsulta($_GET['id'],$_GET['nombre_tabla']);
  }
?>
<!DOCTYPE html>
<html lang="es-MX">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo PATH; ?>images/favicon.png">
      <title>Enterprise Resource Planning.</title>
    <!-- <link href="assets/less/styles.less" rel="stylesheet/less" media="all">  -->
    <link rel="stylesheet" href="assets/css/styles.css?=121">
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>
    <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='styleswitcher'>
    <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='headerswitcher'>

    <!-- The following CSS are included as plugins and can be removed if unused-->
    <link rel='stylesheet' type='text/css' href='assets/plugins/form-daterangepicker/daterangepicker-bs3.css' />
    <link rel='stylesheet' type='text/css' href='assets/plugins/fullcalendar/fullcalendar.css' />
    <link rel='stylesheet' type='text/css' href='assets/plugins/form-markdown/css/bootstrap-markdown.min.css' />
    <link rel='stylesheet' type='text/css' href='assets/plugins/codeprettifier/prettify.css' />
    <link rel='stylesheet' type='text/css' href='assets/plugins/form-toggle/toggles.css' />
    <link rel='stylesheet' type='text/css' href='assets/plugins/progress-skylo/skylo.css' />
    <!-- <script type="text/javascript" src="assets/js/less.js"></script> -->

  </head>
  <body class="">
    <?php require("snippets/header.php"); ?>
    <div id="page-container">
      <?php require("snippets/sidebars.php"); ?>
      <div id="page-content">
        <div id='wrap'>
          <div id="page-heading">
            <ol class="breadcrumb">
              <li><a href="index.php"><i class="fa fa-home"></i> Inicio</a></li>
              <li><a href="cnfg05_catalogos_indice.php"><i class="<?= $oBreadcrumb->getImagen() ?>"></i> Índice de Catálogos</a></li>
              <li class="active">Edición de Catálogo</li>
            </ol>
            <h1><i class="<?= $oBreadcrumb->getImagen() ?>"></i> Edición de Registro</h1>
            <div class="options">
              <div class="btn-toolbar">
                <div class="btn-group hidden-xs">
                  <!-- a href='#' class="btn btn-default dropdown-toggle" data-toggle='dropdown'><i class="fa fa-cloud-download"></i><span class="hidden-sm"> Export as  </span><span class="caret"></span></a> -->
                  <ul class="dropdown-menu">
                    <li><a href="#">Text File (*.txt)</a></li>
                    <li><a href="#">Excel File (*.xlsx)</a></li>
                    <li><a href="#">PDF File (*.pdf)</a></li>
                  </ul>
                </div>
                <a href='cnfg05_catalogos_edicion.php?nombre_tabla=<?= $_GET['nombre_tabla'] ?>' class="btn btn-default"><i class="fa fa-plus"></i><span class="hidden-sm"> Nuevo registro</span></a>
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
                  <form  action="" class="form-horizontal row-border" method="post" id="frm-catalogo" name="formModule">
                    <input type="hidden" id="id" name="id" value="<?= $oCatalogo->getId() ?>">
                    <div class="panel-heading">
                      <h4 onclick="loadModulos()">
                        Edición de registro de Catálogo
                      </h4>
                      <div class="options">
                        <a href="javascript:;"><i class="fa fa-cog"></i></a>
                        <!--a href="javascript:;" onclick="loadModulos()"><i class="fa fa-refresh"></i></a-->
                        <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                      </div>
                    </div>
                    <div class="panel-body collapse in">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Catálogo</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" value="<?= $_GET['nombre_tabla'] ?>" disabled>
                              <input type="hidden" name="nombre_tabla" class="form-control" value="<?= $_GET['nombre_tabla'] ?>">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Nombre</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="nombre" placeholder="Ingrese la descripción del registro" title="Ingrese una descripción del registro" value="<?= $oCatalogo->getNombre() ?>" required />
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Valor</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="valor" placeholder="Ingrese el identificador del registro" title="Ingrese el identificador" value="<?= $oCatalogo->getValor() ?>" required />
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Caracteristica</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="caracteristica" placeholder="Ingrese el Valor" title="Ingrese una caracteristica del registro" value="<?= $oCatalogo->getCaracteristica() ?>" required />
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Fecha</label>
                            <div class="col-sm-6">
                              <div class="input-group date datepicker">
																<input type="text" class="form-control" id="fecha" name="fecha" placeholder="Seleccione la fecha" title="Seleccione la fecha" value="<?= $oCatalogo->getFecha() ?>" required />
																<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
															</div>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Estado</label>
                            <div class="col-sm-6">
                              <select class="form-control" name="estado">
                                <option value="1" <?=($oCatalogo->getEstado() == 1) ? 'selected' : ''; ?>>Activo</option>
                                <option value="2" <?= ($oCatalogo->getEstado() == 2) ? 'selected' : ''; ?>>Inactivo</option>
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
                            <button type="submit" class="btn-primary btn btn-label" id="saveButton" tabindex="8"><i class="fa fa-save"></i> Guardar</button>
                            <button type="button" class="btn-default btn" onclick="window.location = 'cnfg05_catalogos_contenido.php?nombre_tabla=<?= $_REQUEST['nombre_tabla'] ?>'" tabindex="9">Cancelar</button>
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
    <script type='text/javascript' src='assets/js/pages/cnfg05_catalogos_edicion.js'></script>
  </body>
</html>
