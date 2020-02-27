<?php
  require '../includes/main.php';
  $datos=
    "<thead>
      <tr>
        <th>Id</th>
        <th>Evento</th>
        <th>Usuario</th>
        <th>Fecha</th>
        <th>Hora</th>
        <th>Datos</th>
        <th>IP</th>
      </tr>
    </thead>
    <tbody>"
  ;
  $consulta =
    "SELECT
      a.id,
      a.id_evento,
      a.id_usuario,
      DATE_FORMAT(a.fecha, '%d/%m/%Y') fecha,
      a.hora,
      a.datos,
      a.ip,
      b.nombre evento,
      c.usuario,
      d.nombres,
      d.app,
      d.apm
    FROM
      bitacora a
      INNER JOIN cat_eventos b ON a.id_evento = b.id
      INNER JOIN usuarios c ON a.id_usuario = c.id_usuario
      INNER JOIN empleados d ON c.id_empleado = d.id_empleado
    WHERE
      1 ORDER BY a.id ASC 
    ;"
  ;
  var_dump($consulta);
  $query=mysqli_query($conexion,$consulta) or die(mysql_error());
  while($row= mysqli_fetch_assoc($query)){
    $datos.=
      "<tr>
        <td>".$row['id']."</td>
        <td>".$row['evento']."</td>
        <td>".$row['usuario']."</td>
        <td>".$row['fecha']."</td>
        <td>".$row['hora']."</td>
        <td>".$row['datos']."</td>
        <td>".$row['ip']."</td>
      </tr>"
    ;
  }
  $datos.="</tbody>";
  echo $datos;
?>
