<?php
  require '../includes/main.php';
  foreach ($_POST as $key => $value) {
    $$key = $value;
  }
  $consulta =
    "SELECT
    a.id_finanzas_pagos_transacciones,
    a.id_pago_solicitud,
    a.id_banco,
    b.nombre banco,
    a.id_cuenta_banco,
    c.nombre cuenta,
    a.monto,
    a.id_forma_pago,
    d.nombre forma_pago
    FROM
        finanzas_pagos_transacciones a
        INNER JOIN cat_bancos b ON a.id_banco = b.id
        INNER JOIN cat_banco_cuentas c ON a.id_cuenta_banco = c.id
        INNER JOIN cat_fin_forma_pago d ON a.id_forma_pago = d.id
    WHERE
        id_pago_solicitud = ".$id
  ;
  $query=mysqli_query($conexion,$consulta) or die(mysql_error());
  $datos='';
  $datos = [];
  while($row= mysqli_fetch_assoc($query)){
    $datos[] = array('id_banco' =>$row["id_banco"], 'banco' =>$row["banco"], 'id_cuenta_banco' =>$row["id_cuenta_banco"], 'cuenta' =>$row["cuenta"], 'monto' =>$row["monto"], 'id_forma_pago' =>$row["id_forma_pago"], 'forma_pago' =>$row["forma_pago"]);
  }
  echo json_encode($datos);
?>
