<?php
  require '../includes/main.php';
  foreach ($_REQUEST as $key => $value) {
    $$key = strip_tags($_REQUEST[$key]);
  }
  $consulta =
    "SELECT
    	id_pago_solicitud
    from
    	finanzas_pago_solicitud
    ORDER BY
      id_pago_solicitud DESC"
  ;
  $query=mysqli_query($conexion,$consulta) or die(mysql_error());
  $datos='';
  $datos = [];
  while($row= mysqli_fetch_assoc($query)){
    $datos[] = array('id_pago_solicitud' =>$row["id_pago_solicitud"],"consulta" =>$consulta);
  }
  echo json_encode($datos);
?>
