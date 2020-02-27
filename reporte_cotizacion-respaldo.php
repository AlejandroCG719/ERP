<?php
	session_start();
	require("conexion/conexion.php");
	/*
	if($_SESSION['bandera_inicio']!=1){
		header("Location: login.php");
	}
	*/
	ob_start();
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
	<div style="margin-left:15px; margin-right:15px; padding-top:30px">
		<img src="../images/logo.png" style="width:100px; float:right" >
		<h3>Cotización de campaña</h3>
		<h1 style="margin-top:40px; text-align:center">TOP MKT<br>COTIZACIÓN</h1>
		<div >
			<?php
				$consulta =
					'SELECT
						cotizaciones.id_cotizacion,
						cotizaciones.fecha,
						cotizaciones.no_presupuesto,
						cotizaciones.id_cliente,
						cat_clientes.nombrenodo as cliente,
						cotizaciones.id_promocion,
						cotizaciones.plaza,
						cotizaciones.id_status,
						cat_estado_cotizacion.nombrenodo as status,
						cotizaciones.carga_social,
						cotizaciones.comision_ag_per,
						cotizaciones.dias,
						cotizaciones.dias_dom,
						cotizaciones.comision_ag_mat,
						cotizaciones.id_usuario,
						sys_usuarios.nombre,
						sys_usuarios.ap,
						sys_usuarios.am,
						cotizaciones.id_usuario_2
					FROM
						cotizaciones
						INNER JOIN cat_clientes ON cat_clientes.idcf = cotizaciones.id_cliente
						INNER JOIN cat_estado_cotizacion ON cat_estado_cotizacion.idcf = cotizaciones.id_status
						INNER JOIN sys_usuarios ON sys_usuarios.id_usuario = cotizaciones.id_usuario
					WHERE
						cotizaciones.id_cotizacion = 8
					;'
				;
				$query = mysqli_query($conexion,$consulta) or die(mysql_error());
				$tot_ingresos = 0;
				$subtot = 0;
				$general= "";
				while($row= mysqli_fetch_assoc($query)){
					$subtot=0;
					$general .= "
						<div class='border-bottom'>
							<h3 style='margin-top:15px'>Datos generales</h3>
							<table style='width:100%; padding-top:5px;'>
								<tr>
									<th>No. Presupuesto: ".$row["no_presupuesto"]."</th>
								</tr>
								<tr>
									<th style='text-align:center;'>Cliente</th>
								</tr>
								<tr>
									<th style='text-align:center;'>Promoción</th>
								</tr>
								<tr>
									<th style='text-align:center;'>Plaza</th>
								</tr>
								<tr>
									<th style='text-align:center;'>Fecha</th>
								</tr>
								<tr>
									<th style='text-align:center;'>Estado</th>
								</tr>
								<tr>
								  <td style='width:12%; vertical-align: middle'></td>
								  <td style='width:26%; text-align:center; vertical-align: middle'>".$row["cliente"]."</td>
									<td style='width:10%; text-align:center; vertical-align: middle'>".$row["id_promocion"]."</td>
									<td style='width:28%; text-align:center; vertical-align: middle'>".$row["plaza"]."</td>
									<td style='width:10%; text-align:center; vertical-align: middle'>".$row["fecha"]."</td>
									<td style='width:10%; text-align:center; vertical-align: middle'>".$row["status"]."</td>
								</tr>
							</table>
						</div>
						<h3 style='margin-top:15px'>Datos personal</h3>
						<table style='width:100%; padding-top:-30px;'>
							<tr>
								<th></th>
								<th style='text-align:center;'>Carga social</th>
								<th style='text-align:center;'>Comisión agencia</th>
								<th style='text-align:center;'>Días</th>
							</tr>
							<tr>
								<td style='width:53%;'></td>
							  <td style='width:17%; text-align:center; vertical-align: middle'>".$row["carga_social"]."%</td>
							  <td style='width:15%; text-align:center; vertical-align: middle'>".$row["comision_ag_per"]."%</td>
								<td style='width:15%; text-align:center; vertical-align: middle'>".$row["dias"]."</td>
							</tr>
						</table>
						<div class='border-bottom'>
							<table style='width:100%; padding-top:15px;' >
								<tr>
									<th style='text-align:left;'>Posición</th>
									<th style='text-align:center;'>Sueldo base</th>
									<th style='text-align:center;'>Cuota diaria</th>
									<th style='text-align:center;'>Cantidad</th>
									<th style='text-align:right;'>Total</th>
								</tr>";
								$consulta =
									'SELECT
										cotizacion_personal.id_cotizacion_personal,
										cotizacion_personal.id_cotizacion,
										cotizacion_personal.id_posicion,
										cat_cot_personal.nombrenodo,
										cotizacion_personal.sueldo_base,
										cotizacion_personal.cantidad
									FROM
										cotizacion_personal
										INNER JOIN cat_cot_personal on cat_cot_personal.idcf = cotizacion_personal.id_posicion
									WHERE
										cotizacion_personal.id_cotizacion = '.$row["id_cotizacion"].'
									;'
								;
								$subquery = mysqli_query($conexion,$consulta) or die(mysql_error());
								$tot_personal = 0;
								while($rowSubquery= mysqli_fetch_assoc($subquery)){
									$cuota = $rowSubquery["sueldo_base"]*($row["comision_ag_per"]/100+1)*($row["carga_social"]/100+1);
									$tot_personal += $cuota*$rowSubquery["cantidad"]*$row["dias"];
									$general .=
										"<tr>
											<td style='width:20%; text-align:left; vertical-align: middle'>".$rowSubquery["nombrenodo"]."</td>
										  <td style='width:20%; text-align:center; vertical-align: middle'>$ ".number_format($rowSubquery["sueldo_base"], 2, '.', ',')."</td>
											<td style='width:20%; text-align:center; vertical-align: middle'>$ ".number_format($cuota, 2, '.', ',')."</td>
											<td style='width:18%; text-align:center; vertical-align: middle'>".$rowSubquery["cantidad"]."</td>
											<td style='width:20%; text-align:right; vertical-align: middle'>$ ".number_format($cuota*$rowSubquery["cantidad"]*$row["dias"]	, 2, '.', ',')."</td>
										</tr>"
									;
								}
							$general.=
							"</table>
						</div>
						<table style='width:100%; padding-top:5px;'>
							<tr>
								<th style='width:60%; font-size: 14px'>Sub Total Personal</th>
								<td style='width:38%; text-align:right;'>$ ".number_format($tot_personal	, 2, '.', ',')."</td>
							</tr>
						</table>
						<h3 style='margin-top:15px'>Prima dominical</h3>
						<table style='width:100%; padding-top:-30px;'>
							<tr>
								<th></th>
								<th style='text-align:center;'>Prima dominical</th>
								<th style='text-align:center;'>Días</th>
							</tr>
							<tr>
								<td style='width:70%;'></td>
							  <td style='width:15%; text-align:center; vertical-align: middle'>25%</td>
								<td style='width:15%; text-align:center; vertical-align: middle'>".$row["dias_dom"]."</td>
							</tr>
						</table>
						<div class='border-bottom'>
							<table style='width:100%; padding-top:15px;' >
									<tr>
									<th style='text-align:left;'>Posición</th>
									<th style='text-align:center;'>Sueldo base</th>
									<th style='text-align:center;'>Cuota diaria</th>
									<th style='text-align:center;'>Cantidad</th>
									<th style='text-align:right;'>Total</th>
								</tr>";
								$tot = $tot_personal;
								$tot_personal = 0;
								$subquery = mysqli_query($conexion,$consulta) or die(mysql_error());
								while($rowSubquery= mysqli_fetch_assoc($subquery)){
									$cuota = $rowSubquery["sueldo_base"]*($row["comision_ag_per"]/100+1)*($row["carga_social"]/100+1)*.25;
									$tot_personal += $cuota*$rowSubquery["cantidad"]*$row["dias_dom"];
									$general .=
										"<tr>
											<td style='width:20%; text-align:left; vertical-align: middle'>".$rowSubquery["nombrenodo"]."</td>
											<td style='width:20%; text-align:center; vertical-align: middle'>$ ".number_format($rowSubquery["sueldo_base"]*.25, 2, '.', ',')."</td>
											<td style='width:20%; text-align:center; vertical-align: middle'>$ ".number_format($cuota, 2, '.', ',')."</td>
											<td style='width:18%; text-align:center; vertical-align: middle'>".$rowSubquery["cantidad"]."</td>
											<td style='width:20%; text-align:right; vertical-align: middle'>$ ".number_format($cuota*$rowSubquery["cantidad"]*$row["dias_dom"]	, 2, '.', ',')."</td>
										</tr>"
									;
								}
								$tot += $tot_personal;
								$general.=
								"</table>
							</div>
							<table style='width:100%; padding-top:5px;'>
								<tr>
									<th style='width:60%; font-size: 14px'>Sub Total Personal</th>
									<td style='width:38%; text-align:right;'>$ ".number_format($tot_personal	, 2, '.', ',')."</td>
								</tr>
							</table>

							<h3 style='margin-top:15px'>Datos material</h3>
							<table style='width:100%; padding-top:-30px;'>
								<tr>
									<th></th>
									<th style='text-align:center;'>Comisión agencia</th>
								</tr>
								<tr>
									<td style='width:85%;'></td>
								  <td style='width:15%; text-align:center; vertical-align: middle'>".$row["comision_ag_mat"]."%</td>
								</tr>
							</table>
							<div class='border-bottom'>
								<table style='width:100%; padding-top:15px;' >
									<tr>
										<th style='text-align:left;'>Material</th>
										<th style='text-align:right;'>Precio unitario</th>
										<th style='text-align:right;'>Precio + comisión ag</th>
										<th style='text-align:right;'>Cantidad</th>
										<th style='text-align:right;'>Total</th>
									</tr>";
									$consulta =
										'SELECT
											cotizacion_materiales.id_cotizacion_materiales,
											cotizacion_materiales.id_cotizacion,
											cotizacion_materiales.id_material,
											cat_cot_mat.nombrenodo,
											cotizacion_materiales.precio_unitario,
											cotizacion_materiales.cantidad
										FROM
											cotizacion_materiales
											INNER JOIN cat_cot_mat on cat_cot_mat.idcf = cotizacion_materiales.id_material
										WHERE
											cotizacion_materiales.id_cotizacion = '.$row["id_cotizacion"].'
										;'
									;
									$subquery = mysqli_query($conexion,$consulta) or die(mysql_error());
									$tot_mat = 0;
									while($rowSubquery= mysqli_fetch_assoc($subquery)){
										$cuota = $rowSubquery["precio_unitario"]*($row["comision_ag_mat"]/100+1);
										$tot_mat += $cuota*$rowSubquery["cantidad"];
										$general .=
											"<tr>
												<td style='width:20%; text-align:left; vertical-align: middle'>".$rowSubquery["nombrenodo"]."</td>
											  <td style='width:20%; text-align:right; vertical-align: middle'>$ ".number_format($rowSubquery["precio_unitario"], 2, '.', ',')."</td>
												<td style='width:20%; text-align:right; vertical-align: middle'>$ ".number_format($cuota, 2, '.', ',')."</td>
												<td style='width:18%; text-align:right; vertical-align: middle'>".number_format($rowSubquery["cantidad"], 0, '.', ',')."</td>
												<td style='width:20%; text-align:right; vertical-align: middle'>$ ".number_format($cuota*$rowSubquery["cantidad"], 2, '.', ',')."</td>
											</tr>"
										;
									}
								$general.=
								"</table>
							</div>
							<table style='width:100%; padding-top:5px;'>
								<tr>
									<th style='width:60%; font-size: 14px'>Sub Total Material</th>
									<td style='width:38%; text-align:right;'>$ ".number_format($tot_mat	, 2, '.', ',')."</td>
								</tr>
							</table>


					";

					/*
					*/
				}
				echo $general;
				$tot_personal = $tot;

				/**/

				/**/
			?>
			<div class='border-bottom'>
				<table style="width:100%; padding-top:30px">
					<tr>
						<th style='width:60%; font-size: 14px'>Total Personal</th>
						<td style='width:38%; text-align:right;'>$ <?= number_format($tot_personal, 2, '.', ',') ?></td>
					</tr>
					<tr>
						<th style='width:60%; font-size: 14px'>Total Material</th>
						<td style='width:38%; text-align:right;'>$ <?= number_format($tot_mat, 2, '.', ',') ?></td>
					</tr>
				</table>
			</div>
			<table style="width:100%; padding-top:30px">
				<tr>
					<th style='width:60%; font-size: 14px'>Total Final</th>
					<td style='width:38%; text-align:right;'>$ <?= number_format($tot_personal+$tot_mat, 2, '.', ',') ?></td>
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
