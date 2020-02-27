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
  if ($id != "") {
    $consulta =
      "UPDATE cat_personal_promocion
      SET
      id_personal ='".$id_personal."',
      id_promocion ='".$id_promocion."',
      carga_social ='".$carga_social."',
      sueldo_base ='".$sueldo_base."'
      where id = '".$id."'
      ;"
    ;
    $res = mysqli_query($conexion,$consulta);
    if (!$res) {
      $error = true;
    }
    //$bitacora = "INSERT INTO bitacora (id_evento, id_usuario, fecha, hora, datos, ip) values ('10', '".$_SESSION['id_usuario']."', '".date('Y-m-d')."', '".date('H:i:s')."', 'Se modificó el empleado: ".$nombres." ".$app." ".$apm." con el id: ".$id_empleado."', '".$_SERVER['REMOTE_ADDR']."');" ;

  }else {
    $consulta =
      "INSERT INTO cat_personal_promocion(
        id_personal,
        id_promocion,
        carga_social,
        sueldo_base
      )
      VALUES(

        '".$id_personal."',
        '".$id_promocion."',
        '".$carga_social."',
        '".$sueldo_base."'
      );"
    ;
    //$bitacora = "INSERT INTO bitacora (id_evento, id_usuario, fecha, hora, datos, ip) values ('9', '".$_SESSION['id_usuario']."', '".date('Y-m-d')."', '".date('H:i:s')."', 'Se agregó el empleado: ".$nombres." ".$app." ".$apm."', '".$_SERVER['REMOTE_ADDR']."');" ;
    $res = mysqli_query($conexion,$consulta);
  }
  if (!$res) {
    $error = true;
  }else {
    //mysqli_query($conexion,$bitacora);
  }
  $datos[] = array('error' =>$error,'consulta' =>$consulta);
  echo json_encode($datos);
?>
