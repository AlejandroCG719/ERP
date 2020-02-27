<?php
  require '../includes/main.php';
  $datos=
    "<thead>
      <tr>
        <th>Id</th>
        <th>Usuario</th>
        <th>Perfil</th>
        <th>Empleado</th>
        <th>Estado</th>
        <th>Editar</th>
      </tr>
    </thead>
    <tbody>"
  ;
  $consulta =
    "SELECT
      a.id_usuario,
      a.usuario,
      IF (
        a.estado = 1, 'Activo', 'Inactivo'
      ) AS estado,
      b.nombre perfil,
      c.nombres,
      c.app,
      c.apm
    FROM
      usuarios a
      INNER JOIN cat_perfiles b ON a.id_perfil = b.id
      INNER JOIN empleados c ON a.id_empleado = c.id_empleado
    WHERE
      1
    ;"
  ;
  $query=mysqli_query($conexion,$consulta) or die(mysql_error());
  while($row= mysqli_fetch_assoc($query)){
    $datos.=
      "<tr>
        <td>".$row['id_usuario']."</td>
        <td>".$row['usuario']."</td>
        <td>".$row['perfil']."</td>
        <td>".$row['nombres']." ".$row['app']." ".$row['apm']."</td>
        <td>".$row['estado']."</td>
        <td class='center'>
          <a class='fa-stack fa-lg' href='cnfg01_usuarios_edicion.php?id_usuario=".$row['id_usuario']."' >
            <i class='fa fa-edit'></i>
          </a>
        </td>
      </tr>"
    ;
  }
  $datos.="</tbody>";
  echo $datos;
?>
