	<table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
	<tr>
	<?
	if($CmbResumen=='1')
	{
	?>
		<td width="20%" class="TituloTablaVerde" align="center" rowspan="2">Resumen Precios (Finos) </td>
	<?
	}
	else
	{
	?>
		<td width="20%" class="TituloTablaVerde" align="center" rowspan="2">Desglose por Proveedores</td>
	<?
	}
	?>
	<?
	for($i=$Mes;$i<=$MesFin;$i++)
	{
	?>
		<td width="7%" class="TituloTablaVerde"align="center" colspan="2"><? echo $Meses[$i-1]?></td>
	<?	
		$ArrTMF1[$i][0]=0;
		$ArrTMF2[$i][0]=0;
		$ArrTotal1[$i][0]=0;
		$ArrTotal2[$i][0]=0;
		$ArrTMH1[$i][0]=0;
		$ArrTMH2[$i][0]=0;				
	}
	?>
	</tr>
	<tr>
	<?
	for($i=$Mes;$i<=$MesFin;$i++)
	{
	?>
		<td width="7%" class="TituloTablaVerde" align="center" >Real</td>
		<td width="7%" class="TituloTablaVerde" align="center">Proyectado</td>
	<?	
	}
	?>
	</tr>
	<?	
	$Buscar='S';	
	 if($Buscar=='S')
	 {	
	   //echo $CmbProductos."<br>";
	   //echo $CmbDivision."<br>";
		$Tms1=1;
		$Tms2=1;					
		if($CmbResumen!='1')					
		{					   
		$ArrayTot=array();
		$Consulta ="select nombre_subclase  as nom_prv,cod_subclase as cod_prv from proyecto_modernizacion.sub_clase";
		$Consulta.=" where cod_clase='31024' ";
		if($CmbProductos=='3')
		{
			if($CmbDivision!='T')
				$Consulta.=" and cod_subclase='".$CmbDivision."' ";
			else
				$Consulta.=" and cod_subclase in('3')";
		}				
		$Consulta.= " group by cod_prv";	
		//echo $Consulta; 	
		$Resp=mysqli_query($link, $Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{
			$NomPrv=$Fila[nom_prv];
			$CodPrv=$Fila[cod_prv];
				?>
				<tr class="Formulario2">
				<td rowspan="1" colspan="25" align="left"><? echo $NomPrv;?></td>
				</tr>
				<tr class="FilaAbeja">
				<td align="left">TMH</td>
				<?
				for($i=$Mes;$i<=$MesFin;$i++)
				{	
					$LEY1=DatosProyectados($CodPrv,'1',$Ano,$i,'COBRE','R')*100;
					$LEY2=DatosProyectados($CodPrv,'1',$Ano,$i,'COBRE','P')*100;										
					$Hum1=DatosProyectados($CodPrv,'1',$Ano,$i,'HUMEDAD','R')*100;
					$Hum2=DatosProyectados($CodPrv,'1',$Ano,$i,'HUMEDAD','P')*100;			
					$Valor1=$Tms1;
					$Um=$Hum1/100;
					$Um2=$Hum2/100;
					$Valor2=(1-$Um);
					$Valor3=(1-$Um2);
					$TMH1=$Valor1/$Valor2;
					$TMH2=$Valor1/$Valor3;
					$ArrTMH1[$i][0]=$TMH1;
					$ArrTMH2[$i][0]=$TMH2;
				?>
				<td align='right'><? echo number_format($TMH1,2,',','.');?>&nbsp;</td>
				<td align='right'><? echo number_format($TMH2,2,',','.');?>&nbsp;</td>
				<?
				 }
				?>
				</tr>
				<tr class="FilaAbeja3">
				<td align="left">TMS</td>
				<?
				for($i=$Mes;$i<=$MesFin;$i++)
				{	
				?>
					<td align='right'><? echo number_format($Tms1,2,',','.');?>&nbsp;</td>
					<td align='right'><? echo number_format($Tms2,2,',','.');?>&nbsp;</td>
				<?
				 }
				?>
				</tr>
				<tr class="FilaAbeja">
				<td align="left">LEY</td>
				<?								
				for($i=$Mes;$i<=$MesFin;$i++)
				{		
			     $LEY1=DatosPrecios($Ano,$i,'3','27');
			     //echo $LEY1;
			     $LEY2=DatosPrecios($Ano,$i,'3','27');
			     //echo	$LEY2;								    
                ?>
				<td align='right'><? echo number_format($LEY1,1,',','.')."%";?>&nbsp;</td>
				<td align='right'><? echo number_format($LEY2,1,',','.')."%";?>&nbsp;</td>
				<?
				 }
				?>
				</tr>
				<tr class="FilaAbeja3">
				<td align="left">TMF</td>
				<?								
				for($i=$Mes;$i<=$MesFin;$i++)
				{	
				$LEY1=DatosPrecios($Ano,$i,'3','27');
				$LEY2=DatosPrecios($Ano,$i,'3','27');
				$varpres=DatosPrecios($Ano,$i,'3','22')/100;
				$Valor1=(1-$varpres);
				$Valor2=$Tms1*($LEY1/100);
				$TMF1=$Valor2*$Valor1;								
				$Valor3=(1-$varpres);
				$Valor4=$Tms2*($LEY2/100);					
				$TMF2=$Valor4*$Valor3;
					$ArrTMF1[$i][0]=$TMF1;
					//echo $TMF1."<br>";
					$ArrTMF2[$i][0]=$TMF2;
					//echo $TMF2."<br><br>";
				?>
				<td align='right'><? echo number_format($TMF1,3,',','.');?>&nbsp;</td>
				<td align='right'><? echo number_format($TMF2,3,',','.');?>&nbsp;</td>
				<?
				 }
				?>
				<tr class="FilaAbeja">
				<td align="left">RC</td>
				<?
				for($i=$Mes;$i<=$MesFin;$i++)
				{	
					$LEY1=DatosPrecios($Ano,$i,'3','27');
					$LEY2=DatosPrecios($Ano,$i,'3','27');
					$varpres=DatosPrecios($Ano,$i,'3','22')/100;
					$Valor1=(1-$varpres);
					$Valor2=$Tms1*($LEY1/100);
					$TMF1=$Valor2*$Valor1;								
					$Valor3=(1-$varpres);
					$Valor4=$Tms2*($LEY2/100);					
					$TMF2=$Valor4*$Valor3;
					$RCScrap=DatosPrecios($Ano,$i,'3','23');
					
					if($TMF1=='0')
					    $Rc1=0;
					else	
						$Rc1=($RCScrap*$Tms1)/$TMF1;
					if($TMF2=='0')
					    $Rc2=0;
					else						
						$Rc2=($RCScrap*$Tms2)/$TMF2;
						
					$ArrTotal1[$i][0]=$ArrTotal1[$i][0]+$Rc1;
					$ArrTotal2[$i][0]=$ArrTotal2[$i][0]+$Rc2;									
				?>
				<td align='right'><? echo number_format($Rc1,0,',','.');?>&nbsp;</td>
				<td align='right'><? echo number_format($Rc2,0,',','.');?>&nbsp;</td>
				<?
				  }
				?>
				</tr>
				<tr class="FilaAbeja3">
				<td align="left">FACTOR LOC Y FLETE</td>
				<?								
				for($i=$Mes;$i<=$MesFin;$i++)
				{	
					$LEY1=DatosPrecios($Ano,$i,'3','27');
					$LEY2=DatosPrecios($Ano,$i,'3','27');
					$varpres=DatosPrecios($Ano,$i,'3','22')/100;
					$Valor1=(1-$varpres);
					$Valor2=$Tms1*($LEY1/100);
					$TMF1=$Valor2*$Valor1;								
					$Valor3=(1-$varpres);
					$Valor4=$Tms2*($LEY2/100);					
					$TMF2=$Valor4*$Valor3;					
					//echo $Dato1;
					if($TMF1=='0')
					    $FactLocFle1=0;
					else			
						$Dato1=DatosPrecios($Ano,$i,'3','24');
						$FactLocFle1=$Dato1;
					if($TMF2=='0')
					    $FactLocFle2=0;
					else	
						$Dato2=DatosPrecios($Ano,$i,'3','24');
						$FactLocFle2=$Dato2;
						
					$ArrTotal1[$i][0]=$ArrTotal1[$i][0]+$FactLocFle1;
					$ArrTotal2[$i][0]=$ArrTotal2[$i][0]+$FactLocFle2;	
				?>
				<td align='right'><? echo number_format($FactLocFle1,0,',','.');?>&nbsp;</td>
				<td align='right'><? echo number_format($FactLocFle2,0,',','.');?>&nbsp;</td>
				<?
				 }
				?>
				</tr>
				<tr class="FilaAbeja">
				<td align="left">PREMIO</td>
				<?
				for($i=$Mes;$i<=$MesFin;$i++)
				{	
					$LEY1=DatosPrecios($Ano,$i,'3','27');
					$LEY2=DatosPrecios($Ano,$i,'3','27');
					$varpres=DatosPrecios($Ano,$i,'3','22')/100;
					$Valor1=(1-$varpres);
					$Valor2=$Tms1*($LEY1/100);
					$TMF1=$Valor2*$Valor1;								
					$Valor3=(1-$varpres);
					$Valor4=$Tms2*($LEY2/100);					
					$TMF2=$Valor4*$Valor3;									
					if($TMF1=='0')
					    $Premio1=0;
					else										
						$Premio1=DatosPrecios($Ano,$i,'3','26');
					if($TMF2=='0')
					    $Premio2=0;
					else																
						$Premio2=DatosPrecios($Ano,$i,'3','26');
						
					$ArrTotal1[$i][0]=$ArrTotal1[$i][0]+$Premio1;
					$ArrTotal2[$i][0]=$ArrTotal2[$i][0]+$Premio2;	
				?>
				<td align='right'><? echo number_format($Premio1,0,',','.');?>&nbsp;</td>
				<td align='right'><? echo number_format($Premio2,0,',','.');?>&nbsp;</td>
				<?
				 }
				?>
				</tr>
				<tr class="FilaAbeja3">
				<td align="left">TOTAL</td>
				<?
				for($i=$Mes;$i<=$MesFin;$i++)
				{		
					$Total1=$ArrTotal1[$i][0];
					$Total2=$ArrTotal2[$i][0];			
				?>
				<td align='right'><? echo number_format($Total1,0,',','.');?>&nbsp;</td>
				<td align='right'><? echo number_format($Total2,0,',','.');?>&nbsp;</td>
				<?
				 }
				?>
				</tr>
				<?
			   }
		 }  					
		 else//resumen					   
			   {					   
			   ?>
				<tr class="FilaAbeja3">
				<td align="left">Teniente</td>
				<? //Resumen Anodos, Cucons y Scrap
				for($i=$Mes;$i<=$MesFin;$i++)
				{
					$TotalTteReal=ResumenPrvScrap($Ano,$i,'3','R',$Tms1);							
					$TotalTtePpto=ResumenPrvScrap($Ano,$i,'3','P',$Tms1);
				?>
				<td align='right'><? echo number_format($TotalTteReal,0,',','.');?>&nbsp;</td>
				<td align='right'><? echo number_format($TotalTtePpto,0,',','.');?>&nbsp;</td>
				<?
				 }
				?>
				</tr>
	</tr>
	
	<? 					 
			  } 
	 }
	 ?>
	</table>
	
<?
function ResumenPrvScrap($Ano,$Mes,$CodPrv,$Tipo,$Tms1)// CALCULO TOTAL ANODOS
{
  
	$ArrTMF1=array();$ArrTotal1=array();$ArrTMH1=array();
	reset($ArrTMF1);reset($ArrTotal1);reset($ArrTMH1);
	for($i=$Mes;$i<=12;$i++)
	{
		$ArrTMF1[$Mes][0]=0;
		$ArrTotal1[$Mes][0]=0;
		$ArrTMH1[$Mes][0]=0;
	}
	$LEY1=DatosPrecios($Ano,$Mes,'3','27');
	//echo $LEY1."<br>";
	$varpres=DatosPrecios($Ano,$Mes,'3','22')/100;
	//echo $varpres."<br>";
	$Valor1=(1-$varpres);
	$Valor2=$Tms1*($LEY1/100);
	$TMF1=$Valor2*$Valor1;								
	$ArrTMF1[$Mes][0]=$TMF1;
	//echo $TMF1."<br>";

	$Dato1=DatosPrecios($Ano,$Mes,'3','24');
	if($ArrTMF1[$Mes][0]!='0')	
		$FactLocFle1=$Dato1;
	else
	    $FactLocFle1=0;
	$ArrTotal1[$Mes][0]=$ArrTotal1[$Mes][0]+$FactLocFle1;
	//echo "VALOR FactLocFle1   ".$FactLocFle1."<br>";

	$RCScrap=DatosPrecios($Ano,$Mes,'3','23');
	if($ArrTMF1[$Mes][0]!='0')		
		$Rc1=($RCScrap*$Tms1)/$ArrTMF1[$Mes][0];
	else
	    $Rc1=0;
	$ArrTotal1[$Mes][0]=$ArrTotal1[$Mes][0]+$Rc1;
	//echo "VALOR Rc1   ".$Rc1."<br>";

	if($ArrTMF1[$Mes][0]!='0')		
		$Premio1=DatosPrecios($Ano,$Mes,'3','26');
	else
	    $Premio1=0;
	$ArrTotal1[$Mes][0]=$ArrTotal1[$Mes][0]+$Premio1;
	//echo " VALOR Premio1  ".$Premio1."<br>";

	return($ArrTotal1[$Mes][0]);
}	

?>
