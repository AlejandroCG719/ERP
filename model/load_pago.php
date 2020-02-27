<?php
  require '../includes/main.php';
  foreach ($_REQUEST as $key => $value) {
    $$key = strip_tags($_REQUEST[$key]);
  }
  $consulta =
    "SELECT
    	id_finanzas_pago
    from
    	finanzas_pagos
    ORDER BY
      id_finanzas_pago DESC
    Limit 1"
  ;
  $query=mysqli_query($conexion,$consulta) or die(mysql_error());
  $datos='';
  $datos = [];
  while($row= mysqli_fetch_assoc($query)){
    $datos[] = array('id_pago' =>$row["id_finanzas_pago"],"consulta" =>$consulta);
  }
  echo json_encode($datos);
?>
