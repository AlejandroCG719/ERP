<?php
  header('Access-Control-Allow-Origin: *');
  header('Cache-Control: no-cache, must-revalidate');
  header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
  header('Content-type: text/javascript');
  ob_start();
  require '../includes/main.php';
  ob_end_clean();
  foreach ($_POST as $key => $value) {
    $$key = $value;
  }
  var_dump($_POST);
  $datos='';
  $datos = [];
  if ($id_pago_solicitud != "") {
    if ($id_finanzas_pago == "") {
      $consulta =
        "UPDATE
          finanzas_pago_solicitud
        SET
          status = '".$status."'
        WHERE
          id_pago_solicitud = '".$id_pago_solicitud."'; "
      ;
      $res = mysqli_query($conexion,$consulta);
      if (!$res) {
        $error = true;
      }else {
        $consulta =
          "INSERT INTO finanzas_pagos(
            id_pago_solicitud,
            programacion_pago,
            referencia,
            id_concepto_pago,
            id_subconcepto_pago,
            observaciones,
            fecha_deposito
          )
          VALUES(
            '".$id_pago_solicitud."',
            '".$programacion_pago."',
            '".$referencia."',
            '".$id_concepto_pago."',
            '".$id_subconcepto_pago."',
            '".$observaciones."',
            '".$fecha_deposito."'
          );"
        ;
        $res = mysqli_query($conexion,$consulta);
        if (!$res) {
          $error = true;
        }else {
          for ($i=0; $i <= $indice_pagos; $i++) {
            $consulta =
              "INSERT INTO finanzas_pagos_transacciones(
                id_pago_solicitud,
                id_banco,
                id_cuenta_banco,
                monto,
                id_forma_pago
              )
              VALUES(
                '".$id_pago_solicitud."',
                '".$_POST['id_banco_'.$i]."',
                '".$_POST['id_cuenta_banco_'.$i]."',
                '".$_POST['monto_'.$i]."',
                '".$_POST['id_forma_pago_'.$i]."'
              );"
            ;
            $res = mysqli_query($conexion,$consulta);
          }
        }
      }
      //$bitacora = "INSERT INTO bitacora (id_evento, id_usuario, fecha, hora, datos, ip) values ('10', '".$_SESSION['id_usuario']."', '".date('Y-m-d')."', '".date('H:i:s')."', 'Se modificó el empleado: ".$nombres." ".$app." ".$apm." con el id: ".$id_empleado."', '".$_SERVER['REMOTE_ADDR']."');" ;
    } else {
      $consulta =
        "UPDATE
          finanzas_pago_solicitud
        SET
          status = '".$status."'
        WHERE
          id_pago_solicitud = '".$id_pago_solicitud."'; "
      ;
      $res = mysqli_query($conexion,$consulta);
      $consulta =
        "UPDATE
          finanzas_pagos
        SET
          fecha_deposito = '".$fecha_deposito."'
        WHERE
          id_pago_solicitud = '".$id_pago_solicitud."'; "
      ;
      $res = mysqli_query($conexion,$consulta);
      if (!$res) {
        $error = true;
      }
    }
  } else {
    $consulta =
      "INSERT INTO finanzas_pago_solicitud(fecha, plaza, solicitante, folio, monto, monto_letra, id_banco, cuenta_deposito, beneficiario, id_promocion, id_cotizacion, concepto) VALUES( '".$fecha_solicitud."', '".$plaza."', '".$solicitante."', ".$folio."', '".$monto."',  '".$monto_letra."', '".$banco_solicitante."', '".$cuenta_deposito."', '".$beneficiario."', '".$id_promocion."', '".$id_cotizacion."', '".$concepto." );"
    ;
    $bitacora = "INSERT INTO bitacora (id_evento, id_usuario, fecha, hora, datos, ip) values ('9', '".$_SESSION['id_usuario']."', '".date('Y-m-d')."', '".date('H:i:s')."', 'Se agregó el empleado: ".$nombres." ".$app." ".$apm."', '".$_SERVER['REMOTE_ADDR']."');" ;
    $res = mysqli_query($conexion,$consulta);
  }
  if (!$res) {
    $error = true;
  }else {
    mysqli_query($conexion,$bitacora);
  }
  $datos[] = array('error' =>$error,'consulta' =>$consulta);
  echo json_encode($datos);
?>
