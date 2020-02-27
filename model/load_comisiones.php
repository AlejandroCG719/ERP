<?php
  require '../includes/main.php';
  foreach ($_POST as $key => $value) {
    $$key = $value;
  }
  $consulta =
    "SELECT
      carga_social,
      com_ag_per,
      com_ag_mat,
      com_ag_otros,
      com_ag_degu,
      com_ag_eventos_especiales,
      com_ag_incentivos,
      carga_social_incentivos,
      carga_social_pl
    FROM
      cat_promociones
    WHERE
      estado = 1
    AND
      id=".$id."
    ;"
  ;
  $query=mysqli_query($conexion,$consulta) or die(mysql_error());
  $datos='';
  $datos = [];
  while($row= mysqli_fetch_assoc($query)){
    $datos[] = array(
      'carga_social' =>$row["carga_social"],
      'com_ag_per' =>$row["com_ag_per"],
      'com_ag_mat' =>$row["com_ag_mat"],
      'com_ag_otros' =>$row["com_ag_otros"],
      'com_ag_degu' =>$row["com_ag_degu"],
      'com_ag_eventos_especiales' =>$row["com_ag_eventos_especiales"],
      'com_ag_incentivo' =>$row["com_ag_incentivo"],
      'carga_social_incentivos' =>$row["carga_social_incentivos"],
      'carga_social_pl' =>$row["carga_social_pl"],
    );
  }
  echo json_encode($datos);
?>
