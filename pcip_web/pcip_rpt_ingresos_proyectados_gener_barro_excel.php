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
<title>Reporte Gener Barro</title>
<style type="text/css">s
<!--
body {
	background-image: url();
	background-color: #f9f9f9;
}
-->
</style>
<link href="estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
</style></head>
<body>
<form name="frmPrincipal" action="" method="post">
  <table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
    <tr>
      <td  align="center" rowspan="2" colspan="2">Programa  Divisi&oacute;n Ventanas</td>
      <?
			for($i=$Mes;$i<=$MesFin;$i++)
			{
			?>
      <td align="center" colspan="2"><? echo $Meses[$i-1]?></td>
      <?	
			}
			?>
    </tr>
    <tr>
      <?
			for($i=$Mes;$i<=$MesFin;$i++)
			{
			$ArrTotalReal[$i][0]=0;
			$ArrTotalPpto[$i][0]=0;
			$ArrTotalReal2[$i][0]=0;
			$ArrTotalPpto2[$i][0]=0;
			?>
      <td  align="center" >Real</td>
      <td align="center">Proyectado</td>
      <?	
			}
			?>
    </tr>
    <?			
			 $Buscar='S';	
  			 if($Buscar=='S')
			 {
			 ?>
    <tr>
      <td align="center" colspan="2">Plata [kUS$]</td>
      <?
				$Dato1=DatosPreciosDore($Ano,'5','48');
				$DatoPlata=DatosPreciosDore($Ano,'5','37');//RC PLATA
				for($i=$Mes;$i<=$MesFin;$i++)
				{
					//Obtener los datos Kg
					$PLataRealKg=DatosPrecios_Barro('2','10',$Ano,$i,'R');
					$PLataPptoKg=DatosPrecios_Barro('2','10',$Ano,$i,'P');
					$BarroRealKg=DatosPrecios_Barro('2','14',$Ano,$i,'R');
					$BarroPptoKg=DatosPrecios_Barro('2','14',$Ano,$i,'P');					
					//Obtener los datos %
					$PLataRealPor=DatosPrecios_Barro('2','12',$Ano,$i,'R');
					$PLataPptoPor=DatosPrecios_Barro('2','12',$Ano,$i,'P');				
					
					if($Dato1>0)
					{
						$ValorRealPLata=($PLataRealKg*$DatoPlata)/$Dato1;
						$ValorPptoPlata=($PLataPptoKg*$DatoPlata)/$Dato1;
					}	
					else
					{
						$ValorRealPLata=0;
						$ValorPptoPlata=0;
					}
					echo "<td rowspan='1' align='right'>".number_format($ValorRealPLata,2,',','.')."</td>";
					echo "<td rowspan='1' align='right'>".number_format($ValorPptoPlata,2,',','.')."</td>";							 						 
				}	
				  //ACA EMPIEZA LA PARTE DE LOS PRODUCTOS				 	
				  $Consulta="select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31030' and valor_subclase3<>'0' order by valor_subclase3";				  
				  $Resp=mysqli_query($link, $Consulta);
				  //echo $Consulta."<br>";
				  while($Fila=mysql_fetch_array($Resp))
				  {
					?>
    <tr>
      <td width="24%" align="left"><? echo $Fila["nombre_subclase"];?></td>
      <td width="7%" align="left">[kg]</td>
      <?
						for($i=$Mes;$i<=$MesFin;$i++)
						{
						  	$Numero=20; 
							$Real=BuscaDatosPlata($Fila["cod_subclase"],'R',$Ano,$i);
							$Ppto=BuscaDatosPlata($Fila["cod_subclase"],'P',$Ano,$i);
							echo "<td rowspan='1' align='right'>".number_format($Real,0,',','.')."</td>";
							echo "<td rowspan='1' align='right'>".number_format($Ppto,0,',','.')."</td>";							 						 
						}
				  }
				   echo" <tr class='FilaAbeja'>";
				   echo "<td align='left' colspan='25'>&nbsp;</td>";
				   echo" </tr>";
				  $Consulta="select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31030' and valor_subclase3<>'0' order by valor_subclase3";				  
				  $Resp=mysqli_query($link, $Consulta);
				  //echo $Consulta."<br>";
				  while($Fila=mysql_fetch_array($Resp))
				  {
					?>
    <tr>
      <td align="left"><? echo $Fila["nombre_subclase"];?></td>
      <td align="left">[kUS$]</td>
      <?
						for($i=$Mes;$i<=$MesFin;$i++)
						{
							$Real=BuscaDatosPlata($Fila["cod_subclase"],'R',$Ano,$i);
							$Ppto=BuscaDatosPlata($Fila["cod_subclase"],'P',$Ano,$i);
							if($Dato1>0)
							{
								$ValorReal=($Real*$DatoPlata)/$Dato1;
								$ValorPpto=($Ppto*$DatoPlata)/$Dato1;
							}
							else
							{
							    $ValorReal=0;	
								$ValorPpto=0;								
							}
							echo "<td rowspan='1' align='right'>".number_format($ValorReal,0,',','.')."</td>";
							echo "<td rowspan='1' align='right'>".number_format($ValorPpto,0,',','.')."</td>";							 						 
						}
				  }
				    ?>
    </tr>
    <!-- ACA VAN LOS PROVEEDORES DEL ORO-->
    <tr>
      <td align="center" colspan="25">&nbsp;</td>
    </tr>
    <tr >
      <td  align="center" colspan="2">Oro [kUS$]</td>
      <?
				$Dato2=DatosPreciosDore($Ano,'5','48');
				$DatoOro=DatosPreciosDore($Ano,'5','38');//RC ORO
				for($i=$Mes;$i<=$MesFin;$i++)
				{
					//Obtener los datos Kg
					$BarroRealKg=DatosPrecios_Barro('2','14',$Ano,$i,'R');
					$BarroPptoKg=DatosPrecios_Barro('2','14',$Ano,$i,'P');
					$OroRealKg=DatosPrecios_Barro('2','11',$Ano,$i,'R');//Oro datos Real KG
					$OroPptoKg=DatosPrecios_Barro('2','11',$Ano,$i,'P');//Oro datos Ppto KG
					//Obtener los datos %
					$OroRealPor=DatosPrecios_Barro('2','13',$Ano,$i,'R');// Oro Real datos %
					$OroPptoPor=DatosPrecios_Barro('2','13',$Ano,$i,'P');//Oro Ppto datos %
				
					if($Dato1>0)
					{
						$ValorRealOro=($OroRealKg*$DatoOro)/$Dato2;
						$ValorPptoOro=($OroPptoKg*$DatoOro)/$Dato2;
					}
					else
					{
						$ValorRealOro=0;
						$ValorPptoOro=0;
					}					
					echo "<td rowspan='1' align='right'>".number_format($ValorRealOro,2,',','.')."</td>";
					echo "<td rowspan='1' align='right'>".number_format($ValorPptoOro,2,',','.')."</td>";							 						 
				}	
				  //ACA EMPIEZA LA PARTE DE LOS PRODUCTOS		 	
				  $Consulta="select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31030' and valor_subclase3<>'0' order by valor_subclase3";				  
				  $Resp=mysqli_query($link, $Consulta);
				  //echo $Consulta."<br>";
				  while($Fila=mysql_fetch_array($Resp))
				  {
					?>
    <tr>
      <td align="left"><? echo $Fila["nombre_subclase"];?></td>
      <td align="left">[kG]</td>
      <?
						for($i=$Mes;$i<=$MesFin;$i++)
						{						  
							$Real1=BuscaDatosOro($Fila["cod_subclase"],'R',$Ano,$i);
							$Ppto1=BuscaDatosOro($Fila["cod_subclase"],'P',$Ano,$i);
							echo "<td rowspan='1' align='right'>".number_format($Real1,0,',','.')."</td>";
							echo "<td rowspan='1' align='right'>".number_format($Ppto1,0,',','.')."</td>";							 						 
						}
				  }
				   echo" <tr>";
				   echo "<td align='left' colspan='25'>&nbsp;</td>";
				   echo" </tr>";
				  $Consulta="select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31030' and valor_subclase3<>'0' order by valor_subclase3";				  
				  $Resp=mysqli_query($link, $Consulta);
				  //echo $Consulta."<br>";
				  while($Fila=mysql_fetch_array($Resp))
				  {
					?>
    <tr>
      <td align="left"><? echo $Fila["nombre_subclase"];?></td>
      <td align="left">[kUS$]</td>
      <?
						for($i=$Mes;$i<=$MesFin;$i++)
						{
							$Real1=BuscaDatosOro($Fila["cod_subclase"],'R',$Ano,$i);
							$Ppto1=BuscaDatosOro($Fila["cod_subclase"],'P',$Ano,$i);
							if($Dato2>0)
							{
								$ValorReal2=($Real1*$DatoOro)/$Dato2;
								$ValorPpto2=($Ppto1*$DatoOro)/$Dato2;
							}
							else
							{
							    $ValorReal2=0;	
								$ValorPpto2=0;								
							}
							echo "<td rowspan='1' align='right'>".number_format($ValorReal2,0,',','.')."</td>";
							echo "<td rowspan='1' align='right'>".number_format($ValorPpto2,0,',','.')."</td>";							 						 
						}
				  }
				   echo" <tr>";
				   echo "<td align='left' colspan='25'>&nbsp;</td>";
				   echo" </tr>";
				  //RECUEDRO DE TOTALES	
				  $Consulta="select t1.cod_subclase,t2.nombre_subclase,t1.valor_subclase1 from proyecto_modernizacion.sub_clase t1";
				  $Consulta.=" inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31024' and t1.cod_subclase=t2.cod_subclase where t1.cod_clase='31048' and t1.cod_subclase not in ('7','8','9','10','11','12')";				  
				  $Resp=mysqli_query($link, $Consulta);
				  //echo $Consulta."<br>";
				  while($Fila=mysql_fetch_array($Resp))
				  {
				  	  $CodPrincipal=$Fila["nombre_subclase"];	
					  if($Fila["cod_subclase"]==6)
					  		$CodPrincipal='Salvador';												 					 
					  $Proveedor=$Fila["valor_subclase1"];
					  $Dato=explode(",",$Proveedor);
						?>
    </tr>
    <tr>
      <td align="left" ><? echo $CodPrincipal;?></td>
      <td align="left">[kUS$]</td>
      <?
						//echo $Dato[0]."<br>";
						for($i=$Mes;$i<=$MesFin;$i++)
						{										
							$ValorReal2=0;$ValorPpto2=0;
							while(list($c,$v)=each($Dato))
							{
								$RealPlata=DatosSuma($v,'PLata','R',$Ano,$i);
								$PptoPlata=DatosSuma($v,'PLata','P',$Ano,$i);
								$RealOro=DatosSuma($v,'Oro','R',$Ano,$i);
								$PptoOro=DatosSuma($v,'Oro','P',$Ano,$i);
								if($Dato1>0)
								{
									$ValorReal2=$ValorReal2+($RealPlata*$DatoPlata)/$Dato1;
									$ValorPpto2=$ValorPpto2+($PptoPlata*$DatoPlata)/$Dato1;
								}
								else
								{
									$ValorReal2=0;	
									$ValorPpto2=0;								
								}
								if($Dato2>0)
								{
									$ValorReal2=$ValorReal2+($RealOro*$DatoOro)/$Dato2;
									$ValorPpto2=$ValorPpto2+($PptoOro*$DatoOro)/$Dato2;
								}
								else
								{
									$ValorReal2=0;	
									$ValorPpto2=0;								
								}
							}
							echo "<td rowspan='1' align='right'>".number_format($ValorReal2,0,',','.')."</td>";
							echo "<td rowspan='1' align='right'>".number_format($ValorPpto2,0,',','.')."</td>";	
							$ArrTotalReal[i][0]=$ArrTotalReal[i][0]+$ValorReal2;
							$ArrTotalPpto[i][0]=$ArrTotalPpto[i][0]+$ValorPpto2;						 						 
						}
				  }	 
				  ?>
    </tr>
    <tr>
      <td align="left">TOTAL</td>
      <td align="left">[kUS$]</td>
      <?
						//echo $Dato[0]."<br>";
						for($i=$Mes;$i<=$MesFin;$i++)
						{
						    $TotalReal=$ArrTotalReal[i][0];
							$TotalPpto=$ArrTotalPpto[i][0];
							echo "<td rowspan='1' align='right'>".number_format($TotalReal,0,',','.')."</td>";
							echo "<td rowspan='1' align='right'>".number_format($TotalPpto,0,',','.')."</td>";
							$ArrTotalReal[i][0]=0;$ArrTotalPpto[i][0]=0;						 						 
				    	}	
						
						
					echo" <tr>";
				   echo "<td align='left' colspan='25'>&nbsp;</td>";
				   echo" </tr>";
				  //RECUEDRO MAQUILAS
				  $Consulta="select cod_subclase,nombre_subclase,valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='31048' and cod_subclase in ('7','8','9','10')";				  
				  $Resp=mysqli_query($link, $Consulta);
				  //echo $Consulta."<br>";
				  while($Fila=mysql_fetch_array($Resp))
				  {
				  	  $CodPrincipal=$Fila["nombre_subclase"];	
					  $Proveedor=$Fila["valor_subclase1"];
					  $Dato=explode(",",$Proveedor);
						?>
    </tr>
    <tr >
      <td align="left"><? echo $CodPrincipal;?></td>
      <td align="left">[kUS$]</td>
      <?
						//echo $Dato[0]."<br>";
						for($i=$Mes;$i<=$MesFin;$i++)
						{										
							$ValorReal2=0;$ValorPpto2=0;
							while(list($c,$v)=each($Dato))
							{
								$RealPlata=DatosSuma($v,'PLata','R',$Ano,$i);
								$PptoPlata=DatosSuma($v,'PLata','P',$Ano,$i);
								$RealOro=DatosSuma($v,'Oro','R',$Ano,$i);
								$PptoOro=DatosSuma($v,'Oro','P',$Ano,$i);
								if($Dato1>0)
								{
									$ValorReal2=$ValorReal2+($RealPlata*$DatoPlata)/$Dato1;
									$ValorPpto2=$ValorPpto2+($PptoPlata*$DatoPlata)/$Dato1;
								}
								else
								{
									$ValorReal2=0;	
									$ValorPpto2=0;								
								}
								if($Dato2>0)
								{
									$ValorReal2=$ValorReal2+($RealOro*$DatoOro)/$Dato2;
									$ValorPpto2=$ValorPpto2+($PptoOro*$DatoOro)/$Dato2;
								}
								else
								{
									$ValorReal2=0;	
									$ValorPpto2=0;								
								}
							}
							echo "<td rowspan='1' align='right'>".number_format($ValorReal2,0,',','.')."</td>";
							echo "<td rowspan='1' align='right'>".number_format($ValorPpto2,0,',','.')."</td>";	
							$ArrTotalReal2[i][0]=$ArrTotalReal2[i][0]+$ValorReal2;
							$ArrTotalPpto2[i][0]=$ArrTotalPpto2[i][0]+$ValorPpto2;						 						 
						}
				  }	 
				  
				    //RECUEDRO CODELCO Y TERCEROS
					echo" <tr>";
				   echo "<td align='left' colspan='25'>&nbsp;</td>";
				   echo" </tr>";				  
				  $Consulta="select cod_subclase,nombre_subclase,valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='31048' and cod_subclase in ('11','12')";				  
				  $Resp=mysqli_query($link, $Consulta);
				  //echo $Consulta."<br>";
				  while($Fila=mysql_fetch_array($Resp))
				  {
				  	  $CodPrincipal=$Fila["nombre_subclase"];	
					  $Proveedor=$Fila["valor_subclase1"];
					  $Dato=explode(",",$Proveedor);
						?>
    </tr>
    <tr>
      <td align="left"><? echo $CodPrincipal;?></td>
      <td align="left">[kUS$]</td>
      <?
						//echo $Dato[0]."<br>";
						for($i=$Mes;$i<=$MesFin;$i++)
						{										
							$ValorReal2=0;$ValorPpto2=0;
							while(list($c,$v)=each($Dato))
							{
								$RealPlata=DatosSuma($v,'PLata','R',$Ano,$i);
								$PptoPlata=DatosSuma($v,'PLata','P',$Ano,$i);
								$RealOro=DatosSuma($v,'Oro','R',$Ano,$i);
								$PptoOro=DatosSuma($v,'Oro','P',$Ano,$i);
								if($Dato1>0)
								{
									$ValorReal2=$ValorReal2+($RealPlata*$DatoPlata)/$Dato1;
									$ValorPpto2=$ValorPpto2+($PptoPlata*$DatoPlata)/$Dato1;
								}
								else
								{
									$ValorReal2=0;	
									$ValorPpto2=0;								
								}
								if($Dato2>0)
								{
									$ValorReal2=$ValorReal2+($RealOro*$DatoOro)/$Dato2;
									$ValorPpto2=$ValorPpto2+($PptoOro*$DatoOro)/$Dato2;
								}
								else
								{
									$ValorReal2=0;	
									$ValorPpto2=0;								
								}
							}
						    if($ArrTotalReal2[i][0]>0)
							 	$CALDULADOREAL=($ValorReal2/$ArrTotalReal2[i][0])*100;
						    if($ArrTotalPpto2[i][0]>0)	
								$CALDULADOPPTO=($ValorPpto2/$ArrTotalPpto2[i][0])*100;
							echo "<td rowspan='1' align='right'>".number_format($CALDULADOREAL,1,',','.')."%</td>";
							echo "<td rowspan='1' align='right'>".number_format($CALDULADOPPTO,1,',','.')."%</td>";	
						}
				  }	 
				  ?>
    </tr>
    <?										  				  			  															 
			 }	 
			  ?>
  </table>
