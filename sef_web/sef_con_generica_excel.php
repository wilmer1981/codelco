<?
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	include("../principal/conectar_sef_web.php");	
	$FechaIni = $AnoIni."-".str_pad($MesIni,2,0,STR_PAD_LEFT)."-".str_pad($DiaIni,2,0,STR_PAD_LEFT);
	$FechaFin = $AnoFin."-".str_pad($MesFin,2,0,STR_PAD_LEFT)."-".str_pad($DiaFin,2,0,STR_PAD_LEFT);
	$Periodo = str_pad($DiaIni,2,0,STR_PAD_LEFT)."-".str_pad($MesIni,2,0,STR_PAD_LEFT)."-".$AnoIni;
	$Periodo.= " AL ".str_pad($DiaFin,2,0,STR_PAD_LEFT)."-".str_pad($MesFin,2,0,STR_PAD_LEFT)."-".$AnoFin;
	switch ($TipoInforme)
	{
		case 1:
			$TituloInforme = "PRODUCCION BLISTER";
			$ProductoSef = "= '7'";
			$EquipoSef = "in(7,8,9)";
			$Origen = "in(7,8,9)";
			$Destino = "= '3'";
			$Movimiento = "S";
			$CodProducto = 16;
			$CodSubproducto = 41; 
			break;
		case 2:
			$TituloInforme = "CARGA FRIA A CONVERTIDOR PIERCE SMITH";
			$ProductoSef = "= '8'";
			$EquipoSef = "in(7,8,9)";
			$Origen = "= '10'";
			$Destino = "in(7,8,9)";
			$Movimiento = "E";
			$CodProducto = 42;
			$CodSubproducto = 6; 	
			break;
		case 3:
			$TituloInforme = "ESCORIA DE RETORNO CPS A POZO";
			$ProductoSef = "= '6'";
			$EquipoSef = "in(7,8,9)";
			$Origen = "in(7,8,9)";
			$Destino = " ='11'";
			$Movimiento = "S";
			$CodProducto = 0;
			$CodSubproducto = 0; 	
			break;
		case 4:
			$TituloInforme = "METAL BLANCO CONVERTIDOR TENIENTE A CONVERTIDOR PIERCE SMITH";
			$ProductoSef = "= '5'";
			$EquipoSef = "= '5'";
			$Origen = "= '5'";
			$Destino = "= '6'";
			$Movimiento = "S";
			$CodProducto = 23;
			$CodSubproducto = 2; 			
			break;
		case 5:
			$TituloInforme = "ESCORIA RETORNO CONVERTIDOR TENIENTE A HORNO ELECTRICO";
			$ProductoSef = "= '6'";
			$EquipoSef = "= '2'";
			$Origen = "= '5'";
			$Destino = "= '2'";
			$Movimiento = "E";
			$CodProducto = 22;
			$CodSubproducto = 2; 	
			break;
		case 6:
			$TituloInforme = "ESCORIA HORNO ELECTRICO A BOTADERO";
			$ProductoSef = "= '6'";
			$EquipoSef = "= '2'";
			$Origen = "= '2'";
			$Destino = "= '11'";
			$Movimiento = "S";
			$CodProducto = 22;
			$CodSubproducto = 1; 	
			break;
		case 7:
			$TituloInforme = "METAL BLANCO HORNO ELECTRICO A CONVERTIDOR PIERCE SMITH";
			$ProductoSef = "= '5'";
			$EquipoSef = "= '2'";
			$Origen = "= '2'";
			$Destino = "= '6'";
			$Movimiento = "S";
			$CodProducto = 23;
			$CodSubproducto = 1; 	
			break;
		case 8:
			$TituloInforme = "METAL BLANCO HORNO ELECTRICO A CONVERTIDOR TENIENTE";
			$ProductoSef = "= '5'";
			$EquipoSef = "= '5'";
			$Origen = "= '2'";
			$Destino = "= '5'";
			$Movimiento = "E";
			$CodProducto = 23;
			$CodSubproducto = 1; 	
			break;
		case 9:
			$TituloInforme = "ESCORIA Y METAL BLANCO HORNO ELECTRICO A POZO";
			$ProductoSef = "in(5,6)";
			$EquipoSef = "= '2'";
			$Origen = "= '2'";
			$Destino = "= '10'";
			$Movimiento = "S";
			$CodProducto = 23;
			$CodSubproducto = 1; 	
			break;
	}
	//PESO BASE
	$Consulta = "SELECT * from sef.producto_por_equipo ";
	if ($EquipoSef == "in(7,8,9)")	
		$Consulta.= " where cod_equipo = '6' ";
	else
		$Consulta.= " where cod_equipo ".$EquipoSef." ";
	$Consulta.= "and cod_producto ".$ProductoSef;
	$Respuesta = mysql_query($Consulta);
	$PesoBase = 0;
	if ($Fila = mysql_fetch_array($Respuesta))
		$PesoBase = $Fila["Peso_base"];
	//LEYES
	include("../principal/cerrar_sef_web.php");
	include("../principal/conectar_principal.php");
	$ArrLeyes = array();
	$Consulta = "SELECT distinct t1.cod_leyes, t3.abreviatura ";
	$Consulta.= " from cal_web.leyes_por_solicitud t1 inner join cal_web.solicitud_analisis t2 ";
	$Consulta.= " on t1.nro_solicitud = t2.nro_solicitud and t1.recargo = t2.recargo ";
	$Consulta.= " inner JOIN proyecto_modernizacion.leyes t3 on t1.cod_leyes = t3.cod_leyes ";
	$Consulta.= " where (t2.cod_producto = '".$CodProducto."' and t2.cod_subproducto = '".$CodSubproducto."') ";
	$Consulta.= " and t2.tipo = '1'";
	$Consulta.= " and t2.cod_analisis = '1' ";
	if ($VerTodosPeriodos=="S")
	{
		$Consulta.= " and t2.cod_periodo in(1,2,3,4)";
	}
	else
	{
		$Consulta.= " and (";
		if ($VerTurno=="S")
			$Consulta.= "t2.cod_periodo = '4' or ";
		if ($VerDiario=="S")
			$Consulta.= "t2.cod_periodo = '1' or ";
		if ($VerSemanal=="S")
			$Consulta.= "t2.cod_periodo = '2' or ";
		if ($VerMensual=="S")
			$Consulta.= "t2.cod_periodo = '3' or ";
		$Consulta = substr($Consulta,0,strlen($Consulta)-3);
		$Consulta.= ")";
	}			 
	$Consulta.= " and ((month(t2.fecha_muestra) >= '".$MesIni."' and year(t2.fecha_muestra) >= '".$AnoIni."')";
	$Consulta.= " and (month(t2.fecha_muestra) <= '".$MesFin."' and year(t2.fecha_muestra) <= '".$AnoFin."'))";
	if ($VerTodosAnalisis!="S")
	{	
		if ($VerLeyes=="S")
		{
			$Consulta.= " and (t1.cod_leyes = '02' or t1.cod_leyes = '04' or t1.cod_leyes = '05')";
		}
		else
		{
			if ($VerImpurezas=="S")
			{
				$Consulta.= " and (t1.cod_leyes <> '02' and t1.cod_leyes <> '04' and t1.cod_leyes <> '05')";
			}		
		}
	}
	$Consulta.= " and (t1.valor <> '' and NOT isnull(t1.valor))";
	$Consulta.= " order by t1.cod_leyes";
	$Respuesta = mysql_query($Consulta);
	while ($Fila = mysql_fetch_array($Respuesta))
	{
		$ArrLeyes[$Fila["cod_leyes"]][0] = $Fila["cod_leyes"];
		$ArrLeyes[$Fila["cod_leyes"]][1] = $Fila["abreviatura"];
		$ArrLeyes[$Fila["cod_leyes"]][2] = "";
	}
	include("../principal/cerrar_principal.php");
	include("../principal/conectar_sef_web.php");
	if ($ChkLeyes=="S" && $ChkFinos=="S")
	{
		$LargoTabla = 300 + ((count($ArrLeyes)*50)*2);
	}
	else
	{
		if ($ChkLeyes=="S" || $ChkFinos=="S")
		{
			$LargoTabla = 300 + (count($ArrLeyes)*50);
		}
		else
		{
			$LargoTabla = 300;
		}
	}	
