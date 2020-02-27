<?php
	session_start();
	$_SESSION['bandera_inicio']=0;
	unset($_SESSION['bandera_inicio']);
  unset($_SESSION['id_usuario']);
  unset($_SESSION['id_empleado']);
  unset($_SESSION['id_perfil']);
	session_destroy();
	header("Location: ../login.php");
?>
