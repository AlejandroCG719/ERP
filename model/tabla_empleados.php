<?php
  require '../includes/main.php';
  $datos=
    "<thead>
      <tr>
        <th>Id</th>
        <th>Nombre</th>
        <th>Teléfono</th>
        <th>Dirección</th>
        <th>Curp</th>
        <th>RFC</th>
        <th>NSS</th>
        <th>Puesto</th>
        <th>Estado</th>
        <th>Editar</th>
      </tr>
    </thead>
    <tbody>"
  ;
  $consulta =
    "SELECT
      a.id_empleado,
      a.nombres,
      a.app,
      a.apm,
      a.tel,
      a.dir,
      a.curp,
      a.rfc,
      a.nss,
      a.fecha_nac,
      a.fecha_alta,
      a.fecha_baja,
      IF (
        a.estado = 1, 'Activo', 'Inactivo'
      ) AS estado,
      b.nombre puesto
    FROM
      empleados a
      INNER JOIN cat_puestos b ON a.id_puesto = b.id
    WHERE
      1
    ;"
  ;
  $query=mysqli_query($conexion,$consulta) or die(mysql_error());
  while($row= mysqli_fetch_assoc($query)){
    $datos.=
      "<tr>
        <td>".$row['id_empleado']."</td>
        <td>".$row['nombres']." ".$row['app']." ".$row['apm']."</td>
        <td>".$row['tel']."</td>
        <td>".$row['dir']."</td>
        <td>".$row['curp']."</td>
        <td>".$row['rfc']."</td>
        <td>".$row['nss']."</td>
        <td>".$row['puesto']."</td>
        <td>".$row['estado']."</td>
        <td class='center'>
          <a class='fa-stack fa-lg' href='rh01_empleados_edicion.php?id_empleado=".$row['id_empleado']."' >
            <i class='fa fa-edit'></i>
          </a>
        </td>
      </tr>"
    ;
  }
  $datos.="</tbody>";
  echo $datos;
?>
