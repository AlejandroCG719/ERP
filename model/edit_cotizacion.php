<?php
header('Content-type: text/javascript');
ob_start();
require '../includes/main.php';
ob_end_clean();
$error = false;
foreach ($_POST as $key => $value) {
  $$key = $value;
}
if (!isset($dias_tot_degustaciones)) {
  $dias_tot_degustaciones = 0;
}
var_dump($_POST);
$consulta =
  "INSERT INTO cotizaciones(
    fecha,
    fecha_inicio,
    fecha_fin,
    no_presupuesto,
    id_cliente,
    id_promocion,
    plaza,
    id_status,
    dias_capacitacion,
    comision_ag_mat,
    comision_ag_otros,
    comision_ag_degustaciones,
    dias_tot_degustaciones,
    com_ag_eventos_especiales,
    carga_social_incentivo,
    com_ag_incentivo,
    carga_social_pl,
    com_ag_pl,
    secc_personal,
    secc_dominical,
    secc_otros,
    secc_mat,
    secc_degu,
    secc_eventos_especiales,
    secc_incentivos,
    secc_pl,
    id_usuario
  )values(
    '".$_POST['fecha']."',
    '".$_POST['fecha_inicio']."',
    '".$_POST['fecha_fin']."',
    '".$_POST['no_presupuesto']."',
    '".$_POST['id_cliente']."',
    '".$_POST['id_promocion']."',
    '".$_POST['plaza']."',
    '".$_POST['id_status']."',
    '".$_POST['dias_capacitacion']."',
    '".$_POST['comision_ag_mat']."',
    '".$_POST['comision_ag_otros']."',
    '".$_POST['comision_ag_degustaciones']."',
    '".$_POST['dias_tot_degustaciones']."',
    '".$_POST['comision_ag_eventos_especiales']."',
    '".$_POST['carga_social_incentivo']."',
    '".$_POST['comision_ag_incentivo']."',
    '".$_POST['carga_social_pl']."',
    '".$_POST['comision_ag_pl']."',
    '".$_POST['secc_personal']."',
    '".$_POST['secc_dominical']."',
    '".$_POST['secc_otros']."',
    '".$_POST['secc_mat']."',
    '".$_POST['secc_degustaciones']."',
    '".$_POST['secc_eventos_especiales']."',
    '".$_POST['secc_incentivos']."',
    '".$_POST['secc_pl']."',
    '".$_SESSION["id_empleado"]."'
  );"
