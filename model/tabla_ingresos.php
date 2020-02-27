<?php
  require '../includes/main.php';
  $datos=
    "<thead>
      <tr>
        <th>No. Factura</th>
        <th>Cliente</th>
        <th>Fecha</th>
        <th>Importe</th>
        <th>IVA</th>
        <th>Total</th>
        <th>Estado</th>
        <th>Opciones</th>
      </tr>
    </thead>
    <tbody>"
  ;
  $consulta =
    "SELECT
      finanzas_ingresos.id_finanzas_ingresos,
      cat_clientes.nombre as cliente,
      finanzas_ingresos.evento,
      finanzas_ingresos.no_factura,
      finanzas_ingresos.fecha,
      finanzas_ingresos.importe,
      finanzas_ingresos.iva,
      finanzas_ingresos.total,
      cat_estado_ingresos.nombre as estado,
      IF (
        1 = finanzas_ingresos.id_estado_ingresos,
        CONCAT('<a class=\"fa-stack fa-lg\" href=\"fin02_ingresos_edicion.php?id_finanzas_ingresos=',id_finanzas_ingresos,'\"><i class=\"fa fa-edit \"></i></a>'),
        CONCAT('<a class=\"fa-stack fa-lg\" href=\"fin02_ingresos_edicion.php?id_finanzas_ingresos=',id_finanzas_ingresos,'&v=1\"><i class=\"fa fa-eye \"></i></a>')
      ) AS opciones
    FROM
      finanzas_ingresos
    INNER JOIN
      cat_clientes ON cat_clientes.id = finanzas_ingresos.id_cliente
    INNER JOIN
      cat_estado_ingresos ON cat_estado_ingresos.id = finanzas_ingresos.id_estado_ingresos
    where 1"
  ;
  $query=mysqli_query($conexion,$consulta) or die(mysql_error());
  while($row= mysqli_fetch_assoc($query)){
    $datos.=
      "<tr>
        <td>".$row['no_factura']."</td>
        <td>".$row['cliente']."</td>
        <td>".$row['fecha']."</td>
        <td>".$row['importe']."</td>
        <td>".$row['iva']."</td>
        <td>".number_format($row['total'], 2, '.', ',')."</td>
        <td>".$row['estado']."</td>
        <td class='center'>".$row['opciones']."</td>
      </tr>"
    ;
  }
  $datos.="</tbody>";
  echo $datos;
?>
