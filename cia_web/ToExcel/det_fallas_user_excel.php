<?php
header("Content-Type:  application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
include ("../../principal/conectar_principal.php");

//se recuperan los datos del usuario
$query="select NOMBRES as nom,APELLIDO_PATERNO as pat, APELLIDO_MATERNO as mat, COD_CENTRO_COSTO as cc ";
$query.="from antecedentes_personales where rut='".$rut_user."';";
$res_tmp=mysql_db_query("bd_rrhh",$query,$link);
$info_user=mysql_fetch_array($res_tmp);
mysql_free_result($res_tmp);

//se recupera el nombre del centro de costo al cual pertenece el usuario
$cc=explode(".",substr($info_user["cc"],3,5));
$cc=$cc[0].$cc[1];
$query="select descripcion from centro_costo where centro_costo='".$cc."';";
$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
$r=mysql_fetch_array($res_tmp);
$cc.=" - ".$r["descripcion"];
?>
<html>
<body>
<table>
<!--   Informacion del usuario  -->
<tr>
<td>
<table border="1">
<tr bgcolor="#999999">
	<th colspan="5" align="center">DATOS DEL USUARIO</th>	
</tr>
<tr bgcolor="#CCCCCC">
	<th align="center">Rut</th>
	<th align="center">Nombres</th>
	<th align="center">Apellido Paterno</th>
	<th align="center">Apellido Materno</th>
	<th align="center">Centro de Costo</th>
</tr>
<tr bgcolor="#E8FDD9">
	<td align="center">&nbsp;<?php echo $rut_user;?>&nbsp;</td>
	<td align="center">&nbsp;<?php echo $info_user["nom"];?>&nbsp;</td>
	<td align="center">&nbsp;<?php echo $info_user["pat"];?>&nbsp;</td>
	<td align="center">&nbsp;<?php echo $info_user["mat"];?>&nbsp;</td>
	<td align="center">&nbsp;<?php echo $cc;?>&nbsp;</td>
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
		
		//se recuperan todas las fallas asociadas a este usuario
		$query="select nro_falla,fecha_inicio,fecha_termino,tipo_tarea,accion,cod_equipo from historial_fallas";
		$query.=" where nro_asoc_activa IN (select nro_asoc from asoc_equipos_usuarios where ";
		$query.="rut_usuario='".$rut_user."') order by fecha_inicio;";
		$result=mysql_db_query("cia_web",$query,$link);
		?>
		<table border="1">
		<tr>
			<th align="center" colspan="8" bgcolor="#999999">HISTORIAL DE FALLAS</th>
		</tr>
		<tr bgcolor="#CCCCCC">
			<th align="center">Fecha Inicio</th>
			<th align="center">Fecha Termino</th>
			<th align="center">Tipo</th>
			<th align="center">Marca</th>
			<th align="center">Modelo</th>
			<th align="center">Nro Serie</th>
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
			//se recuperan los datos del equipo
			$query="select marca,modelo,nro_serie from hardware where codigo='".$resp["cod_equipo"]."';";
			$res_tmp=mysql_db_query("cia_web",$query,$link);
			$re=mysql_fetch_array($res_tmp);
			mysql_free_result($res_tmp);
			echo '<td align="center">&nbsp;';
			//se recupera el tipo de equipo
			$tip=substr($resp["cod_equipo"],0,3);
			$query="select nombre_subclase as nom from sub_clase where valor_subclase1='".$tip."';";
			$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
			$r_tmp=mysql_fetch_array($res_tmp);
			echo $r_tmp["nom"].'</td>';
			echo '<td align="center">&nbsp;'.$re["marca"].'</td>';
			echo '<td align="center">&nbsp;'.$re["modelo"].'</td>';
			echo '<td align="center">&nbsp;'.$re["nro_serie"].'</td>';
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
		$duracion=$r["duracion"];
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
		//se formatean las fechas
		$fecha=explode("-",$r["fecha_inicio"]);
		$fecha_inicio=$fecha[2]."-".$fecha[1]."-".$fecha[0];
		$fecha=explode("-",$r["fecha_termino"]);
		$fecha_termino=$fecha[2]."-".$fecha[1]."-".$fecha[0];
		
		//se recupera la informacion del equipo
		
		//se recupera el tipo de equipo
		$tip=substr($r["cod_equipo"],0,3);
		$query="select nombre_subclase as nom from sub_clase where valor_subclase1='".$tip."';";
		$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
		$r_tmp=mysql_fetch_array($res_tmp);
		$tipo=$r_tmp["nom"];
		$query="select marca,modelo,nro_serie from hardware where codigo='".$r["cod_equipo"]."';";
		$res_tmp=mysql_db_query("cia_web",$query,$link);
		$re=mysql_fetch_array($res_tmp);
		mysql_free_result($res_tmp);
		?>
		<table border="1">
		<tr>
			<th align="center" colspan="2" bgcolor="#999999">DETALLE DE LA FALLA</th>
		</tr>
		<tr>
			<td bgcolor="#CCCCCC" align="center"><strong>Nro Falla</strong></td>
			<td align="center" bgcolor="#E8FDD9">&nbsp;<?php echo $r["nro_falla"];?></td>
		</tr>
		<tr>
			<td bgcolor="#CCCCCC" align="center"><strong>Ubicaci&oacute;n</strong></td>
			<td align="center" bgcolor="#E8FDD9">&nbsp;<?php echo $ubi;?></td>
		</tr>
		<tr>
			<td bgcolor="#CCCCCC" align="center"><strong>Tipo</strong></td>
			<td align="center" bgcolor="#E8FDD9">&nbsp;<?php echo $tipo?></td>
		</tr>
		<tr>
			<td bgcolor="#CCCCCC" align="center"><strong>Marca</strong></td>
			<td align="center" bgcolor="#E8FDD9">&nbsp;<?php echo $re["marca"];?></td>
		</tr>
		<tr>
			<td bgcolor="#CCCCCC" align="center"><strong>Modelo</strong></td>
			<td align="center" bgcolor="#E8FDD9">&nbsp;<?php echo $re["modelo"];?></td>
		</tr>
		<tr>
			<td bgcolor="#CCCCCC" align="center"><strong>Nro Serie</strong></td>
			<td align="center" bgcolor="#E8FDD9">&nbsp;<?php echo $re["nro_serie"];?></td>
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
		//se recuperan todas las fallas asociadas a este usuario
		$query="select * from historial_fallas";
		$query.=" where nro_asoc_activa IN (select nro_asoc from asoc_equipos_usuarios where ";
		$query.="rut_usuario='".$rut_user."') order by fecha_inicio;";
		$result=mysql_db_query("cia_web",$query,$link);
		
		?>
		<table border="1">
		<tr>
			<th align="center" colspan="14" bgcolor="#999999">HISTORIAL DE FALLAS DETALLADO</th>
		</tr>
		<tr bgcolor="#CCCCCC">
			<th align="center">Nro Falla</th>
			<th align="center">Ubicaci&oacute;n</th>
			<th align="center">Tipo</th>
			<th align="center">Marca</th>
			<th align="center">Modelo</th>
			<th align="center">Nro Serie</th>
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
			
			echo '<td align="center">&nbsp;'.$ubi.'</td>';
			
			//se recupera la informacion del equipo
			$cod_equipo=$resp["cod_equipo"];
			$tip=substr($cod_equipo,0,3);
			$query="select nombre_subclase as nom from sub_clase where valor_subclase1='".$tip."';";
			$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
			$r_tmp=mysql_fetch_array($res_tmp);
			$tipo=$r_tmp["nom"];
			$query="select marca,modelo,nro_serie from hardware where codigo='".$cod_equipo."';";
			$res_tmp=mysql_db_query("cia_web",$query,$link);
			$info_equipo=mysql_fetch_array($res_tmp);
			mysql_free_result($res_tmp);
			echo '<td align="center">&nbsp;'.$tipo.'</td>';
			echo '<td align="center">&nbsp;'.$info_equipo["marca"].'</td>';
			echo '<td align="center">&nbsp;'.$info_equipo["modelo"].'</td>';
			echo '<td align="center">&nbsp;'.$info_equipo["nro_serie"].'</td>';
			
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