</form>
</body>
</html>
<?
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

function DatosPreciosDore($Ano,$Prod,$Deduc)
{
	$Valor=0;
	$Consulta2 =" select valor from pcip_inp_precios ";
	$Consulta2.=" where cod_producto='".$Prod."' and ano='".$Ano."' and cod_deduccion='".$Deduc."'";
	//echo $Consulta2."<br>";
	$RespAux1=mysql_query($Consulta2);
	if($FilaAux1=mysql_fetch_array($RespAux1))
	{
		$Valor=$FilaAux1[valor];
		//echo $Valor;
	}
	return($Valor);
}

function DatosPrecios_Barro($Dato,$Producto,$Ano,$Mes,$Tipo)
{
	$Datos1=0;$Datos2=0;
	$Consulta2 =" select valor_real as ValorReal,valor_ppto as ValorPpto from pcip_inp_precios_dore ";
	$Consulta2.=" where dato='".$Dato."' and cod_producto='".$Producto."' and ano='".$Ano."' and mes='".$Mes."' ";
	//echo $Consulta2."<br>";
	$RespAux1=mysql_query($Consulta2);
	if($FilaAux1=mysql_fetch_array($RespAux1))
	{
		$Datos1=$FilaAux1[ValorReal];
		//echo "Valor datos consyulta 1   ".$Datos1."&nbsp;";
		$Datos2=$FilaAux1[ValorPpto];
		//echo $Valor;
	}
   if($Tipo=='R')	
	return($Datos1);
   if($Tipo=='P')	    
	return($Datos2);	
}
function DatosSuma($Cod,$Tipo1,$Tipo,$Ano,$i)
{
  switch($Tipo1)
  {
    case "PLata":
				switch($Cod)
				{	
				 case "10"://Ex Anodos Sur Andes
				 		$Numero=20; 
						$DatoAnoPaSurReal1=DatosProyectadosTratam($Ano,$i,'3','2','TMS','R');//Valor Tratam D79 real
						$DatoAnoPaSurPpto1=DatosProyectadosTratam($Ano,$i,'3','2','TMS','P');//Valor Tratam D79 ppto
						$DatoAnoPaSurReal2=DatosProyectadosTratam($Ano,$i,'3','2','PLATA','R');//Valor Tratam D82 real
						$DatoAnoPaSurPpto2=DatosProyectadosTratam($Ano,$i,'3','2','PLATA','P');//Valor Tratam D82 ppto
						
						$ValorAnoPaSurReal=($DatoAnoPaSurReal2-$DatoAnoPaSurReal1*$Numero/1000);
						if($ValorAnoPaSurReal<0)
							$ValorAnoPaSurReal=0;
						else
							$ValorAnoPaSurReal;														
						$ValorAnoPaSurPpto=($DatoAnoPaSurPpto2-$DatoAnoPaSurPpto1*$Numero/1000);										
						if($ValorAnoPaSurPpto<0)
							$ValorAnoPaSurPpto=0;
						else
							$ValorAnoPaSurPpto;		
							
						$ValorReal=$ValorAnoPaSurReal;
						$ValorPpto=$ValorAnoPaSurPpto;		 
				 break;
				 case "7"://Ex Anodos Teniente
						 $Numero=20; 
						$DatoAnoPaTeReal1=DatosProyectadosTratam($Ano,$i,'3','3','TMS','R');//Valor Tratam D85 real
						$DatoAnoPaTePpto1=DatosProyectadosTratam($Ano,$i,'3','3','TMS','P');//Valor Tratam D85 ppto
						$DatoAnoPaTeReal2=DatosProyectadosTratam($Ano,$i,'3','3','PLATA','R');//Valor Tratam D88 real
						$DatoAnoPaTePpto2=DatosProyectadosTratam($Ano,$i,'3','3','PLATA','P');//Valor Tratam D88 ppto
						
						$ValorAnoPaTeReal=$DatoAnoPaTeReal2-$DatoAnoPaTeReal1*$Numero/1000;
						$ValorAnoPaTePpto=$DatoAnoPaTePpto2-$DatoAnoPaTePpto1*$Numero/1000;
						
						$ValorReal=$ValorAnoPaTeReal;
						$ValorPpto=$ValorAnoPaTePpto;
				 break;
				 case "11"://Ex Blister Salvador
						$DatoAnoPaBlisReal1=DatosProyectadosTratam($Ano,$i,'2','8','TMS','R');//Valor Tratam D58 real
						$DatoAnoPaBlisPpto1=DatosProyectadosTratam($Ano,$i,'2','8','TMS','P');//Valor Tratam D58 ppto
						$DatoAnoPaBlisReal2=DatosProyectadosTratam($Ano,$i,'2','8','PLATA','R');//Valor Tratam D61 real
						$DatoAnoPaBlisPpto2=DatosProyectadosTratam($Ano,$i,'2','8','PLATA','P');//Valor Tratam D61 ppto
						
						$ValorAnoPaBlisReal=$DatoAnoPaBlisReal2-$DatoAnoPaBlisReal1*$Numero1/1000;					
						$ValorAnoPaBlisPpto=$DatoAnoPaBlisPpto2-$DatoAnoPaBlisPpto1*$Numero1/1000;
						
						$ValorReal=$ValorAnoPaBlisReal;
						$ValorPpto=$ValorAnoPaBlisPpto;
				 break;
				 case "4"://Ex cucons Enami
				 		$Numero=20; 
						$DatoCuPaEnamiReal1=DatosProyectadosTratam($Ano,$i,'1','1','PLATA','R');//Valor Tratam D11 real
						$DatoCuPaEnamiPpto1=DatosProyectadosTratam($Ano,$i,'1','1','PLATA','P');//Valor Tratam D11 ppto
						$DatoCuPaEnamiReal2=DatosProyectadosTratam($Ano,$i,'1','1','TMS','R');// Valor Tratam D9 real
						$DatoCuPaEnamiPpto2=DatosProyectadosTratam($Ano,$i,'1','1','TMS','P');// Valor Tratam D9 ppto
						$DatoCuPaEnamiReal3=DatosProyectadosTratam($Ano,$i,'2','7','SECO FU','R');//Valor Tratam D52 real
						$DatoCuPaEnamiPpto3=DatosProyectadosTratam($Ano,$i,'2','7','SECO FU','P');//Valor Tratam D52 ppto
						
						$ValorRealCuPaEnami=($DatoCuPaEnamiReal1-$Numero)*($DatoCuPaEnamiReal2-$DatoCuPaEnamiReal3)/1000;
						if($ValorRealCuPaEnami<0)
							$ValorRealCuPaEnami=0;
						else
							$ValorRealCuPaEnami;				
						$ValorPptoCuPaEnami=($DatoCuPaEnamiPpto1-$Numero)*($DatoCuPaEnamiPpto2-$DatoCuPaEnamiPpto3)/1000;
						if($ValorPptoCuPaEnami<0)
							$ValorPptoCuPaEnami=0;
						else
							$ValorPptoCuPaEnami;				
							
						$ValorReal=$ValorRealCuPaEnami;		
						$ValorPpto=$ValorPptoCuPaEnami;	
				 break;
				 case "6"://Ex cucons Sur Andes
				 		$Numero=20; 
						$DatoCuPaSurReal1=DatosProyectadosTratam($Ano,$i,'1','2','TMS','R');//Valor Tratam D16 real
						$DatoCuPaSurPpto1=DatosProyectadosTratam($Ano,$i,'1','2','TMS','P');//Valor Tratam D16 ppto
						$DatoCuPaSurReal2=DatosProyectadosTratam($Ano,$i,'1','2','PLATA','R');//Valor Tratam D18 real
						$DatoCuPaSurPpto2=DatosProyectadosTratam($Ano,$i,'1','2','PLATA','P');//Valor Tratam D18 ppto
						
						$ValorCuPaSurReal=($DatoCuPaSurReal2-$Numero)*$DatoCuPaSurReal1/1000;//Valor Real
						if($ValorCuPaSurReal<0)
							$ValorCuPaSurReal=0;
						else
							$ValorCuPaSurReal;
							//echo $ValorCuPaSurReal;
						$ValorCuPaSurPpto=($DatoCuPaSurPpto2-$Numero)*$DatoCuPaSurPpto1/1000;//Valor Ppto 				
						if($ValorCuPaSurPpto<0)
							$ValorCuPaSurPpto=0;
						else
							$ValorCuPaSurPpto;
							//echo $ValorCuPaSurPpto;
			
						$ValorReal=$ValorCuPaSurReal;
						$ValorPpto=$ValorCuPaSurPpto;
				 break;
				 case "2"://Ex cucons Andina
				 		$Numero=20; 
						$DatoCuPaAndinaReal1=DatosProyectadosTratam($Ano,$i,'1','4','TMS','R');//Valor Tratam D30 real
						$DatoCuPaAndinaPpto1=DatosProyectadosTratam($Ano,$i,'1','4','TMS','P');//Valor Tratam D30 ppto
						$DatoCuPaAndinaReal2=DatosProyectadosTratam($Ano,$i,'1','4','PLATA','R');//Valor Tratam D32 real
						$DatoCuPaAndinaPpto2=DatosProyectadosTratam($Ano,$i,'1','4','PLATA','P');//Valor Tratam D32 ppto
						
						$ValorCuAndinaReal=($DatoCuPaAndinaReal1*($DatoCuPaAndinaReal2-$Numero))/1000;
						if($ValorCuAndinaReal<0)
							$ValorCuAndinaReal=0;
						else
							$ValorCuAndinaReal;					
						$ValorCuAndinaPpto=($DatoCuPaAndinaPpto1*($DatoCuPaAndinaPpto2-$Numero))/1000;	
						if($ValorCuAndinaPpto<0)
							$ValorCuAndinaPpto=0;
						else
							$ValorCuAndinaPpto;		
																			
						$ValorReal=$ValorCuAndinaReal;	
						$ValorPpto=$ValorCuAndinaPpto;	
				 break;
				 case "1"://Ex cucons Teniente
				 		$Numero=20; 
						$DatoCuPaTeReal1=DatosProyectadosTratam($Ano,$i,'1','3','TMS','R');//Valor Tratam D23 real
						$DatoCuPaTePpto1=DatosProyectadosTratam($Ano,$i,'1','3','TMS','P');//Valor Tratam D23 ppto
						$DatoCuPaTeReal2=DatosProyectadosTratam($Ano,$i,'1','3','PLATA','R');//Valor Tratam D25 real
						$DatoCuPaTePpto2=DatosProyectadosTratam($Ano,$i,'1','3','PLATA','P');//Valor Tratam D25 ppto
						
						$ValorCuTenienteReal=($DatoCuPaTeReal1*($DatoCuPaTeReal2-$Numero))/1000;
						if($ValorCuTenienteReal<0)
							$ValorCuTenienteReal=0;
						else
							$ValorCuTenienteReal;											
						$ValorCuTenientePpto=($DatoCuPaTePpto1*($DatoCuPaTePpto2-$Numero))/1000;
						if($ValorCuTenientePpto<0)
							$ValorCuTenientePpto=0;
						else
							$ValorCuTenientePpto;
							
						$ValorReal=$ValorCuTenienteReal;
						$ValorPpto=$ValorCuTenientePpto;		 
				 break;
				 case "3"://Ex cucons CN
				 		$Numero=20; 
						$DatoCuPaNorteReal1=DatosProyectadosTratam($Ano,$i,'1','5','TMS','R');//Valor Tratam D37 real
						$DatoCuPaNortePpto1=DatosProyectadosTratam($Ano,$i,'1','5','TMS','P');//Valor Tratam D37 ppto
						$DatoCuPaNorteReal2=DatosProyectadosTratam($Ano,$i,'1','5','PLATA','R');//Valor Tratam D39 real
						$DatoCuPaNortePpto2=DatosProyectadosTratam($Ano,$i,'1','5','PLATA','P');//Valor Tratam D39 ppto
						
						$ValorCuNorteReal=($DatoCuPaNorteReal1*($DatoCuPaNorteReal2-$numero))/1000;
						if($ValorCuNorteReal<0)
							$ValorCuNorteReal=0;
						else
							$ValorCuNorteReal;														
						$ValorCuNortePpto=($DatoCuPaNortePpto1*($DatoCuPaNortePpto2-$numero))/1000;										
						if($ValorCuNortePpto<0)
							$ValorCuNortePpto=0;
						else
							$ValorCuNortePpto;														
																				
						$ValorReal=$ValorCuNorteReal;
						$ValorPpto=$ValorCuNortePpto;
				 break;
				 case "9"://Ex anodos Enami
				 		$Numero=20; 
						$DatoAnoPaEnamiReal1=DatosProyectadosTratam($Ano,$i,'3','1','TMS','R');//Valor Tratam D73 real
						$DatoAnoPaEnamiPpto1=DatosProyectadosTratam($Ano,$i,'3','1','TMS','P');//Valor Tratam D73 ppto
						$DatoAnoPaEnamiReal2=DatosProyectadosTratam($Ano,$i,'3','1','PLATA','R');//Valor Tratam D76 real
						$DatoAnoPaEnamiPpto2=DatosProyectadosTratam($Ano,$i,'3','1','PLATA','P');//Valor Tratam D76 ppto
						
						$ValorReal=$DatoAnoPaEnamiReal2-$DatoAnoPaEnamiReal1*$Numero/1000;					 					
						$ValorPpto=$DatoAnoPaEnamiPpto2-$DatoAnoPaEnamiPpto1*$Numero/1000;
				 break;
				} 
				 if($Tipo=='R')
					return($ValorReal);
				 else	
					return($ValorPpto);	
	break;
	case "Oro":
				switch($Cod)
				{
				 case "10"://Ex Anodos Sur Andes
				 		$Numero=0.5;
						$DatoAnoPaSurReal1=DatosProyectadosTratam($Ano,$i,'3','2','TMS','R');//Valor Tratam D79 real
						$DatoAnoPaSurPpto1=DatosProyectadosTratam($Ano,$i,'3','2','TMS','P');//Valor Tratam D79 ppto
						$DatoAnoPaSurReal2=DatosProyectadosTratam($Ano,$i,'3','2','ORO','R');//Valor Tratam D83 real
						$DatoAnoPaSurPpto2=DatosProyectadosTratam($Ano,$i,'3','2','ORO','P');//Valor Tratam D83 ppto
						
						$ValorAnoPaSurReal=($DatoAnoPaSurReal2-$DatoAnoPaSurReal1*$Numero1/1000);
						if($ValorAnoPaSurReal<0)
							$ValorAnoPaSurReal=0;
						else
							$ValorAnoPaSurReal;														
						$ValorAnoPaSurPpto=($DatoAnoPaSurPpto2-$DatoAnoPaSurPpto1*$Numero1/1000);										
						if($ValorAnoPaSurPpto<0)
							$ValorAnoPaSurPpto=0;
						else
							$ValorAnoPaSurPpto;	
							
						$ValorReal=$ValorAnoPaSurReal;
						$ValorPpto=$ValorAnoPaSurPpto;
				 break;
				 case "7"://Ex Anodos Teniente
				 		$Numero=0.5;
						$DatoAnoPaTeReal1=DatosProyectadosTratam($Ano,$i,'3','3','TMS','R');//Valor Tratam D85 real
						$DatoAnoPaTePpto1=DatosProyectadosTratam($Ano,$i,'3','3','TMS','P');//Valor Tratam D85 ppto
						$DatoAnoPaTeReal2=DatosProyectadosTratam($Ano,$i,'3','3','ORO','R');//Valor Tratam D89 real
						$DatoAnoPaTePpto2=DatosProyectadosTratam($Ano,$i,'3','3','ORO','P');//Valor Tratam D89 ppto
						
						$ValorAnoPaTeReal=$DatoAnoPaTeReal2-$DatoAnoPaTeReal1*$Numero1/1000;
						$ValorAnoPaTePpto=$DatoAnoPaTePpto2-$DatoAnoPaTePpto1*$Numero1/1000;
						
						$ValorReal=$ValorAnoPaTeReal;
						$ValorPpto=$ValorAnoPaTePpto;
				 break;
				 case "11"://Ex Blister Salvador
				 		$Numero=0.5;
						$DatoAnoPaBlisReal1=DatosProyectadosTratam($Ano,$i,'2','8','TMS','R');//Valor Tratam D58 real
						$DatoAnoPaBlisPpto1=DatosProyectadosTratam($Ano,$i,'2','8','TMS','P');//Valor Tratam D58 ppto
						$DatoAnoPaBlisReal2=DatosProyectadosTratam($Ano,$i,'2','8','ORO','R');//Valor Tratam D62 real
						$DatoAnoPaBlisPpto2=DatosProyectadosTratam($Ano,$i,'2','8','ORO','P');//Valor Tratam D62 ppto
						
						$ValorAnoPaBlisReal=$DatoAnoPaBlisReal2-$DatoAnoPaBlisReal1*$Numero1/1000;					
						$ValorAnoPaBlisPpto=$DatoAnoPaBlisPpto2-$DatoAnoPaBlisPpto1*$Numero1/1000;
						
						$ValorReal=$ValorAnoPaBlisReal;
						$ValorPpto=$ValorAnoPaBlisPpto;
				 break;
				 case "4"://Ex cucons Enami
				 		$Numero=0.5;
						$DatoCuPaEnamiReal1=DatosProyectadosTratam($Ano,$i,'1','1','TMS','R');//Valor Tratam D9 real
						$DatoCuPaEnamiPpto1=DatosProyectadosTratam($Ano,$i,'1','1','TMS','P');//Valor Tratam D9 ppto
						$DatoCuPaEnamiReal2=DatosProyectadosTratam($Ano,$i,'2','7','SECO FU','R');//Valor Tratam D52 real
						$DatoCuPaEnamiPpto2=DatosProyectadosTratam($Ano,$i,'2','7','SECO FU','P');//Valor Tratam D52 ppto
						$DatoCuPaEnamiReal3=DatosProyectadosTratam($Ano,$i,'1','1','ORO','R');// Valor Tratam D12 real
						$DatoCuPaEnamiReal3=DatosProyectadosTratam($Ano,$i,'1','1','ORO','P');// Valor Tratam D12 ppto
						
						$ValorRealCuPaEnami=($DatoCuPaEnamiReal1-$DatoCuPaEnamiReal2)*($DatoCuPaEnamiReal3-$Numero)/1000;
						if($ValorRealCuPaEnami<0)
							$ValorRealCuPaEnami=0;
						else
							$ValorRealCuPaEnami;				
						$ValorPptoCuPaEnami=($DatoCuPaEnamiPpto1-$DatoCuPaEnamiPpto2)*($DatoCuPaEnamiReal3-$Numero)/1000;
						if($ValorPptoCuPaEnami<0)
							$ValorPptoCuPaEnami=0;
						else
							$ValorPptoCuPaEnami;				
							
						$ValorReal=$ValorRealCuPaEnami;		
						$ValorPpto=$ValorPptoCuPaEnami;	
				 break;
				 case "6"://Ex cucons Sur Andes
				 		$Numero=0.5;
						$DatoCuPaSurReal1=DatosProyectadosTratam($Ano,$i,'1','2','TMS','R');//Valor Tratam D16 real
						$DatoCuPaSurPpto1=DatosProyectadosTratam($Ano,$i,'1','2','TMS','P');//Valor Tratam D16 ppto
						$DatoCuPaSurReal2=DatosProyectadosTratam($Ano,$i,'1','2','ORO','R');//Valor Tratam D19 real
						$DatoCuPaSurPpto2=DatosProyectadosTratam($Ano,$i,'1','2','ORO','P');//Valor Tratam D19 ppto
						
						$ValorCuPaSurReal=$DatoCuPaSurReal1*($DatoCuPaSurReal2-$Numero)/1000;//Valor Real
						if($ValorCuPaSurReal<0)
							$ValorCuPaSurReal=0;
						else
							$ValorCuPaSurReal;
						$ValorCuPaSurPpto=$DatoCuPaSurPpto1*($DatoCuPaSurPpto2-$Numero)/1000;//Valor Ppto 				
						if($ValorCuPaSurPpto<0)
							$ValorCuPaSurPpto=0;
						else
							$ValorCuPaSurPpto;
			
						$ValorReal=$ValorCuPaSurReal;
						$ValorPpto=$ValorCuPaSurPpto;
				 break;
				 case "2"://Ex cucons Andina
				 		$numero=0.5;
						$DatoCuPaAndinaReal1=DatosProyectadosTratam($Ano,$i,'1','4','TMS','R');//Valor Tratam D23 real
						$DatoCuPaAndinaPpto1=DatosProyectadosTratam($Ano,$i,'1','4','TMS','P');//Valor Tratam D23 ppto
						$DatoCuPaAndinaReal2=DatosProyectadosTratam($Ano,$i,'1','4','ORO','R');//Valor Tratam D26 real
						$DatoCuPaAndinaPpto2=DatosProyectadosTratam($Ano,$i,'1','4','ORO','P');//Valor Tratam D26 ppto
						
						$ValorCuAndinaReal=($DatoCuPaAndinaReal1*($DatoCuPaAndinaReal2-$numero))/1000;
						if($ValorCuAndinaReal<0)
							$ValorCuAndinaReal=0;
						else
							$ValorCuAndinaReal;					
						$ValorCuAndinaPpto=($DatoCuPaAndinaPpto1*($DatoCuPaAndinaPpto2-$numero))/1000;	
						if($ValorCuAndinaPpto<0)
							$ValorCuAndinaPpto=0;
						else
							$ValorCuAndinaPpto;														
								
						$ValorReal=$ValorCuAndinaReal;	
						$ValorPpto=$ValorCuAndinaPpto;	
				 break;
				 case "1"://Ex cucons Teniente
				 		$Numero=0.5;
						$DatoCuPaTeReal1=DatosProyectadosTratam($Ano,$i,'1','3','TMS','R');//Valor Tratam D23 real
						$DatoCuPaTePpto1=DatosProyectadosTratam($Ano,$i,'1','3','TMS','P');//Valor Tratam D23 ppto
						$DatoCuPaTeReal2=DatosProyectadosTratam($Ano,$i,'1','3','ORO','R');//Valor Tratam D26 real
						$DatoCuPaTePpto2=DatosProyectadosTratam($Ano,$i,'1','3','ORO','P');//Valor Tratam D26 ppto
						
						$ValorCuTenienteReal=($DatoCuPaTeReal1*($DatoCuPaTeReal2-$Numero))/1000;
						if($ValorCuTenienteReal<0)
							$ValorCuTenienteReal=0;
						else
							$ValorCuTenienteReal;											
						$ValorCuTenientePpto=($DatoCuPaTePpto1*($DatoCuPaTePpto2-$Numero))/1000;
						if($ValorCuTenientePpto<0)
							$ValorCuTenientePpto=0;
						else
							$ValorCuTenientePpto;
							
						$ValorReal=$ValorCuTenienteReal;
						$ValorPpto=$ValorCuTenientePpto;
				 break;
				 case "3"://Ex cucons CN
				 		$Numero=0.5;
						$DatoCuPaNorteReal1=DatosProyectadosTratam($Ano,$i,'1','5','TMS','R');//Valor Tratam D23 real
						$DatoCuPaNortePpto1=DatosProyectadosTratam($Ano,$i,'1','5','TMS','P');//Valor Tratam D23 ppto
						$DatoCuPaNorteReal2=DatosProyectadosTratam($Ano,$i,'1','5','ORO','R');//Valor Tratam D26 real
						$DatoCuPaNortePpto2=DatosProyectadosTratam($Ano,$i,'1','5','ORO','P');//Valor Tratam D26 ppto
						
						$ValorCuNorteReal=($DatoCuPaNorteReal1*($DatoCuPaNorteReal2-$numero))/1000;
						if($ValorCuNorteReal<0)
							$ValorCuNorteReal=0;
						else
							$ValorCuNorteReal;														
						$ValorCuNortePpto=($DatoCuPaNortePpto1*($DatoCuPaNortePpto2-$numero))/1000;										
						if($ValorCuNortePpto<0)
							$ValorCuNortePpto=0;
						else
							$ValorCuNortePpto;	
																				
						$ValorReal=$ValorCuNorteReal;
						$ValorPpto=$ValorCuNortePpto;
				 break;
				 case "9"://Ex anodos Enami
						$Numero=0.5;
						$DatoAnoPaEnamiReal1=DatosProyectadosTratam($Ano,$i,'3','1','TMS','R');//Valor Tratam D73 real
						//echo "Real1   ".$DatoAnoPaEnamiReal1."<br>";
						$DatoAnoPaEnamiPpto1=DatosProyectadosTratam($Ano,$i,'3','1','TMS','P');//Valor Tratam D73 ppto
						//echo "Ppto1   ".$DatoAnoPaEnamiPpto1."<br>";
						$DatoAnoPaEnamiReal2=DatosProyectadosTratam($Ano,$i,'3','1','ORO','R');//Valor Tratam D77 real
						//echo "Real2   ".$DatoAnoPaEnamiReal2."<br>";
						$DatoAnoPaEnamiPpto2=DatosProyectadosTratam($Ano,$i,'3','1','ORO','P');//Valor Tratam D77 ppto
						//echo "Ppto2   ".$DatoAnoPaEnamiPpto2."<br>";
						
						$ValorReal=$DatoAnoPaEnamiReal2-$DatoAnoPaEnamiReal1*$Numero1/1000;					 					
						$ValorPpto=$DatoAnoPaEnamiPpto2-$DatoAnoPaEnamiPpto1*$Numero1/1000;
				 break;
				} 
				 if($Tipo=='R')
					return($ValorReal);
				 else	
					return($ValorPpto);	
	break;					
  }	
}
function BuscaDatosOro($Cod,$Tipo,$Ano,$i)
{
	switch($Cod)
	{
		 case "10"://Ex Anodos Sur Andes
		 		$Numero=0.5;
				$DatoAnoPaSurReal1=DatosProyectadosTratam($Ano,$i,'3','2','TMS','R');//Valor Tratam D79 real
				$DatoAnoPaSurPpto1=DatosProyectadosTratam($Ano,$i,'3','2','TMS','P');//Valor Tratam D79 ppto
				$DatoAnoPaSurReal2=DatosProyectadosTratam($Ano,$i,'3','2','ORO','R');//Valor Tratam D83 real
				$DatoAnoPaSurPpto2=DatosProyectadosTratam($Ano,$i,'3','2','ORO','P');//Valor Tratam D83 ppto
				
				$ValorAnoPaSurReal=($DatoAnoPaSurReal2-$DatoAnoPaSurReal1*$Numero1/1000);
				if($ValorAnoPaSurReal<0)
					$ValorAnoPaSurReal=0;
				else
					$ValorAnoPaSurReal;														
				$ValorAnoPaSurPpto=($DatoAnoPaSurPpto2-$DatoAnoPaSurPpto1*$Numero1/1000);										
				if($ValorAnoPaSurPpto<0)
					$ValorAnoPaSurPpto=0;
				else
					$ValorAnoPaSurPpto;	
					
				$ValorReal=$ValorAnoPaSurReal;
				$ValorPpto=$ValorAnoPaSurPpto;
		 break;
		 case "7"://Ex Anodos Teniente
		 		$Numero=0.5;
				$DatoAnoPaTeReal1=DatosProyectadosTratam($Ano,$i,'3','3','TMS','R');//Valor Tratam D85 real
				$DatoAnoPaTePpto1=DatosProyectadosTratam($Ano,$i,'3','3','TMS','P');//Valor Tratam D85 ppto
				$DatoAnoPaTeReal2=DatosProyectadosTratam($Ano,$i,'3','3','ORO','R');//Valor Tratam D89 real
				$DatoAnoPaTePpto2=DatosProyectadosTratam($Ano,$i,'3','3','ORO','P');//Valor Tratam D89 ppto
				
				$ValorAnoPaTeReal=$DatoAnoPaTeReal2-$DatoAnoPaTeReal1*$Numero1/1000;
				$ValorAnoPaTePpto=$DatoAnoPaTePpto2-$DatoAnoPaTePpto1*$Numero1/1000;
				
				$ValorReal=$ValorAnoPaTeReal;
				$ValorPpto=$ValorAnoPaTePpto;
		 break;
		 case "11"://Ex Blister Salvador
		 		$Numero=0.5;
				$DatoAnoPaBlisReal1=DatosProyectadosTratam($Ano,$i,'2','8','TMS','R');//Valor Tratam D58 real
				$DatoAnoPaBlisPpto1=DatosProyectadosTratam($Ano,$i,'2','8','TMS','P');//Valor Tratam D58 ppto
				$DatoAnoPaBlisReal2=DatosProyectadosTratam($Ano,$i,'2','8','ORO','R');//Valor Tratam D62 real
				$DatoAnoPaBlisPpto2=DatosProyectadosTratam($Ano,$i,'2','8','ORO','P');//Valor Tratam D62 ppto
				
				$ValorAnoPaBlisReal=$DatoAnoPaBlisReal2-$DatoAnoPaBlisReal1*$Numero1/1000;					
				$ValorAnoPaBlisPpto=$DatoAnoPaBlisPpto2-$DatoAnoPaBlisPpto1*$Numero1/1000;
				
				$ValorReal=$ValorAnoPaBlisReal;
				$ValorPpto=$ValorAnoPaBlisPpto;
		 break;
		 case "4"://Ex cucons Enami
		 		$Numero=0.5;
				$DatoCuPaEnamiReal1=DatosProyectadosTratam($Ano,$i,'1','1','TMS','R');//Valor Tratam D9 real
				$DatoCuPaEnamiPpto1=DatosProyectadosTratam($Ano,$i,'1','1','TMS','P');//Valor Tratam D9 ppto
				$DatoCuPaEnamiReal2=DatosProyectadosTratam($Ano,$i,'2','7','SECO FU','R');//Valor Tratam D52 real
				$DatoCuPaEnamiPpto2=DatosProyectadosTratam($Ano,$i,'2','7','SECO FU','P');//Valor Tratam D52 ppto
				$DatoCuPaEnamiReal3=DatosProyectadosTratam($Ano,$i,'1','1','ORO','R');// Valor Tratam D12 real
				$DatoCuPaEnamiReal3=DatosProyectadosTratam($Ano,$i,'1','1','ORO','P');// Valor Tratam D12 ppto
				
				$ValorRealCuPaEnami=($DatoCuPaEnamiReal1-$DatoCuPaEnamiReal2)*($DatoCuPaEnamiReal3-$Numero)/1000;
				if($ValorRealCuPaEnami<0)
					$ValorRealCuPaEnami=0;
				else
					$ValorRealCuPaEnami;				
				$ValorPptoCuPaEnami=($DatoCuPaEnamiPpto1-$DatoCuPaEnamiPpto2)*($DatoCuPaEnamiReal3-$Numero)/1000;
				if($ValorPptoCuPaEnami<0)
					$ValorPptoCuPaEnami=0;
				else
					$ValorPptoCuPaEnami;	
					
				$ValorReal=$ValorRealCuPaEnami;		
				$ValorPpto=$ValorPptoCuPaEnami;	
		 break;
		 case "6"://Ex cucons Sur Andes
		 		$Numero=0.5;
				$DatoCuPaSurReal1=DatosProyectadosTratam($Ano,$i,'1','2','TMS','R');//Valor Tratam D16 real
				$DatoCuPaSurPpto1=DatosProyectadosTratam($Ano,$i,'1','2','TMS','P');//Valor Tratam D16 ppto
				$DatoCuPaSurReal2=DatosProyectadosTratam($Ano,$i,'1','2','ORO','R');//Valor Tratam D19 real
				$DatoCuPaSurPpto2=DatosProyectadosTratam($Ano,$i,'1','2','ORO','P');//Valor Tratam D19 ppto
				
				$ValorCuPaSurReal=$DatoCuPaSurReal1*($DatoCuPaSurReal2-$Numero)/1000;//Valor Real
				if($ValorCuPaSurReal<0)
					$ValorCuPaSurReal=0;
				else
					$ValorCuPaSurReal;
				$ValorCuPaSurPpto=$DatoCuPaSurPpto1*($DatoCuPaSurPpto2-$Numero)/1000;//Valor Ppto 				
				if($ValorCuPaSurPpto<0)
					$ValorCuPaSurPpto=0;
				else
					$ValorCuPaSurPpto;
	
				$ValorReal=$ValorCuPaSurReal;
				$ValorPpto=$ValorCuPaSurPpto;
		 break;
		 case "2"://Ex cucons Andina
		 		$Numero=0.5;
				$DatoCuPaAndinaReal1=DatosProyectadosTratam($Ano,$i,'1','4','TMS','R');//Valor Tratam D23 real
				$DatoCuPaAndinaPpto1=DatosProyectadosTratam($Ano,$i,'1','4','TMS','P');//Valor Tratam D23 ppto
				$DatoCuPaAndinaReal2=DatosProyectadosTratam($Ano,$i,'1','4','ORO','R');//Valor Tratam D26 real
				$DatoCuPaAndinaPpto2=DatosProyectadosTratam($Ano,$i,'1','4','ORO','P');//Valor Tratam D26 ppto
				
				$ValorCuAndinaReal=($DatoCuPaAndinaReal1*($DatoCuPaAndinaReal2-$numero))/1000;
				if($ValorCuAndinaReal<0)
					$ValorCuAndinaReal=0;
				else
					$ValorCuAndinaReal;					
				$ValorCuAndinaPpto=($DatoCuPaAndinaPpto1*($DatoCuPaAndinaPpto2-$numero))/1000;	
				if($ValorCuAndinaPpto<0)
					$ValorCuAndinaPpto=0;
				else
					$ValorCuAndinaPpto;	
						
				$ValorReal=$ValorCuAndinaReal;	
				$ValorPpto=$ValorCuAndinaPpto;	
		 break;
		 case "1"://Ex cucons Teniente
		 		$Numero=0.5;
				$DatoCuPaTeReal1=DatosProyectadosTratam($Ano,$i,'1','3','TMS','R');//Valor Tratam D23 real
				$DatoCuPaTePpto1=DatosProyectadosTratam($Ano,$i,'1','3','TMS','P');//Valor Tratam D23 ppto
				$DatoCuPaTeReal2=DatosProyectadosTratam($Ano,$i,'1','3','ORO','R');//Valor Tratam D26 real
				$DatoCuPaTePpto2=DatosProyectadosTratam($Ano,$i,'1','3','ORO','P');//Valor Tratam D26 ppto
				
				$ValorCuTenienteReal=($DatoCuPaTeReal1*($DatoCuPaTeReal2-$Numero))/1000;
				if($ValorCuTenienteReal<0)
					$ValorCuTenienteReal=0;
				else
					$ValorCuTenienteReal;											
				$ValorCuTenientePpto=($DatoCuPaTePpto1*($DatoCuPaTePpto2-$Numero))/1000;
				if($ValorCuTenientePpto<0)
					$ValorCuTenientePpto=0;
				else
					$ValorCuTenientePpto;
					
				$ValorReal=$ValorCuTenienteReal;
				$ValorPpto=$ValorCuTenientePpto;
		 break;
		 case "3"://Ex cucons CN
		 		$Numero=0.5;
				$DatoCuPaNorteReal1=DatosProyectadosTratam($Ano,$i,'1','5','TMS','R');//Valor Tratam D23 real
				$DatoCuPaNortePpto1=DatosProyectadosTratam($Ano,$i,'1','5','TMS','P');//Valor Tratam D23 ppto
				$DatoCuPaNorteReal2=DatosProyectadosTratam($Ano,$i,'1','5','ORO','R');//Valor Tratam D26 real
				$DatoCuPaNortePpto2=DatosProyectadosTratam($Ano,$i,'1','5','ORO','P');//Valor Tratam D26 ppto
				
				$ValorCuNorteReal=($DatoCuPaNorteReal1*($DatoCuPaNorteReal2-$numero))/1000;
				if($ValorCuNorteReal<0)
					$ValorCuNorteReal=0;
				else
					$ValorCuNorteReal;														
				$ValorCuNortePpto=($DatoCuPaNortePpto1*($DatoCuPaNortePpto2-$numero))/1000;										
				if($ValorCuNortePpto<0)
					$ValorCuNortePpto=0;
				else
					$ValorCuNortePpto;	
																		
				$ValorReal=$ValorCuNorteReal;
				$ValorPpto=$ValorCuNortePpto;
		 break;
		 case "9"://Ex anodos Enami
		 		$Numero=0.5;
				$DatoAnoPaEnamiReal1=DatosProyectadosTratam($Ano,$i,'3','1','TMS','R');//Valor Tratam D73 real
				//echo "Real1   ".$DatoAnoPaEnamiReal1."<br>";
				$DatoAnoPaEnamiPpto1=DatosProyectadosTratam($Ano,$i,'3','1','TMS','P');//Valor Tratam D73 ppto
				//echo "Ppto1   ".$DatoAnoPaEnamiPpto1."<br>";
				$DatoAnoPaEnamiReal2=DatosProyectadosTratam($Ano,$i,'3','1','ORO','R');//Valor Tratam D77 real
				//echo "Real2   ".$DatoAnoPaEnamiReal2."<br>";
				$DatoAnoPaEnamiPpto2=DatosProyectadosTratam($Ano,$i,'3','1','ORO','P');//Valor Tratam D77 ppto
				//echo "Ppto2   ".$DatoAnoPaEnamiPpto2."<br>";
				
				$ValorReal=$DatoAnoPaEnamiReal2-$DatoAnoPaEnamiReal1*$Numero1/1000;					 					
				$ValorPpto=$DatoAnoPaEnamiPpto2-$DatoAnoPaEnamiPpto1*$Numero1/1000;
		 break;
	}
	if($Tipo=='R')
		return($ValorReal); 
	else
		return($ValorPpto);
}
function BuscaDatosPlata($Cod,$Tipo,$Ano,$i)
{
	switch($Cod)
	{
		 case "10"://Ex Anodos Sur Andes
				$DatoAnoPaSurReal1=DatosProyectadosTratam($Ano,$i,'3','2','TMS','R');//Valor Tratam D79 real
				$DatoAnoPaSurPpto1=DatosProyectadosTratam($Ano,$i,'3','2','TMS','P');//Valor Tratam D79 ppto
				$DatoAnoPaSurReal2=DatosProyectadosTratam($Ano,$i,'3','2','PLATA','R');//Valor Tratam D82 real
				$DatoAnoPaSurPpto2=DatosProyectadosTratam($Ano,$i,'3','2','PLATA','P');//Valor Tratam D82 ppto
				
				$ValorAnoPaSurReal=($DatoAnoPaSurReal2-$DatoAnoPaSurReal1*$Numero/1000);
				if($ValorAnoPaSurReal<0)
					$ValorAnoPaSurReal=0;
				else
					$ValorAnoPaSurReal;														
				$ValorAnoPaSurPpto=($DatoAnoPaSurPpto2-$DatoAnoPaSurPpto1*$Numero/1000);										
				if($ValorAnoPaSurPpto<0)
					$ValorAnoPaSurPpto=0;
				else
					$ValorAnoPaSurPpto;		
					
				$ValorReal=$ValorAnoPaSurReal;
				$ValorPpto=$ValorAnoPaSurPpto;		 
		 break;
		 case "7"://Ex Anodos Teniente
				$DatoAnoPaTeReal1=DatosProyectadosTratam($Ano,$i,'3','3','TMS','R');//Valor Tratam D85 real
				$DatoAnoPaTePpto1=DatosProyectadosTratam($Ano,$i,'3','3','TMS','P');//Valor Tratam D85 ppto
				$DatoAnoPaTeReal2=DatosProyectadosTratam($Ano,$i,'3','3','PLATA','R');//Valor Tratam D88 real
				$DatoAnoPaTePpto2=DatosProyectadosTratam($Ano,$i,'3','3','PLATA','P');//Valor Tratam D88 ppto
				
				$ValorAnoPaTeReal=$DatoAnoPaTeReal2-$DatoAnoPaTeReal1*$Numero/1000;
				$ValorAnoPaTePpto=$DatoAnoPaTePpto2-$DatoAnoPaTePpto1*$Numero/1000;
				
				$ValorReal=$ValorAnoPaTeReal;
				$ValorPpto=$ValorAnoPaTePpto;
		 break;
		 case "11"://Ex Blister Salvador
				$DatoAnoPaBlisReal1=DatosProyectadosTratam($Ano,$i,'2','8','TMS','R');//Valor Tratam D58 real
				$DatoAnoPaBlisPpto1=DatosProyectadosTratam($Ano,$i,'2','8','TMS','P');//Valor Tratam D58 ppto
				$DatoAnoPaBlisReal2=DatosProyectadosTratam($Ano,$i,'2','8','PLATA','R');//Valor Tratam D61 real
				$DatoAnoPaBlisPpto2=DatosProyectadosTratam($Ano,$i,'2','8','PLATA','P');//Valor Tratam D61 ppto
				
				$ValorAnoPaBlisReal=$DatoAnoPaBlisReal2-$DatoAnoPaBlisReal1*$Numero1/1000;					
				$ValorAnoPaBlisPpto=$DatoAnoPaBlisPpto2-$DatoAnoPaBlisPpto1*$Numero1/1000;
				
				$ValorReal=$ValorAnoPaBlisReal;
				$ValorPpto=$ValorAnoPaBlisPpto;
		 break;
		 case "4"://Ex cucons Enami
				$DatoCuPaEnamiReal1=DatosProyectadosTratam($Ano,$i,'1','1','PLATA','R');//Valor Tratam D11 real
				$DatoCuPaEnamiPpto1=DatosProyectadosTratam($Ano,$i,'1','1','PLATA','P');//Valor Tratam D11 ppto
				$DatoCuPaEnamiReal2=DatosProyectadosTratam($Ano,$i,'1','1','TMS','R');// Valor Tratam D9 real
				$DatoCuPaEnamiPpto2=DatosProyectadosTratam($Ano,$i,'1','1','TMS','P');// Valor Tratam D9 ppto
				$DatoCuPaEnamiReal3=DatosProyectadosTratam($Ano,$i,'2','7','SECO FU','R');//Valor Tratam D52 real
				$DatoCuPaEnamiPpto3=DatosProyectadosTratam($Ano,$i,'2','7','SECO FU','P');//Valor Tratam D52 ppto
				
				$ValorRealCuPaEnami=($DatoCuPaEnamiReal1-$Numero)*($DatoCuPaEnamiReal2-$DatoCuPaEnamiReal3)/1000;
				if($ValorRealCuPaEnami<0)
					$ValorRealCuPaEnami=0;
				else
					$ValorRealCuPaEnami;				
				$ValorPptoCuPaEnami=($DatoCuPaEnamiPpto1-$Numero)*($DatoCuPaEnamiPpto2-$DatoCuPaEnamiPpto3)/1000;
				if($ValorPptoCuPaEnami<0)
					$ValorPptoCuPaEnami=0;
				else
					$ValorPptoCuPaEnami;				
					
				$ValorReal=$ValorRealCuPaEnami;		
				$ValorPpto=$ValorPptoCuPaEnami;	
		 break;
		 case "6"://Ex cucons Sur Andes
				$DatoCuPaSurReal1=DatosProyectadosTratam($Ano,$i,'1','2','TMS','R');//Valor Tratam D16 real
				$DatoCuPaSurPpto1=DatosProyectadosTratam($Ano,$i,'1','2','TMS','P');//Valor Tratam D16 ppto
				$DatoCuPaSurReal2=DatosProyectadosTratam($Ano,$i,'1','2','PLATA','R');//Valor Tratam D18 real
				$DatoCuPaSurPpto2=DatosProyectadosTratam($Ano,$i,'1','2','PLATA','P');//Valor Tratam D18 ppto
				
				$ValorCuPaSurReal=($DatoCuPaSurReal2-$Numero)*$DatoCuPaSurReal1/1000;//Valor Real
				if($ValorCuPaSurReal<0)
					$ValorCuPaSurReal=0;
				else
					$ValorCuPaSurReal;
					//echo $ValorCuPaSurReal;
				$ValorCuPaSurPpto=($DatoCuPaSurPpto2-$Numero)*$DatoCuPaSurPpto1/1000;//Valor Ppto 				
				if($ValorCuPaSurPpto<0)
					$ValorCuPaSurPpto=0;
				else
					$ValorCuPaSurPpto;
					//echo $ValorCuPaSurPpto;
	
				$ValorReal=$ValorCuPaSurReal;
				$ValorPpto=$ValorCuPaSurPpto;
		 break;
		 case "2"://Ex cucons Andina
				$DatoCuPaAndinaReal1=DatosProyectadosTratam($Ano,$i,'1','4','TMS','R');//Valor Tratam D30 real
				$DatoCuPaAndinaPpto1=DatosProyectadosTratam($Ano,$i,'1','4','TMS','P');//Valor Tratam D30 ppto
				$DatoCuPaAndinaReal2=DatosProyectadosTratam($Ano,$i,'1','4','PLATA','R');//Valor Tratam D32 real
				$DatoCuPaAndinaPpto2=DatosProyectadosTratam($Ano,$i,'1','4','PLATA','P');//Valor Tratam D32 ppto
				
				$ValorCuAndinaReal=($DatoCuPaAndinaReal1*($DatoCuPaAndinaReal2-$Numero))/1000;
				if($ValorCuAndinaReal<0)
					$ValorCuAndinaReal=0;
				else
					$ValorCuAndinaReal;					
				$ValorCuAndinaPpto=($DatoCuPaAndinaPpto1*($DatoCuPaAndinaPpto2-$Numero))/1000;	
				if($ValorCuAndinaPpto<0)
					$ValorCuAndinaPpto=0;
				else
					$ValorCuAndinaPpto;		
																	
				$ValorReal=$ValorCuAndinaReal;	
				$ValorPpto=$ValorCuAndinaPpto;	
		 break;
		 case "1"://Ex cucons Teniente
				$DatoCuPaTeReal1=DatosProyectadosTratam($Ano,$i,'1','3','TMS','R');//Valor Tratam D23 real
				$DatoCuPaTePpto1=DatosProyectadosTratam($Ano,$i,'1','3','TMS','P');//Valor Tratam D23 ppto
				$DatoCuPaTeReal2=DatosProyectadosTratam($Ano,$i,'1','3','PLATA','R');//Valor Tratam D25 real
				$DatoCuPaTePpto2=DatosProyectadosTratam($Ano,$i,'1','3','PLATA','P');//Valor Tratam D25 ppto
				
				$ValorCuTenienteReal=($DatoCuPaTeReal1*($DatoCuPaTeReal2-$Numero))/1000;
				if($ValorCuTenienteReal<0)
					$ValorCuTenienteReal=0;
				else
					$ValorCuTenienteReal;											
				$ValorCuTenientePpto=($DatoCuPaTePpto1*($DatoCuPaTePpto2-$Numero))/1000;
				if($ValorCuTenientePpto<0)
					$ValorCuTenientePpto=0;
				else
					$ValorCuTenientePpto;
					
				$ValorReal=$ValorCuTenienteReal;
				$ValorPpto=$ValorCuTenientePpto;		 
		 break;
		 case "3"://Ex cucons CN
				$DatoCuPaNorteReal1=DatosProyectadosTratam($Ano,$i,'1','5','TMS','R');//Valor Tratam D37 real
				$DatoCuPaNortePpto1=DatosProyectadosTratam($Ano,$i,'1','5','TMS','P');//Valor Tratam D37 ppto
				$DatoCuPaNorteReal2=DatosProyectadosTratam($Ano,$i,'1','5','PLATA','R');//Valor Tratam D39 real
				$DatoCuPaNortePpto2=DatosProyectadosTratam($Ano,$i,'1','5','PLATA','P');//Valor Tratam D39 ppto
				
				$ValorCuNorteReal=($DatoCuPaNorteReal1*($DatoCuPaNorteReal2-$numero))/1000;
				if($ValorCuNorteReal<0)
					$ValorCuNorteReal=0;
				else
					$ValorCuNorteReal;														
				$ValorCuNortePpto=($DatoCuPaNortePpto1*($DatoCuPaNortePpto2-$numero))/1000;										
				if($ValorCuNortePpto<0)
					$ValorCuNortePpto=0;
				else
					$ValorCuNortePpto;														
																		
				$ValorReal=$ValorCuNorteReal;
				$ValorPpto=$ValorCuNortePpto;
		 break;
		 case "9"://Ex anodos Enami
				$DatoAnoPaEnamiReal1=DatosProyectadosTratam($Ano,$i,'3','1','TMS','R');//Valor Tratam D73 real
				$DatoAnoPaEnamiPpto1=DatosProyectadosTratam($Ano,$i,'3','1','TMS','P');//Valor Tratam D73 ppto
				$DatoAnoPaEnamiReal2=DatosProyectadosTratam($Ano,$i,'3','1','PLATA','R');//Valor Tratam D76 real
				$DatoAnoPaEnamiPpto2=DatosProyectadosTratam($Ano,$i,'3','1','PLATA','P');//Valor Tratam D76 ppto
				
				$ValorReal=$DatoAnoPaEnamiReal2-$DatoAnoPaEnamiReal1*$Numero/1000;					 					
				$ValorPpto=$DatoAnoPaEnamiPpto2-$DatoAnoPaEnamiPpto1*$Numero/1000;
		 break;
	}
	if($Tipo=='R')
		return($ValorReal); 
	else
		return($ValorPpto);
}
?>
