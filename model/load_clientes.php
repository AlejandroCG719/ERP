<?php
  require '../includes/main.php';
  $consulta =
    "SELECT
    	a.id,
    	a.nombre,
      a.valor,
      a.caracteristica,
      a.fecha,
      a.telefono,
      a.cp,
      a.dir,
      a.estado
    from
    	cat_clientes as a
    ;"
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
      'telefono' =>$row["telefono"],
      'cp' =>$row["cp"],
      'dir' =>$row["dir"],
      'estado' =>$row["estado"]
    );
  }
  echo json_encode($datos);
?>
