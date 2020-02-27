<?php
  require '../includes/main.php';
  $datos=
    "<thead>
      <tr>
        <th>Id</th>
        <th>Nombre</th>
        <th>Icono</th>
        <th>Descripción</th>
        <th>Orden</th>
        <th>Editar</th>
      </tr>
    </thead>
    <tbody>"
  ;
  $consulta =
    "SELECT
      a.id_supermodulo,
      a.nombre,
      a.imagen,
      a.descripcion,
      a.imagen,
      a.orden
    FROM
      supermodulos a
    WHERE
      1
    ;"
  ;
  $query=mysqli_query($conexion,$consulta) or die(mysql_error());
  while($row= mysqli_fetch_assoc($query)){
    $datos.=
      "<tr>
        <td>".$row['id_supermodulo']."</td>
        <td>".$row['nombre']."</td>
        <td>".$row['imagen']."</td>
        <td>".$row['descripcion']."</td>
        <td>".$row['orden']."</td>
        <td class='center'>
          <a class='fa-stack fa-lg' href='cnfg04_supermodulos_edicion.php?id_supermodulo=".$row['id_supermodulo']."' >
            <i class='fa fa-edit'></i>
          </a>
        </td>
      </tr>"
    ;
  }
  $datos.="</tbody>";
  echo $datos;
?>
