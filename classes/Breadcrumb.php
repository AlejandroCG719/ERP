<?php
class Breadcrumb{
  private $nombre;
  private $descripcion;
  private $id_modulo;
  private $apm;
  private $tel;

  //get
  public function getNombre() {
    return $this->nombre;
  }
  public function getDescripcion() {
    return $this->descripcion;
  }
  public function getIdMod() {
    return $this->id_modulo;
  }
  public function getImagen() {
    return $this->imagen;
  }
  public function getLiga() {
    return $this->liga;
  }
  // set
  public function setNombre($nombre) {
    $this->nombre = $nombre;
  }
  public function setDescripcion($descripcion) {
    $this->descripcion = $descripcion;
  }
  public function setIdMod($id_modulo) {
    $this->id_modulo = $id_modulo;
  }
  public function setImagen($Imagen) {
    $this->imagen = $imagen;
  }
  public function setLiga($liga) {
    $this->liga = $liga;
  }
  public function setConsulta($perfil){
    $pagina = $_SERVER['PHP_SELF'];
    $pagina = basename($pagina);
    $b=0;
    $prefijo= '';
    for ($i=0; $i < strlen($pagina); $i++) {
      if ($pagina[$i] == '_') {
        $b=1;
      }
      if ($b == 0) {
        $prefijo = $prefijo.$pagina[$i];
      }

    }
    require 'includes/main.php';

    $consulta =
      "SELECT
      	modulos.nombre,
        modulos.descripcion,
        modulos.id_modulo,
        modulos.imagen,
        modulos.liga
      FROM
          modulos
      	INNER JOIN modulo_has_perfiles ON modulo_has_perfiles.id_modulo = modulos.id_modulo
      WHERE
      	modulos.prefijo LIKE '".$prefijo."' AND modulo_has_perfiles.id_perfil = ".$perfil."
      ;"
    ;
    //echo $consulta;

    $query=mysqli_query($conexion,$consulta) or die(mysql_error());
    while($row= mysqli_fetch_assoc($query)){
      $this->nombre = $row['nombre'];
      $this->descripcion = $row['descripcion'];
      $this->id_modulo = $row['id_modulo'];
      $this->imagen = $row['imagen'];
      $this->liga = $row['liga'];
    }
  }
}
?>
