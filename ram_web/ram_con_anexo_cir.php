<?php 
$CodigoDeSistema = 16;
$CodigoDePantalla = 4;
include("../principal/conectar_principal.php");

if(isset($_REQUEST["Mostrar"])){
	$Mostrar = $_REQUEST["Mostrar"];
}else{
	$Mostrar = "";
}
if(isset($_REQUEST["Ano"])){
	$Ano = $_REQUEST["Ano"];
}else{
	$Ano = date("Y");
}
if(isset($_REQUEST["Mes"])){
	$Mes = $_REQUEST["Mes"];
}else{
	$Mes = date("m");
}

if ($Mostrar == "S")
{
	$Consulta = "SELECT * FROM ram_web.existencia_nodo_cir";
	$Consulta.= " WHERE ano = '".$Ano."' AND mes = '".$Mes."'";
	$Consulta.= " AND bloqueado = '1'";
	$Resp2 = mysqli_query($link, $Consulta);
	if (!$Fila2 = mysqli_fetch_array($Resp2))
	{		
		//LIMPIA TABLAS FLUJOS_MES Y EXISTENCIA NODO
		$Eliminar = "DELETE FROM ram_web.flujos_mes_cir where ano='".$Ano."' and mes='".$Mes."'";
		mysqli_query($link, $Eliminar);
		$Eliminar = "DELETE FROM ram_web.existencia_nodo_cir where ano='".$Ano."' and mes='".$Mes."'";
		mysqli_query($link, $Eliminar);
		$FechaIni = $Ano."-".$Mes."-01";
		$FechaFin = date("Y-m-d", mktime(0,0,0,$Mes+1,1,$Ano));
		$FechaFin = date("Y-m-d", mktime(0,0,0,intval(substr($FechaFin,5,2)),1-1,intval(substr($FechaFin,0,4))));	
		$FechaHoraIni = $Ano."-".$Mes."-01 08:00:00";
		$FechaHoraFin = date("Y-m-d", mktime(0,0,0,$Mes+1,1,$Ano));
		$FechaHoraFin = $FechaHoraFin." 07:59:59";
		$FechaFinAnt = date("Y-m-d", mktime(0,0,0,$Mes,1-1,$Ano));
		//ASIGNA FINOS A LOS VALORES DE STOCK EN PISO
		$Consulta = "select * from ram_web.stock_piso ";
		$Consulta.= " where fecha = '".$FechaFin."'";
		$Consulta.= " and tipo_calculo <> 'M' "; //OSEA CUANDO TIPO CALCULO = "A" AUTOMATICO O "" NULO
		$Resp = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Resp))
		{
			$PisoActual = $Fila["peso_humedo"];
			$Consulta = "select distinct nodo from ram_web.param_circulante ";
			$Consulta.= " where cod_producto = '".$Fila["cod_producto"]."' and cod_subproducto = '".$Fila["cod_subproducto"]."'";
			$Resp3 = mysqli_query($link, $Consulta);
			if ($Fila3 = mysqli_fetch_array($Resp3))
			{
				$Consulta = "SELECT distinct t3.num_conjunto, t3.rut_proveedor, sum(peso_humedo) as peso_humedo,";
				$Consulta.= " sum(peso_seco) as peso_seco, SUM(fino_cu) as fino_cu, sum(fino_ag)as fino_ag, sum(fino_au) AS fino_au, sum(fino_as) AS fino_as";
				$Consulta.= " from ram_web.conjunto_ram_bd t1 inner join ram_web.param_circulante t2";
				$Consulta.= " on t1.cod_producto = t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto";
				$Consulta.= " inner join ram_web.movimiento_proveedor t3 on t1.num_conjunto = t3.num_conjunto";
				$Consulta.= " where t1.cod_conjunto='03'";
				$Consulta.= " and t2.nodo = '".$Fila3["nodo"]."'";
				$Consulta.= " and t3.fecha_movimiento = '".$FechaFin."'";
				$Consulta.= " and t3.cod_existencia='01'";//EXIST. FINAL
				$Consulta.= " group by t2.nodo";
				$Resp4 = mysqli_query($link, $Consulta);
				if ($Fila4 = mysqli_fetch_array($Resp4))
				{	
					$PesoHumedo = $Fila4["peso_humedo"];				
					$PesoSeco = $Fila4["peso_seco"];
					$FinoCu = $Fila4["fino_cu"];
					$FinoAg = $Fila4["fino_ag"];
					$FinoAu = $Fila4["fino_au"];
					$FinoAs = $Fila4["fino_as"];
					if ($PesoSeco>0 && $PesoHumedo>0)
					{
						$LeyH2O = 100-(($PesoSeco*100)/$PesoHumedo);
						$PesoSecoSP = $PisoActual - (($PisoActual * $LeyH2O)/100);
					}
					if ($PesoSeco>0 && $FinoCu>0)
					{
						$LeyCu = ($FinoCu/$PesoSeco)*100;
						$FinoCuSP = (($PisoActual * $LeyCu)/100);
					}
					if ($PesoSeco>0 && $FinoAg>0)
					{
						$LeyAg = ($FinoAg/$PesoSeco)*1000;
						$FinoAgSP = (($PisoActual * $LeyAg)/1000);
					}
					if ($PesoSeco>0 && $FinoAu>0)
					{
						$LeyAu = ($FinoAu/$PesoSeco)*1000;
						$FinoAuSP = (($PisoActual * $LeyAu)/1000);
					}
					if ($PesoSeco>0 && $FinoAs>0)
					{
						$LeyAs = ($FinoAs/$PesoSeco)*100;
						$FinoAsSP = (($PisoActual * $LeyAs)/100);
					}
					//echo $Fila["cod_producto"]."-".$Fila["cod_subproducto"]." == Hum=".$LeyH2O."; Cu=".$LeyCu."; Ag=".$LeyAg."; Au=".$LeyAu."<br>";
					$Actualizar = "UPDATE ram_web.stock_piso set ";
					$Actualizar.= " peso_seco = '".$PesoSecoSP."' ";
					$Actualizar.= " , fino_cu = '".$FinoCuSP."' ";
					$Actualizar.= " , fino_ag = '".$FinoAgSP."' ";
					$Actualizar.= " , fino_au = '".$FinoAuSP."' ";
					$Actualizar.= " , fino_as = '".$FinoAsSP."' ";
					$Actualizar.= " where fecha = '".$FechaFin."' and cod_existencia='01' ";
					$Actualizar.= " and cod_producto = '".$Fila["cod_producto"]."' and cod_subproducto = '".$Fila["cod_subproducto"]."'";
					mysqli_query($link, $Actualizar);
					//echo $Actualizar."<br>";
					$PesoHumedo = 0;				
					$PesoSeco = 0;
					$FinoCu = 0;
					$FinoAg = 0;
					$FinoAu = 0;
					$FinoAs = 0;
				}		
			}
		}
		//NODOS	
		$Consulta = "select distinct nodo ";
		$Consulta.= " from ram_web.param_circulante ";
		$Consulta.= " order by nodo";
		$Resp = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Resp))
		{
			$Consulta = "SELECT distinct t3.num_conjunto, t3.rut_proveedor, sum(peso_humedo) as peso_humedo,";
			$Consulta.= " sum(peso_seco) as peso_seco, SUM(fino_cu) as fino_cu, sum(fino_ag)as fino_ag, sum(fino_au) AS fino_au, sum(fino_as) AS fino_as";
			$Consulta.= " from ram_web.conjunto_ram_bd t1 inner join ram_web.param_circulante t2";
			$Consulta.= " on t1.cod_producto = t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto";
			$Consulta.= " inner join ram_web.movimiento_proveedor t3 on t1.num_conjunto = t3.num_conjunto";
			$Consulta.= " where t1.cod_conjunto='03'";
			$Consulta.= " and t2.nodo = '".$Fila["nodo"]."'";
			$Consulta.= " and t3.fecha_movimiento = '".$FechaFin."'";
			$Consulta.= " and t3.cod_existencia='01'";//EXIST. FINAL
			$Consulta.= " group by t2.nodo";
			$Resp2 = mysqli_query($link, $Consulta);
			//echo $Consulta."<br>";
			if ($Fila2 = mysqli_fetch_array($Resp2))
			{
				$Consulta = "SELECT distinct t1.cod_producto, t1.cod_subproducto, t2.nodo, t1.peso_seco, t1.fino_cu, t1.fino_ag, t1.fino_au, t1.fino_as ";
				$Consulta.= " from ram_web.stock_piso t1 inner join ram_web.param_circulante t2";
				$Consulta.= " on t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto";
				$Consulta.= " WHERE t2.nodo = '".$Fila["nodo"]."'";
				$Consulta.= " and fecha = '".$FechaFin."'";
				$Resp3 = mysqli_query($link, $Consulta);
				$StockPisoActual = 0;
				$FinoCuActual = 0;
				$FinoAgActual = 0;
				$FinoAuActual = 0;
				$FinoAsActual = 0;
				while ($Fila3 = mysqli_fetch_array($Resp3))
				{
					$StockPisoActual = $StockPisoActual + $Fila3["peso_seco"];
					$FinoCuActual = $FinoCuActual + $Fila3["fino_cu"];
					$FinoAgActual = $FinoAgActual + $Fila3["fino_ag"];
					$FinoAuActual = $FinoAuActual + $Fila3["fino_au"];
					$FinoAsActual = $FinoAsActual + $Fila3["fino_as"];
				}				
				$PesoNodo = $Fila2["peso_seco"] + $StockPisoActual;
				$PesoFinoCu = $Fila2["fino_cu"] + $FinoCuActual;
				$PesoFinoAg = $Fila2["fino_ag"] + $FinoAgActual;
				$PesoFinoAu = $Fila2["fino_au"] + $FinoAuActual;
				$PesoFinoAs = $Fila2["fino_as"] + $FinoAsActual;
				$Insertar = "Insert into ram_web.existencia_nodo_cir (ano, mes, nodo, peso, fino_cu, fino_ag, fino_au, fino_as) ";
				$Insertar.= " VALUES('".$Ano."','".$Mes."','".$Fila["nodo"]."','".$PesoNodo."','".$PesoFinoCu."','".$PesoFinoAg."','".$PesoFinoAu."', '".$PesoFinoAs."')";
				mysqli_query($link, $Insertar);
				$PesoNodo = 0;
				$PesoFinoCu = 0;
				$PesoFinoAg = 0;
				$PesoFinoAu = 0;
				$PesoFinoAs = 0;
			}		
		}
		//FIN NODOS
		//FLUJOS
		$Consulta = "select distinct flujo, tipo_movimiento as tipo ";
		$Consulta.= " from ram_web.param_circulante ";
		$Consulta.= " order by flujo";
		$Resp = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Resp))
		{
			$Peso = 0;
			$FinoCu = 0;
			$FinoAg = 0;
			$FinoAu = 0;
			$FinoAs = 0;			
			if ($Fila["tipo"]=="E")
			{
				#RECEPCION
				$Consulta = " SELECT t3.num_conjunto, t3.rut_proveedor, sum(peso_humedo) as peso_humedo,";
				$Consulta.= " sum(peso_seco) as peso_seco, SUM(fino_cu) as fino_cu, sum(fino_ag)as fino_ag, sum(fino_au) AS fino_au, sum(fino_as) AS fino_as";
				$Consulta.= " from ram_web.conjunto_ram_bd t1 inner join ram_web.param_circulante t2";
				$Consulta.= " on t1.cod_producto = t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto";
				$Consulta.= " inner join ram_web.movimiento_proveedor t3 on t1.num_conjunto = t3.num_conjunto";
				$Consulta.= " where t1.cod_conjunto='03'";
				$Consulta.= " and t2.flujo = '".$Fila["flujo"]."'";
				$Consulta.= " and t3.fecha_movimiento BETWEEN '".$FechaIni."' and '".$FechaFin."'";
				$Consulta.= " and (t3.cod_existencia='02')";
				$Consulta.= " group by t2.flujo";				
				$Resp2 = mysqli_query($link, $Consulta);
				if ($Fila2 = mysqli_fetch_array($Resp2))
				{
					$Peso = $Fila2["peso_seco"];
					$FinoCu = $Fila2["fino_cu"];
					$FinoAg = $Fila2["fino_ag"];
					$FinoAu = $Fila2["fino_au"];
					$FinoAs = $Fila2["fino_as"];
				}
				
				#TRASP. DESDE CONJ.
				$Consulta = " SELECT t3.num_conjunto, t3.rut_proveedor, sum(peso_humedo) as peso_humedo,";
				$Consulta.= " sum(peso_seco) as peso_seco, SUM(fino_cu) as fino_cu, sum(fino_ag)as fino_ag, sum(fino_au) AS fino_au, sum(fino_as) AS fino_as";
				$Consulta.= " from ram_web.conjunto_ram_bd t1 inner join ram_web.param_circulante t2";
				$Consulta.= " on t1.cod_producto = t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto";
				$Consulta.= " inner join ram_web.movimiento_proveedor t3 on t1.num_conjunto = t3.conjunto_destino";
				$Consulta.= " where t1.cod_conjunto='03'";
				$Consulta.= " and t2.flujo = '".$Fila["flujo"]."'";
				$Consulta.= " and t3.fecha_movimiento BETWEEN '".$FechaHoraIni."' and '".$FechaHoraFin."'";
				$Consulta.= " and (t3.cod_existencia='15')";
				$Consulta.= " group by t2.flujo";				
				$Resp2 = mysqli_query($link, $Consulta);
				if ($Fila2 = mysqli_fetch_array($Resp2))
				{
					$Peso = $Peso + $Fila2["peso_seco"];
					$FinoCu = $FinoCu + $Fila2["fino_cu"];
					$FinoAg = $FinoAg + $Fila2["fino_ag"];
					$FinoAu = $FinoAu + $Fila2["fino_au"];
					$FinoAs = $FinoAs + $Fila2["fino_as"];
				}
								
			}
	
			if ($Fila["tipo"]=="S")
			{		 
				#BENEFICIO (TRASPASO)
				$Consulta = " SELECT t3.num_conjunto, sum(peso_humedo) as peso_humedo, sum(peso_seco) as peso_seco, ";
				$Consulta.= " SUM(fino_cu) as fino_cu, sum(fino_ag)as fino_ag, sum(fino_au) AS fino_au, sum(fino_as) AS fino_as ";
				$Consulta.= " from ram_web.conjunto_ram_bd t1 inner join ram_web.param_circulante t2 ";
				$Consulta.= " on t1.cod_producto = t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
				$Consulta.= " inner join ram_web.movimiento_proveedor t3 on t1.num_conjunto = t3.num_conjunto ";
				$Consulta.= " where t1.cod_conjunto='03' ";
				$Consulta.= " and t2.flujo = '".$Fila["flujo"]."'";
				$Consulta.= " and t3.fecha_movimiento BETWEEN '".$FechaHoraIni."' and '".$FechaHoraFin."'";
				$Consulta.= " and (t3.cod_existencia='12') ";
				$Consulta.= " group by t2.flujo ";
				//echo $Consulta."<br>";
				$Resp2 = mysqli_query($link, $Consulta);
				if ($Fila2 = mysqli_fetch_array($Resp2))
				{
					$Peso = $Fila2["peso_seco"];
					$FinoCu = $Fila2["fino_cu"];
					$FinoAg = $Fila2["fino_ag"];
					$FinoAu = $Fila2["fino_au"];
					$FinoAs = $Fila2["fino_as"];
				}
				if ($Peso < 0) //SI DATO ES NEGATIVO
				{
					#TRASP. A CONJ.
					$Consulta = " SELECT t3.num_conjunto, t3.rut_proveedor, sum(peso_humedo) as peso_humedo,";
					$Consulta.= " sum(peso_seco) as peso_seco, SUM(fino_cu) as fino_cu, sum(fino_ag)as fino_ag, sum(fino_au) AS fino_au, sum(fino_as) AS fino_as";
					$Consulta.= " from ram_web.conjunto_ram_bd t1 inner join ram_web.param_circulante t2";
					$Consulta.= " on t1.cod_producto = t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto";
					$Consulta.= " inner join ram_web.movimiento_proveedor t3 on t1.num_conjunto = t3.num_conjunto";
					$Consulta.= " where t1.cod_conjunto='03'";
					$Consulta.= " and t2.flujo = '".$Fila["flujo"]."'";
					$Consulta.= " and t3.fecha_movimiento BETWEEN '".$FechaHoraIni."' and '".$FechaHoraFin."'";
					$Consulta.= " and (t3.cod_existencia='15')";
					$Consulta.= " group by t2.flujo";				
					$Resp2 = mysqli_query($link, $Consulta);
					if ($Fila2 = mysqli_fetch_array($Resp2))
					{
						$Peso = $Peso + $Fila2["peso_seco"];
						$FinoCu = $FinoCu + $Fila2["fino_cu"];
						$FinoAg = $FinoAg + $Fila2["fino_ag"];
						$FinoAu = $FinoAu + $Fila2["fino_au"];
						$FinoAs = $FinoAs + $Fila2["fino_as"];
					}
				}//FIN SI DATO ES NEGATIVO
			}
			//$Insertar = "Insert into ram_web.flujos_mes_cir (ano, mes, flujo, peso, fino_cu, fino_ag, fino_au, fino_as) ";
			$Insertar = "INSERT IGNORE INTO ram_web.flujos_mes_cir (ano, mes, flujo, peso, fino_cu, fino_ag, fino_au, fino_as) ";
			$Insertar.= " VALUES('".$Ano."','".$Mes."','".$Fila["flujo"]."','".$Peso."','".$FinoCu."','".$FinoAg."','".$FinoAu."','".$FinoAs."')";
			mysqli_query($link, $Insertar);
		}//FIN FLUJOS
		//AJUSTE DE COOKIES
		$Consulta = "select * from ram_web.cookie";
		$Consulta.= " where ano='".$Ano."' and mes='".$Mes."'";
		$Resp = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Resp))
		{			
			$Actualizar = "UPDATE ram_web.flujos_mes_cir set ";
			$Actualizar.= " peso = (peso + ".$Fila["peso_seco"].") ";
			$Actualizar.= " ,fino_cu = (fino_cu + ".$Fila["fino_cu"].") ";
			$Actualizar.= " ,fino_ag = (fino_ag + ".$Fila["fino_ag"].") ";
			$Actualizar.= " ,fino_au = (fino_au + ".$Fila["fino_au"].") ";
			$Actualizar.= " ,fino_as = (fino_as + ".$Fila["fino_as"].") ";
			$Actualizar.= " where flujo = '".$Fila["flujo"]."' ";
			$Actualizar.= " and ano='".$Ano."' and mes='".$Mes."'";
			mysqli_query($link, $Actualizar);					
		}
		//MANEJA STOCK DE PISO
		//FLUJO - TIPO
		$Consulta = "select distinct nodo ";
		$Consulta.= " from ram_web.param_circulante ";
		$Consulta.= " order by nodo";
		$Resp = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Resp))
		{
			$StockPisoAnt = 0;
			$StockPisoActual = 0;
			$FinoCuAnt = 0;
			$FinoAgAnt = 0;
			$FinoAuAnt = 0;
			$FinoAsAnt = 0;
			$FinoCuActual = 0;
			$FinoAgActual = 0;
			$FinoAuActual = 0;
			$FinoAsActual = 0;
			$Consulta = "select distinct cod_producto, cod_subproducto ";
			$Consulta.= " from ram_web.param_circulante ";
			$Consulta.= " where nodo='".$Fila["nodo"]."'";
			$Consulta.= " order by flujo";
			$Resp3 = mysqli_query($link, $Consulta);
			while ($Fila3 = mysqli_fetch_array($Resp3))
			{
				//STOCK PISO MES ANTERIOR						
				$Consulta = "SELECT peso_seco, fino_cu, fino_ag, fino_au, fino_as ";
				$Consulta.= " from ram_web.stock_piso ";
				$Consulta.= " WHERE cod_producto = '".$Fila3["cod_producto"]."'";
				$Consulta.= " and cod_subproducto = '".$Fila3["cod_subproducto"]."'";
				$Consulta.= " and fecha = '".$FechaFinAnt."'";
				$Resp2 = mysqli_query($link, $Consulta);
				if ($Fila2 = mysqli_fetch_array($Resp2))
				{
					$StockPisoAnt = $StockPisoAnt + $Fila2["peso_seco"];
					$FinoCuAnt = $FinoCuAnt + $Fila2["fino_cu"];
					$FinoAgAnt = $FinoAgAnt + $Fila2["fino_ag"];
					$FinoAuAnt = $FinoAuAnt + $Fila2["fino_au"];
					$FinoAsAnt = $FinoAsAnt + $Fila2["fino_as"];
				}
				//STOCK PISO MES ACTUAL
				$FechaFinAnt = date("Y-m-d", mktime(0,0,0,$Mes,1-1,$Ano));				
				$Consulta = "SELECT peso_seco, fino_cu, fino_ag, fino_au, fino_as  ";
				$Consulta.= " from ram_web.stock_piso ";
				$Consulta.= " WHERE cod_producto = '".$Fila3["cod_producto"]."'";
				$Consulta.= " and cod_subproducto = '".$Fila3["cod_subproducto"]."'";
				$Consulta.= " and fecha = '".$FechaFin."'";
				$Resp2 = mysqli_query($link, $Consulta);
				if ($Fila2 = mysqli_fetch_array($Resp2))
				{
					$StockPisoActual = $StockPisoActual + $Fila2["peso_seco"];
					$FinoCuActual = $FinoCuActual + $Fila2["fino_cu"];
					$FinoAgActual = $FinoAgActual + $Fila2["fino_ag"];
					$FinoAuActual = $FinoAuActual + $Fila2["fino_au"];
					$FinoAsActual = $FinoAsActual + $Fila2["fino_as"];
				}
			}
			$DifStockPiso = $StockPisoAnt - $StockPisoActual;
			//echo "NODO = ".$Fila["nodo"]."   DIF. PISO = ".$DifStockPiso. "<br>";
			$DifFinoCu = $FinoCuAnt - $FinoCuActual;
			$DifFinoAg = $FinoAgAnt - $FinoAgActual;
			$DifFinoAu = $FinoAuAnt - $FinoAuActual;
			$DifFinoAs = $FinoAsAnt - $FinoAsActual;
			if ($DifStockPiso>0)
			{
				$Consulta = "select distinct flujo from ram_web.param_circulante ";
				$Consulta.= " where nodo='".$Fila["nodo"]."' and tipo_movimiento='S'";
				$Resp2 = mysqli_query($link, $Consulta);
				if ($Fila2 = mysqli_fetch_array($Resp2))
				{
					//AJUSTA BENEFICIO
					$Actualizar = "UPDATE ram_web.flujos_mes_cir set ";
					$Actualizar.= " peso = (peso + ".abs($DifStockPiso).") ";
					$Actualizar.= " , fino_cu = (fino_cu + ".abs($DifFinoCu).") ";
					$Actualizar.= " , fino_ag = (fino_ag + ".abs($DifFinoAg).") ";
					$Actualizar.= " , fino_au = (fino_au + ".abs($DifFinoAu).") ";
					$Actualizar.= " , fino_as = (fino_as + ".abs($DifFinoAs).") ";
					$Actualizar.= " where flujo = '".$Fila2["flujo"]."' ";
					$Actualizar.= " and ano='".$Ano."' and mes='".$Mes."'";
					mysqli_query($link, $Actualizar);
					//CALCULA BENEFICIO
					//STOCK INICIAL
					$FechaAux = date("Y-m-d", mktime(0,0,0,$Mes-1,1,$Ano));
					$AnoAnt = intval(substr($FechaAux,0,4));
					$MesAnt = intval(substr($FechaAux,5,2));
					$Consulta = "select * from ram_web.existencia_nodo_cir ";
					$Consulta.= " where nodo = '".$Fila["nodo"]."' ";
					$Consulta.= " and ano='".$AnoAnt."' and mes='".$MesAnt."'";
					$Resp3 = mysqli_query($link, $Consulta);
					if ($Fila3 = mysqli_fetch_array($Resp3))
					{
						$PesoInicial = $Fila3["peso"];
						$FinoCuInicial = $Fila3["fino_cu"];
						$FinoAgInicial = $Fila3["fino_ag"];
						$FinoAuInicial = $Fila3["fino_au"];
						$FinoAsInicial = $Fila3["fino_as"];
					}
					else
					{
						$PesoInicial = 0;
						$FinoCuInicial = 0;
						$FinoAgInicial = 0;
						$FinoAuInicial = 0;
						$FinoAsInicial = 0;
					}
					//FLUJO DE RECEPCION
					$Consulta = "select distinct flujo from ram_web.param_circulante ";
					$Consulta.= " where nodo='".$Fila["nodo"]."' and tipo_movimiento='E'";
					$RespRecep = mysqli_query($link, $Consulta);
					if ($FilaRecep = mysqli_fetch_array($RespRecep))
					{
						$Consulta = "select * from ram_web.flujos_mes_cir ";
						$Consulta.= " where flujo = '".$FilaRecep["flujo"]."' ";
						$Consulta.= " and ano='".$Ano."' and mes='".$Mes."'";
						$Resp3 = mysqli_query($link, $Consulta);
						if ($Fila3 = mysqli_fetch_array($Resp3))
						{
							$PesoRecepcion = $Fila3["peso"];
							$FinoCuRecepcion = $Fila3["fino_cu"];
							$FinoAgRecepcion = $Fila3["fino_ag"];
							$FinoAuRecepcion = $Fila3["fino_au"];
							$FinoAsRecepcion = $Fila3["fino_as"];
						}
						else
						{
							$PesoRecepcion = 0;
							$FinoCuRecepcion = 0;
							$FinoAgRecepcion = 0;
							$FinoAuRecepcion = 0;
							$FinoAsRecepcion = 0;
						}
					}
					//EXISTENCIA FINAL
					$Consulta = "select * from ram_web.existencia_nodo_cir ";
					$Consulta.= " where nodo = '".$Fila["nodo"]."' ";
					$Consulta.= " and ano='".$Ano."' and mes='".$Mes."'";
					$Resp3 = mysqli_query($link, $Consulta);
					if ($Fila3 = mysqli_fetch_array($Resp3))
					{
						$PesoFinal = $Fila3["peso"];
						$FinoCuFinal = $Fila3["fino_cu"];
						$FinoAgFinal = $Fila3["fino_ag"];
						$FinoAuFinal = $Fila3["fino_au"];
						$FinoAsFinal = $Fila3["fino_as"];
					}
					else
					{
						$PesoFinal = 0;
						$FinoCuFinal = 0;
						$FinoAgFinal = 0;
						$FinoAuFinal = 0;
						$FinoAsFinal = 0;
					}
					//ACTUALIZA BENEFICIO CON AJUSTE METALURGICO
					$PesoAjuste = ($PesoInicial + $PesoRecepcion) - $PesoFinal;			
					$FinoCuAjuste = ($FinoCuInicial  + $FinoCuRecepcion) - $FinoCuFinal;	
					$FinoAgAjuste = ($FinoAgInicial  + $FinoAgRecepcion) - $FinoAgFinal;	
					$FinoAuAjuste = ($FinoAuInicial  + $FinoAuRecepcion) - $FinoAuFinal;	
					$FinoAsAjuste = ($FinoAsInicial  + $FinoAsRecepcion) - $FinoAsFinal;	
					$Consulta = "select distinct flujo from ram_web.param_circulante ";
					$Consulta.= " where nodo='".$Fila["nodo"]."' and tipo_movimiento='S'";
					$Resp3 = mysqli_query($link, $Consulta);
					if ($Fila3 = mysqli_fetch_array($Resp3))
					{
						//AJUSTA BENEFICIO
						$Actualizar = "UPDATE ram_web.flujos_mes_cir set ";
						$Actualizar.= " peso = '".$PesoAjuste."' ";
						$Actualizar.= " , fino_cu = '".$FinoCuAjuste."' ";
						$Actualizar.= " , fino_ag = '".$FinoAgAjuste."' ";
						$Actualizar.= " , fino_au = '".$FinoAuAjuste."' ";
						$Actualizar.= " , fino_as = '".$FinoAsAjuste."' ";
						$Actualizar.= " where flujo = '".$Fila3["flujo"]."' ";
						$Actualizar.= " and ano='".$Ano."' and mes='".$Mes."'";
						//mysqli_query($link, $Actualizar);
						//echo "AJUSTE BENEF, NODO=".$Fila["nodo"]." , FLUJO=".$Fila3["flujo"]." -> ".$PesoAjuste."<br>";
					}
				}
			}
			else
			{
				if ($DifStockPiso<0)
				{
					$Consulta = "select distinct flujo from ram_web.param_circulante ";
					$Consulta.= " where nodo='".$Fila["nodo"]."' and tipo_movimiento='E'";
					$Resp2 = mysqli_query($link, $Consulta);
					if ($Fila2 = mysqli_fetch_array($Resp2))
					{
						//AJUSTA RECEPCION
						$Actualizar = "UPDATE ram_web.flujos_mes_cir set ";
						$Actualizar.= " peso = (peso + ".abs($DifStockPiso).") ";
						$Actualizar.= " , fino_cu = (fino_cu + ".abs($DifFinoCu).") ";
						$Actualizar.= " , fino_ag = (fino_ag + ".abs($DifFinoAg).") ";
						$Actualizar.= " , fino_au = (fino_au + ".abs($DifFinoAu).") ";
						$Actualizar.= " , fino_as = (fino_as + ".abs($DifFinoAs).") ";
						$Actualizar.= " where flujo = '".$Fila2["flujo"]."' ";
						$Actualizar.= " and ano='".$Ano."' and mes='".$Mes."'";
						mysqli_query($link, $Actualizar);												
						//CALCULA LA RECEPCION
						//STOCK INICIAL
						$FechaAux = date("Y-m-d", mktime(0,0,0,$Mes-1,1,$Ano));
						$AnoAnt = intval(substr($FechaAux,0,4));
						$MesAnt = intval(substr($FechaAux,5,2));
						$Consulta = "select * from ram_web.existencia_nodo_cir ";
						$Consulta.= " where nodo = '".$Fila["nodo"]."' ";
						$Consulta.= " and ano='".$AnoAnt."' and mes='".$MesAnt."'";
						$Resp3 = mysqli_query($link, $Consulta);
						if ($Fila3 = mysqli_fetch_array($Resp3))
						{
							$PesoInicial = $Fila3["peso"];
							$FinoCuInicial = $Fila3["fino_cu"];
							$FinoAgInicial = $Fila3["fino_ag"];
							$FinoAuInicial = $Fila3["fino_au"];
							$FinoAsInicial = $Fila3["fino_as"];
						}
						else
						{
							$PesoInicial = 0;
							$FinoCuInicial = 0;
							$FinoAgInicial = 0;
							$FinoAuInicial = 0;
							$FinoAsInicial = 0;
						}
						//FLUJO DE BENEFICIO
						$Consulta = "select distinct flujo from ram_web.param_circulante ";
						$Consulta.= " where nodo='".$Fila["nodo"]."' and tipo_movimiento='S'";
						$RespBenef = mysqli_query($link, $Consulta);
						if ($FilaBenef = mysqli_fetch_array($RespBenef))
						{
							$Consulta = "select * from ram_web.flujos_mes_cir ";
							$Consulta.= " where flujo = '".$FilaBenef["flujo"]."' ";
							$Consulta.= " and ano='".$Ano."' and mes='".$Mes."'";
							$Resp3 = mysqli_query($link, $Consulta);
							if ($Fila3 = mysqli_fetch_array($Resp3))
							{
								$PesoBeneficio = $Fila3["peso"];
								$FinoCuBeneficio = $Fila3["fino_cu"];
								$FinoAgBeneficio = $Fila3["fino_ag"];
								$FinoAuBeneficio = $Fila3["fino_au"];
								$FinoAsBeneficio = $Fila3["fino_as"];
							}
							else
							{
								$PesoBeneficio = 0;
								$FinoCuBeneficio = 0;
								$FinoAgBeneficio = 0;
								$FinoAuBeneficio = 0;
								$FinoAsBeneficio = 0;
							}
						}
						//EXISTENCIA FINAL
						$Consulta = "select * from ram_web.existencia_nodo_cir ";
						$Consulta.= " where nodo = '".$Fila["nodo"]."' ";
						$Consulta.= " and ano='".$Ano."' and mes='".$Mes."'";
						$Resp3 = mysqli_query($link, $Consulta);
						if ($Fila3 = mysqli_fetch_array($Resp3))
						{
							$PesoFinal = $Fila3["peso"];
							$FinoCuFinal = $Fila3["fino_cu"];
							$FinoAgFinal = $Fila3["fino_ag"];
							$FinoAuFinal = $Fila3["fino_au"];
							$FinoAsFinal = $Fila3["fino_as"];
						}
						else
						{
							$PesoFinal = 0;
							$FinoCuFinal = 0;
							$FinoAgFinal = 0;
							$FinoAuFinal = 0;
							$FinoAsFinal = 0;
						}
						//ACTUALIZA RECEPCION CON AJUSTE METALURGICO
						$PesoAjuste = ($PesoFinal + $PesoBeneficio) - $PesoInicial;
						//echo $PesoAjuste." = (".$PesoFinal." + ".$PesoBeneficio.") - ".$PesoInicial."<br>";
						$FinoCuAjuste = ($FinoCuFinal + $FinoCuBeneficio) - $FinoCuInicial;	
						$FinoAgAjuste = ($FinoAgFinal + $FinoAgBeneficio) - $FinoAgInicial;	
						$FinoAuAjuste = ($FinoAuFinal + $FinoAuBeneficio) - $FinoAuInicial;
						$FinoAsAjuste = ($FinoAsFinal + $FinoAsBeneficio) - $FinoAsInicial;							
						$Consulta = "select distinct flujo from ram_web.param_circulante ";
						$Consulta.= " where nodo='".$Fila["nodo"]."' and tipo_movimiento='E'";
						$Resp3 = mysqli_query($link, $Consulta);
						if ($Fila3 = mysqli_fetch_array($Resp3))
						{
							//AJUSTA RECEPCION
							$Actualizar = "UPDATE ram_web.flujos_mes_cir set ";
							$Actualizar.= " peso = '".$PesoAjuste."' ";
							$Actualizar.= " , fino_cu = '".$FinoCuAjuste."' ";
							$Actualizar.= " , fino_ag = '".$FinoAgAjuste."' ";
							$Actualizar.= " , fino_au = '".$FinoAuAjuste."' ";
							$Actualizar.= " , fino_as = '".$FinoAsAjuste."' ";
							$Actualizar.= " where flujo = '".$Fila3["flujo"]."' ";
							$Actualizar.= " and ano='".$Ano."' and mes='".$Mes."'";
							mysqli_query($link, $Actualizar);			
							//echo $Actualizar."<br>";			
						}
					}
				}
			}
			
		}
		
		//		
	}//FIN SI ESTA BLOQUEADO
}
?>
<html>
<head>
<title>Anexo Circulante</title>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frm1;
	switch (opt)
	{
		case "AM":
			var Pag = "../principal/abrir_mes_anexo.php?Sistema=CIR&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
			window.open(Pag,"","top=200,left=175,width=409,height=210,scrollbars=no,resizable = no");	
			break;
		case "CM":
			var msg = confirm("¿Esta seguro que desea guardar esta version del Anexo.CIR?");
			if (msg)
			{
				f.action = "ram_con_anexo_cir01.php?Proceso=G&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
				f.submit();
			}
			else
			{
				return;
			}
			break;
		case "S":
			f.action = "../principal/sistemas_usuario.php?CodSistema=16&Nivel=0";
			f.submit();
			break;
		case "I":
			window.print();
			break;
		case "E":
			f.action = "ram_con_anexo_cir_excel.php?Mostrar=S&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
			f.submit(); 
			break;
		case "C":
			f.action = "ram_con_anexo_cir.php?Mostrar=S";
			f.submit(); 
			break;
	}	
}

