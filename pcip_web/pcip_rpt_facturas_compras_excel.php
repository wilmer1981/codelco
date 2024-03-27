<?
	//header("Content-Type:  application/vnd.ms-excel");
 	//header("Expires: 0");
  	//header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	

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
<title>Consulta Facturas</title>
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
<body>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
</style></head>
<body>
<form name="frmPrincipal" action="" method="post">
  <table width="100%" border="1" cellspacing="0" cellpadding="0">
    <tr>
      <td width="7%" rowspan="3"  align="center">Fecha</td>
      <td width="6%" rowspan="3" align="center">N&ordm; Fact.</td>
      <td width="5%" rowspan="3" align="center"> NC / ND </td>
      <td width="7%" rowspan="3"  align="center">Cuota Mes </td>
      <td width="5%"  align="center">Valor Neto</td>
      <td width="5%"  align="center">Iva</td>
      <td width="5%"  align="center">Total</td>
      <?
			  if($OptInfChecked!='')
			  {
				$ContCol=1;
				$Datos=explode('~',$OptInfChecked);
				while(list($c,$v)=each($Datos))
				{			
				 //echo $v."<br>"; 	 
					$ContCol++;
				}
				echo "<td colspan='".($ContCol*10)."' width='5%' align='center'>Informaci&oacute;n</td>";			  
			  }
			  ?>
    </tr>
    <tr>
      <td width="5%" rowspan="2" align="center">Fact. US$</td>
      <td width="5%" rowspan="2" align="center">Fact. US$</td>
      <td width="5%" rowspan="2" align="center">Fact. US$</td>
      <?
				$Datos=explode('~',$OptInfChecked);
				while(list($c,$v)=each($Datos))
				{
				   $Consulta = "select nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31000' and cod_subclase='".$v."'";			
				   $Resp=mysqli_query($link, $Consulta);
				   while ($Fila=mysql_fetch_array($Resp))
				   {
						if($v=='5'||$v=='6'||$v=='7'||$v=='8'||$v=='9'||$v=='10'||$v=='11'||$v=='12'||$v=='13')
							echo "<td width='5%' align='center' colspan='2'>".ucfirst($Fila["nombre_subclase"])."</td>";
						else	
							echo "<td width='5%' align='center' colspan='10'>".ucfirst($Fila["nombre_subclase"])."</td>";
				   }	
				}
			  ?>
    </tr>
    <tr>
      <?			
			if($OptInfChecked!='')
			{
				$Datos=explode('~',$OptInfChecked);
				while(list($c,$v)=each($Datos))
				{
					// echo $v."<br>";
					 if($v=='5'||$v=='6'||$v=='7'||$v=='8'||$v=='9'||$v=='10'||$v=='11'||$v=='12'||$v=='13')
					 {
					   $Consulta = "select nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31000' and cod_subclase='".$v."'";			
					   $Resp=mysqli_query($link, $Consulta);
					   while ($Fila=mysql_fetch_array($Resp))
					   {
						  echo"<td width='5%' align='center'>".ucfirst($Fila["nombre_subclase"])."</td>";	
						  echo"<td width='5%' align='center'>Un.</td>";
					   }	  
					 }
					 else
					 {
						  echo"<td width='5%' align='center'>Cobre</td>";	
						  echo"<td width='5%' align='center'>Un.</td>";	
						  echo"<td width='5%' align='center'>Plata</td>";
						  echo"<td width='5%' align='center'>Un.</td>";
						  echo"<td width='5%' align='center'>Oro</td>";
						  echo"<td width='5%' align='center'>Un.</td>";	
						  echo"<td width='5%' align='center'>Otros</td>";
						  echo"<td width='5%' align='center'>Un.</td>";	
						  echo"<td width='5%' align='center'>Otros 2</td>";
						  echo"<td width='5%' align='center'>Un.</td>";	
					}
				}
			}
			?>
    </tr>
    <?
	   $Buscar='S';
		  	if($Buscar=='S')
			{   			     
			    $TotalNetoCobre=0;$TotalNetoPlata=0;$TotalNetoOro=0;
				$Consulta="select t1.estado_actual,t2.tipo_factura as tipo_fac,t3.tipo_factura,t1.codigo,t1.cod_producto,t1.fecha_emision,t1.num_factura,t1.cuota,t2.cod_contenido,t2.valor,t2.cod_unidad,t1.tipo as TipoCtto,";
				$Consulta.=" t3.valor_neto,t3.iva,t3.valor_total,t3.correlativo,t3.numero,t3.tipo_nota,t4.acuerdo_contractual_au,t4.acuerdo_contractual_cu ";
				$Consulta.=" from pcip_fac_compra t1 inner join pcip_fac_compra_finos t2";
				$Consulta.=" on t1.codigo=t2.codigo left join pcip_fac_compra_finos_relacion t3 on t1.codigo=t3.codigo";
				$Consulta.=" inner join pcip_fac_contratos_compra t4 on t1.cod_contrato=t4.cod_contrato";				
				$Consulta.=" where t1.cod_contrato<>'' ";
				if($CmbContrato!='T')			
					$Consulta.=" and t1.cod_contrato='".$CmbContrato."'";
				if($CmbTipo!='T')
				    $Consulta.=" and t3.tipo_factura='".$CmbTipo."'";
				if($CmbProd!='T')
				   	$Consulta.=" and t1.cod_producto='".$CmbProd."'";
				if($CmbNumFact!='T')
					$Consulta.=" and t1.num_factura='".$CmbNumFact."'";
				if($CmbTipoContrato!='T')	
					$Consulta.=" and t1.tipo='".$CmbTipoContrato."' ";	
				if($CmbTipo=='2')
				{
					if($CmbDeCre!='T')	
						$Consulta.=" and t3.tipo_nota='".$CmbDeCre."' ";	
				}														
				$FechaInicio=$Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-01";
				$FechaTermino=$AnoFin."-".str_pad($MesFin,2,"0",STR_PAD_LEFT)."-31";
				if(isset($CmbFactura)&&($CmbFactura=='2'||$CmbFactura=='3'))
					$Consulta.=" and t1.estado_actual = 1";
				else
					$Consulta.=" and t1.fecha_emision BETWEEN '".$FechaInicio."' AND '".$FechaTermino."'";
				$Consulta.=" group by t1.codigo,t3.correlativo";
				$Consulta.=" order by t1.fecha_emision,t1.num_factura";
				$Resp=mysqli_query($link, $Consulta);				
				//echo $Consulta."<br><br>";
				while($Fila=mysql_fetch_array($Resp))
				{
				    $Cod=$Fila["codigo"];
				    $Mostrar='S';
					$Cuota=$Fila["cuota"];
					if($Fila["tipo_factura"]=='1')//SI ES PROVISORIA
					{
						switch($CmbFactura)
						{
							case "1"://FINALIZADAS
								if($Fila["estado_actual"]=='2')
									$Mostrar='N';	
								break;
							case "2"://VENCIDAS
								if($Fila["estado_actual"]=='1')
								{
									if($Fila[TipoCtto]=='2')//MAQUILA
										$Acuerdo=intval($Fila["acuerdo_contractual_au"]);
									else
										$Acuerdo=intval($Fila["acuerdo_contractual_cu"]);
									$FechaFactura=explode('-',$Fila[fecha_emision]);
									$FechaAVencer=date( "Y-m-d", mktime(0,0,0,intval($FechaFactura[1])+$Acuerdo,$FechaFactura[2],$FechaFactura[0]));
									//echo $Acuerdo."<br>";
									//echo $FechaAVencer."<br>";
									//echo $FechaInicio."<br>";
									//echo "DIF:".resta_fechas($FechaAVencer,$FechaTermino)."<BR><br>";
									if(resta_fechas($FechaAVencer,$FechaTermino)>=0)
										$Mostrar='N';	
								}
								else
									$Mostrar='N';	
								break;
							case "3"://SIN VENCER
								if($Fila["estado_actual"]=='1')
								{
									$FechaFactura=explode('-',$Fila[fecha_emision]);
									$FechaFactura=$FechaFactura[0]."-".$FechaFactura[1]."-01";
									if(resta_fechas($FechaInicio,$FechaFactura)>=0)
									{
										if($Fila[TipoCtto]=='2')//MAQUILA
											$Acuerdo=intval($Fila["acuerdo_contractual_au"]);
										else
											$Acuerdo=intval($Fila["acuerdo_contractual_cu"]);
										$FechaFactura=explode('-',$Fila[fecha_emision]);
										$FechaAVencer=date( "Y-m-d", mktime(0,0,0,intval($FechaFactura[1])+$Acuerdo,$FechaFactura[2],$FechaFactura[0]));
										//echo $FechaAVencer."<br>";
										//echo $FechaInicio."<br>";
										//echo "DIF:".resta_fechas($FechaAVencer,$FechaTermino)."<BR>";
										if(resta_fechas($FechaAVencer,$FechaTermino)<0)
											$Mostrar='N';	
									}
									else
										$Mostrar='N';
								}
								else
									$Mostrar='N';	
								break;
						}
					}

					if($Mostrar=='S')
					{  
					?>
    <tr>
      <td align="center"><? echo $Fila[fecha_emision];?>&nbsp; </td>
      <td align="right"><? echo $Fila[num_factura];?>&nbsp; </td>
      <?
					   if($Fila["tipo_factura"]=='1')
					   {					   
					  ?>
      <td align="center"><? echo "-";?>&nbsp;</td>
      <?
					   }
					   else
					   {
						$DatoNC='';$DatoND='';$NC_ND='';
						$DatoNC=RetornaNC_ND($Cod,'2');
						$DatoND=RetornaNC_ND($Cod,'1');	
						if($DatoNC<>'')
						   $NC_ND="NC:".$DatoNC." ";
						if($DatoND<>'')
						   $NC_ND=$NC_ND."ND:".$DatoND;
					  ?>
      <td align="left"><? echo $NC_ND;?>&nbsp;</td>
      <?
					   }
					  ?>
      <td align="center"><? echo substr($Cuota,0,4)." ". $Meses[intval(substr($Cuota,4)-1)];?>&nbsp; </td>
      <? 
					   $Var=ValoresIn($Fila[codigo],$Fila[correlativo],'1','1','1');
					   $Var1=ValoresIn($Fila[codigo],$Fila[correlativo],'2','1','1');
					   $Var2=ValoresIn($Fila[codigo],$Fila[correlativo],'1','2','1');
					   $Var3=ValoresIn($Fila[codigo],$Fila[correlativo],'2','2','1');
					   $Var4=ValoresIn($Fila[codigo],$Fila[correlativo],'1','3','1');
					   $Var5=ValoresIn($Fila[codigo],$Fila[correlativo],'2','3','1');
					  						
						$Var_Precio=ValorPrecioCompra($Ano,$Mes,'1');
						$Var_Precio1=ValorPrecioCompra($Ano,$Mes,'2');
						$Var_Precio2=ValorPrecioCompra($Ano,$Mes,'3');
						$TotalNetoCobre=$Var_Precio*$Var1; 
						$TotalNetoPlata=$Var_Precio1*$Var3; 
						$TotalNetoOro=$Var_Precio2*$Var5;               
					 ?>
      <td align="right"><? echo number_format($Fila[valor_neto],2,',','.');?>&nbsp; </td>
      <td align="right"><? echo number_format($Fila[iva],2,',','.');?>&nbsp; </td>
      <td align="right"><? echo number_format($Fila[valor_total],2,',','.');?>&nbsp; </td>
      <?
					    if($CmbTipo=='2')
					    {
							 if($OptInfChecked!='')
							 {
								$Datos=explode('~',$OptInfChecked);
								while(list($c,$v)=each($Datos))
								{
								  //echo $v."<br>";
								   if($v=='5'||$v=='6'||$v=='7'||$v=='8'||$v=='9'||$v=='10'||$v=='11'||$v=='12'||$v=='13')
								   {
									echo"<td align='right'>".number_format(Contenido($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,'2',''),2,',','.')."</td>";					
									echo"<td>".Unidad($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,'2','')."</td>";																
								   }
								   else
								   {
									echo"<td align='right'>".number_format(Contenido($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,'2','1'),2,',','.')."</td>";
									echo"<td>".Unidad($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,'2','1')."</td>";					
									echo"<td align='right'>".number_format(Contenido($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,'2','2'),2,',','.')."</td>";								
									echo"<td>".Unidad($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,'2','2')."</td>";					
									echo"<td align='right'>".number_format(Contenido($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,'2','3'),2,',','.')."</td>";								
									echo"<td>".Unidad($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,'2','3')."</td>";					
									echo"<td align='right'>".number_format(Contenido($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,'2','4'),2,',','.')."</td>";								
									echo"<td>".Unidad($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,'2','4')."</td>";					
									echo"<td align='right'>".number_format(Contenido($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,'2','5'),2,',','.')."</td>";
									echo"<td>".Unidad($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,'2','5')."</td>";																
								   }	
								}	
							 }	
						}
						else
						{
							if($OptInfChecked!='')
							{
								$Datos=explode('~',$OptInfChecked);
								while(list($c,$v)=each($Datos))
								{
								//echo $v."<br>";
								   if($v=='5'||$v=='6'||$v=='7'||$v=='8'||$v=='9'||$v=='10'||$v=='11'||$v=='12'||$v=='13')
								   {
									echo"<td align='right'>".number_format(Contenido($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,$Fila[tipo_factura],''),2,',','.')."</td>";					
									echo"<td>".Unidad($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,$Fila[tipo_fac],'')."</td>";																
								   }
								   else
								   {
									echo"<td align='right'>".number_format(Contenido($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,$Fila[tipo_factura],'1'),2,',','.')."</td>";					
									echo"<td>".Unidad($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,$Fila[tipo_fac],'1')."</td>";																
									echo"<td align='right'>".number_format(Contenido($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,$Fila[tipo_factura],'2'),2,',','.')."</td>";								
									echo"<td>".Unidad($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,$Fila[tipo_fac],'2')."</td>";																
									echo"<td align='right'>".number_format(Contenido($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,$Fila[tipo_factura],'3'),2,',','.')."</td>";								
									echo"<td>".Unidad($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,$Fila[tipo_fac],'3')."</td>";																
									echo"<td align='right'>".number_format(Contenido($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,$Fila[tipo_factura],'4'),2,',','.')."</td>";								
									echo"<td>".Unidad($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,$Fila[tipo_fac],'4')."</td>";																
									echo"<td align='right'>".number_format(Contenido($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,$Fila[tipo_factura],'5'),2,',','.')."</td>";											
									echo"<td>".Unidad($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,$Fila[tipo_fac],'5')."</td>";																
								   }
								}	
							}
						}		
					  ?>
    </tr>
    <?
					}	
					$TotalNeto=$TotalNeto+$Fila[valor_neto];
					$TotalIva=$TotalIva+$Fila[iva];
					$TotalTotal=$TotalTotal+$Fila[valor_total];
				 }
				 
				?>
    <tr>
      <td align="right" colspan="4">TOTAL</td>
      <td align="right"><? echo number_format($TotalNeto,2,',','.');?></td>
      <td align="right"><? echo number_format($TotalIva,2,',','.');?></td>
      <td align="right"><? echo number_format($TotalTotal,2,',','.');?></td>
    </tr>
    <?				 
				 
			 }		  	
			?>
  </table>
