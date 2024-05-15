<?php
	include("../principal/conectar_principal.php");	
	include("../age_web/age_funciones.php");	
	$CmbMes = str_pad($CmbMes,2,"0",STR_PAD_LEFT);
	/*$TxtFechaIni = $CmbAno."-".$CmbMes."-01";
	$TxtFechaFin = date("Y-m-d", mktime(0,0,0,$CmbMes+1,1,$CmbAno));
	$TxtFechaFin = date("Y-m-d", mktime(0,0,0,substr($TxtFechaFin,5,2),1-1,substr($TxtFechaFin,0,4)));*/
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
			f.action = "age_con_resumen_pesos.php";
			f.submit();
			break;
	}
}
</script>
<style type="text/css">
<!--
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
.Estilo1 {color: #0000FF}
-->
</style></head>

<body>
<form name="frmPrincipal" action="" method="post">
  <table width="620" border="0" align="center">
    <tr>
      <td width="294">CODELCO DIVISION VENTANAS </td>
      <td width="296" align="right">FECHA:&nbsp;<?php echo date("d-m-Y")?></td>
    </tr>
    <tr align="center">
      <td height="30" colspan="2"><strong><u>RESUMEN DE PESO HUMEDO Y PESO SECO </u></strong></td>
    </tr>
    <tr align="center">
      <td colspan="2">Periodo: <?php echo substr($TxtFechaIni,8,2)."-".substr($TxtFechaIni,5,2)."-".substr($TxtFechaIni,0,4)." al ".substr($TxtFechaFin,8,2)."-".substr($TxtFechaFin,5,2)."-".substr($TxtFechaFin,0,4); ?></td>
    </tr>
    <tr align="center">
      <td colspan="2"><input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70px " onClick="Proceso('I')">
      <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
    </tr>
  </table>
  <br>
  <?php
	echo "<table width=\"600\"  border=\"1\" align=\"center\" cellpadding=\"3\" cellspacing=\"0\">\n";
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
	while ($FilaAsig = mysqli_fetch_array($RespAsig))
	{
		echo "<tr class=\"ColorTabla01\">\n";
		echo "<td align=\"left\" colspan=\"5\">".$FilaAsig["cod_recepcion"]."</td>";
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
			echo "<tr bgcolor=\"#CCCCCC\">\n";
			if($FilaClaseProd["valor_subclase1"]=='METALICO')	
				echo "<td align=\"left\" colspan=\"5\">".strtoupper($FilaClaseProd["valor_subclase1"])."</td>\n";
			else
				echo "<td align=\"left\" colspan=\"5\">".strtoupper('MINERO')."</td>\n";
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
			while($FilaProd=mysqli_fetch_array($RespProd))
			{
				echo "<tr class=\"Detalle01\">\n";
				echo "<td colspan=\"2\">".$FilaProd["descripcion"]."</td>";
				echo "<td align=\"center\">P.Hum.(Kg)</td>\n";
				echo "<td align=\"center\">Hum(%)</td>\n";
				echo "<td align=\"center\">P.Seco (Kg)</td>\n";
				echo "</tr>\n";
				//CONSULTA LOS PROVEEDOR DE UNA ASINACION Y UNA CLASE PRODUCTO Y UN PRODUCTO
				$Consulta = "select distinct t1.rut_proveedor, t1.cod_recepcion,t2.NOMPRV_A as nom_prv  ";
				$Consulta.= " from age_web.lotes t1 inner join rec_web.proved t2 on t1.rut_proveedor=t2.RUTPRV_A";
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
				$RespPrv = mysqli_query($link, $Consulta);
				while ($FilaPrv = mysqli_fetch_array($RespPrv))
				{						
					echo "<tr>\n";
					echo "<td align=\"right\">".$FilaPrv["rut_proveedor"]."</td>";
					echo "<td align=\"left\">".substr(strtoupper($FilaPrv["nom_prv"]),0,30)."</td>\n";
					$ArrDatos=array();
					$ArrLeyesProv=array();
					$ArrLeyesProv["01"][0]="01";$ArrLeyesProv["02"][0]="02";$ArrLeyesProv["04"][0]="04";$ArrLeyesProv["05"][0]="05";
					LeyesProveedor('',$FilaPrv["rut_proveedor"],$FilaProd["cod_producto"],$FilaProd["cod_subproducto"],&$ArrDatos,&$ArrLeyesProv,'N','S','S',$TxtFechaIni,$TxtFechaFin,"");
					$CantDecPeso=0;$CantDecLF=0;
					if($FilaProd[recepcion]=='PMN')
					{
						$CantDecPeso=4;$CantDecLF=0;
					}
					echo "<td align=\"right\">".number_format($ArrDatos[peso_humedo],$CantDecPeso,",",".")."</td>\n";
					reset($ArrLeyesProv);
					echo "<td align=\"right\">".number_format($ArrLeyesProv["01"][2],2,",",".")."</td>\n";
					echo "<td align=\"right\">".number_format($ArrDatos[peso_seco],$CantDecPeso,",",".")."</td>\n";
					reset($ArrLeyesProv);
					echo "</tr>\n";
					$PesoHumProd=$PesoHumProd + $ArrDatos["peso_humedo"];
					$PesoSecoProd=$PesoSecoProd + $ArrDatos["peso_seco"];
				}
				if ($PesoSecoProd>0 && $PesoHumProd>0)
					$PorcHumProd = abs(100 - (($PesoSecoProd * 100)/$PesoHumProd));
				else
					$PorcHumProd = 0;
				$CantDecPeso=0;$CantDecLF=0;
				if($FilaProd[recepcion]=='PMN')
				{
					$CantDecPeso=4;$CantDecLF=0;
				}
				echo "<tr class=\"Detalle01\">\n";
				echo "<td align=\"left\" colspan=\"2\">TOTAL ".$FilaProd["descripcion"]."</td>";
				echo "<td align=\"right\">".number_format($PesoHumProd,$CantDecPeso,",",".")."</td>";
				echo "<td align=\"right\">".number_format($PorcHumProd,2,",",".")."</td>";
				echo "<td align=\"right\">".number_format($PesoSecoProd,$CantDecPeso,",",".")."</td>";
				echo "</tr>\n";
				$PesoHumClasProd=$PesoHumClasProd+$PesoHumProd;
				$PesoSecoClasProd=$PesoSecoClasProd+$PesoSecoProd;
				$PesoHumProd=0;$PesoSecoProd=0;$PorcHumProd=0;
			}	
			echo "<tr bgcolor=\"#CCCCCC\">\n";
			if($FilaClaseProd["valor_subclase2"]=='METALICO')	
				echo "<td align=\"left\" colspan=\"2\">TOTAL ".$FilaClaseProd["valor_subclase1"]."</td>";
			else
				echo "<td align=\"left\" colspan=\"2\">TOTAL MINERO</td>";
			if ($PesoSecoClasProd>0 && $PesoHumClasProd>0)
				$PorcHumClasProd = 100 - (($PesoSecoClasProd * 100)/$PesoHumClasProd);
			else
				$PorcHumClasProd = 0;
			echo "<td align=\"right\">".number_format($PesoHumClasProd,0,",",".")."</td>";
			echo "<td align=\"right\">".number_format($PorcHumClasProd,2,",",".")."</td>";
			echo "<td align=\"right\">".number_format($PesoSecoClasProd,0,",",".")."</td>";
			echo "</tr>\n";
			$PesoHumAsig=$PesoHumAsig+$PesoHumClasProd;
			$PesoSecoAsig=$PesoSecoAsig+$PesoSecoClasProd;
			$PesoHumClasProd=0;$PesoSecoClasProd=0;$PorcHumClasProd=0;
		}
		echo "<tr class=\"ColorTabla01\">\n";
		echo "<td align=\"left\" colspan=\"2\">TOTAL ".$FilaAsig["cod_recepcion"]."</td>";
		if ($PesoSecoAsig>0 && $PesoHumAsig>0)
			$PorcHumAsig = 100 - (($PesoSecoAsig * 100)/$PesoHumAsig);
		else
			$PorcHumAsig = 0;
		echo "<td align=\"right\">".number_format($PesoHumAsig,0,",",".")."</td>";
		echo "<td align=\"right\">".number_format($PorcHumAsig,2,",",".")."</td>";
		echo "<td align=\"right\">".number_format($PesoSecoAsig,0,",",".")."</td>";
		echo "</tr>\n";
		$PesoHumTot=$PesoHumTot+$PesoHumAsig;
		$PesoSecoTot=$PesoSecoTot+$PesoSecoAsig;
		$PesoHumAsig=0;$PesoSecoAsig=0;$PorcHumAsig=0;
	}
	echo "<tr class=\"Detalle03\">\n";
	echo "<td align=\"left\" colspan=\"2\">TOTAL</td>";
	if ($PesoSecoTot>0 && $PesoHumTot>0)
		$PorcHumTot = 100 - (($PesoSecoTot * 100)/$PesoHumTot);
	else
		$PorcHumTot = 0;
	echo "<td align=\"right\">".number_format($PesoHumTot,0,",",".")."</td>";
	echo "<td align=\"right\">".number_format($PorcHumTot,2,",",".")."</td>";
	echo "<td align=\"right\">".number_format($PesoSecoTot,0,",",".")."</td>";
	echo "</tr>\n";
	
	echo "</table>\n";
 ?>  
</form>
</body>
</html>