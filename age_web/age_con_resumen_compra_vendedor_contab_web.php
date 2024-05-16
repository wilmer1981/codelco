<?php
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
      <td height="30" colspan="2"><strong><u>RESUMEN COMPRA POR VENDEDOR AJUSTADO<br>
        (AJUSTES CONTABLES) 
      </u></strong></td>
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
/*CONSULTO FECHA CIERRE ANEXO
$Consulta = "select estado, fecha_cierre from proyecto_modernizacion.cierre_mes";
$Consulta.= " where cod_sistema='15' ";
$Consulta.= " and ano='".$CmbAno."' and mes='".$CmbMes."' and cod_bloqueo='1' and fecha_cierre = (";
$Consulta.= " select max(fecha_cierre) from proyecto_modernizacion.cierre_mes";
$Consulta.= " where cod_sistema='15' ";
$Consulta.= " and ano='".$CmbAno."' and mes='".$CmbMes."' and cod_bloqueo='1')";
$Resp = mysqli_query($link, $Consulta);
$CierreBalance = false;	
if ($Fila = mysqli_fetch_array($Resp))
{
	if ($Fila["estado"]=="C")
	{*/
		$CierreBalance = true;
		//$FechaCierreAnexo=$Fila["fecha_cierre"];
		$FechaCierreAnexo=$TxtFechaConsulta;
		//echo "FechaCierreAnexo=".$FechaCierreAnexo;
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
					$SumHumedad=0;
					$RespPrv = mysqli_query($link, $Consulta);
					while ($FilaPrv = mysqli_fetch_array($RespPrv))
					{						
						echo "<tr>\n";
						echo "<td align='right'>".$FilaPrv["rut_proveedor"]."</td>";
						echo "<td align='left'>".substr(strtoupper($FilaPrv["nom_prv"]),0,30)."</td>\n";
						$ArrDatos=array();
						$ArrLeyesProv=array();
						$ArrLeyesProv["01"][0]="01";$ArrLeyesProv["02"][0]="02";$ArrLeyesProv["04"][0]="04";$ArrLeyesProv["05"][0]="05";
						LeyesProveedor($FilaAsig["cod_recepcion"],$FilaPrv["rut_proveedor"],$FilaProd["cod_producto"],$FilaProd["cod_subproducto"],&$ArrDatos,&$ArrLeyesProv,'N','S','S',$TxtFechaIni,$TxtFechaFin,$FechaCierreAnexo);
						$CantDecPeso=0;$CantDecLF=0;
						$PesoS=$ArrDatos[peso_seco3];
						if($FilaProd["recepcion"]=='PMN')
						{
							$CantDecPeso=4;$CantDecLF=0;
							$PesoS=$ArrDatos[peso_seco];
						}
						echo "<td align='right'>".number_format($ArrDatos[peso_humedo],$CantDecPeso,",",".")."</td>\n";
						reset($ArrLeyesProv);
						//SUMA LAS HUMEDADES PARA LUEGO COMPARAR SI TIENE ALGO O NO
						$SumHumedad=$SumHumedad + $ArrLeyesProv["01"][2];
						echo "<td align='right'>".number_format($ArrLeyesProv["01"][2],2,",",".")."</td>\n";
						echo "<td align='right'>".number_format($ArrLeyesProv["02"][2],2,",",".")."</td>\n";
						echo "<td align='right'>".number_format($ArrLeyesProv["04"][2],0,",",".")."</td>\n";
						echo "<td align='right'>".number_format($ArrLeyesProv["05"][2],1,",",".")."</td>\n";
						echo "<td align='right'>".number_format($PesoS,$CantDecPeso,",",".")."</td>\n";
						reset($ArrLeyesProv);
						echo "<td align='right'>".number_format($ArrLeyesProv["02"][23],$CantDecLF,",",".")."</td>\n";
						echo "<td align='right'>".number_format($ArrLeyesProv["04"][23],$CantDecLF,",",".")."</td>\n";
						echo "<td align='right'>".number_format($ArrLeyesProv["05"][23],$CantDecLF,",",".")."</td>\n";
						echo "</tr>\n";
						$PesoHumProd=$PesoHumProd + $ArrDatos["peso_humedo"];
						$PesoSecoProd=$PesoSecoProd + $PesoS;
						$FinoProdCu=$FinoProdCu + $ArrLeyesProv["02"][23];
						$FinoProdAg=$FinoProdAg + $ArrLeyesProv["04"][23];
						$FinoProdAu=$FinoProdAu + $ArrLeyesProv["05"][23];
						//AJUSTES POR CANJE
						$ArrAjustes=array();
						$ArrAjustes["01"][0]="01";$ArrLeyesProv["02"][0]="02";$ArrLeyesProv["04"][0]="04";$ArrLeyesProv["05"][0]="05";
						LeyesAjusteProveedor($CmbAno,$CmbMes,$FilaPrv["rut_proveedor"],$FilaProd["cod_producto"],$FilaProd["cod_subproducto"],&$ArrAjustes,$FechaCierreAnexo);
						if ($ArrAjustes["02"][23]!=0 || $ArrAjustes["04"][23]!=0 || $ArrAjustes["05"][23]!=0)
						{
							echo "<tr>\n";
							echo "<td align='right'>&nbsp;</td>";
							echo "<td align='left'>AJUSTES DEL MES POR CANJE</td>\n";
							echo "<td align='right'>&nbsp;</td>\n";
							echo "<td align='right'>&nbsp;</td>\n";
							echo "<td align='right'>&nbsp;</td>\n";
							echo "<td align='right'>&nbsp;</td>\n";
							echo "<td align='right'>&nbsp;</td>\n";
							echo "<td align='right'>&nbsp;</td>\n";
							echo "<td align='right'>".number_format($ArrAjustes["02"][23],$CantDecLF,",",".")."</td>\n";
							echo "<td align='right'>".number_format($ArrAjustes["04"][23],$CantDecLF,",",".")."</td>\n";
							echo "<td align='right'>".number_format($ArrAjustes["05"][23],$CantDecLF,",",".")."</td>\n";
							echo "</tr>\n";
							echo "<tr>\n";
							echo "<td align='right'><strong>***</strong></td>";
							echo "<td align='left'><strong>TOTAL</strong></td>\n";
							echo "<td align='right'>&nbsp;</td>\n";
							echo "<td align='right'>&nbsp;</td>\n";
							echo "<td align='right'>&nbsp;</td>\n";
							echo "<td align='right'>&nbsp;</td>\n";
							echo "<td align='right'>&nbsp;</td>\n";
							echo "<td align='right'>&nbsp;</td>\n";
							echo "<td align='right'>".number_format(($ArrLeyesProv["02"][23]+$ArrAjustes["02"][23]),$CantDecLF,",",".")."</td>\n";
							echo "<td align='right'>".number_format(($ArrLeyesProv["04"][23]+$ArrAjustes["04"][23]),$CantDecLF,",",".")."</td>\n";
							echo "<td align='right'>".number_format(($ArrLeyesProv["05"][23]+$ArrAjustes["05"][23]),$CantDecLF,",",".")."</td>\n";
							echo "</tr>\n";
						}
						$FinoProdCu=$FinoProdCu + $ArrAjustes["02"][23];
						$FinoProdAg=$FinoProdAg + $ArrAjustes["04"][23];
						$FinoProdAu=$FinoProdAu + $ArrAjustes["05"][23];
					}
					if ($PesoSecoProd>0 && $PesoHumProd>0 && $SumHumedad!=0)
						$PorcHumProd = round(abs(100 - (($PesoSecoProd * 100)/$PesoHumProd)));
					else
						$PorcHumProd = 0;
					$CantDecPeso=0;$CantDecLF=0;
					if($FilaProd["recepcion"]=='PMN')
					{
						$CantDecPeso=4;$CantDecLF=0;
					}
					echo "<tr class='Detalle01'>\n";
					echo "<td align='left' colspan='2'>TOTAL ".$FilaProd["descripcion"]."</td>";
					echo "<td align='right'>".number_format($PesoHumProd,$CantDecPeso,",",".")."</td>";
					echo "<td align='right'>".number_format($PorcHumProd,2,",",".")."</td>";
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
					echo "<td align='right'>".number_format($LeyProdCu,2,",",".")."</td>";
					echo "<td align='right'>".number_format($LeyProdAg,0,",",".")."</td>";
					echo "<td align='right'>".number_format($LeyProdAu,1,",",".")."</td>";
					echo "<td align='right'>".number_format($PesoSecoProd,$CantDecPeso,",",".")."</td>";
					echo "<td align='right'>".number_format($FinoProdCu,$CantDecLF,",",".")."</td>";
					echo "<td align='right'>".number_format($FinoProdAg,$CantDecLF,",",".")."</td>";
					echo "<td align='right'>".number_format($FinoProdAu,$CantDecLF,",",".")."</td>";
					echo "</tr>\n";
					$PesoHumClasProd=$PesoHumClasProd+$PesoHumProd;
					$PesoSecoClasProd=$PesoSecoClasProd+$PesoSecoProd;
					$FinoClasProdCu=$FinoClasProdCu+$FinoProdCu;
					$FinoClasProdAg=$FinoClasProdAg+$FinoProdAg;
					$FinoClasProdAu=$FinoClasProdAu+$FinoProdAu;
					$PesoHumProd=0;$PesoSecoProd=0;$PorcHumProd=0;$FinoProdCu=0;$FinoProdAg=0;$FinoProdAu=0;
				}	
				echo "<tr bgcolor='#CCCCCC'>\n";
				if($FilaClaseProd["valor_subclase2"]=='METALICO')	
					echo "<td align='left' colspan='2'>TOTAL ".$FilaClaseProd["valor_subclase1"]."</td>";
				else
					echo "<td align='left' colspan='2'>TOTAL MINERO</td>";
				if ($PesoSecoClasProd>0 && $PesoHumClasProd>0 && $SumHumedad!=0)
					$PorcHumClasProd = 100 - (($PesoSecoClasProd * 100)/$PesoHumClasProd);
				else
					$PorcHumClasProd = 0;
				echo "<td align='right'>".number_format($PesoHumClasProd,0,",",".")."</td>";
				echo "<td align='right'>".number_format($PorcHumClasProd,2,",",".")."</td>";
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
				echo "<td align='right'>".number_format($LeyClasProdCu,2,",",".")."</td>";
				echo "<td align='right'>".number_format($LeyClasProdAg,0,",",".")."</td>";
				echo "<td align='right'>".number_format($LeyClasProdAu,1,",",".")."</td>";
				echo "<td align='right'>".number_format($PesoSecoClasProd,0,",",".")."</td>";
				echo "<td align='right'>".number_format($FinoClasProdCu,0,",",".")."</td>";
				echo "<td align='right'>".number_format($FinoClasProdAg,0,",",".")."</td>";
				echo "<td align='right'>".number_format($FinoClasProdAu,0,",",".")."</td>";
				echo "</tr>\n";
				$PesoHumAsig=$PesoHumAsig+$PesoHumClasProd;
				$PesoSecoAsig=$PesoSecoAsig+$PesoSecoClasProd;
				$FinoAsigCu=$FinoAsigCu+$FinoClasProdCu;
				$FinoAsigAg=$FinoAsigAg+$FinoClasProdAg;
				$FinoAsigAu=$FinoAsigAu+$FinoClasProdAu;
				$PesoHumClasProd=0;$PesoSecoClasProd=0;$PorcHumClasProd=0;$FinoClasProdCu=0;$FinoClasProdAg=0;$FinoClasProdAu=0;
			}
			echo "<tr class='ColorTabla01'>\n";
			echo "<td align='left' colspan='2'>TOTAL ".$FilaAsig["cod_recepcion"]."</td>";
			if ($PesoSecoAsig>0 && $PesoHumAsig>0 && $SumHumedad!=0)
				$PorcHumAsig = 100 - (($PesoSecoAsig * 100)/$PesoHumAsig);
			else
				$PorcHumAsig = 0;
			echo "<td align='right'>".number_format($PesoHumAsig,0,",",".")."</td>";
			echo "<td align='right'>".number_format($PorcHumAsig,2,",",".")."</td>";
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
			echo "<td align='right'>".number_format($LeyAsigCu,2,",",".")."</td>";
			echo "<td align='right'>".number_format($LeyAsigAg,0,",",".")."</td>";
			echo "<td align='right'>".number_format($LeyAsigAu,1,",",".")."</td>";
			echo "<td align='right'>".number_format($PesoSecoAsig,0,",",".")."</td>";
			echo "<td align='right'>".number_format($FinoAsigCu,0,",",".")."</td>";
			echo "<td align='right'>".number_format($FinoAsigAg,0,",",".")."</td>";
			echo "<td align='right'>".number_format($FinoAsigAu,0,",",".")."</td>";
			echo "</tr>\n";
			$PesoHumTot=$PesoHumTot+$PesoHumAsig;
			$PesoSecoTot=$PesoSecoTot+$PesoSecoAsig;
			$FinoTotCu=$FinoTotCu+$FinoAsigCu;
			$FinoTotAg=$FinoTotAg+$FinoAsigAg;
			$FinoTotAu=$FinoTotAu+$FinoAsigAu;
			$PesoHumAsig=0;$PesoSecoAsig=0;$PorcHumAsig=0;$FinoAsigCu=0;$FinoAsigAg=0;$FinoAsigAu=0;
		}
		echo "<tr class='Detalle03'>\n";
		echo "<td align='left' colspan='2'>TOTAL</td>";
		if ($PesoSecoTot>0 && $PesoHumTot>0 && $SumHumedad!=0)
			$PorcHumTot = 100 - (($PesoSecoTot * 100)/$PesoHumTot);
		else
			$PorcHumTot = 0;
		echo "<td align='right'>".number_format($PesoHumTot,0,",",".")."</td>";
		echo "<td align='right'>".number_format($PorcHumTot,2,",",".")."</td>";
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
		echo "<td align='right'>".number_format($LeyTotCu,2,",",".")."</td>";
		echo "<td align='right'>".number_format($LeyTotAg,0,",",".")."</td>";
		echo "<td align='right'>".number_format($LeyTotAu,1,",",".")."</td>";
		echo "<td align='right'>".number_format($PesoSecoTot,0,",",".")."</td>";
		echo "<td align='right'>".number_format($FinoTotCu,0,",",".")."</td>";
		echo "<td align='right'>".number_format($FinoTotAg,0,",",".")."</td>";
		echo "<td align='right'>".number_format($FinoTotAu,0,",",".")."</td>";
		echo "</tr>\n";
		
		echo "</table>\n";
	/*}
	else
	{
		echo "EL MES NO SE HA CERRADO, POR FAVOR CIERRE EL ANEXO";
	}
}		*/
 ?>  
</form>
</body>
</html>