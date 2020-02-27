<?php
class Pago{
  private $id_pago_solicitud;
  private $fecha;
  private $plaza;
  private $solicitante;
  private $folio;
  private $monto;
  private $monto_letra;
  private $id_banco;
  private $cuenta_deposito;
  private $beneficiario;
  private $id_promocion;
  private $id_cotizacion;
  private $concepto;
  private $status;
  // datos segunda seccion (datos del pago)
  private $id_finanzas_pago;
  private $fecha_deposito;
  private $referencia;
  private $id_concepto_pago;
  private $id_subconcepto_pago;
  private $observaciones;
  private $num_pagos;


  //get
  public function getIdPagoSolicitud() {
    return $this->id_pago_solicitud;
  }
  public function getFechaSolicitud() {
    return $this->fecha;
  }
  public function getPlaza() {
    return $this->plaza;
  }
  public function getSolicitante() {
    return $this->solicitante;
  }
  public function getFolio() {
    return $this->folio;
  }
  public function getMonto() {
    return $this->monto;
  }
  public function getMontoLetra() {
    return $this->monto_letra;
  }
  public function getIdBanco() {
    return $this->id_banco;
  }
  public function getCuentaDeposito() {
    return $this->cuenta_deposito;
  }
  public function getBeneficiario() {
    return $this->beneficiario;
  }
  public function getPromocion() {
    return $this->id_promocion;
  }
  public function getCotizacion() {
    return $this->id_cotizacion;
  }
  public function getConcepto() {
    return $this->concepto;
  }
  public function getStatus() {
    return $this->status;
  }
  // gets segunda seccion (datos forma de pago)
  public function getIdFinanzaPgo() {
    return $this->id_finanzas_pago;
  }
  public function getFechaDeposito() {
    return $this->fecha_deposito;
  }
  public function getReferencia() {
    return $this->referencia;
  }
  public function getIdConceptoPago() {
    return $this->id_concepto_pago;
  }
  public function getIdSubconceptoPago() {
    return $this->id_subconcepto_pago;
  }
  public function getObservaciones() {
    return $this->observaciones;
  }
  public function getNumPagos() {
    return $this->num_pagos;
  }
  // set
  public function setId($id_pago_solicitud) {
    $this->id_pago_solicitud = $id_pago_solicitud;
  }
  public function setFechaSolicitud($fecha) {
    $this->fecha = $fecha;
  }
  public function setPlaza($plaza) {
    $this->plaza = $plaza;
  }
  public function setSolicitante($solicitante) {
    $this->solicitante = $solicitante;
  }
  public function setFolio($folio) {
    $this->folio = $folio;
  }
  public function setMonto($monto) {
    $this->monto = $monto;
  }
  public function setMontoLetra($monto_letra) {
    $this->monto = $monto_letra;
  }
  public function setBanco($id_banco) {
    $this->id_banco = $id_banco;
  }
  public function setCuentaDeposito($cuenta_deposito) {
    $this->cuenta_deposito = $cuenta_deposito;
  }
  public function setBeneficiario($beneficiario) {
    $this->beneficiario = $beneficiario;
  }
  public function setPromocion($promocion) {
    $this->promocion = $promocion;
  }
  public function setCotizacion($id_cotizacion) {
    $this->id_cotizacion = $id_cotizacion;
  }
  public function setConcepto($concepto) {
    $this->concepto = $concepto;
  }
  public function setStatus($status) {
    $this->status = $status;
  }
  // set segunda seccion (datos forma de pago)
  public function setIdFinanzaPgo($id_finanzas_pago) {
    $this->id_finanzas_pago = $id_finanzas_pago;
  }
  public function setFechaDeposito($fecha_deposito) {
    $this->fecha_deposito = $fecha_deposito;
  }
  public function setReferencia($referencia) {
    $this->referencia = $referencia;
  }
  public function setIdConceptoPago($id_concepto_pago) {
    $this->id_concepto_pago = $id_concepto_pago;
  }
  public function setIdSubconceptoPago($id_subconcepto_pago) {
    $this->id_subconcepto_pago = $id_subconcepto_pago;
  }
  public function setObservaciones($observaciones) {
    $this->observaciones = $observaciones;
  }
  public function setNumPagos($num_pagos) {
    $this->num_pagos = $num_pagos;
  }
  public function setConsulta($id){
    require 'includes/main.php';
    $consulta =
      "SELECT
        a.id_pago_solicitud,
        a.fecha,
        a.plaza,
        a.solicitante,
        a.folio,
        a.monto,
        a.monto_letra,
        a.id_banco,
        a.cuenta_deposito,
        a.beneficiario,
        a.id_promocion,
        b.nombre,
        a.id_cotizacion,
        c.no_presupuesto,
        a.concepto,
        a.status,
        d.nombre,
        e.id_finanzas_pago,
        e.fecha_deposito,
        e.referencia,
        e.id_concepto_pago,
        e.id_subconcepto_pago,
        e.observaciones,
        (SELECT COUNT(id_pago_solicitud) FROM finanzas_pagos_transacciones WHERE id_pago_solicitud = ".$id.") num_pagos
      FROM
        finanzas_pago_solicitud a
        INNER JOIN cat_promociones b ON a.id_promocion = b.id
        INNER JOIN cotizaciones c ON a.id_cotizacion = c.id_cotizacion
        INNER JOIN cat_estado_pagos d ON a.status = d.id
        LEFT JOIN finanzas_pagos e ON a.id_pago_solicitud = e.id_pago_solicitud
      WHERE
        a.id_pago_solicitud = ".$id."
      ;"
    ;
    $query=mysqli_query($conexion,$consulta) or die(mysql_error());
    while($row= mysqli_fetch_assoc($query)){
      $this->id_pago_solicitud = $row['id_pago_solicitud'];
      $this->fecha = $row['fecha'];
      $this->plaza = $row['plaza'];
      $this->solicitante = $row['solicitante'];
      $this->folio = $row['folio'];
      $this->monto = $row['monto'];
      $this->monto_letra = $row['monto_letra'];
      $this->id_banco = $row['id_banco'];
      $this->cuenta_deposito = $row['cuenta_deposito'];
      $this->beneficiario = $row['beneficiario'];
      $this->id_promocion = $row['id_promocion'];
      $this->id_cotizacion = $row['id_cotizacion'];
      $this->concepto = $row['concepto'];
      $this->status = $row['status'];
      $this->id_finanzas_pago = $row['id_finanzas_pago'];
      $this->fecha_deposito = $row['fecha_deposito'];
      $this->referencia = $row['referencia'];
      $this->id_concepto_pago = $row['id_concepto_pago'];
      $this->id_subconcepto_pago = $row['id_subconcepto_pago'];
      $this->observaciones = $row['observaciones'];
      $this->num_pagos = $row['num_pagos'];
    }
  }
}
?>
