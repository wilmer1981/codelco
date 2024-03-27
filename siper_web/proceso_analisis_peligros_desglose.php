<?
include('funciones/siper_funciones.php');
?>
<link href="estilos/siper_style.css" rel="stylesheet" type="text/css">
<form>
<table width="100%" border="0" cellpadding="0"cellspacing="0">
<tr>
	<td align="center">
		<table width="90%" border="0" cellpadding="0" cellspacing="4">
		<tr>
		  <td align="left"><? $CODAREA=ObtenerCodParent($CodSelTarea); echo DescripOrganica2($CodSelTarea);?></td>
		</tr>
		</table>
		<table width="90%" border="1" cellpadding="0" cellspacing="0">
		<tr>
			<td width="5%" class="TituloCabecera" rowspan="2">Cod</td>
			<td width="30%" class="TituloCabecera" rowspan="2">Peligro</td>
			<td width="55%" class="TituloCabecera" colspan="4">MRr</td>
			<td width="55%" class="TituloCabecera" colspan="4">MRi</td>
		</tr>
		<tr>	
			<td width="7%" class="TituloCabecera" >Aceptable</td>
			<td width="7%" class="TituloCabecera" >Moderado</td>
			<td width="7%" class="TituloCabecera" >Inaceptable</td>
			<td width="3%" class="TituloCabecera" >Total</td>
			<td width="7%" class="TituloCabecera" >Aceptable</td>
			<td width="7%" class="TituloCabecera" >Moderado</td>
			<td width="7%" class="TituloCabecera" >Inaceptable</td>
			<td width="3%" class="TituloCabecera" >Total</td>
		 </tr>
            <?
			$TotGAcep=0;$TotGMod=0;$TotGInacep=0;$Total=0;
			$Consulta="SELECT t1.CTAREA from sgrs_areaorg t1 where t1.CAREA = '".$CODAREA."' and t1.MVIGENTE='1'";
			$Resultado=mysqli_query($link, $Consulta);
			$Fila=mysql_fetch_array($Resultado);
			$CodTarea=$Fila[CTAREA];
			if($CodTarea==8)
				$Filtro2="t1.CAREA='".$CODAREA."'";
			else
				$Filtro2="t1.CPARENT like '%".$CodSelTarea."%' ";			
			$Consulta="SELECT t3.NCONTACTO,t2.CCONTACTO from sgrs_areaorg t1 inner join sgrs_siperpeligros t2 on t1.CAREA=t2.CAREA inner join sgrs_codcontactos t3 on t2.CCONTACTO=t3.CCONTACTO ";
			$Consulta.="where t1.MVIGENTE='1' and t2.MVIGENTE<>'0' and t1.CTAREA ='8' and ".$Filtro2." group by t2.CCONTACTO order by t2.CCONTACTO ";
			$RespPel=mysqli_query($link, $Consulta);
			//echo $Consulta."<br>";
			while($FilaPel=mysql_fetch_array($RespPel))
			{
				$TotAcep=0;$TotMod=0;$TotInacep=0;$TotMriAcep=0;$TotMriMode=0;$TotMriInac=0;
				$Consulta="SELECT * from sgrs_areaorg t1 inner join sgrs_siperpeligros t2 on t1.CAREA=t2.CAREA ";
				$Consulta.="where t1.MVIGENTE='1' and t2.MVIGENTE<>'0' and t1.CTAREA ='8' and ".$Filtro2." and t2.CCONTACTO='".$FilaPel[CCONTACTO]."' ";
				$RespP=mysqli_query($link, $Consulta);
				//echo $Consulta."<br>";
				while($FilaP=mysql_fetch_array($RespP))
				{
					$MR=$FilaP[QMR];
					if($FilaP[MR1]==1&&$FilaP[MR2]==1)
						$TotAcep++;
					if($FilaP[MR1]==2&&$FilaP[MR2]==2)
						$TotMod++;
					if($FilaP[MR1]==3&&$FilaP[MR2]==3)
						$TotInacep++;
						
					$Devuelto=SUMAMRI2($FilaP[QPROBHIST],$FilaP[QCONSECHIST]);	
					if($Devuelto==1)
						$TotMriAcep++;
					if($Devuelto==2)
						$TotMriMode++;
					if($Devuelto==3)
						$TotMriInac++;
				}
				if($TotAcep!=0||$TotMod!=0||$TotInacep!=0)
				{
					echo "<tr>";
					echo "<td align='center' width='4%'>".$FilaPel[CCONTACTO]."&nbsp;</td>";
					echo "<td align='left' width='24.5%' class='InputCafe'>&nbsp;".strtoupper($FilaPel[NCONTACTO])."&nbsp;</td>";
					echo "<td align='center' width='5%'>".$TotAcep."</td>";
					echo "<td align='center' width='5%'>".$TotMod."</td>";
					echo "<td align='center' width='6%'>".$TotInacep."</td>";
					echo "<td align='center' width='3%'>".($TotAcep+$TotMod+$TotInacep)."</td>";

					$TotGAcep=$TotGAcep+$TotAcep;
					$TotGMod=$TotGMod+$TotMod;
					$TotGInacep=$TotGInacep+$TotInacep;
					$Total=$Total+($TotAcep+$TotMod+$TotInacep);

					echo "<td align='center' width='5%'>".$TotMriAcep."&nbsp;</td>";
					echo "<td align='center' width='5%'>".$TotMriMode."&nbsp;</td>";
					echo "<td align='center' width='6%'>".$TotMriInac."&nbsp;</td>";
					echo "<td align='center' width='3%'>".($TotMriAcep+$TotMriMode+$TotMriInac)."</td>";
					echo "</tr>";
					$TotGAcep1=$TotGAcep1+$TotMriAcep;
					$TotGMod1=$TotGMod1+$TotMriMode;
					$TotGInacep1=$TotGInacep1+$TotMriInac;
					$Total2=$Total2+($TotMriAcep+$TotMriMode+$TotMriInac);
				}					
			}
		 ?>
		<tr>
			<td class="TituloCabecera" align="right" colspan="2">Totales</td>
			<td class="TituloCabecera" align='center'><? echo $TotGAcep;?></td>
			<td class="TituloCabecera" align='center'><? echo $TotGMod;?></td>
			<td class="TituloCabecera" align='center'><? echo $TotGInacep;?></td>
			<td class="TituloCabecera" align='center'><? echo $Total;?></td>
			<td class="TituloCabecera" align='center'><? echo $TotGAcep1;?></td>
			<td class="TituloCabecera" align='center'><? echo $TotGMod1;?></td>
			<td class="TituloCabecera" align='center'><? echo $TotGInacep1;?></td>
			<td class="TituloCabecera" align='center'><? echo $Total2;?></td>
		 </tr>

          </table>
	 </td>
