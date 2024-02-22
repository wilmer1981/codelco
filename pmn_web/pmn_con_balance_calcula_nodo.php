<?php
	function CalculaNodos($Ano,$Mes)
	{	
		$consulta = "SELECT DISTINCT nodo FROM proyecto_modernizacion.flujos t1";
		$consulta.= " inner JOIN proyecto_modernizacion.nodos t2 on t1.nodo=t2.cod_nodo ";
		$consulta.= " WHERE t1.sistema = 'PMN' and t2.virtual<>'S' ORDER BY t1.nodo";
		//echo $consulta."<br>";
		$rs = mysqli_query($link, $consulta);            
		while ($row = mysqli_fetch_array($rs))	
		{
			$Cont = 0;
			$Nodo = $row["nodo"];		
			$Peso = 0;
			$Fino_Cu = 0;
			$Fino_Ag = 0;
			$Fino_Au = 0;	
			
			//Existencias del Mes Pasado
			if ($Mes == 1)
				$AnoAnterior = $Ano - 1;
			else
				$AnoAnterior = $Ano;
			
			$consulta = "SELECT IFNULL(SUM(peso),0) AS peso, ";
			$consulta.= " IFNULL(SUM(fino_cu),0) AS fino_cu, ";
			$consulta.= " IFNULL(SUM(fino_ag),0) AS fino_ag, ";
			$consulta.= " IFNULL(SUM(fino_au),0) AS fino_au";
			$consulta.= " FROM pmn_web.existencia_nodo";
			$consulta.= " WHERE nodo = '".$Nodo."'";
			$consulta.= " AND ano = '".$AnoAnterior."' ";
			$consulta.= " AND mes = MONTH(SUBDATE('2004-".$Mes."-01', INTERVAL 1 MONTH))";
			//echo $consulta."<br>";
			$rs1 = mysqli_query($link, $consulta);
			if ($row1 = mysqli_fetch_array($rs1))
			{
				$Peso = $row1["peso"];
				$Fino_Cu = $row1["fino_cu"];					
				$Fino_Ag = $row1["fino_ag"];
				$Fino_Au = $row1["fino_au"];
			}		
			
			//Entradas.
			$consulta = "SELECT IFNULL(SUM(peso),0) AS peso, ";
			$consulta.= " IFNULL(SUM(fino_cu),0) AS fino_cu, ";
			$consulta.= " IFNULL(SUM(fino_ag),0) AS fino_ag, ";
			$consulta.= " IFNULL(SUM(fino_au),0) AS fino_au";
			$consulta.= " FROM pmn_web.flujos_mes AS t1";
			$consulta.= " INNER JOIN proyecto_modernizacion.flujos AS t2";
			$consulta.= " ON t1.flujo = t2.cod_flujo";
			$consulta.= " WHERE mes = '".$Mes."'";
			$consulta.= " AND ano = '".$Ano."'";
			$consulta.= " AND t2.nodo = '".$Nodo."'";
			$consulta.= " AND t2.tipo = 'E'";
			//echo $consulta."<br>";						
			$rs2 = mysqli_query($link, $consulta);
			if ($row2 = mysqli_fetch_array($rs2))
			{
				$Peso = $Peso + $row2["peso"];
				$Fino_Cu = $Fino_Cu + $row2["fino_cu"];
				$Fino_Ag = $Fino_Ag + $row2["fino_ag"];
				$Fino_Au = $Fino_Au + $row2["fino_au"];
			}	
			
			//Salidas.
			$consulta = "SELECT IFNULL(SUM(peso),0) AS peso, ";
			$consulta.= " IFNULL(SUM(fino_cu),0) AS fino_cu, ";
			$consulta.= " IFNULL(SUM(fino_ag),0) AS fino_ag, ";
			$consulta.= " IFNULL(SUM(fino_au),0) AS fino_au";
			$consulta.= " FROM pmn_web.flujos_mes AS t1";
			$consulta.= " INNER JOIN proyecto_modernizacion.flujos AS t2";
			$consulta.= " ON t1.flujo = t2.cod_flujo";
			$consulta.= " WHERE mes = '".$Mes."'";
			$consulta.= " AND ano = '".$Ano."'";
			$consulta.= " AND t2.nodo = '".$Nodo."'";
			$consulta.= " AND t2.tipo = 'S'";
			//echo $consulta."<br>";						
			$rs3 = mysqli_query($link, $consulta);
			if ($row3 = mysqli_fetch_array($rs3))
			{
				$Peso = $Peso + $row3["peso"];
				$Fino_Cu = $Fino_Cu + $row3["fino_cu"];
				$Fino_Ag = $Fino_Ag + $row3["fino_ag"];
				$Fino_Au = $Fino_Au + $row3["fino_au"];
			}
								   
			
			//INSERTO VALORES EN LA TABLA EXISTENCIA NODO	   
			$insertar = "INSERT INTO pmn_web.existencia_nodo ";
			$insertar.= " (ano,mes,nodo,peso,fino_cu,fino_ag,fino_au)";
			$insertar.= " VALUES ('".$Ano."',";
			$insertar.= "'".$Mes."',";
			$insertar.= "'".$Nodo."',";
			$insertar.= "'".$Peso."',";
			$insertar.= "'".$Fino_Cu."',";
			$insertar.= "'".$Fino_Ag."',";
			$insertar.= "'".$Fino_Au."')";
			//echo $Insertar."<br>";
			mysqli_query($link, $insertar);						
		}
	}
?>