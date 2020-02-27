<?php
class PersonalPromocion{
  private $id;
  private $id_personal;
  private $id_promocion;
  private $caracteristica;
  private $carga_social;
  private $sueldo_base;
  private $estado;
  //get
  public function getId() {
    return $this->id;
  }
  public function getId_personal() {
    return $this->id_personal;
  }
  public function getId_promocion() {
    return $this->id_promocion;
  }
  public function getCaracteristica() {
    return $this->caracteristica;
  }
  public function getCarga_social() {
    return $this->carga_social;
  }
  public function getSueldo_base() {
    return $this->sueldo_base;
  }
  public function getEstado() {
    return $this->estado;
  }
  // set
  public function setId($id) {
    $this->id = $id;
  }
  public function setId_personal($id_personal) {
    $this->id_personal = $id_personal;
  }
  public function setCaracteristica($caracteristica) {
    $this->caracteristica = $caracteristica;
  }
  public function setFecha($id_promocion) {
    $this->id_promocion = $id_promocion;
  }
  public function setTelefono($carga_social) {
    $this->carga_social = $carga_social;
  }
  public function setCP($sueldo_base) {
    $this->sueldo_base = $sueldo_base;
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
        cat_personal_promocion
      WHERE
        cat_personal_promocion.id = ".$id."
      ;"
    ;
    $query=mysqli_query($conexion,$consulta) or die(mysql_error());
    while($row= mysqli_fetch_assoc($query)){
      $this->id = $row['id'];
      $this->id_personal = $row['id_personal'];
      $this->id_promocion = $row['id_promocion'];
      $this->caracteristica = $row['caracteristica'];
      $this->carga_social = $row['carga_social'];
      $this->sueldo_base = $row['sueldo_base'];
      $this->estado = $row['estado'];
    }
  }
}
?>
