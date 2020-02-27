<?php
  require '../includes/main.php';
  $datos=
    "<thead>
      <tr>
        <th>Id</th>
        <th>Nombre</th>
        <th>Prefijo</th>
        <th>Icono</th>
        <th>Liga</th>
        <th>Orden</th>
        <th>Super Módulo</th>
        <th>Editar</th>
      </tr>
    </thead>
    <tbody>"
  ;
  $consulta =
    "SELECT
      modulos.id_supermodulo,
      modulos.liga,
      modulos.nombre,
      modulos.prefijo,
      modulos.orden,
      modulos.descripcion,
      modulos.imagen,
      supermodulos.nombre supermod
    FROM
      modulos
      INNER JOIN supermodulos ON supermodulos.id_supermodulo = modulos.id_supermodulo
    WHERE
      1
    ;"
  ;
  var_dump($consulta);
  $query=mysqli_query($conexion,$consulta) or die(mysql_error());
  while($row= mysqli_fetch_assoc($query)){
    $datos.=
      "<tr>
        <td>".$row['id_supermodulo']."</td>
        <td>".$row['nombre']."</td>
        <td>".$row['prefijo']."</td>
        <td>".$row['imagen']."</td>
        <td>".$row['liga']."</td>
        <td>".$row['orden']."</td>
        <td>".$row['supermod']."</td>
        <td class='center'>
          <a class='fa-stack fa-lg' href='cnfg03_modulos_edicion.php?id_modulo=".$row['id_supermodulo']."' >
            <i class='fa fa-edit'></i>
          </a>
        </td>
      </tr>"
    ;
  }
  $datos.="</tbody>";
  echo $datos;
?>
