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
$error = false;
if ('false' == $add) {
  $accion = "Removido";
  $consulta = "SELECT a.nombre perfil, c.nombre modulo FROM cat_perfiles a INNER JOIN modulo_has_perfiles b ON a.id = b.id_perfil INNER JOIN modulos c ON b.id_modulo = c.id_modulo WHERE b.id_modulo = ".$id_modulo." AND b.id_perfil = ".$id_perfil."; ";
  $query=mysqli_query($conexion,$consulta) or die(mysql_error());
  while($row= mysqli_fetch_assoc($query)){
    $perfil = $row['perfil'];
    $modulo = $row['modulo'];
  }
  $consulta = "DELETE FROM modulo_has_perfiles WHERE id_modulo = ".$id_modulo." AND id_perfil = ".$id_perfil." ;" ;
  $res = mysqli_query($conexion,$consulta);
  if (!$res) {
    $msg = 'Ocurrio un Error, por favor verifique e intente nuevamente. ';
    $error = true;
  }
} else {
  $accion = "Otorgado";
  $consulta = "INSERT INTO modulo_has_perfiles (id_modulo, id_perfil) values ('".$id_modulo."', '".$id_perfil."') ;" ;
  $res = mysqli_query($conexion,$consulta);
  if (!$res) {
    $msg = 'Ocurrio un Error, por favor verifique e intente nuevamente. ';
    $error = true;
  }
  $consulta = "SELECT a.nombre perfil, c.nombre modulo FROM cat_perfiles a INNER JOIN modulo_has_perfiles b ON a.id = b.id_perfil INNER JOIN modulos c ON b.id_modulo = c.id_modulo WHERE b.id_modulo = ".$id_modulo." AND b.id_perfil = ".$id_perfil."; ";
  $query=mysqli_query($conexion,$consulta) or die(mysql_error());
  while($row= mysqli_fetch_assoc($query)){
    $perfil = $row['perfil'];
    $modulo = $row['modulo'];
  }
}
if (true == $res) {
  $msg = 'El Registro se Guardo con Éxito';
  $consulta = "INSERT INTO bitacora ( id_evento, id_usuario, fecha, hora, datos, ip ) values ( '4', '".$_SESSION['id_usuario']."', '".date('Y-m-d')."', '".date('H:i:s')."', 'Perfil: ".$perfil." - Módulo: ".$modulo." - Acceso: ".$accion."', '".$_SERVER['REMOTE_ADDR']."' );" ;
  $res = mysqli_query($conexion,$consulta);
} else {
    $error = true;
    $msg = 'Ocurrio un Error, por favor verifique e intente nuevamente. ';
}
?>
$(document).ready(function () {
$.noty.consumeAlert({layout: 'top', type: '<?= (true == $error) ? 'warning' : 'success' ?>', dismissQueue: true,timeout:2500});
alert("<?= $msg ?>");
});
