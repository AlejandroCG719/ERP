<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>XMLHttpRequest2 File Upload Example App</title>
        <script type='text/javascript' src='assets/js/jquery-1.10.2.min.js'></script>
        <script type='text/javascript' src='assets/js/jqueryui-1.10.3.min.js'></script>
        <script type='text/javascript' src='assets/js/bootstrap.min.js'></script>
        <script type='text/javascript' src='assets/js/enquire.js'></script>
        <script type='text/javascript' src='assets/js/jquery.cookie.js'></script>
        <script type='text/javascript' src='assets/js/jquery.nicescroll.min.js'></script>
        <script type='text/javascript' src='assets/plugins/codeprettifier/prettify.js'></script>
        <script type='text/javascript' src='assets/plugins/sparklines/jquery.sparklines.min.js'></script>
        <script type='text/javascript' src='assets/plugins/form-toggle/toggle.min.js'></script>
        <script type='text/javascript' src='assets/plugins/form-select2/select2.min.js'></script>
        <script type='text/javascript' src='assets/plugins/form-daterangepicker/daterangepicker.min.js'></script>
        <script type='text/javascript' src='assets/plugins/form-datepicker/js/bootstrap-datepicker.js'></script>
        <script type='text/javascript' src='assets/plugins/form-jasnyupload/fileinput.min.js'></script>
        <script type='text/javascript' src='assets/js/placeholdr.js'></script>
        <script type='text/javascript' src='assets/js/application.js'></script>
        <script type='text/javascript' src='assets/demo/demo.js'></script>
        <script src="assets/js/noty/js/noty/packaged/jquery.noty.packaged.min.js" type="text/javascript"></script>
        <script type='text/javascript' src='assets/plugins/progress-skylo/skylo.js'></script>
        <script type='text/javascript' src='assets/js/pages/fileupload.js'></script>
    </head>
    <body>
      <form method="post" enctype="multipart/form-data" name="fileinfo" id="frm-empleado">
  			<input type="file" name="archivo" id="archivo" onchange="validarCV()"></input>
        <input type="text" name="FileName" id="FileName"></input>
  			<input type="submit" value="Subir archivo"></input>
  		</form>
    </body>
</html>
