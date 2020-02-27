<?php
  header('Access-Control-Allow-Origin: *');
  header('Cache-Control: no-cache, must-revalidate');
  header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
  header('Content-type: text/javascript');
  ob_start();
  require '../includes/main.php';
  ob_end_clean();
  foreach ($_POST as $key => $value) {
    $$key = $value;
  }
  $datos='';
  $datos = [];
  $error = false;
  if ($id_supermodulo != "") {
    $consulta= "UPDATE supermodulos SET nombre='".$nombre."', imagen='".$imagen."', descripcion='".$descripcion."', orden='".$orden."' WHERE id_supermodulo= '".$id_supermodulo."'; ";
    $bitacora = "INSERT INTO bitacora (id_evento, id_usuario, fecha, hora, datos, ip) values ('8', '".$_SESSION['id_usuario']."', '".date('Y-m-d')."', '".date('H:i:s')."', 'Se modificó el supermódulo: ".$nombre."', '".$_SERVER['REMOTE_ADDR']."');" ;
  } else {
    $consulta = "INSERT INTO supermodulos (nombre, imagen, descripcion, orden) values ('".$nombre."', '".$imagen."', '".$descripcion."', '".$orden."') ;" ;
    $bitacora = "INSERT INTO bitacora (id_evento, id_usuario, fecha, hora, datos, ip) values ('7', '".$_SESSION['id_usuario']."', '".date('Y-m-d')."', '".date('H:i:s')."', 'Se registró un nuevo supermódulo: ".$nombre."', '".$_SERVER['REMOTE_ADDR']."');" ;
  }
  $res = mysqli_query($conexion,$consulta);
  if (!$res) {
    $msg = 'Ocurrio un Error, por favor verifique e intente nuevamente. ';
    $error = true;
  }else {
    mysqli_query($conexion,$bitacora);
  }
  $datos[] = array('error' =>$error);
  echo json_encode($datos);
?>