</form>
</body>
</html>
<?
function Contenido($OptInfChecked,$Codigo,$Correlativo,$Numero,$Contenido,$TipoFac,$Fino)
{
	$ConsultaValor =" select valor,nombre_subclase as nom_unidad from pcip_fac_compra_finos t1 left join";
	$ConsultaValor.=" proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31013' and t1.cod_unidad=t2.cod_subclase where codigo='".$Codigo."' and correlativo='".$Correlativo."' and numero='".$Numero."'";
	$ConsultaValor.=" and tipo_factura='".$TipoFac."' and cod_contenido='".$Contenido."'";
	if($Fino!='')
		$ConsultaValor.=" and cod_fino='".$Fino."'";
	$RespValor=mysql_query($ConsultaValor);				
	//echo $ConsultaValor."<br><br>";
	if($FilaValor=mysql_fetch_array($RespValor))
	{
	  $Valor=$FilaValor[valor];
	  return($Valor);
	}
	else
	{
	  $Valor=0;
	  return($Valor);
	}
}
function Unidad($OptInfChecked,$Codigo,$Correlativo,$Numero,$Contenido,$TipoFac,$Fino)
{
	$ConsultaValor =" select valor,nombre_subclase as nom_unidad from pcip_fac_compra_finos t1 left join";
	$ConsultaValor.=" proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31013' and t1.cod_unidad=t2.cod_subclase where codigo='".$Codigo."' and correlativo='".$Correlativo."' and numero='".$Numero."'";
	$ConsultaValor.=" and tipo_factura='".$TipoFac."' and cod_contenido='".$Contenido."'";
	if($Fino!='')
		$ConsultaValor.=" and cod_fino='".$Fino."'";
	$RespValor=mysql_query($ConsultaValor);				
	//echo $ConsultaValor."<br><br>";
	if($FilaValor=mysql_fetch_array($RespValor))
	{
	  $Unidad=$FilaValor[nom_unidad];
	  return($Unidad);
	}
	else
	{
	  $Unidad='&nbsp;';
	  return($Unidad);
	}
}
function ValoresIn($Codigo,$Correlativo,$Contenido,$Fino,$Unidad)
{
	$Valor=0;
	$Consulta="select sum(t1.valor) as total ";
	$Consulta.="from pcip_fac_compra_finos t1 where t1.codigo='".$Codigo."'";
	$Consulta.=" and t1.correlativo='".$Correlativo."'";
	$Consulta.=" and t1.cod_contenido='".$Contenido."'";	
	$Consulta.=" and t1.cod_fino='".$Fino."'";
	$Consulta.=" and t1.cod_unidad='".$Unidad."'";
	//echo $Consulta."<br>";
	$Respaux=mysqli_query($link, $Consulta);
	if($Filaaux=mysql_fetch_array($Respaux))
	{
		$Valor=$Filaaux["total"];		
	}
	return($Valor);
}

