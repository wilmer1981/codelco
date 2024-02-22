<?php
	include("../principal/conectar_principal.php");
	$Consulta = "select * from proyecto_modernizacion.flujos where sistema='RAM' and cod_flujo='".$Flujo."'";
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
		$NomFlujo = $Fila["descripcion"];	
?>
<html>
<head>
<title>Detalle de Flujo</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
-->
</style></head>

<body>
<div align="center"><strong>FLUJO:&nbsp;<?php echo $Flujo." - ".strtoupper($NomFlujo); ?>
  </strong><br>
  <br>
</div>
<table width="700" border="1" align="center" cellpadding="3" cellspacing="0">
  <tr align="center" valign="middle" class="ColorTabla01">
    <td width="93" rowspan="2">Rut</td>
    <td width="341" rowspan="2">Descripcion</td>
    <td width="54" rowspan="2">Peso</td>
    <td colspan="3">Leyes</td>
    <td colspan="3">Fino</td>
  </tr>
  <tr class="ColorTabla01">
    <td width="31" align="center">Cu</td>
    <td width="26" align="center">Ag</td>
    <td width="23" align="center">Au</td>
    <td width="17" align="center">Cu</td>
    <td width="21" align="center">Ag</td>
    <td width="20" align="center">Au</td>
  </tr>
<?php
	$Consulta = "SELECT DISTINCT t1.rut_proveedor, t1.cod_producto, t1.cod_subproducto, t2.flujo as flujo1, t3.flujo as flujo2,";
	$Consulta.= " sum(peso_humedo) as peso_humedo, sum(peso_seco) as peso_seco, sum(fino_cu) as fino_cu,";
	$Consulta.= " sum(fino_ag) as fino_ag, SUM(fino_au) as fino_au";
	$Consulta.= " from age_web.recepciones t1 left join age_web.recpromin t2";
	$Consulta.= " on t1.cod_producto = t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto and";
	$Consulta.= " TRIM(t1.rut_proveedor)=trim(t2.rut_proveedor) left join age_web.recpromin t3";
	$Consulta.= " on t1.cod_producto = t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto";
	$Consulta.= " and SUBSTRING(t3.rut_proveedor,1,8)='99999999' where mes='".$Mes."' and ano='".$Ano."'";
	$Consulta.= " and (t2.flujo='".$Flujo."' or t3.flujo='".$Flujo."')  ";
	$Consulta.= " group by cod_producto, cod_subproducto, rut_proveedor";
	$Consulta.= " order BY t2.flujo, t3.flujo,cod_producto , cod_subproducto";
	//echo $Consulta;
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{	
		$Mostrar = false;	
		if ($Fila["flujo1"]!="" && !is_null($Fila["flujo1"]))
		{
			if ($Fila["flujo1"]==$Flujo)
				$Mostrar = true;
		}
		else
		{
			if ($Fila["flujo2"]!="" && !is_null($Fila["flujo2"]))
			{
				if ($Fila["flujo2"]==$Flujo)
					$Mostrar = true;
			}
		}
		if ($Mostrar)
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
	echo "<tr class='ColorTabla02'>";
	echo "<td align='right' colspan='2'><strong>TOTAL</strong></td>";		
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
