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
	include("age_funciones.php");

	$Mostrar = isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"";
	$Mes     = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date('n');
	$Ano     = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date('Y');
	$TxtFiltroPrv  = isset($_REQUEST["TxtFiltroPrv"])?$_REQUEST["TxtFiltroPrv"]:"";
	$SubProducto   = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
	$Proveedor     = isset($_REQUEST["Proveedor"])?$_REQUEST["Proveedor"]:"";
	$Busq          = isset($_REQUEST["Busq"])?$_REQUEST["Busq"]:"";
?>
<html>
<head>
<title>AGE-Consulta Comparacion Canje Leyes Excel</title>
</head>
<body leftmargin="3" topmargin="5">
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="Valores" value="">
<table width="770" border="0" cellpadding="5" cellspacing="0" >
<tr> 
  <td width="762" height="313" align="center" valign="top"><br>
	  <br>
	  <table width="750" border="1" align="center" cellpadding="2" cellspacing="0">
<?php		
if ($Mostrar=="S")
{
	if ($Ano<2006)
	{
		$LoteIni = substr($Ano,3,1).str_pad($Mes,2,'0',STR_PAD_LEFT)."000";
		$LoteFin = substr($Ano,3,1).str_pad($Mes,2,'0',STR_PAD_LEFT)."999";
	}
	else
	{	
		$LoteIni = substr($Ano,2,2).str_pad($Mes,2,'0',STR_PAD_LEFT)."0000";
		$LoteFin = substr($Ano,2,2).str_pad($Mes,2,'0',STR_PAD_LEFT)."9999";
	}
	//CONSULTA LOS DISTINTOS PRODUCTOS Y PROVEEDORES CON MUESTRA PARALELA
	$Consulta = "select distinct t1.cod_producto, t1.cod_subproducto, t1.rut_proveedor, t2.descripcion, t3.nomprv_a ";
	$Consulta.= " from age_web.lotes t1 inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto ";
	$Consulta.= " and t1.cod_subproducto=t2.cod_subproducto inner join rec_web.proved t3 on t1.rut_proveedor=t3.rutprv_a";
	$Consulta.= " where t1.lote between '".$LoteIni."' and '".$LoteFin."' and canjeable='S' ";
	if ($SubProducto!="S")
		$Consulta.= " and t1.cod_producto='1' and t1.cod_subproducto='".$SubProducto."'";
	if ($Proveedor!="S")
		$Consulta.= " and t1.rut_proveedor='".$Proveedor."'";		
	$Consulta.= " order by lpad(t1.cod_subproducto,4,'0'), lpad(t1.rut_proveedor,11,'0') ";
	$Resp = mysqli_query($link, $Consulta);
	$Cont=0;
	while ($Fila = mysqli_fetch_array($Resp))
	{
		Titulo($Fila["cod_subproducto"],$Fila["descripcion"],$Fila["rut_proveedor"],$Fila["nomprv_a"]);
		$Consulta = "select distinct t1.lote, t1.muestra_paralela, t1.remuestreo, t1.num_lote_remuestreo, t1.estado_lote ";
		$Consulta.= " from age_web.lotes t1 inner join age_web.leyes_por_lote_canje t2 on t1.lote=t2.lote ";
		$Consulta.= " where t1.lote  between '".$LoteIni."' and '".$LoteFin."' and canjeable='S'";
		$Consulta.= " and t1.cod_producto='".$Fila["cod_producto"]."' ";
		$Consulta.= " and t1.cod_subproducto='".$Fila["cod_subproducto"]."' ";
		$Consulta.= " and t1.rut_proveedor='".$Fila["rut_proveedor"]."'";
		$Resp2 = mysqli_query($link, $Consulta);
		while ($Fila2 = mysqli_fetch_array($Resp2))
		{
			$Lote=$Fila2["lote"];
			$Cu_Pri=0;$Ag_Pri=0;$Au_Pri=0;$Cu_Seg=0;$Ag_Seg=0;$Au_Seg=0;$Cu_Ter=0;$Ag_Ter=0;$Au_Ter=0;$SA_Pri="";
			Leyes($Lote,$Cu_Pri,$Ag_Pri,$Au_Pri,$Cu_Seg,$Ag_Seg,$Au_Seg,$Cu_Ter,$Ag_Ter,$Au_Ter,$Ley_CanjeCu,$Ley_CanjeAg,$Ley_CanjeAu,$SA_Pri,$link);						
			$Cu_Dif=0;$Ag_Dif=0;$Au_Dif=0;$Cu_Dif2=0;$Ag_Dif2=0;$Au_Dif2=0;
			if($Cu_Seg>0)
				$Cu_Dif=abs($Cu_Pri-$Cu_Seg);
			if($Ag_Seg>0)	
				$Ag_Dif=abs($Ag_Pri-$Ag_Seg);
			if($Au_Seg>0)	
				$Au_Dif=abs($Au_Pri-$Au_Seg);
			if($Cu_Ter>0)	
				$Cu_Dif2=abs($Cu_Pri-$Cu_Ter);
			if($Ag_Ter>0)	
				$Ag_Dif2=abs($Ag_Pri-$Ag_Ter);
			if($Au_Ter>0)	
				$Au_Dif2=abs($Au_Pri-$Au_Ter);
			echo "<tr align=\"center\">\n";
			echo "<td>".$Lote."</td>\n";			
			if($Cu_Pri==0)
				echo "<td align=\"right\">&nbsp;</td>\n";
			else			
				echo "<td align=\"right\">".number_format($Cu_Pri,3,",",".")."</td>\n";
			if($Ag_Pri==0)
				echo "<td align=\"right\">&nbsp;</td>\n";
			else
				echo "<td align=\"right\">".number_format($Ag_Pri,3,",",".")."</td>\n";
			if($Au_Pri==0)	
				echo "<td align=\"right\">&nbsp;</td>\n";
			else
				echo "<td align=\"right\">".number_format($Au_Pri,3,",",".")."</td>\n";
			if($Cu_Seg==0)
				echo "<td align=\"right\">&nbsp;</td>\n";
			else
				echo "<td align=\"right\">".number_format($Cu_Seg,3,",",".")."</td>\n";
			if($Ag_Seg==0)
				echo "<td align=\"right\">&nbsp;</td>\n";
			else
				echo "<td align=\"right\">".number_format($Ag_Seg,3,",",".")."</td>\n";
			if($Au_Seg==0)
				echo "<td align=\"right\">&nbsp;</td>\n";
			else
				echo "<td align=\"right\">".number_format($Au_Seg,3,",",".")."</td>\n";
			if($Cu_Dif==0)
				echo "<td class='Detalle02' align=\"right\">&nbsp;</td>\n";
			else
				echo "<td class='Detalle02' align=\"right\">".number_format($Cu_Dif,3,",",".")."</td>\n";
			if($Ag_Dif==0)
				echo "<td class='Detalle02' align=\"right\">&nbsp;</td>\n";
			else
				echo "<td class='Detalle02' align=\"right\">".number_format($Ag_Dif,3,",",".")."</td>\n";
			if($Au_Dif==0)
				echo "<td class='Detalle02' align=\"right\">&nbsp;</td>\n";
			else
				echo "<td class='Detalle02' align=\"right\">".number_format($Au_Dif,3,",",".")."</td>\n";
			if($Cu_Ter==0)
				echo "<td align=\"right\">&nbsp;</td>\n";
			else
				echo "<td align=\"right\">".number_format($Cu_Ter,3,",",".")."</td>\n";
			if($Ag_Ter==0)
				echo "<td align=\"right\">&nbsp;</td>\n";
			else
				echo "<td align=\"right\">".number_format($Ag_Ter,3,",",".")."</td>\n";
			if($Au_Ter==0)
				echo "<td align=\"right\">&nbsp;</td>\n";
			else
				echo "<td align=\"right\">".number_format($Au_Ter,3,",",".")."</td>\n";
			if($Cu_Dif2==0)
				echo "<td class='Detalle02' align=\"right\">&nbsp;</td>\n";
			else
				echo "<td class='Detalle02' align=\"right\">".number_format($Cu_Dif2,3,",",".")."</td>\n";
			if($Ag_Dif2==0)
				echo "<td class='Detalle02' align=\"right\">&nbsp;</td>\n";
			else
				echo "<td class='Detalle02' align=\"right\">".number_format($Ag_Dif2,3,",",".")."</td>\n";
			if($Au_Dif2==0)
				echo "<td class='Detalle02' align=\"right\">&nbsp;</td>\n";
			else
				echo "<td class='Detalle02' align=\"right\">".number_format($Au_Dif2,3,",",".")."</td>\n";
			$ColorCeldaCu="";
			if($Ley_CanjeCu==$Cu_Pri)
				$ColorCeldaCu="bgcolor=\"#FFFF00\"";
			else 
				if($Ley_CanjeCu==$Cu_Seg)	
					$ColorCeldaCu="bgcolor=\"#FFFFFF\"";
			echo "<td $ColorCeldaCu align=\"right\">".number_format($Ley_CanjeCu,3,",",".")."</td>\n";
			$ColorCeldaAg="";
			if($Ley_CanjeAg==$Ag_Pri)
				$ColorCeldaAg="bgcolor=\"#FFFF00\"";
			else 
				if($Ley_CanjeAg==$Ag_Seg)	
					$ColorCeldaAg="bgcolor=\"#FFFFFF\"";
			echo "<td $ColorCeldaAg align=\"right\">".number_format($Ley_CanjeAg,3,",",".")."</td>\n";
			$ColorCeldaAu="";
			if($Ley_CanjeAu==$Au_Pri)
				$ColorCeldaAu="bgcolor=\"#FFFF00\"";
			else 
				if($Ley_CanjeAu==$Au_Seg)	
					$ColorCeldaAu="bgcolor=\"#FFFFFF\"";
			echo "<td $ColorCeldaAu align=\"right\">".number_format($Ley_CanjeAu,3,",",".")."</td>\n";
			echo "</tr>\n";			
		}		
	}
}//FIN MOSTRAR = S	
function Titulo($Prod, $NomProd, $Proved, $NomProved)
{
	echo "<tr>\n";
	echo "<td colspan=\"7\">Producto:&nbsp;".str_pad($Prod,2,'0',STR_PAD_LEFT)."-".strtoupper($NomProd)."</td>\n";
	echo "<td colspan=\"12\">Proveedor:&nbsp;".str_pad($Proved,10,'0',STR_PAD_LEFT)."-".strtoupper($NomProved)."</td>\n";
	echo "</tr>\n";
	echo "<tr align=\"center\">\n";
	echo "<td width=\"40\" rowspan=\"2\">Lote</td> \n";
	echo "<td colspan=\"3\">Paquete Primero</td>\n";
	echo "<td colspan=\"3\">Paquete Segundo</td>\n";
	echo "<td colspan=\"3\">Diferencia Pqte1-Pqte2</td>\n";
	echo "<td colspan=\"3\">Paquete Tercero</td>\n";
	echo "<td colspan=\"3\">Diferencia Pqte1-Pqte3</td>\n";
	echo "<td colspan=\"3\">Resultados</td>\n";
	echo "</tr>\n";
	echo "<tr align=\"center\">\n";
	echo "<td width=\"57\">Cu</td>\n";
	echo "<td width=\"57\">Ag</td>\n";
	echo "<td width=\"57\">Au</td>\n";
	echo "<td width=\"57\">Cu</td>\n";
	echo "<td width=\"57\">Ag</td>\n";
	echo "<td width=\"57\">Au</td>\n";
	echo "<td width=\"57\">Cu</td>\n";
	echo "<td width=\"57\">Ag</td>\n";
	echo "<td width=\"57\">Au</td>\n";
	echo "<td width=\"57\">Cu</td>\n";
	echo "<td width=\"57\">Ag</td>\n";
	echo "<td width=\"57\">Au</td>\n";
	echo "<td width=\"57\">Cu</td>\n";
	echo "<td width=\"57\">Ag</td>\n";
	echo "<td width=\"57\">Au</td>\n";
	echo "<td width=\"57\">Cu</td>\n";
	echo "<td width=\"57\">Ag</td>\n";
	echo "<td width=\"57\">Au</td>\n";
	echo "</tr>\n";
}//FIN FUNCION TITULO

