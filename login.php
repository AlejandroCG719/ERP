<?php
  require 'includes/main.php';
?>
<!DOCTYPE html>
<html lang="es-MX">
  <head>
    <meta charset="utf-8">
      <title>Enterprise Resource Planning.</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="assets/less/styles.less" rel="stylesheet/less" media="all">
    <link rel="stylesheet" href="assets/css/styles.min.css?=113">
    <link rel="icon" href="<?php echo PATH; ?>images/favicon.png">
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>
    <script src="assets/js/jquery-1.10.2.min.js" type="text/javascript"></script>
    <script>
        setTimeout(function () {
            $(".alert").fadeOut(1000);
        })
    </script>
  </head>
  <body class="focusedform">
    <div class="verticalcenter">
      <div id="mensaje">
        <div class="alert alert-info"><a href="#" class="close" data-dismiss="alert">&times;</a>Ingrese su  <strong> Usuario </strong> y <strong>Contraseña.</strong></div>
      </div>
      <!--a href="index.htm"><img src="assets/img/logo-big.png" alt="Logo" class="brand" /></a-->
      <div class="panel panel-primary">
        <form class="form-horizontal" id="frm-login" style="margin-bottom: 0px !important;"></strong>
          <div class="panel-body">
            <div class="row">
              <h4 class="text-center" style="margin-bottom: 25px;">Enterprise Resource Planning.</h4>
              <div class="col-md-4">
                <a href="<?=PATH?>">
                  <img src="<?= PATH ?>images/logo.png" alt="Logo" class="img img-responsive" height="300px"/>
                </a>
              </div>
              <div class="col-md-8">
                <div class="form-group">
                  <div class="col-md-12">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-user"></i></span>
                      <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" required>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Contraseña" required>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
          <div class="panel-footer">
          <!--<a href="extras-forgotpassword.htm" class="pull-left btn btn-link" style="padding-left:0">Forgot password?</a>-->
          <div class="pull-right">
            <button type="submit" id="btn-login" class="btn-primary btn btn-label">Entrar</button>
            <!-- <a class="btn btn-primary" id="btn-login">Iniciar Sesión</a> -->
          </div>
        </div>
        </form>
      </div>
    </div>
    <script type='text/javascript' src='<?= PATH ?>assets/js/jqueryui-1.10.3.min.js'></script>
    <script type='text/javascript' src='<?= PATH ?>assets/js/pages/login.js'></script>
    <script type='text/javascript' src='assets/js/bootstrap.min.js'></script>
  </body>
</html>
