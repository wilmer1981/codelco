<?php 
	header("Content-Type:  application/vnd.ms-excel");
	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	include("../principal/conectar_ref_web.php");

	 if (!isset($DiaIni))
	{
		$DiaIni = date("d");
		$MesIni = date("m");
		$AnoIni = date("Y");
		$DiaFin = date("d");
		$MesFin = date("m");
		$AnoFin = date("Y");
	}
	if ($DiaIni < 10)
		$DiaIni = "0".$DiaIni;
	if ($MesIni < 10)
		$MesIni = "0".$MesIni;
	if ($DiaFin < 10)
		$DiaFin = "0".$DiaFin;
	if ($MesFin < 10)
		$MesFin = "0".$MesFin;
 //	$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
//	$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;
	
	?>
		
<HTML>
<HEAD>
      <TITLE> Informe Semanal Planta Tratamiento Electrolito</TITLE>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">	  	  
<script language="JavaScript">
function Imprimir(f)
{
	window.print();
}
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=10&Nivel=1&CodPantalla=7";
}
/***************/
function Proceso(f)
{
	var f = document.frmPrincipal;
	f.action = "informe_pte_02.php?proceso=C";
	f.submit();
}
function Excel()

{
	var  f=document.frmPrincipal;
	var FechaInicio=f.AnoIni.value+'-'+f.MesIni.value+'-'+f.DiaIni.value;
	var FechaTermino=f.AnoFin.value+'-'+f.MesFin.value+'-'+f.DiaFin.value;
	var txt_turno=f.txt_turno.value;
	var txt_turno1=f.txt_turno1.value;
	
	
	document.location ="Informe_pte_02_xls.php?Proceso=C&FechaInicio="+FechaInicio+"&FechaTermino="+FechaTermino+"&txt_turno="+txt_turno+"&txt_turno1="+txt_turno1+"&proceso=C";
}
/**********/
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></HEAD>
<BODY background="../principal/imagenes/fondo3.gif" >
<FORM name="frmPrincipal" action="" method="post">

 
          <p align="center"><font color="#0000FF"><strong>Informe Operacion Planta 
            Tratamiento Electrolito</font><font color="#0000FF" size="1"> 
           </p>
          
        
    
          
	<table width="969" height="62" border="0" cellpadding="0" cellspacing="0">
    	<tr> 
    		<td width="74" rowspan="4"><div align="center">fecha</div></td>
        	<td width="700" height="25"><div align="center">N&deg;Lixiviaciones</div></td>
        	<td height="70" colspan="5"><div align="center">Produccion</div></td>
    	</tr>
    	<tr> 
    		<td width="200" height="13"> <div align="center"></div></td>
        	<td width="200" height="13"> <div align="center">Sulfato Cu(sacos/dia)</div></td>
        	<td width="200" height="13"> <div align="center">Arseniato Fe(sacos/dia)</div></td>
        	<td width="200" height="13"> <div align="center">Sales Cu-Ni(sacos/dia)</div></td>
		</tr>
   		<tr> 
    		<td width="220"> 
        		<table width="100%" border="1">
            		<tr> 
                		<td width="20%" height="18"> <div align="center">TC</div></td>
                  		<td width="20%"><div align="center">TA</div></td>
                  		<td width="20%"><div align="center">TB</div></td>
                  		<td width="40%">(Ciclos/d&iacute;a)</td>
                	</tr>
   				</table>
			</td>
   			<td width="220">
				<table width="100%" border="1">
        			<tr> 
                		<td width="20%"><div align="center">TC</div></td>
                    	<td width="20%"><div align="center">TA</div></td>
                    	<td width="20%"><div align="center">TB</div></td>
                    	<td width="40%"><div align="center">Tot.Dia</div></td>
                 	</tr>
             	</table>
			</td>
            <td width="220">
				<table width="100%" border="1">
            		<tr> 
                		<td width="20%" height="17"><div align="center">TC</div></td>
                    	<td width="20%"><div align="center">TA</div></td>
                    	<td width="20%"><div align="center">TB</div></td>
                    	<td width="40%"><div align="center">Tot.Dia</div></td>
                	</tr>
            	</table>
			</td>
            <td width="220">
				<table width="100%" border="1">
                	<tr> 
                  		<td width="20%"><div align="center">TC</div></td>
                    	<td width="20%"><div align="center">TA</div></td>
                    	<td width="20%"><div align="center">TB</div></td>
                    	<td width="40%"><div align="center">Tot.Dia</div></td>
                  	</tr>
				</table>
			</td>
		</tr>
	</table>
	<table width="969"  border="1">
    <tr> 

   
		<?php 
			$cont_reactor=0;
			$cont_sc=0;
			$cont_af=0;
			$cont_sn=0;
			$cont_tur = 0;
			if ($proceso == "C")
            {
				$consulta = "select distinct fecha from ref_web.pte";
				$consulta.= " where fecha between '".$FechaInicio."' and '".$FechaTermino."' and fecha < '".$FechaTermino."'";
				$consulta.= " order by fecha";
					//echo $consulta;
				$respuesta = mysqli_query($link, $consulta);
				$pasada='1';
				$pasada2='1';
				$pasada3='1';
				while ($row= mysqli_fetch_array($respuesta))
				{
					$mes=substr($row["fecha"],5,2);
					$dia=substr($row["fecha"],8,2);
					$ano=substr($row["fecha"],0,4);
                    $fecha=$ano.'/'.$mes.'/'.$dia; 						
					echo "<td width='5%' align='center'>$fecha</td>\n";
					$consulta2="select distinct fecha,sum(reactores)as reactores2,sulfato_cobre,arseniato_ferico,sales_niquel from ref_web.pte ";
					$consulta2.="where fecha= '".$row["fecha"]."'  and turno='C' group by fecha";
					$respuesta2 = mysqli_query($link, $consulta2);
					$row2= mysqli_fetch_array($respuesta2);
					$consulta3="select distinct fecha,sum(reactores)as reactores2,sulfato_cobre,arseniato_ferico,sales_niquel from ref_web.pte ";
					$consulta3.="where fecha= '".$row["fecha"]."'  and turno='A' group by fecha";
					$respuesta3 = mysqli_query($link, $consulta3);
					$row3= mysqli_fetch_array($respuesta3);
					$consulta4="select distinct fecha,sum(reactores)as reactores2,sulfato_cobre,arseniato_ferico,sales_niquel from ref_web.pte ";
					$consulta4.="where fecha= '".$row["fecha"]."'  and turno='B' group by fecha";
					$respuesta4 = mysqli_query($link, $consulta4);
					$row4= mysqli_fetch_array($respuesta4);
					if (($txt_turno=='A') and ($pasada=='1'))
					{
						$total_reactores=$row3[reactores2]+$row4[reactores2];
						$total_r=$total_r+$total_reactores;
						$cont_reactor=$cont_reactor+1;
						?>	
					<td width='220'>
					<table width="100%" border="1">
					<tr>						
						<?php		
							echo "<td width='7%' align='center'></td>\n";
							$reactor2=number_format($row3[reactores2]);
							echo "<td width='20%' align='center'>'".$reactor2."'&nbsp;</td>\n";
							echo "<td width='20%' align='center'>'".$row4[reactores2]."'&nbsp;</td>\n";
							echo "<td width='40%'align='center'>'".$total_reactores."'&nbsp;</td>\n";
							
						?>
					</tr>
					</table>
					</td>	
					<td width="220">
					<table width="100%" border="1">
					<tr>	
						<?php	
										
							echo "<td width='7%' align='center'>&nbsp;</td>\n";
							echo "<td width='20%' align='center'>'".$row3[sulfato_cobre]."'&nbsp;</td>\n";
							echo "<td width='20%' align='center'>'".$row4[sulfato_cobre]."'&nbsp;</td>\n";
							$cont_sc=$cont_sc+1;
							$row2[sulfato_cobre]=0;
							$total_sacos1=$row2[sulfato_cobre]+$row3[sulfato_cobre]+$row4[sulfato_cobre];
							echo "<td width='40%' align='center'>'".$total_sacos1."'&nbsp;</td>\n";
						?>
					</tr>
					</table>
					</td>
						
					<td width="220">
					<table width="100%" border="1">
					<tr>	

						<?php	
						echo "<td width='7%' align='center'>&nbsp;</td>\n"; 
						echo "<td width='20%' align='center'>'".$row3[arseniato_ferico]."'&nbsp;</td>\n";
						echo "<td width='20%' align='center'>'".$row4[arseniato_ferico]."'&nbsp;</td>\n";
						$cont_af=$cont_af+1;
						$row2[arseniato_ferico]=0;
						$total_sacos2=$row2[arseniato_ferico]+$row3[arseniato_ferico]+$row4[arseniato_ferico];
						echo "<td width='40%' align='center'>'".$total_sacos2."'&nbsp;</td>\n";
						
						?>
					</tr>
					</table>
					</td>		
					<td width="220">
					<table width="100%" border="1">
					<tr>	

						<?php
						echo "<td width='7%' align='center'>&nbsp;</td>\n";
						echo "<td width='20%' align='center'>'".$row3[sales_niquel]."'&nbsp;</td>\n";
						echo "<td width='20%' align='center'>'".$row4[sales_niquel]."'&nbsp;</td>\n"; 
						$cont_sn=$cont_sn+1;
						$row2[sales_niquel]=0;
						$total_sacos3=$row2[sales_niquel]+$row3[sales_niquel]+$row4[sales_niquel];
						echo "<td width='40%' align='center'>'".$total_sacos3."'&nbsp;</td>\n";
						//hasta aqui el final de la primera fila
						?>
					</tr>
					</table>
					</td>

	</tr>
	</table>
							


						<?php 
						      $pasada='2';
							  $total_sc=$total_sc+$total_sacos1;
							  $total_af=$total_af+$total_sacos2;
							  $total_sn=$total_sn+$total_sacos3;
							  $cont_tur=$cont_tur+2;
							}
							else if (($txt_turno=='B') and ($pasada2=='1'))
							?>
								<table width="969"  border="1">
    							<tr> 
						<?php
							
								{
								  $total_reactores=$row4[reactores2];
								  $cont_reactor=$cont_reactor+1;
								  //aqui incluir tabla grande.................
						?>
							<td width="220">
							<table width="100%" border="1">
							<tr>	

						<?php
								  echo "<td width='7%' align='center'>&nbsp;</td>\n";
								   echo "<td width='5%' align='center'>&nbsp;</td>\n";
								   echo "<td width='5%' align='center'>".$row4[reactores2]."&nbsp;</td>\n"; 
						           echo "<td width='10%' align='center'>'".$total_reactores."'&nbsp;</td>\n";
						?>
							</tr>
							</table>
							</td>
							<td width="220">
							<table width="100%" border="1">
							<tr>	

							<?php		   
								   echo "<td width='7%' align='center'>&nbsp;</td>\n";
								   echo "<td width='5%' align='center'>&nbsp;</td>\n";
								   echo "<td width='5%' align='center'>'".$row4[sulfato_cobre]."'&nbsp;</td>\n"; 
								   $cont_sc=$cont_sc+1;
								   $row2[sulfato_cobre]=0;
								   $row3[sulfato_cobre]=0;
								   $total_sacos1=$row2[sulfato_cobre]+$row3[sulfato_cobre]+$row4[sulfato_cobre];
            					   echo "<td width='8%' align='center'>'".$total_sacos1&nbsp."';</td>\n";
								   echo "<td width='5%' align='center'>&nbsp;</td>\n";
							?>
							</tr>
							</table>
							</td>
							<td width="220">
							<table width="100%" border="1">
								<tr>	

							<?php	   
								   echo "<td width='5%' align='center'>&nbsp;</td>\n";
	   							   echo "<td width='5%' align='center'>".$row4[arseniato_ferico]."&nbsp;</td>\n";
								   $cont_af=$cont_af+1;
								   $row2[arseniato_ferico]=0;
								   $row3[arseniato_ferico]=0;
								   $total_sacos2=$row2[arseniato_ferico]+$row3[arseniato_ferico]+$row4[arseniato_ferico];
							       echo "<td width='6%' align='center'>'".$total_sacos2."'&nbsp;</td>\n";								   
								   echo "<td width='5%' align='center'>&nbsp;</td>\n";
							?>
							</tr>
							</table>
							</td>
							<td width="220">
							<table width="100%" border="1">
								<tr>	

							
							<?php 	   
								   echo "<td width='5%' align='center'>&nbsp;</td>\n";
								   echo "<td width='4%' align='center'>'".$row4[sales_niquel]."'&nbsp;</td>\n"; 
								   $cont_sn=$cont_sn+1;
	   							   $row2[sales_niquel]=0;
								   $row3[sales_niquel]=0;
								   $total_sacos3=$row2[sales_niquel]+$row3[sales_niquel]+$row4[sales_niquel];
						           echo "<td width='10%' align='center'>'".$total_sacos3."'&nbsp;</td>\n";
							?>
								</tr>
								</table>
								</td>
								
							<?php	   
								   $pasada2='2';
								   $total_r=$total_r+$total_reactores;
								   $total_sc=$total_sc+$total_sacos1;
							       $total_af=$total_af+$total_sacos2;
							       $total_sn=$total_sn+$total_sacos3;
								   $cont_tur=$cont_tur+1;
								 }
							 ?> 
								<tr>
								</table>
							<?php					
			   				}
						  	else if (($txt_turno=='C') and ($pasada3=='1'))
						  ?>
								<table width="969"  border="1">
    							<tr> 

						  <?php	{
						  			 $total_reactores=$row2[reactores2]+$row3[reactores2]+$row4[reactores2];
									 $cont_reactor=$cont_reactor+1;
								
								?>
								<td width="220">
								<table width="100%" border="1">
								<tr>	

								<?php 	 
									 echo "<td width='7%'  align='center'>'".$row2[reactores2]."'&nbsp;</td>\n"; 
									 echo "<td width='5%'  align='center'>'".$row3[reactores2]."'&nbsp;</td>\n"; 
									 echo "<td width='5%'  align='center'>".$row4[reactores2]."&nbsp;</td>\n";
						             echo "<td width='10%' align='center'>'".$total_reactores."'&nbsp;</td>\n";
								?>
								</tr>
								</table>
								</td>
								<td width="220">
								<table width="100%" border="1">
								<tr>	

								<?php	 
									 echo "<td width='7%'  align='center'>'".$row2[sulfato_cobre]."'&nbsp;</td>\n"; 
									 echo "<td width='5%'  align='center'>'".$row3[sulfato_cobre]."'&nbsp;</td>\n"; 
									 echo "<td width='5%'  align='center'>'".$row4[sulfato_cobre]."'&nbsp;</td>\n";
									 $cont_sc=$cont_sc+1;
									 $total_sacos1=$row2[sulfato_cobre]+$row3[sulfato_cobre]+$row4[sulfato_cobre];
						             echo "<td width='8%' align='center'>'".$total_sacos1."'&nbsp;</td>\n"; 
								?>	 
								</tr>
								</table>
								</td>
								<td width="220">
								<table width="100%" border="1">
								<tr>	
	 							<?php
									 //aqui
									 echo "<td width='5%' align='center'>'".$row2[arseniato_ferico]."'&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>'".$row3[arseniato_ferico]."'&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>'".$row4[arseniato_ferico]."'&nbsp;</td>\n"; 
									 $cont_af=$cont_af+1;
									 $total_sacos2=$row2[arseniato_ferico]+$row3[arseniato_ferico]+$row4[arseniato_ferico];
							         echo "<td width='6%' align='center'>'".$total_sacos2."'&nbsp;</td>\n";
							?>
												</tr>
								</table>
								</td>
								<td width="220">
								<table width="100%" border="1">
								<tr>	

									 
							<?php	//	 aqui								   
									 echo "<td width='5%' align='center'>".$row2[sales_niquel]."&nbsp;</td>\n";
									 echo "<td width='5%' align='center'>".$row3[sales_niquel]."&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>".$row4[sales_niquel]."&nbsp;</td>\n";  
									 $cont_sn=$cont_sn+1;
									 $total_sacos3=$row2[sales_niquel]+$row3[sales_niquel]+$row4[sales_niquel];
						             echo "<td width='10%' align='center'>'".$total_sacos3."'&nbsp;</td>\n";
							?>		 
								</tr>
								</table>
								</td>
								<td width="220">
								<table width="100%" border="1">
								<tr>	
</tr>
</table>
							<?php		 
								//	 aqui
									  $pasada3='2';
									  $total_r=$total_r+$total_reactores;
									  $total_sc=$total_sc+$total_sacos1;
							          $total_af=$total_af+$total_sacos2;
							          $total_sn=$total_sn+$total_sacos3;
									  $cont_tur=$cont_tur+3;
								
							  }		     
						       else 
							  {
							         $total_reactores=$row2[reactores2]+$row3[reactores2]+$row4[reactores2];
									  $cont_reactor=$cont_reactor+1;
									 echo "<td width='5%' align='center'>'".$row2[reactores2]."'&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>'".$row3[reactores2]."'&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>'".$row4[reactores2]."'&nbsp;</td>\n"; 
						             echo "<td width='10%' align='center'>'".$total_reactores."'&nbsp;</td>\n";
								?>
								</tr>
								</table>
								</td>
								<td width="220">
								<table width="100%" border="1">
								<tr>	
	 
								<?php	// aqui
							         echo "<td width='5%' align='center'>'".$row2[sulfato_cobre]."'&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>'".$row3[sulfato_cobre]."'&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>'".$row4[sulfato_cobre]."'&nbsp;</td>\n";
									 $cont_sc=$cont_sc+1;
									 $total_sacos1=$row2[sulfato_cobre]+$row3[sulfato_cobre]+$row4[sulfato_cobre];
						             echo "<td width='8%' align='center'>'".$total_sacos1."'&nbsp;</td>\n"; 
								?>	 
								</tr>
								</table>
								</td>
								<td width="220">
								<table width="100%" border="1">
								<tr>	

								<?php	// aqui
									 echo "<td width='5%' align='center'>'".$row2[arseniato_ferico]."'&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>'".$row3[arseniato_ferico]."'&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>'".$row4[arseniato_ferico]."'&nbsp;</td>\n"; 
									 $cont_af=$cont_af+1;
									 $total_sacos2=$row2[arseniato_ferico]+$row3[arseniato_ferico]+$row4[arseniato_ferico];
							         echo "<td width='6%' align='center'>'".$total_sacos2."'&nbsp;</td>\n";
								?>
								</tr>
								</table>
								</td>
								<td width="220">
								<table width="100%" border="1">
								<tr>	

								<?php 	 
									// aqui								   
									 echo "<td width='5%' align='center'>".$row2[sales_niquel]."&nbsp;</td>\n";
									 echo "<td width='5%' align='center'>".$row3[sales_niquel]."&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>".$row4[sales_niquel]."&nbsp;</td>\n";  
									 $cont_sn=$cont_sn+1;
									 $total_sacos3=$row2[sales_niquel]+$row3[sales_niquel]+$row4[sales_niquel];
						             echo "<td width='10%' align='center'>'".$total_sacos3."'&nbsp;</td>\n";
								?>
								</tr>
								</table>
								</td>

								<?php	 
									 
									// aqui
									  $total_r=$total_r+$total_reactores;
									 $total_sc=$total_sc+$total_sacos1;
							         $total_af=$total_af+$total_sacos2;
							         $total_sn=$total_sn+$total_sacos3;
									 $cont_tur=$cont_tur+3;}
						//ver este cierre de tr
						 					 
								echo "</tr>\n";
				
						 
						}
						 $consulta_max_fecha="select max(fecha) as fecha_m from ref_web.pte where fecha='".$FechaTermino."'";
					     $respuesta_m = mysqli_query($link, $consulta_max_fecha);
					     $row_m= mysqli_fetch_array($respuesta_m);
						 $mesm=substr($row_m[fecha_m],5,2);
						 $diam=substr($row_m[fecha_m],8,2);
						 $anom=substr($row_m[fecha_m],0,4);
                         $fecham=$anom.'/'.$mesm.'/'.$diam; 
						 $consulta2="select distinct fecha,sum(reactores)as reactores2,sulfato_cobre,arseniato_ferico,sales_niquel from ref_web.pte ";
						 $consulta2.="where fecha= '".$row_m[fecha_m]."'  and turno='C' group by fecha";
						 $respuesta2 = mysqli_query($link, $consulta2);
						 $row2= mysqli_fetch_array($respuesta2);
						 $consulta3="select distinct fecha,sum(reactores)as reactores2,sulfato_cobre,arseniato_ferico,sales_niquel from ref_web.pte ";
						 $consulta3.="where fecha= '".$row_m[fecha_m]."'  and turno='A' group by fecha";
						 $respuesta3 = mysqli_query($link, $consulta3);
						 $row3= mysqli_fetch_array($respuesta3);
						 $consulta4="select distinct fecha,sum(reactores)as reactores2,sulfato_cobre,arseniato_ferico,sales_niquel from ref_web.pte ";
						 $consulta4.="where fecha= '".$row_m[fecha_m]."'  and turno='B' group by fecha";
						 $respuesta4 = mysqli_query($link, $consulta4);
						 $row4= mysqli_fetch_array($respuesta4);
						 $pasada='1';
						 $pasada2='1';
						 $pasada3='1';
						 if ($txt_turno1=='A')
						     {  echo "<td width='5%' align='center'>'".$fecham."'&nbsp;</td>\n";
							   $total_reactores=$row2[reactores2]+$row3[reactores2];
							   $cont_reactor=$cont_reactor+1;
							   $total_r=$total_r+$total_reactores;
							 ?>  
							<td width="220">
							<table width="100%" border="1">
							<tr>
							<?php	   
							   echo "<td width='5%' align='center'>'".$row2[reactores2]."'&nbsp;</td>\n"; 
							   echo "<td width='5%' align='center'>'".$row3[reactores2]."'&nbsp;</td>\n";
							   echo "<td width='5%' align='center'>&nbsp;</td>\n";
							   echo "<td width='10%' align='center'>'".$total_reactores."'&nbsp;</td>\n";
						
							
				

							   
							 //  aqui
							   echo "<td width='5%' align='center'>'".$row2[sulfato_cobre]."'&nbsp;</td>\n"; 
							   echo "<td width='5%' align='center'>'".$row3[sulfato_cobre]."'&nbsp;</td>\n";
							   $cont_sc=$cont_sc+1; 
							   echo "<td width='5%' align='center'>&nbsp;</td>\n";
							   $total_sacos1=$row2[sulfato_cobre]+$row3[sulfato_cobre];
						       echo "<td width='8%' align='center'>'".$total_sacos1."'&nbsp;</td>\n";
						?>
								</tr>
								</table>
								</td>
								<td width="220">
								<table width="100%" border="1">
								<tr>	

						<?php 	   
							   //aqui 
							   echo "<td width='5%' align='center'>'".$row2[arseniato_ferico]."'&nbsp;</td>\n"; 
							   echo "<td width='5%' align='center'>'".$row3[arseniato_ferico]."'&nbsp;</td>\n"; 
							   $cont_af=$cont_af+1;
							   echo "<td width='5%' align='center'>&nbsp;</td>\n"; 
							   $total_sacos2=$row2[arseniato_ferico]+$row3[arseniato_ferico];
							   echo "<td width='6%' align='center'>'".$total_sacos2."'&nbsp;</td>\n";
						?>
								</tr>
								</table>
								</td>
								<td width="220">
								<table width="100%" border="1">
								<tr>	

						<?php 	   
							//   aqui								   
							   echo "<td width='5%' align='center'>'".$row2[sales_niquel]."'&nbsp;</td>\n";
							   echo "<td width='5%' align='center'>'".$row3[sales_niquel]."'&nbsp;</td>\n"; 
							   $cont_sn=$cont_sn+1;
							   echo "<td width='5%' align='center'>&nbsp;</td>\n";  
							   $total_sacos3=$row2[sales_niquel]+$row3[sales_niquel];
						       echo "<td width='10%' align='center'>'".$total_sacos3."'&nbsp;</td>\n";
						?>
								</tr>
								</table>
								</td>
								<td width="220">
								<table width="100%" border="1">
								<tr>	

						<?php 	   
							   //aqui
							   $total_sc=$total_sc+$total_sacos1;
							   $total_af=$total_af+$total_sacos2;
							   $total_sn=$total_sn+$total_sacos3;
							   $cont_tur=$cont_tur+2;}
						 else if ($txt_turno1=='B')
						         {    echo "<td width='5%' align='center'>'".$fecham."'&nbsp;</td>\n";
								     $total_reactores=$row2[reactores2]+$row3[reactores2]+$row4[reactores2];
									 $cont_reactor=$cont_reactor+1;
									 $total_r=$total_r+$total_reactores;
									 echo "<td width='5%' align='center'>'".$row2[reactores2]."'&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>'".$row3[reactores2]."'&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>'".$row4[reactores2]."'&nbsp;</td>\n";
									 echo "<td width='10%' align='>'".$total_reactores."'&nbsp;</td>\n";
							?>
								</tr>
								</table>
								</td>
								<td width="220">
								<table width="100%" border="1">
								<tr>	
	 
							<?php //		 aqui
							         echo "<td width='5%' align='center'>'".$row2[sulfato_cobre]."'&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>'".$row3[sulfato_cobre]."'&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>'".$row4[sulfato_cobre]."'&nbsp;</td>\n";
									 $cont_sc=$cont_sc+1; 
									 $total_sacos1=$row2[sulfato_cobre]+$row3[sulfato_cobre]+$row4[sulfato_cobre];
						             echo "<td width='8%' align='center'>'".$total_sacos1."'&nbsp;</td>\n"; 
							?>
								</tr>
								</table>
								</td>
								<td width="220">
								<table width="100%" border="1">
								<tr>	

							<?php 		 
								//	 aqui
									 echo "<td width='5%' align='center'>'".$row2[arseniato_ferico]."'&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>'".$row3[arseniato_ferico]."'&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>'".$row4[arseniato_ferico]."'&nbsp;</td>\n"; 
									 $cont_af=$cont_af+1;
									 $total_sacos2=$row2[arseniato_ferico]+$row3[arseniato_ferico]+$row4[arseniato_ferico];
							         echo "<td width='6%' align='center'>'".$total_sacos2."'&nbsp;</td>\n";
							?>
								</tr>
								</table>
								</td>
								<td width="220">
								<table width="100%" border="1">
								<tr>	

							<?php 		 
								//	 aqui								   
									 echo "<td width='5%' align='center'>'".$row2[sales_niquel]."'&nbsp;</td>\n";
									 echo "<td width='5%' align='center'>'".$row3[sales_niquel]."'&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>'".$row4[sales_niquel]."'&nbsp;</td>\n";  
									 $cont_sn=$cont_sn+1;
									 $total_sacos3=$row2[sales_niquel]+$row3[sales_niquel]+$row4[sales_niquel];
						             echo "<td width='10%' align='center'>'".$total_sacos3."'&nbsp</td>\n";
							?>		 
								</tr>
								</table>
								</td>
								<td width="220">
								<table width="100%" border="1">
								<tr>	

							<?php //		 aqui
									  $total_sc=$total_sc+$total_sacos1;
							         $total_af=$total_af+$total_sacos2;
							         $total_sn=$total_sn+$total_sacos3;
									 $cont_tur=$cont_tur+3;}
						 else if ($txt_turno1=='C')
						          {   echo "<td width='5%' align='center'>'".$fecham."'&nbsp;</td>\n";
								      $cont_reactor=$cont_reactor+1;
								     $total_reactores=$row2[reactores2]+$row3[reactores2]+$row4[reactores2];
									 $total_r=$total_r+$total_reactores;
									 echo "<td width='5%' align='center'>'".$row2[reactores2]."'&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>&nbsp;</td>\n";
									 
						             echo "<td width='10%' align='center'>'".$total_reactores."'&nbsp;</td>\n";
							?>
								</tr>
								</table>
								</td>
								<td width="220">
								<table width="100%" border="1">
								<tr>	

							<?php 		 
								//	 aqui
							         echo "<td width='5%' align='center'>'".$row2[sulfato_cobre]."'&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>&nbsp;</td>\n";
									 $cont_sc=$cont_sc+1; 
									 $total_sacos1=$row2[sulfato_cobre];
						             echo "<td width='8%' align='center'>'".$total_sacos1."'&nbsp;</td>\n";
							?>
								</tr>
								</table>
								</td>
								<td width="220">
								<table width="100%" border="1">
								<tr>	

							<?php 		 
								//	 aqui 
									 echo "<td width='5%' align='center'>'".$row2[arseniato_ferico]."'&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>&nbsp;</td>\n";
									 $cont_af=$cont_af+1;  
									 $total_sacos2=$row2[arseniato_ferico];
							         echo "<td width='6%' align='center'>'".$total_sacos2."'&nbsp;</td>\n";
							?>
								</tr>
								</table>
								</td>
								<td width="220">
								<table width="100%" border="1">
								<tr>	

							<?php 		 
								//	 aqui								   
									 echo "<td width='5%' align='center'>'".$row2[sales_niquel]."'&nbsp;</td>\n";
									 echo "<td width='5%' align='center'>&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>&nbsp;</td>\n";
									 $cont_sn=$cont_sn+1;   
									 $total_sacos3=$row2[sales_niquel];
						             echo "<td width='10%' align='center'>'".$total_sacos3."'&nbsp;</td>\n";
							?>
								</tr>
								</table>
								</td>
								<td width="220">
								<table width="100%" border="1">
								<tr>	

							<?php 		 
								//	 aqui termino
									 $total_sc=$total_sc+$total_sacos1;
							         $total_af=$total_af+$total_sacos2;
							         $total_sn=$total_sn+$total_sacos3;
									 $cont_tur=$cont_tur+1;}		 	   
								  echo "</tr>\n";			 
					}
							?>
										
					<?php	
					//ver esto php			
					echo "<td align='center'><font color='blue'>Totales&nbsp</font></td>\n";
					echo "<td align='center'><font color='blue'>&nbsp</font></td>\n";
					echo "<td align='center'><font color='blue'>&nbsp</font></td>\n";
					echo "<td align='center'><font color='blue'>&nbsp</font></td>\n";
					echo "<td align='center'><font color='blue'>$total_r&nbsp</font></td>\n";
					echo "<td align='center'><font color='blue'>&nbsp</font></td>\n";
					echo "<td align='center'><font color='blue'>&nbsp</font></td>\n";
					echo "<td align='center'><font color='blue'>&nbsp</font></td>\n";
					echo "<td align='center'><font color='blue'>$total_sc&nbsp</font></td>\n";
					echo "<td align='center'><font color='blue'>&nbsp</font></td>\n";	  
					echo "<td align='center'><font color='blue'>&nbsp</font></td>\n";	  
					echo "<td align='center'><font color='blue'>&nbsp</font></td>\n";	  
					echo "<td align='center'><font color='blue'>$total_af&nbsp</font></td>\n";	  
					echo "<td align='center'><font color='blue'>&nbsp</font></td>\n";
					echo "<td align='center'><font color='blue'>&nbsp</font></td>\n";	  
					echo "<td align='center'><font color='blue'>&nbsp</font></td>\n";
		    		echo "<td align='center' ><font color='blue'>$total_sn&nbsp</font></td>\n";	  	  	  
			?>  
          </table>
		  <--hata aqui-->
        <table width="969" height="40" border="2" align="left">
          <tr bordercolor="#0000FF" bgcolor="#FFFFFF"> 
            <td width="6%"><strong>Promedios</strong></td>
            <?php
			//$javier=$cont_sc+$cont_af+$cont_sn-2;
			//echo $cont_tur;
			if ($cont_sc==0)
			   {$promedio_sc=0; }
			else{$promedio_sc=$total_sc/$cont_tur;
			     $promedio_sc=number_format($promedio_sc,"2",",","");}   
			if ($cont_af==0)
			   {$promedio_af=0;}
			else {$promedio_af=$total_af/$cont_tur;
			      $promedio_af=number_format($promedio_af,"2",",","");}
			if ($cont_sn==0)
			   {$promedio_sn=0;}
			else {$promedio_sn=$total_sn/$cont_tur;
			      $promedio_sn=number_format($promedio_sn,"2",",","");}
			if ($cont_reactor==0)
			   {$promedio_r=0;}
			else {$promedio_r=$total_r/ $cont_tur;
			      $promedio_r=number_format($promedio_r,"2",",",""); }    
		?>
            <td width='15%' align='center'>&nbsp;</td>
            <td width='10%' align='center'><?php echo $promedio_r ?> ciclo/turno&nbsp;</td>
            <td width='15%' align='right'>&nbsp;</td>
            <td width='9%' align='center'><?php echo $promedio_sc ?> s/turno</td>
            <td width='12%' align='right'>&nbsp;</td>
            <td width='9%' align='center'><?php echo $promedio_af ?>s/turno</td>
            <td width='14%' align='right'>&nbsp;</td>
            <td width='15%' align='center'><?php echo $promedio_sn ?> s/turno</td>
          </tr>
        </table>
        <p>&nbsp;</p>
        <table width="55%" height="62" border="2" bordercolor="#0000FF" align="center">
          <tr> 
            <td colspan="2" bgcolor="#FFFFFF" class="ColorTabla01">&nbsp;Volumen 
              Electrolito</td>
            <td colspan="2" rowspan="2" bgcolor="#FFFFFF"> <div align="left"><strong>Carga 
                Reactor</strong></div></td>
            <td colspan="8" rowspan="2" bgcolor="#FFFFFF"> <div align="left"><strong>Razon 
                Prod. Sulfato de Cobre</strong></div></td>
            <td width="36%" rowspan="2" bgcolor="#FFFFFF"><strong>Elect. Tratado</strong></td>
          </tr>
          <tr> 
            <td width="12%" bgcolor="#FFFFFF" class="Detalle02"><strong>INT. I.</strong></td>
            <td width="9%" align="center" bgcolor="#FFFFFF" class="Detalle02">--</td>
          </tr>
          <tr bordercolor="#0000FF"> 
            <td bgcolor="#FFFFFF" class="Detalle02"><strong>INT. F.</strong></td>
            <td bgcolor="#FFFFFF" align="center" class="Detalle02">--&nbsp;</td>
            <td colspan="2" bgcolor="#FFFFFF"> 
              <?php
			 $total_x=($total_r*11.4);
            echo  "<div align='left'><font color='#FF0000'><strong>11,4 m3/ciclo</strong></font></div></td>";
			if ($total_x==0)
			   {$Razon_prod=0;}
			 else{$Razon_prod=($total_sc/$total_x);
			      $Razon_prod=number_format($Razon_prod,"2",",","");}
            echo "<td colspan='8' bgcolor='#FFFFFF'><font color='#FF0000'><strong>$Razon_prod sacos/m3 </strong></font></td>";
			?>
            <td width="11%" bgcolor="#FFFFFF"><?php echo number_format($total_x/$cont_tur,"2",".",".");?>&nbsp;m3/turno</td>
          </tr>
          <tr> 
            <td bordercolor="#0000FF" bgcolor="#FFFFFF" class="Detalle02"><strong>Total 
              Procesado</strong></td>
            <?php
              echo "<td bordercolor='#0000FF' bgcolor='#FFFFFF' align='center' class='Detalle02'>$total_x&nbsp;</td>";
			?>
            <?php
			
            echo "<td colspan='2' bordercolor='#000000' bgcolor='#FFFFFF'>&nbsp;</td>";
			?>
            <td colspan="8" bordercolor="#0000FF" bgcolor="#FFFFFF">&nbsp;</td>
            <td width="4%" bordercolor="#0000FF" bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
        </table>
        <p>&nbsp;</p>
        <table width="49%" height="48" border="0" cellpadding="0" cellspacing="0" bordercolor="#b26c4a" class="TablaDetalle" align="center">
          <tr class="ColorTabla01"> 
            <td width="27%" height="24" rowspan="2"> <div align="center"><strong>DESTINO</strong></div></td>
            <td colspan="7"><div align="center"><strong> CIRCUITO ORIGEN</strong></div></td>
          </tr>
          <tr class="ColorTabla01"> 
            <td width="12%"><div align="center"><strong>C1</strong></div></td>
            <td width="12%"><div align="center"><strong>C2</strong></div></td>
            <td width="12%"><div align="center"><strong>C3</strong></div></td>
            <td width="12%"><div align="center"><strong>C4</strong></div></td>
            <td width="12%"><div align="center"><strong>C5</strong></div></td>
            <td width="12%"><div align="center"><strong>C6</strong></div></td>
			<td width="12%"><div align="center"><strong>Total</strong></div></td>
          </tr>
        </table>
        <table width="49%" border="2" align="center">
          <tr bordercolor="#0000FF" bgcolor="#FFFFFF"> 
            <?php
		            $consulta_circuito="select valor_subclase1,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='3100' and valor_subclase1<='6' "; 
					$respuesta_circuito= mysqli_query($link, $consulta_circuito);
					$total_electrolito=0;
					$total_dp=0;
					while ($row_c= mysqli_fetch_array($respuesta_circuito))
					       {
	                    	    $consulta_elect_total_proceso="select sum(volumen_pte) as volumen_pte_total from ref_web.tratamiento_electrolito";
						        $consulta_elect_total_proceso.= " where fecha  between '".$FechaInicio."' and '".$FechaTermino."' and turno  in ('C','A','B') and destino_pte='Proceso' ";
					            $consulta_elect_total_proceso.= " and circuito_pte='".$row_c["nombre_subclase"]."'";
						        $respuesta_elect_total_proceso = mysqli_query($link, $consulta_elect_total_proceso);
		                        $row_elect_total_proceso= mysqli_fetch_array($respuesta_elect_total_proceso);
								$consulta_elect_total_venta="select sum(volumen_pte) as volumen_pte_total from ref_web.tratamiento_electrolito";
						        $consulta_elect_total_venta.= " where fecha  between '".$FechaInicio."' and '".$FechaTermino."' and turno  in ('C','A','B') and destino_pte='Venta' ";
					            $consulta_elect_total_venta.= " and circuito_pte='".$row_c["nombre_subclase"]."' ";
						        $respuesta_elect_total_venta = mysqli_query($link, $consulta_elect_total_venta);
		                        $row_elect_total_venta= mysqli_fetch_array($respuesta_elect_total_venta);
								$consulto='S';
								if ($txt_turno=='A')
								   {
								     $turnos_desc_inicio="C";
								   }
								else if ($txt_turno=='B')
								        {
										  $turnos_desc_inicio="C','A";
										}  
									  else {
									         $consulto='N';
									       }
								if ($consulto!='N')
								    {		   	 
									  $consulta_elect_descuento_inicio_proceso="select sum(volumen_pte) as volumen_pte_inicio from ref_web.tratamiento_electrolito";
									  $consulta_elect_descuento_inicio_proceso.= " where fecha ='".$FechaInicio."' and turno  in ('".$turnos_desc_inicio."') and destino_pte='Proceso'";
									  $consulta_elect_descuento_inicio_proceso.= " and circuito_pte='".$row_c["nombre_subclase"]."'";
									  $respuesta_elect_descuento_inicio_proceso= mysqli_query($link, $consulta_elect_descuento_inicio_proceso);
									  $row_elect_descuento_inicio_proceso= mysqli_fetch_array($respuesta_elect_descuento_inicio_proceso);
									  $consulta_elect_descuento_inicio_venta="select sum(volumen_pte) as volumen_pte_inicio from ref_web.tratamiento_electrolito";
									  $consulta_elect_descuento_inicio_venta.= " where fecha ='".$FechaInicio."' and turno  in ('".$turnos_desc_inicio."') and destino_pte='Venta'";
									  $consulta_elect_descuento_inicio_venta.= " and circuito_pte='".$row_c["nombre_subclase"]."'";
									  $respuesta_elect_descuento_inicio_venta = mysqli_query($link, $consulta_elect_descuento_inicio_venta);
									  $row_elect_descuento_inicio_venta= mysqli_fetch_array($respuesta_elect_descuento_inicio_venta);
								    }
							    $consulto='S';		
								if ($txt_turno1=='A')
								   {
								    $turnos_desc_fin="B";
								   }
								else if ($txt_turno1=='C')
								        {
										  $turnos_desc_fin="A','B";
										}
								      else {
									        $consulto='N';
									       }
								 if ($consulto!='N')
								    {		   
									 $consulta_elect_descuento_ter_proceso="select sum(volumen_pte) as volumen_pte_ter from ref_web.tratamiento_electrolito";
									 $consulta_elect_descuento_ter_proceso.= " where fecha ='".$FechaTermino."' and turno  in ('".$turnos_desc_fin."') and destino_pte='Proceso'";
									 $consulta_elect_descuento_ter_proceso.= " and circuito_pte='".$row_c["nombre_subclase"]."'";
									 $respuesta_elect_descuento_ter_proceso = mysqli_query($link, $consulta_elect_descuento_ter_proceso);
									 $row_elect_descuento_ter_proceso= mysqli_fetch_array($respuesta_elect_descuento_ter_proceso);
									 $consulta_elect_descuento_ter_venta="select sum(volumen_pte) as volumen_pte_ter from ref_web.tratamiento_electrolito";
									 $consulta_elect_descuento_ter_venta.= " where fecha ='".$FechaTermino."' and turno  in ('".$turnos_desc_fin."') and destino_pte='Venta'";
									 $consulta_elect_descuento_ter_venta.= " and circuito_pte='".$row_c["nombre_subclase"]."'";
									 $respuesta_elect_descuento_ter_venta = mysqli_query($link, $consulta_elect_descuento_ter_venta);
									 $row_elect_descuento_ter_venta= mysqli_fetch_array($respuesta_elect_descuento_ter_venta);
									} 
								$total_electrolito=0;			   
							    $total_electrolito=($row_elect_total_proceso[volumen_pte_total]+$row_elect_total_venta[volumen_pte_total])-($row_elect_descuento_inicio_proceso[volumen_pte_inicio]+$row_elect_descuento_inicio_venta[volumen_pte_inicio])-($row_elect_descuento_ter_proceso[volumen_pte_ter]+$row_elect_descuento_ter_venta[volumen_pte_ter]);
							/***************************************************************************************************************/

							    $consulta_dp_total="select sum(volumen_dp) as total_desc_parcial from ref_web.desc_parcial";
						        $consulta_dp_total.= " where fecha  between '".$FechaInicio."' and '".$FechaTermino."' and turno  in ('C','A','B')";
					            $consulta_dp_total.= " and circuito_dp='".$row_c["nombre_subclase"]."'";
								//echo $consulta_dp_total."<br>";
								$respuesta_dp_total = mysqli_query($link, $consulta_dp_total);
         						$row_dp_total= mysqli_fetch_array($respuesta_dp_total);
								$consulto='S';
								if ($txt_turno=='A')
								   {
								     $turnos_desc_inicio="C";
								   }
								else if ($txt_turno=='B')
								        {
										  $turnos_desc_inicio="C','A";
										}  
									  else {
									         $consulto='N';
									       }
								
								if ($consulto!='N')
								    {		   	 
								     $consulta_dp_total_ini="select sum(volumen_dp) as total_desc_parcial_ini from ref_web.desc_parcial";
						             $consulta_dp_total_ini.= " where fecha = '".$FechaInicio."' and turno  in ('".$turnos_desc_inicio."')";
					                 $consulta_dp_total_ini.= " and circuito_dp='".$row_c["nombre_subclase"]."'";
									 //echo $consulta_dp_total_ini."<br>";
								     $respuesta_dp_total_ini = mysqli_query($link, $consulta_dp_total_ini);
         						     $row_dp_total_ini= mysqli_fetch_array($respuesta_dp_total_ini);
									} 
								$consulto='S';	
								if ($txt_turno1=='A')
								   {
								    $turnos_desc_fin="B";
								   }
								else if ($txt_turno1=='C')
								        {
										  $turnos_desc_fin="A','B";
										}
								      else {
									        $consulto='N';
									       }	
								if ($consulto!='N')
								    {		   	 
								      $consulta_dp_total_fin="select sum(volumen_dp) as total_desc_parcial_fin from ref_web.desc_parcial";
						              $consulta_dp_total_fin.= " where fecha = '".$FechaTermino."' and turno in ('".$turnos_desc_fin."')";
					                  $consulta_dp_total_fin.= " and circuito_dp='".$row_c["nombre_subclase"]."'";
								      $respuesta_dp_total_fin = mysqli_query($link, $consulta_dp_total_fin);
         						      $row_dp_total_fin= mysqli_fetch_array($respuesta_dp_total_fin);
								      //echo $consulta_dp_total_fin."<br>";
								    }
								
								
								
								
							$total_dp=0;	
							$total_dp=$row_dp_total[total_desc_parcial]-$row_dp_total_ini[total_desc_parcial_ini]-$row_dp_total_fin[total_desc_parcial_fin];
							/***************************************************************************************************************/
						 	 if ($row_c["nombre_subclase"]=='Circuito1')
							     {
								  $total_c1=$total_c1+($total_electrolito + $total_dp);
								  $total_d_parcial_venta_c1=$total_d_parcial_venta_c1+$row_elect_total_venta[volumen_pte_total]-$row_elect_descuento_ter_venta[volumen_pte_inicio]-$row_elect_descuento_inicio_venta[volumen_pte_ter];
                                  $total_d_parcial_proceso_c1=$total_d_parcial_proceso_c1+$row_elect_total_proceso[volumen_pte_total]-$row_elect_descuento_ter_proceso[volumen_pte_inicio]-$row_elect_descuento_inicio_proceso[volumen_pte_ter];								 
								  $total_dp_c1=$total_dp_c1+$row_dp_total[total_desc_parcial]-$row_dp_total_ini[total_desc_parcial_ini]-$row_dp_total_fin[total_desc_parcial_fin];
								 }
							 else if ($row_c["nombre_subclase"]=='Circuito2')
									{
									 $total_c2=$total_c2+($total_electrolito + $total_dp);
									 $total_d_parcial_venta_c2=$total_d_parcial_venta_c2+$row_elect_total_venta[volumen_pte_total]-$row_elect_descuento_ter_venta[volumen_pte_inicio]-$row_elect_descuento_inicio_venta[volumen_pte_ter];
                                     $total_d_parcial_proceso_c2=$total_d_parcial_proceso_c2+$row_elect_total_proceso[volumen_pte_total]-$row_elect_descuento_ter_proceso[volumen_pte_inicio]-$row_elect_descuento_inicio_proceso[volumen_pte_ter];
									 $total_dp_c2=$total_dp_c2+$row_dp_total[total_desc_parcial]-$row_dp_total_ini[total_desc_parcial_ini]-$row_dp_total_fin[total_desc_parcial_fin];
								    }
							      else if ($row_c["nombre_subclase"]=='Circuito3')
									      {
										   $total_c3=$total_c3+($total_electrolito + $total_dp);
										   $total_d_parcial_venta_c3=$total_d_parcial_venta_c3+$row_elect_total_venta[volumen_pte_total]-$row_elect_descuento_ter_venta[volumen_pte_inicio]-$row_elect_descuento_inicio_venta[volumen_pte_ter];
                                           $total_d_parcial_proceso_c3=$total_d_parcial_proceso_c3+$row_elect_total_proceso[volumen_pte_total]-$row_elect_descuento_ter_proceso[volumen_pte_inicio]-$row_elect_descuento_inicio_proceso[volumen_pte_ter];
										   $total_dp_c3=$total_dp_c3+$row_dp_total[total_desc_parcial]-$row_dp_total_ini[total_desc_parcial_ini]-$row_dp_total_fin[total_desc_parcial_fin];								 
										  }
								       else if ($row_c["nombre_subclase"]=='Circuito4')
									           {
											    $total_c4=$total_c4+($total_electrolito + $total_dp);
												$total_d_parcial_venta_c4=$total_d_parcial_venta_c4+$row_elect_total_venta[volumen_pte_total]-$row_elect_descuento_ter_venta[volumen_pte_inicio]-$row_elect_descuento_inicio_venta[volumen_pte_ter];
                                                $total_d_parcial_proceso_c4=$total_d_parcial_proceso_c4+$row_elect_total_proceso[volumen_pte_total]-$row_elect_descuento_ter_proceso[volumen_pte_inicio]-$row_elect_descuento_inicio_proceso[volumen_pte_ter];								 
												$total_dp_c4=$total_dp_c4+$row_dp_total[total_desc_parcial]-$row_dp_total_ini[total_desc_parcial_ini]-$row_dp_total_fin[total_desc_parcial_fin];
											   }
										    else if ($row_c["nombre_subclase"]=='Circuito5')
									               {
												     $total_c5=$total_c5+($total_electrolito + $total_dp);
													 $total_d_parcial_venta_c5=$total_d_parcial_venta_c5+$row_elect_total_venta[volumen_pte_total]-$row_elect_descuento_ter_venta[volumen_pte_inicio]-$row_elect_descuento_inicio_venta[volumen_pte_ter];
                                                     $total_d_parcial_proceso_c5=$total_d_parcial_proceso_c5+$row_elect_total_proceso[volumen_pte_total]-$row_elect_descuento_ter_proceso[volumen_pte_inicio]-$row_elect_inicio_ter_proceso[volumen_pte_ter];								 
													 $total_dp_c5=$total_dp_c5+$row_dp_total[total_desc_parcial]-$row_dp_total_ini[total_desc_parcial_ini]-$row_dp_total_fin[total_desc_parcial_fin];
												   }	
												  else if ($row_c["nombre_subclase"]=='Circuito6')
									                      {
														   $total_c6=$total_c6+($total_electrolito + $total_dp);
														   $total_d_parcial_venta_c6=$total_d_parcial_venta_c6+$row_elect_total_venta[volumen_pte_total]-$row_elect_descuento_ter_venta[volumen_pte_inicio]-$row_elect_descuento_inicio_venta[volumen_pte_ter];
                                                           $total_d_parcial_proceso_c6=$total_d_parcial_proceso_c6+$row_elect_total_proceso[volumen_pte_total]-$row_elect_descuento_ter_proceso[volumen_pte_inicio]-$row_elect_descuento_inicio_proceso[volumen_pte_ter];								 
														   $total_dp_c6=$total_dp_c6+$row_dp_total[total_desc_parcial]-$row_dp_total_ini[total_desc_parcial_ini]-$row_dp_total_fin[total_desc_parcial_fin];
														  }    
						   }
		  ?>
            <td width="27%"><strong>D. Parcial</strong></td>
            <td width="12%" align="center"><?php echo $total_dp_c1; ?>&nbsp;</td>
            <td width="12%" align="center"><?php echo $total_dp_c2; ?>&nbsp;</td>
            <td width="12%" align="center"><?php echo $total_dp_c3; ?>&nbsp;</td>
            <td width="12%" align="center"><?php echo $total_dp_c4; ?>&nbsp;</td>
            <td width="12%" align="center"><?php echo $total_dp_c5; ?>&nbsp;</td>
            <td width="12%" align="center"><?php echo $total_dp_c6; ?>&nbsp;</td>
			<td width="12%" align="center"><?php echo $total_dp_c1+$total_dp_c2+$total_dp_c3+$total_dp_c4+$total_dp_c5+$total_dp_c6; ?>&nbsp;</td>
			
          <tr bordercolor="#0000FF" bgcolor="#FFFFFF"> 
            <td width="27%"><strong>Proceso Pte.</strong></td>
            <td width="12%" align="center"><?php echo $total_d_parcial_proceso_c1; ?>&nbsp;</td>
            <td width="12%" align="center"><?php echo $total_d_parcial_proceso_c2; ?>&nbsp;</td>
            <td width="12%" align="center"><?php echo $total_d_parcial_proceso_c3; ?>&nbsp;</td>
            <td width="12%" align="center"><?php echo $total_d_parcial_proceso_c4; ?>&nbsp;</td>
            <td width="12%" align="center"><?php echo $total_d_parcial_proceso_c5; ?>&nbsp;</td>
            <td width="12%" align="center"><?php echo $total_d_parcial_proceso_c6; ?>&nbsp;</td>
            <td width="12%" align="center"><?php echo $total_d_parcial_proceso_c1+$total_d_parcial_proceso_c2+$total_d_parcial_proceso_c3+$total_d_parcial_proceso_c4+$total_d_parcial_proceso_c5+$total_d_parcial_proceso_c6; ?>&nbsp;</td>
          </tr>
          <tr bordercolor="#0000FF" bgcolor="#FFFFFF"> 
            <td width="27%"><strong>Venta</strong></td>
            <td width="12%" align="center"><?php echo $total_d_parcial_venta_c1; ?>&nbsp;</td>
            <td width="12%" align="center"><?php echo $total_d_parcial_venta_c2; ?>&nbsp;</td>
            <td width="12%" align="center"><?php echo $total_d_parcial_venta_c3; ?>&nbsp;</td>
            <td width="12%" align="center"><?php echo $total_d_parcial_venta_c4; ?>&nbsp;</td>
            <td width="12%" align="center"><?php echo $total_d_parcial_venta_c5; ?>&nbsp;</td>
            <td width="12%" align="center"><?php echo $total_d_parcial_venta_c6; ?>&nbsp;</td>
			<td width="12%" align="center"><?php echo $total_d_parcial_venta_c1+$total_d_parcial_venta_c2+$total_d_parcial_venta_c3+$total_d_parcial_venta_c4+$total_d_parcial_venta_c5+$total_d_parcial_venta_c6; ?>&nbsp;</td>
          </tr>
          <tr bordercolor="#0000FF" bgcolor="#FFFFFF"> 
            <td width="27%"><strong>Total</strong></td>
            <td width="12%" align="center"><font color='#FF0000'><strong><?php echo $total_dp_c1+$total_d_parcial_venta_c1+$total_d_parcial_proceso_c1; ?>&nbsp;</strong></font></td>
            <td width="12%" align="center"><font color='#FF0000'><strong><?php echo $total_dp_c2+$total_d_parcial_venta_c2+$total_d_parcial_proceso_c2; ?>&nbsp;</strong></font></td>
            <td width="12%" align="center"><font color='#FF0000'><strong><?php echo $total_dp_c3+$total_d_parcial_venta_c3+$total_d_parcial_proceso_c3; ?>&nbsp;</strong></font></td>
            <td width="12%" align="center"><font color='#FF0000'><strong><?php echo $total_dp_c4+$total_d_parcial_venta_c4+$total_d_parcial_proceso_c4; ?>&nbsp;</strong></font></td>
            <td width="12%" align="center"><font color='#FF0000'><strong><?php echo $total_dp_c5+$total_d_parcial_venta_c5+$total_d_parcial_proceso_c5; ?>&nbsp;</strong></font></td>
            <td width="12%" align="center"><font color='#FF0000'><strong><?php echo $total_dp_c6+$total_d_parcial_venta_c6+$total_d_parcial_proceso_c6; ?>&nbsp;</strong></font></td>
			<?php $total_circuitos=$total_dp_c1+$total_d_parcial_venta_c1+$total_d_parcial_proceso_c1+$total_dp_c2+$total_d_parcial_venta_c2+$total_d_parcial_proceso_c2+$total_dp_c3+$total_d_parcial_venta_c3+$total_d_parcial_proceso_c3+$total_dp_c4+$total_d_parcial_venta_c4+$total_d_parcial_proceso_c4+$total_dp_c5+$total_d_parcial_venta_c5+$total_d_parcial_proceso_c5+$total_dp_c6+$total_d_parcial_venta_c6+$total_d_parcial_proceso_c6;?>
            <td width="12%" align="center"><font color='#FF0000'><strong><?php echo $total_circuitos;?>&nbsp;</strong></font></td>
          </tr>
        </table>
		  <p>&nbsp;</p>
          <table width="954"  border="1" cellpadding="0" cellspacing="0" bordercolor="#b26c4a" class="TablaDetalle">
            <tr class="ColorTabla01"> 
              <td colspan="3" ><div align="center"><font color="#FFFFFF"><strong>Novedades 
                  Relevantes </strong></font></div></td>
            </tr>
            <tr class="ColorTabla01"> 
              <td width="124" align="center"><strong>fecha</strong></td>
              <td width="88" align="center"><strong>Turno</strong></td>
              <td width="720" align="center"><strong>Observacion</strong></td>
            </tr>
			<?php $consulta="select * from ref_web.novedades_jefe_pte where fecha between '".$FechaInicio."' and '".$FechaTermino."' and pte='S' order by fecha";
			   //echo $consulta;
			   $respuesta = mysqli_query($link, $consulta);
 		       while ($row= mysqli_fetch_array($respuesta))
			        {
					   echo '<tr>';
					   echo '<td width="106" align="center" class="detalle01">'.$row[FECHA].'</td>';
                       echo '<td width="88" align="center" >'.$row[TURNO].'</td>';
                       echo '<td width="519" align="left" >'.$row[NOVEDAD].'</td>';
					   echo '</tr>';
					
					
					}
			
			
			
			?>
          </table>
		  </div></td>
    </tr>
    <tr>

	<td height="30" align="center"> <div align="center"><font face="Arial, Helvetica, sans-serif">
        <input name="btnimprimir" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Imprimir(this.form)">
        <?php
	  		//Campo oculto.
			echo '<input name="opcion" type="hidden" size="40" value="'.$opcion.'">';
	  	?>
        <input type="button" name="btnexcel3" value="Excel" style="width:70" onClick="Excel()" title="Ejecutar Planilla Excel con datos de informes">
        <input name="btnsalir" type="button" style="width:70" value="Salir" onClick="Salir()">
        </font></div></td>
		  </tr>
    <tr> 
	  <td height="40" align="center" valign="middle"> <font face="Arial, Helvetica, sans-serif">&nbsp; 
        </font><br>

 <?php /*include("../principal/pie_pagina.php");*/ ?>
  <font face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
  </font> <font face="Arial, Helvetica, sans-serif">&nbsp; </font><font face="Arial, Helvetica, sans-serif">&nbsp; 
  </font> 
</FORM>
</BODY>
</HTML>
<?php
	if (isset($Mensaje))
	{
		echo "<script languaje='javascript'>";
		echo "alert('".$Mensaje."')";
		echo "</script>";
	
	}
?>

