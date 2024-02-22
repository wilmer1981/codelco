<?
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	include("../principal/conectar_sef_web.php");	
	$FechaIni = $AnoFin."-".str_pad($MesFin,2,0,STR_PAD_LEFT)."-01";
	$FechaFin = $AnoFin."-".str_pad($MesFin,2,0,STR_PAD_LEFT)."-31";
	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$Periodo = strtoupper($Meses[$MesFin-1])." ".$AnoFin;
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
	//HUMEDAD
	if ($TipoInforme==2)
		$PorcHumedad = 0.5;
	else
		$PorcHumedad = 0;
	//PESO BASE
	$Consulta = "SELECT * from sef.producto_por_equipo ";
	if ($EquipoSef == "in(7,8,9)")	
	{
		$Consulta.= " where cod_equipo = '6' ";
	}
	else
	{
		if ($ProductoSef=="= '6'" && $EquipoSef=="= '2'" && $TipoInforme==5)
			$Consulta.= " where cod_equipo = '5' ";
		else
			$Consulta.= " where cod_equipo ".$EquipoSef." ";
	}
	$Consulta.= "and cod_producto ".$ProductoSef;
	$Respuesta = mysql_query($Consulta);
	$PesoBase = 0;
	if ($Fila = mysql_fetch_array($Respuesta))
		$PesoBase = $Fila["Peso_base"];	
	include("../principal/cerrar_sef_web.php");	
	include("../principal/conectar_principal.php");	
		//-------------------LEYES DIARIAS SOLO (As)---------------							
		$FechaAux = $FechaIni;	
		while (date($FechaAux)<=date($FechaFin))
		{
			$Dia = intval(substr($FechaAux,8,2));			
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
			//$Consulta.= " and (t1.id_muestra like '%PROM%' or t1.id_muestra like '%COMP%')";	
			if ($TipoInforme == 6)
				$Consulta.= " and (t2.cod_leyes = '02' or t2.cod_leyes = '08' or t2.cod_leyes = '26')";		
			else
				$Consulta.= " and (t2.cod_leyes = '02')";	
			$Consulta.= " and (t2.valor <> '' and NOT isnull(t2.valor))";
			$Consulta.= " order by t1.id_muestra, t2.cod_leyes";
			$Resp2 = mysql_query($Consulta);
			while ($Fila2 = mysql_fetch_array($Resp2))
			{				
				switch ($Fila2["cod_leyes"])
				{					
					case "02":		
						if ($TipoInforme != 1 && $TipoInforme != 2)
						{				
							$ArrLeyes[$Dia][0] = $Dia;//DIA
							$ArrLeyes[$Dia][1] = $Fila2["cod_leyes"];
							$ArrLeyes[$Dia][2] = $Fila2["valor"];
							$ArrLeyes[$Dia][3] = $Fila2["unidad"];
							$ArrLeyes[$Dia][4] = $Fila2["conversion"];
						}
						break;
					case "08":									
						$ArrLeyes[$Dia][13] = $Fila2["cod_leyes"];
						$ArrLeyes[$Dia][14] = $Fila2["valor"];
						$ArrLeyes[$Dia][15] = $Fila2["unidad"];
						$ArrLeyes[$Dia][16] = $Fila2["conversion"];				
						break;			
					case "26":									
						$ArrLeyes[$Dia][17] = $Fila2["cod_leyes"];
						$ArrLeyes[$Dia][18] = $Fila2["valor"];
						$ArrLeyes[$Dia][19] = $Fila2["unidad"];
						$ArrLeyes[$Dia][20] = $Fila2["conversion"];				
						break;				
				}
			}
			$FechaAux = date("Y-m-d", mktime(0,0,0,substr($FechaAux,5,2),intval(substr($FechaAux,8,2))+1,substr($FechaAux,0,4)));
		}
		//----------------FIN LEYES DIARIAS------------------------
	
	//-------------------LEYES SEMANALES-----------------------
	for ($i=1;$i<=4;$i++)
	{		
		switch ($i)
		{
			case 1:
				$PriDia="1";
				$UltDia="7";
				$FechaAux = $AnoFin."-".str_pad($MesFin,2,"0",STR_PAD_LEFT)."-".str_pad($UltDia,2,"0",STR_PAD_LEFT);
				break;
			case 2:
				$PriDia="8";
				$UltDia="14";
				$FechaAux = $AnoFin."-".str_pad($MesFin,2,"0",STR_PAD_LEFT)."-".$UltDia;
				break;
			case 3:
				$PriDia="15";
				$UltDia="21";
				$FechaAux = $AnoFin."-".str_pad($MesFin,2,"0",STR_PAD_LEFT)."-".$UltDia;
				break;
			case 4:
				$PriDia="22";
				$FechaAux2 = date("Y-m-d", mktime(0,0,0,$MesFin+1,01,substr($AnoFin,0,4)));
				$UltDia = date("d", mktime(0,0,0,substr($FechaAux2,5,2),1-1,substr($FechaAux2,0,4)));	
				$FechaAux = $AnoFin."-".str_pad($MesFin,2,"0",STR_PAD_LEFT)."-".$UltDia;
				break;
		}	
		//NUMERO SEMANA
		$Consulta = "SELECT week('".$FechaAux."') as num_semana";
		$Resp2 = mysql_query($Consulta);
		$Fila2 = mysql_fetch_array($Resp2);
		$NumSemana = $Fila2["num_semana"];			
		//LEYES SEMANALES				
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
		if ($TipoInforme == 6)
			$Consulta.= " and (t2.cod_leyes = '02' or t2.cod_leyes = '04' or t2.cod_leyes = '05')";// or t2.cod_leyes = '26')";						
		else					
			$Consulta.= " and (t2.cod_leyes = '02' or t2.cod_leyes = '04' or t2.cod_leyes = '05')";						
		$Consulta.= " and (t2.valor <> '' and NOT isnull(t2.valor))";
		$Consulta.= " order by t1.id_muestra, t2.cod_leyes";
		$Resp2 = mysql_query($Consulta);
		while ($Fila2 = mysql_fetch_array($Resp2))
		{	
			for ($j=$PriDia;$j<=$UltDia;$j++)	
			{	
				switch ($Fila2["cod_leyes"])
				{					
					case "02":		
						if ($TipoInforme == 1 || $TipoInforme == 2)
						{				
							$ArrLeyes[$j][0] = $i;//DIA
							$ArrLeyes[$j][1] = $Fila2["cod_leyes"];
							$ArrLeyes[$j][2] = $Fila2["valor"];
							$ArrLeyes[$j][3] = $Fila2["unidad"];
							$ArrLeyes[$j][4] = $Fila2["conversion"];
						}
						break;
					case "04":						
						$ArrLeyes[$j][5] = $Fila2["cod_leyes"];
						$ArrLeyes[$j][6] = $Fila2["valor"];
						$ArrLeyes[$j][7] = $Fila2["unidad"];
						$ArrLeyes[$j][8] = $Fila2["conversion"];						
						break;
					case "05":				
						$ArrLeyes[$j][9] = $Fila2["cod_leyes"];
						$ArrLeyes[$j][10] = $Fila2["valor"];
						$ArrLeyes[$j][11] = $Fila2["unidad"];
						$ArrLeyes[$j][12] = $Fila2["conversion"];						
						break;
					/*case "08":					
						$ArrLeyes[$j][13] = $Fila2["cod_leyes"];
						$ArrLeyes[$j][14] = $Fila2["valor"];
						$ArrLeyes[$j][15] = $Fila2["unidad"];
						$ArrLeyes[$j][16] = $Fila2["conversion"];						
						break;	
					case "26":					
						$ArrLeyes[$j][17] = $Fila2["cod_leyes"];
						$ArrLeyes[$j][18] = $Fila2["valor"];
						$ArrLeyes[$j][19] = $Fila2["unidad"];
						$ArrLeyes[$j][20] = $Fila2["conversion"];						
						break;				*/			
				}		
			}
		}
	}	
	include("../principal/cerrar_principal.php");	
	include("../principal/conectar_sef_web.php");	
