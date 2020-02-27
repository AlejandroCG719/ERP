<?php
  require '../includes/main.php';
  $datos=
    "<thead>
      <tr>
        <th>Id</th>
        <th>Nombre Personal</th>
        <th>Promoción</th>
        <th>Carga Social</th>
        <th>Estado</th>
        <th>Opción</th>
      </tr>
    </thead>
    <tbody>"
  ;
  $consulta =
    "SELECT
      a.id,
      a.carga_social,
      b.nombre as nombrePersonal,
      c.nombre as nombrePromocion,
      IF (
        a.estado = 1, 'Activo', 'Inactivo'
      ) AS estado
    FROM
      cat_personal_promocion a
      INNER JOIN cat_cot_personal b ON a.id_personal = b.id
      INNER JOIN cat_promociones c ON a.id_promocion = c.id
    WHERE
      1
    ;"
  ;
  $query=mysqli_query($conexion,$consulta) or die(mysql_error());
  while($row= mysqli_fetch_assoc($query)){
    $datos.=
      "<tr>
        <td>".$row['id']."</td>
        <td>".$row['nombrePersonal']."</td>
        <td>".$row['nombrePromocion']."</td>
        <td>".$row['carga_social']."</td>
        <td>".$row['estado']."</td>
        <td class='center'>
          <a class='fa-stack fa-lg' href='sysadm01_per_prom_edicion.php?id=".$row['id']."' >
            <i class='fa fa-edit'></i>
          </a>
        </td>
      </tr>"
    ;
  }
  $datos.="</tbody>";
  echo $datos;
?>
