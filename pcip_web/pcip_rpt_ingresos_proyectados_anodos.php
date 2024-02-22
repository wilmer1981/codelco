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
				if($CmbProductos=='2')
				{
					if($CmbDivision!='T')
				    	$Consulta.=" and cod_subclase='".$CmbDivision."' ";
					else
						$Consulta.=" and cod_subclase in('1','2','3','8')";
				}
    			$Consulta.= " group by cod_prv";	
				//echo $Consulta; 	
				$Resp=mysql_query($Consulta);
				while($Fila=mysql_fetch_array($Resp))
				{
					$NomPrv=$Fila[nom_prv];
					$CodPrv=$Fila[cod_prv];
					for($i=$Mes;$i<=$MesFin;$i++)
					{		
					$ArrTotal1[$i][0]=0;
					$ArrTotal2[$i][0]=0;
					}					
				?>
				<tr class="Formulario2">
				<td rowspan="1" colspan="25" align="left"><? echo $NomPrv;?></td>
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
							   if($CodPrv=='1'||$CodPrv=='2'||$CodPrv=='3')
							   {									       
								   $LEY1=DatosProyectados($CodPrv,'3',$Ano,$i,'COBRE','R')*100;
								   //echo "Valor LEY1 area 3   ".$LEY1."<br>";
								   $LEY2=DatosProyectados($CodPrv,'3',$Ano,$i,'COBRE','P')*100;	
								   //echo "Valor LEY2 area 3   ".$LEY2."<br>";
							   }
							   if($CodPrv=='7' || $CodPrv=='8' ||$CodPrv=='9')
							   {   
								   $LEY1=DatosProyectados($CodPrv,'2',$Ano,$i,'COBRE','R')*100;
								   //echo "Valor LEY1 area 2   ".$LEY1."<br>";
								   $LEY2=DatosProyectados($CodPrv,'2',$Ano,$i,'COBRE','P')*100;	
								   //echo "Valor LEY2 area 2   ".$LEY2."<br>";
							   }
							   //echo "Valor LEY2  ".$LEY2."<br>";								    
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
							       $LEY1=0;$LEY2=0;
								   if($CodPrv=='1'||$CodPrv=='2'||$CodPrv=='3')
								   {
									   $LEY1=DatosProyectados($CodPrv,'3',$Ano,$i,'COBRE','R')*100;
									   //echo "Valor TMF1   ".$LEY1."<br>";
									   $LEY2=DatosProyectados($CodPrv,'3',$Ano,$i,'COBRE','P')*100;	
									   //echo "Valor TMF2   ".$LEY2."<br>";
								   }
								   if($CodPrv=='8' ||$CodPrv=='9')
								   {
									   $LEY1=DatosProyectados($CodPrv,'2',$Ano,$i,'COBRE','R')*100;
									   //echo "Valor LEY1   ".$LEY1."<br>";
									   $LEY2=DatosProyectados($CodPrv,'2',$Ano,$i,'COBRE','P')*100;	
								   }
									$varpres=DatosPrecios($Ano,$i,'2','12')/100;
									$Valor1=(1-$varpres);
									$Valor2=$Tms1*($LEY1/100);
									$TMF1=$Valor2*$Valor1;								
									$Valor3=(1-$varpres);
									$Valor4=$Tms2*($LEY2/100);					
									$TMF2=$Valor4*$Valor3;
										$ArrTMF1[$i][0]=$TMF1;
										//echo "Valor TMF1   ".$TMF1."<br>";
										$ArrTMF2[$i][0]=$TMF2;//echo  $TMF1;
										//echo "Valor TMF2   ".$TMF2."<br>";
							?>
							<td align='right'><? echo number_format($TMF1,3,',','.');?>&nbsp;</td>
							<td align='right'><? echo number_format($TMF2,3,',','.');?>&nbsp;</td>
							<?
							 }
							?>
						  </tr>
							  <tr class="FilaAbeja">
								<td align="left">RC</td>
								<?
								for($i=$Mes;$i<=$MesFin;$i++)
								{	
									   $LEY1=0;$LEY2=0;$RCAnodos=0;						
									   if($CodPrv=='1'||$CodPrv=='2'||$CodPrv=='3')
									   {
										   $LEY1=DatosProyectados($CodPrv,'3',$Ano,$i,'COBRE','R')*100;
										   //echo "Valor LEY1   ".$LEY1."<br>";
										   $LEY2=DatosProyectados($CodPrv,'3',$Ano,$i,'COBRE','P')*100;	
										   $RCAnodos=DatosPrecios($Ano,$i,'2','16');
											$varpres=DatosPrecios($Ano,$i,'2','12')/100;
											$Valor1=(1-$varpres);
											$Valor2=$Tms1*($LEY1/100);
											$TMF1=$Valor2*$Valor1;
											$Valor3=(1-$varpres);
											$Valor4=$Tms2*($LEY2/100);	
											$TMF2=$Valor4*$Valor3;
										   //echo	"RCANODOS COD. 1,2,3     ".$RCAnodos."<br>";
											if($TMF1=='0')
											    $Rc1=0;
											else	
												$Rc1=($RCAnodos*$Tms1)/$TMF1;
											if($TMF2=='0')
											    $Rc2=0;						
											else	
												$Rc2=($RCAnodos*$Tms2)/$TMF2;										   									   																			   										}
									   if($CodPrv=='7' || $CodPrv=='8' ||$CodPrv=='9')
									   {
										   $LEY1=DatosProyectados($CodPrv,'2',$Ano,$i,'COBRE','R')*100;
										   //echo "Valor LEY1 opcion 2   ".$LEY1."<br>";
										   $LEY2=DatosProyectados($CodPrv,'2',$Ano,$i,'COBRE','P')*100;
										   //echo "Valor LEY2 opcion 2   ".$LEY2."<br>";
										   $RCAnodos=DatosPrecios($Ano,$i,'2','13');
											$varpres=DatosPrecios($Ano,$i,'2','12')/100;
											$Valor1=(1-$varpres);
											$Valor2=$Tms1*($LEY1/100);
											$TMF1=$Valor2*$Valor1;
											$Valor3=(1-$varpres);
											$Valor4=$Tms2*($LEY2/100);	
											$TMF2=$Valor4*$Valor3;
											if($TMF1=='0')
											    $Rc1=0;
											else	
												$Rc1=($RCAnodos*$Tms1)/$TMF1;
											if($TMF2=='0')
											    $Rc2=0;						
											else	
												$Rc2=($RCAnodos*$Tms2)/$TMF2;										   									   																							   										}		
										$ArrTotal1[$i][0]=$ArrTotal1[$i][0]+$Rc1;
										//echo "VALOR RC  1     ".$Rc1."<br>";
										$ArrTotal2[$i][0]=$ArrTotal2[$i][0]+$Rc2;
										//echo "VALOR RC  2     ".$Rc2."<br>";									
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
									   $LEY1=0;$LEY2=0;
									   if($CodPrv=='1'||$CodPrv=='2'||$CodPrv=='3')
									   {
										   $LEY1=DatosProyectados($CodPrv,'3',$Ano,$i,'COBRE','R')*100;
										   //echo "Valor FactLocFle1   ".$LEY1."<br>";
										   $LEY2=DatosProyectados($CodPrv,'3',$Ano,$i,'COBRE','P')*100;	
										   //echo "Valor FactLocFle2   ".$LEY2."<br>";
									   }
									   if($CodPrv=='8'||$CodPrv=='9')
									   {
										   $LEY1=DatosProyectados($CodPrv,'2',$Ano,$i,'COBRE','R')*100;
										   //echo "Valor LEY1   ".$LEY1."<br>";
										   $LEY2=DatosProyectados($CodPrv,'2',$Ano,$i,'COBRE','P')*100;	
									   }
										$varpres=DatosPrecios($Ano,$i,'2','12')/100;
										$Valor1=(1-$varpres);
										$Valor2=$Tms1*($LEY1/100);
										$TMF1=$Valor2*$Valor1;
										$Valor3=(1-$varpres);
										$Valor4=$Tms2*($LEY2/100);	
										$TMF2=$Valor4*$Valor3;
										if($TMF1=='0')
										   $FactLocFle1=0;
										else	
										{		
											$Dato1=DatosPrecios($Ano,$i,'2','14');
											$FactLocFle1=$Dato1;
										}
										if($TMF2=='0')
										  $FactLocFle2=0;						
										else	
										{		
											$Dato2=DatosPrecios($Ano,$i,'2','14');
											$FactLocFle2=$Dato2;
										}
										$ArrTotal1[$i][0]=$ArrTotal1[$i][0]+$FactLocFle1;
										//echo "VALOR FACTOR FLETE  1     ".$FactLocFle1."<br>";
										$ArrTotal2[$i][0]=$ArrTotal2[$i][0]+$FactLocFle2;
										//echo "VALOR FACTOR FLETE  2     ".$FactLocFle2."<br>";	
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
						        	   $Premio2=0;								
									   if($CodPrv=='1'||$CodPrv=='2'||$CodPrv=='3')
									   {
									        $LEY1=0;$LEY2=0;
										    $LEY1=DatosProyectados($CodPrv,'3',$Ano,$i,'COBRE','R')*100;
										   //echo "Valor FactLocFle1   ".$LEY1."<br>";
										    $LEY2=DatosProyectados($CodPrv,'3',$Ano,$i,'COBRE','P')*100;	
											//echo "Valor LEY2 opcion 2   ".$LEY2."<br>";
											$RCAnodos=DatosPrecios($Ano,$i,'2','13');
											$varpres=DatosPrecios($Ano,$i,'2','12')/100;
											//echo "Varpres     ".$varpres."<br>";
											$Valor1=(1-$varpres);
											//echo "VALOR 1       ".$Valor1."<br>";
											$Valor2=$Tms1*($LEY1/100);
											//echo "LEY     ".$LEY1."<br>";
											//echo "VALOR 2       ".$Valor2."<br>";
											$TMF1=$Valor2*$Valor1;
											//echo $TMF1."<br>";
											$Valor3=(1-$varpres);
											$Valor4=$Tms2*($LEY2/100);	
											$TMF2=$Valor4*$Valor3;
											if($TMF1=='0')
												$Premio1=0;	
											else
												$Premio1=DatosPrecios($Ano,$i,'2','19');
												
											if($TMF2=='0')
												$Premio2=0;	
											else						 														
												$Premio2=DatosPrecios($Ano,$i,'2','19');
												//echo "ENTROOO   2   ".$Premio2."<br>";
									   }	
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
									//echo "TOTAL PROVEEDORES   1   ".$Total1."<br>";
									$Total2=$ArrTotal2[$i][0];			
									//echo "TOTAL PROVEEDORES   2   ".$Total2."<br>";
								?>
								<td align='right'><? echo number_format($Total1,0,',','.');?>&nbsp;</td>
								<td align='right'><? echo number_format($Total2,0,',','.');?>&nbsp;</td>
								<?
								 }
								?>
					  </tr>
					  <?
			           }
					   //PROVEEDORES EN DURO
						for($i=$Mes;$i<=$MesFin;$i++)
						{		
						$ArrTotal1[$i][0]=0;
						$ArrTotal2[$i][0]=0;
						}	
						  if($CmbDivision=='2' || $CmbDivision=='T')	
						  {			
							  ?>						  				  
							<tr class="Formulario2">
							<td rowspan="1" colspan="25" align="left">Sur Andes, Ánodos (cátodos rechazados: láminas y despuntes)</td>
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
								$LEY1=0;$LEY2=0;							
								for($i=$Mes;$i<=$MesFin;$i++)
								{		
									 $LEY1=DatosProyectados('2','3',$Ano,$i,'COBRE','R')*100;
									 $LEY2=DatosProyectados('3','3',$Ano,$i,'COBRE','P')*100;	
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
									$LEY1=0;$LEY2=0;							
									for($i=$Mes;$i<=$MesFin;$i++)
									{	
										$LEY1=DatosProyectados('2','3',$Ano,$i,'COBRE','R')*100;
										$LEY2=DatosProyectados('3','3',$Ano,$i,'COBRE','P')*100;	
										
										$varpres=DatosPrecios($Ano,$i,'2','12')/100;
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
										<td align="left">RC</td>
										<?
										for($i=$Mes;$i<=$MesFin;$i++)
										{	
										   $LEY1=0;$LEY2=0;$RCAnodos=0;						
											$LEY1=DatosProyectados('2','3',$Ano,$i,'COBRE','R')*100;
											$LEY2=DatosProyectados('3','3',$Ano,$i,'COBRE','P')*100;	
		
											$RCAnodos=DatosPrecios($Ano,$i,'2','16');
											$varpres=DatosPrecios($Ano,$i,'2','12')/100;
											$Valor1=(1-$varpres);
											$Valor2=$Tms1*($LEY1/100);
											$TMF1=$Valor2*$Valor1;
											$Valor3=(1-$varpres);
											$Valor4=$Tms2*($LEY2/100);	
											$TMF2=$Valor4*$Valor3;
										   //echo	"RCANODOS COD. 1,2,3     ".$RCAnodos."<br>";
											if($TMF1=='0')
												$Rc1=0;
											else	
												$Rc1=($RCAnodos*$Tms1)/$TMF1;
											if($TMF2=='0')
												$Rc2=0;						
											else	
												$Rc2=($RCAnodos*$Tms2)/$TMF2;										   									   										   								   
											$ArrTotal11[$i][0]=$ArrTotal11[$i][0]+$Rc1;
											$ArrTotal22[$i][0]=$ArrTotal22[$i][0]+$Rc2;									
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
									   $LEY1=0;$LEY2=0;						
										for($i=$Mes;$i<=$MesFin;$i++)
										{	
											$LEY1=DatosProyectados('2','3',$Ano,$i,'COBRE','R')*100;
											$LEY2=DatosProyectados('3','3',$Ano,$i,'COBRE','P')*100;	
		
											$varpres=DatosPrecios($Ano,$i,'2','12')/100;
											$Valor1=(1-$varpres);
											$Valor2=$Tms1*($LEY1/100);
											$TMF1=$Valor2*$Valor1;
											$Valor3=(1-$varpres);
											$Valor4=$Tms2*($LEY2/100);	
											$TMF2=$Valor4*$Valor3;
											if($TMF1=='0')
											   $FactLocFle1=0;
											else	
											{		
												$Dato1=DatosPrecios($Ano,$i,'2','14');
												$FactLocFle1=$Dato1;
											}
											if($TMF2=='0')
											  $FactLocFle2=0;						
											else	
											{		
												$Dato2=DatosPrecios($Ano,$i,'2','14');
												$FactLocFle2=$Dato2;
											}
											$ArrTotal11[$i][0]=$ArrTotal11[$i][0]+$FactLocFle1;
											$ArrTotal22[$i][0]=$ArrTotal22[$i][0]+$FactLocFle2;	
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
										   $LEY1=0;$LEY2=0;
											$LEY1=DatosProyectados('2','3',$Ano,$i,'COBRE','R')*100;
											$LEY2=DatosProyectados('3','3',$Ano,$i,'COBRE','P')*100;	
											$RCAnodos=DatosPrecios($Ano,$i,'2','13');
											$varpres=DatosPrecios($Ano,$i,'2','12')/100;
											$Valor1=(1-$varpres);
											$Valor2=$Tms1*($LEY1/100);
											$TMF1=$Valor2*$Valor1;
											$Valor3=(1-$varpres);
											$Valor4=$Tms2*($LEY2/100);	
											$TMF2=$Valor4*$Valor3;
											if($TMF1=='0')
												$Premio1=0;	
											else						 		
												$Premio1=DatosPrecios($Ano,$i,'2','20');
											if($TMF2=='0')
												$Premio2=0;	
											else						 														
												$Premio2=DatosPrecios($Ano,$i,'2','20');
		
											$ArrTotal11[$i][0]=$ArrTotal11[$i][0]+$Premio1;
											$ArrTotal22[$i][0]=$ArrTotal22[$i][0]+$Premio2;								   
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
											$Total1=$ArrTotal11[$i][0];
											//echo "TOTAL NUMERO 1 SUR ANDES FIJO     ".$Total1."<br>";
											$Total2=$ArrTotal22[$i][0];	
											//echo "TOTAL NUMERO 2 SUR ANDES FIJO     ".$Total2."<br><br>";		
										?>
										<td align='right'><? echo number_format($Total1,0,',','.');?>&nbsp;</td>
										<td align='right'><? echo number_format($Total2,0,',','.');?>&nbsp;</td>
										<?
										 }
										?>
							  </tr>
							<tr class="Formulario2">
							<td rowspan="1" colspan="25" align="left">Sur Andes, Ánodos (cátodos estándar)</td>
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
									 $LEY1=DatosProyectados('2','3',$Ano,$i,'COBRE','R')*100;
									 $LEY2=DatosProyectados('3','3',$Ano,$i,'COBRE','P')*100;	
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
									   $LEY1=0;$LEY2=0;
										$LEY1=DatosProyectados('2','3',$Ano,$i,'COBRE','R')*100;
										$LEY2=DatosProyectados('3','3',$Ano,$i,'COBRE','P')*100;	
										
										$varpres=DatosPrecios($Ano,$i,'2','12')/100;
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
										<td align="left">RC</td>
										<?
										for($i=$Mes;$i<=$MesFin;$i++)
										{	
										   $LEY1=0;$LEY2=0;$RCAnodos=0;						
											$LEY1=DatosProyectados('2','3',$Ano,$i,'COBRE','R')*100;
											$LEY2=DatosProyectados('3','3',$Ano,$i,'COBRE','P')*100;	
		
											$RCAnodos=DatosPrecios($Ano,$i,'2','16');
											$varpres=DatosPrecios($Ano,$i,'2','12')/100;
											$Valor1=(1-$varpres);
											$Valor2=$Tms1*($LEY1/100);
											$TMF1=$Valor2*$Valor1;
											$Valor3=(1-$varpres);
											$Valor4=$Tms2*($LEY2/100);	
											$TMF2=$Valor4*$Valor3;
										   //echo	"RCANODOS COD. 1,2,3     ".$RCAnodos."<br>";
											if($TMF1=='0')
												$Rc1=0;
											else	
												$Rc1=($RCAnodos*$Tms1)/$TMF1;
											if($TMF2=='0')
												$Rc2=0;						
											else	
												$Rc2=($RCAnodos*$Tms2)/$TMF2;										   									   										   								   
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
										   $LEY1=0;$LEY2=0;
											$LEY1=DatosProyectados('2','3',$Ano,$i,'COBRE','R')*100;
											$LEY2=DatosProyectados('3','3',$Ano,$i,'COBRE','P')*100;	
		
											$varpres=DatosPrecios($Ano,$i,'2','12')/100;
											$Valor1=(1-$varpres);
											$Valor2=$Tms1*($LEY1/100);
											$TMF1=$Valor2*$Valor1;
											$Valor3=(1-$varpres);
											$Valor4=$Tms2*($LEY2/100);	
											$TMF2=$Valor4*$Valor3;
											if($TMF1=='0')
											   $FactLocFle1=0;
											else	
											{		
												$Dato1=DatosPrecios($Ano,$i,'2','14');
												$FactLocFle1=$Dato1;
											}
											if($TMF2=='0')
											  $FactLocFle2=0;						
											else	
											{		
												$Dato2=DatosPrecios($Ano,$i,'2','14');
												$FactLocFle2=$Dato2;
											}
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
										   $LEY1=0;$LEY2=0;
											$LEY1=DatosProyectados('2','3',$Ano,$i,'COBRE','R')*100;
											$LEY2=DatosProyectados('3','3',$Ano,$i,'COBRE','P')*100;	
											$RCAnodos=DatosPrecios($Ano,$i,'2','13');
											$varpres=DatosPrecios($Ano,$i,'2','12')/100;
											$Valor1=(1-$varpres);
											$Valor2=$Tms1*($LEY1/100);
											$TMF1=$Valor2*$Valor1;
											$Valor3=(1-$varpres);
											$Valor4=$Tms2*($LEY2/100);	
											$TMF2=$Valor4*$Valor3;
											if($TMF1=='0')
												$Premio1=0;	
											else						 		
												$Premio1=DatosPrecios($Ano,$i,'2','21');
											if($TMF2=='0')
												$Premio2=0;	
											else						 														
												$Premio2=DatosPrecios($Ano,$i,'2','21');
		
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
					  <tr class="FilaAbeja">
						<td align="left">Enami</td>
						<? 
						for($i=$Mes;$i<=$MesFin;$i++)
						{	
							$TotalEnamiReal=ResumenPrvAnodo($Ano,$i,'1','R',$Tms1);							
							$TotalEnamiPpto=ResumenPrvAnodo($Ano,$i,'1','P',$Tms1);
						?>
						<td align='right'><? echo number_format($TotalEnamiReal,0,',','.');?>&nbsp;</td>
						<td align='right'><? echo number_format($TotalEnamiPpto,0,',','.');?>&nbsp;</td>
						<?
						 }
						?>
					  </tr>
					  <tr class="FilaAbeja">
						<td align="left">Sur Andes</td>
						<? 
						for($i=$Mes;$i<=$MesFin;$i++)
						{	
							if($CmbProductos=='1')
							{								
							$TotalSurAndesReal=ResumenPrv($Ano,$i,'2','R',$Tms1);							
							$TotalSurAndesPpto=ResumenPrv($Ano,$i,'2','P',$Tms1);
							}
							if($CmbProductos=='2')
							{								
							$TotalSurAndesReal=ResumenPrvAnodo($Ano,$i,'2','R',$Tms1);							
							$TotalSurAndesPpto=ResumenPrvAnodo($Ano,$i,'2','P',$Tms1);
							}
							
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
							if($CmbProductos=='1')
							{									
							$TotalTteReal=ResumenPrv($Ano,$i,'3','R',$Tms1);							
							$TotalTtePpto=ResumenPrv($Ano,$i,'3','P',$Tms1);
							}
							if($CmbProductos=='2')
							{
							$TotalTteReal=ResumenPrvAnodo($Ano,$i,'3','R',$Tms1);							
							$TotalTtePpto=ResumenPrvAnodo($Ano,$i,'3','P',$Tms1);
							}
							if($CmbProductos=='3')
							{
							$TotalTteReal=ResumenPrvScrap($Ano,$i,'3','R',$Tms1);							
							$TotalTtePpto=ResumenPrvScrap($Ano,$i,'3','P',$Tms1);
							}
						?>
						<td align='right'><? echo number_format($TotalTteReal,0,',','.');?>&nbsp;</td>
						<td align='right'><? echo number_format($TotalTtePpto,0,',','.');?>&nbsp;</td>
						<?
						 }
						?>
					  </tr>
					  <tr class="FilaAbeja3">
						<td align="left">Salvador Blister</td>
						<? 
						for($i=$Mes;$i<=$MesFin;$i++)
						{	
															
							$TotalSBReal=ResumenPrvAnodo($Ano,$i,'5','R',$Tms1);							
							$TotalSBPpto=ResumenPrvAnodo($Ano,$i,'5','R',$Tms1);
						?>
						<td align='right'><? echo number_format($TotalSBReal,0,',','.');?>&nbsp;</td>
						<td align='right'><? echo number_format($TotalSBPpto,0,',','.');?>&nbsp;</td>
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

?>
