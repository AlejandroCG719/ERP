  <?php
  require '../includes/main.php';
  $data = [];
  foreach ($_POST as $key => $value) {
    array_push($data,$value);
  }
  $ids= "(";
  for ($i=2; $i < count($data); $i++) {
    if ($i == 2) {
      $ids .= $data[$i];
    }else {
      $ids .= ",".$data[$i];
    }
  }
  $ids.=")";

  $datos=
    "<thead>
      <tr>
        <th>No.</th>
        <th>APELLIDO PATERNO</th>
        <th>APELLIDO MATERNO</th>
        <th>NOMBRES</th>
        <th>EDAD</th>
        <th>ORIGINARIO</th>
        <th>NACIONALIDAD</th>
        <th>FECHA DE NACIMIENTO</th>
        <th>ESTADO CIVIL</th>
        <th>SEXO</th>
        <th>CALLE Y NÚMERO</th>
        <th>COLONIA</th>
        <th>DELEGACION/MUNICIPIO</th>
        <th>C.P.</th>
        <th>ESTADO</th>
        <th>TELEFONO</th>
        <th>RFC</th>
        <th>CURP</th>
        <th>N.S.S.</th>
        <th>INICIO DE CONTRATO</th>
        <th>TERMINO DE CONTRATO </th>
        <th>DIAS DE CONTRATO</th>
        <th>SUPERVISOR</th>
        <th>PUESTO</th>
        <th>SALARIO</th>
        <th>SALARIO (LETRA)</th>
        <th>FECHA DE CONTRATO</th>
        <th>LUGAR DEL CONTRATO</th>
        <th>PROYECTO</th>
        <th>HORARIO LABORAL</th>
      </tr>
    </thead>
    <tbody>"
  ;
  $consulta =
    'SELECT
        a.app,
        a.apm,
        a.nombre,
        a.id_estado_nac,
        b.nombre as estado_nac,
        a.fecha_nac,
        a.id_estado_civil,
        c.nombre as estado_civil,
    	IF (
            a.sexo = 1, "Hombre", "Mujer"
          ) AS sexo,
        a.calle,
        a.num_int_ext,
        a.colonia,
        (SELECT nombre FROM cat_municipios_mexico WHERE id=a.id_municipio_dir) municipio_dir,
        a.cp,
        (SELECT nombre FROM cat_estados_mexico WHERE id=a.id_estado_dir) estado_dir,
        a.tel_cel,
        a.curp,
        a.rfc,
        a.nss
    FROM
    	solicitud_empleo a
    	INNER JOIN cat_estados_mexico b ON a.id_estado_nac = b.id
      INNER JOIN cat_estado_civil c ON a.id_estado_civil = c.id
      INNER JOIN cat_municipios_mexico d ON a.id_municipio_dir = d.id
    WHERE a.id_solicitud_empleo IN '.$ids
  ;
  $query=mysqli_query($conexion,$consulta) or die(mysql_error());


  $hoy = new DateTime();
  while($row= mysqli_fetch_assoc($query)){
    $cumpleanos = new DateTime($row['fecha_nac']);
    $annos = $hoy->diff($cumpleanos);
    $datos.=
      "<tr>
        <td></td>
        <td>".$row['app']."</td>
        <td>".$row['apm']."</td>
        <td>".$row['nombre']."</td>
        <td>".$annos->y."</td>
        <td>".$row['estado_nac']."</td>
        <td></td>
        <td>".$row['fecha_nac']."</td>
        <td>".$row['estado_civil']."</td>
        <td>".$row['sexo']."</td>
        <td>".$row['calle']." ".$row['num_int_ext']."</td>
        <td>".$row['colonia']."</td>
        <td>".$row['municipio_dir']."</td>
        <td>".$row['cp']."</td>
        <td>".$row['estado_dir']."</td>
        <td>".$row['tel_cel']."</td>
        <td>".$row['rfc']."</td>
        <td>".$row['curp']."</td>
        <td>".$row['nss']."</td>
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
      </tr>"
    ;
  }

  $datos.="</tbody>";
  echo $datos;
?>
