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
if(!isset($CmbProducto))
	$CmbProducto='T';		
?>
<html>
<head>
<title>Consulta Provisi�n</title>
<style type="text/css">
<!--
body {
	background-image: url();
	background-color: #f9f9f9;
}
-->
</style>
<link href="estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
</style></head>
<body>
<form name="frmPrincipal" action="" method="post">
  <table width="100%"  border="0" align="center" cellpadding="0"  cellspacing="0">
    <tr>
      <td><table width="100%"  border="1" cellpadding="2" cellspacing="0" >
          <? 
		  $Buscar='S';
		if($Buscar=='S')
		{
			$TOTALES=0;
			if($Mes<10)
				$Mes="0".$Mes;
			if($MesFin<10)
				$MesFin="0".$MesFin;
			$FechaDesde=$Ano."-".$Mes."-01";
			$FechaHasta=$AnoFin."-".$MesFin."-31";
			$ContMeses=intval(resta_fechas($FechaHasta,$FechaDesde)/30);
			
			$Consulta="select t3.cod_subclase,t3.nombre_subclase from  pcip_fac_compra t1 ";
			$Consulta.=" inner join pcip_fac_compra_finos t2 on t1.codigo=t2.codigo ";
			$Consulta.=" inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31012' and t2.cod_fino=t3.cod_subclase and t3.cod_subclase in('1','2','3')";
			$Consulta.=" where t1.rut_proveedor<>''";
			if($CmbMostrar!='T')
				$Consulta.=" and t3.cod_subclase='".$CmbMostrar."'";
			if($CmbProveedor!='-1')
				$Consulta.=" and t1.rut_proveedor='".$CmbProveedor."'";
			if($CmbProducto!='T')
			{
				$Str="(";
				$Codigos=explode(',',$CodSeleccion);
				while(list($c,$v)=each($Codigos))
				{
				 	$Str=$Str."'".$v."',";
					
				}
				$Str=substr($Str,0,strlen($Str)-1);
				$Str=$Str.")";
				$Consulta.=" and t1.cod_producto in ".$Str;	
			}
			if($CmbContrato!='T')
				$Consulta.=" and t1.tipo='".$CmbContrato."'";
			$Consulta.=" and t1.estado_actual='1'";
			$Consulta.=" and t1.fecha_emision BETWEEN '".$FechaDesde."' and '".$FechaHasta."'";
			$Consulta.=" group by t3.cod_subclase";			
			$Resp=mysqli_query($link, $Consulta);$ArrayTot=array();				
			//echo $Consulta."<br>";
			while($Fila=mysql_fetch_array($Resp))
			{
				$ArrayTot=array();
				$Fino=$Fila["cod_subclase"];
				$NomFino=$Fila["nombre_subclase"];
				MuestraFino($Ano,$Mes,$ContMeses,$Fino,$CmbProveedor,$CmbContrato,$CmbProducto,$NomFino,$Meses,$MesFin,$CodSeleccion); 
				MuestraMeses($Ano,$Mes,$ContMeses,$Fino,$CmbProveedor,$CmbContrato,$CmbProducto,$Meses,$CodSeleccion);
				MuestraFactura($Ano,$Mes,$ContMeses,$Fino,$CmbProveedor,$CmbContrato,$CmbProducto,$CodSeleccion);
				MuestraPrecio($Ano,$Mes,$ContMeses,$NomFino,$Fino,$CmbProveedor,$CmbContrato,$CmbProducto,&$ArrayTot,$CodSeleccion);
				MuestraPagable($Ano,$Mes,$ContMeses,$Fino,$CmbProveedor,$CmbContrato,$CmbProducto,'2',$NomFino,&$ArrayTot,$CodSeleccion);
				MuestraMesPago($Ano,$Mes,$ContMeses,$Fino,$CmbProveedor,$CmbContrato,$CmbProducto,$Meses,$CodSeleccion);
				MuestraPrecioPago($Ano,$Mes,$ContMeses,$Fino,$CmbProveedor,$CmbContrato,$CmbProducto,$Meses,$NomFino,&$ArrayTot,$CodSeleccion);
				MuestraValorFactura($Ano,$Mes,$ContMeses,$Fino,$CmbProveedor,$CmbContrato,$CmbProducto,'4',$NomFino,&$ArrayTot,$CodSeleccion);
				MuestraValorLiquidacion($ArrayTot,$NomFino);
				MuestraDebCred($ArrayTot,$NomFino);
				reset($ArrayTot);
				while(list($c,$v)=each($ArrayTot))
				{
					$ArrayTot[$c][0]=0;
					$ArrayTot[$c][1]=0;
					$ArrayTot[$c][2]=0;
					$ArrayTot[$c][3]=0;
				}
				
			}	
		}		 
		?>
      </table></td>
    </tr>
  </table>
