<?php
class Ingreso{
  private $id_finanzas_ingresos;
  private $id_cotizacion;
  private $id_cliente;
  private $evento;
  private $no_factura;
  private $fecha;
  private $importe;
  private $iva;
  private $total;
  private $id_estado_ingresos;

  //get
  public function getId() {
    return $this->id_finanzas_ingresos;
  }
  public function getIdCot() {
    return $this->id_cotizacion;
  }
  public function getIdCliente() {
    return $this->id_cliente;
  }
  public function getEvento() {
    return $this->evento;
  }
  public function getNoFactura() {
    return $this->no_factura;
  }
  public function getFecha() {
    return $this->fecha;
  }
  public function getImporte() {
    return $this->importe;
  }
  public function getIva() {
    return $this->iva;
  }
  public function getTotal() {
    return $this->total;
  }
  public function getEstadoIngreso() {
    return $this->id_estado_ingresos;
  }
  // set
  public function setId($id_finanzas_ingresos) {
    $this->id_finanzas_ingresos = $id_finanzas_ingresos;
  }
  public function setIdCot($id_cotizacion) {
    $this->id_cotizacion = $id_cotizacion;
  }
  public function setIdCliente($id_cliente) {
    $this->id_cliente = $id_cliente;
  }
  public function setEvento($evento) {
    $this->evento = $evento;
  }
  public function setNoFactura($no_factura) {
    $this->no_factura = $no_factura;
  }
  public function setFecha($fecha) {
    $this->fecha = $fecha;
  }
  public function setImporte($importe) {
    $this->importe = $importe;
  }
  public function setIva($iva) {
    $this->iva = $iva;
  }
  public function setTotal($total) {
    $this->total = $total;
  }
  public function setEstadoIngreso($id_estado_ingresos) {
    $this->id_estado_ingresos = $id_estado_ingresos;
  }
  public function setConsulta($id){
    require 'includes/main.php';
    $consulta =
      "SELECT
        *
      From
        finanzas_ingresos
      WHERE
        finanzas_ingresos.id_finanzas_ingresos = ".$id."
      ;"
    ;
    $query=mysqli_query($conexion,$consulta) or die(mysql_error());
    while($row= mysqli_fetch_assoc($query)){
      $this->id_finanzas_ingresos = $row['id_finanzas_ingresos'];
      $this->id_cotizacion = $row['id_cotizacion'];
      $this->id_cliente = $row['id_cliente'];
      $this->evento = $row['evento'];
      $this->no_factura = $row['no_factura'];
      $this->fecha = $row['fecha'];
      $this->importe = $row['importe'];
      $this->iva = $row['iva'];
      $this->total = $row['total'];
      $this->id_estado_ingresos = $row['id_estado_ingresos'];
    }
  }
}
?>
