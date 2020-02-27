<?php
  require '../includes/main.php';
  foreach ($_POST as $key => $value) {
    $$key = $value;
  }
  $consulta =
    "SELECT
    a.id,
    b.nombre personal,
    a.id_promocion,
    c.nombre promo,
    a.caracteristica,
    a.carga_social,
    a.sueldo_base,
    a.estado
    FROM
        cat_personal_promocion a
    INNER JOIN cat_cot_personal b ON
        a.id_personal = b.id
    INNER JOIN cat_promociones c ON
        a.id_promocion = c.id
    WHERE 1"
  ;
  if (isset($_POST['id_promocion'])) {
    $consulta.=" AND a.id_promocion = ".$id_promocion;
  }elseif (isset($_POST['id'])) {
    $consulta .= " AND a.id = ".$id;
  }
  $query=mysqli_query($conexion,$consulta) or die(mysql_error());
  $datos='';
  $datos = [];
  while($row= mysqli_fetch_assoc($query)){
    $datos[] = array('id' =>$row["id"], 'personal' =>$row["personal"], 'id_promocion' =>$row["id_promocion"], 'promo' =>$row["promo"], 'caracteristica' =>$row["caracteristica"], 'carga_social' =>$row["carga_social"], 'sueldo_base' =>$row["sueldo_base"],'estado' =>$row["estado"]);
  }
  echo json_encode($datos);
?>