</form>
</body>
</html>
<?
function MuestraFino($Ano,$Mes,$ContMeses,$Fino,$Prv,$Contrato,$CodProd,$NomFino,$Meses,$MesFin,$CodSeleccion)
{
	$CantCol=1;
	$Anodesde=$Ano;
	$a=intval($Mes);
	$Aux=$a+$ContMeses;
	$k=$a-1;$Clase='';
	for($i=$a;$i<$Aux;$i++)
	{
		if($k>=12)
		{
			$k=0;
			$Anodesde=$Ano+1;
		}
		$FechaInicio=$Anodesde."-".($k+1)."-1";
		$FechaFin=$Anodesde."-".($k+1)."-31";
		$CantCol=$CantCol+RetornaColSpan($Fino,$Prv,$Contrato,$CodProd,$FechaInicio,$FechaFin,$CodSeleccion);		 	
		$k=$k+1;
	}
	$FechaFactura=explode('-',$FechaFin);
	$FechaAVencer=date( "Y-m-d", mktime(0,0,0,intval($FechaFactura[1]),$FechaFactura[2],$FechaFactura[0]));
	$FechaAVencer=explode('-',$FechaAVencer);
	echo "<tr><td align='center' colspan='".$CantCol."'>".$NomFino."</td>";
	echo "<td align='center'>Provisi&oacute;n a ".$Meses[($MesFin)-1]."&nbsp;".$Anodesde."</td>";
	echo "</tr>";
}

function MuestraMeses($Ano,$Mes,$ContMeses,$Fino,$Prv,$Contrato,$CodProd,$Meses,$CodSeleccion)
{
	echo "<tr><td>Mes Entrega</td>";
	$Anodesde=$Ano;
	$a=intval($Mes);
	$Aux=$a+$ContMeses;
	$k=$a-1;$Clase='';
	for($i=$a;$i<$Aux;$i++)
	{
		if($k>=12)
		{
			$k=0;
			$Anodesde=$Ano+1;
		}
		if($Clase=="TituloCabeceraOz")
			$Clase="TituloCabeceraOz";
		else
			$Clase="TituloCabeceraOz";
		$FechaInicio=$Anodesde."-".($k+1)."-1";
		$FechaFin=$Anodesde."-".($k+1)."-31";
		$CantCol=RetornaColSpan($Fino,$Prv,$Contrato,$CodProd,$FechaInicio,$FechaFin,$CodSeleccion);
		if($CantCol!=0)
		{
		?>
		<td align="center" colspan="<? echo $CantCol;?>"> <? echo $Meses[$k]."&nbsp;".$Anodesde; ?></td>
		<?
		}
		$k=$k+1;
	}
		echo "<td align='center' rowspan='7'>&nbsp;</td>";
	echo "</tr>"; 

}
function MuestraFactura($Ano,$Mes,$ContMeses,$Fino,$Prv,$Contrato,$CodProd,$CodSeleccion)
{
	echo "<tr><td>Facturas</td>";
	$Anodesde=$Ano;
	$a=intval($Mes);
	$Aux=$a+$ContMeses;
	$k=$a-1;$Clase='';
	for($i=$a;$i<$Aux;$i++)
	{
		if($k>=12)
		{
			$k=0;
			$Anodesde=$Ano+1;
		}
		if($Clase=="TituloCabeceraOz")
			$Clase="TituloCabeceraOz";
		else
			$Clase="TituloCabeceraOz";

		$FechaInicio=$Anodesde."-".($k+1)."-1";
		$FechaFin=$Anodesde."-".($k+1)."-31";
		//echo $Prv."<br>";
		$Consulta1 ="select distinct t1.num_factura, t1.tipo from pcip_fac_compra t1 inner join pcip_fac_compra_finos t2";
		$Consulta1.=" on t1.codigo=t2.codigo where t1.rut_proveedor<>'' and t2.cod_fino='".$Fino."'";
		if($Prv!='-1')
			$Consulta1.=" and t1.rut_proveedor='".$Prv."'";
		if($CodProd!='T')
		{
			$Str="(";
			$Codigos=explode(',',$CodSeleccion);
			while(list($c,$v)=each($Codigos))
			{
				$Str=$Str."'".$v."',";
				
			}
			$Str=substr($Str,0,strlen($Str)-1);
			$Str=$Str.")";
			$Consulta1.=" and t1.cod_producto in ".$Str;	
		}
		if($Contrato!='T')
			$Consulta1.=" and t1.tipo='".$Contrato."'";
		$Consulta1.=" and t1.estado_actual='1'";
		$Consulta1.=" and t1.fecha_emision BETWEEN '".$FechaInicio."' and '".$FechaFin."'";
		$Consulta1.=" group by t1.codigo";
		$Resp1=mysql_query($Consulta1);				
		//echo $Consulta1."<br>";
		while($Fila1=mysql_fetch_array($Resp1))
		{			     
			$Facturas=$Fila1[num_factura];			
			//echo $Facturas."<br>";
			echo "<td align='center'>".$Facturas."</td>";
		}			
		$k=$k+1;
	}
	echo "</tr>"; 
}