;
var_dump($consulta);
$res = mysqli_query($conexion,$consulta);
if (!$res) {
  $error = true;
  $msg = 'Ocurrio un Error, por favor verifique e intente nuevamente. tabla cotizacion '.$consulta;
} else {
  $consulta =
    "SELECT
      cotizaciones.id_cotizacion
    FROM
      cotizaciones
    ORDER BY
      cotizaciones.id_cotizacion DESC
    Limit 1
    ;"
  ;
  $res = mysqli_query($conexion,$consulta);
  if ($res) {
    while($row= mysqli_fetch_assoc($res)){
      $id = $row['id_cotizacion'];
    }
    if ($secc_personal == 1) {
      for ($i=0; $i <=$indice_per; $i++) {
        $consulta =
          "INSERT INTO cotizacion_personal(
            id_cotizacion,
            id_posicion,
            sueldo_base,
            cantidad,
            dias_laborados,
            carga_social
          )values(
            ".$id.",
            ".$_POST['id_posicion_0_'.$i].",
            ".$_POST['sueldo_base_0_'.$i].",
            ".$_POST['cantidad_0_'.$i].",
            ".$_POST['num_dias_0_'.$i].",
            ".$_POST['carga_social_personal_0_'.$i]."
          );"
        ;
        $res = mysqli_query($conexion,$consulta);
        if ($res) {
          $msg .= 'Personal OK';
        }else {
          /*$error = true ;*/
          $msg = 'Error al guardar en personal.';
        }
      }
    }

    if ($desglozado == 1) {
      $consulta =
        "INSERT INTO cotizacion_prestaciones_integrales (
          id_cotizacion,
          id_posicion,
          porcentaje_puntualidad,
          porcentaje_asistencia,
          porcentaje_despensa,
          salario_minimo
        ) values (
          ".$id.",
          ".$_POST['id_posicion_'.$i].",
          ".$_POST['pi_puntualidad_'.$i].",
          ".$_POST['pi_asistencia_'.$i].",
          ".$_POST['pi_porcentaje_despensa_'.$i].",
          ".$_POST['pi_salario_minimo']."
        );"
      ;
      mysqli_query($conexion,$consulta);
    }
    if ($secc_dominical == 1) {
      if ($indice_dominical >= 0) {
        for ($i=0; $i <= $indice_dominical ; $i++) {
          if (isset($_POST['dominical_id_personal_'.$i])) {
            $consulta =
              "INSERT INTO cotizacion_prima_dominical (
                id_cotizacion,
                id_posicion,
                sueldo_base,
                dias_laborados
              ) values (
                ".$id.",
                ".$_POST['dominical_id_personal_'.$i].",
                ".$_POST['dominical_sueldo_base_'.$i].",
                ".$_POST['dias_dom_'.$i]."
              );"
            ;
            mysqli_query($conexion,$consulta);
          }
        }
      }
    }
    if ($secc_incentivos == 1) {
      for ($i=0; $i <= $indice_incentivos; $i++) {
        $consulta =
          "INSERT INTO cotizacion_incentivos(
            descripcion,
            num_personal,
            costo_mensual,
            id_cotizacion
          )values(
            '".$_POST['incentivo_descripcion_'.$i]."',
            ".$_POST['incentivos_num_personal_'.$i].",
            ".$_POST['incentivos_costo_mensual_'.$i].",
            ".$id."
          );"
        ;
        mysqli_query($conexion,$consulta);
      }
    }
    if ($secc_otros == 1) {
      for ($i=0; $i <= $indice_otros; $i++) {
        $consulta =
          "INSERT INTO cotizacion_otros (
            id_cotizacion,
            concepto,
            precio_unitario,
            cantidad
          ) values (
            ".$id.",
            '".$_POST['otros_concepto_'.$i]."',
            ".$_POST['otros_monto_'.$i].",
            ".$_POST['otros_cantidad_'.$i]."
          );"
        ;
        mysqli_query($conexion,$consulta);
      }
    }
    if ($secc_mat == 1) {
      for ($i=0; $i <= $indice_mat; $i++) {
        $consulta =
          "INSERT INTO cotizacion_materiales(
            id_cotizacion,
            id_material,
            precio_unitario,
            cantidad
          )values(
            ".$id.",
            ".$_POST['id_material_'.$i].",
            ".$_POST['costo_unitario_'.$i].",
            ".$_POST['cant_mat_'.$i]."
          );"
        ;
        mysqli_query($conexion,$consulta);
      }
    }
    if ($secc_degu == 1) {
      for ($i=0; $i <= $indice_degustaciones; $i++) {
        $consulta =
          "INSERT INTO cotizacion_degustaciones (
            id_cotizacion,
            id_degustacion,
            degustacion_por_dia,
            precio_unitario
          ) values(
            ".$id.",
            ".$_POST['id_degustacion_'.$i].",
            ".$_POST['degu_cantidad_'.$i].",
            ".$_POST['degu_costo_unidad_'.$i]."
          );"
        ;
        mysqli_query($conexion,$consulta);
      }
    }
    if ($secc_pago_proveedor == 1) {
      $consulta =
        "INSERT INTO cotizacion_pago_proveedor (
          proveedor,
          monto,
          id_cotizacion
        ) values(
          '".$proveedor."',
          ".$pago_proveedor_monto.",
          ".$id."
        );"
      ;
      mysqli_query($conexion,$consulta);
    }
    if ($secc_pl == 1) {
      for ($i=0; $i <= $indice_pl; $i++) {
        $consulta =
          "INSERT INTO cotizacion_pasivo_laboral(
            id_personal,
            sueldo_base,
            cant,
            meses_liquidacion,
            dias_x_anio,
            dias_prima_vac,
            id_cotizacion
          )values(
            '".$_POST['id_personal_pl_'.$i]."',
            '".$_POST['pl_sueldo_base_'.$i]."',
            '".$_POST['pl_num_personal_'.$i]."',
            '".$_POST['meses_liquidacion_'.$i]."',
            '".$_POST['dias_x_anio_'.$i]."',
            '".$_POST['dias_prima_vacacional_'.$i]."',
            '".$id."'
          );"
        ;
        mysqli_query($conexion,$consulta);
      }
    }
    $msg .= 'El Registro se Guardo con Éxito.';
    //$msg .='<br><a href="cot01_cotizaciones_listado.php" class="btn btn-info">Ir al listado</a> -o- <a href="cot01_cotizaciones_edicion.php" class="btn btn-success"><i class="fa fa-plus-circle"></i> Registrar uno nuevo</a> ';
  }else {
    $msg = 'Ocurrio un error, favor de intentarlo mas tarde No recupero ID';
  }
}
?>
$("#message").html('<div class="alert alert-<?= (true == $error) ? 'danger' : 'success' ?>"><a href="#" class="close" data-dismiss="alert">&times;</a><strong><?= str_replace("'", '`',$msg) ?> </strong></div>');
