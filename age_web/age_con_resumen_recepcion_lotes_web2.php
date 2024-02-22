<?php	//$link = mysql_connect('vevmmysqlp01','adm_web','codweb2015');
	//mysql_select_db("proyecto_modernizacion", $link);

 	include("../principal/conectar_principal.php");
include("../age_web/age_funciones.php");
	$CmbMes = str_pad($CmbMes,2,"0",STR_PAD_LEFT);
	$FechaMer=$CmbAno.str_pad($CmbMes,2,"0",STR_PAD_LEFT);
	$TxtFechaIni = $CmbAno."-".$CmbMes."-01";
	$TxtFechaFin = date("Y-m-d", mktime(0,0,0,$CmbMes+1,1,$CmbAno));
	$TxtFechaFin = date("Y-m-d", mktime(0,0,0,substr($TxtFechaFin,5,2),1-1,substr($TxtFechaFin,0,4)));
?>
<html>
<head>
<title>AGE-Resumen Recepcion Lotes Comercial Web</title>
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
			//f.action = "age_con_resumen_recepcion_lotes_comercial.php";
			f.action = "age_con_resumen_recepcion_lotes.php";
			f.submit();
			break;
	}
}
</script>
</head>
<body>
<form name="frmPrincipal" action="" method="post">
  <table width="620" border="0" align="center">
    <tr>
      <td width="294">CODELCO CHILE<br>
        DIVISION VENTANAS  V-20161122.1     <br> </td>
      <td width="296" align="right">FECHA:&nbsp;<?php echo date("d-m-Y")?></td>
    </tr>
    <tr align="center">
      <td height="30" colspan="2"><strong><u>INFORME RECEPCION POR LOTES OPERACIONAL </u></strong></td>
    </tr>
    <tr align="center">
      <td colspan="2">MES: <?php echo $CmbMes."-".$CmbAno; ?></td>
    </tr>
    <tr align="center">
      <td colspan="2"><input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70px " onClick="Proceso('I')">
      <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
    </tr>
  </table>
  <br>
	<?php
	$ColSpan=11;
	echo "<table width=\"600\"  border=\"1\" align=\"center\" cellpadding=\"3\" cellspacing=\"0\">\n";
	$Consulta = "select distinct t1.cod_producto, t1.cod_subproducto, lpad(t1.cod_subproducto,4,'0') as orden ,recepcion ";
	$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
	$Consulta.= " on t1.lote = t2.lote inner join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto ";
	$Consulta.= " and t1.cod_subproducto=t3.cod_subproducto ";
	$Consulta.= " where t1.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."' ";
	if ($CmbRecepcion!='S')
		$Consulta.= " and t1.cod_recepcion= '".$CmbRecepcion."' ";
	if ($CmbSubProducto != "S")
	{
		$Consulta.= " and t1.cod_producto = '1' ";
		$Consulta.= " and t1.cod_subproducto = '".$CmbSubProducto."' ";
	}
	if ($CmbProveedor != "S")
		$Consulta.= " and t1.rut_proveedor = '".$CmbProveedor."' ";
	$Consulta.= " order by t1.cod_producto, orden ";
	//echo $Consulta."<br>";
	$Resp01 = mysqli_query($link, $Consulta);
	while ($Fila01 = mysqli_fetch_array($Resp01))	
	{			
		echo "<tr class=\"ColorTabla01\">\n";			
		$Consulta = "select * from proyecto_modernizacion.subproducto ";
		$Consulta.= "where cod_producto = '".$Fila01["cod_producto"]."' and cod_subproducto='".$Fila01["cod_subproducto"]."'";		
		$RespAux2 = mysqli_query($link, $Consulta);
		if ($FilaAux2 = mysqli_fetch_array($RespAux2))
		{
			$NomSubProd = $FilaAux2["descripcion"];
		}
		else
			$NomSubProd = "SIN IDENTIFICACION";		
		echo "<td align=\"left\" colspan=\"".$ColSpan."\">".str_pad($Fila01["cod_subproducto"],2,'0',STR_PAD_LEFT)." - ".$NomSubProd."</td>";					
		echo "</tr>\n";
		//TITULO						
		echo "<tr class=\"ColorTabla02\">\n";		
		echo "<td align=\"center\" rowspan=\"2\">Lote</td>\n";
		echo "<td align=\"center\" rowspan=\"2\">F.Cierre</td>\n";		
		echo "<td align=\"center\" rowspan=\"2\">P.Hum.<br>(Kg)</td>\n";
		echo "<td align=\"center\" colspan=\"4\">Leyes</td>\n";		
		echo "<td align=\"center\" colspan=\"4\">Finos</td>\n";
		echo "</tr>";
		echo "<tr class=\"ColorTabla02\">\n";
		if ($OptLeyes=="S")
		{
			echo "<td align=\"center\">Hum<br>(%)</td>\n";
			echo "<td align=\"center\">Cu<br>(%)</td>\n";
			echo "<td align=\"center\">Ag<br>(g/T)</td>\n";
			echo "<td align=\"center\">Au<br>(g/T)</td>\n";
		}
		if ($OptFinos=="S")
		{
			echo "<td align=\"center\">P.Seco<br>(Kg)</td>\n";
			echo "<td align=\"center\">Cu<br>(Kg)</td>\n";
			echo "<td align=\"center\">Ag<br>(Gr)</td>\n";
			echo "<td align=\"center\">Au<br>(Gr)</td>\n";
		}	
		echo "</tr>\n";
		//CONSULTA LOS TIPOS DE RECEPCION
		$Consulta = "select distinct t1.cod_recepcion, t3.nombre_subclase as desc_a";
		$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
		$Consulta.= " on t1.lote = t2.lote left join proyecto_modernizacion.sub_clase t3 on t3.cod_clase ='3104' and t1.cod_recepcion=t3.nombre_subclase ";
		$Consulta.= " where t1.lote<>'' ";
		$Consulta.= " and t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."'";			
		$Consulta.= " and t1.cod_producto = '".$Fila01["cod_producto"]."' ";
		$Consulta.= " and t1.cod_subproducto = '".$Fila01["cod_subproducto"]."' ";
		if ($CmbRecepcion!='S')
			$Consulta.= " and t1.cod_recepcion= '".$CmbRecepcion."' ";
		if ($CmbProveedor != "S")
			$Consulta.= " and t1.rut_proveedor = '".$CmbProveedor."' ";
		$Consulta.= " order by t1.cod_recepcion ";
		//echo $Consulta."<br>";
		$RutPrv2='';
		$RespTipoRecep = mysqli_query($link, $Consulta);
		while ($FilaTipoRecep = mysqli_fetch_array($RespTipoRecep))
		{					
			//TITULO COD RECEPCION
			echo "<tr bgcolor=\"#CCCCCC\">\n";	
			if ($FilaTipoRecep["desc_a"] == "" || is_null($FilaTipoRecep["desc_a"]))
				echo "<td align=\"left\" colspan=\"".$ColSpan."\">&nbsp;</td>\n";				
			else
				echo "<td align=\"left\" colspan=\"".$ColSpan."\">".strtoupper($FilaTipoRecep["desc_a"])."</td>\n";		
			echo "</tr>\n";
			echo "<tr><td colspan='$ColSpan'>&nbsp;</td></tr>";
			//CONSULTA LOS PROVEEDOR DE UN PRODUCTO Y UN TIPO DE RECEPCION
			$Consulta = "select distinct t1.rut_proveedor, t1.cod_recepcion  ";
			$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
			$Consulta.= " on t1.lote = t2.lote ";
			$Consulta.= " where t1.lote<>'' ";
			$Consulta.= " and t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."'";			
			$Consulta.= " and t1.cod_producto = '".$Fila01["cod_producto"]."' ";
			$Consulta.= " and t1.cod_subproducto = '".$Fila01["cod_subproducto"]."' ";
			if ($CmbProveedor != "S")
				$Consulta.= " and t1.rut_proveedor = '".$CmbProveedor."' ";
			$Consulta.= " and t1.cod_recepcion = '".$FilaTipoRecep["cod_recepcion"]."' ";
			$Consulta.= " order by t1.cod_recepcion, t1.rut_proveedor ";
			//echo $Consulta."<br>";
			$RutPrv='';
			$RespAux = mysqli_query($link, $Consulta);
			while ($FilaAux = mysqli_fetch_array($RespAux))
			{		
				$Datos = explode("-",$FilaAux["rut_proveedor"]);
				$RutAux = $FilaAux["rut_proveedor"];
				$NomProveedor = "";
				$Consulta = "select * ";
				$Consulta.= " from sipa_web.proveedores ";
				$Consulta.= " where rut_prv = '".$RutAux."'";
				$RespProv = mysqli_query($link, $Consulta);	
				//echo $Consulta."<br>";
				while ($FilaProv = mysqli_fetch_array($RespProv))
				{
					$NomProveedor = $FilaProv["nombre_prv"];
				}				
				echo "<tr class=\"Detalle01\">\n";
				echo "<td align=\"left\" colspan=\"".$ColSpan."\">".$FilaAux["rut_proveedor"]."&nbsp;&nbsp;".substr(strtoupper($NomProveedor),0,30)."</td>\n";
				echo "</tr>\n";				
				$Consulta = "select distinct t1.lote, t2.recargo, t1.rut_proveedor, t2.peso_neto as peso_hum,  ";
				$Consulta.= " lpad(t2.recargo,2,'0') as orden, t2.fecha_recepcion, tipo_remuestreo,canjeable,cod_producto,cod_subproducto,peso_retalla,peso_muestra ";		
				$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
				$Consulta.= " on t1.lote = t2.lote ";			
				$Consulta.= " where t1.cod_producto = '".$Fila01["cod_producto"]."' ";
				$Consulta.= " and t1.cod_subproducto = '".$Fila01["cod_subproducto"]."' ";
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
				$Consulta.= " and t1.rut_proveedor = '".$FilaAux["rut_proveedor"]."' ";
				$Consulta.= " and t1.cod_recepcion = '".$FilaAux["cod_recepcion"]."' ";					
				$Consulta.= " and t1.estado_lote <>'6' group by t1.lote order by t1.lote, orden";
				$RespLote = mysqli_query($link, $Consulta);
				//echo $Consulta."<br>";
				$EsPlamen=false;
				while($FilaLote=mysqli_fetch_array($RespLote))
				{
					echo "<tr>";
					echo "<td align=\"center\">".$FilaLote[lote]."</td>";
					echo "<td align=\"center\">".substr($FilaLote[fecha_recepcion],8,2)."/".substr($FilaLote[fecha_recepcion],5,2)."/".substr($FilaLote[fecha_recepcion],0,4)."</td>";
					$TotalPesoSecLote=0;$TotalPesoHumLote=0;
					$Anito = substr($TxtFechaIni,0,4);
					$Mesi = substr($TxtFechaIni,5,2);
					$PorcMerma = 0;$SiMerma=0;$VarMerma=0;$PrvMerma=0;
					$Consulta = "select *  from age_web.mermas ";
					$Consulta.= " where cod_producto='".$FilaLote["cod_producto"]."' ";
					$Consulta.= " and cod_subproducto='".$FilaLote["cod_subproducto"]."' ";
					$Consulta.=" and ((year(fecha) < '".$Anito."') or (year(fecha) = '".$Anito."' and month(fecha) <= '".$Mesi."'))";
					$Consulta.=" order by cod_producto,cod_subproducto,rut_proveedor";
					$RespMerma=mysqli_query($link, $Consulta);
					//echo $Consulta."</br>";
					while ($FilaMerma=mysqli_fetch_array($RespMerma))
					{
						if($FilaMerma["rut_proveedor"]=="")
						{
							$VarMerma = ($FilaMerma[porc] * 1);
						}
						$Consulta2 = "select *  from age_web.mermas ";
						$Consulta2.= " where cod_producto='".$FilaLote["cod_producto"]."' ";
						$Consulta2.= " and cod_subproducto='".$FilaLote["cod_subproducto"]."' ";
						$Consulta2.=" and rut_proveedor = '".$FilaAux["rut_proveedor"]."' ";
						$Consulta2.=" and ((year(fecha) < '".$Anito."') or (year(fecha) = '".$Anito."' and month(fecha) <= '".$Mesi."'))";
						$Consulta2.=" order by cod_producto,cod_subproducto,rut_proveedor";
						$RespM=mysqli_query($link, $Consulta2);
						//echo "jjj".$Consulta."</br>";
						if($FilaM=mysqli_fetch_array($RespM))
						{
							$SiMerma = 1;
							$PrvMerma = ($FilaM[porc] * 1);
						}
					}
					if ($SiMerma==1)
						$PorcMerma=str_replace(',','.',$PrvMerma);
						else
						$PorcMerma=str_replace(',','.',$VarMerma);
						
					/*$RespMerma=mysqli_query($link, $Consulta);
					$FilaMerma=mysqli_fetch_array($RespMerma);
					$PorcMerma=str_replace(',','.',$FilaMerma[merma]);*/
					$LeyCu=0;$LeyAg=0;$LeyAu=0;					
					$Consulta = "select * from age_web.detalle_lotes where lote='".$FilaLote[lote]."' order by lote, lpad(recargo,4,'0')";
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
						$Consulta.= " and t1.cod_leyes in ('01','02','04','05')";
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
									if($FilaLote["peso_retalla"]>0&&$FilaLote[peso_muestra]>0)
										CalcIncRetalla($FilaLote["lote"],"02",$FilaLeyes["valor"],$FilaLote["peso_retalla"],$FilaLote[peso_muestra],&$IncRetalla);
									$LeyCu = $FilaLeyes["valor"]+$IncRetalla;
									break;
								case "04":
									$IncRetalla=0;
									if($FilaLote["peso_retalla"]>0&&$FilaLote[peso_muestra]>0)
										CalcIncRetalla($FilaLote["lote"],"04",$FilaLeyes["valor"],$FilaLote["peso_retalla"],$FilaLote[peso_muestra],&$IncRetalla);
									$LeyAg = $FilaLeyes["valor"]+$IncRetalla;
									break;
								case "05":
									$IncRetalla=0;
									if($FilaLote["peso_retalla"]>0&&$FilaLote[peso_muestra]>0)
										CalcIncRetalla($FilaLote["lote"],"05",$FilaLeyes["valor"],$FilaLote["peso_retalla"],$FilaLote[peso_muestra],&$IncRetalla);
									$LeyAu = $FilaLeyes["valor"]+$IncRetalla;
									break;
								default:
									$ArrLeyesAux[$FilaLeyes["cod_leyes"]][6]=$FilaLeyes["valor"];
									break;	
							}
						}
						if($PorcHum!=0)
						{
							$PesoSecoRec = $PesoHumedoRec - ($PesoHumedoRec*$PorcHum)/100;
							if($Fila01[recepcion]=='PMN')
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
					if($Fila01[recepcion]=='PMN')
					{
						$EsPlamen=true;
						$DecPHum=2;$DecPSeco=3;$DecLeyes=2;$DecFinos=2;
					}
					$PorcHumLote=0;
					if ($TotalPesoHumLote!=0)
						$PorcHumLote = abs(100 - ($TotalPesoSecLote * 100)/$TotalPesoHumLote);
					$FinoCu=0;$FinoAg=0;$FinoAu=0;
					if($LeyCu!=0)
						$FinoCu=($TotalPesoSecLote * $LeyCu)/100;
					if($LeyAg!=0)	
						$FinoAg=($TotalPesoSecLote * $LeyAg)/1000;
					if($LeyAu!=0)	
						$FinoAu=($TotalPesoSecLote * $LeyAu)/1000;
					echo "<td align='right'>".number_format($TotalPesoHumLote,$DecPHum,',','.')."</td>";
					echo "<td align='right'>".number_format($PorcHumLote,2,',','.')."</td>";
					echo "<td align='right'>".number_format($LeyCu,$DecLeyes,',','.')."</td>";
					echo "<td align='right'>".number_format($LeyAg,$DecLeyes,',','.')."</td>";
					echo "<td align='right'>".number_format($LeyAu,$DecLeyes,',','.')."</td>";
					echo "<td align='right'>".number_format($TotalPesoSecLote,$DecPSeco,',','.')."</td>";
					echo "<td align='right'>".number_format($FinoCu,$DecFinos,',','.')."</td>";
					echo "<td align='right'>".number_format($FinoAg,$DecFinos,',','.')."</td>";
					echo "<td align='right'>".number_format($FinoAu,$DecFinos,',','.')."</td>";
					echo "</tr>";
					$TotalPesoHumPrv=$TotalPesoHumPrv+$TotalPesoHumLote;
					$TotalPesoSecPrv=$TotalPesoSecPrv+$TotalPesoSecLote;
					if($EsPlamen==true)
					{
						$TotalFinoCuPrv=$TotalFinoCuPrv+$FinoCu;
						$TotalFinoAgPrv=$TotalFinoAgPrv+$FinoAg;
						$TotalFinoAuPrv=$TotalFinoAuPrv+$FinoAu;
					}
					else
					{
						$TotalFinoCuPrv=$TotalFinoCuPrv+round($FinoCu);
						$TotalFinoAgPrv=$TotalFinoAgPrv+round($FinoAg);
						$TotalFinoAuPrv=$TotalFinoAuPrv+round($FinoAu);
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
				echo "<tr class=\"Detalle01\">\n";
				echo "<td align=\"left\" colspan=\"2\">TOTAL ".$FilaAux["rut_proveedor"]."</td>";
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
				echo "<tr><td colspan='$ColSpan'>&nbsp;</td></tr>";
				$TotalPesoHumAsig=$TotalPesoHumAsig+$TotalPesoHumPrv;
				$TotalPesoSecAsig=$TotalPesoSecAsig+$TotalPesoSecPrv;
				if($EsPlamen==true)
				{
					$TotalFinoCuAsig=$TotalFinoCuAsig+$TotalFinoCuPrv;
					$TotalFinoAgAsig=$TotalFinoAgAsig+$TotalFinoAgPrv;
					$TotalFinoAuAsig=$TotalFinoAuAsig+$TotalFinoAuPrv;
				}
				else
				{
					$TotalFinoCuAsig=$TotalFinoCuAsig+round($TotalFinoCuPrv);
					$TotalFinoAgAsig=$TotalFinoAgAsig+round($TotalFinoAgPrv);
					$TotalFinoAuAsig=$TotalFinoAuAsig+round($TotalFinoAuPrv);
				}
				$TotalPesoHumPrv=0;$TotalPesoSecPrv=0;$TotalFinoCuPrv=0;$TotalFinoAgPrv=0;$TotalFinoAuPrv=0;
			}
			//TOTAL TIPO RECEPCION
			$DecPHum=0;$DecPSeco=0;$DecLeyes=2;$DecFinos=0;
			if($EsPlamen==true)
			{
				$DecPHum=2;$DecPSeco=3;$DecLeyes=2;$DecFinos=2;
			}
			$PorcHumAsig=0;
			if($TotalPesoHumAsig!=0)
				$PorcHumAsig=100-($TotalPesoSecAsig*100)/$TotalPesoHumAsig;
			
			$LeyCuAsig=0;$LeyAgAsig=0;$LeyAuAsig=0;
			if($TotalPesoSecAsig!=0)
			{
				$LeyCuAsig=($TotalFinoCuAsig*100)/$TotalPesoSecAsig;
				$LeyAgAsig=($TotalFinoAgAsig*1000)/$TotalPesoSecAsig;
				$LeyAuAsig=($TotalFinoAuAsig*1000)/$TotalPesoSecAsig;
			}
			echo "<tr bgcolor=\"#CCCCCC\">";
			echo "<td align=\"left\" colspan=\"2\">TOTAL&nbsp;".strtoupper($FilaTipoRecep["desc_a"])."</td>\n";
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
			$TotalPesoHumProd=$TotalPesoHumProd+$TotalPesoHumAsig;
			$TotalPesoSecProd=$TotalPesoSecProd+$TotalPesoSecAsig;
			if($EsPlamen==true)
			{
				$TotalFinoCuProd=$TotalFinoCuProd+$TotalFinoCuAsig;
				$TotalFinoAgProd=$TotalFinoAgProd+$TotalFinoAgAsig;
				$TotalFinoAuProd=$TotalFinoAuProd+$TotalFinoAuAsig;
			}	
			else
			{
				$TotalFinoCuProd=$TotalFinoCuProd+round($TotalFinoCuAsig);
				$TotalFinoAgProd=$TotalFinoAgProd+round($TotalFinoAgAsig);
				$TotalFinoAuProd=$TotalFinoAuProd+round($TotalFinoAuAsig);
			}
			$TotalPesoHumAsig=0;$TotalPesoSecAsig=0;$TotalFinoCuAsig=0;$TotalFinoAgAsig=0;$TotalFinoAuAsig=0;
		}//FIN TIPO RECEPCION
		//TOTAL PRODUCTO
		$DecPHum=0;$DecPSeco=0;$DecLeyes=2;$DecFinos=0;
		if($EsPlamen==true)
		{
			$DecPHum=2;$DecPSeco=3;$DecLeyes=2;$DecFinos=2;
		}
			$PorcHumProd=0;
		if($TotalPesoHumAsig!=0)
			$PorcHumProd=100-($TotalPesoSecProd*100)/$TotalPesoHumProd;
		
		$LeyCuProd=0;$LeyAgProd=0;$LeyAuProd=0;
		if($TotalPesoSecProd!=0)
			{
				$LeyCuProd=($TotalFinoCuProd*100)/$TotalPesoSecProd;
				$LeyAgProd=($TotalFinoAgProd*1000)/$TotalPesoSecProd;
				$LeyAuProd=($TotalFinoAuProd*1000)/$TotalPesoSecProd;
			}
		echo "<tr class=\"ColorTabla02\" bgcolor=\"#CCCCCC\">";
		echo "<td align=\"left\" colspan=\"2\">TOTAL: ".str_pad($Fila01["cod_subproducto"],2,'0',STR_PAD_LEFT)." ".strtoupper($NomSubProd)."</td>\n";
		echo "<td align='right'>".number_format($TotalPesoHumProd,$DecPHum,',','.')."</td>";
		echo "<td align='right'>".number_format($PorcHumProd,2,',','.')."</td>";
		echo "<td align='right'>".number_format($LeyCuProd,$DecLeyes,',','.')."</td>";
		echo "<td align='right'>".number_format($LeyAgProd,$DecLeyes,',','.')."</td>";
		echo "<td align='right'>".number_format($LeyAuProd,$DecLeyes,',','.')."</td>";
		echo "<td align='right'>".number_format($TotalPesoSecProd,$DecPSeco,',','.')."</td>";
		echo "<td align='right'>".number_format($TotalFinoCuProd,$DecFinos,',','.')."</td>";
		echo "<td align='right'>".number_format($TotalFinoAgProd,$DecFinos,',','.')."</td>";
		echo "<td align='right'>".number_format($TotalFinoAuProd,$DecFinos,',','.')."</td>";
		echo "</tr>\n";
		$TotalPesoHumTot=$TotalPesoHumTot+$TotalPesoHumProd;
		$TotalPesoSecTot=$TotalPesoSecTot+$TotalPesoSecProd;
		if($EsPlamen==true)
		{
			$TotalFinoCuTot=$TotalFinoCuTot+$TotalFinoCuProd;
			$TotalFinoAgTot=$TotalFinoAgTot+$TotalFinoAgProd;
			$TotalFinoAuTot=$TotalFinoAuTot+$TotalFinoAuProd;
		}
		else
		{
			$TotalFinoCuTot=$TotalFinoCuTot+round($TotalFinoCuProd);
			$TotalFinoAgTot=$TotalFinoAgTot+round($TotalFinoAgProd);
			$TotalFinoAuTot=$TotalFinoAuTot+round($TotalFinoAuProd);
		}	
		$TotalPesoHumProd=0;$TotalPesoSecProd=0;$TotalFinoCuProd=0;$TotalFinoAgProd=0;$TotalFinoAuProd=0;
}	
	//TOTAL
	$DecPHum=0;$DecPSeco=0;$DecLeyes=2;$DecFinos=0;
	$PorcHumTot=100-($TotalPesoSecTot*100)/$TotalPesoHumTot;
	$LeyCuTot=($TotalFinoCuTot*100)/$TotalPesoSecTot;
	$LeyAgTot=($TotalFinoAgTot*1000)/$TotalPesoSecTot;
	$LeyAuTot=($TotalFinoAuTot*1000)/$TotalPesoSecTot;
	echo "<tr class=\"ColorTabla02\" bgcolor=\"#CCCCCC\">";
	echo "<td align=\"left\" colspan=\"2\">TOTAL:</td>\n";
	echo "<td align='right'>".number_format($TotalPesoHumTot,0,',','.')."</td>";
	echo "<td align='right'>".number_format($PorcHumTot,2,',','.')."</td>";
	echo "<td align='right'>".number_format($LeyCuTot,$DecLeyes,',','.')."</td>";
	echo "<td align='right'>".number_format($LeyAgTot,$DecLeyes,',','.')."</td>";
	echo "<td align='right'>".number_format($LeyAuTot,$DecLeyes,',','.')."</td>";
	echo "<td align='right'>".number_format($TotalPesoSecTot,0,',','.')."</td>";
	echo "<td align='right'>".number_format($TotalFinoCuTot,$DecFinos,',','.')."</td>";
	echo "<td align='right'>".number_format($TotalFinoAgTot,$DecFinos,',','.')."</td>";
	echo "<td align='right'>".number_format($TotalFinoAuTot,$DecFinos,',','.')."</td>";
	echo "</tr>\n";
echo "</table>\n";
//FUNCIONES
function CalcIncRetalla($Lote,$CodLey,$Valor,$PesoRetalla,$PesoMuestra,$IncRetalla)
{	
	$Consulta = "select distinct t1.cod_leyes, t1.valor, t2.abreviatura as nom_unidad, t2.conversion";
	$Consulta.= " from age_web.leyes_por_lote t1 left join proyecto_modernizacion.unidades t2 on ";
	$Consulta.= " t1.cod_unidad=t2.cod_unidad ";
	$Consulta.= " where t1.lote='".$Lote."' ";
	$Consulta.= " and t1.recargo='R' and t1.cod_leyes='".$CodLey."'";	
	//echo $Consulta."<br>";
	$RespLeyes = mysqli_query($link, $Consulta);
	$IncRetalla=0;
	if($FilaLeyes = mysqli_fetch_array($RespLeyes))
	{
		if($FilaLeyes[valor]>0)
			$IncRetalla=($FilaLeyes[valor] - $Valor) * ($PesoRetalla/$PesoMuestra);  //VALOR
	}	
}

mysql_close($link);
	
?>  

</form>
</body>
</html>