function RetornaColSpan($Fino,$Prv,$Contrato,$CodProd,$FechaInicio,$FechaFin,$CodSeleccion)
{
	//COLSPAN PARA LOS MESES
	$Cant=0;
	$Consulta1 ="select distinct num_factura from pcip_fac_compra t1 inner join pcip_fac_compra_finos t2";
	$Consulta1.=" on t1.codigo=t2.codigo where rut_proveedor<>'' and t2.cod_fino='".$Fino."' ";//estado_actual='1'";
	if($Prv!='-1')
		$Consulta1.=" and t1.rut_proveedor='".$Prv."'";
	if($CodProd!='T')
	{
		$Str="(";
		$Codigos=explode(',',$CodSeleccion);
		while(list($c,$v)=each($Codigos))
		{
			$Str=$Str."'".$v."',";
			
		}
		$Str=substr($Str,0,strlen($Str)-1);
		$Str=$Str.")";
		$Consulta1.=" and t1.cod_producto in ".$Str;	
	}
	if($Contrato!='T')
		$Consulta1.=" and t1.tipo='".$Contrato."'";
	$Consulta1.=" and t1.estado_actual='1'";
	$Consulta1.=" and t1.fecha_emision BETWEEN '".$FechaInicio."' and '".$FechaFin."'";
	$Resp1=mysql_query($Consulta1);				
	//echo $Consulta1."<br><br>";
	while($Fila1=mysql_fetch_array($Resp1))
		$Cant++;
	return($Cant);
}

function MuestraPrecio($Ano,$Mes,$ContMeses,$NomFino,$Fino,$Prv,$Contrato,$CodProd,$ArrayTot,$CodSeleccion)
{
    if($NomFino=='Oro'||$NomFino=='Plata')
		 $Unidad='US$/Oz';
	else
   		 $Unidad='US$/TMS';
	echo "<tr><td>Precio ".$NomFino."&nbsp;&nbsp;&nbsp;".$Unidad."</td>";
	$Anodesde=$Ano;
	$a=intval($Mes);
	$Aux=$a+$ContMeses;
	$k=$a-1;$Clase='';
	for($i=$a;$i<$Aux;$i++)
	{
		if($k>=12)
		{
			$k=0;
			$Anodesde=$Ano+1;
		}
		if($Clase=="TituloCabeceraOz")
			$Clase="TituloCabeceraOz";
		else
			$Clase="TituloCabeceraOz";
		$FechaInicio=$Anodesde."-".($k+1)."-1";
		$FechaFin=$Anodesde."-".($k+1)."-31";
		$Consulta1 ="select distinct num_factura,fecha_emision from pcip_fac_compra t1 inner join pcip_fac_compra_finos t2";
		$Consulta1.=" on t1.codigo=t2.codigo where t1.rut_proveedor<>'' and t2.cod_fino='".$Fino."'";
		if($Prv!='-1')
			$Consulta1.=" and t1.rut_proveedor='".$Prv."'";
		if($CodProd!='T')
		{
			$Str="(";
			$Codigos=explode(',',$CodSeleccion);
			while(list($c,$v)=each($Codigos))
			{
				$Str=$Str."'".$v."',";
				
			}
			$Str=substr($Str,0,strlen($Str)-1);
			$Str=$Str.")";
			$Consulta1.=" and t1.cod_producto in ".$Str;	
		}
		if($Contrato!='T')
			$Consulta1.=" and t1.tipo='".$Contrato."'";
		$Consulta1.=" and t1.estado_actual='1'";
		$Consulta1.=" and t1.fecha_emision BETWEEN '".$FechaInicio."' and '".$FechaFin."'";
		$Consulta1.=" group by t1.codigo";
		$Resp1=mysql_query($Consulta1);				
		//echo $Consulta1."<br>";
		while($Fila1=mysql_fetch_array($Resp1))
		{			    
			$Facturas=$Fila1[num_factura];			
			$AnoPrecio=substr($Fila1[fecha_emision],0,4);
			$MesPrecio=intval(substr($Fila1[fecha_emision],5,2));	
			$ConsultaPrecio=" select valor,cod_unidad,euro from pcip_fac_compra_finos where numero='".$Facturas."' and cod_fino='".$Fino."' and cod_contenido='3'";
			$RespPrecio=mysql_query($ConsultaPrecio);
			//echo $ConsultaPrecio."<br>";
			if($FilaPrecio=mysql_fetch_array($RespPrecio))
			{			    
				$ValorPrecio=$FilaPrecio[valor];
				$Precio=ConversionPagablePrecio($NomFino,$ValorPrecio,$FilaPrecio[cod_unidad],$FilaPrecio[euro]);
			}
			else
				$Precio=0;
			//echo $Facturas."<br>";
			$ArrayTot[$Fila1[num_factura]][0]=$Precio;
			//echo $ArrayTot[$Fila1[num_factura]][0]."<br><br>";
			echo "<td  align='right'>".number_format($Precio,2,',','.')."</td>";
		}
		$k=$k+1;					
	}	
	echo "</tr>"; 
}

