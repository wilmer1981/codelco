<table width="740"  border="1" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr align="center" class="ColorTabla01">
    <td width="4%">Rec.</td>
    <td width="4%">Ult.</td>
    <td width="5%">Folio</td>
    <td width="7%">Corr.</td>
    <td width="7%">Fecha.</td>
    <td width="8%">H.Ent</td>
    <td width="7%">H.Sal</td>
    <td width="10%">P.Bruto</td>
    <td width="8%">P.Tara</td>
    <td width="9%">P.Neto</td>
    <td width="9%">Guia</td>
    <td width="10%">Patente</td>
    <td width="4%">Aut.</td>
  </tr>
<?php
	$Consulta = "select t2.fecha_recepcion, t2.hora_entrada, t2.hora_salida, t2.folio, t2.corr, t2.lote, t2.recargo, t2.fin_lote, ";
	$Consulta.= " t1.cod_subproducto, t2.peso_bruto, t2.peso_tara, t2.peso_neto, t2.guia_despacho, ";
	$Consulta.= " t2.guia_despacho, t2.patente, t1.rut_proveedor, LPAD(t2.recargo,2,'0') as orden, ";
	$Consulta.= " t3.valor_subclase1 as est_rec, t2.autorizado ";
	$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes t2 on t1.lote=t2.lote ";
	$Consulta.= " inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='15003' and t2.estado_recargo=t3.cod_subclase ";				
	$Consulta.= " where t1.lote = '".$TxtLote."' order by t2.lote, orden ";
	$Resp = mysqli_query($link, $Consulta);	
	$TotPesoBr = 0;
	$TotPesoTr = 0;
	$TotPesoNt = 0;
	$ContReg = 0;
	while ($Fila = mysqli_fetch_array($Resp))
	{		
		echo "<tr >\n";
		echo "<td align='center'>".$Fila["recargo"]."</td>\n";
		if ($Fila["fin_lote"]!="" && !is_null($Fila["fin_lote"]))
			echo "<td align='center'>".$Fila["fin_lote"]."</td>\n";
		else
			echo "<td>&nbsp;</td>\n";
		echo "<td align='center'>".$Fila["folio"]."</td>\n";		
		echo "<td align='center'>".$Fila["corr"]."</td>\n";		
		echo "<td align='center'>".substr($Fila["fecha_recepcion"],8,2)."/".substr($Fila["fecha_recepcion"],5,2)."</td>\n";		
		echo "<td align='right'>".substr($Fila["hora_entrada"],0,5)."</td>\n";
		echo "<td align='right'>".substr($Fila["hora_salida"],0,5)."</td>\n";
		echo "<td align='right'>".number_format($Fila["peso_bruto"],0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["peso_tara"],0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["peso_neto"],0,",",".")."</td>\n";
		if ($Fila["guia_despacho"]!="" && !is_null($Fila["guia_despacho"]))
			echo "<td align='center'>".$Fila["guia_despacho"]."</td>\n";
		else
			echo "<td>&nbsp;</td>\n";
		if ($Fila["patente"]!="" && !is_null($Fila["patente"]))
			echo "<td align='center'>".$Fila["patente"]."</td>\n";
		else
			echo "<td>&nbsp;</td>\n";		
		echo "<td align='center'>".strtoupper($Fila["autorizado"])."</td>\n";
		echo "</tr>\n";
		$TotPesoBr = $TotPesoBr + $Fila["peso_bruto"];
		$TotPesoTr = $TotPesoTr + $Fila["peso_tara"];
		$TotPesoNt = $TotPesoNt + $Fila["peso_neto"];
		$ContReg++;
	}
?>
  <tr class="ColorTabla02">
    <td colspan="5"><strong>Total Lote: </strong></td>
    <td colspan="2"><strong><?php echo number_format($ContReg,0,",",".");?> Rec.</strong></td>
    <td align="right"><?php echo number_format($TotPesoBr,0,",",".");?></td>
    <td align="right"><?php echo number_format($TotPesoTr,0,",",".");?></td>
    <td align="right"><?php echo number_format($TotPesoNt,0,",",".");?></td>
    <td colspan="6">&nbsp;</td>
  </tr>
</table>
