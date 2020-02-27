<?php
  require '../includes/main.php';
  foreach ($_POST as $key => $value) {
    $$key = $value;
  }
  $error = false;
  if (isset($_POST['nombre_tabla'])) {
    $datos=
      "<thead>
        <tr>
          <th>Id</th>
          <th>Descripción</th>
          <th>Valor</th>
          <th>Característica</th>
          <th>Fecha</th>
          <th>Estado</th>
          <th>Editar</th>
        </tr>
      </thead>
      <tbody>"
    ;
    $consulta =
      "SELECT
        a.id,
        a.nombre,
        a.valor,
        a.caracteristica,
        a.fecha,
        IF (
      		a.estado = 1, 'Activo', 'Inactivo'
      	) AS estado
      FROM
        ".$_POST['nombre_tabla']." a
      WHERE
        1
      ;"
    ;
    $res = $query=mysqli_query($conexion,$consulta);
    if (!$res) {
      $error = true;
    }else {
      while($row= mysqli_fetch_assoc($query)){
        $datos.=
          "<tr>
            <td>".$row['id']."</td>
            <td>".$row['nombre']."</td>
            <td>".$row['valor']."</td>
            <td>".$row['caracteristica']."</td>
            <td>".$row['fecha']."</td>
            <td>".$row['estado']."</td>
            <td class='center'>
              <a class='fa-stack fa-lg' href='cnfg05_catalogos_edicion.php?id=".$row['id']."&nombre_tabla=".$_POST['nombre_tabla']."' >
                <i class='fa fa-edit'></i>
              </a>
            </td>
          </tr>"
        ;
      }
      $datos.="</tbody>";
    }

  }else {
    //mostramos todos los catalogos
    $datos=
      "<thead>
        <tr>
          <th>Catálogo</th>
          <th>Tabla</th>
          <th>Estado</th>
          <th>Editar</th>
        </tr>
      </thead>
      <tbody>"
    ;
    $consulta =
      "SELECT
        a.id_catalogo,
        a.nombre_tabla,
        a.nombre_catalogo,
        a.niveles,
        IF (
      		a.estado = 1, 'Activo', 'Inactivo'
      	) AS estado
      FROM
        indice_catalogos a
      WHERE
        1
      ;"
    ;
    $query=mysqli_query($conexion,$consulta) or die(mysql_error());
    while($row= mysqli_fetch_assoc($query)){
      $datos.=
        "<tr>
          <td>".$row['nombre_tabla']."</td>
          <td>".$row['nombre_catalogo']."</td>
          <td>".$row['estado']."</td>
          <td class='center'>
            <a class='fa-stack fa-lg' href='cnfg05_catalogos_contenido.php?id_catalogo=".$row['id_catalogo']."&nombre_tabla=".$row['nombre_tabla']."' >
              <i class='fa fa-edit'></i>
            </a>
          </td>
        </tr>"
      ;
    }
    $datos.="</tbody>";
  }
  if ($error == true) {
    echo "error";
  }else {
    echo $datos;
  }

?>
