<?php
header("Content-Type:  application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
include ("../../principal/conectar_principal.php");

$cc=substr($centro_costo,0,4);

//se recupera la cantidad total de equipos asignados al centro de costo
$query="select count(t1.codigo) as cant from hardware as t1, asoc_equipos_usuarios as t2 ";
$query.="where t1.tipo='EQUIPO' and t1.codigo=t2.cod_equipo and t2.estado_asoc=1 and t2.cc_ubicacion='".$cc."';";
$result=mysql_db_query("cia_web",$query,$link);
$resp=mysql_fetch_array($result);
mysql_free_result($result);
$total_eq_asig=$resp["cant"];

$query="select count(t1.codigo) as cant from hardware as t1, asoc_equipos_usuarios as t2, asoc_partes_equipos as t3 ";
$query.="where t1.tipo='PARTE' and t1.codigo=t3.cod_parte and t3.estado_asoc=1 and t2.nro_asoc=t3.nro_asoc_eq_user and t2.cc_ubicacion='".$cc."';";
$result=mysql_db_query("cia_web",$query,$link);
$resp=mysql_fetch_array($result);
mysql_free_result($result);
$total_pt_asig=$resp["cant"];
?>
<html>
<body>
<table border="1">
<tr>
	<td align="center" bgcolor="#999999"><strong>Centro de Costo:</strong></td>
	<td align="center" bgcolor="#E8FDD9"><?php echo $centro_costo;?></td>
</tr>
</table>
<br>
<table border="1">
<tr>
	<td align="center" bgcolor="#CCCCCC"><strong>Total Equipos Asignados</strong></td>
	<td align="center" bgcolor="#E8FDD9"><font color="#FF0000"><strong><?php echo $total_eq_asig;?></strong></font></td>
</tr>
<tr>
	<td align="center" bgcolor="#CCCCCC"><strong>Total Partes Asignadas</strong></td>
	<td align="center" bgcolor="#E8FDD9"><font color="#FF0000"><strong><?php echo $total_pt_asig;?></strong></font></td>
</tr>
</table>
<br>
<?php
if($total_eq_asig!=0 && $total_pt_asig!=0)
{
?>				
<table border="1">
<tr> 
	<td  colspan="2" bgcolor="#999999" align="center"><strong>DETALLE</strong></td>
</tr>
<tr> 
	<td align="center" valign="middle" bgcolor="#CCCC66"><strong>Tipo de Equipo</strong></td>
    <td> 
	<table border="1" width="100%">
    <tr> 
	    <td>&nbsp;</td>
        <td bgcolor="#CCCCCC" align="center">Total</td>
   </tr>
   <?php
	//se recuperan todos los tipos de equipos
	$query="select t1.nombre_subclase as nombre, count(t2.codigo) as cant ";
	$query.="from proyecto_modernizacion.sub_clase as t1, cia_web.hardware as t2,";
	$query.=" cia_web.asoc_equipos_usuarios as t3 where  t1.cod_clase=18003 and t1.valor_subclase1 = left(t2.codigo,3) ";
	$query.="and t2.codigo=t3.cod_equipo and t3.cc_ubicacion='".$cc."' and t3.estado_asoc=1 ";
	$query.="group by left(t2.codigo,3) UNION ALL ";
	$query.="select t1.nombre_subclase as nombre, count(t2.codigo) as cant ";
	$query.="from proyecto_modernizacion.sub_clase as t1, cia_web.hardware as t2, cia_web.asoc_equipos_usuarios as t3, ";
	$query.="cia_web.asoc_partes_equipos as t4 where t1.cod_clase=18003 and t1.valor_subclase1 = left(t2.codigo,3) ";
	$query.="and t2.codigo=t4.cod_parte and t4.estado_asoc=1 and t3.nro_asoc=t4.nro_asoc_eq_user ";
	$query.="and t3.cc_ubicacion='".$cc."' group by left(t2.codigo,3);";
						
	$result=mysql_db_query("proyecto_modernizacion",$query,$link);
	while($resp=mysql_fetch_array($result))
	{
		echo '<tr bgcolor="#E8FDD9">';
		echo '<td align="center">'.$resp["nombre"].'</td>';
		echo '<td align="center"><strong>'.$resp["cant"].'</strong></td>';
		echo '</tr>';
	}
	mysql_free_result($result);
	?>
    </table>
	</td>
</tr>
</table>
<?php }?>
</body>
</html>