function MuestraPagable($Ano,$Mes,$ContMeses,$Fino,$Prv,$Contrato,$CodProd,$Pagable,$NomFino,$ArrayTot,$CodSeleccion)
{
    if($NomFino=='Oro'||$NomFino=='Plata')
		 $Unidad1='GR';
	else
   		 $Unidad1='TMS';
    echo "<tr><td>Pagable ".$NomFino."&nbsp;&nbsp;&nbsp;".$Unidad1."</td>";
	$Anodesde=$Ano;
	$a=intval($Mes);
	$Aux=$a+$ContMeses;
	$k=$a-1;$Clase='';
	for($i=$a;$i<$Aux;$i++)
	{
		if($k>=12)
		{
			$k=0;
			$Anodesde=$Ano+1;
		}
		if($Clase=="TituloCabeceraOz")
			$Clase="TituloCabeceraOz";
		else
			$Clase="TituloCabeceraOz";
			
		$FechaInicio=$Anodesde."-".($k+1)."-1";
		$FechaFin=$Anodesde."-".($k+1)."-31";
		
		$Consulta1 ="select distinct num_factura,fecha_emision from pcip_fac_compra t1 inner join pcip_fac_compra_finos t2";
		$Consulta1.=" on t1.codigo=t2.codigo where t1.rut_proveedor<>'' and t2.cod_fino='".$Fino."'";
		if($Prv!='-1')
			$Consulta1.=" and t1.rut_proveedor='".$Prv."'";
		if($CodProd!='T')
		{
			$Str="(";
			$Codigos=explode(',',$CodSeleccion);
			while(list($c,$v)=each($Codigos))
			{
				$Str=$Str."'".$v."',";
				
			}
			$Str=substr($Str,0,strlen($Str)-1);
			$Str=$Str.")";
			$Consulta1.=" and t1.cod_producto in ".$Str;	
		}
		if($Contrato!='T')
			$Consulta1.=" and t1.tipo='".$Contrato."'";
		$Consulta1.=" and t1.estado_actual='1'";
		$Consulta1.=" and t1.fecha_emision BETWEEN '".$FechaInicio."' and '".$FechaFin."'";
		$Consulta1.=" group by t1.codigo";
		$Resp1=mysql_query($Consulta1);				
		//echo $Consulta1."<br>";
		while($Fila1=mysql_fetch_array($Resp1))
		{					    
			$ConsultaPagable ="select t2.valor,t2.cod_unidad from pcip_fac_compra t1 inner join pcip_fac_compra_finos t2";
			$ConsultaPagable.=" on t1.codigo=t2.codigo where t1.rut_proveedor<>'' and t1.num_factura='".$Fila1[num_factura]."' and t2.cod_fino='".$Fino."' and cod_contenido='".$Pagable."'";
			if($Prv!='-1')
				$ConsultaPagable.=" and t1.rut_proveedor='".$Prv."'";
			if($CodProd!='T')
			{
				$Str="(";
				$Codigos=explode(',',$CodSeleccion);
				while(list($c,$v)=each($Codigos))
				{
					$Str=$Str."'".$v."',";
					
				}
				$Str=substr($Str,0,strlen($Str)-1);
				$Str=$Str.")";
				$Consulta1.=" and t1.cod_producto in ".$Str;	
			}
			if($Contrato!='T')
				$Consulta1.=" and t1.tipo='".$Contrato."'";
			$ConsultaPagable.=" and t1.estado_actual='1'";
			$ConsultaPagable.=" and t1.fecha_emision BETWEEN '".$FechaInicio."' and '".$FechaFin."'";
			$ConsultaPagable.=" group by t1.codigo";
			$RespPagable=mysql_query($ConsultaPagable);				
			//echo $ConsultaPagable."<br>";
			if($FilaPagable=mysql_fetch_array($RespPagable))
			{	
			    //echo $NomFino."     ".$FilaPagable[valor]."      ".$FilaPagable[cod_unidad];
				$ValorPaga=$FilaPagable[valor];	    
				$ValorPagable=ConversionPagablePrecio($NomFino,$ValorPaga,$FilaPagable[cod_unidad],'');					
			}			
			$ArrayTot[$Fila1[num_factura]][1]=$ValorPagable;	
			echo "<td align='right'>".number_format($ValorPagable,2,',','.')."</td>";
		}
		$k=$k+1;	
 	}
	echo "</tr>";
}