</tr>
</table>
</form>
<?
/*	function SumaMR($Cod,$CodT,$TotAcep,$TotMod,$TotInacep)
	{
		$TotAcep=0;$TotMod=0;$TotInacep=0;
		if($CodT==8)
			$Filtro="t1.CAREA='".$Cod."'";
		else
			$Filtro="t1.CPARENT like '%,".$Cod.",%' ";			
		$Consulta="SELECT QMR from sgrs_areaorg t1 inner join sgrs_siperpeligros t2 on t1.CAREA=t2.CAREA ";
		$Consulta.="where t1.MVIGENTE='1' and t2.MVIGENTE<>'0' and t1.CTAREA ='8' and ".$Filtro;
		$RespPel=mysqli_query($link, $Consulta);
		//echo $Consulta."<br>";
		while($FilaPel=mysql_fetch_array($RespPel))
		{
			//CalculoMR($FilaPel[CCONTACTO],$FilaPel[CPELIGRO],&$PH,&$CH,&$MRi,&$PC,&$CC,&$MR,&$Descrip,&$Semaforo);
			$MR=$FilaPel[QMR];
			if($MR>=1&&$MR<=4)
			{
				$TotAcep++;
			}
			if($MR>=8&&$MR<=16)
			{
				$TotMod++;
			}
			if($MR>=32&&$MR<=64)
			{
				$TotInacep++;
			}
		}
	}
*/
	function SumaMR($Cod,$CodT,$TotAcep,$TotMod,$TotInacep)
	{
		$TotAcep=0;$TotMod=0;$TotInacep=0;
		if($CodT==8)
			$Filtro="t1.CAREA='".$Cod."'";
		else
			$Filtro="t1.CPARENT like '%,".$Cod.",%' ";			
		$Consulta="SELECT t2.MR1,t2.MR2 from sgrs_areaorg t1 inner join sgrs_siperpeligros t2 on t1.CAREA=t2.CAREA ";
		$Consulta.="where t1.MVIGENTE='1' and t2.MVIGENTE<>'0' and t1.CTAREA ='8' and ".$Filtro;
		$RespPel=mysqli_query($link, $Consulta);
		//echo $Consulta."<br>";
		while($FilaPel=mysql_fetch_array($RespPel))
		{
			//CalculoMR($FilaPel[CCONTACTO],$FilaPel[CPELIGRO],&$PH,&$CH,&$MRi,&$PC,&$CC,&$MR,&$Descrip,&$Semaforo);
			if($FilaPel[MR1]==1&&$FilaPel[MR2]==1)
				$TotAcep=$TotAcep+1;
			if($FilaPel[MR1]==2&&$FilaPel[MR2]==2)
				$TotMod=$TotMod+1;
			if($FilaPel[MR1]==3&&$FilaPel[MR2]==3)
				$TotInacep=$TotInacep+1;
				
/*			$MR=$FilaPel[QMR];
			if($MR>=1&&$MR<=4)
			{
				$TotAcep++;
			}
			if($MR>=8&&$MR<=16)
			{
				$TotMod++;
			}
			if($MR>=32&&$MR<=64)
			{
				$TotInacep++;
			}
*/		}
	}
function SUMAMRI2($PH,$CH)
{
	$DMRI=0;
	switch($PH)
	{
		case 1://PROBABILIDAD
			   switch($CH)
			   {
			   		case 1:
			   		case 2:
			   		case 4:
						$DMRI='1';
					break;
					case 8:
						$DMRI='3';
					break;
			   } 	
		break;
		case 2:
			   switch($CH)
			   {
			   		case 1:
			   		case 2:
						$DMRI='1';
					break;
					case 4:
						$DMRI='2';
					break;
					case 8:
						$DMRI='3';
					break;
			   } 	
		break;
		case 4:
			   switch($CH)
			   {
			   		case 1:
						$DMRI='1';
					break;
					case 2:
					case 4:
						$DMRI='2';
					break;
					case 8:
						$DMRI='3';
					break;
			   } 	
		break;
		case 8:
			   switch($CH)
			   {
			   		case 1:
					case 2:
						$DMRI='2';
					break;
					case 4:
					case 8:
						$DMRI='3';
					break;
			   } 	
		break;
	}
	return($DMRI);	
}
?>