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
if ($id_empleado != "") {
  $consulta= "UPDATE empleados SET nombres='".$nombres."', app='".$app."', apm='".$apm."', tel='".$tel."', dir='".$dir."', curp='".$curp."', nss='".$nss."', rfc='".$rfc."', fecha_nac='".$fecha_nac."', fecha_alta='".$fecha_alta."', estado='".$estado."', id_puesto='".$id_puesto."' WHERE id_empleado= '".$id_empleado."'; ";
  $bitacora = "INSERT INTO bitacora (id_evento, id_usuario, fecha, hora, datos, ip) values ('10', '".$_SESSION['id_usuario']."', '".date('Y-m-d')."', '".date('H:i:s')."', 'Se modificó el empleado: ".$nombres." ".$app." ".$apm." con el id: ".$id_empleado."', '".$_SERVER['REMOTE_ADDR']."');" ;
} else {
  $consulta = "INSERT INTO empleados (nombres, app, apm, tel, dir, curp, nss, rfc, fecha_nac, fecha_alta, estado, id_puesto) values ('".$nombres."', '".$app."', '".$apm."', '".$tel."', '".$dir."', '".$curp."', '".$nss."', '".$rfc."', '".$fecha_nac."', '".$fecha_alta."', '".$estado."', ".$id_puesto.");" ;
  $bitacora = "INSERT INTO bitacora (id_evento, id_usuario, fecha, hora, datos, ip) values ('9', '".$_SESSION['id_usuario']."', '".date('Y-m-d')."', '".date('H:i:s')."', 'Se agregó el empleado: ".$nombres." ".$app." ".$apm."', '".$_SERVER['REMOTE_ADDR']."');" ;
}
$res = mysqli_query($conexion,$consulta);
if (!$res) {
  $error = true;
}else {
  mysqli_query($conexion,$bitacora);
}
$datos[] = array('error' =>$error);
echo json_encode($datos);
?>
