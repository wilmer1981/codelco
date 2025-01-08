<?php
	include("../principal/conectar_principal.php");
	include("age_funciones.php");
	set_time_limit(1000);

if(isset($_REQUEST["Flujo"])){
	$Flujo = $_REQUEST["Flujo"];
}else{
	$Flujo = "";
}
if(isset($_REQUEST["Ano"])){
	$Ano = $_REQUEST["Ano"];
}else{
	$Ano = "";
}
if(isset($_REQUEST["Mes"])){
	$Mes = $_REQUEST["Mes"];
}else{
	$Mes = "";
}

if(isset($_REQUEST["CmbAno"])){
	$CmbAno = $_REQUEST["CmbAno"];
}else{
	$CmbAno = "";
}


if(isset($_REQUEST["TotalPesoHumPrv"])){
	$TotalPesoHumPrv = $_REQUEST["TotalPesoHumPrv"];
}else{
	$TotalPesoHumPrv = 0;
}
if(isset($_REQUEST["TotalPesoSecPrv"])){
	$TotalPesoSecPrv = $_REQUEST["TotalPesoSecPrv"];
}else{
	$TotalPesoSecPrv = 0;
}
if(isset($_REQUEST["TotalFinoCuPrv"])){
	$TotalFinoCuPrv = $_REQUEST["TotalFinoCuPrv"];
}else{
	$TotalFinoCuPrv  = 0;
}
if(isset($_REQUEST["TotalFinoAgPrv"])){
	$TotalFinoAgPrv = $_REQUEST["TotalFinoAgPrv"];
}else{
	$TotalFinoAgPrv  = 0;
}
if(isset($_REQUEST["TotalFinoAuPrv"])){
	$TotalFinoAuPrv = $_REQUEST["TotalFinoAuPrv"];
}else{
	$TotalFinoAuPrv  = 0;
}
if(isset($_REQUEST["TotalFinoCu"])){
	$TotalFinoCu = $_REQUEST["TotalFinoCu"];
}else{
	$TotalFinoCu  = 0;
}
if(isset($_REQUEST["TotalFinoAg"])){
	$TotalFinoAg = $_REQUEST["TotalFinoAg"];
}else{
	$TotalFinoAg  = 0;
}
if(isset($_REQUEST["TotalFinoAu"])){
	$TotalFinoAu = $_REQUEST["TotalFinoAu"];
}else{
	$TotalFinoAu=0;
}
if(isset($_REQUEST["TotalPesoFlujo"])){
	$TotalPesoFlujo = $_REQUEST["TotalPesoFlujo"];
}else{
	$TotalPesoFlujo=0;
}


	$Consulta = "select * from proyecto_modernizacion.flujos where sistema='RAM' and cod_flujo='".$Flujo."'";
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
		$NomFlujo = $Fila["descripcion"];	
		
