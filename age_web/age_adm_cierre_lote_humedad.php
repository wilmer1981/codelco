<table width="740"  border="1" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr align="center" class="ColorTabla01">
    <td width="190">Recargos</td>
    <td width="117">Peso Humedo</td>
	<td width="116">(%) Humedad</td>
	<td width="60">Merma</td>
	<td width="128">Humedad</td>
    <td width="91">Peso Seco</td>
  </tr>
<?php
	$Consulta = "select t1.fecha_recepcion, t2.hora_entrada, t2.hora_salida, t2.folio, t2.corr, t2.lote, t2.recargo, t2.fin_lote, ";
	$Consulta.= " t1.cod_subproducto, t2.peso_bruto, t2.peso_tara, t2.peso_neto, t2.guia_despacho, ";
	$Consulta.= " t2.guia_despacho, t2.patente, t1.rut_proveedor, LPAD(t2.recargo,2,'0') as orden, ";
	$Consulta.= " t3.valor_subclase1 as est_rec, t2.autorizado ";
	$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes t2 on t1.lote=t2.lote ";
	$Consulta.= " inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='15003' and t2.estado_recargo=t3.cod_subclase ";				
	$Consulta.= " where t1.lote = '".$TxtLote."' order by t2.lote, orden ";
	//echo $Consulta;
	$Resp = mysqli_query($link, $Consulta);	
	$ContReg   = 0;
	$PorcMerma = 0;
	$DescMerma = "";
	$CantDec   = 0;
	$TotPesoSeco = 0;
	$TotPesoHum  = 0;
	$TotPesoSecoAnt=0;
	while ($Fila = mysqli_fetch_array($Resp))
	{		
		$DatosLoteRec = array();
		$ArrLeyes=array();
		$DatosLoteRec["lote"]=$TxtLote;
		$DatosLoteRec["recargo"]=$Fila["recargo"];
		$FechaMer = "20".substr($TxtLote,0,2)."-".substr($TxtLote,2,2);
		//LeyesLoteRecargo($DatosLoteRec,$ArrLeyes,"N","N","S","","",$link);
		$ArrLeyes   = LeyesLoteRecargo($DatosLoteRec,$ArrLeyes,"N","N","S","","",$link); 
	
		$ArrLeyes0130 = isset($ArrLeyes["01"][30])?$ArrLeyes["01"][30]:0;
		$ArrLeyes012  = isset($ArrLeyes["01"][2])?$ArrLeyes["01"][2]:0;
		if ($ArrLeyes0130>0)
		{
			$PorcMerma = $ArrLeyes["01"][30];
			$DescMerma = $ArrLeyes["01"][31];
		}
		//echo $ArrLeyes["01"][2]."<br>";
		//echo $ArrLeyes["01"][30]."<br>";
		$recepcion   = isset($ArrLeyes["recepcion"])?$ArrLeyes["recepcion"]:"";
		$peso_humedo = isset($ArrLeyes["peso_humedo"])?$ArrLeyes["peso_humedo"]:0;
		$peso_seco   = isset($ArrLeyes["peso_seco"])?$ArrLeyes["peso_seco"]:0;
		$NuevoPorc = ($ArrLeyes012 + $ArrLeyes0130);
		if ($peso_humedo>0 && $NuevoPorc>0)
		{
			/*echo $ArrLeyes["01"][2]."<br>";
			echo $DatosLoteRec["peso_humedo"]."<br>";
			echo $NuevoPorc."<br>";
			echo $ArrLeyes["01"][30]."<br><br>";*/
			
			if ($recepcion=="PMN" && $Fila["cod_subproducto"] !="43")
				$PesoSeco = $peso_humedo;
			else
				$PesoSeco = $peso_humedo - ($peso_humedo * $NuevoPorc)/100;
		}
		else
		{
			if ($recepcion=="PMN")
				$PesoSeco = $peso_humedo;
			else
				$PesoSeco = $peso_seco;			
		}
		echo "<tr >\n";
		echo "<td align='center'>".$Fila["recargo"]."</td>\n";
		if ($recepcion=="PMN")
			$CantDec=4;
		else
			$CantDec=0;
		echo "<td align='right'>".number_format($peso_humedo,$CantDec,'','.')."</td>\n";		
		echo "<td align='right'>".number_format($ArrLeyes012,4,',','.')."</td>\n";		
		//echo "<td align='right'>".number_format(($ArrLeyes["01"][23]*100)/$PesoSeco,2,',','.')."</td>\n";		
		echo "<td align='right'>".number_format($PorcMerma,2,',','.')."</td>\n";		
		echo "<td align='right'>".number_format($NuevoPorc,4,',','.')."</td>\n";				
		echo "<td align='right'>".number_format($PesoSeco,$CantDec,'','.')."</td>\n";
		echo "</tr>\n";
		$TotPesoHum = $TotPesoHum + $peso_humedo;
		$TotPesoSecoAnt = $TotPesoSecoAnt + $PesoSeco;
		//$TotPesoSecoAnt2 = $TotPesoSecoAnt2 + $DatosLoteRec["peso_seco2"];
		if ($recepcion=="PMN")
			$TotPesoSeco = $TotPesoSeco + $PesoSeco;
		else
			$TotPesoSeco = $TotPesoSeco + round($PesoSeco);
		$ContReg++;
	}
	/*if ($TotPesoSecoAnt!=0 && $TotPesoHum!=0)
		$TotPorc = 100 - ($TotPesoSecoAnt * 100)/$TotPesoHum;
	else
		$TotPorc = 0;*/
	if ($TotPesoSeco!=0 && $TotPesoHum!=0)
		$TotNuevoPorc = 100 - ($TotPesoSeco * 100)/$TotPesoHum;
	else
		$TotNuevoPorc = 0;
	
