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

if ($_POST['id'] != "") {
  $consulta = "UPDATE cat_clientes SET nombre='".$nombre."', valor='".$valor."', caracteristica='".$caracteristica."', fecha='".$fecha."', telefono='".$telefono."', cp='".$cp."', dir='".$dir."', estado='".$estado."' WHERE id= '".$id."'; ";
  $bitacora = "INSERT INTO bitacora (id_evento, id_usuario, fecha, hora, datos, ip) values ('10', '".$_SESSION['id_usuario']."', '".date('Y-m-d')."', '".date('H:i:s')."', 'Se modificó el empleado: ".$nombres." ".$app." ".$apm." con el id: ".$id_empleado."', '".$_SERVER['REMOTE_ADDR']."');" ;
} else {
  $consulta = "INSERT INTO cat_clientes (nombre, valor, caracteristica, fecha, telefono, cp, dir, estado) values ('".$_POST['nombre']."', '".$_POST['valor']."', '".$_POST['nombre']."', '".$_POST['fecha']."', '".$_POST['telefono']."', '".$_POST['cp']."', '".$_POST['dir']."', '".$_POST['estado']."');" ;
  $bitacora = "INSERT INTO bitacora (id_evento, id_usuario, fecha, hora, datos, ip) values ('9', '".$_SESSION['id_usuario']."', '".date('Y-m-d')."', '".date('H:i:s')."', 'Se agregó el empleado: ".$nombres." ".$app." ".$apm."', '".$_SERVER['REMOTE_ADDR']."');" ;
}
$res = mysqli_query($conexion,$consulta);
if (!$res) {
  $error = true. "error";
}else {
 mysqli_query($conexion,$bitacora);
}
$datos[] = array('error' =>$error);
echo json_encode($datos);
?>
