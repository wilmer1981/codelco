<?php	
	function CalculaPesosTabla1($Flujo, $FechaIni, $FechaFin, $Ano, $Mes)
	{
		$consulta = "SELECT (IFNULL(SUM(peso_seco),0) / COUNT(*)) AS peso ";
		$consulta.= " FROM pmn_web.resultado_productos AS t1 ";
		
		if ($Flujo == '1')
			$consulta.= " WHERE YEAR(t1.lote) = YEAR('".$FechaIni."') AND MONTH(t1.lote) = MONTH('".$FechaIni."')";
		else
			$consulta.= " WHERE t1.fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
			
		$consulta.= " AND t1.flujo = '".$Flujo."'";
		$consulta.= " GROUP BY fecha,num_lixiviacion,lixiviador, lote, tambor, id_muestra,num_cajon,hornada,num_barra,num_electrolisis,num_anodos";
		//echo $consulta."<br>";

		$Peso = 0;
		$rs1 = mysqli_query($link, $consulta);
		while ($row1 = mysqli_fetch_array($rs1))
		{	
			$Peso = $Peso + $row1["peso"];
		}
		
		$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase";
		$consulta.= " WHERE cod_clase = '6013' AND cod_subclase = '".$Flujo."'";
		$rs2 = mysqli_query($link, $consulta);
		if ($row2 = mysqli_fetch_array($rs2))
			$Tipo = 'ENA';
		else
			$Tipo = '';
		
		$insertar = "INSERT INTO pmn_web.flujos_mes (ano, mes, flujo, peso, tipo)";
		$insertar.= " VALUES ('".$Ano."', '".$Mes."', '".$Flujo."', '".round($Peso,3)."', '".$Tipo."')";
		//echo $insertar."<br>";
		mysqli_query($link, $insertar);
	}
	
	//---.
	function CalculaPesosTabla2($Flujo, $FechaIni, $FechaFin, $Ano, $Mes)
	{
		//Es para ver si el producto es ajuste se debe agregar el signo.
		$TipoMov = '';
		$consulta = "SELECT DISTINCT t1.tipo_mov FROM pmn_web.relacion_flujo AS t1";
		$consulta.= " INNER JOIN pmn_web.productos_por_movimientos as t2";
		$consulta.= " ON t1.tipo_mov = t2.tipo_mov AND t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto";
		$consulta.= " WHERE t2.fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."' AND t1.flujo = '".$Flujo."'";		
		//echo $consulta."<br>";
		$rs2 = mysqli_query($link, $consulta);
		if ($row2 = mysqli_fetch_array($rs2))
			$TipoMov = $row[tipo_mov];
	
		$consulta = "SELECT IFNULL(SUM(t1.peso_seco),0) AS peso";
		$consulta.= " FROM pmn_web.productos_por_movimientos AS t1";
		$consulta.= " INNER JOIN pmn_web.relacion_flujo as t2";
		$consulta.= " ON t1.tipo_mov = t2.tipo_mov AND t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto";
		if ($TipoMov == '99')
				$consulta.= " AND t1.signo = t2.signo";
				
		$consulta.= " WHERE t1.fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."' AND t2.flujo = '".$Flujo."'";
		$consulta.= " GROUP BY t2.flujo";
		//echo $consulta."<br><br>";
		
		$rs1 = mysqli_query($link, $consulta);
		$row1 = mysqli_fetch_array($rs1);
		
		$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase";
		$consulta.= " WHERE cod_clase = '6013' AND cod_subclase = '".$Flujo."'";
		$rs2 = mysqli_query($link, $consulta);
		if ($row2 = mysqli_fetch_array($rs2))
			$Tipo = 'ENA';
		else
			$Tipo = '';		
		
		$insertar = "INSERT INTO pmn_web.flujos_mes (ano, mes, flujo, peso, tipo)";
		$insertar.= " VALUES ('".$Ano."', '".$Mes."', '".$Flujo."', '".round($row1["peso"],3)."', '".$Tipo."')";
		mysqli_query($link, $insertar);				
	}
	
	//---.
	function CalculaFinosTabla1($Flujo, $FechaIni, $FechaFin, $Ano, $Mes)
	{
		$leyes = array('04'=>0, '05'=>0);
		
		$consulta = "SELECT t1.cod_leyes, SUM(t1.fino) AS fino";
		$consulta.= " FROM pmn_web.resultado_productos AS t1";
		
		if ($Flujo == '1')
			$consulta.= " WHERE YEAR(t1.lote) = YEAR('".$FechaIni."') AND MONTH(t1.lote) = MONTH('".$FechaIni."')";
		else
			$consulta.= " WHERE t1.fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
				
		$consulta.= " AND t1.flujo = '".$Flujo."'";
		$consulta.= " AND t1.cod_leyes IN ('04','05')";
		$consulta.= " GROUP BY t1.cod_leyes";
		//echo $consulta."<br><br>";
		$rs1 = mysqli_query($link, $consulta);
		while ($row1 = mysqli_fetch_array($rs1))
		{
			$leyes[$row1["cod_leyes"]] = $row1[fino];
		}
		
		$actualizar = "UPDATE pmn_web.flujos_mes SET fino_ag = '".round($leyes['04'],3)."', fino_au = '".round($leyes['05'],3)."'";
		$actualizar.= " WHERE ano = '".$Ano."' AND mes = '".$Mes."' AND flujo = '".$Flujo."'";
		//echo $actualizar."<br>";
		mysqli_query($link, $actualizar);
	}
	
	function CalculaFinosTabla2($Flujo, $FechaIni, $FechaFin, $Ano, $Mes) 
	{
		//Es para ver si el producto es ajuste se debe agregar el signo.
		$TipoMov = '';
		$consulta = "SELECT DISTINCT t1.tipo_mov FROM pmn_web.relacion_flujo AS t1";
		$consulta.= " INNER JOIN pmn_web.productos_por_movimientos as t2";
		$consulta.= " ON t1.tipo_mov = t2.tipo_mov AND t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto";
		$consulta.= " WHERE t2.fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."' AND t1.flujo = '".$Flujo."'";		
		//echo $consulta."<br>";
		$rs2 = mysqli_query($link, $consulta);
		if ($row2 = mysqli_fetch_array($rs2))
			$TipoMov = $row[tipo_mov];
				
		$consulta = "SELECT IFNULL(SUM(t1.fino_ag),0) AS fino_ag, IFNULL(SUM(t1.fino_au),0) AS fino_au";
		$consulta.= " FROM pmn_web.productos_por_movimientos AS t1";
		$consulta.= " INNER JOIN pmn_web.relacion_flujo as t2";
		$consulta.= " ON t1.tipo_mov = t2.tipo_mov AND t1.cod_producto = t2.cod_producto AND t1.cod_subproducto = t2.cod_subproducto";
		if ($TipoMov == '99')
				$consulta.= " AND t1.signo = t2.signo";
				
		$consulta.= " WHERE t1.fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."' AND t2.flujo = '".$Flujo."'";
		//echo $consulta."<br><br>";
		$rs1 = mysqli_query($link, $consulta);
		$row1 = mysqli_fetch_array($rs1);
	
		$actualizar = "UPDATE pmn_web.flujos_mes SET fino_cu = '', fino_ag = '".round($row1[fino_ag],3)."', fino_au = '".round($row1[fino_au],3)."'";
		$actualizar.= " WHERE ano = '".$Ano."' AND mes = '".$Mes."' AND flujo = '".$Flujo."'";
		//echo $actualizar."<br>";
		mysqli_query($link, $actualizar);			
	}	
	
	//---.
	function CalculaConFlujos($Nodo, $Prod, $Flujo, $Ano, $Mes, $Suma, $Resta)
	{
		if ($Mes == 1)
		{
			$MesAnt = 12;
			$AnoAnt = $Ano - 1;						
		}
		else
		{
			$MesAnt = $Mes - 1;
			$AnoAnt = $Ano;
		}
		
		//INICIAL.
		$consulta = "SELECT IFNULL(SUM(peso),0) AS peso, IFNULL(SUM(fino_cu),0) AS fino_cu, IFNULL(SUM(fino_ag),0) AS fino_ag, IFNULL(SUM(fino_au),0) AS fino_au";
		$consulta.= " FROM pmn_web.existencia_nodo";
		$consulta.= " WHERE ano = '".$AnoAnt."' AND mes = '".$MesAnt."' AND nodo = '".$Nodo."' AND prod = '".$Prod."'";
		//echo $consulta."<br>";
		$rs = mysqli_query($link, $consulta);
		$row = mysqli_fetch_array($rs);
		
		$Peso = $row["peso"];
		$FinoCu = $row[fino_cu];
		$FinoAg = $row[fino_ag];
		$FinoAu = $row[fino_au];
		
		/*
		echo $FinoCu."<br>";
		echo $FinoAg."<br>";
		echo $FinoAu."<br>";
		*/
				
		//SUMAS.
		//echo $Suma."<br>";
		$vector = explode(',', $Suma);
		while(list($c,$v) = each($vector))
		{	
			$consulta = "SELECT IFNULL(SUM(peso),0) AS peso, IFNULL(SUM(fino_cu),0) AS fino_cu, IFNULL(SUM(fino_ag),0) AS fino_ag, IFNULL(SUM(fino_au),0) AS fino_au";
			$consulta.= " FROM pmn_web.flujos_mes";
			$consulta.= " WHERE ano = '".$Ano."' AND mes = '".$Mes."' AND flujo = '".$v."'";
			//echo $consulta."<br>";
			$rs1 = mysqli_query($link, $consulta);
			$row1 = mysqli_fetch_array($rs1);
			
			$Peso = $Peso + $row1["peso"];
			$FinoCu = $FinoCu + $row1[fino_cu];
			$FinoAg = $FinoAg + $row1[fino_ag];
			$FinoAu = $FinoAu + $row1[fino_au];									
		}

/*
		echo $Peso."<br>";		
		echo $FinoCu."<br>";
		echo $FinoAg."<br>";
		echo $FinoAu."<br>";
*/
		
		//RESTAS.
		//echo $Resta."<br>";
		$vector = explode(',', $Resta);
		while(list($c,$v) = each($vector))
		{	
			$consulta = "SELECT IFNULL(SUM(peso),0) AS peso, IFNULL(SUM(fino_cu),0) AS fino_cu, IFNULL(SUM(fino_ag),0) AS fino_ag, IFNULL(SUM(fino_au),0) AS fino_au";
			$consulta.= " FROM pmn_web.flujos_mes";
			$consulta.= " WHERE ano = '".$Ano."' AND mes = '".$Mes."' AND flujo = '".$v."'";
			//echo $consulta."<br>";
			$rs1 = mysqli_query($link, $consulta);
			$row1 = mysqli_fetch_array($rs1);
			
			$Peso = $Peso - $row1["peso"];
			$FinoCu = $FinoCu - $row1[fino_cu];
			$FinoAg = $FinoAg - $row1[fino_ag];
			$FinoAu = $FinoAu - $row1[fino_au];			
		}		

/*
		echo $Peso."<br><br>";		
		echo $FinoCu."<br>";
		echo $FinoAg."<br>";
		echo $FinoAu."<br>";
*/		
		
		//FINAL.
		$consulta = "SELECT IFNULL(SUM(peso),0) AS peso, IFNULL(SUM(fino_cu),0) AS fino_cu, IFNULL(SUM(fino_ag),0) AS fino_ag, IFNULL(SUM(fino_au),0) AS fino_au";
		$consulta.= " FROM pmn_web.existencia_nodo";
		$consulta.= " WHERE ano = '".$Ano."' AND mes = '".$Mes."' AND nodo = '".$Nodo."' AND prod = '".$Prod."'";
		//echo $consulta."<br>";
		$rs = mysqli_query($link, $consulta);
		$row = mysqli_fetch_array($rs);
				
		$Peso = $Peso - $row["peso"];
		$FinoCu = $FinoCu - $row[fino_cu];
		$FinoAg = $FinoAg - $row[fino_ag];
		$FinoAu = $FinoAu - $row[fino_au];
		
/*	
		echo $Peso."<br>";		
		echo $FinoCu."<br>";
		echo $FinoAg."<br>";
		echo $FinoAu."<br>";
*/				

		$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase";
		$consulta.= " WHERE cod_clase = '6013' AND cod_subclase = '".$Flujo."'";
		$rs2 = mysqli_query($link, $consulta);
		if ($row2 = mysqli_fetch_array($rs2))
			$Tipo = 'ENA';
		else
			$Tipo = '';
					
		//Inserta Registro.
		$insertar = "INSERT INTO pmn_web.flujos_mes (ano, mes, flujo, peso, tipo, fino_cu, fino_ag, fino_au)";
		$insertar.= " VALUES ('".$Ano."', '".$Mes."', '".$Flujo."', '".round(abs($Peso),3)."', '".$Tipo."', '".round(abs($FinoCu),3)."', '".round(abs($FinoAg),3)."', '".round(abs($FinoAu),3)."')";
		//echo $insertar."<br>";
		mysqli_query($link, $insertar);								
	}

	//---.
	function CalculaDifMetalurgicas($Nodo, $Mes, $Ano)
	{	
		$valores = '';
		
		$PesoEnt = 0;
		$FinoAgEnt = 0;
		$FinoAuEnt = 0;
		$PesoSal = 0;
		$FinoAgSal = 0;
		$FinoAuSal = 0;
		
		if ($Mes == 1)
		{
			$MesAnt = 12;
			$AnoAnt = $Ano - 1;						
		}
		else
		{
			$MesAnt = $Mes - 1;
			$AnoAnt = $Ano;
		}
				
		//Existencia Inicial (Ent).
		$consulta = "SELECT IFNULL(SUM(peso),0) AS peso, IFNULL(SUM(fino_ag),0) AS fino_ag, IFNULL(SUM(fino_au),0) AS fino_au";
		$consulta.= " FROM pmn_web.existencia_nodo";
		$consulta.= " WHERE ano = '".$AnoAnt."' AND mes = '".$MesAnt."' AND nodo = '".$Nodo."'";
		//echo $consulta."<br>";
		$rs = mysqli_query($link, $consulta);
		$row = mysqli_fetch_array($rs);
		$PesoEnt = $PesoEnt + round($row["peso"],3);
		$FinoAgEnt = $FinoAgEnt + round($row[fino_ag],3);
		$FinoAuEnt = $FinoAuEnt + round($row[fino_au],3);
		
		//Flujos Entradas (Ent).
		$consulta = "SELECT SUM(t2.peso) AS peso, SUM(t2.fino_ag) AS fino_ag, SUM(t2.fino_au) AS fino_au";	
		$consulta.= " FROM proyecto_modernizacion.flujos AS t1";
		$consulta.= " LEFT JOIN pmn_web.flujos_mes AS t2";
		$consulta.= " ON t1.cod_flujo = t2.flujo AND ano = '".$Ano."' AND mes = '".$Mes."' AND t1.sistema = 'PMN'";
		$consulta.= " WHERE t1.nodo = '".$Nodo."' AND (t1.esflujo != 'N' OR ISNULL(t1.esflujo)) AND t1.tipo = 'E'";
		//echo $consulta."<br>";		
		$rs = mysqli_query($link, $consulta);
		$row = mysqli_fetch_array($rs);
		$PesoEnt = $PesoEnt + round($row["peso"],3);
		$FinoAgEnt = $FinoAgEnt + round($row[fino_ag],3);
		$FinoAuEnt = $FinoAuEnt + round($row[fino_au],3);			
		
		//Existencia Final (Sal).
		$consulta = "SELECT IFNULL(SUM(peso),0) AS peso, IFNULL(SUM(fino_ag),0) AS fino_ag, IFNULL(SUM(fino_au),0) AS fino_au";
		$consulta.= " FROM pmn_web.existencia_nodo";
		$consulta.= " WHERE ano = '".$Ano."' AND mes = '".$Mes."' AND nodo = '".$Nodo."'";
		$rs = mysqli_query($link, $consulta);
		$row = mysqli_fetch_array($rs);
		$PesoSal = $PesoSal + round($row["peso"],3);
		$FinoAgSal = $FinoAgSal + round($row[fino_ag],3);
		$FinoAuSal = $FinoAuSal + round($row[fino_au],3);
		
		//Flujos Entradas (Ent).
		$consulta = "SELECT SUM(t2.peso) AS peso, SUM(t2.fino_ag) AS fino_ag, SUM(t2.fino_au) AS fino_au";	
		$consulta.= " FROM proyecto_modernizacion.flujos AS t1";
		$consulta.= " LEFT JOIN pmn_web.flujos_mes AS t2";
		$consulta.= " ON t1.cod_flujo = t2.flujo AND ano = '".$Ano."' AND mes = '".$Mes."' AND t1.sistema = 'PMN'";
		$consulta.= " WHERE t1.nodo = '".$Nodo."' AND (t1.esflujo != 'N' OR ISNULL(t1.esflujo)) AND t1.tipo = 'S'";
		$rs = mysqli_query($link, $consulta);
		$row = mysqli_fetch_array($rs);
		$PesoSal = $PesoSal + round($row["peso"],3);
		$FinoAgSal = $FinoAgSal + round($row[fino_ag],3);
		$FinoAuSal = $FinoAuSal + round($row[fino_au],3);
		
		//Totales.
		$TotalPeso = round($PesoEnt - $PesoSal,3);
		$TotalFinoAg = round($FinoAgEnt - $FinoAgSal,3);
		$TotalFinoAu = round($FinoAuEnt - $FinoAuSal,3);
			
		if (($TotalPeso != 0) or ($TotalFinoAg != 0) or ($TotalFinoAu != 0))
			$valores = 'S~';
		else 
			$valores = 'N~';
		
		$valores.= $TotalPeso.'~'.$TotalFinoAg.'~'.$TotalFinoAu;
		return $valores;
	}
	
	
	//----.
	function CalculaFlujos($Ano,$Mes)
	{
		$FechaIni = $Ano.'-'.$Mes.'-01';
		$FechaFin = $Ano.'-'.$Mes.'-31';
		
		$consulta = "SELECT * FROM proyecto_modernizacion.flujos";
		$consulta.= " WHERE sistema = 'PMN'";
		$consulta.= " AND (calcular = 'S' OR (calcular = 'N' AND tabla != '0')) AND (esflujo != 'N' OR ISNULL(esflujo))";
		$consulta.= " ORDER BY calcular ASC, CEILING(nodo), CEILING(cod_flujo)";
		//echo $consulta."<br>";
		$rs = mysqli_query($link, $consulta);
		while ($row = mysqli_fetch_array($rs))
		{
			if ($row[calcular] == "S")
			{
				CalculaConFlujos($row["nodo"], $row[prod], $row[cod_flujo], $Ano, $Mes, $row[suma], $row[resta]);			
			}
			else
			{
				if ($row[tabla] == 1) //1: resultado_productos.
				{
					CalculaPesosTabla1($row[cod_flujo],$FechaIni,$FechaFin,$Ano,$Mes);
					CalculaFinosTabla1($row[cod_flujo],$FechaIni,$FechaFin,$Ano,$Mes);					
				}
				else if ($row[tabla] == 2)  //2:productos_por_movimientos.
					{
						CalculaPesosTabla2($row[cod_flujo],$FechaIni,$FechaFin,$Ano,$Mes);
						CalculaFinosTabla2($row[cod_flujo],$FechaIni,$FechaFin,$Ano,$Mes);						
					}
			}			
		}		
	}
?>
	