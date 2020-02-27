<?php
class InfoGen{
  private $id_empleado;
  private $nombres;
  private $app;
  private $apm;
  private $usuario;
  private $perfil;

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
  public function getUsuario() {
    return $this->usuario;
  }
  public function getPerfil() {
    return $this->perfil;
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
  public function setUsuario($usuario) {
    $this->usuario = $usuario;
  }
  public function setDir($perfil) {
    $this->perfil = $perfil;
  }
  public function setConsulta($id){
    require 'includes/main.php';
    if(0< $id){
      $consulta =
        "SELECT
          e.nombres,
          e.app,
          e.apm,
          u.usuario,
          p.nombre,
          e.id_empleado         
        From
          empleados as e
          INNER JOIN usuarios as u ON e.id_empleado = u.id_empleado
          INNER JOIN cat_perfiles as p ON u.id_perfil = p.id
        WHERE
          e.id_empleado = ".$id."
        ;"
      ;
      $query=mysqli_query($conexion,$consulta) or die(mysql_error());
      while($row= mysqli_fetch_assoc($query)){
        $this->id_empleado = $row['id_empleado'];
        $this->nombres = $row['nombres'];
        $this->app = $row['app'];
        $this->apm = $row['apm'];
        $this->usuario = $row['usuario'];
        $this->perfil = $row['nombre'];
      }
    }
  }
}
?>
