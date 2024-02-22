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
<title>Reporte Precio Barro</title>
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
      <td align="center" rowspan="2">Precio Barro An&oacute;dico Descobrizado</td>
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
      <td align="center" >Real</td>
      <td align="center">Proyectado</td>
      <?	
			}
			?>
    </tr>
    <?			
			$Buscar='S';
  			 if($Buscar=='S')
			 {
				  //ACA EMPIEZA LA PARTE DE LOS PRODUCTOS				 	
				  $Consulta="select cod_subclase,nombre_subclase,valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='31049' order by cod_subclase";				  
				  $Resp=mysql_query($Consulta);
				  //echo $Consulta."<br>";
				  while($Fila=mysql_fetch_array($Resp))
				  {	
					 if($Fila["cod_subclase"]=='1'||$Fila["cod_subclase"]=='5'||$Fila["cod_subclase"]=='9'||$Fila["cod_subclase"]=='12'||$Fila["cod_subclase"]=='15')
						$Clase='pie_tabla_bold';
					 else
						$Clase='TituloTablaNaranja';					     			  	
					?>
    <tr >
      <td width="24%" colspan="25" align="left" ><? echo $Fila["nombre_subclase"];?></td>
      <?
					  $Productos=explode(",",$Fila["valor_subclase1"]);
					  while(list($c,$v)=each($Productos))
					  {
						  $Consulta1="select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31050' and cod_subclase='".$v."'";				  
						  $Resp1=mysql_query($Consulta1);
						  //echo $Consulta1."<br>";
						  while($Fila1=mysql_fetch_array($Resp1))
						  {
								?>
    <tr>
      <td width="24%" align="left" >&nbsp;&nbsp;&nbsp;<? echo $Fila1["nombre_subclase"];?></td>
      <?
								for($i=$Mes;$i<=$MesFin;$i++)
								{
									//echo "Codigo:   ".$Fila["cod_subclase"]."   Codigo 2:   ".$Fila1["cod_subclase"];									
									if($Fila1["cod_subclase"]=='10')									
									{
										echo "<td rowspan='1' align='right'>&nbsp;</td>";
										echo "<td rowspan='1' align='right'>&nbsp;</td>";							 						 
									}
									else
									{
										$Real=DatosSuma($Fila["cod_subclase"],$Fila1["cod_subclase"],'R',$Ano,$i);
										$Ppto=DatosSuma($Fila["cod_subclase"],$Fila1["cod_subclase"],'P',$Ano,$i);
										echo "<td rowspan='1' align='right'>".number_format($Real,0,',','.')."</td>";
										echo "<td rowspan='1' align='right'>".number_format($Ppto,0,',','.')."</td>";							 						 
									}
								}
						  }		
					  }	
					  if($Fila["cod_subclase"]!='15')
					  {	
							echo" <tr>";
							echo "<td align='left' colspan='25'>&nbsp;</td>";
							echo" </tr>";
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
function DatosProyectadosSVP($Producto,$Proveedor,$Ano,$Mes)
{
   $Consulta="select Vporden,Vptm,VPmaterial,Vptipinv,VPordenrel,Vpordes from pcip_inp_asignacion";
   $Consulta.=" where cod_producto='".$Producto."' and cod_proveedor='".$Proveedor."' and dato='1'";
   //echo $Consulta."<br>";
   $Resp=mysql_query($Consulta);  
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
function DatosProyectadosPPC($Producto,$Proveedor,$Ano,$Mes)
{
   $Datos2=0;
   $Consulta="select Vporden,Vptm,VPmaterial,Vptipinv from pcip_inp_asignacion";
   $Consulta.=" where cod_producto='".$Producto."' and cod_proveedor='".$Proveedor."' and dato='2'";
   //echo $Consulta."<br>";
   $Resp=mysql_query($Consulta);  
   while($Fila=mysql_fetch_array($Resp))
   {
		$Asignacion=$Fila[Vporden];
		$Procedencia=$Fila[Vptm];
		$Negocio=$Fila[VPmaterial];
		$Titulo=$Fila[Vptipinv];
		
		$Consulta2 =" select valor from pcip_ppc_detalle ";
		$Consulta2.=" where ano='".$Ano."' and mes='".$Mes."' and cod_asignacion='".$Asignacion."' and cod_procedencia='".$Procedencia."' and cod_negocio='".$Negocio."' and cod_titulo='".$Titulo."'";
		//echo $Consulta2."<br>";
		$RespAux1=mysql_query($Consulta2);
		if($FilaAux1=mysql_fetch_array($RespAux1))
		{
			$Datos2=$Datos2+$FilaAux1[valor];
			//echo "Valor datos consyulta 1   ".$Datos1."&nbsp;";
			//$Datos2=$FilaAux[ValorPresupuestado];
			//echo "Valor datos consyulta 2   ".$Datos2."<br>";
		}
	}
	return($Datos2);	
}

function DatosProyectadosTratam($Ano,$Mes,$Area,$Division,$Producto,$Tipo)
{
   $Datos1=0;$Datos2=0;
   $Consulta="select valor_real as ValorReal,valor_presupuestado as ValorPresupuestado from pcip_inp_tratam";
   $Consulta.=" where ano='".$Ano."' and mes='".$Mes."' and nom_area='".$Area."' and nom_division='".$Division."' and cod_producto='".$Producto."'";
   //echo $Consulta."<br>";
   $Resp=mysql_query($Consulta);  
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
  $DatoSalidaReal=0;$DatoSalidaPpto=0;
  switch($Cod)
  {
    case "1"://BARRO CHUQUICAMATA
	case "5"://BARRO VENTANAS	
	case "9"://METAL DORE FLORIDA ENTREGABLE
	case "12"://BULLION DE ORO	
				switch($Tipo1)
				{	
				 case "1"://TMS	
				        if($Cod=='1')
						{
							$DatoSalidaReal=DatosProyectadosTratam($Ano,$i,'4','11','SECO','R');						
							$DatoSalidaPpto=DatosProyectadosTratam($Ano,$i,'4','11','SECO','P');
						}
						if($Cod=='5')
						{
							$DatoSalidaReal=DatosProyectadosTratam($Ano,$i,'4','26','NULL','R');//TRATAM REAL
							$DatoSalidaPpto=DatosProyectadosTratam($Ano,$i,'4','26','NULL','P');//TRATAM PPTO						
						}  
						if($Cod=='9')
						{
							$DatoSalidaReal=DatosProyectadosTratam($Ano,$i,'4','12','SECO','R');//TRATAM REAL
							$DatoSalidaPpto=DatosProyectadosTratam($Ano,$i,'4','12','SECO','P');//TRATAM PPTO						
						}						
						if($Cod=='12')
						{
							$DatoSalidaReal=DatosProyectadosTratam($Ano,$i,'4','13','SECO','R');//TRATAM REAL
							$DatoSalidaPpto=DatosProyectadosTratam($Ano,$i,'4','13','SECO','P');//TRATAM PPTO						
						}
				 break;
				 case "2"://PLATA
				 		if($Cod=='1')	
						{
							$DatoSalidaReal=DatosProyectadosTratam($Ano,$i,'4','11','PLATA','R');
							$DatoSalidaPpto=DatosProyectadosTratam($Ano,$i,'4','11','PLATA','P');
						}
						if($Cod=='5')
						{
							$DatoSalidaR=DatosPrecios_Barro('2','10',$Ano,$i,'R');					
							$Dato=DatosPreciosDore($Ano,'4','30');
							$Dato=$Dato/100;
							$DatoSalidaReal=$DatoSalidaR/(1-$Dato);
							$DatoSalidaP=DatosPrecios_Barro('2','10',$Ano,$i,'P');
							$DatoSalidaPpto=$DatoSalidaP/(1-$Dato);
						}
						if($Cod=='9')
						{
							$DatoSalidaReal=DatosProyectadosTratam($Ano,$i,'4','12','PLATA','R');//TRATAM REAL
							$DatoSalidaPpto=DatosProyectadosTratam($Ano,$i,'4','12','PLATA','P');//TRATAM PPTO						
						}
						if($Cod=='12')
						{
							$DatoSalidaReal=DatosProyectadosTratam($Ano,$i,'4','13','PLATA','R');//TRATAM REAL
							$DatoSalidaPpto=DatosProyectadosTratam($Ano,$i,'4','13','PLATA','P');//TRATAM PPTO						
						}						
				 break;
				 case "3"://ORO
				 		if($Cod=='1')	
						{
							$DatoSalidaReal=DatosProyectadosTratam($Ano,$i,'4','11','ORO','R');
							$DatoSalidaPpto=DatosProyectadosTratam($Ano,$i,'4','11','ORO','P');
						}
						if($Cod=='5')
						{
							$DatoSalidaR=DatosPrecios_Barro('2','11',$Ano,$i,'R');
							$Dato=DatosPreciosDore($Ano,'4','31');
							$Dato=$Dato/100;
							$DatoSalidaReal=$DatoSalidaR/(1-$Dato);
							$DatoSalidaP=DatosPrecios_Barro('2','11',$Ano,$i,'P');
							$DatoSalidaPpto=$DatoSalidaP/(1-$Dato);
						}
						if($Cod=='9')
						{
							$DatoSalidaReal=DatosProyectadosTratam($Ano,$i,'4','12','ORO','R');//TRATAM REAL
							$DatoSalidaPpto=DatosProyectadosTratam($Ano,$i,'4','12','ORO','P');//TRATAM PPTO						
						}
						if($Cod=='12')
						{
							$DatoSalidaReal=DatosProyectadosTratam($Ano,$i,'4','13','ORO','R');//TRATAM REAL
							$DatoSalidaPpto=DatosProyectadosTratam($Ano,$i,'4','13','ORO','P');//TRATAM PPTO						
						}						
				 break;
				} 	
    case "2"://FINOS CONTRACTUALES
	case "6"://FINOS CONTRACTUALES SEGUNA ETAPA
	case "10"://FINOS CONTRACTUALES TERCERA ETAPA
	case "13"://FINOS CONTRACTUALES CUARTA ETAPA
	case "16"://METAL DORE + BULLION	
				switch($Tipo1)
				{					 
				 case "2"://PLATA
				 		if($Cod=='2')
						{
							$Dato=DatosPreciosDore($Ano,'4','30');
							$Dato=$Dato/100;
							$DatoReal1=DatosProyectadosTratam($Ano,$i,'4','11','PLATA','R');
							$DatoPpto1=DatosProyectadosTratam($Ano,$i,'4','11','PLATA','P');
							
							$DatoSalidaReal=$DatoReal1*(1-$Dato);
							$DatoSalidaPpto=$DatoPpto1*(1-$Dato);
						}
						if($Cod=='6')
						{
							$DatoSalidaReal=DatosPrecios_Barro('2','10',$Ano,$i,'R');					
							$DatoSalidaPpto=DatosPrecios_Barro('2','10',$Ano,$i,'P');					
						}	
						if($Cod=='10')
						{
							$DatoB6=DatosPreciosDore($Ano,'4','30');
							$DatoB6=$DatoB6/100;
							$DatoD59Real=DatosProyectadosTratam($Ano,$i,'4','12','PLATA','R');//TRATAM REAL
							$DatoSalidaReal=$DatoD59Real*(1-$DatoB6);
							
							$DatoD59Ppto=DatosProyectadosTratam($Ano,$i,'4','12','PLATA','P');//TRATAM PPTO	
							$DatoSalidaPpto=$DatoD59Ppto*(1-$DatoB6);					
						}
						if($Cod=='13')
						{
							$DatoB6=DatosPreciosDore($Ano,'4','30');
							$DatoB6=$DatoB6/100;							
							$DatoD76Real=DatosProyectadosTratam($Ano,$i,'4','13','PLATA','R');//TRATAM REAL
							$DatoSalidaReal=$DatoD76Real*(1-$DatoB6);
							
							$DatoD76Ppto=DatosProyectadosTratam($Ano,$i,'4','13','PLATA','P');//TRATAM PPTO
							$DatoSalidaPpto=$DatoD76Ppto*(1-$DatoB6);													
						}
						if($Cod=='16')
						{
							$DatoB6=DatosPreciosDore($Ano,'4','30');
							$DatoB6=$DatoB6/100;
							$DatoD59Real=DatosProyectadosTratam($Ano,$i,'4','12','PLATA','R');//TRATAM REAL
							$Dato1=$DatoD59Real*(1-$DatoB6);//D62 REAL
							
							$DatoD59Ppto=DatosProyectadosTratam($Ano,$i,'4','12','PLATA','P');//TRATAM PPTO	
							$Dato2=$DatoD59Ppto*(1-$DatoB6);//D62 PPTO					
						 	
							$DatoB6=DatosPreciosDore($Ano,'4','30');
							$DatoB6=$DatoB6/100;							
							$DatoD76Real=DatosProyectadosTratam($Ano,$i,'4','13','PLATA','R');//TRATAM REAL
							$Dato3=$DatoD76Real*(1-$DatoB6);//D79 REAL
							
							$DatoD76Ppto=DatosProyectadosTratam($Ano,$i,'4','13','PLATA','P');//TRATAM PPTO
							$Dato4=$DatoD76Ppto*(1-$DatoB6);//D79 PPTO													

							$DatoSalidaReal=$Dato1+$Dato3;						
							$DatoSalidaPpto=$Dato2+$Dato4;						
						}												
				 break;
				 case "3"://ORO
				 		if($Cod=='2')
						{
							$Dato=DatosPreciosDore($Ano,'4','31');
							$Dato=$Dato/100;
							$DatoReal1=DatosProyectadosTratam($Ano,$i,'4','11','ORO','R');
							$DatoPpto1=DatosProyectadosTratam($Ano,$i,'4','11','ORO','P');
							
							$DatoSalidaReal=$DatoReal1*(1-$Dato);
							$DatoSalidaPpto=$DatoPpto1*(1-$Dato);
						}
						if($Cod=='6')
						{
							$DatoSalidaReal=DatosPrecios_Barro('2','11',$Ano,$i,'R');					
							$DatoSalidaPpto=DatosPrecios_Barro('2','11',$Ano,$i,'P');					
						}
						if($Cod=='10')
						{
							$DatoB7=DatosPreciosDore($Ano,'4','31');
							$DatoB7=$DatoB7/100;
							$DatoD60Real=DatosProyectadosTratam($Ano,$i,'4','12','ORO','R');//TRATAM REAL
							$DatoSalidaReal=$DatoD60Real*(1-$DatoB7);
							$DatoD60Ppto=DatosProyectadosTratam($Ano,$i,'4','12','ORO','P');//TRATAM PPTO
							$DatoSalidaPpto=$DatoD60Ppto*(1-$DatoB7);						
						}						
						if($Cod=='13')
						{
							$DatoB7=DatosPreciosDore($Ano,'4','31');
							$DatoB7=$DatoB7/100;
							$DatoD77Real=DatosProyectadosTratam($Ano,$i,'4','13','ORO','R');//TRATAM REAL
							$DatoSalidaReal=$DatoD77Real*(1-$DatoB7);
							$DatoD77Ppto=DatosProyectadosTratam($Ano,$i,'4','13','ORO','P');//TRATAM PPTO
							$DatoSalidaPpto=$DatoD77Ppto*(1-$DatoB7);						
						}
						if($Cod=='16')
						{
							$DatoB7=DatosPreciosDore($Ano,'4','31');
							$DatoB7=$DatoB7/100;
							$DatoD60Real=DatosProyectadosTratam($Ano,$i,'4','12','ORO','R');//TRATAM REAL
							$DatoREAL1=$DatoD60Real*(1-$DatoB7);
							
							$DatoD60Ppto=DatosProyectadosTratam($Ano,$i,'4','12','ORO','P');//TRATAM PPTO
							$DatoPPTO1=$DatoD60Ppto*(1-$DatoB7);						
							
							$DatoB7=DatosPreciosDore($Ano,'4','31');
							$DatoB7=$DatoB7/100;
							$DatoD77Real=DatosProyectadosTratam($Ano,$i,'4','13','ORO','R');//TRATAM REAL
							$DatoREAL2=$DatoD77Real*(1-$DatoB7);
							
							$DatoD77Ppto=DatosProyectadosTratam($Ano,$i,'4','13','ORO','P');//TRATAM PPTO
							$DatoPPTO2=$DatoD77Ppto*(1-$DatoB7);	
							
							$DatoSalidaReal=$DatoREAL1+$DatoREAL2;										
							$DatoSalidaPpto=$DatoPPTO1+$DatoPPTO2;										
						}
				 break;
				} 
	break;
	case "3"://FINOS ASIGNACODS
	case "7"://FINOS ASIGNADOS SEGUNDA ETAPA
	case "17"://FINOS ASIGNADOS 
				switch($Tipo1)
				{
				 case "2"://PLATA
				        if($Cod=='3')
						{
							$DatoSalidaReal=DatosProyectadosSVP('3','15',$Ano,$i);
							$DatoSalidaPpto=DatosProyectadosPPC('3','15',$Ano,$i);
						}
						if($Cod=='7')
						{
							$DatoSalidaReal=DatosProyectadosSVP('3','16',$Ano,$i);
							$DatoSalidaPpto=DatosProyectadosPPC('3','16',$Ano,$i);
						}
						if($Cod=='17')
						{
							$DatoSalidaReal=DatosProyectadosSVP('3','17',$Ano,$i);
							$DatoSalidaPpto=DatosProyectadosPPC('3','17',$Ano,$i);
						}
				 break;
				 case "3"://ORO
				        if($Cod=='3')
						{
							$DatoSalidaReal=DatosProyectadosSVP('4','18',$Ano,$i);
							$DatoSalidaPpto=DatosProyectadosPPC('4','18',$Ano,$i);
						}
						if($Cod=='7')
						{
							$DatoSalidaReal=DatosProyectadosSVP('4','19',$Ano,$i);
							$DatoSalidaPpto=DatosProyectadosPPC('4','19',$Ano,$i);
						}	
						if($Cod=='17')
						{
							$DatoSalidaReal=DatosProyectadosSVP('4','20',$Ano,$i);
							$DatoSalidaPpto=DatosProyectadosPPC('4','20',$Ano,$i);
						}
				 break;
				} 
	break;					
	case "4"://INGRESOS
	case "8"://INGRESOS
	case "11"://INGRESOS
	case "14"://INGRESOS
	case "18"://INGRESOS
				switch($Tipo1)
				{
				 case "4"://TC AG	
				 		if($Cod=='4')
						{						 					 	
							$DatoSalidaReal=DatosProyectadosSVP('3','15',$Ano,$i);
							if($DatoSalidaReal=='0')
								$DatoSalidaReal=0;
							else
							{	
								$Dato1=DatosPreciosDore($Ano,'4','32');//VALOR A OCUPAR	 B$8							
								$Dato=DatosPreciosDore($Ano,'4','30');//PARA CALCULO PRINCIPAL																																
								$DatoReal1=DatosProyectadosTratam($Ano,$i,'4','11','PLATA','R');												
								$DatoSalidaR=$DatoReal1*(1-$Dato);												
								$DatoTMSR=DatosProyectadosTratam($Ano,$i,'4','11','SECO','R');						
								$DatoPLATAR=DatosProyectadosTratam($Ano,$i,'4','11','PLATA','R');
								$DatoOROR=DatosProyectadosTratam($Ano,$i,'4','11','ORO','R');						
								
								if($Dato1>0&&$DatoPLATAR>0)
									$DatoSalidaReal=($Dato1/($DatoSalidaR/$DatoTMSR))*($DatoPLATAR/($DatoPLATAR+$DatoOROR)*$DatoReal/1000);                         
								else
									$DatoSalidaReal=0;						
							}
							$ArrReal[$i][0]=$ArrReal[$i][0]+$DatoSalidaReal;
							
							$DatoSalidaPpto=DatosProyectadosPPC('3','15',$Ano,$i);
							if($DatoSalidaPpto=='0')
								$DatoSalidaPpto=0;
							else
							{						
								$Dato1=DatosPreciosDore($Ano,'4','32');//VALOR A OCUPAR	
								$Dato=DatosPreciosDore($Ano,'4','30');//PARA CALCULO PRINCIPAL																																
								$DatoPpto1=DatosProyectadosTratam($Ano,$i,'4','11','PLATA','P');
								$DatoSalidaP=$DatoPpto1*(1-$Dato);
								$DatoTMSP=DatosProyectadosTratam($Ano,$i,'4','11','SECO','P');   
								$DatoPLATAP=DatosProyectadosTratam($Ano,$i,'4','11','PLATA','P');
								$DatoOROP=DatosProyectadosTratam($Ano,$i,'4','11','ORO','P');							
								
								if($Dato1>0&&$DatoPLATAP>0)
									$DatoSalidaPpto=($Dato1/($DatoSalidaP/$DatoTMSP))*($DatoPLATAP/($DatoPLATAP+$DatoOROP)*$DatoPpto/1000);
								else
									$DatoSalidaPpto=0;	
							}
							$ArrPpto[$i][0]=$ArrPpto[$i][0]+$DatoSalidaPpto;
						}
						else
						{
							$DatoSalidaReal=DatosProyectadosSVP('3','16',$Ano,$i);
							if($DatoSalidaReal=='0')
								$DatoSalidaReal=0;
							else
							{
								$Dato1=DatosPreciosDore($Ano,'4','32');//VALOR A OCUPAR	 B$8
								$DatoSalidaR=DatosPrecios_Barro('2','10',$Ano,$i,'R');
								$DatoTMSR=DatosProyectadosTratam($Ano,$i,'4','26','NULL','R');//TRATAM REAL
								$Dato=DatosPreciosDore($Ano,'4','30');
								$Dato=$Dato/100;
								$DatoCALCULO=$DatoSalidaR/(1-$Dato);
								
								$DatoSalidaOROR=DatosPrecios_Barro('2','11',$Ano,$i,'R');
								$Dato=DatosPreciosDore($Ano,'4','31');
								$Dato=$Dato/100;
								$DatoCALCULOREAL=$DatoSalidaOROR/(1-$Dato);								
								$DatoPlataAsignadoReal=DatosProyectadosSVP('3','16',$Ano,$i);
								
								if($Dato1>0&&$DatoCALCULO>0)								
									$DatoSalidaReal=($Dato1/($DatoSalidaR/$DatoTMSR))*($DatoCALCULO/($DatoCALCULO+$DatoCALCULOREAL)*$DatoPlataAsignadoReal/1000);					
								else
								    $DatoSalidaReal=0;
							}	
							$ArrReal[$i][0]=$ArrReal[$i][0]+$DatoSalidaReal;
																				     	
							$DatoSalidaPpto=DatosProyectadosPPC('3','16',$Ano,$i);
							if($DatoSalidaPpto=='0')
								$DatoSalidaPpto=0;
							else
							{	
								$Dato1=DatosPreciosDore($Ano,'4','32');//VALOR A OCUPAR	 B$8
								$DatoSalidaP=DatosPrecios_Barro('2','10',$Ano,$i,'P');					
								$DatoTMSP=DatosProyectadosTratam($Ano,$i,'4','26','NULL','P');//TRATAM PPTO						
								$Dato=DatosPreciosDore($Ano,'4','30');
								$Dato=$Dato/100;
								$DatoCALCULO=$DatoSalidaP/(1-$Dato);

								$DatoSalidaOROP=DatosPrecios_Barro('2','11',$Ano,$i,'P');								
								$Dato=DatosPreciosDore($Ano,'4','31');
								$Dato=$Dato/100;
								$DatoCALCULOPPTO=$DatoSalidaOROP/(1-$Dato);
								$DatoPlataAsignadoPpto=DatosProyectadosPPC('3','16',$Ano,$i);

								if($Dato1>0&&$DatoCALCULO>0)								
									$DatoSalidaPpto=($Dato1/($DatoSalidaP/$DatoTMSP))*($DatoCALCULO/($DatoCALCULO+$DatoCALCULOPPTO)*$DatoPlataAsignadoPpto/1000);					
								else
								    $DatoSalidaPpto=0;
							 }	
							 $ArrReal[$i][0]=$ArrReal[$i][0]+$DatoSalidaPpto;	
						}	
				 break;
				 case "5"://TG AU
				 		if($Cod=='4')
						{
							$DatoSalidaReal=DatosProyectadosSVP('4','18',$Ano,$i);//FINOS ASIGNADOS ORO REAL
							if($DatoSalidaReal=='0')
								$DatoSalidaReal=0;
							else
							{
								$Dato1=DatosPreciosDore($Ano,'4','32');//VALOR A OCUPAR	 B$8									
								$Dato=DatosPreciosDore($Ano,'4','31');//FINOS CONTRACTUALES ORO D22
								$DatoReal1=DatosProyectadosTratam($Ano,$i,'4','11','ORO','R');//FINOS CONTRACTUALES ORO REAL D22							
								$DatoSalidaR=$DatoReal1*(1-$Dato); //CALCULO D22
								$DatoTMSR=DatosProyectadosTratam($Ano,$i,'4','11','SECO','R');//D17 REAL
								$DatoOROR=DatosProyectadosTratam($Ano,$i,'4','11','ORO','R');//D19 REAL
								$DatoPLATAR=DatosProyectadosTratam($Ano,$i,'4','11','PLATA','R');//D18 REAL							
								
								if($Dato1>0&&$DatoOROR>0)
									$DatoSalidaReal=($Dato1/($DatoSalidaR/$DatoTMSR))*($DatoOROR/($DatoPLATAR/$DatoOROR)*$DatoReal/1000);
								else
									$DatoSalidaReal=0;	
							}	
							$ArrReal[$i][0]=$ArrReal[$i][0]+$DatoSalidaReal;
							
							$DatoSalidaReal=DatosProyectadosPPC('4','18',$Ano,$i);//FINOS ASIGNADOS ORO PPTO
							if($DatoSalidaReal=='0')
								$DatoSalidaReal=0;
							else
							{
								$Dato1=DatosPreciosDore($Ano,'4','32');//VALOR A OCUPAR	 B$8									
								$Dato=DatosPreciosDore($Ano,'4','31');//FINOS CONTRACTUALES ORO D22
								$DatoPpto1=DatosProyectadosTratam($Ano,$i,'4','11','ORO','P');//FINOS CONTRACTUALES ORO PPTO D22
								$DatoSalidaP=$DatoPpto1*(1-$Dato); //CALCULO D22
								$DatoTMSP=DatosProyectadosTratam($Ano,$i,'4','11','SECO','P');//D17 PPTO
								$DatoOROP=DatosProyectadosTratam($Ano,$i,'4','11','ORO','P');//D19 REAL
								$DatoPLATAP=DatosProyectadosTratam($Ano,$i,'4','11','PLATA','P');//D18 REAL							
								
								if($Dato1>0&&$DatoOROP>0)
									$DatoSalidaPpto=($Dato1/($DatoSalidaP/$DatoTMSP))*($DatoOROP/($DatoPLATAP/$DatoOROP)*$DatoPpto/1000);
								else
									$DatoSalidaPpto=0;
							}	
							$ArrPpto[$i][0]=$ArrPpto[$i][0]+$DatoSalidaPpto;	
						}	
						else
						{
							$DatoSalidaReal=DatosProyectadosSVP('4','19',$Ano,$i);
							if($DatoSalidaReal=='0')
								$DatoSalidaReal=0;
							else
							{
								$Dato1=DatosPreciosDore($Ano,'4','32');//VALOR A OCUPAR	 B$8
								$DatoSalidaR=DatosPrecios_Barro('2','11',$Ano,$i,'R');//D41 FINOS CONTRACTUALES					
								$DatoTMSR=DatosProyectadosTratam($Ano,$i,'4','26','NULL','R');//TRATAM REAL D36
								$Dato=DatosPreciosDore($Ano,'4','31');//D38 ORO
								$Dato=$Dato/100;//D38 ORO
								$DatoCalculo1=$DatoSalidaR/(1-$Dato);//D38 ORO
								$Dato2=DatosPreciosDore($Ano,'4','30');//D37 PLATA
								$Dato2=$Dato2/100;//D37 PLATA
								$DatoCalculo2=$DatoSalidaR/(1-$Dato2);//D37 PLATA
								$DatoOroAsignado=DatosProyectadosSVP('4','19',$Ano,$i);//D43
							
								if($Dato1>0&&$DatoCalculo1>0)
									$DatoSalidaReal=($Dato1/($DatoSalidaR/$DatoTMSR))*($DatoCalculo1/($DatoCalculo2+$DatoCalculo1)*$DatoOroAsignado/1000);	
								else
								    $DatoSalidaReal=0;									
							}	
							$ArrReal[$i][0]=$ArrReal[$i][0]+$DatoSalidaReal;
							$DatoSalidaPpto=DatosProyectadosPPC('4','19',$Ano,$i);
							if($DatoSalidaPpto=='0')
								$DatoSalidaPpto=0;
							else
							{
								$Dato1=DatosPreciosDore($Ano,'4','32');//VALOR A OCUPAR	 B$8
								$DatoSalidaP=DatosPrecios_Barro('2','11',$Ano,$i,'P');//D41					
								$DatoTMSP=DatosProyectadosTratam($Ano,$i,'4','26','NULL','P');//TRATAM PPTO D36					
								$Dato=DatosPreciosDore($Ano,'4','31');//D38 ORO
								$Dato=$Dato/100;//D38 ORO
								$DatoCalculo1=$DatoSalidaP/(1-$Dato);//D38 ORO
								$Dato2=DatosPreciosDore($Ano,'4','30');//D37 PLATA
								$Dato2=$Dato2/100;//D37 PLATA
								$DatoCalculo2=$DatoSalidaP/(1-$Dato2);//D37 PLATA
								$DatoOroasignado=DatosProyectadosPPC('4','19',$Ano,$i);//D43
								
								if($Dato1>0&&$DatoCalculo1>0)
									$DatoSalidaPpto=($Dato1/($DatoSalidaP/$DatoTMSP))*($DatoCalculo1/($DatoCalculo2+$DatoCalculo1)*$DatoOroAsignado/1000);	
								else
									$DatoSalidaPpto=0;
							}
							$ArrPpto[$i][0]=$ArrPpto[$i][0]+$DatoSalidaPpto;		
						}	
				 break;
				 case "6"://RC PLATA	
				 		if($Cod=='4')
						{					
							$Dato1=DatosPreciosDore($Ano,'4','33');//VALOR A OCUPAR	 B$9						
							$DatoReal=DatosProyectadosSVP('3','15',$Ano,$i);//D24 REAL
							$DatoSalidaReal=$DatoReal*$Dato1/1000;
							$ArrReal[$i][0]=$ArrReal[$i][0]+$DatoSalidaReal;
							
							$DatoPpto=DatosProyectadosPPC('3','15',$Ano,$i);//D24 PPTO
							$DatoSalidaPpto=$DatoPpto*$Dato1/1000;	
							$ArrPpto[$i][0]=$ArrPpto[$i][0]+$DatoSalidaPpto;													
						}
						if($Cod=='8')
						{
							$Dato1=DatosPreciosDore($Ano,'4','33');	
							$DatoD43REAL=DatosProyectadosSVP('3','16',$Ano,$i);
							$DatoSalidaReal=$DatoD43REAL*($Dato1)/1000;
							$ArrReal[$i][0]=$ArrReal[$i][0]+$DatoSalidaReal;
							
							$DatoD43PPTO=DatosProyectadosPPC('3','16',$Ano,$i);
							$DatoSalidaPpto=$DatoD43PPTO*($Dato1)/1000;
							$ArrPpto[$i][0]=$ArrPpto[$i][0]+$DatoSalidaPpto;
						}
						if($Cod=='11')//METAL DORE FLORIDA ENTREGABLE
						{
							$Dato1=DatosPreciosDore($Ano,'4','35');	
							$DatoD96REAL=DatosProyectadosSVP('3','17',$Ano,$i);
							$DatoSalidaRealD96=DatoD96REAL*$Dato1/1000;
							
							$DatoD96PPTO=DatosProyectadosPPC('3','17',$Ano,$i);
							$DatoSalidaPptoD96=DatoD96PPTO*$Dato1/1000;
							
							$Dato1=DatosPreciosDore($Ano,'4','36');
							$DatoD97REAL=DatosProyectadosSVP('4','20',$Ano,$i);
							$DatoSalidaRealD79=$DatoD97REAL*$Dato1/1000;
													
							$DatoD97PPTO=DatosProyectadosPPC('4','20',$Ano,$i);
							$DatoSalidaPptoD79=$DatoD97PPTO*$Dato1/1000;
						
							$DatoB6=DatosPreciosDore($Ano,'4','30');
							$DatoB6=$DatoB6/100;
							$DatoD59Real=DatosProyectadosTratam($Ano,$i,'4','12','PLATA','R');//TRATAM REAL
							$DatoD59REAL=$DatoD59Real*(1-$DatoB6);//D62
							
							$DatoD59Ppto=DatosProyectadosTratam($Ano,$i,'4','12','PLATA','P');//TRATAM PPTO	
							$DatoD59PPTO=$DatoD59Ppto*(1-$DatoB6);//D62				

							$DatoB6=DatosPreciosDore($Ano,'4','30');
							$DatoB6=$DatoB6/100;
							$DatoD59Real=DatosProyectadosTratam($Ano,$i,'4','12','PLATA','R');//TRATAM REAL
							$Dato1=$DatoD59Real*(1-$DatoB6);//D62 REAL
							
							$DatoD59Ppto=DatosProyectadosTratam($Ano,$i,'4','12','PLATA','P');//TRATAM PPTO	
							$Dato2=$DatoD59Ppto*(1-$DatoB6);//D62 PPTO					
						 	
							$DatoB6=DatosPreciosDore($Ano,'4','30');
							$DatoB6=$DatoB6/100;							
							$DatoD76Real=DatosProyectadosTratam($Ano,$i,'4','13','PLATA','R');//TRATAM REAL
							$Dato3=$DatoD76Real*(1-$DatoB6);//D79 REAL
							
							$DatoD76Ppto=DatosProyectadosTratam($Ano,$i,'4','13','PLATA','P');//TRATAM PPTO
							$Dato4=$DatoD76Ppto*(1-$DatoB6);//D79 PPTO													

							$DatoCALCULOREAL=$Dato1+$Dato3;						
							$DatoCALCULOPPTO=$Dato2+$Dato4;						

							$SumaReal=$DatoSalidaRealD96+$DatoSalidaRealD79;
							if($SumaReal=='0')
								$DatoSalidaReal=0;
							else
							 	$DatoSalidaReal=$DatoSalidaRealD96*($DatoD59REAL/$DatoCALCULOREAL);
							$ArrReal[$i][0]=$ArrReal[$i][0]+$DatoSalidaReal;	
								
							$SumaPpto=$DatoSalidaPptoD96+$DatoSalidaPptoD79;
							if($SumaPpto=='0')
								$DatoSalidaPpto=0;
							else
								$DatoSalidaPpto=$DatoSalidaPptoD96*($DatoD59Ppto/$DatoCALCULOPPTO);	
							$ArrPpto[$i][0]=$ArrPpto[$i][0]+$DatoSalidaPpto;													
						}						
						if($Cod=='14')//BULLION DE ORO
						{
							$Dato1=DatosPreciosDore($Ano,'4','35');	
							$DatoD96REAL=DatosProyectadosSVP('3','17',$Ano,$i);
							$DatoSalidaRealD96=DatoD96REAL*$Dato1/1000;
							
							$DatoD96PPTO=DatosProyectadosPPC('3','17',$Ano,$i);
							$DatoSalidaPptoD96=DatoD96PPTO*$Dato1/1000;
							
							$Dato1=DatosPreciosDore($Ano,'4','36');
							$DatoD97REAL=DatosProyectadosSVP('4','20',$Ano,$i);
							$DatoSalidaRealD79=$DatoD97REAL*$Dato1/1000;
													
							$DatoD97PPTO=DatosProyectadosPPC('4','20',$Ano,$i);
							$DatoSalidaPptoD79=$DatoD97PPTO*$Dato1/1000;
							
							$DatoB6=DatosPreciosDore($Ano,'4','30');
							$DatoB6=$DatoB6/100;							
							$DatoD76Real=DatosProyectadosTratam($Ano,$i,'4','13','PLATA','R');//TRATAM REAL
							$DatoD76Real=$DatoD76Real*(1-$DatoB6);
							
							$DatoD76Ppto=DatosProyectadosTratam($Ano,$i,'4','13','PLATA','P');//TRATAM PPTO
							$DatoD76Ppto=$DatoD76Ppto*(1-$DatoB6);													
							
							$DatoCALCULOREAL=DatosProyectadosSVP('3','17',$Ano,$i);
							$DatoCALCULOPPTO=DatosProyectadosPPC('3','17',$Ano,$i);
							
							$SumaReal=$DatoSalidaRealD96+$DatoSalidaRealD79;
							if($SumaReal=='0')
								$DatoSalidaReal=0;
							else
							 	$DatoSalidaReal=$DatoSalidaRealD96*($DatoD76Real/$DatoCALCULOREAL);
							$ArrReal[$i][0]=$ArrReal[$i][0]+$DatoSalidaReal;
								
							$SumaPpto=$DatoSalidaPptoD96+$DatoSalidaPptoD79;
							if($SumaPpto=='0')
								$DatoSalidaPpto=0;
							else
								$DatoSalidaPpto=$DatoSalidaPptoD96*($DatoD76Ppto/$DatoCALCULOPPTO);
							$ArrPpto[$i][0]=$ArrPpto[$i][0]+$DatoSalidaPpto;														
						}						
						if($Cod=='18')//BULLION DE ORO
						{
							$Dato1=DatosPreciosDore($Ano,'4','35');	
							$DatoD96REAL=DatosProyectadosSVP('3','17',$Ano,$i);
							$DatoSalidaReal=DatoD96REAL*$Dato1/1000;
							$ArrReal[$i][0]=$ArrReal[$i][0]+$DatoSalidaReal;
							
							$DatoD96PPTO=DatosProyectadosPPC('3','17',$Ano,$i);
							$DatoSalidaPpto=DatoD96PPTO*$Dato1/1000;
							$ArrPpto[$i][0]=$ArrPpto[$i][0]+$DatoSalidaPpto;
						}						
				 break;
				 case "7"://RC ORO	
				 		if($Cod=='4')
						{					
							$Dato1=DatosPreciosDore($Ano,'4','34');//VALOR A OCUPAR	 B$10						
							$DatoReal=DatosProyectadosSVP('4','18',$Ano,$i);//D24 REAL
							$DatoSalidaReal=$DatoReal*$Dato1/1000;
							
							$ArrReal[$i][0]=$ArrReal[$i][0]+$DatoSalidaReal;
							
							$DatoPpto=DatosProyectadosPPC('4','18',$Ano,$i);//D24 PPTO
							$DatoSalidaPpto=$DatoPpto*$Dato1/1000;
							
							$ArrPpto[$i][0]=$ArrPpto[$i][0]+$DatoSalidaPpto;														
						}
						if($Cod=='8')
						{
							$Dato1=DatosPreciosDore($Ano,'4','34');
							$DatoD44REAL=DatosProyectadosSVP('4','19',$Ano,$i);
							$DatoSalidaReal=$DatoD44REAL*$Dato1/1000;
							$ArrReal[$i][0]=$ArrReal[$i][0]+$DatoSalidaReal;
							
							$DatoD44PPTO=DatosProyectadosPPC('4','19',$Ano,$i);
							$DatoSalidappto=$DatoD44PPTO*$Dato1/1000;
							$ArrPpto[$i][0]=$ArrPpto[$i][0]+$DatoSalidaPpto;
						} 	
						if($Cod=='11')//METAL DORE FLORIDA ENTREGABLE
						{
							$Dato1=DatosPreciosDore($Ano,'4','35');	
							$DatoD96REAL=DatosProyectadosSVP('3','17',$Ano,$i);
							$DatoSalidaRealD96=DatoD96REAL*$Dato1/1000;
							
							$DatoD96PPTO=DatosProyectadosPPC('3','17',$Ano,$i);
							$DatoSalidaPptoD96=DatoD96PPTO*$Dato1/1000;
							
							$Dato1=DatosPreciosDore($Ano,'4','36');
							$DatoD97REAL=DatosProyectadosSVP('4','20',$Ano,$i);
							$DatoSalidaRealD79=$DatoD97REAL*$Dato1/1000;
													
							$DatoD97PPTO=DatosProyectadosPPC('4','20',$Ano,$i);
							$DatoSalidaPptoD79=$DatoD97PPTO*$Dato1/1000;

							$DatoB7=DatosPreciosDore($Ano,'4','31');
							$DatoB7=$DatoB7/100;
							$DatoD60Real=DatosProyectadosTratam($Ano,$i,'4','12','ORO','R');//TRATAM REAL
							$DatoD60Real=$DatoD60Real*(1-$DatoB7);
							$DatoD60Ppto=DatosProyectadosTratam($Ano,$i,'4','12','ORO','P');//TRATAM PPTO
							$DatoD60Ppto=$DatoD60Ppto*(1-$DatoB7);						
														
							$DatoB7=DatosPreciosDore($Ano,'4','31');
							$DatoB7=$DatoB7/100;
							$DatoD60Real=DatosProyectadosTratam($Ano,$i,'4','12','ORO','R');//TRATAM REAL
							$DatoREAL1=$DatoD60Real*(1-$DatoB7);
							
							$DatoD60Ppto=DatosProyectadosTratam($Ano,$i,'4','12','ORO','P');//TRATAM PPTO
							$DatoPPTO1=$DatoD60Ppto*(1-$DatoB7);						
							
							$DatoB7=DatosPreciosDore($Ano,'4','31');
							$DatoB7=$DatoB7/100;
							$DatoD77Real=DatosProyectadosTratam($Ano,$i,'4','13','ORO','R');//TRATAM REAL
							$DatoREAL2=$DatoD77Real*(1-$DatoB7);
							
							$DatoD77Ppto=DatosProyectadosTratam($Ano,$i,'4','13','ORO','P');//TRATAM PPTO
							$DatoPPTO2=$DatoD77Ppto*(1-$DatoB7);	
							
							$DatoCALCULOREAL=$DatoREAL1+$DatoREAL2;										
							$DatoCALCULOPPTO=$DatoPPTO1+$DatoPPTO2;										
							
							$SumaReal=$DatoSalidaRealD96+$DatoSalidaRealD79;
							if($SumaReal=='0')
								$DatoSalidaReal=0;
							else
							 	$DatoSalidaReal=$DatoSalidaRealD79*($DatoD77Real/$DatoCALCULOREAL);
							$ArrReal[$i][0]=$ArrReal[$i][0]+$DatoSalidaReal;
								
							$SumaPpto=$DatoSalidaPptoD96+$DatoSalidaPptoD79;
							if($SumaPpto=='0')
								$DatoSalidaPpto=0;
							else
								$DatoSalidaPpto=$DatoSalidaPptoD79*($DatoD77Ppto/$DatoCALCULOPPTO);	
							$ArrPpto[$i][0]=$ArrPpto[$i][0]+$DatoSalidaPpto;													
						}						
						if($Cod=='14')//BULLION DE ORO
						{
							$Dato1=DatosPreciosDore($Ano,'4','35');	
							$DatoD96REAL=DatosProyectadosSVP('3','17',$Ano,$i);
							$DatoSalidaRealD96=DatoD96REAL*$Dato1/1000;
							
							$DatoD96PPTO=DatosProyectadosPPC('3','17',$Ano,$i);
							$DatoSalidaPptoD96=DatoD96PPTO*$Dato1/1000;
							
							$Dato1=DatosPreciosDore($Ano,'4','36');
							$DatoD97REAL=DatosProyectadosSVP('4','20',$Ano,$i);
							$DatoSalidaRealD79=$DatoD97REAL*$Dato1/1000;
													
							$DatoD97PPTO=DatosProyectadosPPC('4','20',$Ano,$i);
							$DatoSalidaPptoD79=$DatoD97PPTO*$Dato1/1000;
						
							$DatoB7=DatosPreciosDore($Ano,'4','31');
							$DatoB7=$DatoB7/100;
							$DatoD77Real=DatosProyectadosTratam($Ano,$i,'4','13','ORO','R');//TRATAM REAL
							$DatoD77Real=$DatoD77Real*(1-$DatoB7);
							
							$DatoD77Ppto=DatosProyectadosTratam($Ano,$i,'4','13','ORO','P');//TRATAM PPTO
							$DatoD77Ppto=$DatoD77Ppto*(1-$DatoB7);						
							
							$DatoB7=DatosPreciosDore($Ano,'4','31');
							$DatoB7=$DatoB7/100;
							$DatoD60Real=DatosProyectadosTratam($Ano,$i,'4','12','ORO','R');//TRATAM REAL
							$DatoREAL1=$DatoD60Real*(1-$DatoB7);
							
							$DatoD60Ppto=DatosProyectadosTratam($Ano,$i,'4','12','ORO','P');//TRATAM PPTO
							$DatoPPTO1=$DatoD60Ppto*(1-$DatoB7);						
							
							$DatoB7=DatosPreciosDore($Ano,'4','31');
							$DatoB7=$DatoB7/100;
							$DatoD77Real=DatosProyectadosTratam($Ano,$i,'4','13','ORO','R');//TRATAM REAL
							$DatoREAL2=$DatoD77Real*(1-$DatoB7);
							
							$DatoD77Ppto=DatosProyectadosTratam($Ano,$i,'4','13','ORO','P');//TRATAM PPTO
							$DatoPPTO2=$DatoD77Ppto*(1-$DatoB7);	
							
							$DatoCALCULOREAL=$DatoREAL1+$DatoREAL2;										
							$DatoCALCULOPPTO=$DatoPPTO1+$DatoPPTO2;										
						
							$SumaReal=$DatoSalidaRealD96+$DatoSalidaRealD79;
							if($SumaReal=='0')
								$DatoSalidaReal=0;
							else
							 	$DatoSalidaReal=$DatoSalidaRealD79*($DatoD77Real/$DatoCALCULOREAL);
							$ArrReal[$i][0]=$ArrReal[$i][0]+$DatoSalidaReal;	
								
							$SumaPpto=$DatoSalidaPptoD96+$DatoSalidaPptoD79;
							if($SumaPpto=='0')
								$DatoSalidaPpto=0;
							else
								$DatoSalidaPpto=$DatoSalidaPptoD79*($DatoD77Ppto/$DatoCALCULOPPTO);	
							$ArrPpto[$i][0]=$ArrPpto[$i][0]+$DatoSalidaPpto;													
						}	
						if($Cod=='18')//METAL DORE + BULLION
						{
							$Dato1=DatosPreciosDore($Ano,'4','36');
							$DatoD97REAL=DatosProyectadosSVP('4','20',$Ano,$i);
							$DatoSalidaReal=$DatoD97REAL*$Dato1/1000;
							$ArrReal[$i][0]=$ArrReal[$i][0]+$DatoSalidaReal;
							
							$DatoD97PPTO=DatosProyectadosPPC('4','20',$Ano,$i);
							$DatoSalidaPpto=$DatoD97PPTO*$Dato1/1000;
							$ArrPpto[$i][0]=$ArrPpto[$i][0]+$DatoSalidaPpto;
						}
				 break;
				 case "8"://RC PLATA GENERACION					
						$DatoB4=DatosPreciosDore($Ano,'4','28');
						$DatoB6=DatosPreciosDore($Ano,'4','30');
						$DatoB6=$DatoB6/100;							

						$DatoD43REAL=DatosProyectadosSVP('3','16',$Ano,$i);
						$DatoSalidaReal=$DatoD43REAL*($DatoB4/(1-$DatoB6))/1000;
						$ArrReal[$i][0]=$ArrReal[$i][0]+$DatoSalidaReal;
						
						$DatoD43PPTO=DatosProyectadosPPC('3','16',$Ano,$i);
						$DatoSalidaPpto=$DatoD43PPTO*($DatoB4/(1-$DatoB6))/1000;
						$ArrPpto[$i][0]=$ArrPpto[$i][0]+$DatoSalidaPpto;
				 break;
				 case "9"://RC ORO	 GENERACION					
						$DatoB5=DatosPreciosDore($Ano,'4','29');
						$DatoB7=DatosPreciosDore($Ano,'4','31');
						$DatoB7=$DatoB7/100;							
								
						$DatoD44REAL=DatosProyectadosSVP('4','19',$Ano,$i);
						$DatoSalidaReal=$DatoD44REAL*($DatoB5/(1-$DatoB7))/1000;
						$ArrReal[$i][0]=$ArrReal[$i][0]+$DatoSalidaReal;
						
						$DatoD44PPTO=DatosProyectadosPPC('4','19',$Ano,$i);						
						$DatoSalidaPpto=$DatoD44PPTO*($DatoB5/(1-$DatoB7))/1000;
						$ArrPpto[$i][0]=$ArrPpto[$i][0]+$DatoSalidaPpto;
				 break;
				 
				 
				 case "11"://TOTAL						
						$DatoSalidaReal=$ArrReal[$i][0];
						$ArrReal[$i][1]=$DatoSalidaReal;
						
						$DatoSalidaPpto=$ArrPpto[$i][0];
						$ArrPpto[$i][1]=$DatoSalidaPpto;
				 break;
				 case "12"://TOTAL 2						
						$DatoReal=$ArrReal[$i][1];
						$DatoTMSR=DatosProyectadosTratam($Ano,$i,'4','11','SECO','R');//D17 REAL
						if($DatoReal>0)
							$DatoSalidaReal=$DatoReal/$DatoTMSR*1000;
						else
						    $DatoSalidaReal=0;
							
						$DatoPpto=$ArrPpto[$i][1];
						$DatoTMSP=DatosProyectadosTratam($Ano,$i,'4','11','SECO','P');//D17 PPTO
						if($DatoPpto>0)
							$DatoSalidaPpto=$DatoPpto/$DatoTMSP*1000;
						else
						    $DatoSalidaPpto=0;	
				 break;
				 
				} 
	break;		
  }	
	 if($Tipo=='R')
		return($DatoSalidaReal);
	 else	
		return($DatoSalidaPpto);	

}
?>
