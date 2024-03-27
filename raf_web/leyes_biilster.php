<?
	include("../principal/conectar_sef_web.php");	
	$FechaIni = $AnoFin."-".str_pad($MesFin,2,0,STR_PAD_LEFT)."-01";
	$FechaFin = $AnoFin."-".str_pad($MesFin,2,0,STR_PAD_LEFT)."-31";
	//$TituloInforme = "PRODUCCION BLISTER";
	$ProductoSef = "= '7'";
	$EquipoSef = "in(7,8,9)";
	$Origen = "in(7,8,9)";
	$Destino = "= '3'";
	$Movimiento = "S";
	$CodProducto = 16;
	$CodSubproducto = 41; 
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
		$Consulta = "select week('".$FechaAux."') as num_semana";
		$Resp2 = mysqli_query($link, $Consulta);
		$Fila2 = mysql_fetch_array($Resp2);
		$NumSemana = $Fila2["num_semana"];			
		//LEYES SEMANALES				
		$Consulta = "select t1.nro_solicitud, t2.cod_leyes, t2.valor, t2.cod_unidad, t3.conversion ";
		$Consulta.= " from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2 ";
		$Consulta.= " on t1.nro_solicitud = t2.nro_solicitud and t1.recargo = t2.recargo ";
		$Consulta.= " inner join proyecto_modernizacion.unidades t3 on t2.cod_unidad = t3.cod_unidad ";
		$Consulta.= " where t1.cod_periodo = '2'"; //POR SEMANA
		$Consulta.= " and t1.cod_producto = '".$CodProducto."'";
		$Consulta.= " and t1.cod_subproducto = '".$CodSubproducto."'";
		$Consulta.= " and t1.tipo = '1'";
		$Consulta.= " and t1.cod_analisis = '1'";
		$Consulta.= " and t1.nro_semana = '".$NumSemana."' ";
		$Consulta.= " and t1.a�o = '".intval(substr($FechaAux,0,4))."' ";
		$Consulta.= " and t1.mes = '".intval(substr($FechaAux,5,2))."' ";	
		if ($TipoInforme == 6)
			$Consulta.= " and (t2.cod_leyes = '02' or t2.cod_leyes = '04' or t2.cod_leyes = '05')";// or t2.cod_leyes = '26')";						
		else					
			$Consulta.= " and (t2.cod_leyes = '02' or t2.cod_leyes = '04' or t2.cod_leyes = '05')";						
		$Consulta.= " and (t2.valor <> '' and NOT isnull(t2.valor))";
		$Consulta.= " order by t1.id_muestra, t2.cod_leyes";
		$Resp2 = mysqli_query($link, $Consulta);
		while ($Fila2 = mysql_fetch_array($Resp2))
		{	
			for ($j=$PriDia;$j<=$UltDia;$j++)	
			{	
				switch ($Fila2["cod_leyes"])
				{					
					case "02":										
						$ArrLeyes[$j][0] = $i;//DIA
						$ArrLeyes[$j][1] = $Fila2["cod_leyes"];
						$ArrLeyes[$j][2] = $Fila2["valor"];
						$ArrLeyes[$j][3] = $Fila2["unidad"];
						$ArrLeyes[$j][4] = $Fila2["conversion"];
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
				}//FIN SWITCH		
			}//FIN FOR
		}//FON WHILE
	}//FIN FOR 4 SEMANAS