function MuestraMesPago($Ano,$Mes,$ContMeses,$Fino,$Prv,$Contrato,$CodProd,$Meses,$CodSeleccion)
{
    echo "<tr><td>Mes Pago</td>";
	$Anodesde=$Ano;
	$a=intval($Mes);
	$Aux=$a+$ContMeses;
	$k=$a-1;$Clase='';
	for($i=$a;$i<$Aux;$i++)
	{
		if($k>=12)
		{
			$k=0;
			$Anodesde=$Ano+1;
		}
		if($Clase=="TituloCabeceraOz")
			$Clase="TituloCabeceraOz";
		else
			$Clase="TituloCabeceraOz";
		$FechaInicio=$Anodesde."-".($k+1)."-1";
		$FechaFin=$Anodesde."-".($k+1)."-31";

		$Consulta1 ="select distinct t1.num_factura,t1.fecha_emision,t1.tipo as TipoCtto,t3.acuerdo_contractual_au,t3.acuerdo_contractual_cu,t3.acuerdo_contractual_ag from pcip_fac_compra t1 inner join pcip_fac_compra_finos t2";
		$Consulta1.=" on t1.codigo=t2.codigo inner join pcip_fac_contratos_compra t3 on t1.cod_contrato=t3.cod_contrato";
		$Consulta1.=" where t1.rut_proveedor<>'' and t2.cod_fino='".$Fino."'";
		if($Prv!='-1')
			$Consulta1.=" and t1.rut_proveedor='".$Prv."'";
		if($CodProd!='T')
		{
			$Str="(";
			$Codigos=explode(',',$CodSeleccion);
			while(list($c,$v)=each($Codigos))
			{
				$Str=$Str."'".$v."',";
				
			}
			$Str=substr($Str,0,strlen($Str)-1);
			$Str=$Str.")";
			$Consulta1.=" and t1.cod_producto in ".$Str;	
		}
		if($Contrato!='T')
			$Consulta1.=" and t1.tipo='".$Contrato."'";
		$Consulta1.=" and t1.estado_actual='1'";
		$Consulta1.=" and t1.fecha_emision BETWEEN '".$FechaInicio."' and '".$FechaFin."'";
		$Consulta1.=" group by t1.codigo";
		$Resp1=mysql_query($Consulta1);				
		//echo $Consulta1."<br>";
		while($Fila1=mysql_fetch_array($Resp1))
		{
			$Acuerdo=ObtenerAcuerdo($Fino,$Fila1[acuerdo_contractual_cu],$Fila1[acuerdo_contractual_ag],$Fila1[acuerdo_contractual_au]);
			$FechaFactura=explode('-',$Fila1[fecha_emision]);
			$FechaPago=date( "Y-m-d", mktime(0,0,0,intval($FechaFactura[1])+$Acuerdo,$FechaFactura[2],$FechaFactura[0]));
			$FechaPago=explode('-',$FechaPago);			
			$AnoPago=$FechaPago[0];
			$MesPago=intval($FechaPago[1]);
			/*if($Fila1["num_factura"]=='264991')
			{
				echo "FACTURA:".$Fila1["num_factura"]."<br>";
				echo "ACUERDO:".$Acuerdo."<br>";
				echo "FECHA FACTURA:".$FechaFactura."<br>";
				echo "FECHA PAGO:".$FechaFactura."<br>";
				echo "ANO PAGO:".$AnoPago."<br>";
				echo "MES PAGO:".$MesPago."<br><br>";
			}*/
			echo "<td  align='center'>".$Meses[$MesPago-1]."&nbsp;".$AnoPago."</td>";
		}
		$k=$k+1;
	}	
	echo "</tr>";

}
function MuestraPrecioPago($Ano,$Mes,$ContMeses,$Fino,$Prv,$Contrato,$CodProd,$Meses,$NomFino,$ArrayTot,$CodSeleccion)
{
    echo "<tr><td>Precio ".$NomFino."</td>";
	$Anodesde=$Ano;
	$a=intval($Mes);
	$Aux=$a+$ContMeses;
	$k=$a-1;$Clase='';
	for($i=$a;$i<$Aux;$i++)
	{
		if($k>=12)
		{
			$k=0;
			$Anodesde=$Ano+1;
		}
		if($Clase=="TituloCabeceraOz")
			$Clase="TituloCabeceraOz";
		else
			$Clase="TituloCabeceraOz";
		$FechaInicio=$Anodesde."-".($k+1)."-1";
		$FechaFin=$Anodesde."-".($k+1)."-31";

		$Consulta1 ="select distinct t1.num_factura,t1.fecha_emision,t1.tipo as TipoCtto,t3.acuerdo_contractual_au,t3.acuerdo_contractual_cu,t3.acuerdo_contractual_ag from pcip_fac_compra t1 inner join pcip_fac_compra_finos t2";
		$Consulta1.=" on t1.codigo=t2.codigo inner join pcip_fac_contratos_compra t3 on t1.cod_contrato=t3.cod_contrato";
		$Consulta1.=" where t1.rut_proveedor<>'' and t2.cod_fino='".$Fino."'";
		if($Prv!='-1')
			$Consulta1.=" and t1.rut_proveedor='".$Prv."'";
		if($CodProd!='T')
		{
			$Str="(";
			$Codigos=explode(',',$CodSeleccion);
			while(list($c,$v)=each($Codigos))
			{
				$Str=$Str."'".$v."',";
				
			}
			$Str=substr($Str,0,strlen($Str)-1);
			$Str=$Str.")";
			$Consulta1.=" and t1.cod_producto in ".$Str;	
		}
		if($Contrato!='T')
			$Consulta1.=" and t1.tipo='".$Contrato."'";
		$Consulta1.=" and t1.estado_actual='1'";
		$Consulta1.=" and t1.fecha_emision BETWEEN '".$FechaInicio."' and '".$FechaFin."'";
		$Consulta1.=" group by t1.codigo";
		$Resp1=mysql_query($Consulta1);				
		//echo $Consulta1."<br>";
		while($Fila1=mysql_fetch_array($Resp1))
		{
		   	//echo 	$Fila1[cod_fino]."&nbsp;".$Fila1[acuerdo_contractual_cu]."&nbsp;".$Fila1[acuerdo_contractual_ag]."&nbsp;".$Fila1[acuerdo_contractual_au];
			$Acuerdo=ObtenerAcuerdo($Fino,$Fila1[acuerdo_contractual_cu],$Fila1[acuerdo_contractual_ag],$Fila1[acuerdo_contractual_au]);					
			$FechaFactura=explode('-',$Fila1[fecha_emision]);
			$FechaPago=date( "Y-m-d", mktime(0,0,0,intval($FechaFactura[1])+$Acuerdo,$FechaFactura[2],$FechaFactura[0]));
			$FechaPago=explode('-',$FechaPago);			
			$AnoPrecio=$FechaPago[0];
			$MesPrecio=intval($FechaPago[1]);
			//echo "MES PRECIO:".$MesPrecio."<br>";
			$ConsultaPrecio=" select valor from pcip_fac_compra_precios where ano='".$AnoPrecio."' and mes='".$MesPrecio."' and cod_fino='".$Fino."'";
			$RespPrecio=mysql_query($ConsultaPrecio);
			//echo $ConsultaPrecio."<br>";			
			if($FilaPrecio=mysql_fetch_array($RespPrecio))
				$PrecioPago=$FilaPrecio[valor];	
			else
			{
				$Facturas=$Fila1[num_factura];			
				$AnoPrecio=substr($Fila1[fecha_emision],0,4);
				$MesPrecio=intval(substr($Fila1[fecha_emision],5,2));	
				$ConsultaPrecio=" select valor from pcip_fac_compra_precios where ano='".$AnoPrecio."' and mes='".$MesPrecio."' and cod_fino='".$Fino."'";
				$RespPrecio=mysql_query($ConsultaPrecio);
				//echo "segunda consulta   ".$ConsultaPrecio."<br>";
				if($FilaPrecio=mysql_fetch_array($RespPrecio))
					$PrecioPago=$FilaPrecio[valor];					
			}	
			$ArrayTot[$Fila1[num_factura]][2]=$PrecioPago;	
			//echo $Facturas."<br>";
			echo "<td align='right'>".number_format($PrecioPago,2,',','.')."</td>";			
		}
		$k=$k+1;		
	}			
	echo "</tr>";		
}

