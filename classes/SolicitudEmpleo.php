<?php
class SolicitudEmpleo{
  private $id_solicitud_empleo;
  private $fecha;
  private $puesto;
  private $sueldo_bruto;
  private $nombre;
  private $app;
  private $apm;
  private $fecha_nac;
  private $id_estado_nac;
  private $id_municipio_nac;
  private $id_estado_civil;
  private $id_estado_dir;
  private $id_municipio_dir;
  private $calle;
  private $colonia;
  private $cp;
  private $antiguedad;
  private $sexo;
  private $nss;
  private $rfc;
  private $curp;
  private $email;
  private $tel_cel;
  private $tel_casa;
  private $num_int_ext;
  private $talla;
  private $hijos;
  private $enfermedades_cronicas;
  private $med_tratamiento;
  private $op_quirurgicas;
  private $alergias_padecimientos;
  private $tipo_sangre;
  private $contacto_emergencia;
  private $emergencia_tel;
  private $id_grado_estudios;
  private $escuela;
  private $periodo;
  private $titulo;
  private $software;
  private $tipo_smartphone;
  private $nivel_software;
  private $referencia_nombre_1;
  private $referencia_nombre_2;
  private $referencia_tel_1;
  private $referencia_tel_2;
  private $parentesco_1;
  private $parentesco_2;
  private $eAnterior_empresa;
  private $eAnterior_fecha_ingreso;
  private $eAnterior_puesto;
  private $eAnterior_jefe;
  private $eAnterior_tel;
  private $eAnterior_fecha_salida;
  private $eAnterior_motivo_salida;
  private $eAnterior_puesto_jefe;
  private $ext;
  private $status;
  //get
  public function getId() {
    return $this->id_solicitud_empleo;
  }
  public function getFecha() {
    return $this->fecha;
  }

