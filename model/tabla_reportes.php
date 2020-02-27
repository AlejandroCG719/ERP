<?php
  require '../includes/main.php';
  $datos=
    "<thead>
      <tr>
        <th>Ingresos</th>
        <th>Egresos</th>
        <th>Cuentas Por Cobrar</th>
        <th>Cuentas Por Pagar</th>
        <th>General</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><a target=\"_blank\" class=\"fa-stack fa-lg\" href=\"reporte_fin_ingresos.php\"><i class=\"fa fa-file-text-o \"></i></a></td>
        <td><a target=\"_blank\" class=\"fa-stack fa-lg\" href=\"reporte_fin_gastos.php\"><i class=\"fa fa-file-text-o \"></i></a></td>
        <td><a target=\"_blank\" class=\"fa-stack fa-lg\" href=\"reporte_cuentas_por_cobrar.php\"><i class=\"fa fa-file-text-o \"></i></a></td>
        <td><a target=\"_blank\" class=\"fa-stack fa-lg\" href=\"reporte_cuentas_por_pagar.php\"><i class=\"fa fa-file-text-o \"></i></a></td>
        <td><a target=\"_blank\" class=\"fa-stack fa-lg\" href=\"reporte_fin_general.php\"><i class=\"fa fa-file-text-o \"></i></a></td>
      </tr>
    </tbody>";
  echo $datos;
?>