?>
  <tr class="ColorTabla02">
    <td><strong>Total Lote:&nbsp;&nbsp;<?php echo number_format($ContReg,0,",",".");?> Rec.</strong></td>
	<?php
		$DatosLote= array();
		$ArrLeyes=array();
		$DatosLote["lote"]=$TxtLote;
		$ArrLeyes["01"][0]="01";
		//LeyesLote($DatosLote,$ArrLeyes,"N","S","S","","","",$link);
		$ArrLeyes = LeyesLote($DatosLote,$ArrLeyes,"N","S","S","","","",$Petalo,$link);  
		$tipo_remuestreo=isset($ArrLeyes["tipo_remuestreo"])?$ArrLeyes["tipo_remuestreo"]:"";
		if($tipo_remuestreo=='A')
		{
			$ValorLey   =$ArrLeyes["01"][60];
			$TotPesoSeco=isset($ArrLeyes["peso_seco2_ori"])?$ArrLeyes["peso_seco2_ori"]:0;
		}	
		else
		{   
			$ArrLeyes012 = isset($ArrLeyes["01"][2])?$ArrLeyes["01"][2]:"";
			//$ValorLey=$ArrLeyes012;
			$ValorLey=$ArrLeyes["01"][2];
			/*if ($DatosLoteRec["recepcion"]=="PMN")
				$TotPesoSeco=$DatosLote["peso_seco"];
			else
				$TotPesoSeco=$DatosLote["peso_seco2"];*/
		}	
		reset($ArrLeyes);
		//echo $ValorLey;
		//$TotPorc=abs($ValorLey-$ArrLeyes["01"][30]);
		//echo "TotPesoHum:".$TotPesoHum;
		if($TotPesoHum > 0){
			$TotPorc = 100-($TotPesoSeco*100)/$TotPesoHum;
		}else{
			$TotPorc = 0;
		}
		//$TotNuevoPorc=$ValorLey;
		$ArrLeyes0130 = isset($ArrLeyes["01"][30])?$ArrLeyes["01"][30]:0;
		$TotNuevoPorc = abs($TotPorc-$ArrLeyes0130);
		
		
	?>
    <td align="right"><?php echo number_format($TotPesoHum,$CantDec,",",".");?></td>
    <td align="right"><?php echo number_format($TotNuevoPorc,4,",",".");?></td>
	<td align="right"><?php echo number_format($PorcMerma,2,",",".");?></td>
	<td align="right"><?php echo number_format($TotPorc,4,",",".");?></td>
    <td align="right"><?php echo number_format($TotPesoSeco,$CantDec,",",".");?></td>
  </tr>
  <tr class="ColorTabla02">
    <td><strong>Descripcion Merma: </strong></td>
    <td colspan="5"><?php echo $DescMerma; ?>&nbsp;</td>
  </tr>

</table>