  public function getPuesto() {
    return $this->puesto;
  }
  public function getSueldoBruto() {
    return $this->sueldo_bruto;
  }
  public function getNombre() {
    return $this->nombre;
  }
  public function getApp() {
    return $this->app;
  }
  public function getApm() {
    return $this->apm;
  }
  public function getFechaNac() {
    return $this->fecha_nac;
  }
  public function getEstadoNac() {
    return $this->id_estado_nac;
  }
  public function getMunicipioNac() {
    return $this->id_municipio_nac;
  }
  public function getEstadoCivil() {
    return $this->id_estado_civil;
  }
  public function getEstadoDir() {
    return $this->id_estado_dir;
  }
  public function getMunicipioDir() {
    return $this->id_municipio_dir;
  }
  public function getCalle() {
    return $this->calle;
  }
  public function getColonia() {
    return $this->colonia;
  }
  public function getCP() {
    return $this->cp;
  }
  public function getAntiguedad() {
    return $this->antiguedad;
  }
  public function getSexo() {
    return $this->sexo;
  }
  public function getNSS() {
    return $this->nss;
  }
  public function getRFC() {
    return $this->rfc;
  }
  public function getCurp() {
    return $this->curp;
  }
  public function getEmail() {
    return $this->email;
  }
  public function getTelCel() {
    return $this->tel_cel;
  }
  public function getTelCasa() {
    return $this->tel_casa;
  }
  public function getNumIntExt() {
    return $this->num_int_ext;
  }
  public function getTalla() {
    return $this->talla;
  }
  public function getHijos() {
    return $this->hijos;
  }
  public function getEnfermedadesCronicas() {
    return $this->enfermedades_cronicas;
  }
  public function getMedTratamientos() {
    return $this->med_tratamiento;
  }
  public function getOpQuirurgicas() {
    return $this->op_quirurgicas;
  }
  public function getAlergiasPadecimientos() {
    return $this->alergias_padecimientos;
  }
  public function getTipoSangre() {
    return $this->tipo_sangre;
  }
  public function getContactoEmergencia() {
    return $this->contacto_emergencia;
  }
  public function getEmergenciaTel() {
    return $this->emergencia_tel;
  }
  public function getGradoEstudios() {
    return $this->id_grado_estudios;
  }
  public function getEscuela() {
    return $this->escuela;
  }
  public function getPeriodo() {
    return $this->periodo;
  }
  public function getTitulo() {
    return $this->titulo;
  }
  public function getSoftware() {
    return $this->software;
  }
  public function getTipoSmartphone() {
    return $this->tipo_smartphone;
  }
  public function getNivelSoftware() {
    return $this->nivel_software;
  }
  public function getRefNom1() {
    return $this->referencia_nombre_1;
  }
  public function getRefNom2() {
    return $this->referencia_nombre_2;
  }
  public function getRefTel1() {
    return $this->referencia_tel_1;
  }
  public function getRefTel2() {
    return $this->referencia_tel_2;
  }
  public function getParentesco1() {
    return $this->parentesco_1;
  }
  public function getParentesco2() {
    return $this->parentesco_2;
  }
  public function getEAnteriorEmpresa() {
    return $this->eAnterior_empresa;
  }
  public function getEAnteriorFechaIngreso() {
    return $this->eAnterior_fecha_ingreso;
  }
  public function getEAnteriorPuesto() {
    return $this->eAnterior_puesto;
  }
  public function getEAnteriorJefe() {
    return $this->eAnterior_jefe;
  }
  public function getEAnteriorTel() {
    return $this->eAnterior_tel;
  }
  public function getEAnteriorFechaSalida() {
    return $this->eAnterior_fecha_salida;
  }
  public function getEAnteriorMotivoSalida() {
    return $this->eAnterior_motivo_salida;
  }
  public function getEAnteriorPuestoJefe() {
    return $this->eAnterior_puesto_jefe;
  }
  public function getExt() {
    return $this->ext;
  }
  public function getStatus() {
    return $this->status;
  }
  // set
  /*
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
  */
  public function setConsulta($id){
    require 'includes/main.php';
    if(0< $id){
      $consulta =
        "SELECT
          *
        From
          solicitud_empleo
        WHERE
          solicitud_empleo.id_solicitud_empleo = ".$id."
        ;"
      ;
      $query=mysqli_query($conexion,$consulta) or die(mysql_error());
      while($row= mysqli_fetch_assoc($query)){
        $this->fecha = $row['fecha'];
        $this->id_solicitud_empleo = $row['id_solicitud_empleo'];
        $this->puesto = $row['puesto'];
        $this->sueldo_bruto = $row['sueldo_bruto'];
        //datos personales
        $this->nombre = $row['nombre'];
        $this->app = $row['app'];
        $this->apm = $row['apm'];
        $this->fecha_nac = $row['fecha_nac'];
        $this->id_estado_nac = $row['id_estado_nac'];
        $this->id_municipio_nac = $row['id_municipio_nac'];
        $this->id_estado_civil = $row['id_estado_civil'];
        $this->id_estado_dir = $row['id_estado_dir'];
        $this->id_municipio_dir = $row['id_municipio_dir'];
        $this->calle = $row['calle'];
        $this->colonia = $row['colonia'];
        $this->cp = $row['cp'];
        $this->antiguedad = $row['antiguedad'];
        $this->sexo = $row['sexo'];
        $this->nss = $row['nss'];
        $this->rfc = $row['rfc'];
        $this->curp = $row['curp'];
        $this->email = $row['email'];
        $this->tel_cel = $row['tel_cel'];
        $this->tel_casa = $row['tel_casa'];
        $this->num_int_ext = $row['num_int_ext'];
        $this->talla = $row['talla'];
        $this->hijos = $row['hijos'];
        // info medica
        $this->enfermedades_cronicas = $row['enfermedades_cronicas'];
        $this->med_tratamiento = $row['med_tratamiento'];
        $this->op_quirurgicas = $row['op_quirurgicas'];
        $this->alergias_padecimientos = $row['alergias_padecimientos'];
        $this->tipo_sangre = $row['tipo_sangre'];
        $this->contacto_emergencia = $row['contacto_emergencia'];
        $this->emergencia_tel = $row['emergencia_tel'];
        // Estudios
        $this->id_grado_estudios = $row['id_grado_estudios'];
        $this->escuela = $row['escuela'];
        $this->periodo = $row['periodo'];
        $this->titulo = $row['titulo'];
        //otros
        $this->software = $row['software'];
        $this->tipo_smartphone = $row['tipo_smartphone'];
        $this->nivel_software = $row['nivel_software'];
        // referencias
        $this->referencia_nombre_1 = $row['referencia_nombre_1'];
        $this->referencia_nombre_2 = $row['referencia_nombre_2'];
        $this->referencia_tel_1 = $row['referencia_tel_1'];
        $this->referencia_tel_2 = $row['referencia_tel_2'];
        $this->parentesco_1 = $row['parentesco_1'];
        $this->parentesco_2 = $row['parentesco_2'];
        //empleo anterior
        $this->eAnterior_empresa = $row['eAnterior_empresa'];
        $this->eAnterior_fecha_ingreso = $row['eAnterior_fecha_ingreso'];
        $this->eAnterior_puesto = $row['eAnterior_puesto'];
        $this->eAnterior_jefe = $row['eAnterior_jefe'];
        $this->eAnterior_tel = $row['eAnterior_tel'];
        $this->eAnterior_fecha_salida = $row['eAnterior_fecha_salida'];
        $this->eAnterior_motivo_salida = $row['eAnterior_motivo_salida'];
        $this->eAnterior_puesto_jefe = $row['eAnterior_puesto_jefe'];
        $this->ext = $row['ext'];
        $this->status = $row['status'];
      }
    }
  }
}
?>
