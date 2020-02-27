<?php
class Usuario{
  private $id_usuario;
  private $usuario;
  private $estado;
  private $id_perfil;
  private $id_empleado;

  //get
  public function getId() {
    return $this->id_usuario;
  }
  public function getUsuario() {
    return $this->usuario;
  }
  public function getEstado() {
    return $this->estado;
  }
  public function getPerfil() {
    return $this->id_perfil;
  }
  public function getEmpleado() {
    return $this->id_empleado;
  }

  // set
  public function setId($id_usuario) {
    $this->id_usuario = $id_usuario;
  }
  public function setUsuario($usuario) {
    $this->usuario = $usuario;
  }
  public function setEstado($estado) {
    $this->estado = $estado;
  }
  public function setPerfil($id_perfil) {
    $this->id_perfil = $id_perfil;
  }
  public function setEmpleado($id_empleado) {
    $this->id_empleado = $id_empleado;
  }
  public function setConsulta($id){
    require 'includes/main.php';
    if(0< $id){
      $consulta =
        "SELECT
          *
        From
          usuarios
        WHERE
          usuarios.id_usuario = ".$id."
        ;"
      ;
      $query=mysqli_query($conexion,$consulta) or die(mysql_error());
      while($row= mysqli_fetch_assoc($query)){
        $this->id_usuario = $row['id_usuario'];
        $this->usuario = $row['usuario'];
        $this->estado = $row['estado'];
        $this->id_perfil = $row['id_perfil'];
        $this->id_empleado = $row['id_empleado'];
      }
    }
  }
}
?>
