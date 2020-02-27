<?php
  header("Last-Modified: 13 Oct 2016 16:11:00 GMT");
  ini_set('display_errors', 'Off');           //Despliega errores de codigo
  //ini_set('SMTP', 'smtp.juventudsanpedro.com');
  //ini_set('sendmail_from', 'info@juventudsanpedro.com');
  error_reporting(E_ALL ^ E_NOTICE);     //Solo errores de codigo dinamico
  require 'config2.php';
  $conexion = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
  //require DIR_PATH . 'panel/controller/Policy.php';
  //require DIR_PATH . 'panel/controller/Usuario.php';
  //require DIR_PATH . 'panel/includes/libs.php';
  session_start();
  set_time_limit(0);
  ini_set('upload_max_filesize', '300M');
  ini_set('post_max_size', '300M');
  ini_set('memory_limit', '6144M');
  header('Cache-control: private');
  header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
  header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");
  session_cache_limiter("must-revalidate");
  date_default_timezone_set('America/Mexico_City');
?>
