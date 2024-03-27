<?
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	
	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");
	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

if(!isset($Ano))
 	$Ano=date('Y');
if(!isset($Mes))
 	$Mes=date('m');
if(!isset($AnoFin))
 	$AnoFin=date('Y');
if(!isset($MesFin))
 	$MesFin=date('m');
if(!isset($CmbContr))
	$CmbContr='-1';		
?>
<html>
<head>
<title>Reporte Ingresos Proyectados Balance Excel</title>
<link href="estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
</style></head>
<body>
<form name="frmPrincipal" action="" method="post">
  <table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
    <tr>
      <td align="center" colspan="25">BALANCE DIVISIONAL</td>
    </tr>
    <?	
	 $Buscar='S';	
  			 if($Buscar=='S')
			 {				 
			    $ArrTotalRealTM=array();$ArrTotalPptoTM=array();$ArrTotalRealTMF=array();$ArrTotalPptoTMF=array();
				$ArrSubTotalReal=array();$ArrSubTotalPpto=array();$ArrSubTotalReal2=array();$ArrSubTotalPpto2=array();
				$ArrSubTotalRechaReal=array();$ArrSubTotalRechaPpto=array();$ArrTotalRechaReal=array();$ArrTotalRechaPpto=array();
				$Consulta="select valor_subclase1,cod_subclase from proyecto_modernizacion.sub_clase where cod_clase='31023' and valor_subclase1<>''";
				$Resp=mysqli_query($link, $Consulta);
				while ($Fila=mysql_fetch_array($Resp))
				{	
				    $CodigoArea=$Fila["cod_subclase"];				    
					$Dato=$Fila["valor_subclase1"];	
					$DatoArea=explode('//',$Dato);
					$NomArea=$DatoArea[0];
					?>
    <tr>
      <td align="center" colspan="2"><? echo strtoupper($NomArea);?></td>
      <?
					for($i=$Mes;$i<=$MesFin;$i++)
					{
					?>
      <td align="center" colspan="2"><? echo $Meses[$i-1]."&nbsp;".$Ano?></td>
      <?	
					}
					?>
    </tr>
    <tr>
      <td align="center" colspan="2">Tipo/Calidad</td>
      <?
						for($i=$Mes;$i<=$MesFin;$i++)
						{
						?>
      <td width="100"  align="center" >Real</td>
      <td width="100"  align="center">Proyectado</td>
      <?	
						}
						?>
    </tr>
    <?
					$CodDiv=explode('~',$DatoArea[1]);
					while(list($c,$v)=each($CodDiv))
					{
						$ConsultaDivision="select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31024' and cod_subclase='".$v."'";
						//echo $ConsultaDivision;
						$RespDivision=mysql_query($ConsultaDivision);
						while ($FilaDivision=mysql_fetch_array($RespDivision))
						{
						   $CodDivision=$FilaDivision["cod_subclase"];
						   $NomDivision=$FilaDivision["nombre_subclase"];
						   if($CodDivision=='8'||$CodDivision=='9')
						   {
						      $CorteNombre=explode('(',$NomDivision);
							  $NomDivision=$CorteNombre[0];
						   }
						   else
						      $NomDivision;	  						   
						  	echo "<tr>";
							echo "<td rowspan='3'>".$NomDivision."</td>";
							echo "<td>TM</td>";
							for($i=$Mes;$i<=$MesFin;$i++)
							{
							    $ValorRealTM=DatosProyectadosTratam($Ano,$i,$CodigoArea,$CodDivision,'TMS','R');							
							    $ValorPptoTM=DatosProyectadosTratam($Ano,$i,$CodigoArea,$CodDivision,'TMS','P');	
									if($CodDivision=='7')
									{
										$DatoRealPreRe=DatosProyectadosTratam($Ano,$i,'2','7','SECO RE','R');							
										$DatoPptoPreRe=DatosProyectadosTratam($Ano,$i,'2','7','SECO RE','P');
										$DatoRealPreFu=DatosProyectadosTratam($Ano,$i,'2','7','SECO FU','R');							
										$DatoPptoPreFu=DatosProyectadosTratam($Ano,$i,'2','7','SECO FU','P');
										$ValorRealTM=$DatoRealPreRe+$DatoRealPreFu;	
										$ValorPptoTM=$DatoPptoPreRe+$DatoPptoPreFu;																																							
									}
							    if($CodigoArea==3||$CodigoArea==1)
								{						
									$ArrTotalRealTM[$i][0]=$ArrTotalRealTM[$i][0]+$ValorRealTM;
									$ArrTotalPptoTM[$i][0]=$ArrTotalPptoTM[$i][0]+$ValorPptoTM;
								}	
								echo "<td align='right'>".number_format($ValorRealTM,0,',','.')."</td>";
								echo "<td align='right'>".number_format($ValorPptoTM,0,',','.')."</td>";
							}	
						  	echo "</tr>";
						  	echo "<tr>";
							echo "<td>LEY %</td>";
							for($i=$Mes;$i<=$MesFin;$i++)
							{	
							    $DatoRealLey=DatosProyectadosTratam($Ano,$i,$CodigoArea,$CodDivision,'COBRE','R');
								$DatoPptoLey=DatosProyectadosTratam($Ano,$i,$CodigoArea,$CodDivision,'COBRE','P');
																					
							    $ValorRealLey=DatosProyectadosTratam($Ano,$i,$CodigoArea,$CodDivision,'COBRE','R')*100;	
							    $ValorPptoLey=DatosProyectadosTratam($Ano,$i,$CodigoArea,$CodDivision,'COBRE','P')*100;							
								echo "<td align='right'>".number_format($ValorRealLey,1,',','.')."%</td>";
								echo "<td align='right'>".number_format($ValorPptoLey,1,',','.')."%</td>";
							}	
						  	echo "</tr>";
						  	echo "<tr>";
							echo "<td>TMF</td>";
							for($i=$Mes;$i<=$MesFin;$i++)
							{	
							    $ValorRealTM=DatosProyectadosTratam($Ano,$i,$CodigoArea,$CodDivision,'TMS','R');							
							    $ValorPptoTM=DatosProyectadosTratam($Ano,$i,$CodigoArea,$CodDivision,'TMS','P');	
									if($CodDivision=='7')
									{
										$DatoRealPreRe=DatosProyectadosTratam($Ano,$i,'2','7','SECO RE','R');							
										$DatoPptoPreRe=DatosProyectadosTratam($Ano,$i,'2','7','SECO RE','P');
										$DatoRealPreFu=DatosProyectadosTratam($Ano,$i,'2','7','SECO FU','R');							
										$DatoPptoPreFu=DatosProyectadosTratam($Ano,$i,'2','7','SECO FU','P');
										$ValorRealTM=$DatoRealPreRe+$DatoRealPreFu;	
										$ValorPptoTM=$DatoPptoPreRe+$DatoPptoPreFu;																																							
									}						
							    $DatoRealLey=DatosProyectadosTratam($Ano,$i,$CodigoArea,$CodDivision,'COBRE','R');
								$DatoPptoLey=DatosProyectadosTratam($Ano,$i,$CodigoArea,$CodDivision,'COBRE','P');
															
								$ValorRealTMF=$ValorRealTM*$DatoRealLey;
								$ValorPptoTMF=$ValorPptoTM*$DatoPptoLey;
								
								$ArrTotalRealTMF[$i][0]=$ArrTotalRealTMF[$i][0]+$ValorRealTMF;
								$ArrTotalPptoTMF[$i][0]=$ArrTotalPptoTMF[$i][0]+$ValorPptoTMF;					
								echo "<td align='right'>".number_format($ValorRealTMF,0,',','.')."</td>";
								echo "<td align='right'>".number_format($ValorPptoTMF,0,',','.')."</td>";
							}	
						  echo "</tr>";
						}											 
					}
						if($CodigoArea!='2')
						{
							echo "<tr>";
							echo "<td rowspan='3'>TOTAL</td>";
							echo "<td >TM</td>";
							for($i=$Mes;$i<=$MesFin;$i++)
							{
								$ValorTotalReal=$ArrTotalRealTM[$i][0];
								$ValorTotalPpto=$ArrTotalPptoTM[$i][0];
								echo "<td align='right'>".number_format($ValorTotalReal,0,',','.')."</td>";
								echo "<td align='right'>".number_format($ValorTotalPpto,0,',','.')."</td>";
							}	
							echo "</tr>";
							echo "<tr>";
							echo "<td >LEY %</td>";
							for($i=$Mes;$i<=$MesFin;$i++)
							{	
								$ValorTotalTMFReal=$ArrTotalRealTMF[$i][0];
								$ValorTotalTMFPpto=$ArrTotalPptoTMF[$i][0];
								$ValorTotalReal=$ArrTotalRealTM[$i][0];
								$ValorTotalPpto=$ArrTotalPptoTM[$i][0];
								if($ValorTotalReal>0)
									$ValorTotalLeyReal=($ValorTotalTMFReal/$ValorTotalReal)*100;
								else
									$ValorTotalLeyReal=0;
								if($ValorTotalPpto>0)		
									$ValorTotalLeyPpto=($ValorTotalTMFPpto/$ValorTotalPpto)*100;								
								else
									$ValorTotalLeyPpto=0;
								echo "<td align='right' >".number_format($ValorTotalLeyReal,1,',','.')."%</td>";
								echo "<td align='right' >".number_format($ValorTotalLeyPpto,1,',','.')."%</td>";
							}	
							echo "</tr>";
							echo "<tr>";
							echo "<td >TMF</td>";
							for($i=$Mes;$i<=$MesFin;$i++)
							{	
								$ValorTotalTMFReal=$ArrTotalRealTMF[$i][0];
								$ValorTotalTMFPpto=$ArrTotalPptoTMF[$i][0];
								echo "<td align='right' >".number_format($ValorTotalTMFReal,0,',','.')."</td>";
								echo "<td align='right' >".number_format($ValorTotalTMFPpto,0,',','.')."</td>";
							}	
						  echo "</tr>";
						}  
						if($CodigoArea=='1')
						{
						   echo "<tr>";
						   echo "<td colspan='2'>&nbsp;</td>";
						   for($i=$Mes;$i<=$MesFin;$i++)
						   {
							   $ValorTotalReal=$ArrTotalRealTM[$i][0];
							   $ValorTotalPpto=$ArrTotalPptoTM[$i][0];
							   $Dato=$ValorTotalReal-$ValorTotalPpto;						      
							   echo "<td>&nbsp;</td>";
							   echo "<td align='right'>".number_format($Dato,0,',','.')."</td>";
						   }
						   echo "</tr>";
						}
						//LIMPIEZA DE LOS ARREGLOS
					   for($i=$Mes;$i<=$MesFin;$i++)
					   {						   
						$ArrTotalRealTM[$i][0]=0;$ArrTotalPptoTM[$i][0]=0;
						$ArrTotalRealTMF[$i][0]=0;$ArrTotalPptoTMF[$i][0]=0;
					   }
				 }	
				 ?>
    <tr>
      <td  align="center" colspan="2">PAGABLES</td>
      <?
					for($i=$Mes;$i<=$MesFin;$i++)
					{
					?>
      <td align="center" colspan="2"><? echo $Meses[$i-1]."&nbsp;".$Ano?></td>
      <?	
					}
					?>
    </tr>
    <tr>
      <td  align="center" colspan="2">CATODOS</td>
      <?
						for($i=$Mes;$i<=$MesFin;$i++)
						{
						?>
      <td width="100"  align="center" >Real</td>
      <td width="100"  align="center">Proyectado</td>
      <?	
						}
						?>
    </tr>
    <?
						$Consulta="select valor_subclase1,cod_subclase from proyecto_modernizacion.sub_clase where cod_clase='31023' and valor_subclase1<>'' and cod_subclase='1'";
						$Resp=mysqli_query($link, $Consulta);
						while ($Fila=mysql_fetch_array($Resp))
						{	
							$CodigoArea=$Fila["cod_subclase"];				    
							$Dato=$Fila["valor_subclase1"];	
							$DatoArea=explode('//',$Dato);
							$NomArea=$DatoArea[0];
							$CodDiv=explode('~',$DatoArea[1]);
							while(list($c,$v)=each($CodDiv))
							{
								$ConsultaDivision="select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31024' and cod_subclase='".$v."'";
								//echo $ConsultaDivision;
								$RespDivision=mysql_query($ConsultaDivision);
								while ($FilaDivision=mysql_fetch_array($RespDivision))
								{	
								   $CodDivision=$FilaDivision["cod_subclase"];
								   $NomDivision=$FilaDivision["nombre_subclase"];
								   if($CodDivision==1)                
									  $NomDivision="Ex Cucons Enami";
								   if($CodDivision==2)
									  $NomDivision="Ex cucons Sur Andes";
								   if($CodDivision==3)
									  $NomDivision="Ex cucons El Teniente";
								   if($CodDivision==4)
									  $NomDivision="Ex cucons Andina";
								   if($CodDivision==5)
									  $NomDivision="Ex cucons CN";
								   if($CodDivision==7)
									  $NomDivision="Ex precipitados Enami";									  
								   echo "<tr>";
									 echo "<td >".$NomDivision."</td>";
									 echo "<td align='center'>TMF</td>";
								   for($i=$Mes;$i<=$MesFin;$i++)
								   {	
										$FecRealAnt=explode('-',date('Y-m-d',mktime(0,0,0,(intval($i)-1),1,$Ano)));
										$FecRealA�o=$FecRealAnt[0];
										$FecRealMes=$FecRealAnt[1];
										$ValorMes1=DatosProyectadosTratam($FecRealA�o,$FecRealMes,'1',$CodDivision,'TMS','R');//Valor TMS Enami Real; 1 Mes Atras.
										//if($FecRealMes==1)
										 //echo "mes atras 1   ".$ValorMes1."<br>";
										$FecRealAnt=explode('-',date('Y-m-d',mktime(0,0,0,(intval($i)-2),1,$Ano)));
										$FecRealA�o=$FecRealAnt[0];
										$FecRealMes=$FecRealAnt[1];
										$ValorMes2=DatosProyectadosTratam($FecRealA�o,$FecRealMes,'1',$CodDivision,'TMS','R');//Valor TMS Enami Real; 2 Mes Atras.
										//echo "2 meses atras   ".$ValorMes2;
										//CALCULO REAL COBRE MES ANTERIORES
										$FecRealAnt=explode('-',date('Y-m-d',mktime(0,0,0,(intval($i)-1),1,$Ano)));
										$FecRealA�o=$FecRealAnt[0];
										$FecRealMes=$FecRealAnt[1];
										$ValorMes3=DatosProyectadosTratam($FecRealA�o,$FecRealMes,'1',$CodDivision,'COBRE','R');//Valor COBRE Enami Real; 1 Mes Atras.
										$FecRealAnt=explode('-',date('Y-m-d',mktime(0,0,0,(intval($i)-2),1,$Ano)));
										$FecRealA�o=$FecRealAnt[0];
										$FecRealMes=$FecRealAnt[1];
										$ValorMes4=DatosProyectadosTratam($FecRealA�o,$FecRealMes,'1',$CodDivision,'COBRE','R');//Valor COBRE Enami Real; 2 Mes Atras.
																					
										//CALCULO PPTO TMS MESES ATRAS
										$FecPptoAnt=explode('-',date('Y-m-d',mktime(0,0,0,(intval($i)-1),1,$Ano)));
										$FecPptoA�o=$FecPptoAnt[0];
										$FecPptoMes=$FecPptoAnt[1];
										$ValorMesPpto1=DatosProyectadosTratam($FecPptoA�o,$FecPptoMes,'1',$CodDivision,'TMS','P');//Valor TMS Enami Real; 1 Mes Atras.
										$FecPptoAnt=explode('-',date('Y-m-d',mktime(0,0,0,(intval($i)-2),1,$Ano)));
										$FecPptoA�o=$FecPptoAnt[0];
										$FecPptoMes=$FecPptoAnt[1];
										$ValorMesPpto2=DatosProyectadosTratam($FecPptoA�o,$FecPptoMes,'1',$CodDivision,'TMS','P');//Valor TMS Enami Real; 2 Mes Atras.
										//CALCULO PPTO COBRE MESES ATRAS
										$FecPptoAnt=explode('-',date('Y-m-d',mktime(0,0,0,(intval($i)-1),1,$Ano)));
										$FecPptoA�o=$FecPptoAnt[0];
										$FecPptoMes=$FecPptoAnt[1];
										$ValorMesPpto3=DatosProyectadosTratam($FecPptoA�o,$FecPptoMes,'1',$CodDivision,'COBRE','P');//Valor COBRE Enami Real; 1 Mes Atras.
										$FecPptoAnt=explode('-',date('Y-m-d',mktime(0,0,0,(intval($i)-2),1,$Ano)));
										$FecPptoA�o=$FecPptoAnt[0];
										$FecPptoMes=$FecPptoAnt[1];
										$ValorMesPpto4=DatosProyectadosTratam($FecPptoA�o,$FecPptoMes,'1',$CodDivision,'COBRE','P');//Valor COBRE Enami Real; 2 Mes Atras.
										
										$ValorMes1RealAnteriorTMF=$ValorMes1*$ValorMes3;//TMF real 1 Mes Atras
										$ValorMes2RealAnteriorTMF=$ValorMes2*$ValorMes4;//TMF real 2 Meses Atras
										$ValorMes1PptoAnteriorTMF=$ValorMesPpto1*$ValorMesPpto3;//TMF ppto 1 Mes Atras
										$ValorMes2PptoAnteriorTMF=$ValorMesPpto2*$ValorMesPpto4;//TMF ppto 2 Mes Atras
										
										$ConsultaValor="select cod_subclase, valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='31041' and cod_subclase in ('1')";
										$RespValor=mysql_query($ConsultaValor);  										    
										if($FilaValor=mysql_fetch_array($RespValor))
											$Numero=$FilaValor["valor_subclase1"];
										$ConsultaValor1="select cod_subclase, valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='31041' and cod_subclase in ('2')";
										$RespValor1=mysql_query($ConsultaValor1);  
										if($FilaValor1=mysql_fetch_array($RespValor1))											    
											$Numero1=$FilaValor1["valor_subclase1"];
																				
										$ValorExCuconReal=($ValorMes2RealAnteriorTMF+$ValorMes1RealAnteriorTMF)/2*(100-$Numero-$Numero1)/100;
										$ValorExCuconPpto=($ValorMes2PptoAnteriorTMF+$ValorMes1PptoAnteriorTMF)/2*(100-$Numero-$Numero1)/100;										
									 
									 echo "<td align='right'>".number_format($ValorExCuconReal,0,',','.')."</td>";
									 echo "<td align='right'>".number_format($ValorExCuconPpto,0,',','.')."</td>";
		
									 $ArrSubTotalReal[$i][0]=$ArrSubTotalReal[$i][0]+$ValorExCuconReal;
									 $ArrSubTotalPpto[$i][0]=$ArrSubTotalPpto[$i][0]+$ValorExCuconPpto;
								   }			
								   echo "</tr>";
								}   
							}
						}
						   echo "<tr>";//SUBTOTALES PRIMEROS CATODOS
						   	 echo "<td colspan='2'>SUBTOTAL</td>";
							 for($i=$Mes;$i<=$MesFin;$i++)
							 {
							    $ValorSubTotalReal=$ArrSubTotalReal[$i][0];
								$ValorSubTotalPpto=$ArrSubTotalPpto[$i][0];
								echo "<td align='right'>".number_format($ValorSubTotalReal,0,',','.')."</td>";
							    echo "<td  align='right'>".number_format($ValorSubTotalPpto,0,',','.')."</td>";
								 $ArrTotalRechaReal[$i][0]=$ArrTotalRechaReal[$i][0]+$ValorSubTotalReal;							 
								 $ArrTotalRechaPpto[$i][0]=$ArrTotalRechaPpto[$i][0]+$ValorSubTotalPpto;							 
							 }			
						   echo "</tr>";
				 		//CONSULTA PARA OBTENER LOS CATODOS SEGUNDA ETAPA
						$Consulta="select valor_subclase1,cod_subclase from proyecto_modernizacion.sub_clase where cod_clase='31023' and valor_subclase1<>'' and cod_subclase='3'";
						$Resp=mysqli_query($link, $Consulta);
						while ($Fila=mysql_fetch_array($Resp))
						{	
							$CodigoArea=$Fila["cod_subclase"];				    
							$Dato=$Fila["valor_subclase1"];	
							$DatoArea=explode('//',$Dato);
							$NomArea=$DatoArea[0];
							$CodDiv=explode('~',$DatoArea[1]);
							while(list($c,$v)=each($CodDiv))
							{
								$ConsultaDivision="select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31024' and cod_subclase='".$v."'";
								//echo $ConsultaDivision;
								$RespDivision=mysql_query($ConsultaDivision);
								while ($FilaDivision=mysql_fetch_array($RespDivision))
								{	
								   $CodDivision=$FilaDivision["cod_subclase"];
								   $NomDivision=$FilaDivision["nombre_subclase"];
								   if($CodDivision==3)
								      $NomDivision="Ex �nodos Teniente";
								   if($CodDivision==2)
								      $NomDivision="Ex �nodos Sur Andes";
								   if($CodDivision==1)
								      $NomDivision="Ex �nodos Enami";									  
								   echo "<tr>";
									 echo "<td>".$NomDivision."</td>";
									 echo "<td align='center'>TMF</td>";
								   for($i=$Mes;$i<=$MesFin;$i++)
								   {
									$FecRealAnt=explode('-',date('Y-m-d',mktime(0,0,0,(intval($i)-1),1,$Ano)));
									$FecRealA�o=$FecRealAnt[0];
									$FecRealMes=$FecRealAnt[1];
									$ValorMes1=DatosProyectadosTratam($FecRealA�o,$FecRealMes,'3',$CodDivision,'TMS','R');//Valor TMS CN Real; 1 Mes Atras.
									$FecRealAnt=explode('-',date('Y-m-d',mktime(0,0,0,(intval($i)-1),1,$Ano)));
									$FecRealA�o=$FecRealAnt[0];
									$FecRealMes=$FecRealAnt[1];
									$ValorMes2=DatosProyectadosTratam($FecRealA�o,$FecRealMes,'3',$CodDivision,'COBRE','R');//Valor COBRE CN Real; 2 Mes Atras.
									
									$FecPptoAnt=explode('-',date('Y-m-d',mktime(0,0,0,(intval($i)-1),1,$Ano)));
									$FecPptoA�o=$FecPptoAnt[0];
									$FecPptoMes=$FecPptoAnt[1];
									$ValorMesPpto1=DatosProyectadosTratam($FecPptoA�o,$FecPptoMes,'3',$CodDivision,'TMS','P');//Valor TMS CN Ppto; 1 Mes Atras.
									$FecPptoAnt=explode('-',date('Y-m-d',mktime(0,0,0,(intval($i)-1),1,$Ano)));
									$FecPptoA�o=$FecPptoAnt[0];
									$FecPptoMes=$FecPptoAnt[1];
									$ValorMesPpto2=DatosProyectadosTratam($FecPptoA�o,$FecPptoMes,'3',$CodDivision,'COBRE','P');//Valor COBRE CN Ppto; 2 Mes Atras.
									
									$ValorTMFRealTeniente=$ValorMes1+$ValorMes2;
									$ValorTMFPptoTeniente=$ValorMesPpto1+$ValorMesPpto2;
									
									$ConsultaValor1="select cod_subclase, valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='31041' and cod_subclase in ('2')";
									$RespValor1=mysql_query($ConsultaValor1);  
									if($FilaValor1=mysql_fetch_array($RespValor1))											    
										$Numero1=$FilaValor1["valor_subclase1"];

									$ValorTMFEXAnoReal=$ValorTMFRealTeniente*(100-$Numero1)/100;
									$ValorTMFEXAnoPpro=$ValorTMFPptoTeniente*(100-$Numero1)/100;
								   						   
									 echo "<td align='right'>".number_format($ValorTMFEXAnoReal,0,',','.')."</td>";
									 echo "<td align='right'>".number_format($ValorTMFEXAnoPpro,0,',','.')."</td>";

									 $ArrSubTotalReal2[$i][0]=$ArrSubTotalReal2[$i][0]+$ValorTMFEXAnoReal;
									 $ArrSubTotalPpto2[$i][0]=$ArrSubTotalPpto2[$i][0]+$ValorTMFEXAnoPpro;
								   }
								   			
								   echo "</tr>";			   						 
								 }
							  }
						   }
						   echo "<tr>";
							 echo "<td>Ex �nodos El Teniente ex MBCH</td>";
							 echo "<td align='center'>TMF</td>";
								   for($i=$Mes;$i<=$MesFin;$i++)
								   {
									 echo "<td align='right'>&nbsp;</td>";
									 echo "<td align='right'>&nbsp;</td>";									 
								   } 	 
						   echo "</tr>";
							echo "<tr>";
							echo "<td>Ex Blister</td>";
							echo "<td align='center'>TMF</td>";
							   for($i=$Mes;$i<=$MesFin;$i++)
							   {
								$FecRealAnt=explode('-',date('Y-m-d',mktime(0,0,0,(intval($i)-1),1,$Ano)));
								$FecRealA�o=$FecRealAnt[0];
								$FecRealMes=$FecRealAnt[1];
								$ValorMes1=DatosProyectadosTratam($FecRealA�o,$FecRealMes,'2','8','TMS','R');//Valor TMS CN Real; 1 Mes Atras.
								$FecRealAnt=explode('-',date('Y-m-d',mktime(0,0,0,(intval($i)-1),1,$Ano)));
								$FecRealA�o=$FecRealAnt[0];
								$FecRealMes=$FecRealAnt[1];
								$ValorMes2=DatosProyectadosTratam($FecRealA�o,$FecRealMes,'2','8','COBRE','R');//Valor COBRE CN Real; 2 Mes Atras.
								
								$FecPptoAnt=explode('-',date('Y-m-d',mktime(0,0,0,(intval($i)-1),1,$Ano)));
								$FecPptoA�o=$FecPptoAnt[0];
								$FecPptoMes=$FecPptoAnt[1];
								$ValorMesPpto1=DatosProyectadosTratam($FecPptoA�o,$FecPptoMes,'2','8','TMS','P');//Valor TMS CN Ppto; 1 Mes Atras.
								$FecPptoAnt=explode('-',date('Y-m-d',mktime(0,0,0,(intval($i)-1),1,$Ano)));
								$FecPptoA�o=$FecPptoAnt[0];
								$FecPptoMes=$FecPptoAnt[1];
								$ValorMesPpto2=DatosProyectadosTratam($FecPptoA�o,$FecPptoMes,'2','8','COBRE','P');//Valor COBRE CN Ppto; 2 Mes Atras.
								
								$DatoReal1=$ValorMes1*$ValorMes2;
								$DatoPpto1=$ValorMesPpto1*$ValorMesPpto2;
								
									$FecRealAnt=explode('-',date('Y-m-d',mktime(0,0,0,(intval($i)-1),1,$Ano)));
									$FecRealA�o=$FecRealAnt[0];
									$FecRealMes=$FecRealAnt[1];
									$ValorMes1=DatosProyectadosTratam($FecRealA�o,$FecRealMes,'2','9','TMS','R');//Valor TMS CN Real; 1 Mes Atras.
									$FecRealAnt=explode('-',date('Y-m-d',mktime(0,0,0,(intval($i)-1),1,$Ano)));
									$FecRealA�o=$FecRealAnt[0];
									$FecRealMes=$FecRealAnt[1];
									$ValorMes2=DatosProyectadosTratam($FecRealA�o,$FecRealMes,'2','9','COBRE','R');//Valor COBRE CN Real; 2 Mes Atras.
									
									$FecPptoAnt=explode('-',date('Y-m-d',mktime(0,0,0,(intval($i)-1),1,$Ano)));
									$FecPptoA�o=$FecPptoAnt[0];
									$FecPptoMes=$FecPptoAnt[1];
									$ValorMesPpto1=DatosProyectadosTratam($FecPptoA�o,$FecPptoMes,'2','9','TMS','P');//Valor TMS CN Ppto; 1 Mes Atras.
									$FecPptoAnt=explode('-',date('Y-m-d',mktime(0,0,0,(intval($i)-1),1,$Ano)));
									$FecPptoA�o=$FecPptoAnt[0];
									$FecPptoMes=$FecPptoAnt[1];
									$ValorMesPpto2=DatosProyectadosTratam($FecPptoA�o,$FecPptoMes,'2','9','COBRE','P');//Valor COBRE CN Ppto; 2 Mes Atras.
								
								    $DatoReal2=$ValorMes1*$ValorMes2;
									$DatoPpto2=$ValorMesPpto1*$ValorMesPpto2;
								
								$ConsultaValor1="select cod_subclase, valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='31041' and cod_subclase in ('2')";
								$RespValor1=mysql_query($ConsultaValor1);  
								if($FilaValor1=mysql_fetch_array($RespValor1))											    
									$Numero1=$FilaValor1["valor_subclase1"];
	
								$ValorTMFEXAnoReal1=($DatoReal1+$DatoReal2)*(100-$Numero1)/100;
								$ValorTMFEXAnoPpro1=($DatoPpto1+$DatoPpto2)*(100-$Numero1)/100;
													   
								 echo "<td align='right'>".number_format($ValorTMFEXAnoReal1,0,',','.')."</td>";
								 echo "<td align='right'>".number_format($ValorTMFEXAnoPpro1,0,',','.')."</td>";

									 $ArrSubTotalReal2[$i][0]=$ArrSubTotalReal2[$i][0]+$ValorTMFEXAnoReal1;
									 $ArrSubTotalPpto2[$i][0]=$ArrSubTotalPpto2[$i][0]+$ValorTMFEXAnoPpro1;
							   }								   			
							 echo "</tr>";			   						 
								     	 
						   echo "<tr>";//SUBTOTALES SEGUNDA CARTODOS
							 echo "<td colspan='2'>SUBTOTAL</td>";
							 for($i=$Mes;$i<=$MesFin;$i++)
							 {
							    $ValorSubTotalReal2=$ArrSubTotalReal2[$i][0];
								$ValorSubTotalPpto2=$ArrSubTotalPpto2[$i][0];
								echo "<td  align='right'>".number_format($ValorSubTotalReal2,0,',','.')."</td>";
								echo "<td  align='right'>".number_format($ValorSubTotalPpto2,0,',','.')."</td>";
								 $ArrTotalRechaReal[$i][0]=$ArrTotalRechaReal[$i][0]+$ValorSubTotalReal2;							 
								 $ArrTotalRechaPpto[$i][0]=$ArrTotalRechaPpto[$i][0]+$ValorSubTotalPpto2;							 
							 }												
						   echo "</tr>";
						?>						
							<tr>
							<td  align="center" colspan="2">RECHAZADOS</td>
							<?
							for($i=$Mes;$i<=$MesFin;$i++)
							{
							?>
							<td align="center" colspan="2"><? echo $Meses[$i-1]."&nbsp;".$Ano?></td>
							<?	
							}
							?>            
							</tr>
							  <tr>
								<td  align="center" colspan="2">CATODOS</td>						   	
								<?
								for($i=$Mes;$i<=$MesFin;$i++)
								{
								?>
								<td width="100" align="center" >Real</td>
								<td width="100" align="center">Proyectado</td>
								<?	
								}
								?>
							  </tr>							 			
						<?
						   $ArrDiferenciasReal=array();$ArrDiferenciasPpto=array();
						   echo "<tr>";
							 echo "<td>C�todos ENM RCH ex Sur Andes (RCH)</td>";
							 echo "<td align='center'>TMF</td>";
								   for($i=$Mes;$i<=$MesFin;$i++)
								   {
										$FecRealAnt=explode('-',date('Y-m-d',mktime(0,0,0,(intval($i)-1),1,$Ano)));
										$FecRealA�o=$FecRealAnt[0];
										$FecRealMes=$FecRealAnt[1];
										$ValorMes1=DatosProyectadosTratam($FecRealA�o,$FecRealMes,'3','2','TMS','R');//Valor TMS CN Real; 1 Mes Atras.
										$FecRealAnt=explode('-',date('Y-m-d',mktime(0,0,0,(intval($i)-1),1,$Ano)));
										$FecRealA�o=$FecRealAnt[0];
										$FecRealMes=$FecRealAnt[1];
										$ValorMes2=DatosProyectadosTratam($FecRealA�o,$FecRealMes,'3','2','COBRE','R');//Valor COBRE CN Real; 2 Mes Atras.
										
										$FecPptoAnt=explode('-',date('Y-m-d',mktime(0,0,0,(intval($i)-1),1,$Ano)));
										$FecPptoA�o=$FecPptoAnt[0];
										$FecPptoMes=$FecPptoAnt[1];
										$ValorMesPpto1=DatosProyectadosTratam($FecPptoA�o,$FecPptoMes,'3','2','TMS','P');//Valor TMS CN Ppto; 1 Mes Atras.
										$FecPptoAnt=explode('-',date('Y-m-d',mktime(0,0,0,(intval($i)-1),1,$Ano)));
										$FecPptoA�o=$FecPptoAnt[0];
										$FecPptoMes=$FecPptoAnt[1];
										$ValorMesPpto2=DatosProyectadosTratam($FecPptoA�o,$FecPptoMes,'3','2','COBRE','P');//Valor COBRE CN Ppto; 2 Mes Atras.
									    
										$DatoRealTMF=$ValorMes1*$ValorMes2;
										$DatoPptoTMF=$ValorMesPpto1*$ValorMesPpto2;

										$ConsultaValor1="select cod_subclase, valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='31041' and cod_subclase in ('2')";
										$RespValor1=mysql_query($ConsultaValor1);  
										if($FilaValor1=mysql_fetch_array($RespValor1))											    
											$Numero1=$FilaValor1["valor_subclase1"];
										
										$AnodoSurAndesReal=$DatoRealTMF*(100-$Numero1)/100;
										$AnodoSurAndesPpto=$DatoPptoTMF*(100-$Numero1)/100;
										
										$CalculoReal=$DatoRealTMF*(100-$Numero1)/100-$AnodoSurAndesReal;
										$CalculoPpto=$DatoPptoTMF*(100-$Numero1)/100-$AnodoSurAndesPpto;
										if($CalculoReal>$CalculoPpto)
										    $CalculoReal=$CalculoPpto;
										else
										    $CalculoReal;	
									  if($CodigoArea=='14')
									  {
										$CalculoReal2=$DatoRealTMF*(100-$Numero1)/100-$CalculoReal-$AnodoSurAndesReal;
										$CalculoPpto2=$DatoPptoTMF*(100-$Numero1)/100-$CalculoPpto-$AnodoSurAndesPpto;
									  }
																					   
									 echo "<td align='right'>".number_format($CalculoReal,0,',','.')."</td>";
									 echo "<td align='right'>".number_format($CalculoPpto,0,',','.')."</td>";
									 $ArrSubTotalRechaReal[$i][0]=$ArrSubTotalRechaReal[$i][0]+$CalculoReal;
									 $ArrSubTotalRechaPpto[$i][0]=$ArrSubTotalRechaPpto[$i][0]+$CalculoPpto;								 
								   } 	 
						   echo "</tr>";
						   echo "<tr>";
							 echo "<td>L�minas y Despuntes Sur Andes (RCH)</td>";
							 echo "<td align='center'>TMF</td>";
								   for($i=$Mes;$i<=$MesFin;$i++)
								   {
									 echo "<td align='right'>&nbsp;</td>";
									 echo "<td align='right'>&nbsp;</td>";									 
								   } 	 
						   echo "</tr>";
						   echo "<tr>";
							 echo "<td>C�todos SX EW ex Sur Andes (STD)</td>";
							 echo "<td align='center'>TMF</td>";
								   for($i=$Mes;$i<=$MesFin;$i++)
								   {
										$FecRealAnt=explode('-',date('Y-m-d',mktime(0,0,0,(intval($i)-1),1,$Ano)));
										$FecRealA�o=$FecRealAnt[0];
										$FecRealMes=$FecRealAnt[1];
										$ValorMes1=DatosProyectadosTratam($FecRealA�o,$FecRealMes,'3','2','TMS','R');//Valor TMS CN Real; 1 Mes Atras.
										$FecRealAnt=explode('-',date('Y-m-d',mktime(0,0,0,(intval($i)-1),1,$Ano)));
										$FecRealA�o=$FecRealAnt[0];
										$FecRealMes=$FecRealAnt[1];
										$ValorMes2=DatosProyectadosTratam($FecRealA�o,$FecRealMes,'3','2','COBRE','R');//Valor COBRE CN Real; 2 Mes Atras.
										
										$FecPptoAnt=explode('-',date('Y-m-d',mktime(0,0,0,(intval($i)-1),1,$Ano)));
										$FecPptoA�o=$FecPptoAnt[0];
										$FecPptoMes=$FecPptoAnt[1];
										$ValorMesPpto1=DatosProyectadosTratam($FecPptoA�o,$FecPptoMes,'3','2','TMS','P');//Valor TMS CN Ppto; 1 Mes Atras.
										$FecPptoAnt=explode('-',date('Y-m-d',mktime(0,0,0,(intval($i)-1),1,$Ano)));
										$FecPptoA�o=$FecPptoAnt[0];
										$FecPptoMes=$FecPptoAnt[1];
										$ValorMesPpto2=DatosProyectadosTratam($FecPptoA�o,$FecPptoMes,'3','2','COBRE','P');//Valor COBRE CN Ppto; 2 Mes Atras.
									    
										$DatoRealTMF=$ValorMes1*$ValorMes2;
										//echo $DatoRealTMF."<br>";
										$DatoPptoTMF=$ValorMesPpto1*$ValorMesPpto2;

										$ConsultaValor1="select cod_subclase, valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='31041' and cod_subclase in ('2')";
										$RespValor1=mysql_query($ConsultaValor1);  
										if($FilaValor1=mysql_fetch_array($RespValor1))											    
											$Numero1=$FilaValor1["valor_subclase1"];
										
										$AnodoSurAndesReal=$DatoRealTMF*(100-$Numero1)/100;
										$AnodoSurAndesPpto=$DatoPptoTMF*(100-$Numero1)/100;
										
										$CalculoReal=$DatoRealTMF*(100-$Numero1)/100-$AnodoSurAndesReal;
										$CalculoPpto=$DatoPptoTMF*(100-$Numero1)/100-$AnodoSurAndesPpto;
										
										//echo $CalculoReal2=$DatoRealTMF."*(100-".$Numero1.")/100-".$CalculoReal."-".$AnodoSurAndesReal;
										$CalculoReal2=$DatoRealTMF*(100-$Numero1)/100-$CalculoReal-$AnodoSurAndesReal;
										$CalculoPpto2=$DatoPptoTMF*(100-$Numero1)/100-$CalculoPpto-$AnodoSurAndesPpto;
																					   
									 echo "<td align='right'>".number_format($CalculoReal2,0,',','.')."</td>";
									 echo "<td align='right'>".number_format($CalculoPpto2,0,',','.')."</td>";	
									 $ArrSubTotalRechaReal[$i][0]=$ArrSubTotalRechaReal[$i][0]+$CalculoReal2;
									 $ArrSubTotalRechaPpto[$i][0]=$ArrSubTotalRechaPpto[$i][0]+$CalculoPpto2;								 
								   } 	 
						   echo "</tr>";
						   echo "<tr>";
							 echo "<td>SUBTOTAL</td>";
							 echo "<td align='center'>TMF</td>";
								   for($i=$Mes;$i<=$MesFin;$i++)
								   {
								    $ValorSubTotalRealRecha=$ArrSubTotalRechaReal[$i][0];
									$ValorSubTotalPptoRecha=$ArrSubTotalRechaPpto[$i][0];
									 echo "<td align='right'>".number_format($ValorSubTotalRealRecha,0,',','.')."</td>";
									 echo "<td align='right'>".number_format($ValorSubTotalPptoRecha,0,',','.')."</td>";	
									 $ArrTotalRechaReal[$i][0]=$ArrTotalRechaReal[$i][0]+$ValorSubTotalRealRecha;							 
									 $ArrTotalRechaPpto[$i][0]=$ArrTotalRechaPpto[$i][0]+$ValorSubTotalPptoRecha;	
									 //$ArrDiferenciasReal[$i][0]=$ArrDiferenciasReal[$i][0]+$ValorSubTotalRealRecha;	
									 //$ArrDiferenciasPpto[$i][0]=$ArrDiferenciasPpto[$i][0]+$ValorSubTotalPptoRecha;					 
								   } 	 
						   echo "</tr>";						   	 
						   echo "<tr>";
							 echo "<td>TOTAL</td>";
							 echo "<td align='center'>TMF</td>";
								   for($i=$Mes;$i<=$MesFin;$i++)
								   {
								     $TotalRealRecha=$ArrTotalRechaReal[$i][0];
									 $TotalPptoRecha=$ArrTotalRechaPpto[$i][0];
									 echo "<td align='right'>".number_format($TotalRealRecha,0,',','.')."</td>";
									 echo "<td align='right'>".number_format($TotalPptoRecha,0,',','.')."</td>";	
									 	
								   } 	 
						   echo "</tr>";
						      ?>
								<tr>
								<td align="center" colspan="2">SALIDA</td>
								<?
								for($i=$Mes;$i<=$MesFin;$i++)
								{
								?>
								<td align="center" colspan="2"><? echo $Meses[$i-1]."&nbsp;".$Ano?></td>
								<?	
								}
								?>            
								</tr>
								  <tr>
									<td  align="center" colspan="2">CATODOS</td>						   	
									<?
									for($i=$Mes;$i<=$MesFin;$i++)
									{
									?>
									<td width="100"  align="center" >Real</td>
									<td width="100"  align="center">Proyectado</td>
									<?	
									}
									?>
								  </tr>							 			
			  <?
						   		//DATOS CATODOS SALIDA
								$ArrSubTotalSalidaReal=array(); $ArrSubTotalSalidaPpto=array(); 
								$ArrTotalSalidaReal=array(); $ArrTotalSalidaPpto=array(); 
								$Consulta1 ="select nombre_subclase,cod_subclase from proyecto_modernizacion.sub_clase where cod_clase='31030' and cod_subclase in ('1','2','3','4','5','6') order by valor_subclase2";						
								//echo $Consulta1; 	
								$Resp1=mysql_query($Consulta1);
								while($Fila1=mysql_fetch_array($Resp1))
								{
									$NomProveedor=$Fila1["nombre_subclase"];
									$CodProveedor=$Fila1["cod_subclase"];							
									  echo "<tr>";
										echo"<td align='left'>".$NomProveedor."</td>";
										echo "<td align='center'>TMF</td>";
										for($i=$Mes;$i<=$MesFin;$i++)
										{
										echo"<td rowspan='1' align='right'>".number_format(DatosProyectados('1',$CodProveedor,$Ano,$i),0,',','.')."</td>";
										echo"<td rowspan='1' align='right'>Proyectado</td>";
										$ArrSubTotalSalidaReal[$i][0]=$ArrSubTotalSalidaReal[$i][0]+DatosProyectados('1',$CodProveedor,$Ano,$i);
										}
								}	  	
								  echo"</tr>";	
								   echo "<tr>";
									 echo "<td>SUBTOTAL</td>";
									 echo "<td align='center'>TMF</td>";
										   for($i=$Mes;$i<=$MesFin;$i++)
										   {
										     $ValorDubclaseRealSalida=$ArrSubTotalSalidaReal[$i][0];
											 echo "<td align='right' >".number_format($ValorDubclaseRealSalida,0,',','.')."</td>";
											 echo "<td align='right' >&nbsp;</td>";
											 $ArrTotalSalidaReal[$i][0]=$ArrTotalSalidaReal[$i][0]+	$ValorDubclaseRealSalida;
										   } 	 
								   echo "</tr>";
								$ArrSubTotalSalidaReal2=array(); $ArrSubTotalSalidaPpto2=array();   						   	 
								$Consulta1 ="select nombre_subclase,cod_subclase from proyecto_modernizacion.sub_clase where cod_clase='31030' and cod_subclase in ('7','8','9','10','11') order by cod_subclase";						
								//echo $Consulta1; 	
								$Resp1=mysql_query($Consulta1);
								while($Fila1=mysql_fetch_array($Resp1))
								{
									$NomProveedor=$Fila1["nombre_subclase"];
									$CodProveedor=$Fila1["cod_subclase"];	
								   if($CodProveedor=='11')
								   {
									  $CorteNombre=explode('I',$NomProveedor);
									  $NomProveedor=$CorteNombre[0];
								   }
								   else
									  $NomProveedor;	  						   									
									  echo "<tr>";
										echo"<td align='left'>".$NomProveedor."</td>";
										echo "<td align='center'>TMF</td>";
										for($i=$Mes;$i<=$MesFin;$i++)
										{
										echo"<td rowspan='1' align='right'>".number_format(DatosProyectados('1',$CodProveedor,$Ano,$i),0,',','.')."</td>";
										echo"<td rowspan='1' align='right'>Proyectado</td>";
										$ArrSubTotalSalidaReal2[$i][0]=$ArrSubTotalSalidaReal2[$i][0]+DatosProyectados('1',$CodProveedor,$Ano,$i);
										}
								}	  	
								  echo"</tr>";	
								   echo "<tr>";
									 echo "<td>SUBTOTAL</td>";
									 echo "<td align='center'>TMF</td>";
										   for($i=$Mes;$i<=$MesFin;$i++)
										   {
										    $ValorTotalRealSalida2=$ArrSubTotalSalidaReal2[$i][0];
											 echo "<td align='right' >".number_format($ValorTotalRealSalida2,0,',','.')."</td>";
											 echo "<td align='right' >&nbsp;</td>";	
											 $ArrTotalSalidaReal[$i][0]=$ArrTotalSalidaReal[$i][0]+	$ValorTotalRealSalida2;
										   } 	 
								   echo "</tr>";
							?>	   
							<tr>
							<td  align="center" colspan="2">RECHAZADOS</td>
							<?
							for($i=$Mes;$i<=$MesFin;$i++)
							{
							?>
							<td align="center" colspan="2"><? echo $Meses[$i-1]."&nbsp;".$Ano?></td>
							<?	
							}
							?>            
							</tr>
							  <tr>
								<td  align="center" colspan="2">CATODOS</td>						   	
								<?
								for($i=$Mes;$i<=$MesFin;$i++)
								{
								?>
								<td width="100"  align="center" >Real</td>
								<td width="100" align="center">Proyectado</td>
								<?	
								}
								?>
							  </tr>							 			
					    	<?
								$ArrSubTotalSalidaReal3=array();$ArrSubTotalSalidaPpto3=array();   
								$ArrTotalSalidaUltimaReal=array();$ArrTotalSalidaUltimaPpto=array();   	
								$Consulta1 ="select nombre_subclase,cod_subclase from proyecto_modernizacion.sub_clase where cod_clase='31030' and cod_subclase in ('12','13','14') order by cod_subclase";						
								//echo $Consulta1; 	
								$Resp1=mysql_query($Consulta1);
								while($Fila1=mysql_fetch_array($Resp1))
								{
									$NomProveedor=$Fila1["nombre_subclase"];
									$CodProveedor=$Fila1["cod_subclase"];	
									  echo "<tr>";
										echo"<td align='left'>".$NomProveedor."</td>";
										echo "<td align='center'>TMF</td>";
										for($i=$Mes;$i<=$MesFin;$i++)
										{
										echo"<td rowspan='1' align='right'>".number_format(DatosProyectados('2',$CodProveedor,$Ano,$i),0,',','.')."</td>";
										echo"<td rowspan='1' align='right'>Proyectado</td>";
										$ArrSubTotalSalidaReal3[$i][0]=$ArrSubTotalSalidaReal3[$i][0]+DatosProyectados('2',$CodProveedor,$Ano,$i);
										}
								}	  	
								  echo"</tr>";	
								   echo "<tr>";
									 echo "<td>SUBTOTAL</td>";
									 echo "<td align='center'>TMF</td>";
										   for($i=$Mes;$i<=$MesFin;$i++)
										   {
										     $ValorTotalRealSalida3=$ValorTotalRealSalida3[$i][0];
											 $ValorTotalPptoSalida3=$ValorTotalPptoSalida3[$i][0];
											 echo "<td align='right'>".number_format($ValorTotalRealSalida3,0,',','.')."</td>";
											 echo "<td align='right'>&nbsp;</td>";	
											 $ArrTotalSalidaReal[$i][0]=$ArrTotalSalidaReal[$i][0]+	$ValorTotalRealSalida3;
											 $ArrTotalSalidaPpto[$i][0]=$ArrTotalSalidaPpto[$i][0]+	$ValorTotalPptoSalida3;
										   } 	 
								   echo "</tr>";
								   echo "<tr>";
									 echo "<td>TOTAL</td>";
									 echo "<td align='center'>TMF</td>";
										   for($i=$Mes;$i<=$MesFin;$i++)
										   {
										     $ValorTotalRealSalida4=$ArrTotalSalidaReal[$i][0];
											 $ValorTotalPptoSalida4=$ArrTotalSalidaPpto[$i][0];
											 echo "<td align='right' >".number_format($ValorTotalRealSalida4,0,',','.')."</td>";
											 echo "<td align='right'>".number_format($ValorTotalPptoSalida4,0,',','.')."</td>";											 
											 $ArrTotalSalidaUltimaReal[$i][0]=$ArrTotalSalidaUltimaReal[$i][0]+	$ValorTotalRealSalida4;
											 $ArrTotalSalidaUltimaPpto[$i][0]=$ArrTotalSalidaUltimaPpto[$i][0]+	$ValorTotalPptoSalida4;											 
											 //echo $ValorTotalRealSalida4;
										   } 	 
								   echo "</tr>";
								  echo"</tr>";	
								   echo "<tr>";
									 echo "<td colspan='2'>VENTAS SUBPRODUCTOS</td>";
									for($i=$Mes;$i<=$MesFin;$i++)
									{										
										echo "<td width='100' align='center' >Real</td>";
										echo "<td width='100' align='center'>Proyectado</td>";
									}
								   echo "</tr>";	 
								   echo "<tr>";
									 echo "<td>OTROS COBRES A VENTAS</td>";
									 echo "<td align='center'>TMF</td>";
										   for($i=$Mes;$i<=$MesFin;$i++)
										   {
										   $OtrosCobre=0;
											 echo "<td align='right'>".number_format($OtrosObre,0,',','.')."</td>";
											 echo "<td align='right'>&nbsp;</td>";	
											 $ArrTotalSalidaUltimaReal[$i][0]=$ArrTotalSalidaUltimaReal[$i][0]+$OtrosCobre;
											 $ArrTotalSalidaUltimaPpto[$i][0]=$ArrTotalSalidaUltimaPpto[$i][0]+$OtrosCobre;
										   } 	 
								   echo "</tr>";	
								   echo "<tr>";
									 echo "<td>TOTAL SALIDAS</td>";
									 echo "<td align='center'>&nbsp;</td>";
										   for($i=$Mes;$i<=$MesFin;$i++)
										   {
										    	$TotalSalidaRealUltima=$ArrTotalSalidaUltimaReal[$i][0];
												$TotalSalidaPptoUltima=$ArrTotalSalidaUltimaPpto[$i][0];
											 echo "<td align='right'>".number_format($TotalSalidaRealUltima,0,',','.')."</td>";
											 echo "<td align='right'>&nbsp;</td>";	
											 //$ArrDiferenciasReal[$i][0]=$ArrDiferenciasReal[$i][0]-$TotalSalidaRealUltima;	
											 //$ArrDiferenciasPpto[$i][0]=$ArrDiferenciasPpto[$i][0]-$TotalSalidaRealUltima;					 
										   } 	 
								   echo "</tr>";	
								   echo "<tr>";
									 echo "<td>DIFERENCIAS</td>";
									 echo "<td align='center'>&nbsp;</td>";
										   for($i=$Mes;$i<=$MesFin;$i++)
										   {
											 $TotalRealRecha=$ArrTotalRechaReal[$i][0];
											 $TotalPptoRecha=$ArrTotalRechaPpto[$i][0];
									    	 $TotalSalidaRealUltima=$ArrTotalSalidaUltimaReal[$i][0];
											 $TotalSalidaPptoUltima=$ArrTotalSalidaUltimaPpto[$i][0];
											 
											 $DiferenciaReal=$TotalSalidaRealUltima-$TotalRealRecha;
											 $DiferenciaPpto=$TotalSalidaPptoUltima-$TotalPptoRecha;
											 echo "<td align='right'>".number_format($DiferenciaReal,0,',','.')."</td>";
											 echo "<td align='right'>".number_format($DiferenciaPpto,0,',','.')."</td>";	
										   } 	 
								   echo "</tr>";	
								   echo "<tr>";
									 echo "<td>DOLARES</td>";
									 echo "<td align='center'>&nbsp;</td>";
										   for($i=$Mes;$i<=$MesFin;$i++)
										   {
										     $Dato=DatosProyectadosDore('1',$Ano,$i,'R');
											 $DolaresReal=$DiferenciaReal*$Dato*0.022046;
											 $DolaresPpto=$DiferenciaPpto*$Dato*0.022046;
										    //$ValorDiferenciaReal=$ArrDiferenciasReal[$i][0];
											//$ValorDiferenciaPPto=$ArrDiferenciasPpto[$i][0];
											 echo "<td align='right'>".number_format($DolaresReal,0,',','.')."</td>";
											 echo "<td align='right'>".number_format($DolaresPpto,0,',','.')."</td>";	
										   } 	 
								   echo "</tr>";	
								   echo "<tr>";
									 echo "<td>DOLARES ACUMULADOS</td>";
									 echo "<td align='center'>&nbsp;</td>";
										   for($i=$Mes;$i<=$MesFin;$i++)
										   {
										     $Dato=DatosProyectadosDore('1',$Ano,$i,'R');
											 $DolaresReal=$DiferenciaReal*$Dato*0.022046;
											 $DolaresPpto=$DiferenciaPpto*$Dato*0.022046;

										     $AcumuladosReal=$DolaresReal;
											 $AcumuladosPpto=$DolaresPpto;
											 echo "<td align='right'>".number_format($AcumuladosReal,0,',','.')."</td>";
											 echo "<td align='right'>".number_format($AcumuladosPpto,0,',','.')."</td>";	
										   } 	 
								   echo "</tr>";	
					}	   
			 ?>
  </table>
