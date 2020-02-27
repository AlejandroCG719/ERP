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
        <th>Activar</th>
      </tr>
    </thead>
    <tbody>"
  ;
  $consulta =
    "SELECT
      id_modulo,
      id_supermodulo,
      liga,
      nombre,
      prefijo,
      orden,
      descripcion,
      imagen
    FROM
      modulos
    GROUP BY
      modulos.id_modulo
    ;"
  ;
  var_dump($_POST);
  $query=mysqli_query($conexion,$consulta) or die(mysql_error());
  while($row= mysqli_fetch_assoc($query)){
    $checked="";
    $datos.=
      "<tr>
        <td>".$row['id_modulo']."</td>
        <td>".$row['nombre']."</td>
        <td>".$row['prefijo']."</td>
        <td>".$row['imagen']."</td>
        <td>".$row['liga']."</td>
        <td>".$row['orden']."</td>
        <td class='center'>
        ";
          $consulta=
            "SELECT
            	*
            FROM
             modulo_has_perfiles
            WHERE
             id_perfil=".$_POST['id']." AND id_modulo=".$row['id_modulo'].
            ";"
          ;
          $subquery=mysqli_query($conexion,$consulta) or die(mysql_error());
          while($rowsub= mysqli_fetch_assoc($subquery)){
            $checked = "checked";
          }
          $prefijo= '"'.$row['prefijo'].'"';
        $datos.="
          <input type='checkbox' id='".$row['prefijo']."' name='permisos[]' value='".$row['id_modulo']."' class='form-control' ".$checked." onclick='addAccess(".$_POST['id'].", ".$row['id_modulo'].", ".$prefijo.")'>
        </td>
      </tr>"
    ;
  }
  $datos.="</tbody>";
  echo $datos;
?>
