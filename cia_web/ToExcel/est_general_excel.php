<?php
header("Content-Type:  application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
include ("../../principal/conectar_principal.php");
?>
<html>
<body>
<?php
//se obtiene las cantidades generales para los equipos y las partes segun los estados
$query="select count(codigo) as cant from hardware where tipo='EQUIPO' and estado=1 UNION ALL ";
$query.="select count(codigo) as cant from hardware where tipo='EQUIPO' and estado=2 UNION ALL ";
$query.="select count(codigo) as cant from hardware where tipo='EQUIPO' and estado=3 UNION ALL ";
$query.="select count(codigo) as cant from hardware where tipo='EQUIPO' and estado=4 UNION ALL ";
$query.="select count(codigo) as cant from hardware where tipo='PARTE' and estado=1 UNION ALL ";
$query.="select count(codigo) as cant from hardware where tipo='PARTE' and estado=2 UNION ALL ";
$query.="select count(codigo) as cant from hardware where tipo='PARTE' and estado=3 UNION ALL ";
$query.="select count(codigo) as cant from hardware where tipo='PARTE' and estado=4;";
$result=mysql_db_query("cia_web",$query,$link);

$total_eq=0;
$total_pt=0;
?>
<table border="1">
	<tr bgcolor="#999999">
		<th align="center" colspan="2"><strong>EQUIPOS</strong></th>
	</tr>
	<tr>
		<td align="center" bgcolor="#CCCCCC"><strong>Asignados</strong></td>
		<td align="center" bgcolor="#E8FDD9"><?php $resp=mysql_fetch_array($result); echo $resp["cant"]; $total_eq+=$resp["cant"];?></td>
	</tr>
	<tr>
		<td align="center" bgcolor="#CCCCCC"><strong>Para Baja</strong></td>
		<td align="center" bgcolor="#E8FDD9"><?php $resp=mysql_fetch_array($result); echo $resp["cant"]; $total_eq+=$resp["cant"];?></td>
	</tr>
	<tr>	
		<td align="center" bgcolor="#CCCCCC"><strong>De Baja</strong></td>
		<td align="center" bgcolor="#E8FDD9"><?php $resp=mysql_fetch_array($result); echo $resp["cant"]; $total_eq+=$resp["cant"];?></td>
	</tr>
	<tr>
		<td align="center" bgcolor="#CCCCCC"><strong>Disponibles</strong></td>
		<td align="center" bgcolor="#E8FDD9"><?php $resp=mysql_fetch_array($result); echo $resp["cant"]; $total_eq+=$resp["cant"];?></td>
	</tr>
	<tr>
		<td align="center" bgcolor="#CCCCCC"><strong>TOTAL</strong></td>
		<td align="center" bgcolor="#E8FDD9"><font color="#FF0000"><strong><?php echo $total_eq;?></strong></font></td>
	</tr>
</table>
<br>
<table border="1">
	<tr bgcolor="#999999">
		<th align="center" colspan="2"><strong>PARTES</strong></th>
	</tr>
	<tr>
		<td align="center" bgcolor="#CCCCCC"><strong>Asignados</strong></td>
		<td align="center" bgcolor="#E8FDD9"><?php $resp=mysql_fetch_array($result); echo $resp["cant"]; $total_pt+=$resp["cant"];?></td>
	</tr>
	<tr>
		<td align="center" bgcolor="#CCCCCC"><strong>Para Baja</strong></td>
		<td align="center" bgcolor="#E8FDD9"><?php $resp=mysql_fetch_array($result); echo $resp["cant"]; $total_ppt+=$resp["cant"];?></td>
	</tr>
	<tr>	
		<td align="center" bgcolor="#CCCCCC"><strong>De Baja</strong></td>
		<td align="center" bgcolor="#E8FDD9"><?php $resp=mysql_fetch_array($result); echo $resp["cant"]; $total_pt+=$resp["cant"];?></td>
	</tr>
	<tr>
		<td align="center" bgcolor="#CCCCCC"><strong>Disponibles</strong></td>
		<td align="center" bgcolor="#E8FDD9"><?php $resp=mysql_fetch_array($result); echo $resp["cant"]; $total_pt+=$resp["cant"];?></td>
	</tr>
	<tr>
		<td align="center" bgcolor="#CCCCCC"><strong>TOTAL</strong></td>
		<td align="center" bgcolor="#E8FDD9"><font color="#FF0000"><strong><?php echo $total_pt;?></strong></font></td>
	</tr>
</table>
<?php 
		mysql_free_result($result);
		if($total_eq!=0 && $total_pt!=0)
		{
?>
<br>
<table border="1" width="100%">
  <tr bgcolor="#999999"> 
    <td colspan="2" align="center"><strong>Detalle</strong></td>
  </tr>
  <tr> 
    <td bgcolor="#CCCC66" align="center" valign="middle"><strong>Tipo de Equipo</strong></td>
    <td> <table border="1" width="100%">
        <tr> 
			<td>&nbsp;</td>
          <td bgcolor="#CCCCCC" align="center">Total</td>
        </tr>
        <?php
				//se recuperan todos los tipos de equipos
				$query="select t1.nombre_subclase as nombre, count(t2.codigo) as cant ";
				$query.="from proyecto_modernizacion.sub_clase as t1, cia_web.hardware as t2";
				$query.=" where t1.cod_clase=18003 and t1.valor_subclase2='S' and ";
				$query.="t1.valor_subclase1 = left(t2.codigo,3) group by left(t2.codigo,3) ";
				$query.="order by t1.valor_subclase1;";
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
      </table></td>
  </tr>
  <tr> 
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr> 
    <td bgcolor="#CCCC66" align="center" valign="middle"><strong>Centro de Costo</strong></td>
    <td> <table border="1" width="100%">
        <tr> 
          <td>&nbsp;</td>
          <td bgcolor="#CCCCCC" align="center" width="50">Equipos</td>
          <td bgcolor="#CCCCCC" align="center" width="50">Partes</td>
        </tr>
        <?php
				//consulta para obtener la cantidad de equipos que posee cada centro de costo
				$query="select t1.centro_costo,t1.descripcion, count(t2.cc_ubicacion) as cant_equipos";
				$query.=" from proyecto_modernizacion.centro_costo as t1, cia_web.asoc_equipos_usuarios as t2";
				$query.=" where t1.centro_costo = t2.cc_ubicacion and t2.estado_asoc=1";
				$query.=" group by t1.centro_costo order by t1.descripcion;";
				$result_1=mysql_query($query,$link);
				
				//consulta para obtener la cantidad de partes que posee cada centro de costo
				$query="select t1.centro_costo,t1.descripcion, count(t3.nro_asoc_eq_user) as cant_partes";
				$query.=" from proyecto_modernizacion.centro_costo as t1, cia_web.asoc_equipos_usuarios";
				$query.=" as t2, cia_web.asoc_partes_equipos as t3 where t1.centro_costo = t2.cc_ubicacion";
				$query.=" and t2.estado_asoc=1 and t2.nro_asoc=t3.nro_asoc_eq_user and t3.estado_asoc=1";
				$query.=" group by t1.centro_costo order by t1.descripcion;";
				$result_2=mysql_query($query,$link);
				while($resp_1=mysql_fetch_array($result_1))
				{
					echo '<tr bgcolor="#E8FDD9">';
					echo '<td align="center">'.$resp_1["centro_costo"]." - ".$resp_1["descripcion"].'</td>';
					echo '<td align="center"><strong>'.$resp_1["cant_equipos"].'</strong></td>';
					$resp_2=mysql_fetch_array($result_2);
					echo '<td align="center"><strong>'.$resp_2["cant_partes"].'</strong></td>';
					echo '</tr>';
				}
				mysql_free_result($result_1);
				mysql_free_result($result_2);
				?>
      </table></td>
  </tr>
</table>
<?php }?>
</body>
</html>
