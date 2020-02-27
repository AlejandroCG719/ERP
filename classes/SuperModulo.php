<?php
class SuperModulo{
  private $id_supermodulo;
  private $nombre;
  private $imagen;
  private $descripcion;
  private $orden;

  //get
  public function getId() {
    return $this->id_supermodulo;
  }
  public function getNombre() {
    return $this->nombre;
  }
  public function getImagen() {
    return $this->imagen;
  }
  public function getDescripcion() {
    return $this->descripcion;
  }
  public function getOrden() {
    return $this->orden;
  }
  // set
  public function setId($id) {
    $this->id_supermodulo = $id;
  }
  public function setNombre($nombre) {
    $this->nombre = $nombre;
  }
  public function setImagen($imagen) {
    $this->imagen = $imagen;
  }
  public function setDescripcion($descripcion) {
    $this->descripcion = $descripcion;
  }
  public function setOrden($orden) {
    $this->orden = $orden;
  }

  public function setConsulta($id){
    require 'includes/main.php';
    $consulta =
      "SELECT
        a.id_supermodulo,
        a.nombre,
        a.imagen,
        a.descripcion,
        a.orden
      FROM
          supermodulos a
      WHERE
        a.id_supermodulo = ".$id."
      ;"
    ;
    $query=mysqli_query($conexion,$consulta) or die(mysql_error());
    while($row= mysqli_fetch_assoc($query)){
      $this->nombre = $row['nombre'];
      $this->descripcion = $row['descripcion'];
      $this->imagen = $row['imagen'];
      $this->orden = $row['orden'];
    }    
  }
}
?>
