<?php
class Modulo{
  private $id_modulo;
  private $id_supermodulo;
  private $liga;
  private $nombre;
  private $prefijo;
  private $orden;
  private $descripcion;
  private $imagen;
  private $hits;
  //get
  public function getId() {
    return $this->id_modulo;
  }
  public function getIdSuperModulo() {
    return $this->id_supermodulo;
  }
  public function getLiga() {
    return $this->liga;
  }
  public function getNombre() {
    return $this->nombre;
  }
  public function getPrefijo() {
    return $this->prefijo;
  }
  public function getOrden() {
    return $this->orden;
  }
  public function getDescripcion() {
    return $this->descripcion;
  }
  public function getImagen() {
    return $this->imagen;
  }
  public function getHits() {
    return $this->hits;
  }
  // set
  public function setId($id) {
    $this->id_modulo = $id;
  }
  public function setIdSuperModulo($id_supermodulo) {
    $this->id_supermodulo = $id_supermodulo;
  }
  public function setLiga($liga) {
    $this->liga = $liga;
  }
  public function setNombre($nombre) {
    $this->nombre = $nombre;
  }
  public function setPrefijo($prefijo) {
    $this->prefijo = $prefijo;
  }
  public function setOrden($orden) {
    $this->orden = $orden;
  }
  public function setDescripcion($descripcion) {
    $this->descripcion = $descripcion;
  }
  public function setImagen($imagen) {
    $this->imagen = $imagen;
  }
  public function setHits($hits) {
    $this->hits = $hits;
  }
  public function setConsulta($id){
    require 'includes/main.php';
    $consulta =
      "SELECT
      	a.id_modulo,
        a.id_supermodulo,
        a.liga,
        a.nombre,
        a.prefijo,
        a.orden,
        a.descripcion,
        a.imagen,
        a.hits
      FROM
          modulos a
      WHERE
      	a.id_modulo = ".$id."
      ;"
    ;
    //echo $consulta;
    $query=mysqli_query($conexion,$consulta) or die(mysql_error());
    while($row= mysqli_fetch_assoc($query)){
      $this->id_modulo = $row['id_modulo'];
      $this->id_supermodulo = $row['id_supermodulo'];
      $this->liga = $row['liga'];
      $this->nombre = $row['nombre'];
      $this->prefijo = $row['prefijo'];
      $this->orden = $row['orden'];
      $this->descripcion = $row['descripcion'];
      $this->imagen = $row['imagen'];
    }
  }
}
?>