?>
<html>
<head>
<title>Detalle de Flujo</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="javascript">
function DetalleLote(rut,prod,subprod)
{
	var f = frmDetalleProv;		
	window.open("age_anexo_det_lote2.php?Rut=" + rut + "&CodProducto=" + prod + "&CodSubProducto=" + subprod + "&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value,"","top=80,left=30,width=550,height=450,scrollbars=yes,resizable = yes");					
}
</script>
<style type="text/css">

body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
</style></head>

<body>
<form name="frmDetalleProv" action="" method="post">
<input type="hidden" name="Ano" value="<?php echo $Ano; ?>">
<input type="hidden" name="Mes" value="<?php echo $Mes; ?>">
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
	$FechaIni = $Ano."-".str_pad($Mes,2,'0',STR_PAD_LEFT)."-01";
	$FechaFin = $Ano."-".str_pad($Mes,2,'0',STR_PAD_LEFT)."-31";
	$FechaMer=$Ano.str_pad($Mes,2,'0',STR_PAD_LEFT);
	$LoteIni=substr($FechaIni,2,2)."".substr($FechaIni,5,2)."0000";
	$LoteFin=substr($FechaFin,2,2)."".substr($FechaFin,5,2)."9999";
	$Consulta = "select cod_producto, cod_subproducto, rut_proveedor ";
	$Consulta.= " from age_web.relaciones where flujo='".$Flujo."' order by lpad(rut_proveedor,10,'0')";
	$RespFlujo=mysqli_query($link, $Consulta);

	$TotalPesoHumPrv = 0;
	$TotalPesoSecPrv = 0;
	$TotalFinoCuPrv  = 0;
	$TotalFinoAgPrv  = 0;
	$TotalFinoAuPrv  = 0;
	$TotalFinoCu  = 0;
	$TotalFinoAg  = 0;
	$TotalFinoAu=0;
	$TotalPesoFlujo=0;
	
	while ($FilaFlujo=mysqli_fetch_array($RespFlujo))
	{
		$FinoCu=0;$FinoAg=0;$FinoAu=0;$PesoSecoProv=0;$TipoRecep="";
		$RutProv=$FilaFlujo["rut_proveedor"];
		$Prod=$FilaFlujo["cod_producto"];
		$SubProd=$FilaFlujo["cod_subproducto"];
		$Consulta = "select nombre_prv as nombre from sipa_web.proveedores where trim(rut_prv) = '".$RutProv."'";
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Resp2))
			$NomProv = $Fila2["nombre"];
		else
			$NomProv = "&nbsp;";		
		echo "<tr>\n";
		echo "<td align='right'><a href=\"JavaScript:DetalleLote('".$RutProv."','".$Prod."','".$SubProd."')\">".$RutProv."</a></td>";
		echo "<td align='left'>".substr(strtoupper($NomProv),0,30)."</td>\n";
		$Consulta = "select distinct t1.lote, t2.recargo, t1.rut_proveedor, t2.peso_neto as peso_hum, t1.cod_recepcion,  ";
		$Consulta.= " lpad(t2.recargo,2,'0') as orden, t2.fecha_recepcion, tipo_remuestreo,canjeable,cod_producto,cod_subproducto,peso_retalla,peso_muestra ";		
		$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
		$Consulta.= " on t1.lote = t2.lote ";			
		$Consulta.= " where t1.cod_producto = '".$Prod."' ";
		$Consulta.= " and t1.cod_subproducto = '".$SubProd."' ";
		$Consulta.= " and ((t2.fecha_recepcion between '".$FechaIni."' and '".$FechaFin."' ";
		if($CmbAno=='2005')
		{	
			$Consulta.= " AND left(num_lote_remuestreo,3) in ('".substr($Ano,3,1).str_pad($Mes,2,'0',STR_PAD_LEFT)."',''))";
			$Consulta.= " or (tipo_remuestreo='A' AND left(num_lote_remuestreo,3)='".substr($CmbAno,3,1).str_pad($Mes,2,'0',STR_PAD_LEFT)."'))";
		}
		else
		{	
			$Consulta.= " AND left(num_lote_remuestreo,4) in ('".substr($Ano,2,2).str_pad($Mes,2,'0',STR_PAD_LEFT)."',''))";
			$Consulta.= " or (tipo_remuestreo='A' AND left(num_lote_remuestreo,4)='".substr($Ano,2,2).str_pad($Mes,2,'0',STR_PAD_LEFT)."'))";	
		}	
		$Consulta.= " and t1.rut_proveedor = '".$RutProv."' ";
		$Consulta.= " and t1.estado_lote <>'6' group by t1.lote order by t1.lote, orden";
		$RespLote = mysqli_query($link, $Consulta);
		//echo $Consulta."<br>";
		$EsPlamen=false;
		$Ajuste='N';
		while($FilaLote=mysqli_fetch_array($RespLote))
		{
			$Siesta=0;
			$Porce1=0;
			$Porce2=0;
			$Consulta = "select * from age_web.mermas ";
			$Consulta.= " where cod_producto='".$FilaLote["cod_producto"]."' ";
			$Consulta.= " and cod_subproducto='".$FilaLote["cod_subproducto"]."' ";
			$Consulta.=" and ((year(fecha) < '".$Ano."') or (year(fecha) = '".$Ano."' and month(fecha) <= '".$Mes."'))";
			$RespMerma=mysqli_query($link, $Consulta);
			if($FilaMerma=mysqli_fetch_array($RespMerma))
			{
				$Porce1=str_replace(',','.',$FilaMerma["porc"]);
				$Consulta2 = "select * from age_web.mermas ";
				$Consulta2.= " where cod_producto='".$FilaMerma["cod_producto"]."' ";
				$Consulta2.= " and cod_subproducto='".$FilaMerma["cod_subproducto"]."' ";
				$Consulta2.=" and ((year(fecha) < '".$Ano."') or (year(fecha) = '".$Ano."' and month(fecha) <= '".$Mes."'))";
				$RespM=mysqli_query($link, $Consulta2);
				while($FilaM=mysqli_fetch_array($RespM))
				{
					if ($FilaM["rut_proveedor"]==$RutProv)
					{
						$Siesta=1;
						$Porce2=$FilaM["porc"];
					}
				}
			}
			if ($Siesta==1)
				$PorcMerma=$Porce2;
				else
				$PorcMerma=$Porce1;
				
			$LeyCu=0;$LeyAg=0;$LeyAu=0;$LeyCuOri=0;$LeyAgOri=0;$LeyAuOri=0;$LeyCuAj=0;$LeyAgAj=0;$LeyAuAj=0;						
			$Consulta = "select * from age_web.detalle_lotes where lote='".$FilaLote["lote"]."' order by lote, lpad(recargo,4,'0')";
			//echo $Consulta."<br>";
			$ContRecargos = 1;
			$RespDetLote=mysqli_query($link, $Consulta);
			$TotalPesoSecLote=0;//WSO
			$TotalPesoHumLote=0; //WSO
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
				//echo $Consulta."<br>";
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
			if($FilaLote["cod_recepcion"]=='PMN')
			{
				$EsPlamen=true;
				$DecPHum=4;$DecPSeco=4;$DecLeyes=4;$DecFinos=4;
			}
			$PorcHumLote=0;
			if ($TotalPesoHumLote!=0)
				$PorcHumLote = abs(100 - ($TotalPesoSecLote * 100)/$TotalPesoHumLote);
			$FinoCu=0;$FinoAg=0;$FinoAu=0;$FinoCuAj=0;$FinoAgAj=0;$FinoAuAj=0;$FinoCuAux=0;
			if($LeyCu!=0)
				$FinoCu=($TotalPesoSecLote * $LeyCuOri)/100;
			if($LeyAg!=0)	
				$FinoAg=($TotalPesoSecLote * $LeyAgOri)/1000;
			if($LeyAu!=0)	
				$FinoAu=($TotalPesoSecLote * $LeyAuOri)/1000;
			$TotalPesoHumPrv=$TotalPesoHumPrv+$TotalPesoHumLote;
			$TotalPesoSecPrv=$TotalPesoSecPrv+$TotalPesoSecLote;
			$TotalFinoCuPrv=$TotalFinoCuPrv+round($FinoCu);
			$TotalFinoAgPrv=$TotalFinoAgPrv+round($FinoAg);
			$TotalFinoAuPrv=$TotalFinoAuPrv+round($FinoAu);
			$TotalPesoHumLote=0;$TotalPesoSecLote=0;
		}
		//TOTAL PROVEEDOR
		$DecPHum=0;$DecPSeco=0;$DecLeyes=2;$DecFinos=0;
		if($EsPlamen==true)
		{
			$DecPHum=4;$DecPSeco=4;$DecLeyes=4;$DecFinos=4;
		}
		$PorcHumPrv=0;
		if (intval($TotalPesoHumPrv)!=0&&intval($TotalPesoSecPrv)!=0)
			$PorcHumPrv=100-($TotalPesoSecPrv*100)/$TotalPesoHumPrv;
		$LeyCuPrv=0;$LeyAgPrv=0;$LeyAuPrv=0;	
		if (intval($TotalPesoSecPrv)!=0&&intval($TotalFinoCuPrv)!=0)
		{	
			$LeyCuPrv=($TotalFinoCuPrv*100)/$TotalPesoSecPrv;
			$LeyAgPrv=($TotalFinoAgPrv*1000)/$TotalPesoSecPrv;
			$LeyAuPrv=($TotalFinoAuPrv*1000)/$TotalPesoSecPrv;
		}	
		echo "<td align='right'>".number_format($TotalPesoSecPrv,$DecPSeco,',','.')."</td>";
		echo "<td align='right'>".number_format($LeyCuPrv,$DecLeyes,',','.')."</td>";
		echo "<td align='right'>".number_format($LeyAgPrv,$DecLeyes,',','.')."</td>";
		echo "<td align='right'>".number_format($LeyAuPrv,$DecLeyes,',','.')."</td>";
		echo "<td align='right'>".number_format($TotalFinoCuPrv,$DecFinos,',','.')."</td>";
		echo "<td align='right'>".number_format($TotalFinoAgPrv,$DecFinos,',','.')."</td>";
		echo "<td align='right'>".number_format($TotalFinoAuPrv,$DecFinos,',','.')."</td>";
		echo "</tr>\n";
		$TotalFinoCu = $TotalFinoCu + round($TotalFinoCuPrv);
		$TotalFinoAg = $TotalFinoAg + round($TotalFinoAgPrv);
		$TotalFinoAu = $TotalFinoAu + round($TotalFinoAuPrv);
		$TotalPesoFlujo = $TotalPesoFlujo + $TotalPesoSecPrv;
		$TotalPesoSecPrv=0;$TotalFinoCuPrv=0;$TotalFinoAgPrv=0;$TotalFinoAuPrv=0;
		//AJUSTES DEL MES		
		$Consulta = "select t1.flujo, t1.cod_producto, t1.cod_subproducto, t1.rut_proveedor, ";
		$Consulta.= " t2.peso_seco, t2.fino_cu, t2.fino_ag, t2.fino_au, t3.nombre_prv";
		$Consulta.= " from age_web.relaciones t1 inner join age_web.ajustes t2 on t1.cod_producto=t2.cod_producto ";
		$Consulta.= " and t1.cod_subproducto=t2.cod_subproducto and t1.rut_proveedor=t2.rut_proveedor ";
		$Consulta.= " left join sipa_web.proveedores t3 on t2.rut_proveedor=t3.rut_prv ";
		$Consulta.= " where t1.flujo='".$Flujo."' ";
		$Consulta.= " and t1.cod_producto='".$Prod."' and t1.cod_subproducto='".$SubProd."' and t1.rut_proveedor='".$RutProv."'";
		$Consulta.= " and t2.ano='".$Ano."' and t2.mes='".$Mes."'";			
		$Consulta.= " order by t1.flujo, t1.cod_producto, t1.cod_subproducto, lpad(t1.rut_proveedor,10,0) ";
		$RespAjuste=mysqli_query($link, $Consulta);
		if ($FilaAjuste=mysqli_fetch_array($RespAjuste))
		{
			echo "<tr>";
			echo "<td align='right'>&nbsp;</td>";
			echo "<td align='left'>AJUSTE DEL MES</td>";		
			echo "<td align='right'>".number_format($FilaAjuste["peso_seco"],0,",",".")."</td>";						
			echo "<td align='right'>&nbsp;</td>";
			echo "<td align='right'>&nbsp;</td>";
			echo "<td align='right'>&nbsp;</td>";
			echo "<td align='right'>".number_format($FilaAjuste["fino_cu"],0,",",".")."</td>";
			echo "<td align='right'>".number_format($FilaAjuste["fino_ag"],0,",",".")."</td>";
			echo "<td align='right'>".number_format($FilaAjuste["fino_au"],0,",",".")."</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td align='right'><b>***</b></td>";
			echo "<td align='left'><b>TOTAL</b></td>";		
			echo "<td align='right'>".number_format(($PesoSecoProv+$FilaAjuste["peso_seco"]),0,",",".")."</td>";						
			echo "<td align='right'>&nbsp;</td>";
			echo "<td align='right'>&nbsp;</td>";
			echo "<td align='right'>&nbsp;</td>";
			echo "<td align='right'>".number_format(($FinoCu+$FilaAjuste["fino_cu"]),0,",",".")."</td>";
			echo "<td align='right'>".number_format(($FinoAg+$FilaAjuste["fino_ag"]),0,",",".")."</td>";
			echo "<td align='right'>".number_format(($FinoAu+$FilaAjuste["fino_au"]),0,",",".")."</td>";
			echo "</tr>";
			$TotalPesoFlujo = $TotalPesoFlujo + $FilaAjuste["peso_seco"];	
			$TotalFinoCu = $TotalFinoCu + $FilaAjuste["fino_cu"];
			$TotalFinoAg = $TotalFinoAg + $FilaAjuste["fino_ag"];
			$TotalFinoAu = $TotalFinoAu + $FilaAjuste["fino_au"];
		}		
	}	
	//TOTAL
	echo "<tr class='ColorTabla02'>";
	echo "<td align='right' colspan='2'><strong>TOTAL</strong></td>";		
	echo "<td align='right'>".number_format($TotalPesoFlujo,0,",",".")."</td>";		
	if ($TotalFinoCu!=0 && $TotalPesoFlujo!=0)
		echo "<td align='right'>".number_format(($TotalFinoCu/$TotalPesoFlujo)*100,2,",",".")."</td>";
	else	echo "<td align='right'>0</td>";
	if ($TotalFinoAg!=0 && $TotalPesoFlujo!=0)
		echo "<td align='right'>".number_format(($TotalFinoAg/$TotalPesoFlujo)*1000,2,",",".")."</td>";
	else	echo "<td align='right'>0</td>";
	if ($TotalFinoAu!=0 && $TotalPesoFlujo!=0)
		echo "<td align='right'>".number_format(($TotalFinoAu/$TotalPesoFlujo)*1000,2,",",".")."</td>";
	else	echo "<td align='right'>0</td>";
	echo "<td align='right'>".number_format($TotalFinoCu,0,",",".")."</td>";
	echo "<td align='right'>".number_format($TotalFinoAg,0,",",".")."</td>";
	echo "<td align='right'>".number_format($TotalFinoAu,0,",",".")."</td>";
	echo "</tr>";
	
//FUNCIONES
	
?>  
</table>
</form>
</body>
</html>
