<table width="100%" border="0" cellpadding="0"cellspacing="0">
<tr>
	<td width="5" background="imagenes/tab_separator.gif"></td>
	<td align="center">
		<table width="90%" border="0" cellpadding="0" cellspacing="4">
		<tr>
			<td align="right"><a href="javascript:ValidarTarea('VT','<? echo $CodSelTarea;?>')"></td>
		</tr>
		</table>
		<table width="90%" border="1" cellpadding="0" cellspacing="0">
		<tr>
			<td width="30%" class="TituloCabecera" >Gerencia</td>
			<td width="15%" class="TituloCabecera" >Identificadas</td>
			<td width="15%" class="TituloCabecera" >No Identificadas</td>
			<td width="15%" class="TituloCabecera" >Validadas</td>
			<td width="15%" class="TituloCabecera" >No Validadas</td>
			<td width="10%" class="TituloCabecera" >Total</td>
		 </tr>
	    </table>
	    <div id='load'  style='overflow:auto;WIDTH: 90%; height:360px;left: 15px; top: 65px;'>
          <table width="100%" border="1" cellpadding="0" cellspacing="0">
            <? 
			//$Consulta="SELECT * from sgrs_areaorg where CTAREA ='1' and MVIGENTE='1' order by NAREA";
			$Consulta="SELECT * from sgrs_areaorg where CPARENT = ',0,1,'  and MVIGENTE='1' order by NAREA";
			//echo $Consulta;
			$Resultado=mysql_query($Consulta);$TotGenIden=0;$TotGenNoIden=0;$TotGenVal=0;$TotGenNoVal=0;
			while ($Fila=mysql_fetch_array($Resultado))
			{
				$Codigo=$Fila[CPARENT].$Fila[CAREA].",";
				echo "<tr>";
				echo "<td align='left' width='30%' class='InputCafe'>&nbsp;".$Fila[NAREA]."&nbsp;</td>";
				$TotIden=SumaOperaciones($Codigo,'I',1);
				$TotGenIden=$TotGenIden+$TotIden;
				echo "<td align='right' width='15%'>".number_format($TotIden,0,'','.')."&nbsp;</td>";
				$TotNoIden=SumaOperaciones($Codigo,'I',0);
				$TotGenNoIden=$TotGenNoIden+$TotNoIden;
				echo "<td align='right' width='15%'>".number_format($TotNoIden,0,'','.')."&nbsp;</td>";
				$TotVal=SumaOperaciones($Codigo,'V',1);
				$TotGenVal=$TotGenVal+$TotVal;
				echo "<td align='right' width='15%'>".number_format($TotVal,0,'','.')."&nbsp;</td>";
				$TotNoVal=SumaOperaciones($Codigo,'V',0);
				$TotGenNoVal=$TotGenNoVal+$TotNoVal;
				echo "<td align='right' width='15%'>".number_format($TotNoVal,0,'','.')."&nbsp;</td>";
				$Total=SumaOperaciones($Codigo,'T',0);
				echo "<td align='right' width='10%'>".number_format($Total,0,'','.')."&nbsp;</td>";
				echo "</tr>";
			}
		 echo "<tr>";
		 echo "<td class=TituloCabecera' align='right'>TOTALES</td>";
		 echo "<td align='right'>".number_format($TotGenIden,0,'','.')."</td>";
		 echo "<td align='right'>".number_format($TotGenNoIden,0,'','.')."</td>";
		 echo "<td align='right'>".number_format($TotGenVal,0,'','.')."</td>";
		 echo "<td align='right'>".number_format($TotGenNoVal,0,'','.')."</td>";
		 $Tot=$TotGenVal+$TotGenNoVal;
		 echo "<td align='right'>&nbsp;</td>";
		 echo "</tr>";
		 ?>
		  </table>
      </div>
	 </td>
	<td width="5" background="imagenes/tab_separator.gif"></td>
</tr>
</table>
<?
	function SumaOperaciones($Cod,$TipoCampo,$TipoFiltro)
	{
		switch($TipoCampo)
		{
			case "I":
				$Campo='t2.MIDENTIFICADO';
				$Filtro='and t2.MIDENTIFICADO='.$TipoFiltro;
			break;
			case "V":
				$Campo='t2.MVALIDADO';
				$Filtro='and t2.MVALIDADO='.$TipoFiltro;
			break;
			case "T":
				$Campo='*';
				$Filtro='';			
			break;	
		}
		$Consulta="SELECT count(".$Campo.") as cant from sgrs_areaorg t1 inner join sgrs_siperoperaciones t2 on t1.CAREA=t2.CAREA ";
		$Consulta.="where CTAREA ='8' and CPARENT like '%".$Cod."%' ".$Filtro;
		$RespIdent=mysql_query($Consulta);
		//echo $Consulta."<br><br>";
		$FilaIdent=mysql_fetch_array($RespIdent);
		return($FilaIdent["Cant"]);
	
	}
?>