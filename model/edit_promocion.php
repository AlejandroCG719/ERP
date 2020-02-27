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
  $consulta = "UPDATE cat_promociones
  SET nombre='".$nombre."',
   valor='".$valor."',
    fecha='".$fecha."',
    id_cliente='".$id_cliente."',
    carga_social='".$carga_social."',
    com_ag_per='".$com_ag_per."',
    com_ag_mat='".$com_ag_mat."',
    com_ag_otros = '".$com_ag_otros."',
    com_ag_degu = '".$com_ag_degu."',
    com_ag_eventos_especiales = '".$com_ag_eventos_especiales."',
    estado ='".$estado."' ,
    carga_social_incentivos =  '".$carga_social_incentivos."',
    carga_social_pl =  '".$carga_social_pl."',
    com_ag_incentivo =  '".$com_ag_incentivo."',
    com_ag_pl =  '".$com_ag_pl."'
    WHERE id= '".$id."'; ";
  //$bitacora = "INSERT INTO bitacora (id_evento, id_usuario, fecha, hora, datos, ip) values ('10', '".$_SESSION['id_usuario']."', '".date('Y-m-d')."', '".date('H:i:s')."', 'Se modificó el empleado: ".$nombres." ".$app." ".$apm." con el id: ".$id_empleado."', '".$_SERVER['REMOTE_ADDR']."');" ;
} else {
  $consulta =
    "INSERT INTO cat_promociones(nombre,valor,fecha,id_cliente,carga_social,com_ag_per,com_ag_mat,com_ag_otros, com_ag_degu,com_ag_eventos_especiales,estado, carga_social_incentivos, carga_social_pl, com_ag_incentivos, com_ag_pl) VALUES('".$_POST['nombre']."', '".$_POST['valor']."', '".$_POST['fecha']."', '".$_POST['id_cliente']."', '".$_POST['carga_social']."', '".$com_ag_per."', '".$com_ag_mat."', '".$com_ag_otros."', '".$com_ag_degu."', '".$com_ag_eventos_especiales."', '".$estado."', '".$carga_social_incentivos."', '".$carga_social_pl."', '".$com_ag_incentivos."', '".$com_ag_pl."');";
    $bitacora = "INSERT INTO bitacora (id_evento, id_usuario, fecha, hora, datos, ip) values ('9', '".$_SESSION['id_usuario']."', '".date('Y-m-d')."', '".date('H:i:s')."', 'Se agregó el empleado: ".$nombres." ".$app." ".$apm."', '".$_SERVER['REMOTE_ADDR']."');" ;
}
$res = mysqli_query($conexion,$consulta);
if (!$res) {
  $error = true;

}else {
  //mysqli_query($conexion,$bitacora);
}
$datos[] = array('error' =>$error,'consuta'=>$consulta);
echo json_encode($datos);
?>
