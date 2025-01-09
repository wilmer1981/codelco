<table width="100%" border="0" cellpadding="0"cellspacing="0">
<tr>
	<td width="5" background="imagenes/tab_separator.gif"></td>
	<td align="center">
		<table width="90%" border="0" cellpadding="0" cellspacing="4">
		<tr><?php $CODAREA=ObtenerCodParent($CodSelTarea);?>
		  <td align="left"><?php echo DescripOrganica2($CodSelTarea);?></td>
		  <td align="left">&nbsp;</td>
		</tr>
		</table>
		<div id='load'  style='overflow:auto;WIDTH: 90%; height:380px;left: 15px; top: 65px;'>
		<table width="95%" border="1" cellpadding="0" cellspacing="0">
		<tr>
			<td width="50%" class="TituloCabecera" rowspan="2">Nivel</td>
			<td width="50%" class="TituloCabecera" colspan="4">MRi</td>
			<td width="50%" class="TituloCabecera" colspan="4">MRr</td>
		</tr>	
		<tr>
			<td width="5%" class="TituloCabecera" >Aceptable</td>
			<td width="5%" class="TituloCabecera" >Moderado</td>
			<td width="5%" class="TituloCabecera" >Inaceptable</td>
			<td width="5%" class="TituloCabecera" >Total</td>
			<td width="5%" class="TituloCabecera" >Aceptable</td>
			<td width="5%" class="TituloCabecera" >Moderado</td>
			<td width="5%" class="TituloCabecera" >Inaceptable</td>
			<td width="5%" class="TituloCabecera" >Total</td>
		 </tr>
            <?php	
				
			$Consulta="select t1.CTAREA from sgrs_areaorg t1 where t1.CAREA = '".$CODAREA."' and MVIGENTE='1'";
			$Resultado=mysqli_query($link,$Consulta);
			$Fila=mysqli_fetch_array($Resultado);
			$CodTarea=$Fila[CTAREA];
			if($CodTarea==8)
				$Filtro="t1.CAREA='".$CODAREA."'";
			else
				$Filtro="t1.CPARENT = '".$CodSelTarea."'";	
			$Consulta2="select t1.CAREA,t1.CPARENT,t1.CTAREA,t1.NAREA,t2.QPROBHIST,t2.QCONSECHIST from sgrs_areaorg t1 left join sgrs_siperpeligros t2 on t1.CAREA=t2.CAREA ";
			$Consulta2.=" where ".$Filtro." and t1.CPARENT <>'' and t1.MVIGENTE='1' group by t1.CAREA";
			//echo $Consulta2."<BR>";
			$Resultado2=mysqli_query($link,$Consulta2);
			while ($Fila2=mysqli_fetch_array($Resultado2))
			{	$SUMAACEP=0;$SUMAMODE=0;$SUMAINAC=0;
					
				//echo "CAREA:   ".$Fila2[CAREA]."<br>";
				$DMRI=0;
				//echo $Fila2[CTAREA];
				SumaMR($Fila2[CAREA],$Fila2[CPARENT],$Fila2[CTAREA],&$TotAcep,&$TotMod,&$TotInacep);	
				SUMAMRI($Fila2[QPROBHIST],$Fila2[QCONSECHIST],$Fila2[CAREA],$Fila2[CTAREA],&$SUMAACEP,&$SUMAMODE,&$SUMAINAC);
				//if($TotAcep!=0||$TotMod!=0||$TotInacep!=0||$SUMAACEP!=0||$SUMAMODE!=0||$SUMAINAC!=0)
				//{
					echo "<tr>";
					echo "<td align='left' width='40%' class='InputCafe'>&nbsp;".strtoupper($Fila2[NAREA])."&nbsp;</td>";
					echo "<td align='center' width='7%'>".$SUMAACEP."&nbsp;</td>";
					echo "<td align='center' width='7%'>".$SUMAMODE."&nbsp;</td>";
					echo "<td align='center' width='7%'>".$SUMAINAC."&nbsp;</td>";
					echo "<td align='center' width='3%'>".($SUMAACEP+$SUMAMODE+$SUMAINAC)."&nbsp;</td>";
					
					$TotGAcepMRi=$TotGAcepMRi+$SUMAACEP;
					$TotGModMRi=$TotGModMRi+$SUMAMODE;
					$TotGInacepMRi=$TotGInacepMRi+$SUMAINAC;
					$Total1=$Total1+($SUMAACEP+$SUMAMODE+$SUMAINAC);

					echo "<td align='center' width='7%'>".$TotAcep."</td>";
					echo "<td align='center' width='7%'>".$TotMod."</td>";
					echo "<td align='center' width='7%'>".$TotInacep."</td>";
					echo "<td align='center' width='3%'>".($TotAcep+$TotMod+$TotInacep)."</td>";

					$TotGAcep=$TotGAcep+$TotAcep;
					$TotGMod=$TotGMod+$TotMod;
					$TotGInacep=$TotGInacep+$TotInacep;
					$Total=$Total+($TotAcep+$TotMod+$TotInacep);
					echo "</tr>";
				//}
			}
		 ?>
		<tr>
			<td class="TituloCabecera" align="right" >Totales</td>
			<td class="TituloCabecera" ><?php echo $TotGAcepMRi;?></td>
			<td class="TituloCabecera" ><?php echo $TotGModMRi;?></td>
			<td class="TituloCabecera" ><?php echo $TotGInacepMRi;?></td>
			<td class="TituloCabecera" ><?php echo $Total1;?></td>
			<td class="TituloCabecera" ><?php echo $TotGAcep;?></td>
			<td class="TituloCabecera" ><?php echo $TotGMod;?></td>
			<td class="TituloCabecera" ><?php echo $TotGInacep;?></td>
			<td class="TituloCabecera" ><?php echo $Total;?></td>
		 </tr>
		 <tr><td colspan="9">&nbsp;</td></tr>		 
				<tr>
					<!--<td width="3%" class="TituloCabecera" rowspan="2">Cod</td>-->
					<td width="47%" class="TituloCabecera" rowspan="2">Peligro</td>
					<td class="TituloCabecera" colspan="4">MRi</td>
					<td class="TituloCabecera" colspan="4">MRr</td>
				</tr>
				<tr>	
					<td width="9%" class="TituloCabecera" >Aceptable</td>
					<td width="9%" class="TituloCabecera" >Moderado</td>
					<td width="10%" class="TituloCabecera" >Inaceptable</td>
					<td width="4%" class="TituloCabecera" >Total</td>
					<td width="9%" class="TituloCabecera" >Aceptable</td>
					<td width="9%" class="TituloCabecera" >Moderado</td>
					<td width="10%" class="TituloCabecera" >Inaceptable</td>
					<td width="7%" class="TituloCabecera" >Total</td>
				 </tr>
					<?php
					$TotGAcep=0;$TotGMod=0;$TotGInacep=0;$Total=0;
					$Consulta="select t1.CTAREA from sgrs_areaorg t1 where t1.CAREA = '".$CODAREA."' and t1.MVIGENTE='1'";
					$Resultado=mysqli_query($link,$Consulta);
					$Fila=mysqli_fetch_array($Resultado);
					$CodTarea=$Fila[CTAREA];
					if($CodTarea==8)
						$Filtro2="t1.CAREA='".$CODAREA."'";
					else
						$Filtro2="t1.CPARENT like '%".$CodSelTarea."%' ";			
					$Consulta="select t3.NCONTACTO,t2.CCONTACTO from sgrs_areaorg t1 inner join sgrs_siperpeligros t2 on t1.CAREA=t2.CAREA inner join sgrs_codcontactos t3 on t2.CCONTACTO=t3.CCONTACTO ";
					$Consulta.="where t1.MVIGENTE='1' and t2.MVIGENTE<>'0' and t1.CTAREA ='8' and ".$Filtro2." group by t2.CCONTACTO order by t2.CCONTACTO ";
					$RespPel=mysqli_query($link,$Consulta);
					//echo $Consulta."<br>";
					while($FilaPel=mysqli_fetch_array($RespPel))
					{
						$TotAcep=0;$TotMod=0;$TotInacep=0;$TotMriAcep=0;$TotMriMode=0;$TotMriInac=0;
						$Consulta="select * from sgrs_areaorg t1 inner join sgrs_siperpeligros t2 on t1.CAREA=t2.CAREA ";
						$Consulta.="where t1.MVIGENTE='1' and t2.MVIGENTE<>'0' and t1.CTAREA ='8' and ".$Filtro2." and t2.CCONTACTO='".$FilaPel[CCONTACTO]."' ";
						$RespP=mysqli_query($link,$Consulta);
						//echo $Consulta."<br>";
						while($FilaP=mysqli_fetch_array($RespP))
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
						//if($TotAcep!=0||$TotMod!=0||$TotInacep!=0)
						//{
							echo "<tr>";
							//echo "<td align='center' width='4%'>&nbsp;</td>";
							echo "<td align='left' width='24.5%' class='InputCafe'>&nbsp;".strtoupper($FilaPel[NCONTACTO])."&nbsp;</td>";
							echo "<td align='center' width='5%'>".$TotMriAcep."&nbsp;</td>";
							echo "<td align='center' width='5%'>".$TotMriMode."&nbsp;</td>";
							echo "<td align='center' width='6%'>".$TotMriInac."&nbsp;</td>";
							echo "<td align='center' width='3%'>".($TotMriAcep+$TotMriMode+$TotMriInac)."</td>";
							$TotGAcep1=$TotGAcep1+$TotMriAcep;
							$TotGMod1=$TotGMod1+$TotMriMode;
							$TotGInacep1=$TotGInacep1+$TotMriInac;
							$Total2=$Total2+($TotMriAcep+$TotMriMode+$TotMriInac);

							echo "<td align='center' width='5%'>".$TotAcep."</td>";
							echo "<td align='center' width='5%'>".$TotMod."</td>";
							echo "<td align='center' width='6%'>".$TotInacep."</td>";
							echo "<td align='center' width='3%'>".($TotAcep+$TotMod+$TotInacep)."</td>";
							echo "</tr>";
		
							$TotGAcep=$TotGAcep+$TotAcep;
							$TotGMod=$TotGMod+$TotMod;
							$TotGInacep=$TotGInacep+$TotInacep;
							$Total=$Total+($TotAcep+$TotMod+$TotInacep);
						//}	
					}
				 ?>
				<tr>
					<td class="TituloCabecera" align="right" >Totales</td>
					<td class="TituloCabecera" align='center'><?php echo $TotGAcep1;?></td>
					<td class="TituloCabecera" align='center'><?php echo $TotGMod1;?></td>
					<td class="TituloCabecera" align='center'><?php echo $TotGInacep1;?></td>
					<td class="TituloCabecera" align='center'><?php echo $Total2;?></td>
					<td class="TituloCabecera" align='center'><?php echo $TotGAcep;?></td>
					<td class="TituloCabecera" align='center'><?php echo $TotGMod;?></td>
					<td class="TituloCabecera" align='center'><?php echo $TotGInacep;?></td>
					<td class="TituloCabecera" align='center'><?php echo $Total;?></td>
				 </tr>
		
		  </table>
		</div>
	 </td>
	<td width="5" background="imagenes/tab_separator.gif"></td>
