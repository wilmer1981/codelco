<?php
	include("../principal/conectar_principal.php");
	include("age_funciones.php");

if(isset($_REQUEST["Rut"])){
	$Rut = $_REQUEST["Rut"];
}else{
	$Rut = "";
}
if(isset($_REQUEST["CodProducto"])){
	$CodProducto = $_REQUEST["CodProducto"];
}else{
	$CodProducto = "";
}
if(isset($_REQUEST["CodSubProducto"])){
	$CodSubProducto = $_REQUEST["CodSubProducto"];
}else{
	$CodSubProducto = "";
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

	
	$Consulta = "select nombre_prv from sipa_web.proveedores where rut_prv='".$Rut."'";
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
		$NomProveedor = strtoupper($Fila["nombre_prv"]);
	$Consulta = "select * from proyecto_modernizacion.subproducto where cod_producto='".$CodProducto."' and cod_subproducto='".$CodSubProducto."' ";
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
		$NomSubProducto = strtoupper($Fila["descripcion"]);	
?>
<html>
<head>
<title>Detalle de Flujo</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="javascript">
function Proceso(opt)
{
	var f = frmDetalleLote;		
	
}
</script>
<style type="text/css">

body {
	background-image: url(../principal/imagenes/fondo3.gif);
}

</style></head>

<body>
<form name="frmDetalleLote" action="" method="post">
<div align="center"><strong>SUBPRODUCTO:</strong>&nbsp;<?php echo str_pad($CodSubProducto,3,'0',STR_PAD_LEFT)." - ".strtoupper($NomSubProducto); ?><br>
  <br>
  <strong>PROVEEDOR:</strong>&nbsp;<?php echo $Rut." - ".strtoupper($NomProveedor); ?>  <br>
  <br>
</div>
<table width="500" border="1" align="center" cellpadding="3" cellspacing="0">
  <tr align="center" valign="middle" class="ColorTabla01">
    <td width="70" rowspan="2">Lote</td>
    <td width="70" rowspan="2">Peso</td>
    <td colspan="3">Leyes</td>
    <td colspan="3">Fino</td>
  </tr>
  <tr class="ColorTabla01">
    <td width="70" align="center">Cu</td>
    <td width="70" align="center">Ag</td>
    <td width="70" align="center">Au</td>
    <td width="70" align="center">Cu</td>
    <td width="70" align="center">Ag</td>
    <td width="70" align="center">Au</td>
  </tr>
<?php
	$FechaIni = $Ano."-".str_pad($Mes,2,'0',STR_PAD_LEFT)."-01";
	$FechaFin = $Ano."-".str_pad($Mes,2,'0',STR_PAD_LEFT)."-31";
	$FechaMer=$Ano.str_pad($Mes,2,'0',STR_PAD_LEFT);
	$CodLoteIni=substr($FechaIni,3,1).substr($FechaIni,5,2)."000";
	$CodLoteFin=substr($FechaFin,3,1).substr($FechaFin,5,2)."999";	
	$Consulta = "select distinct t1.lote ";
	$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes t2 on t1.lote = t2.lote ";	
	$Consulta.= " where t1.lote<>'' ";
	$Consulta.= " and (t1.estado_lote <>'6'  or (t1.estado_lote='6' and t1.mostrar_lote='S')) ";
	$Consulta.= " and (t1.tipo_remuestreo <>'A'  or (t1.tipo_remuestreo='A' and substring(t1.lote,1,3)='".substr($CodLoteIni,0,3)."'))";					
	$Consulta.= " and t1.cod_producto = '".$CodProducto."' ";
	$Consulta.= " and t1.cod_subproducto = '".$CodSubProducto."' ";
	$Consulta.= " and t2.fecha_recepcion between '".$FechaIni."' and '".$FechaFin."'";
	$Consulta.= " and t1.rut_proveedor = '".$Rut."' ";
	$Consulta.= " order by t1.lote ";	
	//echo $Consulta."<br>";
	$RespProv=mysqli_query($link, $Consulta);
	$TotalPesoProv=0;
	$TotalFinoCu=0;
	$TotalFinoAg=0;
	$TotalFinoAu=0;
	$TotalFinoCu=0;
	$TotalFinoAg=0;
	$TotalFinoAu=0;

	while ($FilaProv=mysqli_fetch_array($RespProv))
	{
		$FinoCu=0;
		$FinoAg=0;
		$FinoAu=0;
		$PesoSecoLote=0;
		
		echo "<tr>";
		echo "<td align=\"center\">".$FilaProv["lote"]."</td>";
		$TotalPesoSecLote=0;$TotalPesoHumLote=0;
		$Siesta=0;
		$Porce1=0;
		$Porce2=0;
		$Consulta = "select * from age_web.mermas ";
		$Consulta.= " where cod_producto='".$CodProducto."' ";
		$Consulta.= " and cod_subproducto='".$CodSubProducto."' ";
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
				if ($FilaM["rut_proveedor"]==$Rut)
				{
					$Siesta=1;
					$Porce2=str_replace(',','.',$FilaM["porc"]);
				}
			}
		}
		if ($Siesta==1)
			$PorcMerma=$Porce2;
			else
			$PorcMerma=$Porce1;

		$LeyCu=0;$LeyAg=0;$LeyAu=0;					
		//$Consulta = "select * from age_web.detalle_lotes where lote='".$FilaProv["lote"]."' order by lote, lpad(recargo,4,'0')";
		$Consulta = "select t1.lote, t1.recargo,t1.peso_neto,t2.peso_muestra,t2.peso_retalla,t2.cod_recepcion ";
		$Consulta.= "from age_web.detalle_lotes t1 inner join age_web.lotes t2 on t2.lote = t1.lote";
		$Consulta.= " where t1.lote='".$FilaProv["lote"]."' order by t1.lote, lpad(t1.recargo,4,'0')";
		$ContRecargos = 1;
		$RespDetLote=mysqli_query($link, $Consulta);
		$cod_recepcion="";
		while ($FilaDetLote = mysqli_fetch_array($RespDetLote))
		{					
			$PorcHum=0;
			$cod_recepcion = $FilaDetLote["cod_recepcion"];
			$PesoHumedoRec = $FilaDetLote["peso_neto"];
			$Consulta = "select distinct t1.cod_leyes, t1.valor,t1.valor2, t2.cod_unidad, t2.abreviatura as nom_unidad, t2.conversion, t3.abreviatura as nom_ley,t3.nombre_leyes as nombre_ley ";
			$Consulta.= " from age_web.leyes_por_lote t1 left join proyecto_modernizacion.unidades t2 on ";
			$Consulta.= " t1.cod_unidad=t2.cod_unidad left join proyecto_modernizacion.leyes t3 on t1.cod_leyes=t3.cod_leyes";
			$Consulta.= " where t1.lote='".$FilaProv["lote"]."' ";
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
						if($FilaDetLote["peso_retalla"]>0&&$FilaDetLote["peso_muestra"]>0)
							$IncRetalla = CalcIncRetalla($FilaDetLote["lote"],"02",$FilaLeyes["valor"],$FilaDetLote["peso_retalla"],$FilaDetLote["peso_muestra"],$IncRetalla,$link);
						$LeyCu = $FilaLeyes["valor"]+$IncRetalla;
						break;
					case "04":
						$IncRetalla=0;
						if($FilaDetLote["peso_retalla"]>0&&$FilaDetLote["peso_muestra"]>0)
							$IncRetalla = CalcIncRetalla($FilaDetLote["lote"],"04",$FilaLeyes["valor"],$FilaDetLote["peso_retalla"],$FilaDetLote["peso_muestra"],$IncRetalla,$link);
						$LeyAg = $FilaLeyes["valor"]+$IncRetalla;
						break;
					case "05":
						$IncRetalla=0;
						if($FilaDetLote["peso_retalla"]>0&&$FilaDetLote["peso_muestra"]>0)
							$IncRetalla = CalcIncRetalla($FilaDetLote["lote"],"05",$FilaLeyes["valor"],$FilaDetLote["peso_retalla"],$FilaDetLote["peso_muestra"],$IncRetalla,$link);
						$LeyAu = $FilaLeyes["valor"]+$IncRetalla;
						break;
				}
			}
			if($PorcHum!=0)
			{
				$PesoSecoRec = $PesoHumedoRec - ($PesoHumedoRec*$PorcHum)/100;
				if($cod_recepcion=='PMN')
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
		if($cod_recepcion=='PMN')
		{
			$EsPlamen=true;
			$DecPHum=2;$DecPSeco=2;$DecLeyes=2;$DecFinos=2;
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
		echo "<td align='right'>".number_format($TotalPesoSecLote,$DecPSeco,',','.')."</td>";
		echo "<td align='right'>".number_format($LeyCu,$DecLeyes,',','.')."</td>";
		echo "<td align='right'>".number_format($LeyAg,$DecLeyes,',','.')."</td>";
		echo "<td align='right'>".number_format($LeyAu,$DecLeyes,',','.')."</td>";
		echo "<td align='right'>".number_format($FinoCu,$DecFinos,',','.')."</td>";
		echo "<td align='right'>".number_format($FinoAg,$DecFinos,',','.')."</td>";
		echo "<td align='right'>".number_format($FinoAu,$DecFinos,',','.')."</td>";
		echo "</tr>";
		$TotalFinoCu = $TotalFinoCu + round($FinoCu);
		$TotalFinoAg = $TotalFinoAg + round($FinoAg);
		$TotalFinoAu = $TotalFinoAu + round($FinoAu);
		$TotalPesoProv = $TotalPesoProv + $TotalPesoSecLote;	
		$TotalPesoSecLote=0;
	}
	echo "<tr class='ColorTabla02'>";
	echo "<td align='right'><strong>TOTAL</strong></td>";		
	echo "<td align='right'>".number_format($TotalPesoProv,0,",",".")."</td>";		
	if ($TotalFinoCu!=0 && $TotalPesoProv!=0)
		echo "<td align='right'>".number_format(($TotalFinoCu/$TotalPesoProv)*100,2,",",".")."</td>";
	else	echo "<td align='right'>0</td>";
	if ($TotalFinoAg!=0 && $TotalPesoProv!=0)
		echo "<td align='right'>".number_format(($TotalFinoAg/$TotalPesoProv)*1000,2,",",".")."</td>";
	else	echo "<td align='right'>0</td>";
	if ($TotalFinoAu!=0 && $TotalPesoProv!=0)
		echo "<td align='right'>".number_format(($TotalFinoAu/$TotalPesoProv)*1000,2,",",".")."</td>";
	else	echo "<td align='right'>0</td>";
	echo "<td align='right'>".number_format($TotalFinoCu,0,",",".")."</td>";
	echo "<td align='right'>".number_format($TotalFinoAg,0,",",".")."</td>";
	echo "<td align='right'>".number_format($TotalFinoAu,0,",",".")."</td>";
	echo "</tr>";
?>  
</table>
</form>
</body>
</html>
