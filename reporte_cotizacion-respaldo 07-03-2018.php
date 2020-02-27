<?php
	session_start();
	require("includes/main.php");
	if($_SESSION['bandera_inicio']!=1){
		header("Location: login.php");
	}
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
	<div style="margin-left:15px; margin-right:45px; padding-top:15px">
		<img src="images/logo.png" style="width:100px; float:right">
		<h3>Cotización de campaña</h3>
		<h1 style="margin-top:40px; text-align:center">TOP MKT<br>COTIZACIÓN</h1>
		<?php
			$consulta =
				'SELECT
					a.id_cotizacion,
					DATE_FORMAT(a.fecha, "%d/%m/%Y") fecha,
					DATE_FORMAT(a.fecha_inicio, "%d/%m/%Y") fecha_inicio,
					DATE_FORMAT(a.fecha_fin, "%d/%m/%Y") fecha_fin,
					a.no_presupuesto,
					a.id_cliente,
					b.nombre as cliente,
					a.id_promocion,
					a.plaza,
					a.id_status,
					c.nombre as status,
					a.carga_social,
					a.comision_ag_per,
          a.desglozado,
          a.dias_capacitacion,
					a.comision_ag_mat,
          a.comision_ag_otros,
          a.comision_ag_degustaciones,
          a.dias_tot_degustaciones,
					a.id_usuario,
					d.nombres,
					d.app,
					d.apm,
					a.id_usuario_2
				FROM
					cotizaciones a
					INNER JOIN cat_clientes b ON b.id = a.id_cliente
					INNER JOIN cat_estado_cotizacion c ON c.id = a.id_status
					INNER JOIN usuarios ON usuarios.id_usuario = a.id_usuario
          INNER JOIN empleados d on d.id_empleado = usuarios.id_empleado
				WHERE a.id_cotizacion =  '.$_GET["id_cotizacion"].' ;'
			;
			$query = mysqli_query($conexion,$consulta) or die(mysql_error());
			$tot_ingresos = 0;
			$subtot = 0;
			$general= "";
			while($row= mysqli_fetch_assoc($query)){
				$subtot=0;
				$general .= "
					<div class='border-bottom'; style='padding-top:15px;'>
						<table style='width:100%;'>
							<tr style='width:100%;'>
								<td style='text-align: right; width: 90%'>Fecha: </td>
								<th>".$row["fecha"]."</th>
							</tr>
						</table>
						<h3>Datos generales</h3>
						<table style='width:100%;'>
							<tr>
								<td style='text-align: right; width:109px'>No. Presupuesto: </td>
								<th>".$row["no_presupuesto"]."</th>
							</tr>
							<tr>
								<td style='text-align: right;'>Cliente: </td>
								<th>".$row["cliente"]."</th>
							</tr>
							<tr>
								<td style='text-align: right;'>Promoción: </td>
								<th>".$row["id_promocion"]."</th>
							</tr>
							<tr>
								<td style='text-align: right;'>Plaza: </td>
								<th>".$row["plaza"]."</th>
							</tr>
							<tr>
								<td style='text-align: right;'>Periodo: </td>
								<th>".$row["fecha_inicio"]." al ".$row["fecha_fin"]."</th>
							</tr>
							<tr>
								<td style='text-align: right;'>Estado:</td>
								<th> ".$row["status"]."</th>
							</tr>
						</table>
					</div>
					<div>
						<h3 style='margin-top:40px'>Datos de personal</h3>
						<table style='width:100%;'>
							<tr>
								<td style='text-align: right;'>Carga social: </td>
								<th>".$row["carga_social"]."%</th>
							</tr>
							<tr>
								<td style='text-align: right;'>Comisión agencia: </td>
								<th>".$row["comision_ag_per"]."%</th>
							</tr>
						</table>
						<div class='border-bottom'>
							<table style='width:100%; padding-top:15px;' >
								<tr>
									<th style='text-align:left;'>Posición</th>
									<th style='text-align:center;'>Sueldo base</th>
									<th style='text-align:center;'>Cuota diaria</th>
									<th style='text-align:center;'>Comisión ag</th>
									<th style='text-align:center;'>Cantidad</th>
									<th style='text-align:center;'>Días</th>
									<th style='text-align:right;'>Total</th>
								</tr>"
							;
							$consulta ='SELECT a.id_cotizacion_personal, a.id_cotizacion, a.id_posicion, b.nombre, a.sueldo_base, a.cantidad, a.dias_laborados FROM cotizacion_personal a INNER JOIN cat_cot_personal b ON b.id = a.id_posicion WHERE a.id_cotizacion = '.$row["id_cotizacion"].';';
							$subquery = mysqli_query($conexion,$consulta) or die(mysql_error());
							$tot_personal = 0;
							while($rowSubquery= mysqli_fetch_assoc($subquery)){
								if ($row["desglozado"]==1) {
									$cuota = $rowSubquery["sueldo_base"]+($rowSubquery["sueldo_base"]*$row["carga_social"]/100)+($rowSubquery["sueldo_base"]*0.1)+($rowSubquery["sueldo_base"]*0.1)+(88.36*0.4);
									$tot_personal += $cuota*$rowSubquery["cantidad"]*$rowSubquery["dias_laborados"];
									$general .=
										"<tr>
											<td style='width:25%; text-align:left; vertical-align: middle'>".$rowSubquery["nombre"]."</td>
											<td style='width:13%; text-align:center; vertical-align: middle'>$ ".number_format($rowSubquery["sueldo_base"], 2, '.', ',')."</td>
											<td style='width:15%; text-align:center; vertical-align: middle'>$ ".number_format($cuota, 2, '.', ',')."</td>
											<td style='width:12%; text-align:center; vertical-align: middle'>$ ".number_format($cuota*($row["comision_ag_per"]/100), 2, '.', ',')."</td>
											<td style='width:9%; text-align:center; vertical-align: middle'>".$rowSubquery["cantidad"]."</td>
											<td style='width:9%; text-align:center; vertical-align: middle'>".$rowSubquery["dias_laborados"]."</td>
											<td style='width:17%; text-align:right; vertical-align: middle'>$ ".number_format(($cuota*$rowSubquery["cantidad"]*$rowSubquery["dias_laborados"])	, 2, '.', ',')."</td>
										</tr>"
									;
								}else {
									$cuota = $rowSubquery["sueldo_base"]*($row["carga_social"]/100+1);
									$tot_personal += $cuota*$rowSubquery["cantidad"]*$rowSubquery["dias_laborados"];
									$general .=
										"<tr>
											<td style='width:25%; text-align:left; vertical-align: middle'>".$rowSubquery["nombre"]."</td>
											<td style='width:13%; text-align:center; vertical-align: middle'>$ ".number_format($rowSubquery["sueldo_base"], 2, '.', ',')."</td>
											<td style='width:15%; text-align:center; vertical-align: middle'>$ ".number_format($cuota, 2, '.', ',')."</td>
											<td style='width:12%; text-align:center; vertical-align: middle'>$ ".number_format($cuota*($row["comision_ag_per"]/100), 2, '.', ',')."</td>
											<td style='width:9%; text-align:center; vertical-align: middle'>".$rowSubquery["cantidad"]."</td>
											<td style='width:9%; text-align:center; vertical-align: middle'>".$rowSubquery["dias_laborados"]."</td>
											<td style='width:17%; text-align:right; vertical-align: middle'>$ ".number_format(($cuota*$rowSubquery["cantidad"]*$rowSubquery["dias_laborados"])	, 2, '.', ',')."</td>
										</tr>"
									;
								}
							}
							$general.=
							"</table>
						</div>
						<div class='border-bottom'>
							<table style='width:100%; padding-top:5px;'>
								<tr>
									<th style='width:30%; text-align:left; '>Sub Total Personal</th>

									<th style='width:40%; text-align:right;'>$ ".number_format($tot_personal	, 2, '.', ',')."</th>
								</tr>
								<tr>
									<th style='width:60%; text-align:left;'>Comisión Agencia</th>
									<th style='width:40%; text-align:right;'>$ ".number_format($tot_personal*$row["comision_ag_per"]/100	, 2, '.', ',')."</th>
								</tr>
							</table>
						</div>
						<table style='width:100%; padding-top:5px;'>
							<tr>
								<th style='width:60%; text-align:left;'>Total Personal Antes de IVA</th>
								<th style='width:40%; text-align:right;'>$ ".number_format($tot_personal*($row["comision_ag_per"]/100+1)	, 2, '.', ',')."</th>
							</tr>
						</table>
					</div>"
				;
				//////////////////////////////////////////
				$consulta = 'SELECT a.id_prestaciones_integrales, a.id_cotizacion, a.id_posicion, b.nombre, a.porcentaje_puntualidad, a.porcentaje_asistencia, a.porcentaje_despensa, a.salario_minimo, c.sueldo_base FROM cotizacion_prestaciones_integrales a INNER JOIN cat_cot_personal b ON a.id_posicion = b.id INNER JOIN cotizacion_personal c ON c.id_cotizacion = a.id_cotizacion WHERE a.id_posicion = c.id_posicion and a.id_cotizacion = '.$row["id_cotizacion"].';';
				$subquery = mysqli_query($conexion,$consulta) or die(mysql_error());
				if (mysqli_num_rows($subquery)>0) {
					$general .=
						"<div style='width:100%;'>
							<h3 style='margin-top:40px'>Datos prestaciones integrales</h3>
							<div class='border-bottom'>
								<table style='width:100%; padding-top:15px;' >
									<tr>
										<th style='text-align:left;'>Posición</th>
										<th style='text-align:center;'>Puntualidad</th>
										<th style='text-align:center;'>Asistencia</th>
										<th style='text-align:center;'>Despensa</th>
									</tr>";
									while($rowSubquery= mysqli_fetch_assoc($subquery)){
										$cuota = $rowSubquery["precio_unitario"];
										$tot_degustaciones += $cuota*$rowSubquery["degustacion_por_dia"];
										$general .=
											"<tr>
												<td style='width:25%; text-align:left; vertical-align: middle'>".$rowSubquery["nombre"]."</td>
												<td style='width:25%; text-align:center; vertical-align: middle'>".$rowSubquery["porcentaje_puntualidad"]."% - $ ".number_format(($rowSubquery["porcentaje_puntualidad"]/100*$rowSubquery["sueldo_base"]), 2, '.', ',')."</td>
												<td style='width:25%; text-align:center; vertical-align: middle'>$ ".$rowSubquery["porcentaje_asistencia"]."% - $ ".number_format(($rowSubquery["porcentaje_asistencia"]/100*$rowSubquery["sueldo_base"]), 2, '.', ',')."</td>
												<td style='width:25%; text-align:center; vertical-align: middle'>".$rowSubquery["porcentaje_despensa"]."% - $ ".number_format(($rowSubquery["porcentaje_despensa"]/100*$rowSubquery["salario_minimo"]), 2, '.', ',')."</td>
											</tr>"
										;
									}
									$general.=
								"</table>
							</div>
						</div>"
					;
				}
				//////////////////////////////////////////
				$general.=
					"<div>
						<h3 style='margin-top:40px'>Prima dominical</h3>
						<table style='width:100%;'>
							<tr>
								<td style='text-align:right;'>Prima dominical: </td>
								<th>25%</th>
							</tr>
						</table>
						<div class='border-bottom'>
							<table style='width:100%; padding-top:15px;' >
								<tr>
									<th style='text-align:left;'>Posición</th>
									<th style='text-align:center;'>Sueldo base</th>
									<th style='text-align:center;'>Cuota diaria</th>
									<th style='text-align:center;'>Comision ag</th>
									<th style='text-align:center;'>Cantidad</th>
									<th style='text-align:center;'>Días</th>
									<th style='text-align:right;'>Total</th>
								</tr>";
								$tot = $tot_personal *($row["comision_ag_per"]/100+1);
								$tot_personal = 0;
								$consulta ='SELECT a.id_prima_dominical, a.id_cotizacion, a.id_posicion, b.nombre, a.sueldo_base, a.dias_laborados, c.cantidad FROM cotizacion_prima_dominical a INNER JOIN cat_cot_personal b ON a.id_posicion = b.id INNER JOIN cotizacion_personal c ON c.id_cotizacion = a.id_cotizacion WHERE a.id_cotizacion = c.id_cotizacion AND a.id_posicion = c.id_posicion AND a.id_cotizacion = '.$row["id_cotizacion"].';';
								$subquery = mysqli_query($conexion,$consulta) or die(mysql_error());
								while($rowSubquery= mysqli_fetch_assoc($subquery)){
									$cuota = $rowSubquery["sueldo_base"]*($row["carga_social"]/100+1);
									$tot_personal += $cuota*$rowSubquery["cantidad"]*$rowSubquery["dias_laborados"];
									$general .=
										"<tr>
											<td style='width:25%; text-align:left; vertical-align: middle'>".$rowSubquery["nombre"]."</td>
											<td style='width:13%; text-align:center; vertical-align: middle'>$ ".number_format($rowSubquery["sueldo_base"], 2, '.', ',')."</td>
											<td style='width:15%; text-align:center; vertical-align: middle'>$ ".number_format($cuota, 2, '.', ',')."</td>
											<td style='width:12%; text-align:center; vertical-align: middle'>$ ".number_format($cuota*($row["comision_ag_per"]/100), 2, '.', ',')."</td>
											<td style='width:9%; text-align:center; vertical-align: middle'>".$rowSubquery["cantidad"]."</td>
											<td style='width:9%; text-align:center; vertical-align: middle'>".$rowSubquery["dias_laborados"]."</td>
											<td style='width:17%; text-align:right; vertical-align: middle'>$ ".number_format($cuota*$rowSubquery["cantidad"]*$rowSubquery["dias_laborados"]	, 2, '.', ',')."</td>
										</tr>"
									;
								}
								$tot += $tot_personal * ($row["comision_ag_per"]/100+1);
								$general.=
							"</table>
						</div>
						<div class='border-bottom'>
							<table style='width:100%; padding-top:5px;'>
								<tr>
									<th style='width:60%; text-align:left;'>Sub Total Prima Dominical</th>
									<th style='width:40%; text-align:right;'>$ ".number_format($tot_personal	, 2, '.', ',')."</th>
								</tr>
								<tr>
									<th style='width:60%; text-align:left;'>Comisión Agencia</th>
									<th style='width:40%; text-align:right;'>$ ".number_format($tot_personal*($row["comision_ag_per"]/100)	, 2, '.', ',')."</th>
								</tr>
							</table>
						</div>
						<table style='width:100%; padding-top:5px;'>
							<tr>
								<th style='width:60%; text-align:left;'>Total Prima Dominical Antes de IVA</th>
								<th style='width:40%; text-align:right;'>$ ".number_format($tot_personal*($row["comision_ag_per"]/100+1)	, 2, '.', ',')."</th>
							</tr>
						</table>
					</div>
					<div style='width:100%;'>
						<h3 style='margin-top:40px'>Datos material</h3>
						<table style='width:100%;'>
							<tr>
								<td style='text-align:right;>Comisión agencia</td>
								<th>".$row["comision_ag_mat"]."%</th>
							</tr>
						</table>
						<div class='border-bottom'>
							<table style='width:100%; padding-top:15px;' >
								<tr>
									<th style='text-align:left;'>Material</th>
									<th style='text-align:center;'>Precio unitario</th>
									<th style='text-align:center;'>Comisión ag</th>
									<th style='text-align:center;'>Cantidad</th>
									<th style='text-align:right;'>Total</th>
								</tr>";
								$consulta = 'SELECT a.id_cotizacion_materiales, a.id_cotizacion, a.id_material, b.nombre, a.precio_unitario, a.cantidad FROM cotizacion_materiales a INNER JOIN cat_cot_mat b ON b.id = a.id_material WHERE a.id_cotizacion = '.$row["id_cotizacion"].';';
								$subquery = mysqli_query($conexion,$consulta) or die(mysql_error());
								$tot_mat = 0;
								while($rowSubquery= mysqli_fetch_assoc($subquery)){
									$cuota = $rowSubquery["precio_unitario"];
									$tot_mat += $cuota*$rowSubquery["cantidad"];
									$general .=
										"<tr>
											<td style='width:20%; text-align:left; vertical-align: middle'>".$rowSubquery["nombre"]."</td>
											<td style='width:23%; text-align:center; vertical-align: middle'>$ ".number_format($rowSubquery["precio_unitario"], 2, '.', ',')."</td>
											<td style='width:25%; text-align:center; vertical-align: middle'>$ ".number_format(($cuota*($row["comision_ag_mat"]/100)), 2, '.', ',')."</td>
											<td style='width:13%; text-align:center; vertical-align: middle'>".number_format($rowSubquery["cantidad"], 0, '.', ',')."</td>
											<td style='width:19%; text-align:right; vertical-align: middle'>$ ".number_format($cuota*$rowSubquery["cantidad"], 2, '.', ',')."</td>
										</tr>"
									;
								}
								$general.=
							"</table>
						</div>
						<div class='border-bottom'>
							<table style='width:100%; padding-top:5px;'>
								<tr>
									<th style='width:60%; text-align:left;'>Sub Total Material</th>
									<th style='width:40%; text-align:right;'>$ ".number_format($tot_mat	, 2, '.', ',')."</th>
								</tr>
								<tr>
									<th style='width:60%; text-align:left;'>Comisión Agencia</th>
									<th style='width:40%; text-align:right;'>$ ".number_format($tot_mat*($row["comision_ag_mat"]/100)	, 2, '.', ',')."</th>
								</tr>
							</table>
						</div>
						<table style='width:100%; padding-top:5px;'>
							<tr>
								<th style='width:60%; text-align:left;'>Total Material Antes de IVA</th>
								<th style='width:40%; text-align:right;'>$ ".number_format($tot_mat*($row["comision_ag_mat"]/100+1)	, 2, '.', ',')."</th>
							</tr>
						</table>
					</div>"
				;
				$tot_mat = $tot_mat*($row["comision_ag_mat"]/100+1);
				//////////////////////////////////////////
				$consulta = 'SELECT a.id_cotizacion_degustacion, a.id_cotizacion, a.id_degustacion, b.nombre, a.degustacion_por_dia, a.precio_unitario FROM cotizacion_degustaciones a INNER JOIN cat_cot_degu b ON a.id_degustacion = b.id WHERE a.id_cotizacion = '.$row["id_cotizacion"].';';
				$subquery = mysqli_query($conexion,$consulta) or die(mysql_error());
				$degustaciones = "";
				$tot_degustaciones = 0;
				if (mysqli_num_rows($subquery)>0) {
					$general .=
						"<div style='width:100%;'>
							<h3 style='margin-top:40px'>Datos degustaciones</h3>
							<table style='width:100%;'>
								<tr>
									<td style='text-align:right;>Comisión de agencia: </td>
									<th>".$row['comision_ag_degustaciones']."%</th>
								</tr>
								<tr>
									<td style='text-align:right;>Días activo: </td>
									<th>".$row['dias_tot_degustaciones']."</th>
								</tr>
							</table>
							<div class='border-bottom'>
								<table style='width:100%; padding-top:15px;' >
									<tr>
										<th style='text-align:left;'>Degustación</th>
										<th style='text-align:center;'>Precio unitario</th>
										<th style='text-align:center;'>Comisión ag</th>
										<th style='text-align:center;'>Cantidad x día</th>
										<th style='text-align:right;'>Total</th>
									</tr>";
									while($rowSubquery= mysqli_fetch_assoc($subquery)){
										$cuota = $rowSubquery["precio_unitario"];
										$tot_degustaciones += $cuota*$rowSubquery["degustacion_por_dia"];
										$general .=
											"<tr>
												<td style='width:20%; text-align:left; vertical-align: middle'>".$rowSubquery["nombre"]."</td>
												<td style='width:23%; text-align:center; vertical-align: middle'>$ ".number_format($rowSubquery["precio_unitario"], 2, '.', ',')."</td>
												<td style='width:25%; text-align:center; vertical-align: middle'>$ ".number_format(($cuota*($row["comision_ag_mat"]/100)), 2, '.', ',')."</td>
												<td style='width:13%; text-align:center; vertical-align: middle'>".number_format($rowSubquery["degustacion_por_dia"], 0, '.', ',')."</td>
												<td style='width:19%; text-align:right; vertical-align: middle'>$ ".number_format($cuota*$rowSubquery["degustacion_por_dia"]*$row['dias_tot_degustaciones'], 2, '.', ',')."</td>
											</tr>"
										;
									}
									$general.=
								"</table>
							</div>
							<div class='border-bottom'>
								<table style='width:100%; padding-top:5px;'>
									<tr>
										<th style='width:60%; text-align:left;'>Sub Total Degustaciones</th>
										<th style='width:40%; text-align:right;'>$ ".number_format($tot_degustaciones*$row['dias_tot_degustaciones']	, 2, '.', ',')."</th>
									</tr>
									<tr>
										<th style='width:60%; text-align:left;'>Comisión Agencia</th>
										<th style='width:40%; text-align:right;'>$ ".number_format($tot_degustaciones*($row["comision_ag_mat"]/100)*$row['dias_tot_degustaciones']	, 2, '.', ',')."</th>
									</tr>
								</table>
							</div>
							<table style='width:100%; padding-top:5px;'>
								<tr>
									<th style='width:60%; text-align:left;'>Total Degustaciones Antes de IVA</th>
									<th style='width:40%; text-align:right;'>$ ".number_format($tot_degustaciones*($row["comision_ag_mat"]/100+1)*$row['dias_tot_degustaciones']	, 2, '.', ',')."</th>
								</tr>
							</table>
						</div>"
					;
					$tot_degustaciones = $tot_degustaciones*($row["comision_ag_otros"]/100+1)*$row['dias_tot_degustaciones'];
					$degustaciones =
						"<tr>
							<th style='width:60%; text-align:left;'>Total Degustaciones</th>
							<th style='width:40%; text-align:right;'>$ ".number_format($tot_degustaciones, 2, '.', ',')."</th>
						</tr>"
					;
				}
				//////////////////////////////////////////
				$consulta = 'SELECT a.id_cotizacion_otros, a.id_cotizacion, a.concepto, a.precio_unitario, a.cantidad FROM cotizacion_otros a WHERE a.id_cotizacion = '.$row["id_cotizacion"].';';
				$subquery = mysqli_query($conexion,$consulta) or die(mysql_error());
				$otros = "";
				$tot_otros = 0;
				if (mysqli_num_rows($subquery)>0) {
					$general .=
						"<div style='width:100%;'>
							<h3 style='margin-top:40px'>Datos otros</h3>
							<table style='width:100%;'>
								<tr>
									<td style='text-align:right;>Comisión de agencia: </td>
									<th>".$row['comision_ag_otros']."%</th>
								</tr>
							</table>
							<div class='border-bottom'>
								<table style='width:100%; padding-top:15px;' >
									<tr>
										<th style='text-align:left;'>Concepto</th>
										<th style='text-align:center;'>Precio unitario</th>
										<th style='text-align:center;'>Comisión ag</th>
										<th style='text-align:center;'>Cantidad</th>
										<th style='text-align:right;'>Total</th>
									</tr>";
									while($rowSubquery= mysqli_fetch_assoc($subquery)){
										$cuota = $rowSubquery["precio_unitario"];
										$tot_otros += $cuota*$rowSubquery["cantidad"];
										$general .=
											"<tr>
												<td style='width:20%; text-align:left; vertical-align: middle'>".$rowSubquery["concepto"]."</td>
												<td style='width:23%; text-align:center; vertical-align: middle'>$ ".number_format($rowSubquery["precio_unitario"], 2, '.', ',')."</td>
												<td style='width:25%; text-align:center; vertical-align: middle'>$ ".number_format(($cuota*($row["comision_ag_mat"]/100)), 2, '.', ',')."</td>
												<td style='width:13%; text-align:center; vertical-align: middle'>".number_format($rowSubquery["cantidad"], 0, '.', ',')."</td>
												<td style='width:19%; text-align:right; vertical-align: middle'>$ ".number_format($cuota*$rowSubquery["cantidad"], 2, '.', ',')."</td>
											</tr>"
										;
									}
									$general.=
								"</table>
							</div>
							<div class='border-bottom'>
								<table style='width:100%; padding-top:5px;'>
									<tr>
										<th style='width:60%; text-align:left;'>Sub Total Material</th>
										<th style='width:40%; text-align:right;'>$ ".number_format($tot_otros	, 2, '.', ',')."</th>
									</tr>
									<tr>
										<th style='width:60%; text-align:left;'>Comisión Agencia</th>
										<th style='width:40%; text-align:right;'>$ ".number_format($tot_otros*($row["comision_ag_mat"]/100)	, 2, '.', ',')."</th>
									</tr>
								</table>
							</div>
							<table style='width:100%; padding-top:5px;'>
								<tr>
									<th style='width:60%; text-align:left;'>Total Otros Antes de IVA</th>
									<th style='width:40%; text-align:right;'>$ ".number_format($tot_otros*($row["comision_ag_mat"]/100+1)	, 2, '.', ',')."</th>
								</tr>
							</table>
						</div>"
					;
					$tot_otros = $tot_otros*($row["comision_ag_otros"]/100+1);
					$otros =
						"<tr>
							<th style='width:60%; text-align:left;'>Total Otros</th>
							<th style='width:40%; text-align:right;'>$ ".number_format($tot_otros, 2, '.', ',')."</th>
						</tr>"
					;
				}
			}
			echo $general;
			$tot_personal = $tot;
		?>
		<div>
			<div class='border-bottom'>
				<h3 style='margin-top:40px'>Totales</h3>
				<table style="width:100%;">
					<tr>
						<th style='width:60%; text-align:left;'>Total Personal</th>
						<th style='width:40%; text-align:right;'>$ <?= number_format($tot_personal, 2, '.', ',') ?></th>
					</tr>
					<tr>
						<th style='width:60%; text-align:left;'>Total Material</th>
						<th style='width:40%; text-align:right;'>$ <?= number_format($tot_mat, 2, '.', ',') ?></th>
					</tr>
					<?= $degustaciones ?>
					<?= $otros ?>
				</table>
			</div>
			<table style="width:100%; padding-top:5px">
				<tr>
					<th style='width:60%; text-align:left;'>Gran Total Antes de IVA</th>
					<th style='width:40%; text-align:right;'>$ <?= number_format($tot_personal+$tot_mat+$tot_otros+$tot_degustaciones, 2, '.', ',') ?></th>
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
