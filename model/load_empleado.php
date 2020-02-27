<?php
  require '../includes/main.php';
  $consulta =
    "SELECT
    	a.id_empleado,
    	a.nombres,
      a.app,
      a.apm,
      a.tel,
      a.dir,
      a.curp,
      a.nss,
      a.rfc,
      a.fecha_nac,
      a.fecha_alta,
      a.fecha_baja,
      a.estado,
      a.id_puesto,
      b.nombre puesto
    from
    	empleados a
      INNER JOIN cat_puestos b ON a.id_puesto = b.id
    WHERE
      a.estado = 1
    ;"
  ;
  $query=mysqli_query($conexion,$consulta) or die(mysql_error());
  $datos='';
  $datos = [];
  while($row= mysqli_fetch_assoc($query)){
    $datos[] = array(
      'id' =>$row["id_empleado"],
      'nombre' =>$row["nombres"]." ".$row["app"]." ".$row["apm"],
      'tel' =>$row["tel"],
      'dir' =>$row["dir"],
      'curp' =>$row["curp"],
      'nss' =>$row["nss"],
      'rfc' =>$row["rfc"],
      'fecha_nac' =>$row["fecha_nac"],
      'fecha_alta' =>$row["fecha_alta"],
      'fecha_baja' =>$row["fecha_baja"],
      'estado' =>$row["estado"],
      'id_puesto' =>$row["id_puesto"],
      'puesto' =>$row["puesto"]
    );
  }
  echo json_encode($datos);
?>
