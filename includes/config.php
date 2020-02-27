<?php
    $DB_HOST	= "localhost";
	$DB_NAME	= "erp";
	$DB_USER	= "root";
	$DB_PASSWORD = "root";
  $conexion = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);

    $siteKey = '6LdR5ygTAAAAAMbNS9JEOtTdlXxQnVPD9cwubPea';
    $secret = '6LdR5ygTAAAAAD9zpSbibz_MUf9QSolipEfSQ';

  $lang = 'es';
  define('DIR_PATH', str_replace('panel' . DIRECTORY_SEPARATOR . 'includes', '', dirname(realpath(__FILE__))));
  define('DOMAIN', 'http://172.17.0.75:88');
  define('DIR_APP', '/');
  define('PATH', '' . DOMAIN . DIR_APP);
  $a_System['main_url'] = PATH;
?>
