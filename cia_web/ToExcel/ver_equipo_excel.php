<?php
header("Content-Type:  application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
include ("../../principal/conectar_principal.php");

$var=explode(";",$valor);
$cod_equipo=$var[0];
$tipo=$var[1];

//se recuperan los datos del equipo
$query="select * from hardware where codigo='".$cod_equipo."';";
$result=mysql_db_query("cia_web",$query,$link);
$info_equipo=mysql_fetch_array($result);
mysql_free_result($result);

//se recuperan los datos de la asociacion
$query="select fecha_inicio,cc_ubicacion,rut_usuario from asoc_equipos_usuarios where ";
if($tipo=="EQUIPO")
	$query.="nro_asoc=".$info_equipo["nro_asociacion_activa"].";";
else
	$query.="nro_asoc IN (select nro_asoc_eq_user from asoc_partes_equipos where nro_asoc=".$info_equipo["nro_asociacion_activa"].");";
$result=mysql_db_query("cia_web",$query,$link);
$info_asoc=mysql_fetch_array($result);
$foobar=mysql_num_rows($result);
mysql_free_result($result);

//se recuperan los datos de los equipos asociados
if($tipo=="EQUIPO")
{
	//recuperan todos las partes asociadas a el
	$query="select cod_parte as cod_equipo from asoc_partes_equipos where cod_equipo='".$info_equipo["codigo"]."'";
	$query.=" and estado_asoc=1";
}
else
{
	//se recupera el equipo al que esta asociado
	$query="select cod_equipo from asoc_partes_equipos where nro_asoc=".$info_equipo["nro_asociacion_activa"].";";
}
$result=mysql_db_query("cia_web",$query,$link);
?>
<html>
<body>
<table border="0">
<tr><td>
<table border="1" align="left">
  <tr> 
    <th bgcolor="#999999" align="center" colspan="2">INFORMACI&Oacute;N EQUIPO</th>
  </tr>
  <tr> 
    <td align="center" bgcolor="#CCCCCC"><strong>Codigo</strong></td>
    <td bgcolor="#E8FDD9" align="left">&nbsp;<?php echo $info_equipo["codigo"]?></td>
  </tr>
  <tr> 
    <td align="center" bgcolor="#CCCCCC"><strong>Tipo</strong></td>
    <td bgcolor="#E8FDD9" align="left">&nbsp; 
      <?php
	//se busca el tipo en la tabla sub_clase
	$var=substr($info_equipo["codigo"],0,3);
	$query="select nombre_subclase from sub_clase where cod_clase=18003 and valor_subclase1='".$var."';";
	$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
	$r_tmp=mysql_fetch_array($res_tmp);
	mysql_free_result($res_tmp);
	echo $r_tmp["nombre_subclase"]
	?>
    </td>
  </tr>
  <tr> 
    <td align="center" bgcolor="#CCCCCC"><strong>Marca</strong></td>
    <td bgcolor="#E8FDD9" align="left">&nbsp;<?php echo $info_equipo["marca"]?></td>
  </tr>
  <tr> 
    <td align="center" bgcolor="#CCCCCC"><strong>Modelo</strong></td>
    <td bgcolor="#E8FDD9" align="left">&nbsp;<?php echo $info_equipo["modelo"]?></td>
  </tr>
  <tr> 
    <td align="center" bgcolor="#CCCCCC"><strong>N&uacute;mero de Serie</strong></td>
    <td bgcolor="#E8FDD9" align="left">&nbsp;<?php echo $info_equipo["nro_serie"]?></td>
  </tr>
  <tr> 
    <?php
//se arregla la fecha de compra
$fecha=explode("-",$info_equipo["fecha_compra"]);
$fecha=$fecha[2]."-".$fecha[1]."-".$fecha[0];
?>
    <td align="center" bgcolor="#CCCCCC"><strong>Fecha Compra</strong></td>
    <td bgcolor="#E8FDD9" align="left">&nbsp;<?php echo $fecha?></td>
  </tr>
  <tr> 
    <td align="center" bgcolor="#CCCCCC"><strong>Periodo Garantia</strong></td>
    <td bgcolor="#E8FDD9" align="left">&nbsp;<?php echo $info_equipo["p_garantia"]?>&nbsp;&nbsp;Meses</td>
  </tr>
  <tr> 
    <td align="center" bgcolor="#CCCCCC"><strong>N&uacute;mero de Factura</strong></td>
    <td bgcolor="#E8FDD9" align="left">&nbsp;<?php echo $info_equipo["nro_factura"]?></td>
  </tr>
  <tr> 
    <td align="center" bgcolor="#CCCCCC"><strong>N&uacute;mero de Guia</strong></td>
    <td bgcolor="#E8FDD9" align="left">&nbsp;<?php echo $info_equipo["nro_guia"]?></td>
  </tr>
  <tr> 
    <td align="center" bgcolor="#CCCCCC"><strong>Cod Activo Fijo</strong></td>
    <td bgcolor="#E8FDD9" align="left">&nbsp;<?php echo $info_equipo["cod_activo_fijo"]?></td>
  </tr>
  <tr> 
    <td align="center" bgcolor="#CCCCCC"><strong>Proveedor</strong></td>
    <td bgcolor="#E8FDD9" align="left">&nbsp;
    <?php
	//se recupera la informacion del proveedor
	$query="select razon_social from proveedor where rut='".$info_equipo["rut_proveedor"]."';";
	$res_tmp=mysql_db_query("cia_web",$query,$link);
	$r_tmp=mysql_fetch_array($res_tmp);
	mysql_free_result($res_tmp);
	echo $r_tmp["razon_social"];
	?>
    </td>
  </tr>
  <tr> 
    <td align="center" bgcolor="#CCCCCC"><strong>Estado</strong></td>
    <td bgcolor="#E8FDD9" align="left">&nbsp; 
      <?php
	if($info_equipo["estado"]==1)
		echo "Asignado";
	if($info_equipo["estado"]==2)
		echo "Para Baja";
	if($info_equipo["estado"]==3)
		echo "De Baja";
	if($info_equipo["estado"]==4)
		echo "Disponible";
	?>
    </td>
  </tr>
  <tr> 
    <td align="center" bgcolor="#CCCCCC"><strong>Observaciones</strong></td>
    <td bgcolor="#E8FDD9" align="left">&nbsp;<?php echo $info_equipo["observaciones"];?></td>
  </tr>
  <?php
if(substr($info_equipo["codigo"],0,3)=="CMP" || substr($info_equipo["codigo"],0,3)=="NBK")
{
	//se recupera el detalle del equipo
	$query="select * from detalle_equipos where cod_equipo='".$info_equipo["codigo"]."';";
	$res_tmp=mysql_db_query("cia_web",$query,$link);
	$det_equipo=mysql_fetch_array($res_tmp);
	mysql_free_result($res_tmp);
	echo '
	<tr bgcolor="#CCCCCC"><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td align="center" bgcolor="#CCCCCC"><strong>Procesador</strong></td>
		<td bgcolor="#E8FDD9" align="left">&nbsp;'.$det_equipo["procesador"].'</td>
	</tr>
	<tr>
		<td align="center" bgcolor="#CCCCCC"><strong>Memoria Ram</strong></td>
		<td bgcolor="#E8FDD9" align="left">&nbsp;'.$det_equipo["ram"].'</td>
	</tr>
	<tr>
		<td align="center" bgcolor="#CCCCCC"><strong>Disco Duro</strong></td>
		<td bgcolor="#E8FDD9" align="left">&nbsp;'.$det_equipo["disco_duro"].'</td>
	</tr>
	<tr>
		<td align="center" bgcolor="#CCCCCC"><strong>Cantidad Seriales</strong></td>
		<td bgcolor="#E8FDD9" align="left">&nbsp;'.$det_equipo["cant_seriales"].'</td>
	</tr>
	<tr>
		<td align="center" bgcolor="#CCCCCC"><strong>Cantidad Paralelos</strong></td>
		<td bgcolor="#E8FDD9" align="left">&nbsp;'.$det_equipo["cant_paralelos"].'</td>
	</tr>';
	}
	?>
</table>
</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>

<!--   Tabla de Informe de Asociacion -->
<table border="1" align="left">
<tr>
	<th bgcolor="#999999" align="center" colspan="2">INFORMACI&Oacute;N ASOCIACI&Oacute;N</th>
</tr>
<?php
if($info_equipo["estado"]!=1 || !$foobar)
	echo '<tr bgcolor="#CCCCCC"><td colspan="2" align="center"><strong>Este equipo no ha sido Asignado a ningun Usuario</strong></td></tr>';
else
{
	echo '
	<tr>
		<td align="center" bgcolor="#CCCCCC"><strong>Fecha Inicio</strong></td>
		<td bgcolor="#E8FDD9" align="left">&nbsp;'.$info_asoc["fecha_inicio"].'</td>
	</tr>
	<tr>
		<td align="center" bgcolor="#CCCCCC"><strong>Ubicaci&oacute;n</strong></td>
		<td bgcolor="#E8FDD9" align="left">&nbsp;';
		//se recupera el centro de costo donde esta ubicado el equipo
		$query="select descripcion from centro_costo where centro_costo='".$info_asoc["cc_ubicacion"]."';";
		$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
		$r_tmp=mysql_fetch_array($res_tmp);
		mysql_free_result($res_tmp);
		echo $info_asoc["cc_ubicacion"].' - '.$r_tmp["descripcion"];
		echo
		'</td>
	</tr>
	<tr>
		<td align="center" bgcolor="#CCCCCC"><strong>Usuario</strong></td>
		<td bgcolor="#E8FDD9" align="left">&nbsp;';
		//se recupera la informacion del usuario
		$query="select APELLIDO_PATERNO,APELLIDO_MATERNO,NOMBRES from antecedentes_personales where";
		$query.=" RUT='".$info_asoc["rut_usuario"]."';";
		$res_tmp=mysql_db_query("bd_rrhh",$query,$link);
		$r_tmp=mysql_fetch_array($res_tmp);
		mysql_free_result($res_tmp);
		echo $r_tmp["APELLIDO_PATERNO"].' '.$r_tmp["APELLIDO_MATERNO"].' '.$r_tmp["NOMBRES"];
		echo '
		</td>
	</tr>';
}
?>
</table>
</td></tr>
<tr><td>
<tr><td>&nbsp;</td></tr>

<!--   Tabla de equipos asociados -->
<table border="1" align="left" width="100%">
<tr>
	<th bgcolor="#999999" align="center" colspan="5">
	<?php
	if($tipo=="EQUIPO")
		echo 'EQUIPOS ASOCIADOS';
	else
		echo 'EQUIPO ASOCIADO';
	?>
	</th>
</tr>
<?php 
if(!mysql_num_rows($result))	//no hay resultados
	echo '<tr bgcolor="#CCCCCC"><td colspan="5" align="center"><strong>No hay Equipos Asociados</strong></td></tr>';
else	//se muestran todos los equipos asociados
{
	?>
	<tr bgcolor="#CCCCCC">
		<th align="center">Codigo</th>
		<th align="center">Tipo</th>
		<th align="center">Marca</th>
		<th align="center">Modelo</th>
		<th align="center">Nro Serie</th>
	</tr>
	<?php
	while($resp=mysql_fetch_array($result))
	{
		echo '<tr bgcolor="#E8FDD9">';
		//se recupera informacion del equipo en base al codigo
		$query="select codigo,marca,modelo,nro_serie,nro_asociacion_activa from hardware where codigo='".$resp["cod_equipo"]."';";
		$res_tmp=mysql_db_query("cia_web",$query,$link);
		$r_tmp=mysql_fetch_array($res_tmp);
		mysql_free_result($res_tmp);
		//se recupera el tipo de equipo
		$var=substr($r_tmp["codigo"],0,3);
		$query="select nombre_subclase from sub_clase where cod_clase=18003 and valor_subclase1='".$var."';";
		$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
		$r=mysql_fetch_array($res_tmp);
		mysql_free_result($res_tmp);
		//se escribe la informacion
		echo '
		<td align="center">&nbsp;'.$r_tmp["codigo"].'</td>
		<td align="center">&nbsp;'.$r["nombre_subclase"].'</td>
		<td align="center">&nbsp;'.$r_tmp["marca"].'</td>
		<td align="center">&nbsp;'.$r_tmp["modelo"].'</td>
		<td align="center">&nbsp;'.$r_tmp["nro_serie"].'</td>';
	}
}
?>		
</table>
</td></tr>
</table>
</body>
</html>