?>
<html>
<head>
<title>Informes SEF</title>
</head>

<body>
<form name="frmPrincipal" action="" method="post">
<table width="600" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
  <tr>
    <td width="76" colspan="3">Informe</td>
    <td width="307" colspan="6"><? echo $TituloInforme; ?></td>
  </tr>
  <tr>
    <td colspan="3">Periodo</td>
    <td colspan="6"><? echo $Periodo; ?>
      <div align="left"></div></td>
  </tr>
  <tr>
    <td colspan="3">Peso Olla </td>
    <td colspan="6"><? echo number_format($PesoBase,0,",","."); ?>
      <div align="left"></div></td>
  </tr>
  <? 
	if ($TipoInforme == 1)
	{
		echo "<tr>";
    	echo "<td colspan='9'>";
		echo "*Descuento Esc. Reten y Esc. Basculante a Pozo.<br>";
		echo "*Descuento Esc. Reten y Esc. Basculante de Retorno a CPS.";
		echo "</td>";
  		echo "</tr>";
	}
	?>
</table>
<br>
<table width="600" border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr align="center" class="ColorTabla01">
    <td width="50" rowspan="2"><strong>Fecha</strong></td>
    <td width="60" rowspan="2"><strong>N&ordm; Ollas </strong></td>
<? 
	if ($TipoInforme==2)
	{	
    	echo "<td width='110' rowspan='2'><strong>P.Humedo [Kg] </strong></td>\n";
	}
