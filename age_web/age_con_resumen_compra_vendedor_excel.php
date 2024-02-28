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
	include("../age_web/age_funciones.php");	
	$CmbMes = str_pad($CmbMes,2,"0",STR_PAD_LEFT);
	$TxtFechaIni = $CmbAno."-".$CmbMes."-01";
	$TxtFechaFin = date("Y-m-d", mktime(0,0,0,$CmbMes+1,1,$CmbAno));
	$TxtFechaFin = date("Y-m-d", mktime(0,0,0,substr($TxtFechaFin,5,2),1-1,substr($TxtFechaFin,0,4)));
	$Humedad = true;
	if (substr($TxtFechaIni,0,4)<2006)
	{
		$LoteIni=substr($TxtFechaIni,3,1)."".substr($TxtFechaIni,5,2)."000";
		$LoteFin=substr($TxtFechaFin,3,1)."".substr($TxtFechaFin,5,2)."999";
	}
	else
	{
		$LoteIni=substr($TxtFechaIni,2,2)."".substr($TxtFechaIni,5,2)."0000";
		$LoteFin=substr($TxtFechaFin,2,2)."".substr($TxtFechaFin,5,2)."9999";
	}
?>
<html>
<head>
<title>Sistema de Agencia</title>
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<body>
<form name="frmPrincipal" action="" method="post">
  <table width="620" border="0" align="center">
    <tr>
      <td width="294" colspan="6">CODELCO DIVISION VENTANAS </td>
      <td width="296" align="right" colspan="5">FECHA:&nbsp;<?php echo date("d-m-Y")?></td>
    </tr>
    <tr align="center">
      <td height="30" colspan="11"><strong><u>RESUMEN COMPRA POR VENDEDOR</u></strong></td>
    </tr>
    <tr align="center" colspan="11">
      <td colspan="11">MES: <?php echo $CmbMes."-".$CmbAno; ?></td>
    </tr>
  </table>
  <br>
  <br>
  <?php
	echo "<table width=	\"830\"  border=\"1\" align=\"center\" cellpadding=\"3\" cellspacing=\"0\">\n";
	$Consulta = "select distinct cod_recepcion from age_web.lotes where lote between '".$LoteIni."' and '".$LoteFin."'";
	$Consulta.= "and cod_recepcion <>'' ";
	if($CmbRecepcion!='S')
		$Consulta.= " and cod_recepcion = '".$CmbRecepcion."'";
	if($CmbClaseProd!='S')
		if($CmbClaseProd=='M')
			$Consulta.= " and clase_producto = '".$CmbClaseProd."' ";
		else
			$Consulta.= " and clase_producto <> 'M' ";
	$Consulta.= "order by cod_recepcion ";
	//echo $Consulta;
	$RespAsig = mysqli_query($link, $Consulta);
	while ($FilaAsig = mysqli_fetch_array($RespAsig))
	{
		echo "<tr class=\"ColorTabla01\">\n";
		echo "<td colspan=\"11\">&nbsp;</td>";
		echo "</tr>\n";
		echo "<tr class=\"ColorTabla01\">\n";
		echo "<td align=\"left\" colspan=\"11\">".$FilaAsig[cod_recepcion]."</td>";
		echo "</tr>\n";
		$Consulta = "select distinct case when (t1.valor_subclase1)='METALICO' then 'METALICO' else 'MINERO' end  as valor_subclase1,t1.valor_subclase2 ";
		$Consulta.= "from proyecto_modernizacion.sub_clase t1 inner join age_web.lotes t2 on t1.cod_clase='15001'  and t1.nombre_subclase=t2.clase_producto ";
		$Consulta.= "where t2.lote between '".$LoteIni."' and '".$LoteFin."' and t2.cod_recepcion = '".$FilaAsig[cod_recepcion]."' ";
		if($CmbClaseProd!='S')
			if($CmbClaseProd=='M')
				$Consulta.= " and t1.nombre_subclase = 'M' ";
			else
				$Consulta.= " and t1.nombre_subclase <> 'M' ";		
		$Consulta.="group by t1.valor_subclase2 ";
		//echo $Consulta."<br>";
		$RespClaseProd=mysqli_query($link, $Consulta);
		while($FilaClaseProd=mysqli_fetch_array($RespClaseProd))
		{
			echo "<tr bgcolor=\"#CCCCCC\">\n";
			if($FilaClaseProd["valor_subclase1"]=='METALICO')	
				echo "<td align=\"left\" colspan=\"3\">".strtoupper($FilaClaseProd["valor_subclase1"])."</td>\n";
			else
				echo "<td align=\"left\" colspan=\"3\">".strtoupper('MINERO')."</td>\n";
			echo "<td align=\"center\" colspan=\"4\">LEYES</td>";
			echo "<td align=\"center\">&nbsp;</td>";										
			echo "<td align=\"center\" colspan=\"3\">FINOS</td>";										
			echo "</tr>\n";
			$Consulta="select * from proyecto_modernizacion.subproducto t1 inner join age_web.lotes t2 on t1.mostrar_age='S' and t1.cod_producto=t2.cod_producto and ";
			$Consulta.="t1.cod_subproducto=t2.cod_subproducto where  t2.lote between '".$LoteIni."' and '".$LoteFin."' and t2.cod_recepcion = '".$FilaAsig[cod_recepcion]."' ";
			if($FilaClaseProd["valor_subclase2"]=='METALICO')
				$Consulta.="and t2.clase_producto='M' ";
			else
				$Consulta.="and t2.clase_producto<>'M' ";
			$Consulta.="group by t1.cod_producto,t1.cod_subproducto ";	
			//echo $Consulta."<br>";	
			$RespProd=mysqli_query($link, $Consulta);
			while($FilaProd=mysqli_fetch_array($RespProd))
			{
				echo "<tr class=\"Detalle01\">\n";
				echo "<td colspan=\"2\"><strong>".$FilaProd["descripcion"]."</strong></td>";
				echo "<td align=\"center\"><strong>P.Hum(Kg)</strong></td>\n";
				echo "<td align=\"center\"><strong>Hum(%)</strong></td>\n";
				echo "<td align=\"center\"><strong>Cu(%)</strong></td>\n";
				echo "<td align=\"center\"><strong>Ag(g/T)</strong></td>\n";
				echo "<td align=\"center\"><strong>Au(g/T)</strong></td>\n";
				echo "<td align=\"center\"><strong>P.Seco(Kg)</strong></td>\n";
				echo "<td align=\"center\"><strong>Cu(Kg)</strong></td>\n";
				echo "<td align=\"center\"><strong>Ag(Gr)</strong></td>\n";
				echo "<td align=\"center\"><strong>Au(Gr)</strong></td>\n";
				echo "</tr>\n";
				//CONSULTA LOS PROVEEDOR DE UNA ASINACION Y UNA CLASE PRODUCTO Y UN PRODUCTO
				$Consulta = "select distinct t1.rut_proveedor, t1.cod_recepcion,t2.nombre_prv as nom_prv  ";
				$Consulta.= " from age_web.lotes t1 inner join sipa_web.proveedores t2 on t1.rut_proveedor=t2.rut_prv ";
				$Consulta.= " where t1.lote<>'' and t1.estado_lote <> '6' ";
				$Consulta.= " and t1.lote between '".$LoteIni."' and '".$LoteFin."'";
				$Consulta.= " and t1.cod_recepcion = '".$FilaAsig[cod_recepcion]."' ";
				if($FilaClaseProd["valor_subclase2"]=='METALICO')
					$Consulta.= " and t1.clase_producto = 'M' ";
				else
					$Consulta.= " and t1.clase_producto <> 'M' ";			
				$Consulta.= " and t1.cod_producto = '".$FilaProd["cod_producto"]."' ";
				$Consulta.= " and t1.cod_subproducto = '".$FilaProd["cod_subproducto"]."' ";
				$Consulta.= " order by t1.rut_proveedor ";
				//echo $Consulta."<br>";
				//SUMA LAS HUMEDADES PARA LUEGO COMPARAR SI TIENE ALGO O NO
				$SumHumedad=0;
				$RespPrv = mysqli_query($link, $Consulta);
				while ($FilaPrv = mysqli_fetch_array($RespPrv))
				{						
					echo "<tr>\n";
					echo "<td align=\"left\" colspan=\"2\">".$FilaPrv["rut_proveedor"]." - ".substr(strtoupper($FilaPrv[nom_prv]),0,30)."</td>";
					$ArrDatos=array();
					$ArrLeyesProv=array();
					$ArrLeyesProv["01"][0]="01";$ArrLeyesProv["02"][0]="02";$ArrLeyesProv["04"][0]="04";$ArrLeyesProv["05"][0]="05";
					LeyesProveedor($FilaAsig[cod_recepcion],$FilaPrv["rut_proveedor"],$FilaProd["cod_producto"],$FilaProd["cod_subproducto"],&$ArrDatos,&$ArrLeyesProv,'N','S','S',$TxtFechaIni,$TxtFechaFin,"");
					$CantDecPeso=0;$CantDecLF=0;
					$PesoS=$ArrDatos[peso_seco3];
					if($FilaProd[recepcion]=='PMN')
					{
						$CantDecPeso=4;$CantDecLF=0;
						$PesoS=$ArrDatos[peso_seco];
					}
					echo "<td align=\"right\">".number_format($ArrDatos[peso_humedo],$CantDecPeso,",",".")."</td>\n";
					reset($ArrLeyesProv);
					//SUMA LAS HUMEDADES PARA LUEGO COMPARAR SI TIENE ALGO O NO
					$SumHumedad=$SumHumedad + $ArrLeyesProv["01"][2];
					echo "<td align=\"right\">".number_format($ArrLeyesProv["01"][2],4,",",".")."</td>\n";
					echo "<td align=\"right\">".number_format($ArrLeyesProv["02"][2],2,",",".")."</td>\n";
					echo "<td align=\"right\">".number_format($ArrLeyesProv["04"][2],0,",",".")."</td>\n";
					echo "<td align=\"right\">".number_format($ArrLeyesProv["05"][2],1,",",".")."</td>\n";
					echo "<td align=\"right\">".number_format($PesoS,$CantDecPeso,",",".")."</td>\n";
					reset($ArrLeyesProv);
					echo "<td align=\"right\">".number_format($ArrLeyesProv["02"][23],$CantDecLF,",",".")."</td>\n";
					echo "<td align=\"right\">".number_format($ArrLeyesProv["04"][23],$CantDecLF,",",".")."</td>\n";
					echo "<td align=\"right\">".number_format($ArrLeyesProv["05"][23],$CantDecLF,",",".")."</td>\n";
					echo "</tr>\n";
					$PesoHumProd=$PesoHumProd + $ArrDatos["peso_humedo"];
					$PesoSecoProd=$PesoSecoProd + $PesoS;
					$FinoProdCu=$FinoProdCu + $ArrLeyesProv["02"][23];
					$FinoProdAg=$FinoProdAg + $ArrLeyesProv["04"][23];
					$FinoProdAu=$FinoProdAu + $ArrLeyesProv["05"][23];
				}
				if ($PesoSecoProd>0 && $PesoHumProd>0 && $SumHumedad!=0)
					$PorcHumProd = 100 - (($PesoSecoProd * 100)/$PesoHumProd);
				else
					$PorcHumProd = 0;
				$CantDecPeso=0;$CantDecLF=0;
				if($FilaProd[recepcion]=='PMN')
				{
					$CantDecPeso=4;$CantDecLF=0;
				}
				echo "<tr class=\"ColorTabla01\">\n";
				echo "<td colspan=\"11\">&nbsp;</td>";
				echo "</tr>\n";
				echo "<tr class=\"Detalle01\">\n";
				echo "<td align=\"left\" colspan=\"2\"><strong>TOTAL ".$FilaProd["descripcion"]."</strong></td>";
				echo "<td align=\"right\"><strong>".number_format($PesoHumProd,$CantDecPeso,",",".")."</strong></td>";
				echo "<td align=\"right\"><strong>".number_format($PorcHumProd,4,",",".")."</strong></td>";
				if ($PesoSecoProd>0 && $FinoProdCu>0)
					$LeyProdCu=($FinoProdCu/$PesoSecoProd)*100;
				else
					$LeyProdCu=0;
				if ($PesoSecoProd>0 && $FinoProdAg>0)
					$LeyProdAg=($FinoProdAg/$PesoSecoProd)*1000;
				else
					$LeyProdAg=0;
				if ($PesoSecoProd>0 && $FinoProdAu>0)
					$LeyProdAu=($FinoProdAu/$PesoSecoProd)*1000;
				else
					$LeyProdAu=0;
				echo "<td align=\"right\"><strong>".number_format($LeyProdCu,2,",",".")."</strong></td>";
				echo "<td align=\"right\"><strong>".number_format($LeyProdAg,0,",",".")."</strong></td>";
				echo "<td align=\"right\"><strong>".number_format($LeyProdAu,1,",",".")."</td>";
				echo "<td align=\"right\"><strong>".number_format($PesoSecoProd,$CantDecPeso,",",".")."</strong></td>";
				echo "<td align=\"right\"><strong>".number_format($FinoProdCu,$CantDecLF,",",".")."</strong></td>";
				echo "<td align=\"right\"><strong>".number_format($FinoProdAg,$CantDecLF,",",".")."</strong></td>";
				echo "<td align=\"right\"><strong>".number_format($FinoProdAu,$CantDecLF,",",".")."</strong></td>";
				echo "</tr>\n";
				echo "<tr class=\"ColorTabla01\">\n";
				echo "<td colspan=\"11\">&nbsp;</td>";
				echo "</tr>\n";
				$PesoHumClasProd=$PesoHumClasProd+$PesoHumProd;
				$PesoSecoClasProd=$PesoSecoClasProd+$PesoSecoProd;
				$FinoClasProdCu=$FinoClasProdCu+$FinoProdCu;
				$FinoClasProdAg=$FinoClasProdAg+$FinoProdAg;
				$FinoClasProdAu=$FinoClasProdAu+$FinoProdAu;
				$PesoHumProd=0;$PesoSecoProd=0;$PorcHumProd=0;$FinoProdCu=0;$FinoProdAg=0;$FinoProdAu=0;
			}	
			echo "<tr class=\"ColorTabla01\">\n";
			echo "<td colspan=\"11\">&nbsp;</td>";
			echo "</tr>\n";
			echo "<tr bgcolor=\"#CCCCCC\">\n";
			if($FilaClaseProd["valor_subclase2"]=='METALICO')	
				echo "<td align=\"left\" colspan=\"2\">TOTAL ".$FilaClaseProd["valor_subclase1"]."</td>";
			else
				echo "<td align=\"left\" colspan=\"2\">TOTAL MINERO</td>";
			if ($PesoSecoClasProd>0 && $PesoHumClasProd>0 && $SumHumedad!=0)
				$PorcHumClasProd = 100 - (($PesoSecoClasProd * 100)/$PesoHumClasProd);
			else
				$PorcHumClasProd = 0;
			echo "<td align=\"right\">".number_format($PesoHumClasProd,$CantDecPeso,",",".")."</td>";
			echo "<td align=\"right\">".number_format($PorcHumClasProd,4,",",".")."</td>";
			if ($PesoSecoClasProd>0 && $FinoClasProdCu>0)
				$LeyClasProdCu=($FinoClasProdCu/$PesoSecoClasProd)*100;
			else
				$LeyClasProdCu=0;
			if ($PesoSecoClasProd>0 && $FinoClasProdAg>0)
				$LeyClasProdAg=($FinoClasProdAg/$PesoSecoClasProd)*1000;
			else
				$LeyClasProdAg=0;
			if ($PesoSecoClasProd>0 && $FinoClasProdAu>0)
				$LeyClasProdAu=($FinoClasProdAu/$PesoSecoClasProd)*1000;
			else
				$LeyClasProdAu=0;
			echo "<td align=\"right\">".number_format($LeyClasProdCu,2,",",".")."</td>";
			echo "<td align=\"right\">".number_format($LeyClasProdAg,0,",",".")."</td>";
			echo "<td align=\"right\">".number_format($LeyClasProdAu,1,",",".")."</td>";
			echo "<td align=\"right\">".number_format($PesoSecoClasProd,$CantDecPeso,",",".")."</td>";
			echo "<td align=\"right\">".number_format($FinoClasProdCu,0,",",".")."</td>";
			echo "<td align=\"right\">".number_format($FinoClasProdAg,0,",",".")."</td>";
			echo "<td align=\"right\">".number_format($FinoClasProdAu,0,",",".")."</td>";
			echo "</tr>\n";
			$PesoHumAsig=$PesoHumAsig+$PesoHumClasProd;
			$PesoSecoAsig=$PesoSecoAsig+$PesoSecoClasProd;
			$FinoAsigCu=$FinoAsigCu+$FinoClasProdCu;
			$FinoAsigAg=$FinoAsigAg+$FinoClasProdAg;
			$FinoAsigAu=$FinoAsigAu+$FinoClasProdAu;
			$PesoHumClasProd=0;$PesoSecoClasProd=0;$PorcHumClasProd=0;$FinoClasProdCu=0;$FinoClasProdAg=0;$FinoClasProdAu=0;
		}
		echo "<tr class=\"ColorTabla01\">\n";
		echo "<td colspan=\"11\">&nbsp;</td>";
		echo "</tr>\n";
		echo "<tr class=\"ColorTabla01\">\n";
		echo "<td align=\"left\" colspan=\"2\">TOTAL ".$FilaAsig[cod_recepcion]."</td>";
		if ($PesoSecoAsig>0 && $PesoHumAsig>0 && $SumHumedad!=0)
			$PorcHumAsig = 100 - (($PesoSecoAsig * 100)/$PesoHumAsig);
		else
			$PorcHumAsig = 0;
		echo "<td align=\"right\">".number_format($PesoHumAsig,$CantDecPeso,",",".")."</td>";
		echo "<td align=\"right\">".number_format($PorcHumAsig,4,",",".")."</td>";
		if ($PesoSecoAsig>0 && $FinoAsigCu>0)
			$LeyAsigCu=($FinoAsigCu/$PesoSecoAsig)*100;
		else
			$LeyAsigCu=0;
		if ($PesoSecoAsig>0 && $FinoAsigAg>0)
			$LeyAsigAg=($FinoAsigAg/$PesoSecoAsig)*1000;
		else
			$LeyAsigAg=0;
		if ($PesoSecoAsig>0 && $FinoAsigAu>0)
			$LeyAsigAu=($FinoAsigAu/$PesoSecoAsig)*1000;
		else
			$LeyAsigAu=0;
		echo "<td align=\"right\">".number_format($LeyAsigCu,2,",",".")."</td>";
		echo "<td align=\"right\">".number_format($LeyAsigAg,2,",",".")."</td>";
		echo "<td align=\"right\">".number_format($LeyAsigAu,2,",",".")."</td>";
		echo "<td align=\"right\">".number_format($PesoSecoAsig,$CantDecPeso,",",".")."</td>";
		echo "<td align=\"right\">".number_format($FinoAsigCu,0,",",".")."</td>";
		echo "<td align=\"right\">".number_format($FinoAsigAg,0,",",".")."</td>";
		echo "<td align=\"right\">".number_format($FinoAsigAu,0,",",".")."</td>";
		echo "</tr>\n";
		$PesoHumTot=$PesoHumTot+$PesoHumAsig;
		$PesoSecoTot=$PesoSecoTot+$PesoSecoAsig;
		$FinoTotCu=$FinoTotCu+$FinoAsigCu;
		$FinoTotAg=$FinoTotAg+$FinoAsigAg;
		$FinoTotAu=$FinoTotAu+$FinoAsigAu;
		$PesoHumAsig=0;$PesoSecoAsig=0;$PorcHumAsig=0;$FinoAsigCu=0;$FinoAsigAg=0;$FinoAsigAu=0;
	}
	echo "<tr class=\"Detalle03\">\n";
	echo "<td align=\"left\" colspan=\"2\">TOTAL</td>";
	if ($PesoSecoTot>0 && $PesoHumTot>0  && $SumHumedad!=0)
		$PorcHumTot = 100 - (($PesoSecoTot * 100)/$PesoHumTot);
	else
		$PorcHumTot = 0;
	echo "<td align=\"right\">".number_format($PesoHumTot,$CantDecPeso,",",".")."</td>";
	echo "<td align=\"right\">".number_format($PorcHumTot,4,",",".")."</td>";
	if ($PesoSecoTot>0 && $FinoTotCu>0)
		$LeyTotCu=($FinoTotCu/$PesoSecoTot)*100;
	else
		$LeyTotCu=0;
	if ($PesoSecoTot>0 && $FinoTotAg>0)
		$LeyTotAg=($FinoTotAg/$PesoSecoTot)*1000;
	else
		$LeyTotAg=0;
	if ($PesoSecoTot>0 && $FinoTotAu>0)
		$LeyTotAu=($FinoTotAu/$PesoSecoTot)*1000;
	else
		$LeyTotAu=0;
	echo "<td align=\"right\">".number_format($LeyTotCu,2,",",".")."</td>";
	echo "<td align=\"right\">".number_format($LeyTotAg,0,",",".")."</td>";
	echo "<td align=\"right\">".number_format($LeyTotAu,1,",",".")."</td>";
	echo "<td align=\"right\">".number_format($PesoSecoTot,$CantDecPeso,",",".")."</td>";
	echo "<td align=\"right\">".number_format($FinoTotCu,0,",",".")."</td>";
	echo "<td align=\"right\">".number_format($FinoTotAg,0,",",".")."</td>";
	echo "<td align=\"right\">".number_format($FinoTotAu,0,",",".")."</td>";
	echo "</tr>\n";
	echo "</table>\n";
 ?> 
  <br>
  <br>
  <table width="100%"  border="0" cellpadding="1" cellspacing="0">
    <tr>
      <td align="center" colspan="11">________________________<br>
        Hugo Valenzuela Ya&ntilde;ez<br>
        Jefe Abastecimiento Minero </td>
    </tr>
  </table> 
</form>
</body>
</html>