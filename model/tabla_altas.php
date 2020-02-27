<?php
  require '../includes/main.php';
  $data = [];
  foreach ($_POST as $key => $value) {
    array_push($data,$value);
  }
  $ids= "(";
  for ($i=1; $i < count($data); $i++) {
    if ($i == 1) {
      $ids .= $data[$i];
    }else {
      $ids .= ",".$data[$i];
    }
  }
  $ids.=")";
  if (count($data)>6) {
    $datos=
      "<thead>
        <tr>
          <th>No.</th>
          <th>Promoción</th>
          <th>Tipo de Jornada</th>
          <th>Apellido Paterno</th>
          <th>Apellido Materno</th>
          <th>Nombre (s)</th>
          <th>Fecha Nacimiento</th>
          <th>RFC</th>
          <th>NSS</th>
          <th>Dig.ver</th>
          <th>Sexo</th>
          <th>Sexo_ID</th>
          <th>Lugar de Nacimiento</th>
          <th>Curp</th>
          <th>Fecha de Ingreso</th>
          <th>Nacionalidad</th>
          <th>Nacionalidad_ID</th>
          <th>Estado Civil</th>
          <th>Edo Civil_ID</th>
          <th>Telefono</th>
          <th>Celular</th>
          <th>Plaza</th>
          <th>Depto_ID</th>
          <th>'Puesto</th>
          <th>'Puesto_ID</th>
          <th>'SD</th>
          <th>'SD SICOSS</th>
          <th>'SDI SICOSS</th>
          <th>Calle y No</th>
          <th>Colonia</th>
          <th>Ciudad o Delegación</th>
          <th>Estado</th>
          <th>CP</th>
          <th>Tipo Infonavit</th>
          <th>No. Crédito</th>
          <th>Factor de Desc</th>
          <th>Grado Estudios</th>
          <th>Estudios_ID</th>
          <th>N° Empleado</th>
          <th>Familiar en Nestlé</th>
          <th>Familiar en TopMkt</th>
          <th>Número de Cuenta</th>
          <th>Banco</th>
          <th>Contratación</th>
          <th>Región</th>
          <th>Localidad</th>
          <th>Coordinador regional Top</th>
          <th>ReportaNestle/ COP</th>
          <th>CADENA</th>
          <th>TIENDA</th>
          <th>RUTA</th>
          <th>SUPERVISOR</th>
          <th>ID ALLOCATION</th>
          <th>Enfermedades Crónicas</th>
          <th>Medicamentos o Tratamientos</th>
          <th>Operaciones Quirurgicas</th>
          <th>Tel: Jefe inmediato</th>
          <th>Alergias/Padecimientos</th>
          <th>Tipo Sanguineo</th>
          <th>Nombre en caso de Emergencia</th>
          <th>Tel: Emergencia</th>
          <th>Comentarios</th>
        </tr>
      </thead>
      <tbody>"
    ;
    $consulta =
      'SELECT
        a.app,
        a.apm,
        a.nombre,
        DATE_FORMAT(a.fecha_nac, "%d/%m/%Y") fecha_nac,
        a.rfc,
        a.nss,
        a.nss "dig_ver",
        IF(a.sexo = 1, "MASCULINO", "FEMENINO") Sexo,
        IF(a.sexo = 1, "0", "1") Sexo_ID,
        b.sicoss_nombre AS lugar_nac,
        a.curp,
        "MEXICANA" AS Nacionalidad,
        c.nombre AS "Estado Civil",
        c.valor AS "Edo_civil_id",
        a.tel_casa,
        a.tel_cel,
        CONCAT(a.calle, " ", a.num_int_ext) AS "calle_num",
        a.colonia,
        e.nombre ciudad_del,
        b.sicoss_nombre AS Estado,
        a.cp,
        d.nombre AS grado_estudios,
        d.valor AS estudios_id,
        a.enfermedades_cronicas,
        a.med_tratamiento,
        a.op_quirurgicas,
        a.eAnterior_tel AS "Tel: Jefe Inmediato",
        a.alergias_padecimientos,
        g.nombre AS "Tipo Sanguineo",
        a.contacto_emergencia,
        a.emergencia_tel
      FROM
        solicitud_empleo a
      INNER JOIN cat_estados_mexico b ON
        a.id_estado_nac = b.id
      INNER JOIN cat_estado_civil c ON
        a.id_estado_civil = c.id
      INNER JOIN cat_escolaridad d ON
        a.id_grado_estudios = d.id
      INNER JOIN cat_municipios_mexico e ON
        a.id_municipio_dir = e.id
      INNER JOIN cat_tipo_sangre g ON
        a.tipo_sangre = g.id
      WHERE a.id_solicitud_empleo IN '.$ids
    ;
    $query=mysqli_query($conexion,$consulta) or die(mysql_error());
    $j = 1;
    $c = 5;
    $d = 8;
    while($row= mysqli_fetch_assoc($query)){
      $nss = "";
      for ($i=0; $i < 11 ; $i++) {
        if ($i<10) {
          $nss .= $row['nss'][$i];
        }else {
          $dver = $row['nss'][$i];
        }
      }
      $datos.=
        "<tr>
          <td>".$j."</td>
          <td></td>
          <td></td>
          <td>".$row['app']."</td>
          <td>".$row['apm']."</td>
          <td>".$row['nombre']."</td>
          <td>".$row['fecha_nac']."</td>
          <td>=+RFC([@[Nombre (s)]],[@[Apellido Paterno]],[@[Apellido Materno]],[@[Fecha Nacimiento]])</td>
          <td>".$nss."</td>
          <td>=+NSS([@NSS])</td>
          <td>".$row['Sexo']."</td>
          <td>=+BUSCARV([@Sexo],DATOS!\$C$2:\$D$3,2,0)</td>
          <td>".$row['lugar_nac']."</td>
          <td>=+CURP!G$c</td>
          <td></td>
          <td>".$row['Nacionalidad']."</td>
          <td>=+BUSCARV([@Nacionalidad],Estatus!\$G$3:\$H$18,2,0)</td>
          <td>".$row['Estado Civil']."</td>
          <td>=+BUSCARV([@[Estado Civil]],Estatus!\$E$3:\$F$8,2,0)</td>
          <td>".$row['tel_casa']."</td>
          <td>".$row['tel_cel']."</td>
          <td></td>
          <td>=+BUSCARV(W$d,DATOS!\$G$2:\$H$500,2,0)</td>
          <td></td>
          <td>=+BUSCARV(Y$d,DATOS!\$I$2:\$J$525,2,0)</td>
          <td></td>
          <td></td>
          <td></td>
          <td>".$row['calle_num']."</td>
          <td>".$row['colonia']."</td>
          <td>".$row['ciudad_del']."</td>
          <td>".$row['Estado']."</td>
          <td>".$row['cp']."</td>
          <td></td>
          <td></td>
          <td></td>
          <td>".$row['grado_estudios']."</td>
          <td>=+BUSCARV([@[Grado Estudios]],DATOS!\$E$2:\$F$10,2,0)</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>".$row['enfermedades_cronicas']."</td>
          <td>".$row['med_tratamiento']."</td>
          <td>".$row['op_quirurgicas']."</td>
          <td>".$row['Tel: Jefe Inmediato']."</td>
          <td>".$row['alergias_padecimientos']."</td>
          <td>".$row['Tipo Sanguineo']."</td>
          <td>".$row['contacto_emergencia']."</td>
          <td>".$row['emergencia_tel']."</td>
          <td></td>
        </tr>"
      ;
      $c++;
      $d++;
      $j++;
    }
  }else {
    $datos=
      "<thead>
        <tr>
          <th>Apellido Paterno</th>
          <th>Apellido Materno</th>
          <th>Nombres</th>
          <th>Fecha De Nacimiento</th>
          <th>Edad</th>
          <th>Sexo</th>
          <th>Originario</th>
          <th>Nacionalidad</th>
          <th>Estado Civil</th>
          <th>Escolaridad</th>
          <th>Rfc</th>
          <th>Curp</th>
          <th>N.S.S</th>
          <th>Comp de NSS</th>
          <th>Calle Y Número</th>
          <th>Colonia</th>
          <th>Delegacion/Municipio</th>
          <th>C.P.</th>
          <th>Estado</th>
          <th>Telefono Celular</th>
          <th>Telefono Casa</th>
          <th>Inicio De Contrato</th>
          <th>Fecha De Contrato(Alta)</th>
          <th>Termino Do Contrato</th>
          <th>Dias De Contrato</th>
          <th>Supervisor</th>
          <th>Puesto</th>
          <th>Salario</th>
          <th>Salario (Letra)</th>
          <th>Lugar Del Contrato</th>
          <th>Proyecto</th>
          <th>Horario Laboral</th>
          <th>Contratacion</th>
          <th>Region</th>
          <th>Coordinador</th>
          <th>Localidad</th>
          <th>Reemplaza A:</th>
          <th>Banco</th>
          <th>Cuenta Clave</th>
          <th>Interbancaria</th>
          <th>Cta Santander</th>
          <th>Enfermedades Crónicas</th>
          <th>Medicamentos O Tratamientos</th>
          <th>Operaciones Quirúrgicas</th>
          <th>Tel: Jefe Inmediato</th>
          <th>Alergias/Padecimientos</th>
          <th>Tipo Sanguineo</th>
          <th>Nombre Emergencia</th>
          <th>Tel. Emergencia</th>
          <th>Correo electrónico</th>
        </tr>
      </thead>
      <tbody>"
    ;
    $consulta =
      'SELECT
        a.app AS "Apellido Paterno",
        a.apm AS "Apellido Materno",
        a.nombre AS Nombres,
        DATE_FORMAT(a.fecha_nac, "%d/%m/%Y") "Fecha De Nacimiento",
        "" AS Edad,
        IF(
          a.sexo = 1,
          "MASCULINO",
          "FEMENINO"
        ) AS Sexo,
        b.nombre AS Originario,
        "MEXICANA" AS Nacionalidad,
        c.nombre AS "Estado Civil",
        d.nombre AS Escolaridad,
        d.caracteristica AS idEscolaridad,
        a.rfc AS Rfc,
        a.curp AS Curp,
        a.nss AS "N.S.S",
        "11" AS "Comp de NSS",
        CONCAT(a.calle, " ", a.num_int_ext) AS "Calle Y Número",
        a.colonia AS Colonia,
        e.nombre AS "Delegacion/Municipio",
        a.cp AS "C.P.",
        f.nombre AS Estado,
        a.tel_cel AS "Telefono Celular",
        a.tel_casa AS "Telefono Casa",
        "" AS "Inicio De Contrato",
        "" AS "Fecha De Contrato(Alta)",
        "" AS "Termino Do Contrato",
        "" AS "Dias De Contrato",
        "" AS "Supervisor",
        "" AS "Fecha De Contrato(Alta)",
        "" AS "Puesto",
        "" AS "Salario",
        "" AS "Salario (Letra)",
        "" AS "Lugar Del Contrato",
        "" AS "Proyecto",
        "" AS "Horario Laboral",
        "" AS "Contratacion",
        "" AS "Region",
        "" AS "Coordinador",
        "" AS "Localidad",
        "" AS "Reemplaza A:",
        "" AS "Banco",
        "" AS "Cuenta Clave",
        "" AS "Interbancaria",
        "" AS "Cta Santander",
        a.enfermedades_cronicas AS "Enfermedades Crónicas",
        a.med_tratamiento AS "Medicamentos O Tratamientos",
        a.op_quirurgicas AS "Operaciones Quirúrgicas",
        a.eAnterior_tel AS "Tel: Jefe Inmediato",
        "" AS "Region",
        a.alergias_padecimientos AS "Alergias/Padecimientos",
        g.nombre as "Tipo Sanguineo",
        a.contacto_emergencia as "Nombre Emergencia",
        a.emergencia_tel as "Tel. Emergencia",
        a.email as "Correo electrónico"
      FROM
        solicitud_empleo a
      INNER JOIN cat_estados_mexico b ON
        a.id_estado_nac = b.id
      INNER JOIN cat_estado_civil c ON
        a.id_estado_civil = c.id
      INNER JOIN cat_escolaridad d ON
        a.id_grado_estudios = d.id
      INNER JOIN cat_municipios_mexico e ON
        a.id_municipio_dir = e.id
      INNER JOIN cat_estados_mexico f ON
        a.id_estado_dir = f.id
      INNER JOIN cat_tipo_sangre g ON
        a.tipo_sangre = g.id
      WHERE a.id_solicitud_empleo IN '.$ids;
    $query=mysqli_query($conexion,$consulta) or die(mysql_error());
    while($row= mysqli_fetch_assoc($query)){
      $datos.=
        "<tr>
          <td>".$row['Apellido Paterno']."</td>
          <td>".$row['Apellido Materno']."</td>
          <td>".$row['Nombres']."</td>
          <td>".$row['Fecha De Nacimiento']."</td>
          <td>".$row['Edad']."</td>
          <td>".$row['Sexo']."</td>
          <td>".$row['Originario']."</td>
          <td>".$row['Nacionalidad']."</td>
          <td>".$row['Estado Civil']."</td>
          <td>".$row['idEscolaridad']." ".$row['Escolaridad']."</td>
          <td>".$row['Rfc']."</td>
          <td>".$row['Curp']."</td>
          <td>".$row['N.S.S']."</td>
          <td>".$row['Comp de NSS']."</td>
          <td>".$row['Calle Y Número']."</td>
          <td>".$row['Colonia']."</td>
          <td>".$row['Delegacion/Municipio']."</td>
          <td>".$row['C.P.']."</td>
          <td>".$row['Estado']."</td>
          <td>".$row['Telefono Celular']."</td>
          <td>".$row['Telefono Casa']."</td>
          <td>".$row['Inicio De Contrato']."</td>
          <td>".$row['Fecha De Contrato(Alta)']."</td>
          <td>".$row['Termino Do Contrato']."</td>
          <td>".$row['Dias De Contrato']."</td>
          <td>".$row['Supervisor']."</td>
          <td>".$row['Puesto']."</td>
          <td>".$row['Salario']."</td>
          <td>".$row['Salario (Letra)']."</td>
          <td>".$row['Lugar Del Contrato']."</td>
          <td>".$row['Proyecto']."</td>
          <td>".$row['Horario Laboral']."</td>
          <td>".$row['Contratacion']."</td>
          <td>".$row['Region']."</td>
          <td>".$row['Coordinador']."</td>
          <td>".$row['Localidad']."</td>
          <td>".$row['Reemplaza A:']."</td>
          <td>".$row['Banco']."</td>
          <td>".$row['Cuenta Clave']."</td>
          <td>".$row['Interbancaria']."</td>
          <td>".$row['Cta Santander']."</td>
          <td>".$row['Enfermedades Crónicas']."</td>
          <td>".$row['Medicamentos O Tratamientos']."</td>
          <td>".$row['Operaciones Quirúrgicas']."</td>
          <td>".$row['Tel: Jefe Inmediato']."</td>
          <td>".$row['Alergias/Padecimientos']."</td>
          <td>".$row['Tipo Sanguineo']."</td>
          <td>".$row['Nombre Emergencia']."</td>
          <td>".$row['Tel. Emergencia']."</td>
          <td>".$row['Correo electrónico']."</td>
        </tr>"
      ;
    }
  }
  $datos.="</tbody>";
  echo $datos;
?>
