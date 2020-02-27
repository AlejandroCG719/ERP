<?php
  require '../includes/main.php';
  foreach ($_POST as $key => $value) {
    $$key = $value;
  }
  $consulta =
    "SELECT
    	a.id,
    	a.nombre,
      a.valor,
      a.caracteristica,
      a.fecha,
      a.estado
    from
    	".$tabla." as a
    WHERE
      a.estado = 1
    "
  ;
  if (isset($_POST['id'])) {
    $consulta .= " AND a.id = ".$id;
  }

  $query=mysqli_query($conexion,$consulta) or die(mysql_error());
  $datos='';
  $datos = [];
  while($row= mysqli_fetch_assoc($query)){
    $datos[] = array('id' =>$row["id"], 'nombre' =>$row["nombre"], 'valor' =>$row["valor"], 'caracteristica' =>$row["caracteristica"], 'fecha' =>$row["fecha"], 'estado' =>$row["estado"]);
  }
  echo json_encode($datos);
?>
