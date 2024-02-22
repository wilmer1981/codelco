<?php
	include("../principal/conectar_principal.php");
	include("age_funciones.php");
	$Consulta = "select nomprv_a from rec_web.proved where rutprv_a='".$Rut."'";
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
		$NomProveedor = strtoupper($Fila["nomprv_a"]);
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
<!--
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
-->
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
	while ($FilaProv=mysqli_fetch_array($RespProv))
	{
		$FinoCu=0;
		$FinoAg=0;
		$FinoAu=0;
		$PesoSecoLote=0;
		$ArrDatosLote=array();
		$ArrLeyesLote=array();
		$ArrDatosLote["lote"]=$FilaProv["lote"];
		$ArrLeyesLote["01"][0]="01";
		$ArrLeyesLote["02"][0]="02";
		$ArrLeyesLote["04"][0]="04";
		$ArrLeyesLote["05"][0]="05";
		LeyesLote(&$ArrDatosLote,&$ArrLeyesLote,"N","S","S",$FechaIni,$FechaFin,"");
		$PesoSecoLote = $ArrDatosLote["peso_seco"];
		/*if ($ArrDatosLote["lote"]=="507053")
		{
			echo $ArrLeyesLote["01"][2]."<br>";
			echo $ArrLeyesLote["02"][2]."<br>";
			echo $ArrLeyesLote["04"][2]."<br>";
		}*/
		/*if ($PesoSecoLote!=0)
		{*/
			reset($ArrLeyesLote);
			while (list($k,$v)=each($ArrLeyesLote))
			{			
				if ($v[2]!=0 && $v[5]!=0) //$PesoSecoLote!=0 && 
				{
					switch ($v[0])
					{
						case "02":
							//$FinoCu = (($PesoSecoLote * $v[2])/$v[5]);//VALOR
							$FinoCu = $ArrLeyesLote["02"][23];//FINO
							break;
						case "04":
							//$FinoAg = (($PesoSecoLote * $v[2])/$v[5]);//VALOR
							$FinoAg = $ArrLeyesLote["04"][23];//FINO
							break;
						case "05":
							//$FinoAu = (($PesoSecoLote * $v[2])/$v[5]);//VALOR
							$FinoAu = $ArrLeyesLote["05"][23];//FINO
							break;
					}				
				}
			}
			//reset($ArrLeyesLote);
			do {			 
				$k = key ($ArrLeyesLote);			
				$ArrLeyesLote[$k][2] = "";
			} while (next($ArrLeyesLote));	
			echo "<tr>";
			echo "<td align='center'>".$FilaProv["lote"]."</td>";
			echo "<td align='right'>".number_format($PesoSecoLote,0,",",".")."</td>";		
			if ($FinoCu!=0 && $PesoSecoLote!=0)//
			{
				echo "<td align='right'>".number_format(($FinoCu/$PesoSecoLote)*100,2,",",".")."</td>";
				
			}
			else	
			{
				echo "<td align='right'>0</td>";
			}
			if ($FinoAg!=0 && $PesoSecoLote!=0)//
			{
				echo "<td align='right'>".number_format(($FinoAg/$PesoSecoLote)*1000,2,",",".")."</td>";
				
			}
			else	
			{
				echo "<td align='right'>0</td>";
			}
			if ($FinoAu!=0 && $PesoSecoLote!=0)//
			{
				echo "<td align='right'>".number_format(($FinoAu/$PesoSecoLote)*1000,2,",",".")."</td>";
				
			}
			else	
			{
				echo "<td align='right'>0</td>";
			}
			$TotalFinoCu = $TotalFinoCu + $FinoCu;
			$TotalFinoAg = $TotalFinoAg + $FinoAg;
			$TotalFinoAu = $TotalFinoAu + $FinoAu;
			echo "<td align='right'>".number_format($FinoCu,0,",",".")."</td>";
			echo "<td align='right'>".number_format($FinoAg,0,",",".")."</td>";
			echo "<td align='right'>".number_format($FinoAu,0,",",".")."</td>";
			echo "</tr>";
			$TotalPesoProv = $TotalPesoProv + $PesoSecoLote;	
		//}				
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
