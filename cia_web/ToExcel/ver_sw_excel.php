<?php
header("Content-Type:  application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
include ("../../principal/conectar_principal.php");

//se recupera la informacion del software
$query="select * from software where codigo='".$codigo."';";
$result=mysql_db_query("cia_web",$query,$link);
$resp=mysql_fetch_array($result);
mysql_free_result($result);
?>
<html>
<body>
<table border="1" 1align="left">
<tr>
	<th bgcolor="#999999" align="center" colspan="2">IMFORMACI&Oacute;N SOFTWARE</th>
</tr>
<tr>
	<td align="center" bgcolor="#CCCCCC"><strong>Codigo</strong></td>
    <td bgcolor="#E8FDD9" align="left">&nbsp;<?php echo $resp["codigo"];?></td>
</tr>
<tr>
	<td align="center" bgcolor="#CCCCCC"><strong>Marca</strong></td>
	<td bgcolor="#E8FDD9" align="left">&nbsp;<?php echo $resp["marca"];?></td>
</tr>
<tr>
	<td align="center" bgcolor="#CCCCCC"><strong>Nombre</strong></td>
	<td bgcolor="#E8FDD9" align="left">&nbsp;<?php echo $resp["nombre"];?></td>
</tr>
<tr>
	<td align="center" bgcolor="#CCCCCC"><strong>Versi&oacute;n</strong></td>
	<td bgcolor="#E8FDD9" align="left">&nbsp;<?php echo $resp["version_sw"];?></td>
</tr>
<tr>
	<td align="center" bgcolor="#CCCCCC"><strong>Tipo</strong></td>
	<td bgcolor="#E8FDD9" align="left">&nbsp;<?php echo $resp["tipo"];?></td>
</tr>
<tr>
	<td align="center" bgcolor="#CCCCCC"><strong>Fecha Compra</strong></td>
	<td bgcolor="#E8FDD9" align="left">&nbsp;
	<?php 
	$fecha=explode("-",$resp["fecha_compra"]);
	$fecha=$fecha[2]."-".$fecha[1]."-".$fecha[0];
	echo $fecha;
	?>
	</td>
</tr>
<tr>
	<td align="center" bgcolor="#CCCCCC"><strong>N&uacute;mero de Factura</strong></td>
	<td bgcolor="#E8FDD9" align="left">&nbsp;<?php echo $resp["nro_factura"];?></td>
</tr>
<tr>
	<td align="center" bgcolor="#CCCCCC"><strong>Proveedor</strong></td>
	<td bgcolor="#E8FDD9" align="left">&nbsp;
	<?php
	//se recuperan el nombre del proveedor
	$query="select razon_social from proveedor where rut='".$resp["rut_proveedor"]."';";
	$res_tmp=mysql_db_query("cia_web",$query,$link);
	$r=mysql_fetch_array($res_tmp);
	mysql_free_result($res_tmp);
	echo $r["razon_social"];
	?>
	</td>
</tr>
<tr>
	<td align="center" bgcolor="#CCCCCC"><strong>Descripci&oacute;n</strong></td>
	<td bgcolor="#E8FDD9" align="left">&nbsp;<?php echo $resp["descripcion"];?></td>
</tr>
</table>
</body>
</html>
