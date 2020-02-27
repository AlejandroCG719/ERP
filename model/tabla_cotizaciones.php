<?php
  require '../includes/main.php';
  $datos=
    "<thead>
      <tr>
        <th>Id cot</th>
        <th>No. Presupuesto</th>
        <th>Cliente</th>
        <th>Promoción</th>
        <th>Periodo</th>
        <th>Total Sin Iva</th>
        <th>Estado</th>
        <th>Opciones</th>
      </tr>
    </thead>
    <tbody>"
  ;
  $consulta =
    "SELECT
      a.id_cotizacion,
      a.fecha,
      DATE_FORMAT(a.fecha_inicio, '%d/%m/%Y') fecha_inicio,
      DATE_FORMAT(a.fecha_fin, '%d/%m/%Y') fecha_fin,
      a.no_presupuesto,
      a.id_cliente,
      b.nombre as cliente,
      a.id_promocion,
      e.nombre as promocion,
      a.plaza,
      a.id_status,
      c.nombre as status,
      a.com_ag_eventos_especiales,
      a.dias_capacitacion,
      a.comision_ag_mat,
      a.comision_ag_otros,
      a.comision_ag_degustaciones,
      a.dias_tot_degustaciones,
      a.id_usuario,
      d.nombres,
      d.app,
      d.apm,
      a.id_usuario_2,
      CONCAT('<a href=\"reporte_cotizacion.php?id_cotizacion=',id_cotizacion,'\" target=\"_blank\" class=\"fa-stack fa-lg\"><i class=\"fa fa-file-text-o \"></i></a>') opciones
    FROM
      cotizaciones a
      INNER JOIN cat_clientes b ON b.id = a.id_cliente
      INNER JOIN cat_estado_cotizacion c ON c.id = a.id_status
      INNER JOIN usuarios ON usuarios.id_usuario = a.id_usuario
      INNER JOIN empleados d ON d.id_empleado = usuarios.id_empleado
      INNER JOIN cat_promociones e ON a.id_promocion = e.id
    WHERE
      1;"
  ;
  $query=mysqli_query($conexion,$consulta) or die(mysql_error());
  while($row= mysqli_fetch_assoc($query)){
    $tot_personal = 0;
    $comision_personal = $row["comision_ag_eventos_especiales"]/100; // comision de agencia del personal
    $cs = $row["carga_social"]/100; //carga social
    /*if ($row['desglozado'] == 0) {
      $subconsulta ='SELECT a.sueldo_base, a.cantidad, a.dias_laborados FROM cotizacion_personal a WHERE a.id_cotizacion = '.$row["id_cotizacion"].';';
      $subquery=mysqli_query($conexion,$subconsulta);
      while($rowSubquery= mysqli_fetch_assoc($subquery)){
        // salario normal
        $sb = $rowSubquery["sueldo_base"]; //sueldo base
        $cant = $rowSubquery["cantidad"];
        $dl = $rowSubquery["dias_laborados"];
        $tot_personal += (($sb*$cs+$sb)*$cant*$dl)*($comision_personal+1);
      }
    }else {*/
      $subconsulta ='SELECT a.sueldo_base, a.cantidad, a.dias_laborados, b.porcentaje_puntualidad, b.porcentaje_asistencia, b.porcentaje_despensa, b.salario_minimo FROM cotizacion_personal a INNER JOIN cotizacion_prestaciones_integrales b ON a.id_cotizacion = b.id_cotizacion WHERE a.id_posicion = b.id_posicion AND a.id_cotizacion = '.$row["id_cotizacion"].';';
      $subquery=mysqli_query($conexion,$subconsulta);
      while($rowSubquery= mysqli_fetch_assoc($subquery)){
        // salario desglozado
        $sb = $rowSubquery["sueldo_base"]; //sueldo base
        $pa = $rowSubquery["porcentaje_asistencia"]/100; //porcentaje asistencia
        $pp = $rowSubquery["porcentaje_puntualidad"]/100; //porcentaje puntualidad
        $pd = $rowSubquery["porcentaje_despensa"]/100;
        $sm = $rowSubquery["salario_minimo"];
        $cant = $rowSubquery["cantidad"];
        $dl = $rowSubquery["dias_laborados"];
        $tot_personal += (((($sb*$cs)+($sb*$pa)+($sb*$pp)+$sb)+($pd*$sm))*$cant*$dl)*($comision_personal+1);
      }
    /*}*/
    //subconsulta dominical
    $subconsulta = 'SELECT a.id_prima_dominical, a.id_cotizacion, a.id_posicion, a.sueldo_base, a.dias_laborados, b.cantidad FROM cotizacion_prima_dominical a INNER JOIN cotizacion_personal b ON b.id_posicion = a.id_posicion WHERE a.id_cotizacion = b.id_cotizacion AND a.id_cotizacion = '.$row["id_cotizacion"].';';
    $subquery=mysqli_query($conexion,$subconsulta);
    $tot_dominical = 0;
    while($rowSubquery= mysqli_fetch_assoc($subquery)){
      $sb = $rowSubquery["sueldo_base"];
      $cant = $rowSubquery["cantidad"];
      $dl = $rowSubquery["dias_laborados"];
      $tot_dominical += $sb*($cs+1)*$cant*($dl)*($comision_personal+1);
    }
    //subconsulta materiales
    $subconsulta = 'SELECT a.id_cotizacion_materiales, a.id_cotizacion, a.id_material, b.nombre, a.precio_unitario, a.cantidad FROM cotizacion_materiales a INNER JOIN cat_cot_mat b ON b.id = a.id_material WHERE a.id_cotizacion = '.$row["id_cotizacion"].';';
    $subquery=mysqli_query($conexion,$subconsulta);
    $tot_mat = 0;
    while($rowSubquery= mysqli_fetch_assoc($subquery)){
      $tot_mat += $rowSubquery["precio_unitario"]*($row["comision_ag_mat"]/100+1)*$rowSubquery["cantidad"];
    }
    //subconsulta degustaciones
    $comision_degustaciones = $row["comision_ag_degustaciones"]/100; // comision de agencia degustacion
    $dtd = $row["dias_tot_degustaciones"];
    $subconsulta = 'SELECT a.id_cotizacion_degustacion, a.id_cotizacion, a.id_degustacion, b.nombre, a.degustacion_por_dia, a.precio_unitario FROM cotizacion_degustaciones a INNER JOIN cat_cot_degu b ON b.id = a.id_degustacion WHERE a.id_cotizacion = '.$row["id_cotizacion"].';';
    $subquery=mysqli_query($conexion,$subconsulta);
    $tot_degu = 0;
    while($rowSubquery= mysqli_fetch_assoc($subquery)){
      $dpd= $rowSubquery["degustacion_por_dia"];
      $pu = $rowSubquery["precio_unitario"];
      $tot_degu += $dtd*$dpd*$pu*($comision_degustaciones+1);
    }
    //subconsulta otros
    $comision_otros = $row["comision_ag_otros"]/100; // comision de agencia degustacion
    $subconsulta = 'SELECT a.id_cotizacion_otros, a.id_cotizacion, a.concepto, a.precio_unitario, a.cantidad FROM cotizacion_otros a WHERE a.id_cotizacion = '.$row["id_cotizacion"].';';
    $subquery=mysqli_query($conexion,$subconsulta);
    $tot_otros = 0;
    while($rowSubquery= mysqli_fetch_assoc($subquery)){
      $pu= $rowSubquery["precio_unitario"];
      $cant = $rowSubquery["cantidad"];
      $tot_otros += $pu*$cant*($comision_otros+1);
    }

    $tot = $tot_personal+$tot_dominical+$tot_mat+$tot_degu+$tot_otros;
    $tot = number_format($tot, 2, '.', ',');
    $datos.=
      "<tr>
        <td>".$row['id_cotizacion']."</td>
        <td>".$row['no_presupuesto']."</td>
        <td>".$row['cliente']."</td>
        <td>".$row['promocion']."</td>
        <td>".$row['fecha_inicio']." al ".$row['fecha_fin']."</td>
        <td>".$tot."</td>
        <td>".$row['status']."</td>
        <td>".$row['opciones']."</td>
      </tr>"
    ;
  }
  $datos.="</tbody>";
  echo $datos;
?>