function MuestraValorFactura($Ano,$Mes,$ContMeses,$Fino,$Prv,$Contrato,$CodProd,$Pagable,$NomFino,$ArrayTot,$CodSeleccion)
{
   	echo "<tr><td>Valor Factura US$ </td>";
	$Anodesde=$Ano;
	$a=intval($Mes);
	$Aux=$a+$ContMeses;
	$k=$a-1;$Clase='';
	for($i=$a;$i<$Aux;$i++)
	{
		if($k>=12)
		{
			$k=0;
			$Anodesde=$Ano+1;
		}
		if($Clase=="TituloCabeceraOz")
			$Clase="TituloCabeceraOz";
		else
			$Clase="TituloCabeceraOz";
		$FechaInicio=$Anodesde."-".($k+1)."-1";
		$FechaFin=$Anodesde."-".($k+1)."-31";
		$Consulta1 ="select distinct num_factura,fecha_emision from pcip_fac_compra t1 inner join pcip_fac_compra_finos t2";
		$Consulta1.=" on t1.codigo=t2.codigo where t1.rut_proveedor<>'' and t2.cod_fino='".$Fino."'";
		if($Prv!='-1')
			$Consulta1.=" and t1.rut_proveedor='".$Prv."'";
		if($CodProd!='T')
		{
			$Str="(";
			$Codigos=explode(',',$CodSeleccion);
			while(list($c,$v)=each($Codigos))
			{
				$Str=$Str."'".$v."',";
				
			}
			$Str=substr($Str,0,strlen($Str)-1);
			$Str=$Str.")";
			$Consulta1.=" and t1.cod_producto in ".$Str;	
		}
		if($Contrato!='T')
			$Consulta1.=" and t1.tipo='".$Contrato."'";
		$Consulta1.=" and t1.estado_actual='1'";
		$Consulta1.=" and t1.fecha_emision BETWEEN '".$FechaInicio."' and '".$FechaFin."'";
		$Consulta1.=" group by t1.codigo";
		$Resp1=mysql_query($Consulta1);				
		//echo $Consulta1."<br>";
		while($Fila1=mysql_fetch_array($Resp1))
		{			    
			$Facturas=$Fila1[num_factura];			
			$AnoPrecio=substr($Fila1[fecha_emision],0,4);
			$MesPrecio=intval(substr($Fila1[fecha_emision],5,2));	
			$ConsultaPrecio=" select valor from pcip_fac_compra_finos where numero='".$Facturas."' and cod_fino='".$Fino."' and cod_contenido='4'";
			$RespPrecio=mysql_query($ConsultaPrecio);
			//echo $ConsultaPrecio."<br>";
			if($FilaPrecio=mysql_fetch_array($RespPrecio))
				$ValorFactura=$FilaPrecio[valor];	
			else
				$ValorFactura="";
			$ArrayTot[$Fila1[num_factura]][3]=$ValorFactura;			
			echo "<td  align='right'>".number_format($ValorFactura,2,',','.')."</td>";
		}
		$k=$k+1;					
	}	
	echo "</tr>"; 
}

