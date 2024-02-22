<?php
header("Content-Type:  application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
include ("../../principal/conectar_principal.php");

//se recupera la informacion del equipó
$query="select marca,modelo,nro_serie from hardware where codigo='".$cod_equipo."';";
$result=mysql_db_query("cia_web",$query,$link);
$info_equipo=mysql_fetch_array($result);
mysql_free_result($result);

?>
<html>
<body>
<table>
<!--   Informacion del Equipo  -->
<tr>
<td align="left">
<table width="600" border="1" align="left" cellpadding="0" cellspacing="0">
<tr bgcolor="#999999">
	<th colspan="4" align="center">DATOS DEL EQUIPO</th>	
</tr>
<tr bgcolor="#CCCCCC">
	<th align="center" width="80">Codigo</th>
	<th align="center" width="200">Marca</th>
	<th align="center" width="200">Modelo</th>
	<th align="center" width="120">Nro Serie</th>
</tr>
<tr bgcolor="#E8FDD9">
	<td align="center">&nbsp;<?php echo $cod_equipo;?>&nbsp;</td>
	<td align="center">&nbsp;<?php echo $info_equipo["marca"];?>&nbsp;</td>
	<td align="center">&nbsp;<?php echo $info_equipo["modelo"];?>&nbsp;</td>
	<td align="center">&nbsp;<?php echo $info_equipo["nro_serie"];?>&nbsp;</td>
</tr>
</table>
</td>
</tr>
<tr><td>&nbsp;</td></tr>
<!-- Fallas -->
<tr>
<td>
<?php
switch($opcion)
{
	case "t_fallas":
		//se recuperan todas las fallas asociadas a este equipo
		$query="select * from historial_fallas where cod_equipo='".$cod_equipo."' order by fecha_inicio;";
		$result=mysql_db_query("cia_web",$query,$link);
		?>
		<table align="left" border="1" width="100%">
		<tr>
			<th align="center" colspan="5" bgcolor="#999999">HISTORIAL DE FALLAS</th>
		</tr>
		<tr bgcolor="#CCCCCC">
			<th align="center">Fecha Inicio</th>
			<th align="center">Fecha Termino</th>
			<th align="center">Duraci&oacute;n</th>
			<th align="center">Tipo de Tarea</th>
			<th align="center">Acci&oacute;n Realizada</th>
		</tr>
		<?php
		while($resp=mysql_fetch_array($result))
		{	
			echo '<tr bgcolor="#E8FDD9">';
			$fecha=explode("-",$resp["fecha_inicio"]);
			$fecha=$fecha[2]."-".$fecha[1]."-".$fecha[0];
			echo '<td align="center">&nbsp;'.$fecha.'</td>';
			$fecha=explode("-",$resp["fecha_termino"]);
			$fecha=$fecha[2]."-".$fecha[1]."-".$fecha[0];
			echo '<td align="center">&nbsp;'.$fecha.'</td>';
			echo '<td align="center">&nbsp;'.$resp["duracion"].'</td>';
			echo '<td align="center">&nbsp;'.$resp["tipo_tarea"].'</td>';
			echo '<td align="center">&nbsp;'.$resp["accion"].'</td>';
			echo '</tr>';
		}
		?>
		</table>
		<?php
		break;
		
	case "t_detalle":
		//se recupera el detalle completo de la falla
		$query="select * from historial_fallas where nro_falla='".$nro_falla."';";
		$result=mysql_db_query("cia_web",$query,$link);
		$r=mysql_fetch_array($result);
		mysql_free_result($result);
		//se recuperan los datos de la ubicacion del equipo
		if($r["nro_asoc_activa"]!=0)
		{
			$query="select cc_ubicacion from asoc_equipos_usuarios where ";
			if($r["tipo"]=="EQUIPO")
				$query.="nro_asoc=".$r["nro_asoc_activa"].";";
			else
				$query.="nro_asoc in (select nro_asoc_eq_user from asoc_partes_equipos where nro_asoc=".$r["nro_asoc_activa"].");";
			$res_tmp=mysql_db_query("cia_web",$query,$link);
			$r_tmp=mysql_fetch_array($res_tmp);
			mysql_free_result($res_tmp);
			//se recupera la descripcion del centro de costo
			$query="select descripcion from centro_costo where centro_costo='".$r_tmp["cc_ubicacion"]."';";
			$ubi=$r_tmp["cc_ubicacion"];
			$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
			$r_tmp=mysql_fetch_array($res_tmp);
			mysql_free_result($res_tmp);
			$ubi.=" - ".$r_tmp["descripcion"];
		}
		//se recuperan los datos del usuario
		if($r["nro_asoc_activa"]!=0)
		{
			$query="select APELLIDO_PATERNO,APELLIDO_MATERNO,NOMBRES,COD_CENTRO_COSTO from bd_rrhh.antecedentes_personales ";
			if($r["tipo"]=="EQUIPO")
				$query.="where RUT in (select rut_usuario from cia_web.asoc_equipos_usuarios where nro_asoc=".$r["nro_asoc_activa"].");";
			else
			{
				$query="where RUT in (select rut_usuario from cia_web.asoc_equipos_usuarios where nro_asoc in ";
				$query.="(select nro_asoc_eq_user from cia_web.asoc_partes_equipos where nro_asoc=".$r["nro_asoc_activa"]."));";
			}
			$res_tmp=mysql_query($query,$link);
			$r_tmp=mysql_fetch_array($res_tmp);
			mysql_free_result($res_tmp);
			$user=$r_tmp["APELLIDO_PATERNO"]." ".$r_tmp["APELLIDO_MATERNO"]." ".$r_tmp["NOMBRES"]."<br>";
			//se recupera la informacion del centro de costo del usuario
			$cc=substr($r_tmp["COD_CENTRO_COSTO"],3,5);
			$cc=explode(".",$cc);
			$cc=$cc[0].$cc[1];
			$query="select descripcion from centro_costo where centro_costo='".$cc."';";
			$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
			$r_tmp=mysql_fetch_array($res_tmp);
			mysql_free_result($res_tmp);
			//$user.="&nbsp;&nbsp;&nbsp;&nbsp;".$cc." - ".$r_tmp["descripcion"];
		}
		else
			$user="No esta asociado a ningun usuario";
		//se formatean las fechas
		$fecha=explode("-",$r["fecha_inicio"]);
		$fecha_inicio=$fecha[2]."-".$fecha[1]."-".$fecha[0];
		$fecha=explode("-",$r["fecha_termino"]);
		$fecha_termino=$fecha[2]."-".$fecha[1]."-".$fecha[0];
		?>
		<table align="left" border="1" width="100%">
		<tr>
			<th align="center" colspan="2" bgcolor="#999999">DETALLE DE LA FALLA</th>
		</tr>
		<tr>
			<td bgcolor="#CCCCCC" align="center"><strong>Nro Falla</strong></td>
			<td align="center" bgcolor="#E8FDD9">&nbsp;<?php echo $r["nro_falla"];?></td>
		</tr>
		<tr>
			<td bgcolor="#CCCCCC" align="center"><strong>Usuario</strong></td>
			<td align="center" bgcolor="#E8FDD9">&nbsp;<?php echo $user;?></td>
		</tr>
		<tr>
			<td bgcolor="#CCCCCC" align="center"><strong>Ubicaci&oacute;n</strong></td>
			<td align="center" bgcolor="#E8FDD9">&nbsp;<?php echo $ubi;?></td>
		</tr>
		<tr>
			<td bgcolor="#CCCCCC" align="center"><strong>Fecha Inicio</strong></td>
			<td align="center" bgcolor="#E8FDD9">&nbsp;<?php echo $fecha_inicio;?></td>
		</tr>
		<tr>
			<td bgcolor="#CCCCCC" align="center"><strong>Fecha Termino</strong></td>
			<td align="center" bgcolor="#E8FDD9">&nbsp;<?php echo $fecha_termino;?></td>
		</tr>
		<tr>
			<td bgcolor="#CCCCCC" align="center"><strong>Duraci&oacute;n</strong></td>
			<td align="center" bgcolor="#E8FDD9">&nbsp;<?php echo $r["duracion"];?></td>
		</tr>
		<tr>
			<td bgcolor="#CCCCCC" align="center"><strong>Tipo de Tarea</strong></td>
			<td align="center" bgcolor="#E8FDD9">&nbsp;<?php echo $r["tipo_tarea"];?></td>
		</tr>
		<tr>
			<td bgcolor="#CCCCCC" align="center"><strong>Acci&oacute;n Realizada</strong></td>
			<td align="center" bgcolor="#E8FDD9">&nbsp;<?php echo $r["accion"];?></td>
		</tr>
		<tr>
			<td bgcolor="#CCCCCC" align="center"><strong>Causa</strong></td>
			<td align="center" bgcolor="#E8FDD9">&nbsp;<?php echo $r["causa"];?></td>
		</tr>
		<tr>
			<td bgcolor="#CCCCCC" align="center"><strong>Descripcion del Trabajo</strong></td>
			<td align="center" bgcolor="#E8FDD9">&nbsp;<?php echo $r["d_trabajo"];?></td>
		</tr>
		<tr>
			<td bgcolor="#CCCCCC" align="center"><strong>Compra de Insumos</strong></td>
			<td align="center" bgcolor="#E8FDD9">&nbsp;<?php echo $r["compra_insumos"];?></td>
		</tr>
		</table>
		<?php
		break;
		
	case "historial_c":
		//se recuperan todas las fallas asociadas a este equipo
		$query="select * from historial_fallas where cod_equipo='".$cod_equipo."' order by fecha_inicio;";
		$result=mysql_db_query("cia_web",$query,$link);
		?>
		<table align="left" border="1" width="100%">
		<tr>
			<th align="center" colspan="11" bgcolor="#999999">HISTORIAL DE FALLAS DETALLADO</th>
		</tr>
		<tr bgcolor="#CCCCCC">
			<th align="center">Nro Falla</th>
			<th align="center">Usuario</th>
			<th align="center">Ubicaci&oacute;n</th>
			<th align="center">Fecha Inicio</th>
			<th align="center">Fecha Termino</th>
			<th align="center">Duraci&oacute;n</th>
			<th align="center">Tipo de Tarea</th>
			<th align="center">Acci&oacute;n Realizada</th>
			<th align="center">Causa</th>
			<th align="center">Descripci&oacute;n Trabajo</th>
			<th align="center">Compra de Insumos</th>
		</tr>
		<?php
		while($resp=mysql_fetch_array($result))
		{	
			echo '<tr bgcolor="#E8FDD9">';
			echo '<td align="center">&nbsp;'.$resp["nro_falla"].'</td>';
			//se recuperan los datos de la ubicacion del equipo
			if($resp["nro_asoc_activa"]!=0)
			{
				$query="select cc_ubicacion from asoc_equipos_usuarios where ";
				if($resp["tipo"]=="EQUIPO")
					$query.="nro_asoc=".$resp["nro_asoc_activa"].";";
				else
					$query.="nro_asoc in (select nro_asoc_eq_user from asoc_partes_equipos where nro_asoc=".$resp["nro_asoc_activa"].");";
				$res_tmp=mysql_db_query("cia_web",$query,$link);
				$r_tmp=mysql_fetch_array($res_tmp);
				mysql_free_result($res_tmp);
				//se recupera la descripcion del centro de costo
				$query="select descripcion from centro_costo where centro_costo='".$r_tmp["cc_ubicacion"]."';";
				$ubi=$r_tmp["cc_ubicacion"];
				$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
				$r_tmp=mysql_fetch_array($res_tmp);
				mysql_free_result($res_tmp);
				$ubi.=" - ".$r_tmp["descripcion"];
			}
			//se recuperan los datos del usuario
			if($resp["nro_asoc_activa"]!=0)
			{
				$query="select APELLIDO_PATERNO,APELLIDO_MATERNO,NOMBRES,COD_CENTRO_COSTO from bd_rrhh.antecedentes_personales ";
				if($resp["tipo"]=="EQUIPO")
					$query.="where RUT in (select rut_usuario from cia_web.asoc_equipos_usuarios where nro_asoc=".$resp["nro_asoc_activa"].");";
				else
				{
					$query="where RUT in (select rut_usuario from cia_web.asoc_equipos_usuarios where nro_asoc in ";
					$query.="(select nro_asoc_eq_user from cia_web.asoc_partes_equipos where nro_asoc=".$resp["nro_asoc_activa"]."));";
				}
				$res_tmp=mysql_query($query,$link);
				$r_tmp=mysql_fetch_array($res_tmp);
				mysql_free_result($res_tmp);
				$user=$r_tmp["APELLIDO_PATERNO"]." ".$r_tmp["APELLIDO_MATERNO"]." ".$r_tmp["NOMBRES"]."<br>";
				//se recupera la informacion del centro de costo del usuario
				$cc=substr($r_tmp["COD_CENTRO_COSTO"],3,5);
				$cc=explode(".",$cc);
				$cc=$cc[0].$cc[1];
				$query="select descripcion from centro_costo where centro_costo='".$cc."';";
				$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
				$r_tmp=mysql_fetch_array($res_tmp);
				mysql_free_result($res_tmp);
				//$user.="&nbsp;&nbsp;&nbsp;&nbsp;".$cc." - ".$r_tmp["descripcion"];
			}
			else
				$user="No esta asociado a ningun usuario";
		
			echo '<td align="center">&nbsp;'.$user.'</td>';
			echo '<td align="center">&nbsp;'.$ubi.'</td>';
			
			$fecha=explode("-",$resp["fecha_inicio"]);
			$fecha=$fecha[2]."-".$fecha[1]."-".$fecha[0];
			echo '<td align="center">&nbsp;'.$fecha.'</td>';
			$fecha=explode("-",$resp["fecha_termino"]);
			$fecha=$fecha[2]."-".$fecha[1]."-".$fecha[0];
			echo '<td align="center">&nbsp;'.$fecha.'</td>';
			echo '<td align="center">&nbsp;'.$resp["duracion"].'</td>';
			echo '<td align="center">&nbsp;'.$resp["tipo_tarea"].'</td>';
			echo '<td align="center">&nbsp;'.$resp["accion"].'</td>';
			echo '<td align="center">&nbsp;'.$resp["causa"].'</td>';
			echo '<td align="center">&nbsp;'.$resp["d_trabajo"].'</td>';
			echo '<td align="center">&nbsp;'.$resp["compra_insumos"].'</td>';
			echo '</tr>';
		}
		?>
		</table>
		<?php
		break;
}	
?>
</td>
</tr>
</table>
</body>
</html>
