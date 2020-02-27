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
  $key = $value;
}
//usuario nuevo
if ($_POST['id_usuario'] == "" ) {
  //revisamos que no exista el usuario
  $libre= true;
  $consulta= "SELECT * FROM usuarios WHERE usuario='".$usuario."' Limit 1;";
  $res = $query=mysqli_query($conexion,$consulta);
  if (!$res) {
    $error = true;
  }else {
    while($row= mysqli_fetch_assoc($query)){
      $libre = false;
    }
  }
  if ($libre == true) {
    $consulta = "INSERT INTO usuarios ( usuario, contrasena, estado, id_perfil, id_empleado ) values ( '".$_POST['usuario']."', '".md5($contrasena)."', '".$_POST['estado']."', '".$_POST['id_perfil']."', '".$_POST['id_empleado']."' );" ;
    $res = mysqli_query($conexion,$consulta);
    if (!$res) {
        $error = true;
      }else {
        $bitacora = "INSERT INTO bitacora ( id_evento, id_usuario, fecha, hora, datos, ip ) values ( '2', '".$_SESSION['id_usuario']."', '".date('Y-m-d')."', '".date('H:i:s')."', 'Se ingresó un nuevo usuario: ".$usuario."', '".$_SERVER['REMOTE_ADDR']."' );" ;
        $res = mysqli_query($conexion,$bitacora);
      }
        $datos[] = array('error' =>false);
        echo json_encode($datos);
  }else {
    $datos[] = array('error' =>"duplicado");
    echo json_encode($datos);
  }
}else {
  $consulta= "UPDATE usuarios SET usuario='".$_POST['usuario']."', contrasena='".md5($contrasena)."', estado='".$_POST['estado']."', id_perfil='".$_POST['id_perfil']."', id_empleado='".$_POST['id_empleado']."' WHERE id_usuario= '".$_POST['id_usuario']."';" ;
  $res = mysqli_query($conexion,$consulta);
  if ($res == true) {
    $bitacora = "INSERT INTO bitacora ( id_evento, id_usuario, fecha, hora, datos, ip ) values ( '3', '".$_SESSION['id_usuario']."', '".date('Y-m-d')."', '".date('H:i:s')."', 'Se actualizó el usuario: ".$usuario." con id: ".$_POST['id_usuario']."', '".$_SERVER['REMOTE_ADDR']."' );" ;
    $res = mysqli_query($conexion,$bitacora);
  }else {
    $error = true;
  }
  $datos[] = array('error' =>false);
  echo json_encode($datos);
}
?>
