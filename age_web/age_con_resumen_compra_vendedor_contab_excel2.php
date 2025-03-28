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
	include("../age_web/age_funciones.php");	
	$CmbMes        = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:date('m');
	$CmbAno        = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date("Y");
	$CmbRecepcion  = isset($_REQUEST["CmbRecepcion"])?$_REQUEST["CmbRecepcion"]:"";
	$TxtFechaConsulta  = isset($_REQUEST["TxtFechaConsulta"])?$_REQUEST["TxtFechaConsulta"]:"";
	$CmbClaseProd  = isset($_REQUEST["CmbClaseProd"])?$_REQUEST["CmbClaseProd"]:"";

	$CmbMes = str_pad($CmbMes,2,"0",STR_PAD_LEFT);
	$TxtFechaIni = $CmbAno."-".$CmbMes."-01";
	$FechaC=$CmbAno.str_pad($CmbMes,2,"0",STR_PAD_LEFT);
	$TxtFechaFin = date("Y-m-d", mktime(1,0,0,$CmbMes+1,1,$CmbAno));
	$TxtFechaFin = date("Y-m-d", mktime(1,0,0,substr($TxtFechaFin,5,2),1-1,substr($TxtFechaFin,0,4)));
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
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{		
		case "I":
			f.BtnImprimir.style.visibility = "hidden";
			f.BtnSalir.style.visibility = "hidden";
			window.print();
			f.BtnImprimir.style.visibility = "visible";
			f.BtnSalir.style.visibility = "visible";
			break;	
		case "S":
			f.action = "age_con_resumen_compra_vendedor_contab.php";
			f.submit();
			break;
	}
}
</script>
<style type="text/css">
body {
	background-image: url();
}
.Estilo1 {color: #0000FF}
</style><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body>
<form name="frmPrincipal" action="" method="post">
  <table width="620" border="0" align="center">
    <tr>
      <td width="294">CODELCO DIVISION VENTANAS V-2 </td>
      <td width="296" align="right">FECHA:&nbsp;<?php echo date("d-m-Y")?></td>
    </tr>
    <tr align="center">
      <td height="30" colspan="2"><strong><u>RESUMEN COMPRA POR VENDEDOR COMERCIAL<br>
        (AJUSTES CONTABLES) 
      </u></strong></td>
    </tr>
    <tr align="center">
      <td colspan="2">MES: <?php echo $CmbMes."-".$CmbAno; ?></td>
    </tr>
    <tr align="center">
      <td colspan="2">&nbsp;        </td>
    </tr>
  </table>
  <br>
  <?php
		$CierreBalance = true;
		$FechaCierreAnexo=$TxtFechaConsulta;
		echo "<table width='1000'  border='1' align='center' cellpadding='3' cellspacing='0'>\n";
		$Consulta = "select distinct cod_recepcion from age_web.lotes where lote between '".$LoteIni."' and '".$LoteFin."'";
		$Consulta.= "and cod_recepcion <>'' ";
		if($CmbRecepcion!='S')
			$Consulta.= " and cod_recepcion = '".$CmbRecepcion."' ";
		if($CmbClaseProd!='S')
			if($CmbClaseProd=='M')
				$Consulta.= " and clase_producto = '".$CmbClaseProd."' ";
			else
				$Consulta.= " and clase_producto <> 'M' ";
		$Consulta.= "order by cod_recepcion ";
		//echo $Consulta;
		$RespAsig = mysqli_query($link, $Consulta);
		$TotalPesoSecTot=0;	$TotalPesoHumTot=0;
		$EsPlamen=false;
		//WSO
		$TotalFinoCuTot=0;$TotalFinoAgTot=0;$TotalFinoAuTot=0;
		$TotalPesoHumAsig=0;$TotalPesoSecAsig=0;$TotalFinoCuAsig=0;$TotalFinoAgAsig=0;$TotalFinoAuAsig=0;
		while ($FilaAsig = mysqli_fetch_array($RespAsig))
		{
			echo "<tr class='ColorTabla01'>\n";
			echo "<td align='left' colspan='11'>".$FilaAsig["cod_recepcion"]."</td>";
			echo "</tr>\n";
			$Consulta = "select distinct case when (t1.valor_subclase1)='METALICO' then 'METALICO' else 'MINERO' end  as valor_subclase1,t1.valor_subclase2 ";
			$Consulta.= "from proyecto_modernizacion.sub_clase t1 inner join age_web.lotes t2 on t1.cod_clase='15001'  and t1.nombre_subclase=t2.clase_producto ";
			$Consulta.= "where t2.lote between '".$LoteIni."' and '".$LoteFin."' and t2.cod_recepcion = '".$FilaAsig["cod_recepcion"]."' ";
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
				echo "<tr bgcolor='#CCCCCC'>\n";
				if($FilaClaseProd["valor_subclase1"]=='METALICO')	
					echo "<td align='left' colspan='3'>".strtoupper($FilaClaseProd["valor_subclase1"])."</td>\n";
				else
					echo "<td align='left' colspan='3'>".strtoupper('MINERO')."</td>\n";
				echo "<td align='center' colspan='4'>LEYES</td>";
				echo "<td align='center'>&nbsp;</td>";										
				echo "<td align='center' colspan='3'>FINOS</td>";										
				echo "</tr>\n";
				$Consulta="select * from proyecto_modernizacion.subproducto t1 inner join age_web.lotes t2 on t1.mostrar_age='S' and t1.cod_producto=t2.cod_producto and ";
				$Consulta.="t1.cod_subproducto=t2.cod_subproducto where  t2.lote between '".$LoteIni."' and '".$LoteFin."' and t2.cod_recepcion = '".$FilaAsig["cod_recepcion"]."' ";
				if($FilaClaseProd["valor_subclase2"]=='METALICO')
					$Consulta.="and t2.clase_producto='M' ";
				else
					$Consulta.="and t2.clase_producto<>'M' ";
				$Consulta.="group by t1.cod_producto,t1.cod_subproducto ";	
				//echo $Consulta."<br>";	
				$RespProd=mysqli_query($link, $Consulta);
				//WSO
				$TotalPesoHumClasProd=0;$TotalPesoSecClasProd=0;$TotalFinoCuClasProd=0;$TotalFinoAgClasProd=0;$TotalFinoAuClasProd=0;
				$TotalPesoHumPrv=0;$TotalPesoSecPrv=0;$TotalFinoCuPrv=0;$TotalFinoAgPrv=0;$TotalFinoAuPrv=0;$TotalFinoCuPrvAj=0;$TotalFinoAgPrvAj=0;$TotalFinoAuPrvAj=0;
				while($FilaProd=mysqli_fetch_array($RespProd))
				{
					echo "<tr class='Detalle01'>\n";
					echo "<td colspan='2'>".$FilaProd["descripcion"]."</td>";
					echo "<td align='center'>P.Hum.</td>\n";
					echo "<td align='center'>Hum(%)</td>\n";
					echo "<td align='center'>Cu(%)</td>\n";
					echo "<td align='center'>Ag(g/T)</td>\n";
					echo "<td align='center'>Au(g/T)</td>\n";
					echo "<td align='center'>P.Seco</td>\n";
					echo "<td align='center'>Cu(Kg)</td>\n";
					echo "<td align='center'>Ag(Gr)</td>\n";
					echo "<td align='center'>Au(Gr)</td>\n";
					echo "</tr>\n";
					//CONSULTA LOS PROVEEDOR DE UNA ASINACION Y UNA CLASE PRODUCTO Y UN PRODUCTO
					$Consulta = "select distinct t1.rut_proveedor, t1.cod_recepcion,t2.nombre_prv as nom_prv  ";
					$Consulta.= " from age_web.lotes t1 inner join sipa_web.proveedores t2 on t1.rut_proveedor=t2.rut_prv";
					$Consulta.= " where t1.lote<>'' and t1.estado_lote <> '6' ";
					$Consulta.= " and t1.lote between '".$LoteIni."' and '".$LoteFin."'";
					$Consulta.= " and t1.cod_recepcion = '".$FilaAsig["cod_recepcion"]."' ";
					if($FilaClaseProd["valor_subclase2"]=='METALICO')
						$Consulta.= " and t1.clase_producto = 'M' ";
					else
						$Consulta.= " and t1.clase_producto <> 'M' ";			
					$Consulta.= " and t1.cod_producto = '".$FilaProd["cod_producto"]."' ";
					$Consulta.= " and t1.cod_subproducto = '".$FilaProd["cod_subproducto"]."' ";
					$Consulta.= " order by t1.rut_proveedor ";
					//echo $Consulta."<br>";
					$SumHumedad=0;
					$RespPrv = mysqli_query($link, $Consulta);
					//WSO
					$TotalPesoHumPrv=0;$TotalPesoSecPrv=0;$TotalFinoCuPrv=0;$TotalFinoAgPrv=0;$TotalFinoAuPrv=0;$TotalFinoCuPrvAj=0;$TotalFinoAgPrvAj=0;$TotalFinoAuPrvAj=0;
					$TotalPesoHumProd=0;$TotalPesoSecProd=0;$TotalFinoCuProd=0;$TotalFinoAgProd=0;$TotalFinoAuProd=0;
					while ($FilaPrv = mysqli_fetch_array($RespPrv))
					{						
						echo "<tr>\n";
						echo "<td align='right'>".$FilaPrv["rut_proveedor"]."</td>";
						echo "<td align='left'>".substr(strtoupper($FilaPrv["nom_prv"]),0,30)."</td>\n";
						$Consulta = "select distinct t1.lote, t2.recargo, t1.rut_proveedor, t2.peso_neto as peso_hum,  ";
						$Consulta.= " lpad(t2.recargo,2,'0') as orden, t2.fecha_recepcion, tipo_remuestreo,canjeable,cod_producto,cod_subproducto,peso_retalla,peso_muestra ";		
						$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
						$Consulta.= " on t1.lote = t2.lote ";			
						$Consulta.= " where t1.cod_producto = '".$FilaProd["cod_producto"]."' ";
						$Consulta.= " and t1.cod_subproducto = '".$FilaProd["cod_subproducto"]."' ";
						//$Consulta.= " and t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."' ";
						$Consulta.= " and ((t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."' ";
						if($CmbAno=='2005')
						{	
							$Consulta.= " AND left(num_lote_remuestreo,3) in ('".substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."',''))";
							$Consulta.= " or (tipo_remuestreo='A' AND left(num_lote_remuestreo,3)='".substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."'))";
						}
						else
						{	
							$Consulta.= " AND left(num_lote_remuestreo,4) in ('".substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."',''))";
							$Consulta.= " or (tipo_remuestreo='A' AND left(num_lote_remuestreo,4)='".substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."'))";	
						}	
						$Consulta.= " and t1.rut_proveedor = '".$FilaPrv["rut_proveedor"]."' ";
						$Consulta.= " and t1.cod_recepcion = '".$FilaAsig["cod_recepcion"]."' ";					
						$Consulta.= " and t1.estado_lote <>'6' group by t1.lote order by t1.lote, orden";
						$RespLote = mysqli_query($link, $Consulta);
						//echo $Consulta."<br>";
						$EsPlamen=false;
						$Ajuste='N';
						while($FilaLote=mysqli_fetch_array($RespLote))
						{
							$PorcMerma=0;$SiMerma=0;$VarMerma=0;$PrvMerma=0;
							$TotalPesoSecLote=0;$TotalPesoHumLote=0;
							$Consulta = "select * from age_web.mermas ";
							$Consulta.= " where cod_producto='".$FilaLote["cod_producto"]."' ";
							$Consulta.= " and cod_subproducto='".$FilaLote["cod_subproducto"]."' ";
							$Consulta.=" and ((year(fecha) < '".$CmbAno."') or (year(fecha) = '".$CmbAno."' and month(fecha) <= '".$CmbMes."'))";
							$Consulta.=" order by cod_producto,cod_subproducto,rut_proveedor";
							$RespMerma=mysqli_query($link, $Consulta);
							while($FilaMerma=mysqli_fetch_array($RespMerma))
							{
								if ($FilaMerma["rut_proveedor"]=="")
								{
									$VarMerma = ($FilaMerma["porc"] * 1);
								}
								$Consulta2 = "select * from age_web.mermas ";
								$Consulta2.= " where cod_producto='".$FilaLote["cod_producto"]."' ";
								$Consulta2.= " and cod_subproducto='".$FilaLote["cod_subproducto"]."' ";
								$Consulta2.=" and rut_proveedor = '".$FilaPrv["rut_proveedor"]."' ";
								$Consulta2.=" and ((year(fecha) < '".$CmbAno."') or (year(fecha) = '".$CmbAno."' and month(fecha) <= '".$CmbMes."'))";
								$RespMer=mysqli_query($link, $Consulta2);
								if($RowM=mysqli_fetch_array($RespMer))
								{
									$SiMerma = 1;
									$PrvMerma= ($RowM["porc"] * 1);
								}
							}
							if ($SiMerma==1)
							{	
								$PorcMerma=str_replace(',','.',$PrvMerma);
							}
							else
							{
								$PorcMerma=str_replace(',','.',$VarMerma);
							}	
							//*********************************************
							$LeyCu=0;$LeyAg=0;$LeyAu=0;$LeyCuOri=0;$LeyAgOri=0;$LeyAuOri=0;$LeyCuAj=0;$LeyAgAj=0;$LeyAuAj=0;						
							$Consulta = "select * from age_web.detalle_lotes where lote='".$FilaLote["lote"]."' order by lote, lpad(recargo,4,'0')";
							$ContRecargos = 1;
							$RespDetLote=mysqli_query($link, $Consulta);
							while ($FilaDetLote = mysqli_fetch_array($RespDetLote))
							{					
								$PorcHum=0;
								$PesoHumedoRec = $FilaDetLote["peso_neto"];
								$Consulta = "select distinct t1.cod_leyes, t1.valor,t1.valor2, t2.cod_unidad, t2.abreviatura as nom_unidad, t2.conversion, t3.abreviatura as nom_ley,t3.nombre_leyes as nombre_ley ";
								$Consulta.= " from age_web.leyes_por_lote t1 left join proyecto_modernizacion.unidades t2 on ";
								$Consulta.= " t1.cod_unidad=t2.cod_unidad left join proyecto_modernizacion.leyes t3 on t1.cod_leyes=t3.cod_leyes";
								$Consulta.= " where t1.lote='".$FilaLote["lote"]."' ";
								if ($ContRecargos==1)
									$Consulta.= " and (t1.recargo='".$FilaDetLote["recargo"]."' or t1.recargo='0')";
								else
									$Consulta.= " and t1.recargo='".$FilaDetLote["recargo"]."'";
								$Consulta.= " and t1.cod_leyes in('01','02','04','05')";	
								$Consulta.= " order by t1.cod_leyes";
								$RespLeyes = mysqli_query($link, $Consulta);
								while ($FilaLeyes = mysqli_fetch_array($RespLeyes))
								{								
									switch ($FilaLeyes["cod_leyes"])
									{
										case "01":
											$PorcHum = $FilaLeyes["valor"]+$PorcMerma;
											break;
										case "02":
											$IncRetalla=0;
											if($FilaLote["peso_retalla"]>0&&$FilaLote["peso_muestra"]>0)
												$IncRetalla = CalcIncRetalla($FilaLote["lote"],"02",$FilaLeyes["valor"],$FilaLote["peso_retalla"],$FilaLote["peso_muestra"],$IncRetalla,$link);
											$LeyCu = $FilaLeyes["valor"]+$IncRetalla;
											$LeyCuOri = $FilaLeyes["valor"]+$IncRetalla;
											break;
										case "04":
											$IncRetalla=0;
											if($FilaLote["peso_retalla"]>0&&$FilaLote["peso_muestra"]>0)
												$IncRetalla = CalcIncRetalla($FilaLote["lote"],"04",$FilaLeyes["valor"],$FilaLote["peso_retalla"],$FilaLote["peso_muestra"],$IncRetalla,$link);
											$LeyAg = $FilaLeyes["valor"]+$IncRetalla;
											$LeyAgOri = $FilaLeyes["valor"]+$IncRetalla;
											break;
										case "05":
											$IncRetalla=0;
											if($FilaLote["peso_retalla"]>0&&$FilaLote["peso_muestra"]>0)
												$IncRetalla = CalcIncRetalla($FilaLote["lote"],"05",$FilaLeyes["valor"],$FilaLote["peso_retalla"],$FilaLote["peso_muestra"],$IncRetalla,$link);
											$LeyAu = $FilaLeyes["valor"]+$IncRetalla;
											$LeyAuOri = $FilaLeyes["valor"]+$IncRetalla;
											break;
									}
								}
								if($PorcHum!=0)
								{
									$PesoSecoRec = $PesoHumedoRec - ($PesoHumedoRec*$PorcHum)/100;
									if($FilaProd["recepcion"]=='PMN')
										$TotalPesoSecLote=$TotalPesoSecLote+$PesoSecoRec;
									else
										$TotalPesoSecLote=$TotalPesoSecLote+round($PesoSecoRec);
								}	
								else
								{
									$PesoSecoRec=$PesoHumedoRec;
									$TotalPesoSecLote=$TotalPesoSecLote+$PesoSecoRec;
								}	
								$TotalPesoHumLote=$TotalPesoHumLote+$PesoHumedoRec;
								$ContRecargos++;
							}
							$DecPHum=0;$DecPSeco=0;$DecLeyes=2;$DecFinos=0;
							$EsPlamen=false;
							if($FilaProd["recepcion"]=='PMN')
							{
								$EsPlamen=true;
								$DecPHum=2;$DecPSeco=3;$DecLeyes=2;$DecFinos=2;
							}
							$PorcHumLote=0;
							if ($TotalPesoHumLote!=0)
								$PorcHumLote = abs(100 - ($TotalPesoSecLote * 100)/$TotalPesoHumLote);
							if($FilaLote["canjeable"]=="S")
							{
								$Ajuste='S';
								$Consulta = "select distinct t1.lote, t2.cod_leyes, (t2.inc_retalla+t2.ley_canje) as valor, t2.pendiente, ";
								$Consulta.= " (t2.inc_retalla+t2.valor1) as valor1";
								$Consulta.= " from age_web.lotes t1 inner join age_web.leyes_por_lote_canje t2 on t1.lote = t2.lote ";	
								$Consulta.= " where (t1.lote='".$FilaLote["lote"]."' and t1.estado_lote <>'6' ";
								$Consulta.= " and t1.fecha_canje<='".$TxtFechaConsulta."') ";
								$Consulta.= " or (t1.lote='".$FilaLote["lote"]."' and t1.fecha_fin_canje between '".$TxtFechaIni."' and '".$TxtFechaFin."') ";	
								$Consulta.= " and t2.cod_leyes in('02','04','05')";	
								$Consulta.= " order by t2.cod_leyes";
								$RespLeyesC = mysqli_query($link, $Consulta);
								while($FilaLeyesC = mysqli_fetch_array($RespLeyesC))
								{
									switch ($FilaLeyesC["cod_leyes"])
									{
										case "02":
											$LeyCu = $FilaLeyesC["valor"];
											$LeyCuAj = $FilaLeyesC["valor"];
											break;
										case "04":
											$LeyAg = $FilaLeyesC["valor"];
											$LeyAgAj = $FilaLeyesC["valor"];
											break;
										case "05":
											$LeyAu = $FilaLeyesC["valor"];
											$LeyAuAj = $FilaLeyesC["valor"];
											break;
									}
								}
							}
							$FinoCu=0;$FinoAg=0;$FinoAu=0;$FinoCuAj=0;$FinoAgAj=0;$FinoAuAj=0;$FinoCuAux=0;
							if($LeyCu!=0)
								$FinoCu=($TotalPesoSecLote * $LeyCuOri)/100;
							if($LeyAg!=0)	
								$FinoAg=($TotalPesoSecLote * $LeyAgOri)/1000;
							if($LeyAu!=0)	
								$FinoAu=($TotalPesoSecLote * $LeyAuOri)/1000;
							if($EsPlamen==true)	
							{
								if($LeyCuAj!=0)
									$FinoCuAj=(($TotalPesoSecLote * $LeyCuAj)/100)-$FinoCu;
								if($LeyAgAj!=0)	
									$FinoAgAj=(($TotalPesoSecLote * $LeyAgAj)/1000)-$FinoAg;
								if($LeyAuAj!=0)	
									$FinoAuAj=(($TotalPesoSecLote * $LeyAuAj)/1000)-$FinoAu;
							}
							else
							{
								if($LeyCuAj!=0)
									$FinoCuAj=(($TotalPesoSecLote * $LeyCuAj)/100)-round($FinoCu);
								if($LeyAgAj!=0)	
									$FinoAgAj=(($TotalPesoSecLote * $LeyAgAj)/1000)-round($FinoAg);
								if($LeyAuAj!=0)	
									$FinoAuAj=(($TotalPesoSecLote * $LeyAuAj)/1000)-round($FinoAu);
							}		
							$TotalPesoHumPrv=$TotalPesoHumPrv+$TotalPesoHumLote;
							$TotalPesoSecPrv=$TotalPesoSecPrv+$TotalPesoSecLote;
							if($EsPlamen==true)
							{
								$TotalFinoCuPrv=$TotalFinoCuPrv+$FinoCu;
								$TotalFinoAgPrv=$TotalFinoAgPrv+$FinoAg;
								$TotalFinoAuPrv=$TotalFinoAuPrv+$FinoAu;
								$TotalFinoCuPrvAj=$TotalFinoCuPrvAj+$FinoCuAj;
								$TotalFinoAgPrvAj=$TotalFinoAgPrvAj+$FinoAgAj;
								$TotalFinoAuPrvAj=$TotalFinoAuPrvAj+$FinoAuAj;
							}
							else
							{
								$TotalFinoCuPrv=$TotalFinoCuPrv+round($FinoCu);
								$TotalFinoAgPrv=$TotalFinoAgPrv+round($FinoAg);
								$TotalFinoAuPrv=$TotalFinoAuPrv+round($FinoAu);
								$TotalFinoCuPrvAj=$TotalFinoCuPrvAj+round($FinoCuAj);
								$TotalFinoAgPrvAj=$TotalFinoAgPrvAj+round($FinoAgAj);
								$TotalFinoAuPrvAj=$TotalFinoAuPrvAj+round($FinoAuAj);
							}	
							$TotalPesoHumLote=0;$TotalPesoSecLote=0;
						}
						//TOTAL PROVEEDOR
						$DecPHum=0;$DecPSeco=0;$DecLeyes=2;$DecFinos=0;
						if($EsPlamen==true)
						{
							$DecPHum=2;$DecPSeco=3;$DecLeyes=2;$DecFinos=2;
						}
						$PorcHumPrv=0;
						if ($TotalPesoHumPrv!='0')
							$PorcHumPrv=100-($TotalPesoSecPrv*100)/$TotalPesoHumPrv;
						$LeyCuPrv=0;$LeyAgPrv=0;$LeyAuPrv=0;	
						if ($TotalPesoSecPrv!='0')
						{	
							$LeyCuPrv=($TotalFinoCuPrv*100)/$TotalPesoSecPrv;
							$LeyAgPrv=($TotalFinoAgPrv*1000)/$TotalPesoSecPrv;
							$LeyAuPrv=($TotalFinoAuPrv*1000)/$TotalPesoSecPrv;
						}	
						echo "<td align='right'>".number_format($TotalPesoHumPrv,$DecPHum,',','.')."</td>";
						echo "<td align='right'>".number_format($PorcHumPrv,2,',','.')."</td>";
						echo "<td align='right'>".number_format($LeyCuPrv,$DecLeyes,',','.')."</td>";
						echo "<td align='right'>".number_format($LeyAgPrv,$DecLeyes,',','.')."</td>";
						echo "<td align='right'>".number_format($LeyAuPrv,$DecLeyes,',','.')."</td>";
						echo "<td align='right'>".number_format($TotalPesoSecPrv,$DecPSeco,',','.')."</td>";
						echo "<td align='right'>".number_format($TotalFinoCuPrv,$DecFinos,',','.')."</td>";
						echo "<td align='right'>".number_format($TotalFinoAgPrv,$DecFinos,',','.')."</td>";
						echo "<td align='right'>".number_format($TotalFinoAuPrv,$DecFinos,',','.')."</td>";
						echo "</tr>\n";
						if($TotalFinoCuPrvAj!=0||$TotalFinoAgPrvAj!=0||$TotalFinoAuPrvAj!=0)
						{
							echo "<tr>\n";
							echo "<td align='right'>&nbsp;</td>";
							echo "<td align='left'>AJUSTES DEL MES POR CANJE</td>\n";
							echo "<td align=\"right\" colspan=\"6\">&nbsp;</td>";
							echo "<td align='right'>".number_format($TotalFinoCuPrvAj,$DecFinos,',','.')."</td>";
							echo "<td align='right'>".number_format($TotalFinoAgPrvAj,$DecFinos,',','.')."</td>";
							echo "<td align='right'>".number_format($TotalFinoAuPrvAj,$DecFinos,',','.')."</td>";
							echo "</tr>\n";
							echo "<tr>\n";
							echo "<td align='right'><strong>***</strong></td>";
							echo "<td align='left'><strong>TOTAL</strong></td>\n";
							echo "<td align=\"right\" colspan=\"6\">&nbsp;</td>";
							echo "<td align='right'>".number_format($TotalFinoCuPrvAj+$TotalFinoCuPrv,$DecFinos,',','.')."</td>";
							echo "<td align='right'>".number_format($TotalFinoAgPrvAj+$TotalFinoAgPrv,$DecFinos,',','.')."</td>";
							echo "<td align='right'>".number_format($TotalFinoAuPrvAj+$TotalFinoAuPrv,$DecFinos,',','.')."</td>";
							if($EsPlamen==true)
							{
								$TotalFinoCuPrv=$TotalFinoCuPrv+$TotalFinoCuPrvAj;
								$TotalFinoAgPrv=$TotalFinoAgPrv+$TotalFinoAgPrvAj;
								$TotalFinoAuPrv=$TotalFinoAuPrv+$TotalFinoAuPrvAj;
							}
							else
							{
								$TotalFinoCuPrv=$TotalFinoCuPrv+round($TotalFinoCuPrvAj);
								$TotalFinoAgPrv=$TotalFinoAgPrv+round($TotalFinoAgPrvAj);
								$TotalFinoAuPrv=$TotalFinoAuPrv+round($TotalFinoAuPrvAj);
							}	
							echo "</tr>\n";
						}
						$TotalPesoHumProd=$TotalPesoHumProd+$TotalPesoHumPrv;
						$TotalPesoSecProd=$TotalPesoSecProd+$TotalPesoSecPrv;
						if($EsPlamen==true)
						{
							$TotalFinoCuProd=$TotalFinoCuProd+$TotalFinoCuPrv;
							$TotalFinoAgProd=$TotalFinoAgProd+$TotalFinoAgPrv;
							$TotalFinoAuProd=$TotalFinoAuProd+$TotalFinoAuPrv;
						}
						else
						{
							$TotalFinoCuProd=$TotalFinoCuProd+round($TotalFinoCuPrv);
							$TotalFinoAgProd=$TotalFinoAgProd+round($TotalFinoAgPrv);
							$TotalFinoAuProd=$TotalFinoAuProd+round($TotalFinoAuPrv);
						}	
						$TotalPesoHumPrv=0;$TotalPesoSecPrv=0;$TotalFinoCuPrv=0;$TotalFinoAgPrv=0;$TotalFinoAuPrv=0;$TotalFinoCuPrvAj=0;$TotalFinoAgPrvAj=0;$TotalFinoAuPrvAj=0;
					}
					$DecPHum=0;$DecPSeco=0;$DecLeyes=2;$DecFinos=0;
					if($EsPlamen==true)
					{
						$DecPHum=2;$DecPSeco=3;$DecLeyes=2;$DecFinos=2;
					}

					if($TotalPesoHumProd>0){
						$PorcHumProd=100-($TotalPesoSecProd*100)/$TotalPesoHumProd;
					}else{
						$PorcHumProd=0;
					}
					if($TotalPesoSecProd>0){
						$LeyCuProd=($TotalFinoCuProd*100)/$TotalPesoSecProd;
						$LeyAgProd=($TotalFinoAgProd*1000)/$TotalPesoSecProd;
						$LeyAuProd=($TotalFinoAuProd*1000)/$TotalPesoSecProd;
					}else{
						$LeyCuProd=0;
						$LeyAgProd=0;
						$LeyAuProd=0;
					}
					echo "<tr class='Detalle01'>\n";
					echo "<td align='left' colspan='2'>TOTAL ".$FilaProd["descripcion"]."</td>";
					echo "<td align='right'>".number_format($TotalPesoHumProd,$DecPSeco,',','.')."</td>";
					echo "<td align='right'>".number_format($PorcHumProd,2,',','.')."</td>";
					echo "<td align='right'>".number_format($LeyCuProd,$DecLeyes,',','.')."</td>";
					echo "<td align='right'>".number_format($LeyAgProd,$DecLeyes,',','.')."</td>";
					echo "<td align='right'>".number_format($LeyAuProd,$DecLeyes,',','.')."</td>";
					echo "<td align='right'>".number_format($TotalPesoSecProd,$DecPSeco,',','.')."</td>";
					echo "<td align='right'>".number_format($TotalFinoCuProd,$DecFinos,',','.')."</td>";
					echo "<td align='right'>".number_format($TotalFinoAgProd,$DecFinos,',','.')."</td>";
					echo "<td align='right'>".number_format($TotalFinoAuProd,$DecFinos,',','.')."</td>";
					echo "</tr>\n";
					$TotalPesoHumClasProd=$TotalPesoHumClasProd+$TotalPesoHumProd;
					$TotalPesoSecClasProd=$TotalPesoSecClasProd+$TotalPesoSecProd;
					if($EsPlamen==true)
					{
						$TotalFinoCuClasProd=$TotalFinoCuClasProd+$TotalFinoCuProd;
						$TotalFinoAgClasProd=$TotalFinoAgClasProd+$TotalFinoAgProd;
						$TotalFinoAuClasProd=$TotalFinoAuClasProd+$TotalFinoAuProd;
					}
					else
					{
						$TotalFinoCuClasProd=$TotalFinoCuClasProd+round($TotalFinoCuProd);
						$TotalFinoAgClasProd=$TotalFinoAgClasProd+round($TotalFinoAgProd);
						$TotalFinoAuClasProd=$TotalFinoAuClasProd+round($TotalFinoAuProd);
					}	
					$TotalPesoHumProd=0;$TotalPesoSecProd=0;$TotalFinoCuProd=0;$TotalFinoAgProd=0;$TotalFinoAuProd=0;
				}	
				$DecPHum=0;$DecPSeco=0;$DecLeyes=2;$DecFinos=0;
				if($EsPlamen==true)
				{
					$DecPHum=2;$DecPSeco=3;$DecLeyes=2;$DecFinos=2;
				}
				if($TotalPesoHumClasProd>0){
					$PorcHumClasProd=100-($TotalPesoSecClasProd*100)/$TotalPesoHumClasProd;	
				}else{
					$PorcHumClasProd=0;
				}
				if($TotalPesoSecClasProd>0){
					$LeyCuClasProd=($TotalFinoCuClasProd*100)/$TotalPesoSecClasProd;
					$LeyAgClasProd=($TotalFinoAgClasProd*1000)/$TotalPesoSecClasProd;
					$LeyAuClasProd=($TotalFinoAuClasProd*1000)/$TotalPesoSecClasProd;
				}else{
					$LeyCuClasProd=0;
					$LeyAgClasProd=0;
					$LeyAuClasProd=0;
				}
				echo "<tr bgcolor='#CCCCCC'>\n";
				if($FilaClaseProd["valor_subclase2"]=='METALICO')	
					echo "<td align='left' colspan='2'>TOTAL ".$FilaClaseProd["valor_subclase1"]."</td>";
				else
					echo "<td align='left' colspan='2'>TOTAL MINERO</td>";
				echo "<td align='right'>".number_format($TotalPesoHumClasProd,$DecPHum,',','.')."</td>";
				echo "<td align='right'>".number_format($PorcHumClasProd,2,',','.')."</td>";
				echo "<td align='right'>".number_format($LeyCuClasProd,$DecLeyes,',','.')."</td>";
				echo "<td align='right'>".number_format($LeyAgClasProd,$DecLeyes,',','.')."</td>";
				echo "<td align='right'>".number_format($LeyAuClasProd,$DecLeyes,',','.')."</td>";
				echo "<td align='right'>".number_format($TotalPesoSecClasProd,$DecPSeco,',','.')."</td>";
				echo "<td align='right'>".number_format($TotalFinoCuClasProd,$DecFinos,',','.')."</td>";
				echo "<td align='right'>".number_format($TotalFinoAgClasProd,$DecFinos,',','.')."</td>";
				echo "<td align='right'>".number_format($TotalFinoAuClasProd,$DecFinos,',','.')."</td>";
				echo "</tr>\n";
				$TotalPesoHumAsig=$TotalPesoHumAsig+$TotalPesoHumClasProd;
				$TotalPesoSecAsig=$TotalPesoSecAsig+$TotalPesoSecClasProd;
				if($EsPlamen==true)
				{
					$TotalFinoCuAsig=$TotalFinoCuAsig+$TotalFinoCuClasProd;
					$TotalFinoAgAsig=$TotalFinoAgAsig+$TotalFinoAgClasProd;
					$TotalFinoAuAsig=$TotalFinoAuAsig+$TotalFinoAuClasProd;
				}
				else
				{
					$TotalFinoCuAsig=$TotalFinoCuAsig+round($TotalFinoCuClasProd);
					$TotalFinoAgAsig=$TotalFinoAgAsig+round($TotalFinoAgClasProd);
					$TotalFinoAuAsig=$TotalFinoAuAsig+round($TotalFinoAuClasProd);
				}	
				$TotalPesoHumClasProd=0;$TotalPesoSecClasProd=0;$TotalFinoCuClasProd=0;$TotalFinoAgClasProd=0;$TotalFinoAuClasProd=0;
				echo "</tr>\n";
			}
			$DecPHum=0;$DecPSeco=0;$DecLeyes=2;$DecFinos=0;
			if($EsPlamen==true)
			{
				$DecPHum=2;$DecPSeco=3;$DecLeyes=2;$DecFinos=2;
			}
			if($TotalPesoHumAsig>0){
				$PorcHumAsig=100-($TotalPesoSecAsig*100)/$TotalPesoHumAsig;
			}else{
				$PorcHumAsig=0;
			}
			if($TotalPesoSecAsig>0){
				$LeyCuAsig=($TotalFinoCuAsig*100)/$TotalPesoSecAsig;
				$LeyAgAsig=($TotalFinoAgAsig*1000)/$TotalPesoSecAsig;
				$LeyAuAsig=($TotalFinoAuAsig*1000)/$TotalPesoSecAsig;
			}else{
				$LeyCuAsig=0;
				$LeyAgAsig=0;
				$LeyAuAsig=0;	
			}
			
			echo "<tr class='ColorTabla01'>\n";
			echo "<td align='left' colspan='2'>TOTAL ".$FilaAsig["cod_recepcion"]."</td>";
			echo "<td align='right'>".number_format($TotalPesoHumAsig,$DecPHum,',','.')."</td>";
			echo "<td align='right'>".number_format($PorcHumAsig,2,',','.')."</td>";
			echo "<td align='right'>".number_format($LeyCuAsig,$DecLeyes,',','.')."</td>";
			echo "<td align='right'>".number_format($LeyAgAsig,$DecLeyes,',','.')."</td>";
			echo "<td align='right'>".number_format($LeyAuAsig,$DecLeyes,',','.')."</td>";
			echo "<td align='right'>".number_format($TotalPesoSecAsig,$DecPSeco,',','.')."</td>";
			echo "<td align='right'>".number_format($TotalFinoCuAsig,$DecFinos,',','.')."</td>";
			echo "<td align='right'>".number_format($TotalFinoAgAsig,$DecFinos,',','.')."</td>";
			echo "<td align='right'>".number_format($TotalFinoAuAsig,$DecFinos,',','.')."</td>";
			echo "</tr>\n";
			$TotalPesoHumTot=$TotalPesoHumTot+$TotalPesoHumAsig;
			$TotalPesoSecTot=$TotalPesoSecTot+$TotalPesoSecAsig;
			if($EsPlamen==true)
			{
				$TotalFinoCuTot=$TotalFinoCuTot+$TotalFinoCuAsig;
				$TotalFinoAgTot=$TotalFinoAgTot+$TotalFinoAgAsig;
				$TotalFinoAuTot=$TotalFinoAuTot+$TotalFinoAuAsig;
			}
			else
			{
				$TotalFinoCuTot=$TotalFinoCuTot+round($TotalFinoCuAsig);
				$TotalFinoAgTot=$TotalFinoAgTot+round($TotalFinoAgAsig);
				$TotalFinoAuTot=$TotalFinoAuTot+round($TotalFinoAuAsig);
			}	
			$TotalPesoHumAsig=0;$TotalPesoSecAsig=0;$TotalFinoCuAsig=0;$TotalFinoAgAsig=0;$TotalFinoAuAsig=0;
			echo "</tr>\n";
		}
		$DecPHum=0;$DecPSeco=0;$DecLeyes=2;$DecFinos=0;
		if($EsPlamen==true)
		{
			$DecPHum=2;$DecPSeco=3;$DecLeyes=2;$DecFinos=2;
		}
		if($TotalPesoHumTot>0){
			$PorcHumTot=100-($TotalPesoSecTot*100)/$TotalPesoHumTot;
		}else{
			$PorcHumTot=0;
		}
		if($TotalPesoSecTot>0){
			$LeyCuTot=($TotalFinoCuTot*100)/$TotalPesoSecTot;
			$LeyAgTot=($TotalFinoAgTot*1000)/$TotalPesoSecTot;
			$LeyAuTot=($TotalFinoAuTot*1000)/$TotalPesoSecTot;
		}else{
			$LeyCuTot=0;
			$LeyAgTot=0;
			$LeyAuTot=0;
		}

		echo "<tr class='Detalle03'>\n";
		echo "<td align='left' colspan='2'>TOTAL</td>";
		echo "<td align='right'>".number_format($TotalPesoHumTot,$DecPHum,',','.')."</td>";
		echo "<td align='right'>".number_format($PorcHumTot,2,',','.')."</td>";
		echo "<td align='right'>".number_format($LeyCuTot,$DecLeyes,',','.')."</td>";
		echo "<td align='right'>".number_format($LeyAgTot,$DecLeyes,',','.')."</td>";
		echo "<td align='right'>".number_format($LeyAuTot,$DecLeyes,',','.')."</td>";
		echo "<td align='right'>".number_format($TotalPesoSecTot,$DecPSeco,',','.')."</td>";
		echo "<td align='right'>".number_format($TotalFinoCuTot,$DecFinos,',','.')."</td>";
		echo "<td align='right'>".number_format($TotalFinoAgTot,$DecFinos,',','.')."</td>";
		echo "<td align='right'>".number_format($TotalFinoAuTot,$DecFinos,',','.')."</td>";
		echo "</tr>\n";
		echo "</table>\n";
		

 ?>  
</form>
</body>
</html>