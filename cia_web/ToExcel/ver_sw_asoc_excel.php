<?php
header("Content-Type:  application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
include ("../../principal/conectar_principal.php");

//se recuperan los datos del equipo
$query="select marca,modelo,nro_serie from hardware where codigo='".$cod_equipo."';";
$result=mysql_db_query("cia_web",$query,$link);
$info_equipo=mysql_fetch_array($result);
mysql_free_result($result);

//se recuperan los sw asociados
$query="select * from asoc_sw_equipo where cod_equipo='".$cod_equipo."';";
$result=mysql_db_query("cia_web",$query,$link);
?>
<html>
<body>
<table>
<tr>
<td align="left">
<table width="500" border="1" align="left" cellpadding="0" cellspacing="0">
<tr bgcolor="#999999">
	      <th colspan="4" align="center">DATOS DEL EQUIPO</th>	
</tr>
<tr bgcolor="#CCCCCC">
	<th align="center">Codigo</th>
	<th align="center">Marca</th>
	<th align="center">Modelo</th>
	<th align="center">Nro Serie</th>
</tr>
<tr bgcolor="#E8FDD9">
	<td align="center"><? echo $cod_equipo;?></td>
	<td align="center"><? echo $info_equipo["marca"];?></td>
	<td align="center"><? echo $info_equipo["modelo"];?></td>
	<td align="center"><? echo $info_equipo["nro_serie"];?></td>
</tr>
</table>
</td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr>
<td>
<table width="500" border="1" align="left" cellpadding="0" cellspacing="0">
<tr bgcolor="#999999">
	<th colspan="4" align="center">SOFTWARES ASOCIADOS</th>
</tr>
  <tr bgcolor="#CCCCCC"> 
    <th align="center">Codigo</th>
	<th align="center">Nombre</th>
	<th align="center">Version</th>
	<th align="center">Fecha Asociacion</th>
</tr>
<?php

while($resp=mysql_fetch_array($result))
{
	echo '<tr bgcolor="#E8FDD9">';
	//se recupera info del sw
	$query="select nombre,version_sw from software where codigo='".$resp["cod_sw"]."';";
	$res_tmp=mysql_db_query("cia_web",$query,$link);
	$r=mysql_fetch_array($res_tmp);
	echo '<td align="center">'.$resp["cod_sw"].'</td>';
	echo '<td align="center">&nbsp;'.$r["nombre"].'</td>';
	echo '<td align="center">&nbsp;'.$r["version_sw"].'</td>';
	echo '<td align="center">&nbsp;'.$resp["fecha"].'</td>';
	echo '</tr>';
}
?>
</table>
</td></tr>
</table>
</body>
</html>
