<?php
  require '../includes/main.php';
  $consulta =
    "SELECT
    	a.id_supermodulo,
    	a.nombre,
      a.imagen,
      a.descripcion,
      a.orden
    from
    	supermodulos as a
    ;"
  ;
  var_dump($_POST);
  $query=mysqli_query($conexion,$consulta) or die(mysql_error());
  $datos='';
  $datos = [];
  while($row= mysqli_fetch_assoc($query)){
    $datos[] = array('id_supermodulo' =>$row["id_supermodulo"], 'nombre' =>$row["nombre"], 'imagen' =>$row["imagen"], 'descripcion' =>$row["descripcion"], 'orden' =>$row["orden"]);
  }
  echo json_encode($datos);
?>
