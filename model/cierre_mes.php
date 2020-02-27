<?php
require '../includes/main.php';
$fecha = date("Y-m");
$consulta = "SELECT * FROM fin_cierres_mes WHERE fin_cierres_mes.fecha LIKE '".$fecha."%'";
$res = $query=mysqli_query($conexion,$consulta);
$num_rows = mysqli_num_rows($res);
if ($num_rows == 0) {
  $existe= "false";
  $consulta = "SELECT id_cierre_mes, DATE_FORMAT(fecha , '%Y-%m') fecha, saldo FROM `fin_cierres_mes` WHERE 1 ORDER BY fecha DESC LIMIT 1";
  $query=mysqli_query($conexion,$consulta) or die(mysql_error());
  while($row= mysqli_fetch_assoc($query)){
    $fecha = $row["fecha"];
    $saldo = $row["saldo"];
  }
  $consulta = "SELECT * FROM `finanzas_ingresos` WHERE id_estado_ingresos = 3 AND fecha like '".$fecha."%'";
  $query=mysqli_query($conexion,$consulta) or die(mysql_error());
  $tot_ingresos = 0;
  while($row= mysqli_fetch_assoc($query)){
    $tot_ingresos += $row["total"];
  }
  $consulta = "SELECT a.status, b.fecha_deposito, a.monto FROM finanzas_pago_solicitud a INNER JOIN finanzas_pagos b on a.id_pago_solicitud = b.id_pago_solicitud WHERE a.status = 3 AND fecha_deposito LIKE '".$fecha."%'";
  $query=mysqli_query($conexion,$consulta) or die(mysql_error());
  $tot_egresos = 0;
  while($row= mysqli_fetch_assoc($query)){
    $tot_egresos += $row["monto"];
  }
  $saldo += $tot_ingresos - $tot_egresos;
  $consulta = "INSERT INTO fin_cierres_mes (fecha, saldo) values ('".date("Y-m-d")."', '".$saldo."') ;";
  $query=mysqli_query($conexion,$consulta) or die(mysql_error());
}else {
  $existe= "true";
}
?>
