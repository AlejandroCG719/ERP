<?php
  require '../includes/main.php';
  $datos=
    "<thead>
      <tr>
        <th>Fecha Solicitud</th>
        <th>Folio</th>
        <th>Solicitante</th>
        <th>Cuenta</th>
        <th>Monto</th>
        <th>Beneficiario</th>
        <th>Promoción</th>
        <th>Concepto</th>
        <th>Plaza</th>
        <th>Opciones</th>
      </tr>
    </thead>
    <tbody>"
  ;
  $consulta =
    "SELECT
      a.id_pago_solicitud,
      a.fecha,
      a.folio,
      a.solicitante,
      a.cuenta_deposito,
      a.monto,
      a.beneficiario,
      a.id_promocion,
      a.concepto,
      a.plaza,
      b.nombre promo
    FROM
      finanzas_pago_solicitud a
    INNER JOIN cat_promociones b ON
      a.id_promocion = b.id
    WHERE
      1 "
  ;
  $query=mysqli_query($conexion,$consulta) or die(mysql_error());
  while($row= mysqli_fetch_assoc($query)){
    $datos.=
      "<tr>
        <td>".$row['fecha']."</td>
        <td>".$row['folio']."</td>
        <td>".$row['solicitante']."</td>
        <td>".$row['cuenta_deposito']."</td>
        <td>".$row['monto']."</td>
        <td>".$row['beneficiario']."</td>
        <td>".$row['promo']."</td>
        <td>".$row['concepto']."</td>
        <td>".$row['plaza']."</td>
        <td class='center'>
          <a class='fa-stack fa-lg' href='fin01_pagos_edicion.php?id=".$row['id_pago_solicitud']."' >
            <i class='fa fa-edit'></i>
          </a>
        </td>
      </tr>"
    ;
  }
  $datos.="</tbody>";
  echo $datos;
?>
