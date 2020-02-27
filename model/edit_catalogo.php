<?php
header('Access-Control-Allow-Origin: *');
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: text/javascript');
ob_start();
require '../includes/main.php';
//require '../controller/Modulo.php';
ob_end_clean();
//$db->debug = 1;
foreach ($_POST as $key => $value) {
  $$key = $value;
}
$datos='';
$datos = [];
$error = false;
if (isset($_POST['cat_nuevo'])) {
  //catalogo nuevo
  $consulta = "INSERT INTO indice_catalogos (nombre_tabla, nombre_catalogo, estado) values ('".$nombre_tabla."', '".$nombre_catalogo."', 1) ;" ;
  $bitacora = "INSERT INTO bitacora (id_evento, id_usuario, fecha, hora, datos, ip) values ('11', '".$_SESSION['id_usuario']."', '".date('Y-m-d')."', '".date('H:i:s')."', 'Se registró un nuevo catálogo: ".$nombre_tabla."', '".$_SERVER['REMOTE_ADDR']."');" ;
  $seccion = 1;
}elseif ($id>0) {
  //update info catalogo
  $consulta= "UPDATE ".$nombre_tabla." SET nombre='".$nombre."', valor='".$valor."', caracteristica='".$caracteristica."', fecha='".$fecha."', estado='".$estado."' WHERE id= '".$id."'; ";
  $bitacora = "INSERT INTO bitacora (id_evento, id_usuario, fecha, hora, datos, ip) values ('13', '".$_SESSION['id_usuario']."', '".date('Y-m-d')."', '".date('H:i:s')."', 'Se modificó contenido de la tabla: ".$nombre_tabla." dato: ".$nombre."', '".$_SERVER['REMOTE_ADDR']."');" ;
  $seccion = 2;
}else {
  //nueva info catalogo
  var_dump($_POST);
  $consulta = "INSERT INTO ".$_POST['nombre_tabla']." (nombre, valor, caracteristica, fecha, estado) values ('".$_POST['nombre']."', '".$_POST['valor']."', '".$_POST['caracteristica']."', '".$_POST['fecha']."', '".$_POST['estado']."') ;" ;
  $bitacora = "INSERT INTO bitacora (id_evento, id_usuario, fecha, hora, datos, ip) values ('12', '".$_SESSION['id_usuario']."', '".date('Y-m-d')."', '".date('H:i:s')."', 'Se registró nuevo dato en la tabla: ".$nombre_tabla." dato: ".$nombre."', '".$_SERVER['REMOTE_ADDR']."');" ;
  $seccion = 3;
}
$res = mysqli_query($conexion,$consulta);
if (!$res) {
  $error = true;
  $msg = 'Ocurrio un Error, por favor verifique e intente nuevamente.';
}else {
  $msg = 'El Registro se Guardo con Éxito';
  mysqli_query($conexion,$bitacora);
}
$datos[] = array('error' =>$error, 'desc' =>$msg, 'seccion' =>$seccion);
echo json_encode($datos);
?>
