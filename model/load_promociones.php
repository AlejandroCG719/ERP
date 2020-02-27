<?php
  require '../includes/main.php';
  foreach ($_REQUEST as $key => $value) {
    $$key = strip_tags($_REQUEST[$key]);
  }
  if (isset($_POST['last_id'])) {
    $consulta =
      'SELECT
        id_cat_promocion
      FROM
        cat_promociones
      ORDER BY
        id_cat_promocion DESC
      Limit 1'
    ;
    $query=mysqli_query($conexion,$consulta) or die(mysql_error());
    $datos='';
    $datos = [];
    while($row= mysqli_fetch_assoc($query)){
      $datos[] = array(
        'id' =>$row["id_cat_promocion"]
      );
    }
    echo json_encode($datos);
  }else {
    $consulta =
      "SELECT
      	a.id,
      	a.nombre,
        a.valor,
        a.caracteristica,
        a.fecha,
        a.id_cliente,
        a.carga_social,
        a.com_ag_per,
        a.com_ag_mat,
        a.estado
      from
      	cat_promociones as a
      WHERE
        estado = 1";
      if (isset($_POST['id'])) {
        $consulta .= " AND id_cliente = ".$id;
      }
    ;
    $query=mysqli_query($conexion,$consulta) or die(mysql_error());
    $datos='';
    $datos = [];
    while($row= mysqli_fetch_assoc($query)){
      $datos[] = array(
        'id' =>$row["id"],
        'nombre' =>$row["nombre"],
        'valor' =>$row["valor"],
        'caracteristica' =>$row["caracteristica"],
        'fecha' =>$row["fecha"],
        'id_cliente' =>$row["id_cliente"],
        'carga_social' =>$row["carga_social"],
        'comision_ag_per' =>$row["comision_ag_per"],
        'comision_ag_mat' =>$row["comision_ag_mat"],
        'estado' =>$row["estado"]
      );
    }
    echo json_encode($datos);
  }
?>
