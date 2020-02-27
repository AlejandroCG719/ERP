<?php
  require '../includes/main.php';
  $datos=
    "<thead>
      <tr>
        <th>Nombre</th>
        <th>CURP</th>
        <th>Promocion</th>
        <th>Localidad</th>
        <th>Puesto</th>
        <th>Fecha  baja</th>
        <th>Razon</th>
      </tr>
    </thead>
    <tbody>"
  ;
  $consulta =
    "SELECT
      a.nombre_empleado,
      a.curp,
      a.promocion,
      a.localidad,
      a.puesto,
      a.fecha_baja,
      a.tipo_baja      
    FROM
      boletinados a 
    WHERE
      1
    ORDER BY
      a.nombre_empleado DESC
    ;"
  ;
  $query=mysqli_query($conexion,$consulta) or die(mysql_error());
  while($row= mysqli_fetch_assoc($query)){
    $datos.=
      "<tr>
        <td>".$row['nombre_empleado']."</td>
        <td>".$row['curp']."</td>
        <td>".$row['promocion']."</td>
        <td>".$row['localidad']."</td>
        <td>".$row['puesto']."</td>
        <td>".$row['fecha_baja']."</td>
        <td>".$row['tipo_baja']."</td>
      </tr>"
    ;
  }
  $datos.="</tbody>";
  echo $datos;
?>
