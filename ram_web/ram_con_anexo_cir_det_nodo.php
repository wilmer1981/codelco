<?php
	include("../principal/conectar_principal.php");
	if(isset($_REQUEST["Nodo"])){
		$Nodo = $_REQUEST["Nodo"];
	}else{
		$Nodo = "";
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

	$Consulta = "select * from proyecto_modernizacion.nodos where sistema='CIR' and cod_nodo='".$Nodo."'";
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
		$NomNodo = $Fila["descripcion"];
	
		
?>
<html>
<head>
<title>Detalle de Nodo</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
</style></head>

<body>
<div align="center"><strong>NODO:&nbsp;<?php echo $Nodo." - ".strtoupper($NomNodo); ?>
  </strong><br>
  <br>
</div>
<table width="700" border="1" align="center" cellpadding="3" cellspacing="0">
  <tr align="center" valign="middle" class="ColorTabla01">
    <td width="65" rowspan="2">Cjto</td>
    <td width="160" rowspan="2">Descripcion</td>
    <td width="50" rowspan="2">Peso</td>
    <td colspan="4">Leyes</td>
    <td colspan="4">Fino</td>
  </tr>
  <tr class="ColorTabla01">
    <td width="51" align="center">Cu</td>
    <td width="50" align="center">Ag</td>
    <td width="22" align="center">Au</td>
    <td width="22" align="center">As</td>
    <td width="63" align="center">Cu</td>
    <td width="54" align="center">Ag</td>
    <td width="32" align="center">Au</td>
    <td width="41" align="center">As</td>
  </tr>
<?php
	$ArrDetalle = array();
	//************************************** NODO ********************************************						
	$FechaIni = $Ano."-".$Mes."-01";
	$FechaFin = date("Y-m-d", mktime(0,0,0,$Mes+1,1,$Ano));
	$FechaFin = date("Y-m-d", mktime(0,0,0,intval(substr($FechaFin,5,2)),1-1,intval(substr($FechaFin,0,4))));	
	$FechaHoraIni = $Ano."-".$Mes."-01 08:00:00";
	$FechaHoraFin = date("Y-m-d", mktime(0,0,0,$Mes+1,1,$Ano));
	$FechaHoraFin = $FechaHoraFin." 07:59:59";
	$FechaFinAnt = date("Y-m-d", mktime(0,0,0,$Mes,1-1,$Ano));
	$Consulta = "SELECT distinct t3.num_conjunto, (peso_humedo) as peso_humedo,";
	$Consulta.= " (peso_seco) as peso_seco, (fino_cu) as fino_cu, (fino_ag)as fino_ag, (fino_au) AS fino_au, (fino_as) AS fino_as";
	$Consulta.= " from ram_web.conjunto_ram_bd t1 inner join ram_web.param_circulante t2";
	$Consulta.= " on t1.cod_producto = t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto";
	$Consulta.= " inner join ram_web.movimiento_proveedor t3 on t1.num_conjunto = t3.num_conjunto";
	$Consulta.= " where t1.cod_conjunto='03'";
	$Consulta.= " and t2.nodo = '".$Nodo."'";
	$Consulta.= " and t3.fecha_movimiento = '".$FechaFin."'";
	$Consulta.= " and t3.cod_existencia='01'";//EXIST. FINAL
	//$Consulta.= " group by t3.num_conjunto";
	//echo $Consulta;
	$Resp2 = mysqli_query($link, $Consulta);
	$Cont=0;
	$PesoNodo=0;
	while ($Fila2 = mysqli_fetch_array($Resp2))
	{		
		//$PesoNodo = $Fila2["peso_seco"] + $StockPisoActual;
		$PesoNodo = $Fila2["peso_seco"] + $PesoNodo;
		$ArrDetalle[$Cont][0] = $Fila2["num_conjunto"];
		$ArrDetalle[$Cont][1] = $PesoNodo;
		$ArrDetalle[$Cont][2] = $Fila2["fino_cu"];
		$ArrDetalle[$Cont][3] = $Fila2["fino_ag"];
		$ArrDetalle[$Cont][4] = $Fila2["fino_au"];
		$ArrDetalle[$Cont][5] = $Fila2["fino_as"];
		$Cont++;
	}
	$Consulta = "SELECT distinct t1.cod_producto, t1.cod_subproducto, t2.nodo, peso_seco as peso, fino_cu, fino_ag, fino_au, fino_as";
	$Consulta.= " from ram_web.stock_piso t1 inner join ram_web.param_circulante t2";
	$Consulta.= " on t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto";
	$Consulta.= " WHERE t2.nodo = '".$Nodo."'";
	$Consulta.= " and fecha = '".$FechaFin."'";	
	$Resp3 = mysqli_query($link, $Consulta);
	$StockPisoActual=0;
	while ($Fila3 = mysqli_fetch_array($Resp3))
	{
		$StockPisoActual = $StockPisoActual + $Fila3["peso"];
		$FinoCuActual = $FinoCuActual + $Fila3["fino_cu"];
		$FinoAgActual = $FinoAgActual + $Fila3["fino_ag"];
		$FinoAuActual = $FinoAuActual + $Fila3["fino_au"];
		$FinoAsActual = $FinoAsActual + $Fila3["fino_as"];
	}
	if ($StockPisoActual>0)
	{
		$ArrDetalle[Cont][0] = "&nbsp;";
		$ArrDetalle[Cont][1] = $StockPisoActual;
		$ArrDetalle[Cont][2] = $FinoCuActual;
		$ArrDetalle[Cont][3] = $FinoAgActual;
		$ArrDetalle[Cont][4] = $FinoAuActual;
		$ArrDetalle[Cont][5] = $FinoAsActual;
		$ArrDetalle[Cont][9] = "AJUSTE STOCK PISO";
	}


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
			echo "<td align='left'>".$NomCjto."</td>";		
			echo "<td align='right'>".number_format($v[1],0,",",".")."</td>";		
			if ($v[2]>0 && $v[1]>0)
			{
				echo "<td align='right'>".number_format(($v[2]/$v[1])*100,2,",",".")."</td>";
				$TotalFinoCu = $TotalFinoCu + $v[2];
			}
			else	
			{
				echo "<td align='right'>0</td>";
			}
			if ($v[3]>0 && $v[1]>0)
			{
				echo "<td align='right'>".number_format(($v[3]/$v[1])*1000,0,",",".")."</td>";
				$TotalFinoAg = $TotalFinoAg + $v[3];
			}
			else	
			{
				echo "<td align='right'>0</td>";
			}
			if ($v[4]>0 && $v[1]>0)
			{
				echo "<td align='right'>".number_format(($v[4]/$v[1])*1000,1,",",".")."</td>";
				$TotalFinoAu = $TotalFinoAu + $v[4];
			}
			else	
			{
				echo "<td align='right'>0</td>";
			}
			if ($v[5]>0 && $v[1]>0)
			{
				echo "<td align='right'>".number_format(($v[5]/$v[1])*100,2,",",".")."</td>";
				$TotalFinoAs = $TotalFinoAs + $v[5];
			}
			else	
			{
				echo "<td align='right'>0</td>";
			}
			echo "<td align='right'>".number_format($v[2],0,",",".")."</td>";
			echo "<td align='right'>".number_format($v[3],0,",",".")."</td>";
			echo "<td align='right'>".number_format($v[4],0,",",".")."</td>";
			echo "<td align='right'>".number_format($v[5],0,",",".")."</td>";
			echo "</tr>";
			$TotalPeso = $TotalPeso + $v[1];				
		}
	}
	echo "<tr>";
	echo "<td align='center' colspan='2'>TOTAL</td>";		
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
