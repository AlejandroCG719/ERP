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
.border-bottom
	{
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
		<h3>Reporte de Bancos</h3>
		<h1 style="margin-top:40px; text-align:center">TOP MKT<br>REPORTE DE BANCOS</h1>
		<div style="margin-left:60px; margin-right:60px">
			<div class="border-bottom">
				<h3 style="margin-top:15px">Saldo Inicial</h3>
				<?php
					$consulta =
						'SELECT
							fin_cierres_mes.saldo
						FROM
							fin_cierres_mes
            ORDER BY
							id_cierre_mes DESC
            LIMIT 1';
					$query = mysqli_query($conexion,$consulta) or die(mysql_error());
					$ingresos = '<table style="width:100%; padding-top:15px; padding-left:15px">';
					$tot_ingresos = 0;
					$saldo = 0;
					while($row= mysqli_fetch_assoc($query)){
						$saldo = $row["saldo"];
						if($saldo < 0){
							$textocolor = "color:red";
						}else {
							$textocolor = "";
						}
						$ingresos .= "
							<tr>
							  <th style='width:60%; font-size: 14px'>Saldo</th>
							  <td style='width:40%; text-align:right;".$textocolor."'>$ ".number_format($row["saldo"], 2, '.', ',')."</td>
							</tr>
						";
				  }
				 	$ingresos .= "</table>";
					echo $ingresos;
				?>
			</div>
			<div class="border-bottom">
				<h3 style="margin-top:15px">Ingresos</h3>
				<?php
					$consulta =
						'SELECT
							cat_clientes.id,
							cat_clientes.nombre,
							(SELECT
								SUM(finanzas_ingresos.total)
							FROM
								finanzas_ingresos
							WHERE
								finanzas_ingresos.id_cliente = cat_clientes.id
							AND finanzas_ingresos.id_estado_ingresos=3
							AND finanzas_ingresos.fecha like "'.$fecha.'%" )
							as total
						FROM cat_clientes';
					$query = mysqli_query($conexion,$consulta) or die(mysql_error());
					$ingresos = '<table style="width:100%; padding-top:15px; padding-left:15px">';
					$tot_ingresos = 0;
					while($row= mysqli_fetch_assoc($query)){
						$tot_ingresos += $row["total"];
						$ingresos .= "
							<tr>
							  <th style='width:60%; font-size: 14px'>".$row["nombre"]."</th>
							  <td style='width:40%; text-align:right;'>$ ".number_format($row["total"], 2, '.', ',')."</td>
							</tr>
						";
				  }
				 	$ingresos .= "</table>";
					echo $ingresos;
				?>
			</div>
			<table style="width:100%; padding-top:15px; padding-left:15px">
				<tr>
					<th style='width:60%; font-size: 16px'>Total Ingresos</th>
					<td style='width:40%; text-align:right; font-weight: bold;'>$ <?= number_format($tot_ingresos, 2, '.', ',') ?></td>
				</tr>
			</table>
			<div class="border-bottom">
				<h3 style="margin-top:15px">Egresos</h3>
				<?php
					$consulta =
						'SELECT
								cat_concepto_pagos.id, cat_concepto_pagos.nombre,
								(SELECT
									SUM(finanzas_pago_solicitud.monto)
								FROM
									finanzas_pago_solicitud INNER JOIN finanzas_pagos on finanzas_pago_solicitud.id_pago_solicitud = finanzas_pagos.id_pago_solicitud
								WHERE
									finanzas_pagos.id_concepto_pago = cat_concepto_pagos.id AND finanzas_pago_solicitud.status=3 AND finanzas_pagos.fecha_deposito like "'.$fecha.'%") as total
							FROM cat_concepto_pagos'
					;
					$query = mysqli_query($conexion,$consulta) or die(mysql_error());
					$ingresos = '<table style="width:100%; padding-top:15px; padding-left:15px">';
					$tot_egresos = 0;
					while($row= mysqli_fetch_assoc($query)){
						$tot_egresos += $row["total"];
						$ingresos .= "
							<tr>
							  <th style='width:60%; font-size: 14px'>".$row["nombre"]."</th>
							  <td style='width:40%; text-align:right; color:red;'>$ ".number_format($row["total"], 2, '.', ',')."</td>
							</tr>
						";
				  }
				 	$ingresos .= "</table>";
					echo $ingresos;
				?>
			</div>
			<table style="width:100%; padding-top:15px; padding-left:15px">
				<tr>
					<th style='width:60%; font-size: 16px'>Total Egresos</th>
					<td style='width:40%; text-align:right; color:red; font-weight: bold;'>$ <?= number_format($tot_egresos, 2, '.', ',') ?></td>
				</tr>
			</table>
			<h3 style="margin-top:15px">Total	</h3>
			<div class="border-bottom">
				<table style="width:100%; padding-top:15px; padding-left:15px">
					<tr>
						<th style='width:60%; font-size: 14px'>Saldo</th>
						<td style='width:40%; text-align:right;<?= $textocolor ?>'>$ <?= number_format($saldo, 2, '.', ',') ?></td>
					</tr>
					<tr>
						<th style='width:60%; font-size: 14px;'>Total Ingresos</th>
						<td style='width:40%; text-align:right;'>$ <?= number_format($tot_ingresos, 2, '.', ',') ?></td>
					</tr>
					<tr>
						<th style='width:60%; font-size: 14px'>Total Egresos</th>
						<td style='width:40%; text-align:right;color:red'>$ <?= number_format($tot_egresos, 2, '.', ',') ?></td>
					</tr>
				</table>
			</div>
			<table style="width:100%; padding-top:15px; padding-left:15px">
			<tr>
				<th style='width:60%; font-size: 16px'>Total</th>
				<td style='width:40%; text-align:right; <?= (($tot_ingresos-$tot_egresos+$saldo) < 0) ? 'color:red' : ''; ?>; font-weight: bold;'>$ <?= number_format($tot_ingresos-$tot_egresos+$saldo, 2, '.', ',') ?></td>
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
	$pdf->Output('reporte_finanzas_general.pdf');
?>
