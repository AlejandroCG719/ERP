<?php
  require '../includes/main.php';
  $datos=
    "<thead>
      <tr>
        <th>Num. Promoción</th>
        <th>Promoción</th>
        <th>Cliente</th>
        <th>Fecha Alta</th>
        <th>Estado</th>
        <th>Opciones</th>
      </tr>
    </thead>
    <tbody>"
  ;
  $consulta =
    "SELECT
      a.id,
      a.nombre as promo,
      a.valor,
      DATE_FORMAT(a.fecha, '%d/%m/%Y') fecha,
      b.nombre as cliente,
      IF (
        1 = a.estado,'Activo','Inactivo'
      )as estado
    FROM
      cat_promociones a inner join cat_clientes b on a.id_cliente = b.id
    where 1 "
  ;
  $query=mysqli_query($conexion,$consulta) or die(mysql_error());
  while($row= mysqli_fetch_assoc($query)){
    $datos.=
      "<tr>
        <td>".$row['id']."</td>
        <td>".$row['promo']."</td>
        <td>".$row['cliente']." ".$row['app']." ".$row['apm']."</td>
        <td>".$row['fecha']."</td>
        <td>".$row['estado']."</td>
        <td class='center'>
          <a class='fa-stack fa-lg' href='clpr01_promociones_edicion.php?id=".$row['id']."' >
            <i class='fa fa-edit'></i>
          </a>
        </td>
      </tr>"
    ;
  }
  $datos.="</tbody>";
  echo $datos;
?>
