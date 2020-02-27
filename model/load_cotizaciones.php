<?php
  require '../includes/main.php';
  foreach ($_POST as $key => $value) {
    $$key = $value;
  }
  if (isset($_POST['last_id'])) {
    $consulta =
      'SELECT
        id_cotizacion,
        no_presupuesto
      FROM
        cotizaciones
      ORDER BY
        id_cotizacion DESC
      Limit 1';
  }else {
    $consulta =
      'SELECT
        id_cotizacion,
        no_presupuesto
      FROM
        cotizaciones
      WHERE
        id_status = 4'
    ;
    if ($id_promo>0) {
      $consulta.=
        ' AND
          id_promocion='.$id_promo
      ;
    }
  }
  $query=mysqli_query($conexion,$consulta) or die(mysql_error());
  $datos='';
  $datos = [];
  while($row= mysqli_fetch_assoc($query)){
    $datos[] = array(
      'id_cotizacion' =>$row["id_cotizacion"],
      'no_presupuesto' =>$row["no_presupuesto"]
    );
  }
  echo json_encode($datos);
?>