</tr>
</table>
<?php
	function SumaMR($CAREA,$CodSelTarea,$CodT,$TotAcep,$TotMod,$TotInacep)
	{
		$TotAcep=0;$TotMod=0;$TotInacep=0;
		if($CodT==8)
			$Filtro="t1.CAREA='".$CAREA."'";
		else
			$Filtro="t1.CPARENT like '%".$CodSelTarea.$CAREA.",%' ";			
		$Consulta="select t2.MR1,t2.MR2 from sgrs_areaorg t1 inner join sgrs_siperpeligros t2 on t1.CAREA=t2.CAREA ";
		$Consulta.="where t1.MVIGENTE='1' and t2.MVIGENTE<>'0' and t1.CTAREA ='8' and ".$Filtro;
		$RespPel=mysqli_query($link,$Consulta);
		//echo $Consulta."<br>";
		while($FilaPel=mysqli_fetch_array($RespPel))
		{
			if($FilaPel[MR1]==1&&$FilaPel[MR2]==1)
				$TotAcep=$TotAcep+1;
			if($FilaPel[MR1]==2&&$FilaPel[MR2]==2)
				$TotMod=$TotMod+1;
			if($FilaPel[MR1]==3&&$FilaPel[MR2]==3)
				$TotInacep=$TotInacep+1;				
		}
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