<?php 
	ob_end_clean();
	$file_name=basename($_SERVER['PHP_SELF']).".xls";
	$userBrowser = $_SERVER['HTTP_USER_AGENT'];
	$filename="";
	if ( preg_match( '/MSIE/i', $userBrowser ) ) {
	$filename = urlencode($filename);
	}
	$filename = iconv('UTF-8', 'gb2312', $filename);
	$file_name = str_replace(".php", "", $file_name);
	header("<meta http-equiv='X-UA-Compatible' content='IE=Edge'>");
	header("<meta http-equiv='content-type' content='text/html;charset=uft-8'>");
	
	header("content-disposition: attachment;filename={$file_name}");
	header( "Cache-Control: public" );
	header( "Pragma: public" );
	header( "Content-type: text/csv" ) ;
	header( "Content-Dis; filename={$file_name}" ) ;
	header("Content-Type:  application/vnd.ms-excel");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	include("../principal/conectar_principal.php");
	$Mes         = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");
	$Ano         = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
	$Producto    = isset($_REQUEST["Producto"])?$_REQUEST["Producto"]:"";
	$SubProducto = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
	$ChkLeyes    = isset($_REQUEST["ChkLeyes"])?$_REQUEST["ChkLeyes"]:"";
	$PesoHum     = isset($_REQUEST["PesoHum"])?$_REQUEST["PesoHum"]:"";
?>
<html>
<head>
<title>Sistema RAM</title>
</head>

<body leftmargin="3" topmargin="5">

        <br>
        <table width="95%"  border="1" cellpadding="2" cellspacing="0" class="TablaDetalle">
          <tr class="ColorTabla01">
            <td width="4%">Prod</td>
            <td width="7%">SubProd</td>
            <td width="23%">Descripcion</td>
            <td width="10%">Peso.Hum</td>
            <td width="9%">Peso.Seco</td>
            <td width="8%">Fino.Cu</td>
            <td width="7%">Fino.Ag</td>
            <td width="8%">Fino.Au</td>
			<td width="8%">Fino.As</td>
            <td width="6%">Ley.Cu</td>
            <td width="7%">Ley.Ag</td>
            <td width="7%">Ley.Au</td>
			<td width="7%">Ley.As</td>
          </tr>
<?php	
	if (!isset($Mes))	
	{
	 	$Mes = date("n");
		$Ano = date("Y");
	} 
	$FechaAux1 = date("Y-m-d", mktime(0,0,0,$Mes+1,1,$Ano));
	$FechaAux2 = date("Y-m-d", mktime(0,0,0,intval(substr($FechaAux1,5,2)),1-1,intval(substr($FechaAux1,0,4))));
	$Consulta = "select * from ram_web.stock_piso "; 
	$Consulta.= " where fecha = '".$FechaAux2."'";
	$Consulta.= " order by cod_producto, cod_subproducto"; 
	$Resp = mysqli_query($link, $Consulta);
	$TotalPesoHum  = 0;$TotalPesoSeco = 0;
	$TotalFinoCu = 0;$TotalFinoAg = 0;$TotalFinoAu = 0;$TotalFinoAs = 0;
	while ($Fila = mysqli_fetch_array($Resp))
	{
		echo "<tr>\n";
		echo "<td align='center'>".$Fila["cod_producto"]."</td>\n";
		echo "<td align='center'>".$Fila["cod_subproducto"]."</td>\n";
		//SUBPRODUCTO
		$Consulta = "select * from proyecto_modernizacion.subproducto ";
		$Consulta.= " where cod_producto='".$Fila["cod_producto"]."'";
		$Consulta.= " and cod_subproducto='".$Fila["cod_subproducto"]."'";
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Resp2))
			echo "<td>".$Fila2["descripcion"]."</td>\n";
		else
			echo "<td>&nbsp;</td>\n";
		echo "<td align='right'>".number_format($Fila["peso_humedo"],0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["peso_seco"],0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["fino_cu"],0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["fino_ag"],0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["fino_au"],0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["fino_as"],0,",",".")."</td>\n";
		if ($Fila["peso_seco"]!=0 && $Fila["fino_cu"]!=0)
			echo "<td align='right'>".number_format(($Fila["fino_cu"]/$Fila["peso_seco"])*100,2,",",".")."</td>\n";
		else
			echo "<td align='right'>0</td>\n";
		if ($Fila["peso_seco"]!=0 && $Fila["fino_ag"]!=0)
			echo "<td align='right'>".number_format(($Fila["fino_ag"]/$Fila["peso_seco"])*1000,0,",",".")."</td>\n";
		else
			echo "<td align='right'>0</td>\n";
		if ($Fila["peso_seco"]!=0 && $Fila["fino_au"]!=0)
			echo "<td align='right'>".number_format(($Fila["fino_au"]/$Fila["peso_seco"])*1000,1,",",".")."</td>\n";
		else
			echo "<td align='right'>0</td>\n";
		if ($Fila["peso_seco"]!=0 && $Fila["fino_as"]!=0)
			echo "<td align='right'>".number_format(($Fila["fino_as"]/$Fila["peso_seco"])*100,2,",",".")."</td>\n";
		else
			echo "<td align='right'>0</td>\n";
		echo "</tr>\n";
		$TotalPesoHum = $TotalPesoHum + $Fila["peso_humedo"];
		$TotalPesoSeco = $TotalPesoSeco + $Fila["peso_seco"];
		$TotalFinoCu = $TotalFinoCu + $Fila["fino_cu"];
		$TotalFinoAg = $TotalFinoAg + $Fila["fino_ag"];
		$TotalFinoAu = $TotalFinoAu + $Fila["fino_au"];
		$TotalFinoAs = $TotalFinoAs + $Fila["fino_as"];
	}
	echo "<tr>\n";
	echo "<td colspan='3' align='right'><strong>TOTAL</strong></td>\n";
	echo "<td align='right'>".number_format($TotalPesoHum,0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($TotalPesoSeco,0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($TotalFinoCu,0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($TotalFinoAg,0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($TotalFinoAu,0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($TotalFinoAs,0,",",".")."</td>\n";
	if ($TotalPesoSeco!=0 && $TotalFinoCu!=0)
		echo "<td align='right'>".number_format(($TotalFinoCu/$TotalPesoSeco)*100,2,",",".")."</td>\n";
	else
		echo "<td align='right'>0</td>\n";
	if ($TotalPesoSeco!=0 && $TotalFinoAg!=0)
		echo "<td align='right'>".number_format(($TotalFinoAg/$TotalPesoSeco)*1000,0,",",".")."</td>\n";
	else
		echo "<td align='right'>0</td>\n";
	if ($TotalPesoSeco!=0 && $TotalFinoAu!=0)
		echo "<td align='right'>".number_format(($TotalFinoAu/$TotalPesoSeco)*1000,1,",",".")."</td>\n";
	else
		echo "<td align='right'>0</td>\n";
	if ($TotalPesoSeco!=0 && $TotalFinoAs!=0)
		echo "<td align='right'>".number_format(($TotalFinoAs/$TotalPesoSeco)*100,2,",",".")."</td>\n";
	else
		echo "<td align='right'>0</td>\n";
	echo "</tr>\n";
?>		           
        </table>        
</body>
</html>
