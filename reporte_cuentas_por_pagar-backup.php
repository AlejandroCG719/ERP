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
		width: 100%;
	}
</style>
<page>
	<div style="margin-left:30px; margin-right:30px; padding-top:30px">
		<img src="images/logo.png" style="width:100px; float:right" >
		<h3>Reporte Cuentas Por Pagar </h3>
		<h1 style="margin-top:40px; text-align:center">TOP MKT<br>CUENTAS POR PAGAR</h1>
		<div style="margin-left:60px; margin-right:60px">
				<?php
					$egresos= "";
					$consulta =
						'SELECT
							cat_concepto_pagos.id,
							cat_concepto_pagos.nombre
						FROM cat_concepto_pagos'
					;
					$query = mysqli_query($conexion,$consulta) or die(mysql_error());
					$tot_egresos = 0;
					$subtot=0;
					while($row= mysqli_fetch_assoc($query)){
						$subtot=0;
						$egresos .= "<div class='border-bottom'><h3 style='margin-top:15px'>".$row["nombre"]."</h3><table style='width:100%; padding-left:15px'>";
						$subconsulta =
							'SELECT
								cat_subconcepto_pagos.nombre,
								cat_subconcepto_pagos.id,
								(SELECT
									SUM(finanzas_pagos.monto)
								FROM
									finanzas_pagos
								WHERE
									finanzas_pagos.id_subconcepto_pago = cat_subconcepto_pagos.id
								AND finanzas_pagos.status = 1
								AND finanzas_pagos.fecha_solicitud like "'.$fecha.'%") as monto
							FROM
								finanzas_pagos INNER JOIN cat_subconcepto_pagos ON finanzas_pagos.id_subconcepto_pago = cat_subconcepto_pagos.id
							WHERE
								cat_subconcepto_pagos.valor = '.$row["id"].'
							GROUP BY
								cat_subconcepto_pagos.nombre;'
							;
							$subquery = mysqli_query($conexion,$subconsulta) or die(mysql_error());
							while($row2= mysqli_fetch_assoc($subquery)){
								$egresos .="
									<tr>
									  <th style='width:60%; font-size: 14px; font-weight: 900;'>".$row2["nombre"]."</th>
									  <td style='width:40%; text-align:right; color:red'>$ ".number_format($row2["monto"], 2, '.', ',')."</td>
									</tr>
								";
								$tot_egresos += $row2["monto"];
								$subtot +=  $row2["monto"];
							}
						$egresos .= "</table></div><table style='width:100%; padding-top:5px; padding-left:15px'>
							<tr>
								<th style='width:60%; font-size: 16px; '>Total</th>
								<td style='width:40%; font-size: 14px; text-align:right; color:red; font-weight: bold;'>$ ".number_format($subtot, 2, '.', ',')."</td>
							</tr>
						</table>";
				  }
				 	echo $egresos;
				?>
			<table style="width:100%; padding-top:45px; padding-left:15px">
				<tr>
					<th style='width:60%; font-size: 18px; '>Total Por Pagar</th>
					<td style='width:40%; font-size: 18px; text-align:right; color:red; font-weight: bold;'>$ <?= number_format($tot_egresos, 2, '.', ',') ?></td>
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
	$pdf->Output('reporte_finanzas_gastos.pdf');
?>