function ValorPrecioCompra($Ano1,$Mes1,$Fino)
{
	$ValorPre=0;
	$Consulta1="select t1.valor";
	$Consulta1.=" from pcip_fac_compra_precios t1 where t1.ano='".$Ano1."'";
	$Consulta1.=" and t1.mes='".$Mes1."'";	
	$Consulta1.=" and t1.cod_fino='".$Fino."'";
	//echo $Consulta1."<br>";
	$Respaux1=mysql_query($Consulta1);
	if($Filaaux1=mysql_fetch_array($Respaux1))
	{
		$ValorPre=$Filaaux1[valor];		
	}
	return($ValorPre);
}

function RetornaNC_ND($Codigo,$Tipo)
{
  $Numero='';
  $ConsultaNC_ND="select numero from pcip_fac_compra_finos_relacion where codigo='".$Codigo."' and tipo_nota='".$Tipo."'";
  //echo $ConsultaNC_ND."<br>";
  $RespNC_ND=mysql_query($ConsultaNC_ND);  
  while($FilaNC_ND=mysql_fetch_array($RespNC_ND))
  {
    $Numero=$Numero.$FilaNC_ND[numero].", ";
  }
  if($Numero!='')
  	$Numero=substr($Numero,0,strlen($Numero)-2);
  return($Numero);	
}
?>