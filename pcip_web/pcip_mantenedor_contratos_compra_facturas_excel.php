<?
header("Content-Type:  application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");
?>
<html>
<head>
<title>Mantenedor Contratos Facturas Excel</title>
<link href="../pcip_web/estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<form name="FrmPrincipal" method="post" action="">
<table width="930" border="1" cellpadding="4" cellspacing="0" >
  <tr align="center">
    <td width="6%">Contrato</td>
    <td width="8%">Rut Proveedor</td>
    <td width="11%">Proveedor/Cliente</td>
    <td width="7%">Producto</td>
    <td width="6%">Tipo Contrato</td>
    <td width="6%">Mercado</td>
    <td width="6%">Fecha Inicio</td>
    <td width="7%">Fecha Termino</td>
    <td width="11%">Acuerdo Contractual Cu</td>
    <td width="11%">Acuerdo Contractual Ag</td>
    <td width="11%">Acuerdo Contractual Au</td>
    <td width="11%">Acuerdo Contractual Otro</td>
    <td width="7%">Vigente</td>
  </tr>
  <?
   $Buscar='S';
if($Buscar=='S')
{
	$Consulta = "select t4.nombre_subclase as nom_tipo,t5.nombre_subclase as nom_mercado,t1.cod_contrato,t1.cod_producto,t1.rut_proveedor,t2.nom_producto,t1.fecha_contrato,t1.duracion,t1.acuerdo_contractual_cu,t1.acuerdo_contractual_ag,t1.acuerdo_contractual_au,t1.nom_cliente,t1.vigente,t1.acuerdo_contractual_otro,t3.nombre_subclase,t6.nom_proveedor";
	$Consulta.= " from pcip_fac_contratos_compra t1 inner join pcip_fac_productos_facturas t2 on t1.cod_producto=t2.cod_producto";
	$Consulta.= " left join  proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31007' and t1.vigente=t3.cod_subclase";
	$Consulta.= " left join proyecto_modernizacion.sub_clase t4 on t4.cod_clase='31017' and t1.tipo_contrato=t4.cod_subclase";
	$Consulta.= " left join proyecto_modernizacion.sub_clase t5 on t5.cod_clase='31008' and t1.cod_mercado=t5.cod_subclase";
	$Consulta.= " left join pcip_fac_proveedores t6 on t1.rut_proveedor=t6.rut_proveedor";	
	$Consulta.= " where t1.cod_contrato<>''";
	if($CmbContrato!='-1')
		$Consulta.=" and t1.cod_contrato='".$CmbContrato."'";
	if($CmbProveedor!='-1')
		$Consulta.=" and t1.rut_proveedor='".$CmbProveedor."'";					
	if($CmbVig!='-1')
		$Consulta.=" and t1.vigente='".$CmbVig."'";		
	if($CmbTipoContrato!='-1')
		$Consulta.=" and t1.tipo_contrato='".$CmbTipoContrato."'";				
	$Consulta.= " order by t1.cod_producto ";
	$Resp = mysql_query($Consulta);
	//echo $Consulta;
	
	while ($Fila=mysql_fetch_array($Resp))
	{
		$Cod=$Fila["cod_contrato"];
		$NomProveedor=ucfirst(strtolower($Fila["nom_proveedor"]));
		$Rut =$Fila["rut_proveedor"];
		$Pro =ucfirst(strtolower($Fila["nom_producto"]));
		$TipCon=$Fila["nom_tipo"];
		$Merc=$Fila["nom_mercado"];
		$Fecha =$Fila["fecha_contrato"];	
		$Dura =$Fila["duracion"];	
		if($Fila["acuerdo_contractual_cu"]=='')
			$AcuerdoCu ="";	
		else
			$AcuerdoCu ="Mes ".$Fila["acuerdo_contractual_cu"];	
		if($Fila["acuerdo_contractual_ag"]=='')
		    $AcuerdoAg ="";
		else
		   	$AcuerdoAg ="Mes ".$Fila["acuerdo_contractual_ag"];
		if($Fila["acuerdo_contractual_au"]=='')
		    $AcuerdoAu ="";
		else
		    $AcuerdoAu ="Mes ".$Fila["acuerdo_contractual_au"];	
		if($Fila["acuerdo_contractual_otro"]=='')								
		    $Otro ="";
		else
		 	$Otro ="Mes ".$Fila["acuerdo_contractual_otro"];	
		$Vig =$Fila["nombre_subclase"];	
		$Des=$Fila["nom_cliente"];
		$Clave=$Fila["cod_contrato"];
		
		if($Rut=='-1')
		  $Rut=''; 		   
?>
  <tr>
    <td align="center"><? echo $Cod; ?></td>
    <td align="right">&nbsp;<? echo $Rut; ?></td>
    <td align="left"><? echo $NomProveedor."  ".$Des; ?>&nbsp;</td>
    <td align="left">&nbsp;<? echo $Pro; ?></td>
    <td align="left">&nbsp;<? echo $TipCon; ?></td>
    <td align="left">&nbsp;<? echo $Merc; ?></td>
    <td align="right">&nbsp;<? echo $Fecha; ?></td>
    <td align="right">&nbsp;<? echo $Dura; ?></td>
    <td align="right"><? echo $AcuerdoCu; ?>&nbsp;</td>
    <td align="right"><? echo $AcuerdoAg; ?>&nbsp;</td>
    <td align="right"><? echo $AcuerdoAu; ?>&nbsp;</td>
    <td align="right"><? echo $Otro; ?>&nbsp;</td>
    <td align="center">&nbsp;<? echo $Vig; ?></td>
  </tr>
  <?
	}
}	
?>
</table>
<br>
</form>
</body>
</html>
<?
	if($Mensaje=='S')
   {
?>
	<script language="javascript">
	alert("No se pueden Eliminar el dato, existen relaciones ")
	</script>
<? }?>