function Leyes($Lote,$Cu_Pri,$Ag_Pri,$Au_Pri,$Cu_Seg,$Ag_Seg,$Au_Seg,$Cu_Ter,$Ag_Ter,$Au_Ter,$Ley_CanjeCu,$Ley_CanjeAg,$Ley_CanjeAu,$SA_Pri,$link)
{
	$Consulta="select * from age_web.leyes_por_lote_canje where lote='".$Lote."' and cod_leyes in('02','04','05') order by lote,cod_leyes";
	$Cu_Par=0;$Ag_Par=0;$Au_Par=0;
	$Respuesta=mysqli_query($link, $Consulta);
	while($FilaLeyes=mysqli_fetch_array($Respuesta))
	{
		switch($FilaLeyes["cod_leyes"])
		{
			case "02":
				$Cu_Pri=$FilaLeyes["valor1"];
				$Cu_Seg=$FilaLeyes["valor2"];
				$Cu_Ter=$FilaLeyes["valor3"];
				$Ley_CanjeCu=$FilaLeyes["ley_canje"];
				break;
			case "04":
				$Ag_Pri=$FilaLeyes["valor1"];
				$Ag_Seg=$FilaLeyes["valor2"];
				$Ag_Ter=$FilaLeyes["valor3"];
				$Ley_CanjeAg=$FilaLeyes["ley_canje"];
				break;
			case "05":
				$Au_Pri=$FilaLeyes["valor1"];
				$Au_Seg=$FilaLeyes["valor2"];
				$Au_Ter=$FilaLeyes["valor3"];
				$Ley_CanjeAu=$FilaLeyes["ley_canje"];
				break;
		}
	}
	//CONSULTA LA S.A. PAQUETE PRIMERO
	$Consulta = "select distinct t1.id_muestra,t1.nro_solicitud, t1.recargo ";
	$Consulta.= " from cal_web.solicitud_analisis t1 ";
	$Consulta.= " where t1.id_muestra='".$Lote."' and t1.agrupacion in(1,3,6)";// and t1.cod_producto='1' and t1.cod_subproducto='$CodSubProducto'";
	if($Recargo=='')
		$Consulta.= " and (t1.recargo='0' or t1.recargo='')";
	else
		$Consulta.= " and t1.recargo='".$Recargo."'";	
	$RespSA=mysqli_query($link, $Consulta);
	if($FilaSA=mysqli_fetch_array($RespSA))
		$SA_Pri=$FilaSA["nro_solicitud"];
}
?>
  </table>	  
</td></tr>
</table>
</form>
</body>
</html>