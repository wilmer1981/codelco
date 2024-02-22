<?php
header("Content-Type:  application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
include ("../../principal/conectar_principal.php");

$var=explode(";",$valor);
$cod=$var[0];

//se recupera la informacion del usuario
//$query="select * from antecedentes_personales where RUT='".$rut."';";
//$result=mysql_db_query("bd_rrhh",$query,$link);
//$resp=mysql_fetch_array($result);
//mysql_free_result($result);
$query="select * from bd_rrhh.antecedentes_personales t1 , cia_web.asoc_equipos_usuarios t2 where cod_equipo= '".$cod."' and t1.RUT= t2.rut_usuario;";
$result=mysql_query($query,$link);
$resp=mysql_fetch_array($result);
mysql_free_result($result);

//se recupera la informacion del centro de costo
$var=substr($resp["COD_CENTRO_COSTO"],3,5);
$var=explode(".",$var);
$cc=$var[0].$var[1];
$query="select descripcion from centro_costo where centro_costo='".$cc."';";
$result=mysql_db_query("proyecto_modernizacion",$query,$link);
$resp_tmp=mysql_fetch_array($result);
mysql_free_result($result);
$cc=$cc." - ".$resp_tmp["descripcion"];
?>
<html>
<body>
<table border="1" align="left">
<tr>
    <th bgcolor="#999999" align="center" colspan="2">INFORMACI&Oacute;N USUARIO</th>
</tr>
<tr>
	<td align="center" bgcolor="#CCCCCC"><strong>Rut</strong></td>
    <td bgcolor="#E8FDD9" align="left">&nbsp;<?php echo $resp["RUT"];?></td>
</tr>
<tr>
    <td align="center" bgcolor="#CCCCCC"><strong>Nombres</strong></td>
    <td bgcolor="#E8FDD9" align="left">&nbsp;<?php echo $resp["NOMBRES"];?> </td>
</tr>
<tr>
	<td align="center" bgcolor="#CCCCCC"><strong>Apellido Paterno</strong></td>
	<td bgcolor="#E8FDD9" align="left">&nbsp;<?php echo $resp["APELLIDO_PATERNO"];?> </td>
</tr>
<tr>
	<td align="center" bgcolor="#CCCCCC"><strong>Apellido Materno</strong></td>
	<td bgcolor="#E8FDD9" align="left">&nbsp;<?php echo $resp["APELLIDO_MATERNO"];?> </td>
</tr>
<tr>
	<td align="center" bgcolor="#CCCCCC"><strong>Centro de Costo</strong></td>
	<td bgcolor="#E8FDD9" align="left">&nbsp;<?php echo $cc;?></td>
</tr>
</table>
</body>
</html>
