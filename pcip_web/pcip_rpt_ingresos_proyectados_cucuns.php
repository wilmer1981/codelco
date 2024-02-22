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
				if($CmbProductos=='1')
				{
					if($CmbDivision!='T')
				    	$Consulta.=" and cod_subclase='".$CmbDivision."' ";
					else
						$Consulta.=" and cod_subclase in('1','2','3','4','5','7')";
				}
    			$Consulta.= " group by cod_prv";	
				//echo $Consulta; 	
				$Resp=mysql_query($Consulta);
				while($Fila=mysql_fetch_array($Resp))
				{
					$NomPrv=$Fila[nom_prv];
					$CodPrv=$Fila[cod_prv];
						  ?>
					  <tr class="Formulario2">
						<td rowspan="1" colspan="25" align="left"><? 
						   echo $NomPrv;?></td>
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
								   $LEY1=DatosProyectados($CodPrv,'1',$Ano,$i,'COBRE','R')*100;
								   //echo "Valor LEY1   ".$LEY1."<br>";
								   $LEY2=DatosProyectados($CodPrv,'1',$Ano,$i,'COBRE','P')*100;	
								   //echo "Valor LEY2   ".$LEY2."<br>";
								?>
								<td align='right'><? echo number_format($LEY1,1,',','.')."%";?>&nbsp;</td>
								<td align='right'><? echo number_format($LEY2,1,',','.')."%";?>&nbsp;</td>
								<?
								 }
								?>
							  </tr>
							  <tr class="FilaAbeja3">
								<td align="left">HUMEDAD</td>
								<?
								for($i=$Mes;$i<=$MesFin;$i++)
								{		
									$Hum1=DatosProyectados($CodPrv,'1',$Ano,$i,'HUMEDAD','R')*100;
									$Hum2=DatosProyectados($CodPrv,'1',$Ano,$i,'HUMEDAD','P')*100;	
								?>
								<td align='right'><? echo number_format($Hum1,1,',','.')."%";?>&nbsp;</td>
								<td align='right'><? echo number_format($Hum2,1,',','.')."%";?>&nbsp;</td>
								<?
								 }
								?>
							  </tr>
							  <tr class="FilaAbeja">
								<td align="left">AS</td>
								<?								
								for($i=$Mes;$i<=$MesFin;$i++)
								{	
									$Arse1=DatosProyectados($CodPrv,'1',$Ano,$i,'ARS&Eacute;NICO','R')*100;
									$Arse2=DatosProyectados($CodPrv,'1',$Ano,$i,'ARS&Eacute;NICO','P')*100;					
								?>
								<td align='right'><? echo number_format($Arse1,2,',','.')."%";?>&nbsp;</td>
								<td align='right'><? echo number_format($Arse2,2,',','.')."%";?>&nbsp;</td>
								<?
								 }
								?>
							  </tr>
							  <tr class="FilaAbeja3">
								<td align="left">TMF</td>
								<?								
								for($i=$Mes;$i<=$MesFin;$i++)
								{	
									$LEY1=DatosProyectados($CodPrv,'1',$Ano,$i,'COBRE','R')*100;
									$LEY2=DatosProyectados($CodPrv,'1',$Ano,$i,'COBRE','P')*100;																																		
									$varpres=DatosPrecios($Ano,$i,'1','1')/100;
									$Valor1=(1-$varpres);
									$Valor2=$Tms1*($LEY1/100);
									$TMF1=$Valor2*$Valor1;								
									$Valor3=(1-$varpres);
									$Valor4=$Tms2*($LEY2/100);					
									$TMF2=$Valor4*$Valor3;
										$ArrTMF1[$i][0]=$TMF1;
										$ArrTMF2[$i][0]=$TMF2;//echo  $TMF1;
								?>
								<td align='right'><? echo number_format($TMF1,3,',','.');?>&nbsp;</td>
								<td align='right'><? echo number_format($TMF2,3,',','.');?>&nbsp;</td>
								<?
								 }
								?>
							  </tr>
							  <tr class="FilaAbeja">
								<td align="left">TC</td>
								<?								
								for($i=$Mes;$i<=$MesFin;$i++)
								{								
									if($ArrTMF1[$i][0]=='0' || $ArrTMF2[$i][0]=='0')
									{
									  $TC1=0;
									  $TC2=0;						
									} 
									else
									{
										$LEY1=DatosProyectados($CodPrv,'1',$Ano,$i,'COBRE','R')*100;
										$LEY2=DatosProyectados($CodPrv,'1',$Ano,$i,'COBRE','P')*100;																																		
										$varpres=DatosPrecios($Ano,$i,'1','1')/100;
										$Valor1=(1-$varpres);
										$Valor2=$Tms1*($LEY1/100);
										$ArrTMF1[$i][0]=$Valor2*$Valor1;
										$Valor3=(1-$varpres);
										$Valor4=$Tms2*($LEY2/100);					
										$ArrTMF2[$i][0]=$Valor4*$Valor3;
										
										$Valor1=DatosPrecios($Ano,$i,'1','3');
										$Valor2=($Tms1/$ArrTMF1[$i][0]);
										$TC1=$Valor1*$Valor2;	
										$Valor3=($Tms2/$ArrTMF2[$i][0]);
										$TC2=$Valor1*$Valor3;	
										$ArrTotal1[$i][0]=$ArrTotal1[$i][0]+$TC1;
										$ArrTotal2[$i][0]=$ArrTotal2[$i][0]+$TC2;
									}
								?>
								<td align='right'><? echo number_format($TC1,0,',','.');?>&nbsp;</td>
								<td align='right'><? echo number_format($TC2,0,',','.');?>&nbsp;</td>
								<?
								 }
								?>
							  </tr>
							  <tr class="FilaAbeja3">
								<td align="left">FACTOR LOC Y FLETE</td>
								<?								
								for($i=$Mes;$i<=$MesFin;$i++)
								{	
									if($ArrTMF1[$i][0]=='0' || $ArrTMF2[$i][0]=='0')
									{
									  $FactLocFle1=0;
									  $FactLocFle2=0;						
									}
									else	
									{		
										$LEY1=DatosProyectados($CodPrv,'1',$Ano,$i,'COBRE','R')*100;
										$LEY2=DatosProyectados($CodPrv,'1',$Ano,$i,'COBRE','P')*100;	
										$varpres=DatosPrecios($Ano,$i,'1','1')/100;
										$Valor1=(1-$varpres);
										$Valor2=$Tms1*($LEY1/100);
										$ArrTMF1[$i][0]=$Valor2*$Valor1;
										$Valor3=(1-$varpres);
										$Valor4=$Tms2*($LEY2/100);	
										$ArrTMF2[$i][0]=$Valor4*$Valor3;
														
										$Dato1=DatosPrecios($Ano,$i,'1','4')*$ArrTMH1[$i][0];
										$Anodo=DatosPrecios($Ano,$i,'2','14');
										$flete=DatosPrecios($Ano,$i,'1','7');
										$FactLocFle1=($Dato1+$Anodo*$ArrTMF1[$i][0]+$flete*$ArrTMF1[$i][0])/$ArrTMF1[$i][0];
										$Dato2=DatosPrecios($Ano,$i,'1','4')*$ArrTMH2[$i][0];
										$FactLocFle2=($Dato2+$Anodo*$ArrTMF2[$i][0]+$flete*$ArrTMF2[$i][0])/$ArrTMF2[$i][0];
		
											$ArrTotal1[$i][0]=$ArrTotal1[$i][0]+$FactLocFle1;
											$ArrTotal2[$i][0]=$ArrTotal2[$i][0]+$FactLocFle2;	
									 }	
								 }					
								?>
								<td align='right'><? echo number_format($FactLocFle1,0,',','.');?>&nbsp;</td>
								<td align='right'><? echo number_format($FactLocFle2,0,',','.');?>&nbsp;</td>
							  </tr>
							  <tr class="FilaAbeja">
								<td align="left">RC</td>
								<?
								for($i=$Mes;$i<=$MesFin;$i++)
								{	
									if($ArrTMF1[$i][0]=='0' || $ArrTMF2[$i][0]=='0')
									{
									  $Rc1=0;
									  $Rc2=0;						
									}
									else	
									{
										$LEY1=DatosProyectados($CodPrv,'1',$Ano,$i,'COBRE','R')*100;
										$LEY2=DatosProyectados($CodPrv,'1',$Ano,$i,'COBRE','P')*100;																																		
										$varpres=DatosPrecios($Ano,$i,'1','1')/100;
										$Valor1=(1-$varpres);
										$Valor2=$Tms1*($LEY1/100);
										$ArrTMF1[$i][0]=$Valor2*$Valor1;
										$Valor3=(1-$varpres);
										$Valor4=$Tms2*($LEY2/100);					
										$ArrTMF2[$i][0]=$Valor4*$Valor3;
										
										$Blanco=DatosPrecios($Ano,$i,'1','46');
										$RCCu=DatosPrecios($Ano,$i,'1','5');
										$Rc1=($ArrTMF1[$i][0]*$Blanco*$RCCu)/$ArrTMF1[$i][0];
										$Rc2=($ArrTMF2[$i][0]*$Blanco*$RCCu)/$ArrTMF2[$i][0];
		
											$ArrTotal1[$i][0]=$ArrTotal1[$i][0]+$Rc1;
											$ArrTotal2[$i][0]=$ArrTotal2[$i][0]+$Rc2;									
									 }
								 }											
								?>
								<td align='right'><? echo number_format($Rc1,0,',','.');?>&nbsp;</td>
								<td align='right'><? echo number_format($Rc2,0,',','.');?>&nbsp;</td>
							  </tr>
							  <tr class="FilaAbeja3">
								<td align="left">ARSENICO</td>
								<?
								for($i=$Mes;$i<=$MesFin;$i++)
								{				
									$Arse1=DatosProyectados($CodPrv,'1',$Ano,$i,'ARS&Eacute;NICO','R')*100;
									$Arse2=DatosProyectados($CodPrv,'1',$Ano,$i,'ARS&Eacute;NICO','P')*100;					
									$Penal1=DatosPreciosPena($Ano,$i,'1','9');
									$Penal2=DatosPrecios($Ano,$i,'1','9');
									$LEY1=DatosProyectados($CodPrv,'1',$Ano,$i,'COBRE','R')*100;
									$LEY2=DatosProyectados($CodPrv,'1',$Ano,$i,'COBRE','P')*100;																																		
									$varpres=DatosPrecios($Ano,$i,'1','1')/100;
									$Valor1=(1-$varpres);
									$Valor2=$Tms1*($LEY1/100);
									$TMF1=$Valor2*$Valor1;								
									$Valor3=(1-$varpres);
									$Valor4=$Tms2*($LEY2/100);					
									$TMF2=$Valor4*$Valor3;
									if($TMF1>0)
										$Arsenico1=((($Arse1-$Penal1)*100/0.1)*$Penal2)/$TMF1;
									else
										$Arsenico1=0;
									if($TMF1>0)
										$Arsenico2=((($Arse2-$Penal1)*100/0.1)*$Penal2)/$TMF2;
									else
										$Arsenico2=0;	
										$ArrTotal1[$i][0]=$ArrTotal1[$i][0]+$Arsenico1;
										$ArrTotal2[$i][0]=$ArrTotal2[$i][0]+$Arsenico2;
								?>
								<td align='right'><? echo number_format($Arsenico1,2,',','.');?>&nbsp;</td>
								<td align='right'><? echo number_format($Arsenico2,2,',','.');?>&nbsp;</td>
								<?
								 }
								?>
							  </tr>
							  <tr class="FilaAbeja">
								<td align="left">PREMIO</td>
								<?
								for($i=$Mes;$i<=$MesFin;$i++)
								{	
									if($ArrTMF1[$i][0]=='0' || $ArrTMF2[$i][0]=='0')
									{
									  $Premio1=0;
									  $Premio2=0;						
									}
									else	
									{
										$Premio1=DatosPrecios($Ano,$i,'1','6');
										$Premio2=DatosPrecios($Ano,$i,'1','6');
										$ArrTotal1[$i][0]=$ArrTotal1[$i][0]+$Premio1;
										$ArrTotal2[$i][0]=$ArrTotal2[$i][0]+$Premio2;	
									}
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
									$ArrTotal1[$i][0]=0;
									$ArrTotal2[$i][0]=0;
								 }
								?>
							  </tr>
							  <?
						   }
					 }  					
					 else//RESUMEN				   
						   {					   
						   ?>
						  <tr class="FilaAbeja">
							<td align="left">Enami, cucons</td>
							<?
								for($i=$Mes;$i<=$MesFin;$i++)
								{	
									$TotalEnamiReal=ResumenPrv($Ano,$i,'1','R',$Tms1);							
									$TotalEnamiPpto=ResumenPrv($Ano,$i,'1','P',$Tms1);
								?>
								<td align='right'><? echo number_format($TotalEnamiReal,0,',','.');?>&nbsp;</td>
								<td align='right'><? echo number_format($TotalEnamiPpto,0,',','.');?>&nbsp;</td>
								<?
								 }
								?>
							  </tr>
							  <tr class="FilaAbeja3">
								<td align="left">Enami, precipitados</td>
								<?
								for($i=$Mes;$i<=$MesFin;$i++)
								{	
									$TotalEnamiPrecipReal=ResumenPrv($Ano,$i,'7','R',$Tms1);																
									$TotalEnamiPrecipPpto=ResumenPrv($Ano,$i,'7','P',$Tms1);
								?>
								<td align='right'><? echo number_format($TotalEnamiPrecipReal,0,',','.');?>&nbsp;</td>
								<td align='right'><? echo number_format($TotalEnamiPrecipPpto,0,',','.');?>&nbsp;</td>
								<?
								 }
								?>
							  </tr>
							  <tr class="FilaAbeja">
								<td align="left">Sur Andes</td>
								<? 
								for($i=$Mes;$i<=$MesFin;$i++)
								{	
									$TotalSurAndesReal=ResumenPrv($Ano,$i,'2','R',$Tms1);							
									$TotalSurAndesPpto=ResumenPrv($Ano,$i,'2','P',$Tms1);
								?>
								<td align='right'><? echo number_format($TotalSurAndesReal,0,',','.');?>&nbsp;</td>
								<td align='right'><? echo number_format($TotalSurAndesPpto,0,',','.');?>&nbsp;</td>
								<?
								 }
								?>							  
							  </tr>
							  <tr class="FilaAbeja3">
								<td align="left">Teniente</td>
								<? 
								for($i=$Mes;$i<=$MesFin;$i++)
								{
									$TotalTteReal=ResumenPrv($Ano,$i,'3','R',$Tms1);							
									$TotalTtePpto=ResumenPrv($Ano,$i,'3','P',$Tms1);
									//echo $TotalTtePpto;
								?>
								<td align='right'><? echo number_format($TotalTteReal,0,',','.');?>&nbsp;</td>
								<td align='right'><? echo number_format($TotalTtePpto,0,',','.');?>&nbsp;</td>
								<?
								 }
								?>
							  </tr>
							  <tr class="FilaAbeja">
								<td align="left">Andina</td>
								<?
								for($i=$Mes;$i<=$MesFin;$i++)
								{									
									$TotalAndinaReal=ResumenPrv($Ano,$i,'4','R',$Tms1);							
									$TotalAndinaPpto=ResumenPrv($Ano,$i,'4','P',$Tms1);
								?>
								<td align='right'><? echo number_format($TotalAndinaReal,0,',','.');?>&nbsp;</td>
								<td align='right'><? echo number_format($TotalAndinaPpto,0,',','.');?>&nbsp;</td>
								<?
								 }
								?>
							  </tr>
							  <tr class="FilaAbeja3">
								<td align="left">Codelco Norte</td>
								<?
								for($i=$Mes;$i<=$MesFin;$i++)
								{									
									$TotalCNReal=ResumenPrv($Ano,$i,'5','R',$Tms1);							
									$TotalCNPpto=ResumenPrv($Ano,$i,'5','P',$Tms1);
								?>
								<td align='right'><? echo number_format($TotalCNReal,0,',','.');?>&nbsp;</td>
								<td align='right'><? echo number_format($TotalCNPpto,0,',','.');?>&nbsp;</td>
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
function ResumenPrv($Ano,$Mes,$CodPrv,$Tipo,$Tms1)// CALCULO TOTAL CUCONS
{
  
	$ArrTMF1=array();$ArrTotal1=array();$ArrTMH1=array();
	reset($ArrTMF1);reset($ArrTotal1);reset($ArrTMH1);
	for($i=$Mes;$i<=12;$i++)
	{
		$ArrTMF1[$Mes][0]=0;
		$ArrTotal1[$Mes][0]=0;
		$ArrTMH1[$Mes][0]=0;
	}
	$LEY1=DatosProyectados($CodPrv,'1',$Ano,$Mes,'COBRE',$Tipo)*100;
	$varpres=DatosPrecios($Ano,$Mes,'1','1')/100;
	$Valor1=(1-$varpres);
	$Valor2=$Tms1*($LEY1/100);
	$ArrTMF1[$Mes][0]=$Valor2*$Valor1;
	//echo "primer valor ".$ArrTMF1[$Mes][0]."<br>";

	$Valor1=DatosPrecios($Ano,$Mes,'1','3');
	if($ArrTMF1[$Mes][0]!=0)
		$Valor2=($Tms1/$ArrTMF1[$Mes][0]);
	else
		$Valor2=0;
	$TC1=$Valor1*$Valor2;	
	$ArrTotal1[$Mes][0]=$ArrTotal1[$Mes][0]+$TC1;
	//echo "Valor Tc1  ".$TC1."<br>";
	//echo "VALOR ARREGLO TOTAL  ".$ArrTotal1[$Mes][0]."<br>";
	$Hum1=DatosProyectados($CodPrv,'1',$Ano,$Mes,'HUMEDAD',$Tipo)*100;
	//echo "VALOR HUMEDAD  ".$Hum1."<br>";
	//echo "VALOR HUMEDAD DATOS PROYECTADOS   ".(DatosProyectados($CodPrv,'1',$Ano,$Mes,'HUMEDAD',$Tipo)*100)."<br>";
	$Valor1=$Tms1;
	$Um=$Hum1/100;
	//echo "Valor UM  ".$Um."<br>";
	$Valor2=(1-$Um);
	$TMH1=$Valor1/$Valor2;
	//echo "TMH  ".$TMH1."<br>";
	$ArrTMH1[$Mes][0]=$TMH1;
	//echo "ARREGLOR TMH  ".$ArrTMH1[$Mes][0]."<br>";
	

	//echo $ArrTMH1[$Mes][0]."<br>";
	$Dato1=DatosPrecios($Ano,$Mes,'1','4')*$ArrTMH1[$Mes][0];
	$Anodo=DatosPrecios($Ano,$Mes,'2','14');
	$flete=DatosPrecios($Ano,$Mes,'1','7');
	
	if($ArrTMF1[$Mes][0]!=0)	
		$FactLocFle1=($Dato1+$Anodo*$ArrTMF1[$Mes][0]+$flete*$ArrTMF1[$Mes][0])/$ArrTMF1[$Mes][0];
	else
		$FactLocFle1=0;
	$ArrTotal1[$Mes][0]=$ArrTotal1[$Mes][0]+$FactLocFle1;
	//echo "FACTOR FLETE  ".$FactLocFle1."<br>";
	
	$Blanco=DatosPrecios($Ano,$Mes,'1','46');
	$RCCu=DatosPrecios($Ano,$Mes,'1','5');
	if($ArrTMF1[$Mes][0]!=0)
		$Rc1=($ArrTMF1[$Mes][0]*$Blanco*$RCCu)/$ArrTMF1[$Mes][0];
	else
		$Rc1=0;
	$ArrTotal1[$Mes][0]=$ArrTotal1[$Mes][0]+$Rc1;
	if($ArrTMF1[$Mes][0]!='0')
		$Premio1=DatosPrecios($Ano,$Mes,'1','6');
	else
		$Premio1=0;
	$ArrTotal1[$Mes][0]=$ArrTotal1[$Mes][0]+$Premio1;
	//echo "TOTAL    ".$ArrTotal1[$Mes][0]."<br><br><br>";

	return($ArrTotal1[$Mes][0]);

}

function ResumenPrvAnodo($Ano,$Mes,$CodPrv,$Tipo,$Tms1)// CALCULO TOTAL ANODOS
{
  
	$ArrTMF1=array();$ArrTotal1=array();$ArrTMH1=array();
	reset($ArrTMF1);reset($ArrTotal1);reset($ArrTMH1);
	for($i=$Mes;$i<=12;$i++)
	{
		$ArrTMF1[$Mes][0]=0;
		$ArrTotal1[$Mes][0]=0;
		$ArrTMH1[$Mes][0]=0;
	}
	//TMF. 
	$LEY1=DatosProyectados($CodPrv,'3',$Ano,$Mes,'COBRE','R')*100;																																	
	$varpres=DatosPrecios($Ano,$Mes,'2','12')/100;
	$Valor1=(1-$varpres);
	$Valor2=$Tms1*($LEY1/100);
	//echo "Valor TMS   ".$Tms1."<br>";
	$TMF1=$Valor2*$Valor1;								
	$ArrTMF1[$Mes][0]=$TMF1;
	//echo "Valor TMF1   ".$TMF1."<br>";

    //FactLocFle
	$Dato1=DatosPrecios($Ano,$Mes,'2','14');
	if($ArrTMF1[$Mes][0]!='0')	
		$FactLocFle1=$Dato1;
	else
	    $FactLocFle1=0;
	$ArrTotal1[$Mes][0]=$ArrTotal1[$Mes][0]+$FactLocFle1;
	//echo "VALOR FactLocFle1   ".$FactLocFle1."<br>";

    //Rc1
	$RCAnodos=DatosPrecios($Ano,$Mes,'2','16');
	//echo "Valor RCAnodos   ".$RCAnodos."<br>";
	if($ArrTMF1[$Mes][0]!='0')	
		$Rc1=($RCAnodos*$Tms1)/$ArrTMF1[$Mes][0];
	else
	    $Rc1=0;
	$ArrTotal1[$Mes][0]=$ArrTotal1[$Mes][0]+$Rc1;
	//echo "VALOR Rc1   ".$Rc1."<br>";

    //Premio
	if($ArrTMF1[$Mes][0]!='0')	
		$Premio1=DatosPrecios($Ano,$Mes,'2','19');
	else
	    $Premio1=0;
	$ArrTotal1[$Mes][0]=$ArrTotal1[$Mes][0]+$Premio1;
	//echo " VALOR Premio1  ".$Premio1."<br>";
	//echo "Valor Premio1   ".$Premio1."<br>";
	
	return($ArrTotal1[$Mes][0]);
	//echo $ArrTotal1[$Mes][0]."<br>";
}

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
