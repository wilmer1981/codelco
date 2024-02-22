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

	$Consulta = "select * from proyecto_modernizacion.nodos where sistema='RAM' and cod_nodo='".$Nodo."'";
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
		$NomNodo = $Fila["descripcion"];
	$FechaIniTra = $Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-01 08:00:00";
	$FechaFinTra = date("Y-m-d H:i:s", mktime(7,59,00,intval($Mes)+1,1,$Ano));
	$FechaIniRec = $Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-01";
	$FechaFinRec = date("Y-m-d", mktime(0,0,0,intval($Mes)+1,1,$Ano));
	$FechaFinRec = date("Y-m-d", mktime(0,0,0,intval(substr($FechaFinRec,5,2)),1-1,intval(substr($FechaFinRec,0,4))));
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
<div align="center"><strong>NODO:&nbsp;<?php echo strtoupper($NomNodo); ?>
  </strong><br>
  <br>
</div>
<table width="700" border="1" align="center" cellpadding="3" cellspacing="0">
  <tr align="center" valign="middle" class="ColorTabla01">
    <td width="73" rowspan="2">RUT</td>
    <td width="138" rowspan="2">Descripcion</td>
    <td width="47" rowspan="2">Peso</td>
    <td colspan="3">Leyes</td>
    <td colspan="3">Fino</td>
  </tr>
  <tr class="ColorTabla01">
    <td width="48" align="center">Cu</td>
    <td width="47" align="center">Ag</td>
    <td width="42" align="center">Au</td>
    <td width="59" align="center">Cu</td>
    <td width="51" align="center">Ag</td>
    <td width="61" align="center">Au</td>
  </tr>
<?php
	$Consulta = "SELECT case when IsNull(t3.flujo) then (select flujo_rut.flujo from ram_web.flujo_rut";
	$Consulta.= " where flujo_rut.destino=0";
	$Consulta.= " and flujo_rut.cod_existencia='04'";
	$Consulta.= " and t2.cod_producto = flujo_rut.cod_producto";
	$Consulta.= " and t2.cod_subproducto = flujo_rut.cod_subproducto";
	$Consulta.= " and flujo_rut.rut = '99999999-9') else t3.flujo end AS flujo,";
	$Consulta.= " '04' AS Expr1, t2.cod_producto, t2.cod_subproducto,";
	$Consulta.= " t1.rut_proveedor, Sum(t1.peso_humedo) AS peso_humedo,";
	$Consulta.= " Sum(t1.peso_seco) AS peso_seco, Sum(t1.fino_cu) AS fino_cu,";
	$Consulta.= " Sum(t1.fino_ag) AS fino_ag, Sum(t1.fino_au) AS fino_au";
	$Consulta.= " FROM ram_web.movimiento_proveedor t1 INNER JOIN ram_web.conjunto_ram_bd t2";
	$Consulta.= " ON t1.num_conjunto = t2.num_conjunto AND t1.cod_conjunto = t2.cod_conjunto";
	$Consulta.= " left join ram_web.flujo_rut t3 on t2.cod_producto=t3.cod_producto and t2.cod_subproducto = t3.cod_subproducto";
	$Consulta.= " and t3.cod_existencia='04' and TRIM(t1.rut_proveedor) = trim(t3.rut)";
	$Consulta.= " WHERE t2.cod_conjunto='01'";
	$Consulta.= " and t1.cod_existencia='01' AND t1.fecha_movimiento='".$FechaFinRec."'";
	$Consulta.= " GROUP BY '04', t2.cod_producto, t2.cod_subproducto, t1.rut_proveedor";
	$Consulta.= " HAVING t2.cod_producto=1";
	//echo $Consulta."<br>";
	$Resp = mysqli_query($link, $Consulta);
	$TotalFinoCu=0;
	$TotalFinoAg=0;
	$TotalFinoAu=0;
	$TotalPeso=0;

	while ($Fila = mysqli_fetch_array($Resp))
	{
		if ($Fila["flujo"] == $Nodo)
		{
			$Consulta = "select * from ram_web.proveedor where trim(rut_proveedor) = '".trim($Fila["rut_proveedor"])."'";
			$Resp2 = mysqli_query($link, $Consulta);
			if ($Fila2 = mysqli_fetch_array($Resp2))
				$NomProv = $Fila2["nombre"];
			else
				$NomProv = "&nbsp;";
			echo "<tr>";
			echo "<td align='center'>".$Fila["rut_proveedor"]."</td>";
			echo "<td align='left'>".$NomProv."</td>";		
			echo "<td align='right'>".number_format($Fila["peso_seco"],0,",",".")."</td>";		
			if ($Fila["fino_cu"]>0 && $Fila["peso_seco"]>0)
			{
				echo "<td align='right'>".number_format(($Fila["fino_cu"]/$Fila["peso_seco"])*100,2,",",".")."</td>";
				$TotalFinoCu = $TotalFinoCu + $Fila["fino_cu"];
			}
			else	
			{
				echo "<td align='right'>0</td>";
			}
			if ($Fila["fino_ag"]>0 && $Fila["peso_seco"]>0)
			{
				echo "<td align='right'>".number_format(($Fila["fino_ag"]/$Fila["peso_seco"])*1000,2,",",".")."</td>";
				$TotalFinoAg = $TotalFinoAg + $Fila["fino_ag"];
			}
			else	
			{
				echo "<td align='right'>0</td>";
			}
			if ($Fila["fino_au"]>0 && $Fila["peso_seco"]>0)
			{
				echo "<td align='right'>".number_format(($Fila["fino_au"]/$Fila["peso_seco"])*1000,2,",",".")."</td>";
				$TotalFinoAu = $TotalFinoAu + $Fila["fino_au"];
			}
			else	
			{
				echo "<td align='right'>0</td>";
			}
			echo "<td align='right'>".number_format($Fila["fino_cu"],0,",",".")."</td>";
			echo "<td align='right'>".number_format($Fila["fino_ag"],0,",",".")."</td>";
			echo "<td align='right'>".number_format($Fila["fino_au"],0,",",".")."</td>";
			echo "</tr>";
			$TotalPeso = $TotalPeso + $Fila["peso_seco"];			
		}		
	}
	echo "<tr>";
	echo "<td align='center' colspan='2'>TOTAL</td>";		
	echo "<td align='right'>".number_format($TotalPeso,0,",",".")."</td>";		
	if ($TotalFinoCu>0 && $TotalPeso>0)
		echo "<td align='right'>".number_format(($TotalFinoCu/$TotalPeso)*100,2,",",".")."</td>";
	else	echo "<td align='right'>0</td>";
	if ($TotalFinoAg>0 && $TotalPeso>0)
		echo "<td align='right'>".number_format(($TotalFinoAg/$TotalPeso)*1000,2,",",".")."</td>";
	else	echo "<td align='right'>0</td>";
	if ($TotalFinoAu>0 && $TotalPeso>0)
		echo "<td align='right'>".number_format(($TotalFinoAu/$TotalPeso)*1000,2,",",".")."</td>";
	else	echo "<td align='right'>0</td>";
	echo "<td align='right'>".number_format($TotalFinoCu,0,",",".")."</td>";
	echo "<td align='right'>".number_format($TotalFinoAg,0,",",".")."</td>";
	echo "<td align='right'>".number_format($TotalFinoAu,0,",",".")."</td>";
	echo "</tr>";
?>

</table>
</body>
</html>