</form>
</body>
</html>
<?
function DatosProyectadosTratam($Ano,$Mes,$Area,$Division,$Producto,$Tipo)
{
   $Datos1=0;$Datos2=0;
   $Consulta="select valor_real as ValorReal,valor_presupuestado as ValorPresupuestado from pcip_inp_tratam";
   $Consulta.=" where ano='".$Ano."' and mes='".$Mes."' and nom_area='".$Area."' and nom_division='".$Division."' and cod_producto='".$Producto."'";
   //echo $Consulta."<br>";
   $Resp=mysqli_query($link, $Consulta);  
   if($Fila=mysql_fetch_array($Resp))
   {
    $Datos1=$Fila[ValorReal];
    //echo "Valor datos consyulta 1   ".$Datos1."&nbsp;";
    $Datos2=$Fila[ValorPresupuestado];
    //echo "Valor datos consyulta 2   ".$Datos2."<br>";
   }
   if($Tipo=='R')	
	return($Datos1);
   if($Tipo=='P')	    
	return($Datos2);	
}

function DatosProyectadosDore($Producto,$Ano,$Mes,$Tipo)
{
    $Dato1=0;$Dato2=0;
	$Consulta1 =" select valor_real, valor_ppto from pcip_inp_precios_dore ";
	$Consulta1.=" where cod_producto='".$Producto."' and ano='".$Ano."' and mes='".$Mes."'";
	//echo $Consulta1."<br>";
	$RespAux=mysql_query($Consulta1);
	if($FilaAux=mysql_fetch_array($RespAux))
	{
		$Dato1=$FilaAux[valor_real];
		$Dato2=$FilaAux[valor_ppto];
	}
	if($Tipo=='R')   
		return($Dato1);	
	if($Tipo=='P')   
		return($Dato2);	
}
function DatosPreciosDore($Ano,$Mes,$Prod,$Deduc)
{
	$Valor=0;
	$Consulta2 =" select valor from pcip_inp_precios ";
	$Consulta2.=" where cod_producto='".$Prod."' and ano='".$Ano."' and mes='".$Mes."' and cod_deduccion='".$Deduc."'";
	//echo $Consulta2."<br>";
	$RespAux1=mysql_query($Consulta2);
	if($FilaAux1=mysql_fetch_array($RespAux1))
	{
		$Valor=$FilaAux1[valor];
		//echo $Valor;
	}
	return($Valor);
}

