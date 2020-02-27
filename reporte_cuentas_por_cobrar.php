<?php
	session_start();
	include 'includes/main.php';
	if($_SESSION['bandera_inicio']!=1){
		header("Location: login.php");
	}
	ob_start();
	$fecha = date("Y-m");
?>
<style>
	.border-bottom{
		top: 0px;
		margin:0px;
		border-width: 2px;
		border-bottom-width:2px;
		border-bottom-color:black;
		border-bottom-style: solid;
		width: 98%;
	}
</style>
<page>
	<div style="margin-left:15px; margin-right:15px; padding-top:30px">
		<img src="images/logo.png" style="width:100px; float:right" >
		<h3>Reporte Cuentas Por Cobrar</h3>
		<h1 style="margin-top:40px; text-align:center">TOP MKT<br>CUENTAS POR COBRAR</h1>
		<div >
			<?php
				$ingresos= "";
				$ingreso= "";
				$consulta =
					'SELECT
						cat_clientes.id,
						cat_clientes.nombre
					FROM
						cat_clientes;'
				;
				$query = mysqli_query($conexion,$consulta) or die(mysql_error());
				$tot_ingresos = 0;
				$subtot = 0;
				while($row= mysqli_fetch_assoc($query)){
					$subtot=0;
					$ingreso .= "
						<div style='width:98%'>
							<div class='border-bottom'>
								<h3 style='margin-top:15px'>".$row["nombre"]."</h3>
								<table style='width:100%; padding-top:5px; '>
									";
										$subconsulta =
											'SELECT
											  finanzas_ingresos.id_finanzas_ingresos,
											  finanzas_ingresos.evento,
											  finanzas_ingresos.no_factura,
											  finanzas_ingresos.fecha,
											  finanzas_ingresos.importe,
											  finanzas_ingresos.iva,
											  finanzas_ingresos.total
											 FROM
											  finanzas_ingresos
											 WHERE
											  finanzas_ingresos.id_cliente = '.$row["id"].' 	and finanzas_ingresos.id_estado_ingresos=1 or finanzas_ingresos.id_estado_ingresos=2 ;'
										;
										$subquery = mysqli_query($conexion,$subconsulta) or die(mysql_error());
										$ingreso .= "
											<tr>
												<th>Evento</th>
												<th text-align:center;'>No. Fac</th>
												<th text-align:center;'>Fecha</th>
												<th text-align:center;'>Importe</th>
												<th text-align:center;'>Iva</th>
												<th text-align:right;'>Total</th>
											</tr>
										";
										while($row2= mysqli_fetch_assoc($subquery)){
											$ingreso .="
												<tr>
												  <td style='width:30%; vertical-align: middle'>".$row2["evento"]."</td>
												  <td style='width:10%; text-align:center; vertical-align: middle'>".$row2["no_factura"]."</td>
													<td style='width:15%; text-align:center; vertical-align: middle'>".$row2["fecha"]."</td>
													<td style='width:15%; text-align:center; vertical-align: middle'>".number_format($row2["importe"], 2, '.', ',')."</td>
													<td style='width:15%; text-align:center; vertical-align: middle'>".number_format($row2["iva"], 2, '.', ',')."</td>
													<td style='width:15%; text-align:right; vertical-align: middle'>".number_format($row2["total"], 2, '.', ',')."</td>
												</tr>
											";
											$tot_ingresos += $row2["total"];
											$subtot += $row2["total"];
										}
									$ingreso .=
								"</table>
							</div>
							<table style='width:100%; padding-top:5px;'>
							<tr>
								<th style='width:40%; font-size: 14px'>Total</th>
								<td style='width:58%; font-size: 14px; text-align:right; font-weight: bold;'>$ ".number_format($subtot, 2, '.', ',')."</td>
							</tr>
						</table>
						</div>
					";
					if ($subtot == 0) {
						$ingreso = "";
					}else {
						$ingresos.= $ingreso;
					}
				}
			 	echo $ingresos;
			?>
			<table style="width:100%; padding-top:30px">
				<tr>
					<th style='width:60%; font-size: 18px'>Total Por Cobrar</th>
					<td style='width:38%; font-size: 18px; text-align:right; font-weight: bold;'>$ <?= number_format($tot_ingresos, 2, '.', ',') ?></td>
				</tr>
			</table>
		</div>
	</div>
</page>
<?php
	$content = ob_get_clean();
	require ('assets/plugins/html2pdf/html2pdf.class.php');
	$pdf = new HTML2PDF('P', 'A4', 'fr', 'UTF-8');
	$pdf->writeHTML($content);
	$pdf->pdf->IncludeJS('print(TRUE)');
	$pdf->Output('reporte_finanzas_ingresos.pdf');
?>