?>
<html>
<head>
<title>Informes SEF</title>
<script language="javascript">
function Proceso(o)
{	
	var f = document.frmPrincipal;
	switch (o)
	{
		case "I":
			f.BtnImprimir.style.visibility = 'hidden';
			f.BtnSalir.style.visibility = 'hidden';
			f.BtnImprimir.style.visibility = '';
			f.BtnSalir.style.visibility = '';
			window.print();
			break;
		case "S":
			f.action = "sef_con_generica.php";
			f.submit();
			break;
	}
}
function Historial(SA)
{
	window.open("../cal_web/cal_con_registro_leyes.php?SA="+ SA,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}

</script>
</head>

<body>
<form name="frmPrincipal" action="" method="post">
<table width="700" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
  <tr>
    <td width="76" colspan="2">Informe</td>
    <td width="307" colspan="7"><? echo $TituloInforme; ?></td>
  </tr>
  <tr>
    <td colspan="2">Periodo</td>
    <td colspan="7"><? echo $Periodo; ?></td>
  </tr>
  <tr>
    <td colspan="2">Peso Olla </td>
    <td colspan="7"><? echo number_format($PesoBase,0,",","."); ?></td>
  </tr>
</table>
<br>
<table width="<? echo $LargoTabla; ?>" border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr align="center" class="ColorTabla01">
    <td rowspan="2"><strong>Fecha</strong></td>
    <td rowspan="2"><strong>
<?
	if ($TipoInforme == 1 || $TipoInforme == 2 || $TipoInforme == 3)
		echo "Carga";
	else
		echo "Turno";
?></strong></td>
    <td rowspan="2"><strong>N&ordm; Ollas </strong></td>
    <td rowspan="2"><strong>P.Seco [Kg] </strong></td>
<?
	if ($ChkLeyes == "S")
	    echo "<td colspan='".(count($ArrLeyes) + 1)."'><strong>Leyes</strong></td>\n";
	if ($ChkFinos == "S")
	    echo "<td colspan='".(count($ArrLeyes) + 1)."'><strong>Finos</strong></td>\n";		
?>	
  </tr>
  <tr align="center" class="ColorTabla01">
  <td align="center" >#SA</td>
<?  
	if ($ChkLeyes == "S")
	{
		reset($ArrLeyes);
		foreach($ArrLeyes as $k => $v)
		{
			echo "<td>".$v[1]."</td>\n";
		}
	}
	if ($ChkFinos == "S")
	{
		reset($ArrLeyes);
		foreach($ArrLeyes as $k => $v)
		{
			echo "<td>".$v[1]."</td>\n";
		}
	}
?>	
  </tr>
<?  
	
	$FechaAux = $FechaIni;
	$ContSemanas = 1;
	while (date($FechaAux)<=date($FechaFin))
	{		
		$DatosSemanales = false;
		include("../principal/conectar_sef_web.php");			
		$ArrSef = array();
		$Consulta = "SELECT Fecha, Cod_equipo, Turno, Num_carga, Cod_producto, Cod_movimiento, ";
		$Consulta.= "Origen, Destino, Cod_unidad, sum(Cantidad_mov) as Cantidad_mov, sum(Peso_mov) as Peso_mov ";
		$Consulta.= " from sef.movimientos ";
		$Consulta.= " where fecha = '".$FechaAux."'";
		$Consulta.= " and cod_equipo ".$EquipoSef;
		$Consulta.= " and cod_producto ".$ProductoSef;
		$Consulta.= " and cod_movimiento = '".$Movimiento."'";
		$Consulta.= " and origen ".$Origen;
		$Consulta.= " and destino ".$Destino;
		$Consulta.= " group by Fecha, Cod_equipo, Turno, Num_carga";
		$Consulta.= " order by turno, num_carga";
		$Respuesta = mysql_query($Consulta);
		//echo $Consulta;
		$i=0;		
		while ($Fila = mysql_fetch_array($Respuesta))
		{
			$Descuento = 0;
			switch ($TipoInforme)
			{				
				case 7: // PARA DESCONTAR EL M. BLANCO HETE A CT
					$Consulta = "SELECT Fecha, Cod_equipo, Turno, Num_carga, Cod_producto, Cod_movimiento, ";
					$Consulta.= "Origen, Destino, Cod_unidad, sum(Cantidad_mov) as Cantidad_mov, sum(Peso_mov) as Peso_mov ";
					$Consulta.= " from sef.movimientos ";
					$Consulta.= " where fecha = '".$Fila["Fecha"]."'";
					$Consulta.= " and cod_equipo = '5'";
					$Consulta.= " and cod_producto = '5'";
					$Consulta.= " and cod_movimiento = 'E'";
					$Consulta.= " and origen = '2'";
					$Consulta.= " and destino = '5'";
					$Consulta.= " and turno = '".$Fila["Turno"]."'";
					$Consulta.= " group by turno, num_carga";
					$Consulta.= " order by turno, num_carga";
					$Resp2 = mysql_query($Consulta);
					if ($Fila2 = mysql_fetch_array($Resp2))
					{
						$Descuento = $Fila2["Cantidad_mov"];
					}
					break;
			}
			$ArrSef[$i][0] = $Fila["Fecha"];
			$ArrSef[$i][1] = $Fila["Cod_equipo"];
			$ArrSef[$i][2] = $Fila["Turno"];
			$ArrSef[$i][3] = $Fila["Num_carga"];
			$ArrSef[$i][4] = $Fila["Cod_producto"];
			$ArrSef[$i][5] = $Fila["Cod_movimiento"];
			$ArrSef[$i][6] = $Fila["Origen"];
			$ArrSef[$i][7] = $Fila["Destino"];
			$ArrSef[$i][8] = $Fila["Cod_unidad"];
			$ArrSef[$i][9] = $Fila["Cantidad_mov"] - $Descuento;
			$ArrSef[$i][10] = $Fila["Peso_mov"];
			$i++;
		}
		include("../principal/cerrar_sef_web.php");
		include("../principal/conectar_principal.php");
		$DiarioCantMov = 0;
		$ContTurno=1;
		reset($ArrSef);
		while (list($k,$v)=each($ArrSef))
		{			
			//INICIO
			//LIMPIA ARREGLO DE LEYES USADAS			
			reset($ArrLeyes);
			foreach($ArrLeyes as $key => $values)
			{				
				$ArrLeyes[$key][2] = "";				
			}
			//CUENTA CUANTAS SOLICITUDES HAY PARA ESE DIA
			if ($VerTurno == "S" || $VerTodosPeriodos == "S")
			{
				echo "<tr align='right'>\n";
				if ($ContTurno==1)
				{
					$Consulta = "SELECT distinct t1.nro_solicitud ";
					$Consulta.= " from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2 ";
					$Consulta.= " on t1.nro_solicitud = t2.nro_solicitud and t1.recargo = t2.recargo ";
					$Consulta.= " where t1.cod_periodo = '4'"; //POR TURNO
					$Consulta.= " and t1.cod_producto = '".$CodProducto."'";
					$Consulta.= " and t1.cod_subproducto = '".$CodSubproducto."'";
					$Consulta.= " and t1.tipo = '1'";
					$Consulta.= " and t1.cod_analisis = '1'";
					$Consulta.= " and t1.fecha_muestra between '".$FechaAux." 00:00:00' and '".$FechaAux." 23:59:59' ";
					$Consulta.= " and (trim(t1.id_muestra) like 'A%' or trim(t1.id_muestra) like 'B%' or trim(t1.id_muestra) like 'C%')";
					if ($VerTodosAnalisis!="S")
					{	
						if ($VerLeyes=="S")
						{
							$Consulta.= " and (t2.cod_leyes = '02' or t2.cod_leyes = '04' or t2.cod_leyes = '05')";
						}
						else
						{
							if ($VerImpurezas=="S")
							{
								$Consulta.= " and (t2.cod_leyes <> '02' and t2.cod_leyes <> '04' and t2.cod_leyes <> '05')";
							}		
						}
					}
					$Consulta.= " and (t2.valor <> '' and NOT isnull(t2.valor))";
					$Consulta.= " order by t1.id_muestra";
					$Resp2 = mysql_query($Consulta);
					$ContSA = mysql_num_rows($Resp2);					
					if ($ContSA == 0)
					{
						include("../principal/cerrar_principal.php");
						include("../principal/conectar_sef_web.php");
						$Consulta = "SELECT * ";
						$Consulta.= " from sef.movimientos ";
						$Consulta.= " where fecha = '".$FechaAux."'";
						$Consulta.= " and cod_equipo ".$EquipoSef;
						$Consulta.= " and cod_producto ".$ProductoSef;
						$Consulta.= " and cod_movimiento = '".$Movimiento."'";
						$Consulta.= " and origen ".$Origen;
						$Consulta.= " and destino ".$Destino;
						$Consulta.= " order by turno, num_carga";
						$Resp2 = mysql_query($Consulta);
						$ContSA = mysql_num_rows($Resp2);
						include("../principal/cerrar_sef_web.php");
						include("../principal/conectar_principal.php");
					}
					else
					{
						if ($ContSA < 3)
							$ContSA = 3 + (3 - $ContSA);
					}
					echo "<td rowspan='".$ContSA."' align='center'>".$FechaAux."</td>\n";				
				}
				//CUENTA CUANTAS SOLICITUDES HAY PARA ESE TURNO
				$Consulta = "SELECT distinct t1.nro_solicitud ";
				$Consulta.= " from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2 ";
				$Consulta.= " on t1.nro_solicitud = t2.nro_solicitud and t1.recargo = t2.recargo ";
				$Consulta.= " where t1.cod_periodo = '4'"; //POR TURNO
				$Consulta.= " and t1.cod_producto = '".$CodProducto."'";
				$Consulta.= " and t1.cod_subproducto = '".$CodSubproducto."'";
				$Consulta.= " and t1.tipo = '1'";
				$Consulta.= " and t1.cod_analisis = '1'";
				$Consulta.= " and t1.fecha_muestra between '".$FechaAux." 00:00:00' and '".$FechaAux." 23:59:59' ";
				$Consulta.= " and (trim(t1.id_muestra) like '".$v[2]."%')";
				if ($VerTodosAnalisis!="S")
				{	
					if ($VerLeyes=="S")
					{
						$Consulta.= " and (t2.cod_leyes = '02' or t2.cod_leyes = '04' or t2.cod_leyes = '05')";
					}
					else
					{
						if ($VerImpurezas=="S")
						{
							$Consulta.= " and (t2.cod_leyes <> '02' and t2.cod_leyes <> '04' and t2.cod_leyes <> '05')";
						}		
					}
				}
				$Consulta.= " and (t2.valor <> '' and NOT isnull(t2.valor))";
				$Consulta.= " order by t1.id_muestra";
				$Resp2 = mysql_query($Consulta);
				$ContSAs = mysql_num_rows($Resp2);
				$PesoReg = $v[9]*$PesoBase; //OLLAS X PESO_BASE
				if ($TipoInforme == 1 || $TipoInforme == 2 || $TipoInforme == 3)
					echo "<td rowspan='".$ContSAs."' align='center'>".$v[3]."</td>\n"; //Num_Carga
				else
					echo "<td rowspan='".$ContSAs."' align='center'>".$v[2]."</td>\n"; //TURNO
				echo "<td rowspan='".$ContSAs."'>".number_format($v[9],2,",",".")."</td>\n";
				echo "<td rowspan='".$ContSAs."'>".number_format($PesoReg,0,",",".")."</td>\n";
				//RESCATA LEYES	POR TURNO
				$Consulta = "SELECT t1.nro_solicitud, t2.cod_leyes, t2.valor, t2.cod_unidad, t3.conversion ";
				$Consulta.= " from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2 ";
				$Consulta.= " on t1.nro_solicitud = t2.nro_solicitud and t1.recargo = t2.recargo ";
				$Consulta.= " inner join proyecto_modernizacion.unidades t3 on t2.cod_unidad = t3.cod_unidad ";
				$Consulta.= " where t1.cod_periodo = '4'"; //POR TURNO
				$Consulta.= " and t1.cod_producto = '".$CodProducto."'";
				$Consulta.= " and t1.cod_subproducto = '".$CodSubproducto."'";
				$Consulta.= " and t1.tipo = '1'";
				$Consulta.= " and t1.cod_analisis = '1'";
				$Consulta.= " and t1.fecha_muestra between '".$FechaAux." 00:00:00' and '".$FechaAux." 23:59:59' ";
				$Consulta.= " and trim(t1.id_muestra) like '".$v[2]."%'";
				if ($VerTodosAnalisis!="S")
				{	
					if ($VerLeyes=="S")
					{
						$Consulta.= " and (t2.cod_leyes = '02' or t2.cod_leyes = '04' or t2.cod_leyes = '05')";
					}
					else
					{
						if ($VerImpurezas=="S")
						{
							$Consulta.= " and (t2.cod_leyes <> '02' and t2.cod_leyes <> '04' and t2.cod_leyes <> '05')";
						}		
					}
				}
				$Consulta.= " and (t2.valor <> '' and NOT isnull(t2.valor))";
				$Consulta.= " order by t1.id_muestra";
				$Resp2 = mysql_query($Consulta);
				$SA = "";
				$ContSA = 1;
				while ($Fila2 = mysql_fetch_array($Resp2))
				{
					if ($SA != $Fila2["nro_solicitud"] && $SA != "")
					{
						if ($ContSA != 1)
						{
							echo "<tr>\n";
						}
						$ContSA++;
						echo "<td align='center'><a href=\"JavaScript:Historial(".$SA.")\">".$SA."</a></td>\n";						
						//ESCRIBIR LEYES Y FINOS POR TURNO
						if ($ChkLeyes=="S") //LEYES
						{
							reset($ArrLeyes);
							foreach($ArrLeyes as $key => $values)
							{
								if ($SA != "")
								{
									if ($values[2] > 0)
										echo "<td align='right'>".number_format($values[2],2,",",".")."</td>\n";
									else
										echo "<td>&nbsp;</td>\n";
								}
								else
								{
									echo "<td>&nbsp;</td>\n";
								}
							}
						}
						if ($ChkFinos=="S") //FINOS
						{
							reset($ArrLeyes);
							foreach($ArrLeyes as $key => $values)
							{
								if ($SA != "")
								{
									if ($values[2] > 0)
										echo "<td bgcolor='#FFFF99' align='right'>".number_format((($values[2]*$PesoReg)/$values[5]),0,",",".")."</td>\n";
									else
										echo "<td bgcolor='#FFFF99' >&nbsp;</td>\n";
								}
								else
								{
									echo "<td bgcolor='#FFFF99' >&nbsp;</td>\n";
								}
							}
						}
						echo "</tr>\n";
					}					
					$SA = $Fila2["nro_solicitud"];
					$ArrLeyes[$Fila2["cod_leyes"]][2] = $Fila2["valor"];
					$ArrLeyes[$Fila2["cod_leyes"]][3] = $Fila2["nro_solicitud"];
					$ArrLeyes[$Fila2["cod_leyes"]][4] = $Fila2["unidad"];
					$ArrLeyes[$Fila2["cod_leyes"]][5] = $Fila2["conversion"];
				}
				if ($SA != "")
					echo "<td align='center'><a href=\"JavaScript:Historial(".$SA.")\">".$SA."</a></td>\n";
				else
					echo "<td align='center'>&nbsp;</td>\n";
				//ESCRIBIR LEYES Y FINOS POR TURNO
				if ($ChkLeyes=="S") //LEYES
				{
					reset($ArrLeyes);
					foreach($ArrLeyes as $key => $values)
					{
						if ($SA != "")
						{
							if ($values[2] > 0)
								echo "<td align='right'>".number_format($values[2],2,",",".")."</td>\n";
							else
								echo "<td>&nbsp;</td>\n";
						}
						else
						{
							echo "<td>&nbsp;</td>\n";
						}
					}
				}
				if ($ChkFinos=="S") //FINOS
				{
					reset($ArrLeyes);
					foreach($ArrLeyes as $key => $values)
					{
						if ($SA != "")
						{
							if ($values[2] > 0)
								echo "<td bgcolor='#FFFF99' align='right'>".number_format((($values[2]*$PesoReg)/$values[5]),0,",",".")."</td>\n";
							else
								echo "<td bgcolor='#FFFF99' >&nbsp;</td>\n";
						}
						else
						{
							echo "<td bgcolor='#FFFF99' >&nbsp;</td>\n";
						}
					}
				}
				echo "</tr>\n";											
				$ContTurno++;
			}
			$DiarioCantMov = $DiarioCantMov + $v[9];
			$SemanalCantMov = $SemanalCantMov + $v[9];
			$TotalCantMov = $TotalCantMov + $v[9];
		}
		if ($VerDiario == "S" || $VerTodosPeriodos == "S")
		{
			$PesoReg = $DiarioCantMov*$PesoBase;
			echo "<tr align='right' bgcolor='#CCCCCC'>\n";
			echo "<td colspan='2'><strong>DIA ".substr($FechaAux,8,2)."</strong></td>\n";
			echo "<td>".number_format($DiarioCantMov,2,",",".")."</td>\n";
			echo "<td>".number_format($PesoReg,0,",",".")."</td>\n";
			//LEYES DIARIAS
			//LIMPIA ARREGLO DE LEYES USADAS
			reset($ArrLeyes);	
			foreach($ArrLeyes as $key => $values)
			{
				$ArrLeyes[$key][2] = "";		
			}
			$Consulta = "SELECT t1.nro_solicitud, t2.cod_leyes, t2.valor, t2.cod_unidad, t3.conversion  ";
			$Consulta.= " from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2 ";
			$Consulta.= " on t1.nro_solicitud = t2.nro_solicitud and t1.recargo = t2.recargo ";
			$Consulta.= " inner join proyecto_modernizacion.unidades t3 on t2.cod_unidad = t3.cod_unidad ";
			$Consulta.= " where t1.cod_periodo = '1'"; //POR DIARIO
			$Consulta.= " and t1.cod_producto = '".$CodProducto."'";
			$Consulta.= " and t1.cod_subproducto = '".$CodSubproducto."'";
			$Consulta.= " and t1.tipo = '1'";
			$Consulta.= " and t1.cod_analisis = '1'";
			$Consulta.= " and t1.fecha_muestra between '".$FechaAux." 00:00:00' and '".$FechaAux." 23:59:59' ";
			//if ($TipoInforme != 1)
				//$Consulta.= " and (t1.id_muestra like '%PROM%' or t1.id_muestra like '%COMP%')";
			if ($VerTodosAnalisis!="S")
			{	
				if ($VerLeyes=="S")
				{
					$Consulta.= " and (t2.cod_leyes = '02' or t2.cod_leyes = '04' or t2.cod_leyes = '05')";
				}
				else
				{
					if ($VerImpurezas=="S")
					{
						$Consulta.= " and (t2.cod_leyes <> '02' and t2.cod_leyes <> '04' and t2.cod_leyes <> '05')";
					}		
				}
			}
			$Consulta.= " and (t2.valor <> '' and NOT isnull(t2.valor))";
			$Consulta.= " order by t1.id_muestra";
			$Resp2 = mysql_query($Consulta);
			$SA = "";
			while ($Fila2 = mysql_fetch_array($Resp2))
			{			
				$ArrLeyes[$Fila2["cod_leyes"]][2] = $Fila2["valor"];
				$ArrLeyes[$Fila2["cod_leyes"]][3] = $Fila2["nro_solicitud"];
				$ArrLeyes[$Fila2["cod_leyes"]][4] = $Fila2["unidad"];
				$ArrLeyes[$Fila2["cod_leyes"]][5] = $Fila2["conversion"];
				$SA = $Fila2["nro_solicitud"];
			}
			if ($SA != "")
				echo "<td align='center'><a href=\"JavaScript:Historial(".$SA.")\">".$SA."</a></td>\n";
			else
				echo "<td align='center'>&nbsp;</td>\n";
			//ESCRIBIR LEYES DIARIAS
			if ($ChkLeyes=="S") //LEYES
			{	
				reset($ArrLeyes);
				foreach($ArrLeyes as $key => $values)
				{
					if ($values[2] > 0)
						echo "<td align='right'>".number_format($values[2],2,",",".")."</td>\n";
					else
						echo "<td>&nbsp;</td>\n";
				}
			}
			if ($ChkFinos=="S") //FINOS
			{	
				reset($ArrLeyes);
				foreach($ArrLeyes as $key => $values)
				{
					if ($values[2] > 0)
						echo "<td bgcolor='#FFCC66' align='right'>".number_format((($values[2]*$PesoReg)/$values[5]),0,",",".")."</td>\n";
					else
						echo "<td bgcolor='#FFCC66' >&nbsp;</td>\n";
				}
			}
			//--------------- FIN LEYES DIARIAS ---------------------
			echo "</tr>\n";
		}
		if ($VerSemanal == "S" || $VerTodosPeriodos == "S")
		{
			if (intval(substr($FechaAux,8,2)) == 7 || intval(substr($FechaAux,8,2)) == 14 || 
				intval(substr($FechaAux,8,2)) == 21 || intval(substr($FechaAux,8,2)) == 31 || 
				date($FechaAux) == date($FechaFin))
			{
				$DatosSemanales == true;
				$DiaSemana = intval(substr($FechaAux,8,2));
				if ($DiaSemana >=1 && $DiaSemana <= 7)
					$NombreSemana = "01 - 07";
				if ($DiaSemana >=8 && $DiaSemana <= 14)
					$NombreSemana = "08 - 14";
				if ($DiaSemana >=15 && $DiaSemana <= 21)
					$NombreSemana = "15 - 21";
				if ($DiaSemana >=22 && $DiaSemana <= 31)
				{					
					$FechaAux2 = date("Y-m-d", mktime(0,0,0,substr($FechaAux,5,2)+1,01,substr($FechaAux,0,4)));
					$FechaAux2 = date("d", mktime(0,0,0,substr($FechaAux2,5,2),1-1,substr($FechaAux2,0,4)));
					$NombreSemana = "22 - ".$FechaAux2;
				}
				//NUMERO SEMANA
				$Consulta = "SELECT week('".$FechaAux."') as num_semana";
				$Resp2 = mysql_query($Consulta);
				$Fila2 = mysql_fetch_array($Resp2);
				$NumSemana = $Fila2["num_semana"];
				$PesoReg = $SemanalCantMov*$PesoBase;
				echo "<tr align='right' bgcolor='YELLOW'>\n";
				echo "<td colspan='2'><strong>SEMANA ".$NombreSemana."</strong></td>\n";
				echo "<td>".number_format($SemanalCantMov,2,",",".")."</td>\n";
				echo "<td>".number_format($PesoReg,0,",",".")."</td>\n";
				//LEYES SEMANALES
				//LIMPIA ARREGLO DE LEYES USADAS			
				reset($ArrLeyes);
				foreach($ArrLeyes as $key => $values)
				{
					$ArrLeyes[$key][2] = "";										
				}			
				$Consulta = "SELECT t1.nro_solicitud, t2.cod_leyes, t2.valor, t2.cod_unidad, t3.conversion ";
				$Consulta.= " from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2 ";
				$Consulta.= " on t1.nro_solicitud = t2.nro_solicitud and t1.recargo = t2.recargo ";
				$Consulta.= " inner join proyecto_modernizacion.unidades t3 on t2.cod_unidad = t3.cod_unidad ";
				$Consulta.= " where t1.cod_periodo = '2'"; //POR SEMANA
				$Consulta.= " and t1.cod_producto = '".$CodProducto."'";
				$Consulta.= " and t1.cod_subproducto = '".$CodSubproducto."'";
				$Consulta.= " and t1.tipo = '1'";
				$Consulta.= " and t1.cod_analisis = '1'";
				$Consulta.= " and t1.nro_semana = '".$NumSemana."' ";
				$Consulta.= " and t1.año = '".intval(substr($FechaAux,0,4))."' ";
				$Consulta.= " and t1.mes = '".intval(substr($FechaAux,5,2))."' ";
				if ($VerTodosAnalisis!="S")
				{	
					if ($VerLeyes=="S")
					{
						$Consulta.= " and (t2.cod_leyes = '02' or t2.cod_leyes = '04' or t2.cod_leyes = '05')";
					}
					else
					{
						if ($VerImpurezas=="S")
						{
							$Consulta.= " and (t2.cod_leyes <> '02' and t2.cod_leyes <> '04' and t2.cod_leyes <> '05')";
						}		
					}
				}
				$Consulta.= " and (t2.valor <> '' and NOT isnull(t2.valor))";
				$Consulta.= " order by t1.id_muestra";
				$Resp2 = mysql_query($Consulta);
				$SA = "";
				while ($Fila2 = mysql_fetch_array($Resp2))
				{			
					$ArrLeyes[$Fila2["cod_leyes"]][2] = $Fila2["valor"];
					$ArrLeyes[$Fila2["cod_leyes"]][3] = $Fila2["nro_solicitud"];
					$ArrLeyes[$Fila2["cod_leyes"]][4] = $Fila2["unidad"];
					$ArrLeyes[$Fila2["cod_leyes"]][5] = $Fila2["conversion"];
					$SA = $Fila2["nro_solicitud"];
				}
				if ($SA != "")
					echo "<td align='center'><a href=\"JavaScript:Historial(".$SA.")\">".$SA."</a></td>\n";
				else
					echo "<td align='center'>&nbsp;</td>\n";
				//ESCRIBIR LEYES Y FINOS SEMANALES
				if ($ChkLeyes=="S") //LEYES
				{
					reset($ArrLeyes);
					foreach($ArrLeyes as $key => $values)
					{
						if ($values[2] > 0)
							echo "<td align='right'>".number_format($values[2],2,",",".")."</td>\n";
						else
							echo "<td>&nbsp;</td>\n";
					}
				}
				if ($ChkFinos=="S") //FINOS
				{
					reset($ArrLeyes);
					foreach($ArrLeyes as $key => $values)
					{
						if ($values[2] > 0)
							echo "<td align='right'>".number_format((($values[2]*$PesoReg)/$values[5]),0,",",".")."</td>\n";
						else
							echo "<td>&nbsp;</td>\n";
					}
				}
				//--------------- FIN LEYES SEMANALES ------------------
				echo "</tr>\n";
				$SemanalCantMov = 0;
				$ContSemanas++;
			}
		}
		$FechaAux = date("Y-m-d", mktime(0,0,0,substr($FechaAux,5,2),intval(substr($FechaAux,8,2))+1,substr($FechaAux,0,4)));
	}
	if ($VerSemanal == "S" || $VerTodosPeriodos == "S")
	{
		if ((intval(substr($FechaAux,8,2)) == 31 || date($FechaAux) == date($FechaFin)) && $DatosSemanales == false)
		{
			$FechaAux = date("Y-m-d", mktime(0,0,0,substr($FechaAux,5,2),intval(substr($FechaAux,8,2))-1,substr($FechaAux,0,4)));
			$DatosSemanales == true;
			$DiaSemana = intval(substr($FechaAux,8,2));
			if ($DiaSemana >=1 && $DiaSemana <= 7)
				$NombreSemana = "01 - 07";
			if ($DiaSemana >=8 && $DiaSemana <= 14)
				$NombreSemana = "08 - 14";
			if ($DiaSemana >=15 && $DiaSemana <= 21)
				$NombreSemana = "15 - 21";
			if ($DiaSemana >=22 && $DiaSemana <= 31)
			{					
				$FechaAux2 = date("Y-m-d", mktime(0,0,0,substr($FechaAux,5,2)+1,01,substr($FechaAux,0,4)));
				$FechaAux2 = date("d", mktime(0,0,0,substr($FechaAux2,5,2),1-1,substr($FechaAux2,0,4)));
				$NombreSemana = "22 - ".$FechaAux2;
			}
			//NUMERO SEMANA
			$Consulta = "SELECT week('".$FechaAux."') as num_semana";
			$Resp2 = mysql_query($Consulta);
			$Fila2 = mysql_fetch_array($Resp2);
			$NumSemana = $Fila2["num_semana"];
			$PesoReg = $SemanalCantMov*$PesoBase;
			echo "<tr align='right' bgcolor='YELLOW'>\n";
			echo "<td colspan='2'><strong>SEMANA ".$NombreSemana."</strong></td>\n";
			echo "<td>".number_format($SemanalCantMov,2,",",".")."</td>\n";
			echo "<td>".number_format($PesoReg,0,",",".")."</td>\n";
			//LEYES SEMANALES
			//LIMPIA ARREGLO DE LEYES USADAS			
			reset($ArrLeyes);
			foreach($ArrLeyes as $key => $values)
			{
				$ArrLeyes[$key][2] = "";										
			}			
			$Consulta = "SELECT t1.nro_solicitud, t2.cod_leyes, t2.valor, t2.cod_unidad, t3.conversion ";
			$Consulta.= " from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2 ";
			$Consulta.= " on t1.nro_solicitud = t2.nro_solicitud and t1.recargo = t2.recargo ";
			$Consulta.= " inner join proyecto_modernizacion.unidades t3 on t2.cod_unidad = t3.cod_unidad ";
			$Consulta.= " where t1.cod_periodo = '2'"; //POR SEMANA
			$Consulta.= " and t1.cod_producto = '".$CodProducto."'";
			$Consulta.= " and t1.cod_subproducto = '".$CodSubproducto."'";
			$Consulta.= " and t1.tipo = '1'";
			$Consulta.= " and t1.cod_analisis = '1'";
			$Consulta.= " and t1.nro_semana = '".$NumSemana."' ";
			$Consulta.= " and t1.año = '".intval(substr($FechaAux,0,4))."' ";
			$Consulta.= " and t1.mes = '".intval(substr($FechaAux,5,2))."' ";
			if ($VerTodosAnalisis!="S")
			{	
				if ($VerLeyes=="S")
				{
					$Consulta.= " and (t2.cod_leyes = '02' or t2.cod_leyes = '04' or t2.cod_leyes = '05')";
				}
				else
				{
					if ($VerImpurezas=="S")
					{
						$Consulta.= " and (t2.cod_leyes <> '02' and t2.cod_leyes <> '04' and t2.cod_leyes <> '05')";
					}		
				}
			}
			$Consulta.= " and (t2.valor <> '' and NOT isnull(t2.valor))";
			$Consulta.= " order by t1.id_muestra";
			$Resp2 = mysql_query($Consulta);
			$SA = "";
			while ($Fila2 = mysql_fetch_array($Resp2))
			{			
				$ArrLeyes[$Fila2["cod_leyes"]][2] = $Fila2["valor"];
				$ArrLeyes[$Fila2["cod_leyes"]][3] = $Fila2["nro_solicitud"];
				$ArrLeyes[$Fila2["cod_leyes"]][4] = $Fila2["unidad"];
				$ArrLeyes[$Fila2["cod_leyes"]][5] = $Fila2["conversion"];
				$SA = $Fila2["nro_solicitud"];
			}
			if (SA != "")
				echo "<td align='center'><a href=\"JavaScript:Historial(".$SA.")\">".$SA."</a></td>\n";
			else
				echo "<td align='center'>&nbsp;</td>\n";
			//ESCRIBIR LEYES Y FINOS SEMANALES
			if ($ChkLeyes=="S") //LEYES
			{
				reset($ArrLeyes);
				foreach($ArrLeyes as $key => $values)
				{
					if ($values[2] > 0)
						echo "<td align='right'>".number_format($values[2],2,",",".")."</td>\n";
					else
						echo "<td>&nbsp;</td>\n";
				}
			}
			if ($ChkFinos=="S") //FINOS
			{
				reset($ArrLeyes);
				foreach($ArrLeyes as $key => $values)
				{
					if ($values[2] > 0)
						echo "<td align='right'>".number_format(($values[2]*$PesoReg)/$values[5],0,",",".")."</td>\n";
					else
						echo "<td>&nbsp;</td>\n";
				}
			}
		}
		//--------------- FIN LEYES SEMANALES ------------------
		echo "</tr>\n";
		$SemanalCantMov = 0;
		$ContSemanas++;
	}
	include("../principal/cerrar_principal.php");	
	//TOTALES
	if ($VerMensual == "S" || $VerTodosPeriodos == "S")
	{
		echo "<tr align='right' bgcolor='#FF6600'>\n";
		echo "<td colspan='2'><strong>TOTAL</strong></td>\n";
		echo "<td><strong>".number_format($TotalCantMov,2,",",".")."</strong></td>\n";
		echo "<td><strong>".number_format($TotalCantMov*$PesoBase,0,",",".")."</strong></td>\n";
		include("../principal/conectar_principal.php");	
		//LEYES MENSUALES
		//LIMPIA ARREGLO DE LEYES USADAS			
		reset($ArrLeyes);
		foreach($ArrLeyes as $key => $values)
		{
			$ArrLeyes[$key][2] = "";	
		}	
		$Consulta = "SELECT t1.nro_solicitud, t2.cod_leyes, t2.valor, t2.cod_unidad, t3.conversion ";
		$Consulta.= " from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2 ";
		$Consulta.= " on t1.nro_solicitud = t2.nro_solicitud and t1.recargo = t2.recargo ";
		$Consulta.= " inner join proyecto_modernizacion.unidades t3 on t2.cod_unidad = t3.cod_unidad ";
		$Consulta.= " where t1.cod_periodo = '3'"; //POR MES
		$Consulta.= " and t1.cod_producto = '".$CodProducto."'";
		$Consulta.= " and t1.cod_subproducto = '".$CodSubproducto."'";
		$Consulta.= " and t1.tipo = '1'";
		$Consulta.= " and t1.cod_analisis = '1'";
		$Consulta.= " and t1.año = '".intval($AnoFin)."' ";
		$Consulta.= " and t1.mes = '".intval($MesFin)."' ";
		if ($VerTodosAnalisis!="S")
		{	
			if ($VerLeyes=="S")
			{
				$Consulta.= " and (t2.cod_leyes = '02' or t2.cod_leyes = '04' or t2.cod_leyes = '05')";
			}
			else
			{
				if ($VerImpurezas=="S")
				{
					$Consulta.= " and (t2.cod_leyes <> '02' and t2.cod_leyes <> '04' and t2.cod_leyes <> '05')";
				}		
			}
		}
		$Consulta.= " and (t2.valor <> '' and NOT isnull(t2.valor))";
		$Consulta.= " order by t1.id_muestra";	
		$SA = "";
		$Resp2 = mysql_query($Consulta);	
		while ($Fila2 = mysql_fetch_array($Resp2))
		{			
			$ArrLeyes[$Fila2["cod_leyes"]][2] = $Fila2["valor"];
			$ArrLeyes[$Fila2["cod_leyes"]][3] = $Fila2["nro_solicitud"];
			$ArrLeyes[$Fila2["cod_leyes"]][4] = $Fila2["unidad"];
			$ArrLeyes[$Fila2["cod_leyes"]][5] = $Fila2["conversion"];
			$SA = $Fila2["nro_solicitud"];
		}
		if ($SA != "") 
			echo "<td align='center'><a href=\"JavaScript:Historial(".$SA.")\">".$SA."</a></td>\n";
		else
			echo "<td align='center'>&nbsp;</td>\n";
		//ESCRIBIR LEYES Y FINOS TOTALES(MENSUALES)
		if ($ChkLeyes=="S") //LEYES
		{	
			reset($ArrLeyes);
			foreach($ArrLeyes as $key => $values)
			{
				if ($values[2] > 0)
					echo "<td align='right'>".number_format($values[2],2,",",".")."</td>\n";
				else
					echo "<td>&nbsp;</td>\n";
			}
		}
		if ($ChkFinos=="S") //FINOS
		{	
			reset($ArrLeyes);
			foreach($ArrLeyes as $key => $values)
			{
				if ($values[2] > 0)
					echo "<td align='right'>".number_format((($values[2]*$PesoReg)/$values[5]),0,",",".")."</td>\n";
				else
					echo "<td>&nbsp;</td>\n";
			}
		}
		//--------------- FIN LEYES MENSUALES ------------------
		include("../principal/cerrar_principal.php");	
		echo "</tr>";
	}
?>      
</table>
</form>
</body>
</html>
