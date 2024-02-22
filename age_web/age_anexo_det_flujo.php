<?php
	include("../principal/conectar_principal.php");
	include("age_funciones.php");
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
	window.open("age_anexo_det_lote.php?Rut=" + rut + "&CodProducto=" + prod + "&CodSubProducto=" + subprod + "&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value,"","top=80,left=30,width=550,height=450,scrollbars=yes,resizable = yes");					
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
	$Consulta = "select cod_producto, cod_subproducto, rut_proveedor ";
	$Consulta.= " from age_web.relaciones where flujo='".$Flujo."' order by lpad(rut_proveedor,10,'0')";
	$RespFlujo=mysqli_query($link, $Consulta);
	while ($FilaFlujo=mysqli_fetch_array($RespFlujo))
	{
		$FinoCu=0;
		$FinoAg=0;
		$FinoAu=0;
		$PesoSecoProv=0;
		$TipoRecep="";
		$RutProv=$FilaFlujo["rut_proveedor"];
		$Prod=$FilaFlujo["cod_producto"];
		$SubProd=$FilaFlujo["cod_subproducto"];
		$ArrDatosProv=array();
		$ArrLeyesProv=array();
		$ArrLeyesProv["01"][0]="01";
		$ArrLeyesProv["02"][0]="02";
		$ArrLeyesProv["04"][0]="04";
		$ArrLeyesProv["05"][0]="05";
		LeyesProveedor($TipoRecep,$RutProv,$Prod,$SubProd,&$ArrDatosProv,&$ArrLeyesProv,"N","S","S",$FechaIni,$FechaFin,"");		
		$PesoSecoProv = $ArrDatosProv["peso_seco3"];
		/*if ($PesoSecoProv>0)
		{*/
			reset($ArrLeyesProv);
			while (list($k,$v)=each($ArrLeyesProv))
			{			
				/*if ($v[2]!=0 && $v[5]!=0)//$PesoSecoProv!=0 &&  
				{*/
					switch ($v[0])
					{
						case "02":
							//$FinoCu = (($PesoSecoProv * $v[2])/$v[5]);//VALOR
							$FinoCu  = $v[23]; //FINO
							break;
						case "04":
							//$FinoAg = (($PesoSecoProv * $v[2])/$v[5]);//VALOR
							$FinoAg  = $v[23]; //FINO
							break;
						case "05":
							//$FinoAu = (($PesoSecoProv * $v[2])/$v[5]);//VALOR
							$FinoAu = $v[23]; //FINO
							break;
					}				
				//}
			}
			//reset($ArrLeyesLote);
			do {			 
				$k = key ($ArrLeyesProv);			
				$ArrLeyesProv[$k][2] = "";
			} while (next($ArrLeyesProv));	
			$Consulta = "select nomprv_a as nombre from rec_web.proved where trim(rutprv_a) = '".$RutProv."'";
			$Resp2 = mysqli_query($link, $Consulta);
			if ($Fila2 = mysqli_fetch_array($Resp2))
				$NomProv = $Fila2["nombre"];
			else
				$NomProv = "&nbsp;";
			echo "<tr>";
			echo "<td align='right'><a href=\"JavaScript:DetalleLote('".$RutProv."','".$Prod."','".$SubProd."')\">".$RutProv."</a></td>";
			echo "<td align='left'>".$NomProv."</td>";		
			echo "<td align='right'>".number_format($PesoSecoProv,0,",",".")."</td>";		
			if ($FinoCu!=0 && $PesoSecoProv!=0)
			{
				echo "<td align='right'>".number_format(($FinoCu/$PesoSecoProv)*100,2,",",".")."</td>";
			}
			else	
			{
				echo "<td align='right'>0</td>";
			}
			if ($FinoAg!=0 && $PesoSecoProv!=0)
			{
				echo "<td align='right'>".number_format(($FinoAg/$PesoSecoProv)*1000,2,",",".")."</td>";
			}
			else	
			{
				echo "<td align='right'>0</td>";
			}
			if ($FinoAu!=0 && $PesoSecoProv!=0)
			{
				echo "<td align='right'>".number_format(($FinoAu/$PesoSecoProv)*1000,2,",",".")."</td>";
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
			$TotalPesoFlujo = $TotalPesoFlujo + $PesoSecoProv;
			//AJUSTES DEL MES		
			$Consulta = "select t1.flujo, t1.cod_producto, t1.cod_subproducto, t1.rut_proveedor, ";
			$Consulta.= " t2.peso_seco, t2.fino_cu, t2.fino_ag, t2.fino_au, t3.nomprv_a";
			$Consulta.= " from age_web.relaciones t1 inner join age_web.ajustes t2 on t1.cod_producto=t2.cod_producto ";
			$Consulta.= " and t1.cod_subproducto=t2.cod_subproducto and t1.rut_proveedor=t2.rut_proveedor ";
			$Consulta.= " left join rec_web.proved t3 on t2.rut_proveedor=t3.rutprv_a ";
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
		//}				
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
?>  
</table>
</form>
</body>
</html>
