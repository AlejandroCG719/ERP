<?php
  require '../includes/main.php';
  $datos=
    "<thead>
      <tr>
        <th>Fecha</th>
        <th>Nombre</th>
        <th>Puesto</th>
        <th>Estado</th>
        <th>Del o Muni</th>
        <th>CURP</th>
        <th>Edad</th>
        <th>Cel / Casa</th>
        <th>Curriculum</th>
      </tr>
    </thead>
    <tbody>"
  ;
  $consulta =
    "SELECT
      a.id_solicitud_empleo,
      a.fecha,
      a.puesto,
      a.nombre,
      a.app,
      a.apm,
      a.fecha_nac,
      a.id_estado_dir,
      b.nombre estado,
      a.id_municipio_dir,
      c.nombre muni,
      IF (
        a.sexo = 1, 'Hombre', 'Mujer'
      ) AS sexo,
      a.curp,
      a.tel_cel,
      a.tel_casa,
      a.ext,
      a.cv
    FROM
      solicitud_empleo a INNER JOIN cat_estados_mexico b on a.id_estado_dir = b.id
      INNER JOIN cat_municipios_mexico c on a.id_municipio_dir = c.id
    WHERE
      NOT EXISTS (SELECT d.curp FROM boletinados d WHERE a.curp = d.curp )
    ORDER BY
      a.id_solicitud_empleo DESC
    ;"
  ;
  $query=mysqli_query($conexion,$consulta) or die(mysql_error());
  $i = 0;
  $hoy = new DateTime();
  while($row= mysqli_fetch_assoc($query)){
    $cumpleanos = new DateTime($row['fecha_nac']);
    $annos = $hoy->diff($cumpleanos);
    $datos.=
      "<tr>
        <td>".$row['fecha']."</td>
        <td>".$row['nombre']." ".$row['app']." ".$row['apm']."</td>
        <td>".$row['puesto']."</td>
        <td>".$row['estado']."</td>
        <td>".$row['muni']."</td>
        <td>".$row['curp']."</td>
        <td>".$annos->y."</td>
        <td>".$row['tel_cel']." / ".$row['tel_casa']."</td>
        <td class='center'>
          <a class='fa-stack fa-lg' target='_blank' href='solicitud_empleo.php?id=".$row['id_solicitud_empleo']."'>
            <i class='fa fa-edit'></i>
          </a>
          <input type='checkbox' name='val_".$i."' value='".$row['id_solicitud_empleo']."'>";
          if($row['cv']==1){
            $datos.=
              "<a class='fa-stack fa-lg' download='".$row['curp'].".".$row['ext']."' href='cv/".$row['curp'].".".$row['ext']."'>
                <i class='fa fa-file-text-o'></i>
              </a>"
            ;
          }
          $datos.="
        </td>
      </tr>"
    ;
    $i++;
  }
  $datos.="</tbody>";
  echo $datos;
?>