function Detalle(flu)
{
	var f = frm1;		
	window.open("ram_con_anexo_cir_det_flujo.php?Flujo=" + flu + "&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}
function DetalleNodo(nodo)
{
	var f = frm1;		
	window.open("ram_con_anexo_cir_det_nodo.php?Nodo=" + nodo + "&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}
</script>
</head>

<body leftmargin="3" topmargin="5">
<form name="frm1" action="" method="post">
<?php include("../principal/encabezado.php") ?>
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="762" height="313" align="center" valign="top">
	  
<table width="650" border="1" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr align="center">
            <td height="23" colspan="3" class="ColorTabla02"><strong>ANEXO DE CIRCULANTES </strong></td>
          </tr>
          <tr> 
            <td width="92" height="23">Mes Anexo</td>
            <td width="166"> <select name="Mes">
                <?php
			$Meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");				
		 	for($i=1;$i<=12;$i++)
		  	{
				if (!isset($Mes))
				{
					if ($i == date("n"))
						echo "<option selected value ='".$i."'>".$Meses[$i-1]." </option>";
					else	
						echo "<option value ='".$i."'>".$Meses[$i-1]." </option>";
				}
				else
				{
					if ($i == $Mes)
						echo "<option selected value ='".$i."'>".$Meses[$i-1]." </option>";
					else	
						echo "<option value ='".$i."'>".$Meses[$i-1]." </option>";						
				}				
			}		  
		?>
              </select> <select name="Ano" size="1">
                <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (!isset($Ano))
				{
					if ($i == date("Y"))
						echo "<option selected value ='".$i."'>".$i." </option>";
					else	
						echo "<option value ='".$i."'>".$i." </option>";
				}
				else
				{
					if ($i == $Ano)
						echo "<option selected value ='".$i."'>".$i." </option>";
					else	
						echo "<option value ='".$i."'>".$i." </option>";						
				}				
			}		
		?>
              </select>              </td>
            <td width="365" align="right">Estado Del Mes:&nbsp;
<?php
	//Consulto si las existencias del mes estab bloqueadas
	$Consulta = "SELECT count(ifnull(bloqueado,0)) AS valor FROM ram_web.existencia_nodo_cir ";
	$Consulta.= " WHERE ano = '".$Ano."' AND mes = '".$Mes."' AND bloqueado = '1'";    
	$Respuesta = mysqli_query($link, $Consulta);
	$Fila = mysqli_fetch_array($Respuesta);
	if ($Fila["valor"] == "0")
	{		
		echo "<img src='../principal/imagenes/cand_abierto.gif'>";
	}
	else
	{
		echo "<img src='../principal/imagenes/cand_cerrado.gif'>";
	}
?>						
		</td>
          </tr>
          <tr align="center">
            <td height="23" colspan="3"><input name="btnconsultar" type="button" value="Consultar" onClick="Proceso('C')" style="width:70px;">
              <input name="BtnImprimir" type="button" id="BtnImprimir" style="width:70px;" onClick="Proceso('I')" value="Imprimir">
<?php			  
	if ($Mostrar == "S")
	{		
        echo "<input name='BtnExcel' type='button' style='width:70px;' onClick=\"Proceso('E')\" value='Excel'>\n";
	}
	//Consulto si las existencias del mes estab bloqueadas
	$Consulta = "SELECT count(ifnull(bloqueado,0)) AS valor FROM ram_web.existencia_nodo_cir ";
	$Consulta.= " WHERE ano = '".$Ano."' AND mes = '".$Mes."' AND bloqueado = '1'";    
	$Respuesta = mysqli_query($link, $Consulta);
	$Fila = mysqli_fetch_array($Respuesta);
	if ($Fila["valor"] == "0")
	{		
        echo "<input name='BrnCerrar' type='button' value='Cerrar Mes' style='width:70px;' onClick=\"Proceso('CM')\">";
	}
	else
	{
		echo "<input name='BrnAbrir' type='button' value='Abrir Mes' style='width:70px;' onClick=\"Proceso('AM')\">";
	}
?>
              <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:70px;" onClick="Proceso('S')"></td>
          </tr>
        </table>
        <br>
	<table width="700" border="1" align="center" cellpadding="2" cellspacing="0">
    <tr align="center" class="ColorTabla01"> 
      <td width="40" rowspan="2">Flujo</td>
      <td width="264" rowspan="2">Descripcion</td>
      <td width="66" rowspan="2">Peso</td>
      <td colspan="4" align="center">Leyes</td>
      <td colspan="4" align="center">Finos</td>
    </tr>
    <tr class="ColorTabla01"> 
      <td width="42" align="center">Cu</td>
      <td width="40" align="center">Ag</td>
      <td width="20" align="center">Au</td>
      <td width="21" align="center">As</td>
      <td width="42" align="center">Cu</td>
      <td width="40" align="center">Ag</td>
      <td width="27" align="center">Au</td>
    <td width="30" align="center">As</td>
    </tr>
<?php	
if ($Mostrar == "S")
{		
	$Consulta = "SELECT distinct t1.flujo, t2.descripcion, t1.peso, t1.fino_cu, t1.fino_ag, t1.fino_au, t1.fino_as  ";
	$Consulta.= " FROM ram_web.flujos_mes_cir t1 LEFT join proyecto_modernizacion.flujos t2 ";
	$Consulta.= " on t1.flujo = t2.cod_flujo and t2.sistema = 'CIR'";
	$Consulta.= " WHERE t1.ano = ".$Ano." AND t1.mes = ".$Mes;
	$Consulta.= " ORDER BY flujo";	
	$Resp = mysqli_query($link, $Consulta);	
	while ($row = mysqli_fetch_array($Resp))
	{			
		/*if ($row["peso"] != 0)
		{*/
			echo '<tr>';
			echo '<td align="center">'.$row["flujo"].'</td>';
			echo '<td align="left"><a href="JavaScript:Detalle('.$row["flujo"].')">'.strtoupper($row["descripcion"]).'</a></td>';
			echo '<td align="right">'.number_format($row["peso"],0,',','.').'</td>';
			if ($row["fino_cu"]>0 && $row["peso"]>0)
				echo '<td align="right">'.number_format(($row["fino_cu"] / $row["peso"] * 100),2,',','.').'</td>';
			else
				echo '<td align="right">&nbsp;</td>';
			if ($row["fino_ag"]>0 && $row["peso"]>0)
				echo '<td align="right">'.number_format(($row["fino_ag"] / $row["peso"] * 1000),0,',','.').'</td>';
			else
				echo '<td align="right">&nbsp;</td>';
			if ($row["fino_au"]>0 && $row["peso"]>0)
				echo '<td align="right">'.number_format(($row["fino_au"] / $row["peso"] * 1000),1,',','.').'</td>';	
			else
				echo '<td align="right">&nbsp;</td>';
			if ($row["fino_as"]<>0 && $row["peso"]<>0)
				echo '<td align="right">'.number_format(($row["fino_as"] / $row["peso"] * 100),2,',','.').'</td>';	
			else
				echo '<td align="right">&nbsp;</td>';
			echo '<td align="right">'.number_format($row["fino_cu"],0,',','.').'</td>';
			echo '<td align="right">'.number_format($row["fino_ag"],0,',','.').'</td>';
			echo '<td align="right">'.number_format($row["fino_au"],0,',','.').'</td>';
			echo '<td align="right">'.number_format($row["fino_as"],0,',','.').'</td>';										
			echo '</tr>';
		//}
	}
}			
?>		
	<tr align="center" class="ColorTabla01"> 
      <td rowspan="2">Nodo</td>
      <td rowspan="2">Descripcion</td>
      <td rowspan="2">Peso</td>
      <td colspan="4" align="center">Leyes</td>
      <td colspan="4" align="center">Fino</td>
    </tr>
    <tr class="ColorTabla01"> 
      <td align="center">Cu</td>
      <td align="center">Ag</td>
      <td align="center">Au</td>
      <td align="center">As</td>
      <td align="center">Cu</td>
      <td align="center">Ag</td>
      <td align="center">Au</td>
    <td align="center">As</td>
    </tr>
<?php	
if ($Mostrar == "S")
{					
	$Consulta = "SELECT t1.nodo, t2.descripcion, t1.peso, t1.fino_cu, t1.fino_ag, t1.fino_au, t1.fino_as ";
	$Consulta.= " FROM ram_web.existencia_nodo_cir t1 LEFT join proyecto_modernizacion.nodos t2 ";
	$Consulta.= " on t1.nodo = t2.cod_nodo and t2.sistema = 'CIR'";
	$Consulta.= " WHERE t1.ano = ".$Ano." AND t1.mes = ".$Mes;
	$Consulta.= " ORDER BY nodo";			
	$Resp = mysqli_query($link, $Consulta);	
	while ($row = mysqli_fetch_array($Resp))
	{			
		/*if ($row["peso"] != 0)
		{*/
			echo '<tr>';
			echo '<td align="center">'.$row["nodo"].'</td>';
			echo '<td align="left"><a href="JavaScript:DetalleNodo('.$row["nodo"].')">'.strtoupper($row["descripcion"]).'</a></td>';
			echo '<td align="right">'.number_format($row["peso"],0,',','.').'</td>';
			if ($row["fino_cu"]<>0 && $row["peso"]<>0)
				echo '<td align="right">'.number_format(($row["fino_cu"] / $row["peso"] * 100),2,',','.').'</td>';
			else
				echo '<td align="right">&nbsp;</td>';
			if ($row["fino_ag"]<>0 && $row["peso"]<>0)
				echo '<td align="right">'.number_format(($row["fino_ag"] / $row["peso"] * 1000),0,',','.').'</td>';
			else
				echo '<td align="right">&nbsp;</td>';
			if ($row["fino_au"]<>0 && $row["peso"]<>0)
				echo '<td align="right">'.number_format(($row["fino_au"] / $row["peso"] * 1000),1,',','.').'</td>';	
			else
				echo '<td align="right">&nbsp;</td>';
			if ($row["fino_as"]<>0 && $row["peso"]<>0)
				echo '<td align="right">'.number_format(($row["fino_as"] / $row["peso"] * 100),2,',','.').'</td>';	
			else
				echo '<td align="right">&nbsp;</td>';
			echo '<td align="right">'.number_format($row["fino_cu"],0,',','.').'</td>';
			echo '<td align="right">'.number_format($row["fino_ag"],0,',','.').'</td>';
			echo '<td align="right">'.number_format($row["fino_au"],0,',','.').'</td>';	
			echo '<td align="right">'.number_format($row["fino_as"],0,',','.').'</td>';												
			echo '</tr>';
		//}
	}	
}			
?>
</table>
      </td>
    </tr>
</table>
<?php include ("../principal/pie_pagina.php") ?>   
</form>
</body>
</html>