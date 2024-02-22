<?php
	        ob_end_clean();
        $file_name=basename($_SERVER['PHP_SELF']).".xls";
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
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
?>
<html>
<head>
<title>Sistema de Agencia</title></head>

<body>
<form name="frmPrincipal" action="" method="post">      
<?php	
if ($Mostrar == "S")
{	
	echo "<table width='750' border='1' cellpadding='3' cellspacing='0' class='TablaDetalle'>\n";
	$Consulta = "select distinct cod_producto, cod_subproducto, ";
	$Consulta.= " case when length(cod_producto)=1 then concat('0',cod_producto) else cod_producto end as orden1, ";
	$Consulta.= " case when length(cod_subproducto)=1 then concat('0',cod_subproducto) else cod_subproducto end as orden2 ";
	$Consulta.= " from age_web.recepciones ";
	$Consulta.= " where ano='".$Ano."' and mes='".$Mes."'";
	if ($SubProducto!="S")
		$Consulta.= " and cod_producto='1' and cod_subproducto='".$SubProducto."'";
	$Consulta.= " order by orden1, orden2 ";
	$RespProd = mysqli_query($link, $Consulta);
	while ($FilaProd = mysqli_fetch_array($RespProd))
	{
		$Consulta = "select t1.descripcion as nom_prod, t2.descripcion as nom_subprod ";
		$Consulta.= " from proyecto_modernizacion.productos t1 inner join proyecto_modernizacion.subproducto t2";
		$Consulta.= " on t1.cod_producto = t2.cod_producto ";
		$Consulta.= " where t2.cod_producto='".$FilaProd["cod_producto"]."' and t2.cod_subproducto='".$FilaProd["cod_subproducto"]."' ";
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Resp2))
		{
			$NomProd = $Fila2["nom_prod"];
			$NomSubProd = $Fila2["nom_subprod"];
		}		
		else
		{
			$NomProd = "";
			$NomSubProd = "";
		}		
		echo "<tr class='ColorTabla01'>\n";
		echo "<td colspan='11'><strong>Producto: ".$FilaProd["cod_producto"]."-".$NomProd." / SubProducto: ".$FilaProd["cod_subproducto"]."-".$NomSubProd."</strong></td>\n";
		echo "</tr>\n";
		echo "<tr class='ColorTabla01'>\n";
		echo "<td rowspan='2' width='61'>Rut</td>\n";
		echo "<td rowspan='2' width='116'>Proveedor</td>\n";
		echo "<td rowspan='2' width='50'>P.Hum</td>\n";
		echo "<td rowspan='2' width='50'>P.Seco</td>\n";		
		echo "<td colspan='3' width='50'>FINOS</td>\n";
		echo "<td rowspan='2' width='50'>Hum(%)</td>\n";
		echo "<td colspan='3' width='50'>LEYES</td>\n";
		echo "</tr>";
		echo "<tr class='ColorTabla01'>";
		echo "<td width='50'>Cu</td>\n";
		echo "<td width='50'>Ag</td>\n";
		echo "<td width='50'>Au </td>\n";
		echo "<td width='50'>Cu</td>\n";
		echo "<td width='50'>Ag</td>\n";
		echo "<td width='50'>Au</td>\n";
		echo "</tr>\n";
		$TotalPSeco = 0;
		$TotalPHumedo = 0;
		$TotalFinoCu = 0;
		$TotalFinoAg = 0;
		$TotalFinoAu = 0;
		$Consulta = "select * from age_web.recepciones ";
		$Consulta.= " where ano='".$Ano."' and mes='".$Mes."'";
		$Consulta.= " and cod_producto = '".$FilaProd["cod_producto"]."'";
		$Consulta.= " and cod_subproducto = '".$FilaProd["cod_subproducto"]."'";
		$Consulta.= " order by cod_producto, rut_proveedor";
		$Resp = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Resp))
		{
			$Consulta = "select * from ram_web.proveedor ";
			$Consulta.= " where trim(rut_proveedor) = trim('".$Fila["rut_proveedor"]."')";
			$RespProv = mysqli_query($link, $Consulta);
			if ($FilaProv = mysqli_fetch_array($RespProv))
				$NomProv = $FilaProv["nombre"];
			else
				$NomProv = "&nbsp;";
			echo "<tr>\n";
			echo "<td align='center'>".$Fila["rut_proveedor"]."</td>\n";
			echo "<td align='left'>".$NomProv."</td>\n";			
			echo "<td align='right'>".number_format($Fila["peso_humedo"],0,",",".")."</td>\n";
			//FINOS
			echo "<td align='right'>".number_format($Fila["peso_seco"],0,",",".")."</td>\n";
			echo "<td align='right'>".number_format($Fila["fino_cu"],0,",",".")."</td>\n";
			echo "<td align='right'>".number_format($Fila["fino_ag"],0,",",".")."</td>\n";
			echo "<td align='right'>".number_format($Fila["fino_au"],0,",",".")."</td>\n";
			//(%) Humedad
			if ($Fila["peso_seco"]>0 && $Fila["peso_humedo"]>0)
				echo "<td align='right'>".number_format(100-(($Fila["peso_seco"]/$Fila["peso_humedo"])*100),2,",",".")."</td>\n";
			else
				echo "<td align='right'>0</td>\n";
			//LEYES
			if ($Fila["peso_seco"]>0 && $Fila["fino_cu"]>0)
				echo "<td align='right'>".number_format(($Fila["fino_cu"]/$Fila["peso_seco"])*100,2,",",".")."</td>\n";
			else
				echo "<td align='right'>0</td>\n";
			if ($Fila["peso_seco"]>0 && $Fila["fino_ag"]>0)
				echo "<td align='right'>".number_format(($Fila["fino_ag"]/$Fila["peso_seco"])*1000,2,",",".")."</td>\n";
			else
				echo "<td align='right'>0</td>\n";
			if ($Fila["peso_seco"]>0 && $Fila["fino_au"]>0)
				echo "<td align='right'>".number_format(($Fila["fino_au"]/$Fila["peso_seco"])*1000,2,",",".")."</td>\n";
			else
				echo "<td align='right'>0</td>\n";
			echo "</tr>\n";
			$TotalPSeco = $TotalPSeco + $Fila["peso_seco"];
			$TotalPHumedo = $TotalPHumedo + $Fila["peso_humedo"];
			$TotalFinoCu = $TotalFinoCu + $Fila["fino_cu"];
			$TotalFinoAg = $TotalFinoAg + $Fila["fino_ag"];
			$TotalFinoAu = $TotalFinoAu + $Fila["fino_au"];
		}
		echo "<tr class='ColorTabla02'>\n";
		echo "<td align='center' colspan='2'>TOTAL PRODUCTO</td>\n";
		echo "<td align='right'>".number_format($TotalPHumedo,0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($TotalPSeco,0,",",".")."</td>\n";	
		//TOTAL FINOS	
		echo "<td align='right'>".number_format($TotalFinoCu,0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($TotalFinoAg,0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($TotalFinoAu,0,",",".")."</td>\n";
		//(%) HUMEDAD
		if ($TotalPSeco>0 && $TotalPHumedo>0)
			echo "<td align='right'>".number_format(100-(($TotalPSeco/$TotalPHumedo)*100),2,",",".")."</td>\n";
		else
			echo "<td align='right'>0</td>\n";
		//TOTAL LEYES
		if ($TotalPSeco>0 && $TotalFinoCu>0)
			echo "<td align='right'>".number_format(($TotalFinoCu/$TotalPSeco)*100,2,",",".")."</td>\n";
		else
			echo "<td align='right'>0</td>\n";
		if ($TotalPSeco>0 && $TotalFinoAg>0)
			echo "<td align='right'>".number_format(($TotalFinoAg/$TotalPSeco)*1000,2,",",".")."</td>\n";
		else
			echo "<td align='right'>0</td>\n";
		if ($TotalPSeco>0 && $TotalFinoAu>0)
			echo "<td align='right'>".number_format(($TotalFinoAu/$TotalPSeco)*1000,2,",",".")."</td>\n";
		else
			echo "<td align='right'>0</td>\n";
		echo "</tr>\n";
	}
}
?>		  
  </table>
</form>
</body>
</html>
