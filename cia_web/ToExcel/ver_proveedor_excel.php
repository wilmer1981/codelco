<?php
header("Content-Type:  application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
include ("../../principal/conectar_principal.php");

$var=explode(";",$valor);
$cod=$var[0];

//se recupera la informacion del proveedor
$query="select * from proveedor, hardware where codigo= '".$cod."'and rut_proveedor = rut;";
$result=mysql_db_query("cia_web",$query,$link);
$resp=mysql_fetch_array($result);
mysql_free_result($result);

?>
<html>
<body>
<table border="1" align="left">
<tr>
	<th bgcolor="#999999" align="center" colspan="2">INFORMACI&Oacute;N PROVEEDOR</th>
</tr>
<tr>
	<td align="center" bgcolor="#CCCCCC"><strong>Rut</strong></td>
	<td bgcolor="#E8FDD9" align="left">&nbsp;<?php echo $resp["rut"];?></td>
</tr>
<tr>
	<td align="center" bgcolor="#CCCCCC"><strong>Raz&oacute;n Social</strong></td>
	<td bgcolor="#E8FDD9" align="left">&nbsp;<?php echo $resp["razon_social"];?></td>
</tr>
<tr>
	<td align="center" bgcolor="#CCCCCC"><strong>Nombre Fantasia</strong></td>
	<td bgcolor="#E8FDD9" align="left">&nbsp;<?php echo $resp["nombre_fantasia"];?></td>
</tr>
<tr>
	<td align="center" bgcolor="#CCCCCC"><strong>Contacto 1</strong></td>
	<td bgcolor="#E8FDD9" align="left">&nbsp;<?php echo $resp["contacto_1"];?></td>
</tr>
<tr>
	<td align="center" bgcolor="#CCCCCC"><strong>Fono 1</strong></td>
	<td bgcolor="#E8FDD9" align="left">&nbsp;<?php echo $resp["fono_1"];?></td>
</tr>
<tr>
	<td align="center" bgcolor="#CCCCCC"><strong>Contacto 2</strong></td>
	<td bgcolor="#E8FDD9" align="left">&nbsp;<?php echo $resp["contacto_2"];?></td>
</tr>
<tr>
	<td align="center" bgcolor="#CCCCCC"><strong>Fono 2</strong></td>
	<td bgcolor="#E8FDD9" align="left">&nbsp;<?php echo $resp["fono_2"];?></td>
</tr>
<tr>
	<td align="center" bgcolor="#CCCCCC"><strong>Fax</strong></td>
	<td bgcolor="#E8FDD9" align="left">&nbsp;<?php echo $resp["fax"];?></td>
</tr>
</table>
</body>
</html>
