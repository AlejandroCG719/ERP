<?php
class Empleado{
  private $id_empleado;
  private $nombres;
  private $app;
  private $apm;
  private $tel;
  private $dir;
  private $curp;
  private $nss;
  private $rfc;
  private $fecha_nac;
  private $fecha_alta;
  private $fecha_baja;
  private $estado;
  private $id_puesto;

  //get
  public function getId() {
    return $this->id_empleado;
  }
  public function getNombres() {
    return $this->nombres;
  }
  public function getApp() {
    return $this->app;
  }
  public function getApm() {
    return $this->apm;
  }
  public function getTel() {
    return $this->tel;
  }
  public function getDir() {
    return $this->dir;
  }
  public function getCurp() {
    return $this->curp;
  }
  public function getNSS() {
    return $this->nss;
  }
  public function getRFC() {
    return $this->rfc;
  }
  public function getFechaNac() {
    return $this->fecha_nac;
  }
  public function getFechaAlta() {
    return $this->fecha_alta;
  }
  public function getFechaBaja() {
    return $this->fecha_baja;
  }
  public function getEstado() {
    return $this->estado;
  }
  public function getPuesto() {
    return $this->id_puesto;
  }
  // set
  public function setId($id_empleado) {
    $this->id_empleado = $id_empleado;
  }
  public function setNombres($nombres) {
    $this->nombres = $nombres;
  }
  public function setApp($app) {
    $this->app = $app;
  }
  public function setApm($apm) {
    $this->apm = $apm;
  }
  public function setTel($tel) {
    $this->tel = $tel;
  }
  public function setDir($dir) {
    $this->dir = $dir;
  }
  public function setCurp($curp) {
    $this->curp = $curp;
  }
  public function setNSS($nss) {
    $this->nss = $nss;
  }
  public function setRFC($rfc) {
    $this->rfc = $rfc;
  }
  public function setFechaNac($fecha_nac) {
    $this->fecha_nac = $fecha_nac;
  }
  public function setFechaAlta($fecha_alta) {
    $this->fecha_alta = $fecha_alta;
  }
  public function setFechaBaja($fecha_baja) {
    $this->fecha_baja = $fecha_baja;
  }
  public function setEstado($estado) {
    $this->estado = $estado;
  }
  public function setPuesto($id_puesto) {
    $this->id_puesto = $id_puesto;
  }
  public function setConsulta($id){
    require 'includes/main.php';
    if(0< $id){
      $consulta =
        "SELECT
          *
        From
          empleados
        WHERE
          empleados.id_empleado = ".$id."
        ;"
      ;
      $query=mysqli_query($conexion,$consulta) or die(mysql_error());
      while($row= mysqli_fetch_assoc($query)){
        $this->id_empleado = $row['id_empleado'];
        $this->nombres = $row['nombres'];
        $this->app = $row['app'];
        $this->apm = $row['apm'];
        $this->tel = $row['tel'];
        $this->dir = $row['dir'];
        $this->curp = $row['curp'];
        $this->nss = $row['nss'];
        $this->rfc = $row['rfc'];
        $this->fecha_nac = $row['fecha_nac'];
        $this->fecha_alta = $row['fecha_alta'];
        $this->fecha_baja = $row['fecha_baja'];
        $this->estado = $row['estado'];
        $this->id_puesto = $row['id_puesto'];
      }
    }
  }
}
?>