function MuestraValorLiquidacion($ArrayTot,$NomFino)
{
	echo "<tr><td>Valor Liquidaci�n US$ </td>";

	if($Clase=="TituloCabeceraOz")
		$Clase="TituloCabeceraOz";
	else
		$Clase="TituloCabeceraOz";		
	reset($ArrayTot);
	while(list($c,$v)=each($ArrayTot))
	{
	    //echo $ArrayTot[$c][0]."<br>";	
		if($ArrayTot[$c][0]!='')
		{
			//echo $ArrayTot[$c][0]."<br>";	
			if($NomFino=='Plata'||$NomFino=='Oro')
				$ValorLiquidacion=($ArrayTot[$c][1]*$ArrayTot[$c][2])/31.103477;
			else	
				$ValorLiquidacion=$ArrayTot[$c][1]*$ArrayTot[$c][2];
			echo "<td  align='right'>".number_format($ValorLiquidacion,2,',','.')."</td>";
			$ValorEstimadoLiqui=$ValorEstimadoLiqui+$ValorLiquidacion;
		}
		else
		  echo "<td  align='right'>".number_format(0,2,',','.')."</td>";
	}
	echo "<td align='center'>".number_format($ValorEstimadoLiqui,2,',','.')."</td>";
	echo "</tr>";
}

