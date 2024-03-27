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
<title>Reporte Ingresos Proyectados Asignaciones</title>
<link href="estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body>
<form name="frmPrincipal" action="" method="post">
  <table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
    <tr>
      <td width="20%" align="center" rowspan="2">Asignaciones Divisi&oacute;n Ventanas</td>
      <?
			for($i=$Mes;$i<=$MesFin;$i++)
			{
			?>
      <td width="7%" align="center" colspan="2"><? echo $Meses[$i-1]?></td>
      <?	
			}
			?>
    </tr>
    <tr>
      <?
			for($i=$Mes;$i<=$MesFin;$i++)
			{
			?>
      <td width="7%" align="center" >Real</td>
      <td width="7%" align="center">Proyectado</td>
      <?	
			}
			?>
    </tr>
    <?		
			$Buscar='S';
  			 if($Buscar=='S')
			 {	
				$Consulta ="select distinct(t2.nombre_subclase) ,t2.cod_subclase  from pcip_inp_asignacion t1";
				$Consulta.=" left join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31029' and t2.cod_subclase=t1.cod_producto";
				$Consulta.=" where t1.cod_producto<>''";	
				if($CmbProducto!='T')
					$Consulta.=" and t1.cod_producto='".$CmbProducto."'";	
				//echo $Consulta."<br>"; 	
				$Resp=mysqli_query($link, $Consulta);
				while($Fila=mysql_fetch_array($Resp))
				{
					$NomProducto=$Fila["nombre_subclase"];
					$CodProducto=$Fila["cod_subclase"];
					?>
    <tr>
      <td rowspan="1" colspan="25" align="left"><?  echo $NomProducto;?></td>
    </tr>
    <?
						$Consulta1 ="select nombre_subclase,cod_subclase from proyecto_modernizacion.sub_clase where cod_clase='31030' and valor_subclase1='".$CodProducto."'";						
						//if($CmbProveedores!='T')
							//$Consulta1.=" and cod_subclase='".$CmbProveedores."'";												
						//echo $Consulta1; 	
						$Resp1=mysql_query($Consulta1);
						while($Fila1=mysql_fetch_array($Resp1))
						{
							$NomProveedor=$Fila1["nombre_subclase"];
							$CodProveedor=$Fila1["cod_subclase"];							
							?>
    <tr>
      <td rowspan="1" align="left"><?  echo $NomProveedor;?></td>
      <?
								for($i=$Mes;$i<=$MesFin;$i++)
								{
								?>
      <td rowspan="1" align="right"><?  echo number_format(DatosProyectadosSVP($CodProducto,$CodProveedor,$Ano,$i),0,',','.');?>
        &nbsp;</td>
      <td rowspan="1" align="right"><?  echo number_format(DatosProyectadosPPC($CodProducto,$CodProveedor,$Ano,$i),0,',','.');?>
        &nbsp;</td>
      <?
								}
								?>
    </tr>
    <?														
						}
					?>
    <?				       
				}					 
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
function DatosProyectadosPPC($Producto,$Proveedor,$Ano,$Mes)
{
   $Datos2=0;
   $Consulta="select Vporden,Vptm,VPmaterial,Vptipinv from pcip_inp_asignacion";
   $Consulta.=" where cod_producto='".$Producto."' and cod_proveedor='".$Proveedor."' and dato='2'";
   //echo $Consulta."<br>";
   $Resp=mysqli_query($link, $Consulta);  
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
?>
