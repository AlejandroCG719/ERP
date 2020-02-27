<?php
  require '../includes/main.php';
  $datos=
    "<thead>
      <tr>
        <th>Id</th>
        <th>Descripción</th>
        <th>Valor</th>
        <th>Característica</th>
        <th>Fecha Efectiva</th>
        <th>Estado</th>
        <th>Editar</th>
      </tr>
    </thead>
    <tbody>"
  ;
  $consulta =
    "SELECT
      a.id,
      a.nombre,
      a.valor,
      a.caracteristica,
      DATE_FORMAT(a.fecha, '%d/%m/%Y') fecha,
    	if (a.estado = 1, 'Activo', 'Inactivo') estado
    FROM
    	cat_perfiles a
    ;"
  ;
  $query=mysqli_query($conexion,$consulta) or die(mysql_error());
  while($row= mysqli_fetch_assoc($query)){
    $datos.=
      "<tr>
        <td>".$row['id']."</td>
        <td>".$row['nombre']."</td>
        <td>".$row['valor']."</td>
        <td>".$row['caracteristica']."</td>
        <td>".$row['fecha']."</td>
        <td>".$row['estado']."</td>
        <td class='center'>
          <a class='fa-stack fa-lg' href='cnfg02_perfil_accesos.php?id_perfil=".$row['id']."' >
            <i class='fa fa-edit'></i>
          </a>
        </td>
      </tr>"
    ;
  }
  $datos.="</tbody>";
  echo $datos;
?>
