<?php
class Catalogo{
  private $id;
  private $nombre;
  private $valor;
  private $caracteristica;
  private $fecha;
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
  public function setEstado($estado) {
    $this->estado = $estado;
  }
  public function setConsulta($id, $tabla){
    require 'includes/main.php';
    $consulta =
      "SELECT
      	a.id_perfil,
        a.nombre,
        a.valor,
        a.caracteristica,
        a.fecha,
        a.estado
      FROM
          ".$tabla." a
      WHERE
      	a.id = ".$id."
      ;"
    ;
    $query=mysqli_query($conexion,$consulta) or die(mysql_error());
    while($row= mysqli_fetch_assoc($query)){
      $this->id = $row['id_perfil'];
      $this->nombre = $row['nombre'];
      $this->valor = $row['valor'];
      $this->caracteristica = $row['caracteristica'];
      $this->fecha = $row['fecha'];
      $this->estado = $row['estado'];
    }
  }
}
?>
