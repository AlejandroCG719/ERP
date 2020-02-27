<?php
class Promocion{
  private $id;
  private $nombre;
  private $valor;
  private $fecha;
  private $id_cliente;
  private $carga_social;
  private $com_ag_per;
  private $com_ag_mat;
  private $com_ag_otros;
  private $com_ag_degu;
  private $comision_ag_eventos_especialesr;
  private $estado;
  private $carga_social_incentivos;
  private $carga_social_pl;
  private $com_ag_incentivo;
  private $com_ag_pl;
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
  public function getFecha() {
    return $this->fecha;
  }
  public function getCliente() {
    return $this->id_cliente;
  }
  public function getCargaSocial() {
    return $this->carga_social;
  }
  public function getComisionPersonal() {
    return $this->com_ag_per;
  }
  public function getComisionMaterial() {
    return $this->com_ag_mat;
  }
  public function getComisionOtros() {
    return $this->com_ag_otros;
  }
  public function getComisionDegu() {
    return $this->com_ag_degu;
  }
  public function getComisionEventosEspeciales() {
    return $this->com_ag_eventos_especiales;
  }
  public function getEstado() {
    return $this->estado;
  }
  public function getCargaSocialIncentivos() {
    return $this->carga_social_incentivos;
  }
  public function getCargaSocialPL() {
    return $this->carga_social_pl;
  }
  public function getComisionIncentivo() {
    return $this->com_ag_incentivo;
  }
  public function getComisionPL() {
    return $this->com_ag_pl;
  }
  // set
  /*
  public function setId($id) {
    $this->id = $id;
  }
  public function setNombre($nombre) {
    $this->nombre = $nombre;
  }
  public function setValor($valor) {
    $this->valor = $valor;
  }

  public function setApm($apm) {
    $this->apm = $apm;
  }

  public function setFecha($fecha) {
    $this->fecha = $fecha;
  }
  public function setCliente($id_cliente) {
    $this->id_cliente = $id_cliente;
  }
  public function setCargaSocial($carga_social) {
    $this->carga_social = $carga_social;
  }
  public function setFechaBaja($com_ag_per) {
    $this->com_ag_per = $com_ag_per;
  }
  public function setComisionMaterial($com_ag_mat) {
    $this->com_ag_mat = $com_ag_mat;
  }
  public function setEstado($estado) {
    $this->estado = $estado;
  }
  */
  public function setConsulta($id){
    require 'includes/main.php';
    $consulta =
      "SELECT
        *
      From
        cat_promociones
      WHERE
        cat_promociones.id = ".$id."
      ;"
    ;
    $query=mysqli_query($conexion,$consulta) or die(mysql_error());
    while($row= mysqli_fetch_assoc($query)){
      $this->id = $row['id'];
      $this->nombre = $row['nombre'];
      $this->valor = $row['valor'];
      $this->fecha = $row['fecha'];
      $this->id_cliente = $row['id_cliente'];
      $this->carga_social = $row['carga_social'];
      $this->com_ag_per = $row['com_ag_per'];
      $this->com_ag_mat = $row['com_ag_mat'];
      $this->com_ag_otros = $row['com_ag_otros'];
      $this->com_ag_degu = $row['com_ag_degu'];
      $this->com_ag_eventos_especiales = $row['com_ag_eventos_especiales'];
      $this->estado = $row['estado'];
      $this->carga_social_incentivos = $row['carga_social_incentivos'];
      $this->carga_social_pl = $row['carga_social_pl'];
      $this->com_ag_incentivo = $row['com_ag_incentivos'];
      $this->com_ag_pl = $row['com_ag_pl'];
    }
  }
}
?>
