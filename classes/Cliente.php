<?php
class Cliente{
  private $id;
  private $nombre;
  private $valor;
  private $caracteristica;
  private $fecha;
  private $telefono;
  private $cp;
  private $dir;
  private $estado;
  //get
  public function getId() {
    return $this->id;
  }
  public function getNombre() {
    return $this->nombre;
  }
  public function getValor() {
    return $this->valor;
  }
  public function getCaracteristica() {
    return $this->caracteristica;
  }
  public function getFecha() {
    return $this->fecha;
  }
  public function getTelefono() {
    return $this->telefono;
  }
  public function getCP() {
    return $this->cp;
  }
  public function getDir() {
    return $this->dir;
  }
  public function getEstado() {
    return $this->estado;
  }
  // set
  public function setId($id) {
    $this->id = $id;
  }
  public function setNombre($nombre) {
    $this->nombre = $nombre;
  }
  public function setValor($valor) {
    $this->valor = $valor;
  }
  public function setCaracteristica($caracteristica) {
    $this->caracteristica = $caracteristica;
  }
  public function setFecha($fecha) {
    $this->fecha = $fecha;
  }
  public function setTelefono($telefono) {
    $this->telefono = $telefono;
  }
  public function setCP($cp) {
    $this->cp = $cp;
  }
  public function setDir($dir) {
    $this->dir = $dir;
  }
  public function setEstado($estado) {
    $this->estado = $estado;
  }
  public function setConsulta($id){
    require 'includes/main.php';
    $consulta =
      "SELECT
        *
      From
        cat_clientes
      WHERE
        cat_clientes.id = ".$id."
      ;"
    ;
    $query=mysqli_query($conexion,$consulta) or die(mysql_error());
    while($row= mysqli_fetch_assoc($query)){
      $this->id = $row['id'];
      $this->nombre = $row['nombre'];
      $this->valor = $row['valor'];
      $this->caracteristica = $row['caracteristica'];
      $this->fecha = $row['fecha'];
      $this->telefono = $row['telefono'];
      $this->cp = $row['cp'];
      $this->dir = $row['dir'];
      $this->estado = $row['estado'];
    }
  }
}
?>
