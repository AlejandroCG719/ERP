<?php
  header('Content-type: text/javascript');
  ob_start();
  require '../includes/main.php';
  //include '../controller/Binnacle.php';
  ob_end_clean();
  $error = false;
  /// ------*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*
  foreach ($_POST as $key => $value) {
		$$key = $value;
	}
	$contrasena = md5($_POST['contrasena']);
	$consulta= "SELECT a.id_usuario, a.usuario, a.contrasena, a.id_perfil, b.id_empleado, b.nombres, b.app, b.apm FROM usuarios as a INNER JOIN empleados as b ON a.id_empleado = b.id_empleado WHERE a.usuario ='".$_POST['usuario']."' AND a.contrasena = '".$contrasena."' AND a.estado = 1 ;";
  $query=mysqli_query($conexion,$consulta) or die(mysql_error());
  if(mysqli_fetch_assoc($query)>0){
    $query=mysqli_query($conexion,$consulta) or die(mysql_error());
		while($row= mysqli_fetch_assoc($query)){
      $_SESSION['id_usuario']=$row["id_usuario"];
      $_SESSION['id_empleado']=$row["id_empleado"];
      $_SESSION['id_perfil']=$row["id_perfil"];
      $nombre = $row["nombres"]." ". $row["app"]. " ". $row["apm"];
	  }
    $_SESSION['bandera_inicio'] = 1;
    $valor = 1;
    $msj = "<div class='alert alert-dismissable alert-success'> <strong>Bienvenido! </strong>".$nombre."<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button> </div>";
    $bitacora = "INSERT INTO bitacora ( id_evento, id_usuario, fecha, hora, datos, ip ) values ( '1', '".$_SESSION['id_usuario']."', '".date('Y-m-d')."', '".date('H:i:s')."', '".$_SERVER['HTTP_USER_AGENT']."', '".$_SERVER['REMOTE_ADDR']."' );" ;
      $res = mysqli_query($conexion,$bitacora);
  }else {
      $valor = 0;
		$msj = "<div class='alert alert-dismissable alert-danger'> <strong>Oops!</strong> Usuario y/o contraseña incorrecta. <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button> </div>";
		$_SESSION['bandera_inicio'] = 0;
	}
  $resp = ["valor" =>$valor, "msj" =>$msj];
  echo json_encode($resp);
  /// ------*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*
?>
