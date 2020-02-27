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
    <!-- <script type="text/javascript" src="assets/js/less.js"></script> -->

    <!-- css especificos -->
    <link rel='stylesheet' type='text/css' href='assets/plugins/datatables/dataTables.tableTools_.css' />
    <link rel='stylesheet' type='text/css' href='assets/plugins/datatables/dataTables.css' />
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
              <li><a href="cnfg07_bitacora.php"><i class="<?= $oBreadcrumb->getImagen() ?>"></i> Bitácora</a></li>
              <li class="active">Listado de Eventos</li>
            </ol>
            <h1><i class="<?= $oBreadcrumb->getImagen() ?>"></i> Bitácora</h1>

          </div>
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <div class="panel panel-sky">
                  <div class="panel-heading">
                    <h4 onclick="loadBitacora()">
                      Listado de Eventos en el Sistema
                    </h4>
                    <div class="options">
                      <a href="javascript:;"><i class="fa fa-cog"></i></a>
                      <a href="javascript:;" onclick="loadBitacora()"><i class="fa fa-refresh"></i></a>
                      <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                    </div>
                  </div>
                  <div class="panel-body collapse in">
                      <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" id="tabla"></table>
                  </div>
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
    <script type='text/javascript' src='assets/js/placeholdr.js'></script>
    <script type='text/javascript' src='assets/js/application.js'></script>
    <script type='text/javascript' src='assets/demo/demo.js'></script>
    <script type='text/javascript' src='assets/plugins/datatables/jquery.dataTables.min.js'></script>
    <script type='text/javascript' src='assets/plugins/datatables/dataTables.tableTools.min.js'></script>
    <script type='text/javascript' src='assets/plugins/datatables/dataTables.bootstrap.js'></script>
    <script type='text/javascript' src='assets/js/pages/cnfg07_bitacora.js'></script>
  </body>
</html>