function MuestraDebCred($ArrayTot,$NomFino)
{
	echo "<tr><td>DEB/CREDITO</td>";

	if($Clase=="TituloCabeceraOz")
		$Clase="TituloCabeceraOz";
	else
		$Clase="TituloCabeceraOz";
	reset($ArrayTot);
	while(list($c,$v)=each($ArrayTot))
	{
		if($ArrayTot[$c][0]!='')
		{
			$ValorFact=$ArrayTot[$c][3];
			if($NomFino=='Plata'||$NomFino=='Oro')
				$ValorLiq=($ArrayTot[$c][1]*$ArrayTot[$c][2])/31.103477 ;
			else	
				$ValorLiq=$ArrayTot[$c][1]*$ArrayTot[$c][2];
		
		$DecCred=$ValorFact-$ValorLiq;
		echo "<td  align='right'>".number_format($DecCred,2,',','.')."</td>";
		
		$ValorEstimadoDebCred=$ValorEstimadoDebCred+$DecCred;
		}
		else
		  echo "<td  align='right'>".number_format(0,2,',','.')."</td>";
	}
		echo "<td align='center'>".number_format($ValorEstimadoDebCred,2,',','.')."</td>";
	echo "</tr>";
}
function ObtenerAcuerdo($Fino,$Cobre,$Plata,$Oro)
{
   switch ($Fino)	
   {  	 
	  case "1"://COBRE
			if($Cobre!=''||$Cobre!='Null')
				$Acuerdo=intval($Cobre);
			else
			{
				if($Oro>$Plata)
					$Acuerdo=intval($Oro);
				else	
					$Acuerdo=intval($Plata);
			}	
	  break;
	  case "2"://PLATA
			if($Plata!=''||$Plata!='Null')
				$Acuerdo=intval($Plata);
			else
			{
				if($Cobre>$Oro)
					$Acuerdo=intval($Cobre);
				else	
					$Acuerdo=intval($Oro);
			}	
	  break;
	  case "3"://ORO
			if($Oro!=''||$Oro!='Null')
				$Acuerdo=intval($Oro);
			else
			{
				if($Cobre>$Plata)
					$Acuerdo=intval($Cobre);
				else	
					$Acuerdo=intval($Plata);
			}	
	  break;
   }	   
   return ($Acuerdo);	  
}
function ConversionPagablePrecio($NomFino,$Valor,$CodUnidad,$Euro)
{
	$ValorSalida=0;
	switch ($NomFino)
	{
		case "Cobre":		
					 switch($CodUnidad)
					 {					 
					 	case "1"://TON A TON
								$ValorSalida=$Valor;
						break;
					 	case "2"://GR A TON
								$ValorSalida=$Valor/1000000;
						break;
					 	case "3"://OZ A TON
								$ValorSalida=($Valor*0.031013477)/1000; 
						break;
					 	case "4"://LB A TON
								$ValorSalida=($Valor*0.45359237)/1000;
						break;
					 	case "5"://KG A TON
								$ValorSalida=$Valor/1000;
						break;
					 	case "6"://USC/LB a US$/Ton
								$ValorSalida=$Valor/(0.45359237*100000);
						break;
					 	case "7"://US$/LB a US$/Ton
								$ValorSalida=$Valor/(0.45359237*1000);
						break;
					 	case "8"://US$/OZ a US$/Ton
								$ValorSalida=$Valor/(0.031013477*1000);
						break;
					 	case "9"://EURO/KG a US$/Ton
								$ValorSalida=($Valor*1000)/$Euro;
						break;
					 	case "10"://US$/KG a US$/Ton
								$ValorSalida=$Valor*1000;
						break;
					 	case "11"://US$/GR a US$/Ton
								$ValorSalida=$Valor*1000000;
						break;
					 	case "18"://US$/Ton
								$ValorSalida=$Valor;
						break;
					 }
		break;
		case "Plata":
		case "Oro":
					 switch($CodUnidad)
					 {
					    case "2":
								$ValorSalida=$Valor;
						break;
					 	case "1"://TON A GR
								$ValorSalida=$Valor*1000000;
						break;
					 	case "3"://OZ A GR
								$ValorSalida=($Valor*31.013477); 
						break;
					 	case "4"://LB A GR
								$ValorSalida=($Valor*453.59237);
						break;
					 	case "5"://KG A GR
								$ValorSalida=$Valor*1000;
						break;
					 	case "6"://USC/LB a US$/OZ
								$ValorSalida=($Valor/14.5833)/100;
						break;
					 	case "7"://US$/LB a US$/OZ
								$ValorSalida=($Valor/14.5833);
						break;
					 	case "8"://US$/OZ
								$ValorSalida=$Valor;
						break;
					 	case "9"://EURO/KG a US$/OZ
								$ValorSalida=($Valor*1000)/$Euro;
						break;
					 	case "10"://US$/KG a US$/OZ
								$ValorSalida=$Valor/32.15074657;
						break;
					 	case "11"://US$/GR a US$/OZ
								$ValorSalida=$Valor*31.303477;
						break;
					 }
		break;
	}
	return($ValorSalida);
}
?>