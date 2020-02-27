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
$consulta = "SELECT count(curp) exist FROM `solicitud_empleo` WHERE solicitud_empleo.curp = '".$curp."'";
$query=mysqli_query($conexion,$consulta) or die(mysql_error());
while($row= mysqli_fetch_assoc($query)){
  $exist = $row["exist"];
}
$datos='';
$datos = [];
if ($exist == 1) {
  if ($id_solicitud_empleo == 0) {

  } else {
    $consulta=
      "UPDATE
        solicitud_empleo
      SET
        fecha = '".$fecha."',
        puesto = '".$puesto."',
        sueldo_bruto = '".$sueldo_bruto."',
        nombre = '".$nombre."',
        app = '".$app."',
        apm = '".$apm."',
        fecha_nac = '".$fecha_nac."',
        id_estado_nac = '".$id_estado_lugar_nac."',
        id_municipio_nac = '".$id_municipio_lugar_nac."',
        id_estado_civil = '".$estado_civil."',
        id_estado_dir = '".$id_estado_dir."',
        id_municipio_dir = '".$id_municipio_dir."',
        calle = '".$calle."',
        colonia = '".$colonia."',
        cp = '".$cp."',
        antiguedad = '".$antiguedad."',
        sexo = '".$sexo."',
        nss = '".$nss."',
        rfc = '".$rfc."',
        curp = '".$curp."',
        email = '".$email."',
        tel_cel = '".$tel_cel."',
        tel_casa = '".$tel_casa."',
        num_int_ext = '".$num_int_ext."',
        talla = '".$talla."',
        hijos = '".$hijos."',
        enfermedades_cronicas = '".$enfermedades_cronicas."',
        med_tratamiento = '".$med_tratamiento."',
        op_quirurgicas = '".$op_quirurgicas."',
        alergias_padecimientos = '".$alergias_padecimientos."',
        tipo_sangre = '".$tipo_sangre."',
        contacto_emergencia = '".$contacto_emergencia."',
        emergencia_tel = '".$emergencia_tel."',
        id_grado_estudios = '".$grado_estudios."',
        escuela = '".$escuela."',
        periodo = '".$periodo."',
        titulo = '".$titulo."',
        software = '".$software."',
        tipo_smartphone = '".$tipo_smartphone."',
        nivel_software = '".$nivel_software."',
        referencia_nombre_1 = '".$referencia_nombre_1."',
        referencia_nombre_2 = '".$referencia_nombre_2."',
        referencia_tel_1 = '".$referencia_tel_1."',
        referencia_tel_2 = '".$referencia_tel_2."',
        parentesco_1 = '".$parentesco_1."',
        parentesco_2 = '".$parentesco_2."',
        eAnterior_empresa = '".$eAnterior_empresa."',
        eAnterior_fecha_ingreso = '".$eAnterior_fecha_ingreso."',
        eAnterior_puesto = '".$eAnterior_puesto."',
        eAnterior_jefe = '".$eAnterior_jefe."',
        eAnterior_tel = '".$eAnterior_tel."',
        eAnterior_fecha_salida = '".$eAnterior_fecha_salida."',
        eAnterior_motivo_salida = '".$eAnterior_motivo_salida."',
        eAnterior_puesto_jefe = '".$eAnterior_puesto_jefe."',
        ext = '".$ext."',
        status = '".$status."'
      WHERE
        1
      AND solicitud_empleo.curp = '".$curp."'"
    ;
  }
  $bitacora = "INSERT INTO bitacora (id_evento, id_usuario, fecha, hora, datos, ip) values ('10', '".$_SESSION['id_usuario']."', '".date('Y-m-d')."', '".date('H:i:s')."', 'Se modificó el empleado: ".$nombres." ".$app." ".$apm." con el id: ".$id_empleado."', '".$_SERVER['REMOTE_ADDR']."');" ;
}else {
  $consulta =
    "INSERT INTO `solicitud_empleo`(
      `id_solicitud_empleo`,
      `fecha`,
      `puesto`,
      `sueldo_bruto`,
      `nombre`,
      `app`,
      `apm`,
      `fecha_nac`,
      `id_estado_nac`,
      `id_municipio_nac`,
      `id_estado_civil`,
      `id_estado_dir`,
      `id_municipio_dir`,
      `calle`,
      `colonia`,
      `cp`,
      `antiguedad`,
      `sexo`,
      `nss`,
      `rfc`,
      `curp`,
      `email`,
      `tel_cel`,
      `tel_casa`,
      `num_int_ext`,
      `talla`,
      `hijos`,
      `enfermedades_cronicas`,
      `med_tratamiento`,
      `op_quirurgicas`,
      `alergias_padecimientos`,
      `tipo_sangre`,
      `contacto_emergencia`,
      `emergencia_tel`,
      `id_grado_estudios`,
      `escuela`,
      `periodo`,
      `titulo`,
      `software`,
      `tipo_smartphone`,
      `nivel_software`,
      `referencia_nombre_1`,
      `referencia_nombre_2`,
      `referencia_tel_1`,
      `referencia_tel_2`,
      `parentesco_1`,
      `parentesco_2`,
      `eAnterior_empresa`,
      `eAnterior_fecha_ingreso`,
      `eAnterior_puesto`,
      `eAnterior_jefe`,
      `eAnterior_tel`,
      `eAnterior_fecha_salida`,
      `eAnterior_motivo_salida`,
      `eAnterior_puesto_jefe`,
      `ext`
    )
    VALUES(
      NULL,
      '".$fecha."',
      '".$puesto."',
      '".$sueldo_bruto."',
      '".$nombre."',
      '".$app."',
      '".$apm."',
      '".$fecha_nac."',
      '".$id_estado_lugar_nac."',
      '".$id_municipio_lugar_nac."',
      '".$estado_civil."',
      '".$id_estado_dir."',
      '".$id_municipio_dir."',
      '".$calle."',
      '".$colonia."',
      '".$cp."',
      '".$antiguedad."',
      '".$sexo."',
      '".$nss."',
      '".$rfc."',
      '".$curp."',
      '".$email."',
      '".$tel_cel."',
      '".$tel_casa."',
      '".$num_int_ext."',
      '".$talla."',
      '".$hijos."',
      '".$enfermedades_cronicas."',
      '".$med_tratamiento."',
      '".$op_quirurgicas."',
      '".$alergias_padecimientos."',
      '".$tipo_sangre."',
      '".$contacto_emergencia."',
      '".$emergencia_tel."',
      '".$grado_estudios."',
      '".$escuela."',
      '".$periodo."',
      '".$titulo."',
      '".$software."',
      '".$tipo_smartphone."',
      '".$nivel_software."',
      '".$referencia_nombre_1."',
      '".$referencia_nombre_2."',
      '".$referencia_tel_1."',
      '".$referencia_tel_2."',
      '".$parentesco_1."',
      '".$parentesco_2."',
      '".$eAnterior_empresa."',
      '".$eAnterior_fecha_ingreso."',
      '".$eAnterior_puesto."',
      '".$eAnterior_jefe."',
      '".$eAnterior_tel."',
      '".$eAnterior_fecha_salida."',
      '".$eAnterior_motivo_salida."',
      '".$eAnterior_puesto_jefe."',
      '".$ext."'
    );"
  ;
  $bitacora = "INSERT INTO bitacora (id_evento, id_usuario, fecha, hora, datos, ip) values ('9', '".$_SESSION['id_usuario']."', '".date('Y-m-d')."', '".date('H:i:s')."', 'Se agregó el empleado: ".$nombres." ".$app." ".$apm."', '".$_SERVER['REMOTE_ADDR']."');" ;
}

$res = mysqli_query($conexion,$consulta);
if (!$res) {
  $error = true;
}else {
  mysqli_query($conexion,$bitacora);
}
$datos[] = array('error' =>$error);
echo json_encode($datos);

?>