function DatosProyectados($Producto,$Proveedor,$Ano,$Mes)
{
   $Consulta="select Vporden,Vptm,VPmaterial,Vptipinv,VPordenrel,Vpordes from pcip_inp_asignacion";
   $Consulta.=" where cod_producto='".$Producto."' and cod_proveedor='".$Proveedor."'";
   //echo $Consulta."<br>";
   $Resp=mysqli_query($link, $Consulta);  
   if($Fila=mysql_fetch_array($Resp))
   {
     $Orden=$Fila[Vporden];
     $Tm=$Fila[Vptm];
     $Material=$Fila[VPmaterial];
     $Tipinv=$Fila[Vptipinv];
	 $OrdenRel=$Fila[VPordenrel];
     $Ordes=$Fila[Vpordes]; 	 	 	 	 
   }       
	$Consulta1 =" select VPcantidad from pcip_svp_valorizacproduccion ";
	$Consulta1.=" where VPorden='".$Orden."' and VPtm='".$Tm."' and VPmaterial='".$Material."' and VPtipinv='".$Tipinv."' and VPordenrel='".$OrdenRel."' and VPordes='".$Ordes."' and VPa�o='".$Ano."' and VPmes='".$Mes."'";
	//echo $Consulta1."<br>";
	$RespAux=mysql_query($Consulta1);
	if($FilaAux=mysql_fetch_array($RespAux))
	{
		$Datos1=$FilaAux[VPcantidad];
		//echo "Valor datos consyulta 1   ".$Datos1."&nbsp;";
		//$Datos2=$FilaAux[ValorPresupuestado];
		//echo "Valor datos consyulta 2   ".$Datos2."<br>";
	}
		return($Datos1);	
}
?>