?>
    <td width="70" rowspan="2"><strong>P.Seco [Kg] </strong></td>
<?
	if ($TipoInforme == 6)
		$ColSpan = 5;
	else
		$ColSpan = 3;
?>		
    <td colspan="<? echo $ColSpan; ?>"><strong>Leyes</strong></td>
    <td colspan="<? echo $ColSpan; ?>"><strong>Finos</strong></td>
    </tr>
  <tr align="center" class="ColorTabla01">
    <td width="60"><strong>Cu</strong></td>
    <td width="60"><strong>Ag</strong></td>
    <td width="60"><strong>Au</strong></td>
<?
	if ($TipoInforme == 6)
	{
		echo "<td width='60'><strong>As</strong></td>\n";
		echo "<td width='60'><strong>S</strong></td>\n";
	}
?>	
    <td width="60"><strong>Cu</strong></td>
    <td width="60"><strong>Ag</strong></td>
    <td width="63"><strong>Au</strong></td>
<?
	if ($TipoInforme == 6)
	{
		echo "<td width='60'><strong>As</strong></td>\n";
		echo "<td width='60'><strong>S</strong></td>\n";
	}
?>		
  </tr>
<?  
	
	$FechaAux = $FechaIni;
	$TotalCu = 0;
	$TotalAg = 0;
	$TotalAu = 0;
	$TotalAs = 0;
	$TotalS = 0;
	while (date($FechaAux)<=date($FechaFin))
	{					
		$Consulta = "SELECT Fecha, Cod_equipo, Turno, Num_carga, Cod_producto, Cod_movimiento, ";
		$Consulta.= "Origen, Destino, Cod_unidad, sum(Cantidad_mov) as Cantidad_mov, sum(Peso_mov) as Peso_mov ";
		$Consulta.= " from sef.movimientos ";
		$Consulta.= " where fecha = '".$FechaAux."'";
		$Consulta.= " and cod_equipo ".$EquipoSef;
		$Consulta.= " and cod_producto ".$ProductoSef;
		$Consulta.= " and cod_movimiento = '".$Movimiento."'";
		$Consulta.= " and origen ".$Origen;
		$Consulta.= " and destino ".$Destino;
		$Consulta.= " group by Fecha";
		$Respuesta = mysql_query($Consulta);		
		$i=0;		
		while ($Fila = mysql_fetch_array($Respuesta))
		{			
			$Descuento = 0;
			switch ($TipoInforme)
			{	
				case 1:
					//DESCUENTA ESCORIA RETEN Y BASCULANTE DE RETORNO A CPS
					$Consulta = "SELECT ifnull(sum(Cantidad_mov),0) as Cantidad_mov from sef.movimientos";
					$Consulta.= " where cod_equipo in(7,8,9)";
					$Consulta.= " and cod_producto = 6";
					$Consulta.= " and cod_movimiento = 'E'";
					$Consulta.= " and origen IN(1,3)";
					$Consulta.= " and destino in(7,8,9)";
					$Consulta.= " and fecha = '".$Fila["Fecha"]."'";
					$Resp2 = mysql_query($Consulta);
					if ($Fila2 = mysql_fetch_array($Resp2))
					{
						$Descuento = $Fila2["Cantidad_mov"];
					}
					//DESCUENTA ESCORIA RETEN A POZO
					$Consulta = "SELECT Fecha, Cod_equipo, Turno, Num_carga, Cod_producto, Cod_movimiento, ";
					$Consulta.= " Origen, Destino, Cod_unidad, sum(Cantidad_mov) as Cantidad_mov, sum(Peso_mov) as Peso_mov ";
					$Consulta.= " from sef.movimientos ";
					$Consulta.= " where fecha = '".$Fila["Fecha"]."'";
					$Consulta.= " and cod_equipo = '3'";
					$Consulta.= " and cod_producto = '6'";
					$Consulta.= " and cod_movimiento = 'S'";
					$Consulta.= " and origen = '3'";
					$Consulta.= " and destino = '11'";
					$Consulta.= " group by Fecha";
					$Resp2 = mysql_query($Consulta);
					if ($Fila2 = mysql_fetch_array($Resp2))
					{
						$Descuento = $Descuento + $Fila2["Cantidad_mov"];
					}
					//DESCUENTA ESCORIA BASCULANTE A POZO
					$Consulta = "SELECT Fecha, Cod_equipo, Turno, Num_carga, Cod_producto, Cod_movimiento, ";
					$Consulta.= "Origen, Destino, Cod_unidad, sum(Cantidad_mov) as Cantidad_mov, sum(Peso_mov) as Peso_mov ";
					$Consulta.= " from sef.movimientos ";
					$Consulta.= " where fecha = '".$Fila["Fecha"]."'";
					$Consulta.= " and cod_equipo = '1'";
					$Consulta.= " and cod_producto = '6'";
					$Consulta.= " and cod_movimiento = 'S'";
					$Consulta.= " and origen = '1'";
					$Consulta.= " and destino = '11'";
					$Consulta.= " group by Fecha";
					$Resp2 = mysql_query($Consulta);
					if ($Fila2 = mysql_fetch_array($Resp2))
					{
						$Descuento = $Descuento + $Fila2["Cantidad_mov"];
					}
					break;						
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
					//$Consulta.= " and turno = '".$Fila["Turno"]."'";
					$Consulta.= " group by Fecha";
					$Resp2 = mysql_query($Consulta);
					if ($Fila2 = mysql_fetch_array($Resp2))
					{
						$Descuento = $Fila2["Cantidad_mov"];
					}
					break;
			}
			$CantMovDia = $Fila["Cantidad_mov"] - $Descuento;
			$PesoHumedo = $CantMovDia * $PesoBase;
			$PesoSeco = $PesoHumedo - (($PesoHumedo*$PorcHumedad)/100);
			$TotalCantMov = $TotalCantMov + $CantMovDia;			
			echo "<tr align='center' bgcolor='#FFFFFF'>\n";
			echo "<td><strong>".substr($FechaAux,8,2)."</strong></td>\n";
			echo "<td>".number_format($CantMovDia,2,",",".")."</td>\n";
			if ($TipoInforme==2)
			{
				echo "<td>".number_format($PesoHumedo,0,",",".")."</td>\n";
			}
			echo "<td>".number_format($PesoSeco,0,",",".")."</td>\n";
			if ($PesoSeco>0)
			{
				//LEYES
				echo "<td>".number_format($ArrLeyes[intval(substr($FechaAux,8,2))][2],2,",",".")."</td>\n";
				echo "<td>".number_format($ArrLeyes[intval(substr($FechaAux,8,2))][6],2,",",".")."</td>\n";
				echo "<td>".number_format($ArrLeyes[intval(substr($FechaAux,8,2))][10],2,",",".")."</td>\n";
				if ($TipoInforme==6) // As, S
				{
					echo "<td>".number_format($ArrLeyes[intval(substr($FechaAux,8,2))][14],2,",",".")."</td>\n";
					echo "<td>".number_format($ArrLeyes[intval(substr($FechaAux,8,2))][18],2,",",".")."</td>\n";
				}
				//FINOS
				if ($PesoSeco>0 && $ArrLeyes[intval(substr($FechaAux,8,2))][2]>0)
				{
					$TotalCu = $TotalCu + (($ArrLeyes[intval(substr($FechaAux,8,2))][2] * $PesoSeco)/$ArrLeyes[intval(substr($FechaAux,8,2))][4]);						
					echo "<td>".number_format(($ArrLeyes[intval(substr($FechaAux,8,2))][2] * $PesoSeco)/$ArrLeyes[intval(substr($FechaAux,8,2))][4],0,",",".")."</td>\n";
				}
				else
				{
					echo "<td>0</td>\n";
				}
				if ($PesoSeco>0 && $ArrLeyes[intval(substr($FechaAux,8,2))][6]>0)
				{
					$TotalAg = $TotalAg + (($ArrLeyes[intval(substr($FechaAux,8,2))][6] * $PesoSeco)/$ArrLeyes[intval(substr($FechaAux,8,2))][8]);	
					echo "<td>".number_format(($ArrLeyes[intval(substr($FechaAux,8,2))][6] * $PesoSeco)/$ArrLeyes[intval(substr($FechaAux,8,2))][8],0,",",".")."</td>\n";
				}
				else
				{
					echo "<td>0</td>\n";
				}
				if ($PesoSeco>0 && $ArrLeyes[intval(substr($FechaAux,8,2))][6]>0)	
				{
					$TotalAu = $TotalAu + (($ArrLeyes[intval(substr($FechaAux,8,2))][10] * $PesoSeco)/$ArrLeyes[intval(substr($FechaAux,8,2))][12]);
					echo "<td>".number_format(($ArrLeyes[intval(substr($FechaAux,8,2))][10] * $PesoSeco)/$ArrLeyes[intval(substr($FechaAux,8,2))][12],0,",",".")."</td>\n";
				}
				else
				{
					echo "<td>0</td>\n";
				}
				if ($TipoInforme==6) // As, S
				{
					if ($PesoSeco>0 && $ArrLeyes[intval(substr($FechaAux,8,2))][14]>0)
					{
						$TotalAs = $TotalAs + (($ArrLeyes[intval(substr($FechaAux,8,2))][14] * $PesoSeco)/$ArrLeyes[intval(substr($FechaAux,8,2))][16]);	
						echo "<td>".number_format(($ArrLeyes[intval(substr($FechaAux,8,2))][14] * $PesoSeco)/$ArrLeyes[intval(substr($FechaAux,8,2))][16],0,",",".")."</td>\n";
					}
					else
					{
						echo "<td>0</td>\n";
					}
					if ($PesoSeco>0 && $ArrLeyes[intval(substr($FechaAux,8,2))][18]>0)	
					{
						$TotalS = $TotalS + (($ArrLeyes[intval(substr($FechaAux,8,2))][18] * $PesoSeco)/$ArrLeyes[intval(substr($FechaAux,8,2))][20]);
						echo "<td>".number_format(($ArrLeyes[intval(substr($FechaAux,8,2))][18] * $PesoSeco)/$ArrLeyes[intval(substr($FechaAux,8,2))][20],0,",",".")."</td>\n";
					}
					else
					{
						echo "<td>0</td>\n";
					}
				}
			}
			else
			{
				echo "<td>0</td>\n";
				echo "<td>0</td>\n";
				echo "<td>0</td>\n";
				echo "<td>0</td>\n";
				echo "<td>0</td>\n";
				echo "<td>0</td>\n";
				if ($TipoInforme==6)
				{
					echo "<td>0</td>\n";
					echo "<td>0</td>\n";
					echo "<td>0</td>\n";
					echo "<td>0</td>\n";
				}			
			}									
			//FIN LEYES
			echo "</tr>\n";
		}								
		$FechaAux = date("Y-m-d", mktime(0,0,0,substr($FechaAux,5,2),intval(substr($FechaAux,8,2))+1,substr($FechaAux,0,4)));
	}
	$TotalPesoHumedo = $TotalCantMov*$PesoBase;	
	$TotalPesoSeco = $TotalPesoHumedo - (($TotalPesoHumedo*$PorcHumedad)/100);	
	echo "<tr align='center' bgcolor='#CCCCCC'>\n";
	echo "<td><strong>TOTAL</strong></td>\n";
	echo "<td><strong>".number_format($TotalCantMov,2,",",".")."</strong></td>\n";
	if ($TipoInforme==2)
	{
		echo "<td><strong>".number_format($TotalPesoHumedo,0,",",".")."</strong></td>\n";	
	}
	echo "<td><strong>".number_format($TotalPesoSeco,0,",",".")."</strong></td>\n";	
	//LEYES
	if ($TotalCu > 0 && $TotalPesoSeco > 0)
		echo "<td>".number_format(($TotalCu*100)/$TotalPesoSeco,2,",",".")."</td>\n";
	else
		echo "<td>0</td>\n";
	if ($TotalAg > 0 && $TotalPesoSeco > 0)
		echo "<td>".number_format(($TotalAg*1000)/$TotalPesoSeco,2,",",".")."</td>\n";
	else
		echo "<td>0</td>\n";
	if ($TotalAu > 0 && $TotalPesoSeco > 0)
		echo "<td>".number_format(($TotalAu*1000)/$TotalPesoSeco,2,",",".")."</td>\n";
	else
		echo "<td>0</td>\n";
	if ($TipoInforme==6)
	{
		if ($TotalAs > 0 && $TotalPesoSeco > 0)
			echo "<td>".number_format(($TotalAs*100)/$TotalPesoSeco,2,",",".")."</td>\n";
		else
			echo "<td>0</td>\n";
		if ($TotalS > 0 && $TotalPesoSeco > 0)		
			echo "<td>".number_format(($TotalS*100)/$TotalPesoSeco,2,",",".")."</td>\n";
		else
			echo "<td>0</td>\n";
	}
	echo "<td>".number_format($TotalCu,0,",",".")."</td>\n";
	echo "<td>".number_format($TotalAg,0,",",".")."</td>\n";
	echo "<td>".number_format($TotalAu,0,",",".")."</td>\n";
	if ($TipoInforme==6)
	{
		echo "<td>".number_format($TotalAs,0,",",".")."</td>\n";
		echo "<td>".number_format($TotalS,0,",",".")."</td>\n";
	}
	//FIN LEYES	
	echo "</tr>";

?>      
</table>
</form>
</body>
</html>
