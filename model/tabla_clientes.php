<?php
  require '../includes/main.php';
  $datos=
    "<thead>
      <tr>
        <th>Id</th>
        <th>Cliente</th>
        <th>RFC</th>
        <th>Teléfono</th>
        <th>Dirección</th>
        <th>C.P.</th>
        <th>Fecha Alta</th>
        <th>Estatus</th>
        <th>Opciones</th>
      </tr>
    </thead>
    <tbody>"
  ;
  $consulta =
    "SELECT
      a.id,
      a.nombre,
      a.valor,
      a.fecha,
      a.telefono,
      a.cp,
      a.dir,
      IF (
        1 = a.estado,'Activo','Inactivo'
      )as estado
    FROM
      cat_clientes a
    where 1 "
  ;
  $query=mysqli_query($conexion,$consulta) or die(mysql_error());
  while($row= mysqli_fetch_assoc($query)){
    $datos.=
      "<tr>
        <td>".$row['id']."</td>
        <td>".$row['nombre']."</td>
        <td>".$row['valor']."</td>
        <td>".$row['telefono']."</td>
        <td>".$row['dir']."</td>
        <td>".$row['cp']."</td>
        <td>".$row['fecha']."</td>
        <td>".$row['estado']."</td>
        <td class='center'>
          <a class='fa-stack fa-lg' href='clpr02_clientes_edicion.php?id=".$row['id']."' >
            <i class='fa fa-edit'></i>
          </a>
        </td>
      </tr>"
    ;
  }
  $datos.="</tbody>";
  echo $datos;
?>
