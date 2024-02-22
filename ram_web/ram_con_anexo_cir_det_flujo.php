<?php
	include("../principal/conectar_principal.php");
	if(isset($_REQUEST["Flujo"])){
		$Flujo = $_REQUEST["Flujo"];
	}else{
		$Flujo = "";
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

	$Consulta = "select * from proyecto_modernizacion.flujos where sistema='CIR' and cod_flujo='".$Flujo."'";
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
		$NomFlujo = $Fila["descripcion"];	
?>
<html>
<head>
<title>Detalle de Flujo</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
</style></head>

<body>
<div align="center"><strong>FLUJO:&nbsp;<?php echo $Flujo." - ".strtoupper($NomFlujo); ?>
  </strong><br>
  <br>
</div>
<table width="720" border="1" align="center" cellpadding="3" cellspacing="0">
  <tr align="center" valign="middle" class="ColorTabla01">
    <td width="63" rowspan="2">Conjunto</td>
    <td width="60" rowspan="2">TIPO.MOV</td>
    <td width="119" rowspan="2">Descripcion</td>
    <td width="68" rowspan="2">Peso</td>
    <td colspan="4">Leyes</td>
    <td colspan="4">Fino</td>
  </tr>
  <tr class="ColorTabla01">
    <td width="49" align="center">Cu</td>
    <td width="44" align="center">Ag</td>
    <td width="29" align="center">Au</td>
    <td width="29" align="center">As</td>
    <td width="54" align="center">Cu</td>
    <td width="57" align="center">Ag</td>
    <td width="33" align="center">Au</td>
    <td width="33" align="center">As</td>
  </tr>
<?php
	$ArrDetalle = array();
	//************************************** FLUJOS ********************************************						
	$FechaIni = $Ano."-".$Mes."-01";
	$FechaFin = date("Y-m-d", mktime(0,0,0,$Mes+1,1,$Ano));
	$FechaFin = date("Y-m-d", mktime(0,0,0,intval(substr($FechaFin,5,2)),1-1,intval(substr($FechaFin,0,4))));	
	$FechaHoraIni = $Ano."-".$Mes."-01 08:00:00";
	$FechaHoraFin = date("Y-m-d", mktime(0,0,0,$Mes+1,1,$Ano));
	$FechaHoraFin = $FechaHoraFin." 07:59:59";
	$FechaFinAnt = date("Y-m-d", mktime(0,0,0,$Mes,1-1,$Ano));
	//FLUJOS
	$Consulta = "select distinct flujo, tipo_movimiento as tipo ";
	$Consulta.= " from ram_web.param_circulante ";
	$Consulta.= " where flujo = '".$Flujo."'";
	$Consulta.= " order by flujo";
	$Resp = mysqli_query($link, $Consulta);
	$Cont=0;
	$TipoMovimiento = "";
	while ($Fila = mysqli_fetch_array($Resp))
	{
		$Peso = 0;
		$FinoCu = 0;
		$FinoAg = 0;
		$FinoAu = 0;	
		$FinoAs = 0;		
		$TipoMovimiento = $Fila["tipo"];	
		if ($TipoMovimiento=="E")
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
			$Consulta.= " group by t3.num_conjunto";				
			//echo $Consulta."<br>";
			$Resp2 = mysqli_query($link, $Consulta);
			while ($Fila2 = mysqli_fetch_array($Resp2))
			{
				$ArrDetalle[$Cont][0] = $Fila2["num_conjunto"];
				$ArrDetalle[$Cont][1] = $Fila2["peso_seco"];
				$ArrDetalle[$Cont][2] = $Fila2["fino_cu"];
				$ArrDetalle[$Cont][3] = $Fila2["fino_ag"];
				$ArrDetalle[$Cont][4] = $Fila2["fino_au"];
				$ArrDetalle[$Cont][5] = $Fila2["fino_as"];
				$ArrDetalle[$Cont][10] = "+";
				$ArrDetalle[$Cont][11] = "RECEPCION";
				$Cont++;
			}
			
			#TRASP. DESDE CONJ.
			$Consulta = " SELECT t1.num_conjunto, t3.rut_proveedor, sum(peso_humedo) as peso_humedo,";
			$Consulta.= " sum(peso_seco) as peso_seco, SUM(fino_cu) as fino_cu, sum(fino_ag)as fino_ag, sum(fino_au) AS fino_au, sum(fino_as) AS fino_as";
			$Consulta.= " from ram_web.conjunto_ram_bd t1 inner join ram_web.param_circulante t2";
			$Consulta.= " on t1.cod_producto = t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto";
			$Consulta.= " inner join ram_web.movimiento_proveedor t3 on t1.num_conjunto = t3.conjunto_destino";
			$Consulta.= " where t1.cod_conjunto='03'";
			$Consulta.= " and t2.flujo = '".$Fila["flujo"]."'";
			$Consulta.= " and t3.fecha_movimiento BETWEEN '".$FechaHoraIni."' and '".$FechaHoraFin."'";
			$Consulta.= " and (t3.cod_existencia='15')";
			$Consulta.= " group by t1.num_conjunto";							
			//echo $Consulta."<br>";
			$Resp2 = mysqli_query($link, $Consulta);
			while ($Fila2 = mysqli_fetch_array($Resp2))
			{
				$ArrDetalle[$Cont][0] = $Fila2["num_conjunto"];
				$ArrDetalle[$Cont][1] = $Fila2["peso_seco"];
				$ArrDetalle[$Cont][2] = $Fila2["fino_cu"];
				$ArrDetalle[$Cont][3] = $Fila2["fino_ag"];
				$ArrDetalle[$Cont][4] = $Fila2["fino_au"];
				$ArrDetalle[$Cont][5] = $Fila2["fino_as"];
				$ArrDetalle[$Cont][10] = "+";
				$ArrDetalle[$Cont][11] = "TRASP. DE CNJTO";
				$Cont++;
			}						
		}

		if ($TipoMovimiento=="S")
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
			$Consulta.= " group by t3.num_conjunto ";
			//echo $Consulta."<br>";
			$Resp2 = mysqli_query($link, $Consulta);
			while ($Fila2 = mysqli_fetch_array($Resp2))
			{
				$ArrDetalle[$Cont][0] = $Fila2["num_conjunto"];
				$ArrDetalle[$Cont][1] = $Fila2["peso_seco"];
				$ArrDetalle[$Cont][2] = $Fila2["fino_cu"];
				$ArrDetalle[$Cont][3] = $Fila2["fino_ag"];
				$ArrDetalle[$Cont][4] = $Fila2["fino_au"];
				$ArrDetalle[$Cont][5] = $Fila2["fino_as"];
				$ArrDetalle[$Cont][10] = "+";
				$ArrDetalle[$Cont][11] = "TRASPASO";
				$Cont++;
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
				$Consulta.= " group by t3.num_conjunto";							
				//echo $Consulta."<br>";
				$Resp2 = mysqli_query($link, $Consulta);
				while ($Fila2 = mysqli_fetch_array($Resp2))
				{
					$ArrDetalle[$Cont][0] = $Fila2["num_conjunto"];
					$ArrDetalle[$Cont][1] = $Fila2["peso_seco"];
					$ArrDetalle[$Cont][2] = $Fila2["fino_cu"];
					$ArrDetalle[$Cont][3] = $Fila2["fino_ag"];
					$ArrDetalle[$Cont][4] = $Fila2["fino_au"];
					$ArrDetalle[$Cont][5] = $Fila2["fino_as"];
					$ArrDetalle[$Cont][10] = "+";
					$ArrDetalle[$Cont][11] = "TRASP. A CNJTO";
					$Cont++;
				}
			}//FIN SI DATO ES NEGATIVO
		}							
	}//FIN FLUJOS
	//MANEJA STOCK DE PISO
	//FLUJO - TIPO	
	$StockPisoAnt = 0;
	$StockPisoActual = 0;
	$FinoCuAnt = 0;
	$FinoAgAnt = 0;
	$FinoAuAnt = 0;
	$FinoCuActual = 0;
	$FinoAgActual = 0;
	$FinoAuActual = 0;
	$FinoAsActual = 0;
	$FinoAsAnt=0; //WSO
	$Consulta = "select distinct cod_producto, cod_subproducto ";
	$Consulta.= " from ram_web.param_circulante ";
	$Consulta.= " where flujo='".$Flujo."'";
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
		$Consulta = "SELECT peso_seco, fino_cu, fino_ag, fino_au, fino_as ";
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
	//echo " MES ANT = ".$StockPisoAnt." - MES ACTUAL = ".$StockPisoActual." - DIF. STOCK PISO".$DifStockPiso."<br>";
	$DifFinoCu = $FinoCuAnt - $FinoCuActual;
	$DifFinoAg = $FinoAgAnt - $FinoAgActual;
	$DifFinoAu = $FinoAuAnt - $FinoAuActual;
	$DifFinoAs = $FinoAsAnt - $FinoAsActual;
	if ($DifStockPiso > 0 && $TipoMovimiento=="S")
	{		
		//AJUSTA BENEFICIO
		$ArrDetalle[$Cont][0] = "&nbsp;";
		$ArrDetalle[$Cont][1] = abs($DifStockPiso);
		$ArrDetalle[$Cont][2] = abs($DifFinoCu);
		$ArrDetalle[$Cont][3] = abs($DifFinoAg);
		$ArrDetalle[$Cont][4] = abs($DifFinoAu);
		$ArrDetalle[$Cont][5] = abs($DifFinoAs);
		$ArrDetalle[$Cont][9] = "STOCK PISO";
		$ArrDetalle[$Cont][10] = "+";
		$ArrDetalle[$Cont][11] = "AJUSTE";
		$Cont++;		
	}
	else
	{
		if ($DifStockPiso < 0 && $TipoMovimiento=="E")
		{
			//AJUSTA RECEPCION
			$ArrDetalle[$Cont][0] = "&nbsp;";
			$ArrDetalle[$Cont][1] = abs($DifStockPiso);
			$ArrDetalle[$Cont][2] = abs($DifFinoCu);
			$ArrDetalle[$Cont][3] = abs($DifFinoAg);
			$ArrDetalle[$Cont][4] = abs($DifFinoAu);
			$ArrDetalle[$Cont][5] = abs($DifFinoAs);
			$ArrDetalle[$Cont][9] = "STOCK PISO";
			$ArrDetalle[$Cont][10] = "+";
			$ArrDetalle[$Cont][11] = "AJUSTE";
			$Cont++;
		}
	}
	//AJUSTE DE COOKIES
	$Consulta = "select * from ram_web.cookie";
	$Consulta.= " where ano = '".$Ano."' and mes = '".$Mes."'";
	$Consulta.= " and flujo = '".$Flujo."'";
	$Resp = mysqli_query($link, $Consulta);
	//echo $Consulta;
	while ($Fila = mysqli_fetch_array($Resp))
	{	
		$ArrDetalle[$Cont][0] = "&nbsp;";
		$ArrDetalle[$Cont][1] = $Fila["peso_seco"];
		$ArrDetalle[$Cont][2] = $Fila["fino_cu"];
		$ArrDetalle[$Cont][3] = $Fila["fino_ag"];
		$ArrDetalle[$Cont][4] = $Fila["fino_au"];
		$ArrDetalle[$Cont][5] = $Fila["fino_as"];
		$ArrDetalle[$Cont][9] = "COOKIE";
		$ArrDetalle[$Cont][10] = "+";
		$ArrDetalle[$Cont][11] = "AJUSTE";		
	}
	//
	reset($ArrDetalle);
	//while (list($k,$v)=each($ArrDetalle))
	$TotalPeso=0; //WSO
	$TotalFinoCu=0; //WSO
	$TotalFinoAg=0;//WSO
	$TotalFinoAu=0; //WSO
	$TotalFinoAs=0; //WSO

	foreach($ArrDetalle as $k => $v)
	{		
		if ($v[0]!="")
		{
			if ($v[0]!="&nbsp;")
			{ 
				$Consulta = "select * from ram_web.conjunto_ram_bd where cod_conjunto='03' and num_conjunto = ".$v[0]."";
				$Resp2 = mysqli_query($link, $Consulta);
				if ($Fila2 = mysqli_fetch_array($Resp2))
					$NomCjto = $Fila2["descripcion"];
				else
					$NomCjto = "&nbsp;";
			}
			else
			{
				$NomCjto = $v[9];
			}
			echo "<tr>";
			if ($v[0]!="")
				echo "<td align='center'>".$v[0]."</td>";
			else
				echo "<td align='center'>&nbsp;</td>";
			echo "<td align='center'>".$v[11]."</td>";
			echo "<td align='left'>".$NomCjto."</td>";		
			echo "<td align='right'>".number_format(abs($v[1]),0,",",".")."</td>";		
			if ($v[2]<>0 && $v[1]<>0)
			{
				echo "<td align='right'>".number_format(($v[2]/$v[1])*100,2,",",".")."</td>";
				$TotalFinoCu = $TotalFinoCu + $v[2];
			}
			else	
			{
				echo "<td align='right'>0</td>";
			}
			if ($v[3]<>0 && $v[1]<>0)
			{
				echo "<td align='right'>".number_format(($v[3]/$v[1])*1000,0,",",".")."</td>";
				$TotalFinoAg = $TotalFinoAg + $v[3];
			}
			else	
			{
				echo "<td align='right'>0</td>";
			}
			if ($v[4]<>0 && $v[1]<>0)
			{
				echo "<td align='right'>".number_format(($v[4]/$v[1])*1000,1,",",".")."</td>";
				$TotalFinoAu = $TotalFinoAu + $v[4];
			}
			else	
			{
				echo "<td align='right'>0</td>";
			}
			if ($v[5]<>0 && $v[1]<>0)
			{
				echo "<td align='right'>".number_format(($v[5]/$v[1])*100,2,",",".")."</td>";
				$TotalFinoAs = $TotalFinoAs + $v[5];
			}
			else	
			{
				echo "<td align='right'>0</td>";
			}
			echo "<td align='right'>".number_format($v[2],0,",",".")."</td>";
			echo "<td align='right'>".abs(number_format($v[3],0,",","."))."</td>";
			echo "<td align='right'>".abs(number_format($v[4],0,",","."))."</td>";
			echo "<td align='right'>".abs(number_format($v[5],0,",","."))."</td>";
			echo "</tr>";
			$TotalPeso = $TotalPeso + $v[1];				
		}
	}
	echo "<tr>";
	echo "<td align='center' colspan='3'>TOTAL</td>";		
	echo "<td align='right'>".number_format($TotalPeso,0,",",".")."</td>";		
	if ($TotalFinoCu>0 && $TotalPeso>0)
		echo "<td align='right'>".number_format(($TotalFinoCu/$TotalPeso)*100,2,",",".")."</td>";
	else	echo "<td align='right'>0</td>";
	if ($TotalFinoAg>0 && $TotalPeso>0)
		echo "<td align='right'>".number_format(($TotalFinoAg/$TotalPeso)*1000,0,",",".")."</td>";
	else	echo "<td align='right'>0</td>";
	if ($TotalFinoAu>0 && $TotalPeso>0)
		echo "<td align='right'>".number_format(($TotalFinoAu/$TotalPeso)*1000,1,",",".")."</td>";
	else	echo "<td align='right'>0</td>";
	if ($TotalFinoAs>0 && $TotalPeso>0)
		echo "<td align='right'>".number_format(($TotalFinoAs/$TotalPeso)*100,2,",",".")."</td>";
	else	echo "<td align='right'>0</td>";
	echo "<td align='right'>".number_format($TotalFinoCu,0,",",".")."</td>";
	echo "<td align='right'>".number_format($TotalFinoAg,0,",",".")."</td>";
	echo "<td align='right'>".number_format($TotalFinoAu,0,",",".")."</td>";
	echo "<td align='right'>".number_format($TotalFinoAs,0,",",".")."</td>";
	echo "</tr>";	
?>  
</table>
</body>
</html>
