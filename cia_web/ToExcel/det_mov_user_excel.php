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
<!--   Informacion del Equipo  -->
<tr>
<td align="left">
<table width="600" border="1" align="left" cellpadding="0" cellspacing="0">
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
<!-- Movimientos -->

<tr>
	<td>
	<?php
	switch($opcion)
	{
		//table de historial resumida
		case "t_historial":
			//se recuperan los datos necesarios
			//se recuperan todos los equipos asociados al usuario
			$query="select * from asoc_equipos_usuarios where rut_usuario='".$rut_user."';";
			$result=mysql_db_query("cia_web",$query,$link);
			?>
			<table border="1" cellspacing="2" cellpadding="0" width="800" align="left">
			<tr bgcolor="#999999"><th colspan="8" align="center">HISTORIAL DE MOVIMIENTOS</th></tr>
			<tr bgcolor="#CCCCCC">
				<th align="center">Fecha Inicio</th>
				<th align="center">Fecha Termino</th>
				<th align="center">Ubicaci&oacute;n</th>
				<th align="center">Tipo</th>
				<th align="center">Marca</th>
				<th align="center">Modelo</th>
				<th align="center">Nro Serie</th>
				<th align="center">Estado Asociaci&oacute;n</th>
			</tr>
		<?php
		//se muestran los datos
		while($resp=mysql_fetch_array($result))
		{
			//se recuperan los datos del equipo
			$query="select marca,modelo,nro_serie from hardware where codigo='".$resp["cod_equipo"]."';";
			$res_tmp=mysql_db_query("cia_web",$query,$link);
			$r=mysql_fetch_array($res_tmp);
			mysql_free_result($res_tmp);
			
			echo '<tr bgcolor="#E8FDD9">';
			$fecha=explode("-",$resp["fecha_inicio"]);
			$fecha=$fecha[2]."-".$fecha[1]."-".$fecha[0];
			echo '<td align="center">'.$fecha.'</td>';
			$fecha=explode("-",$resp["fecha_termino"]);
			$fecha=$fecha[2]."-".$fecha[1]."-".$fecha[0];
			echo '<td align="center">'.$fecha.'</td>';
			//se recupera la informacion del centro de costo de ubicacion
			$query="select descripcion from centro_costo where centro_costo='".$resp["cc_ubicacion"]."';";
			$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
			$r_tmp=mysql_fetch_array($res_tmp);
			mysql_free_result($res_tmp);
			echo '<td align="center">'.$resp["cc_ubicacion"].' - '.$r_tmp["descripcion"].'</td>';
			echo '<td align="center">&nbsp;';
			//se recupera el tipo de equipo
			$tip=substr($resp["cod_equipo"],0,3);
			$query="select nombre_subclase as nom from sub_clase where valor_subclase1='".$tip."';";
			$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
			$r_tmp=mysql_fetch_array($res_tmp);
			echo $r_tmp["nom"].'</td>';
			echo '<td align="center">'.$r["marca"].'</td>';
			echo '<td align="center">'.$r["modelo"].'</td>';
			echo '<td align="center">'.$r["nro_serie"].'</td>';
			//se coloca la informacion de la asociacion
			echo '<td align="center">';
			if($resp["estado_asoc"]==1)
				echo 'Activa';
			else
				echo 'Terminada';
			echo '</td>';
		}
		?>
			</table>
			<?php
			break;
		
		//historial especifico con detalle
		case "t_detalle":
			//se recuperan los datos de la asociacion
			$query="select * from asoc_equipos_usuarios where nro_asoc=".$nro_asoc.";";
			$result=mysql_db_query("cia_web",$query,$link);
			$resp=mysql_fetch_array($result);
			
			//se preparan los datos para ser mostrados
			$var=explode("-",$resp["fecha_inicio"]);
			$fecha_inicio=$var[2]."-".$var[1]."-".$var[0];
			$var=explode("-",$resp["fecha_termino"]);
			$fecha_termino=$var[2]."-".$var[1]."-".$var[0];
			if($resp["estado_asoc"]==1)
				$estado='Activa';
			else
				$estado='Terminada';
			
			//se recuperan los datos del equipo
			$query="select marca,modelo,nro_serie from hardware where codigo='".$resp["cod_equipo"]."';";
			$res_tmp=mysql_db_query("cia_web",$query,$link);
			$r=mysql_fetch_array($res_tmp);
			mysql_free_result($res_tmp);
			$modelo=$r["modelo"];
			$marca=$r["marca"];
			$nro_serie=$r["nro_serie"];
			
			//se recupera la informacion de la ubicacion
			$query="select descripcion from centro_costo where centro_costo='".$resp["cc_ubicacion"]."';";
			$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
			$r=mysql_fetch_array($res_tmp);
			mysql_free_result($res_tmp);
			$ubicacion=$resp["cc_ubicacion"]." - ".$r["descripcion"];
			
			//se recupera el tipo de equipo
			$tip=substr($resp["cod_equipo"],0,3);
			$query="select nombre_subclase as nom from sub_clase where valor_subclase1='".$tip."';";
			$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
			$r_tmp=mysql_fetch_array($res_tmp);
			$tipo=$r_tmp["nom"];
			?>
			<table border="1" cellspacing="2" cellpadding="0" width="800" align="left">
			<tr bgcolor="#999999"><th colspan="8" align="center">DATOS DEL MOVIMIENTO</th></tr>
			<tr bgcolor="#CCCCCC">
				<th align="center">Fecha Inicio</th>
				<th align="center">Fecha Termino</th>
				<th align="center">Ubicaci&oacute;n</th>
				<th align="center">Tipo</th>
				<th align="center">Marca</th>
				<th align="center">Modelo</th>
				<th align="center">Nro Serie</th>
				<th align="center">Estado Asociaci&oacute;n</th>
			</tr>
			<tr bgcolor="#E8FDD9">
				<td align="center"><?php echo $fecha_inicio;?></td>
				<td align="center"><?php echo $fecha_termino;?></td>
				<td align="center"><?php echo $ubicacion;?></td>
				<td align="center"><?php echo $tipo;?></td>
				<td align="center"><?php echo $marca;?></td>
				<td align="center"><?php echo $modelo;?></td>
				<td align="center"><?php echo $nro_serie;?></td>
				<td align="center"><?php echo $estado;?></td>
			</tr>
			</table>
			</td></tr>
			<tr><td>&nbsp;</td></tr>
			<tr><td>
			<?php
			//se recupera el detalle de la asociacion
			$query="select * from asoc_partes_equipos where nro_asoc_eq_user=".$nro_asoc.";";
			$result_tmp=mysql_db_query("cia_web",$query,$link);
			?>
			<table border="1" cellspacing="2" cellpadding="0" width="800" align="left">
			<?php
			if(mysql_num_rows($result_tmp))
				{
					echo '<tr bgcolor="#999999"><th colspan="7" align="center">DETALLE EQUIPOS ASOCIADOS</th></tr>';
					echo'
					<tr bgcolor="#CCCCCC">
					<th width="80" align="center">Fecha Inicio</th>
					<th width="90" align="center">Fecha Termino</th>
					<th width="70" align="center">Tipo</th>
					<th width="170" align="center">Marca</th>
					<th width="170" align="center">Modelo</th>
					<th width="90" align="center">Nro. Serie</th>
					<th width="90" align="center">Estado</th>
					</tr>';
					while($resp_tmp=mysql_fetch_array($result_tmp))
					{
						echo '<tr bgcolor="#E8FDD9">';
						$var=explode("-",$resp_tmp["fecha_inicio"]);
						$fecha=$var[2]."-".$var[1]."-".$var[0];
						echo '<td align="center">'.$fecha.'</td>';
						$var=explode("-",$resp_tmp["fecha_termino"]);
						$fecha=$var[2]."-".$var[1]."-".$var[0];
						echo '<td align="center">'.$fecha.'</td>';
						echo '<td align="center">&nbsp;';
						//se recupera el tipo de equipo
						$tip=substr($resp_tmp["cod_parte"],0,3);
						$query="select nombre_subclase as nom from sub_clase where valor_subclase1='".$tip."';";
						$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
						$r_tmp=mysql_fetch_array($res_tmp);
						echo $r_tmp["nom"].'</td>';
						
						//se recupera la informacion de la parte
						$query="select marca,modelo,nro_serie from hardware where codigo='".$resp_tmp["cod_parte"]."';";
						$res_tmp=mysql_db_query("cia_web",$query,$link);
						$r=mysql_fetch_array($res_tmp);
						mysql_free_result($res_tmp);
						echo '<td align="center">'.$r["marca"].'</td>';
						echo '<td align="center">'.$r["modelo"].'</td>';
						echo '<td align="center">'.$r["nro_serie"].'</td>';
						//se coloca la informacion de la asociacion
						echo '<td align="center">';
						if($resp_tmp["estado_asoc"]==1)
							echo 'Activa';
						else
							echo 'Terminada';
						echo '</td>';
						echo '</tr>';
					}
			}
			else
				echo'<tr bgcolor="#CCCCCC"><td colspan="7" align="center"><strong>No hay Partes Asociadas en este Periodo</strong></td></tr>';
			echo '</table>';
			break;
			
		//historial completo detallado	
		case "historial_c":
			//se recuperan los datos necesarios
			$query="select * from asoc_equipos_usuarios where rut_usuario='".$rut_user."';";
			$result=mysql_db_query("cia_web",$query,$link);
			?>
			<table border="1">
			<tr bgcolor="#999999"><th colspan="15" align="center">HISTORIAL DE MOVIMIENTOS DETALLADO</th></tr>
			<tr bgcolor="#999999">
				<th align="center" colspan="8">MOVIMIENTO</th>
				<th align="center" colspan="7">PARTES ASOCIADAS</th>
			</tr>
			<tr bgcolor="#CCCCCC">
				<th align="center">Fecha Inicio</th>
				<th align="center">Fecha Termino</th>
				<th align="center">Ubicaci&oacute;n</th>
				<th align="center">Tipo</th>
				<th align="center">Marca</th>
				<th align="center">Modelo</th>
				<th align="center">Nro Serie</th>
				<th align="center">Estado Asociaci&oacute;n</th>
				<th align="center">Fecha Inicio</th>
				<th align="center">Fecha Termino</th>
				<th align="center">Tipo</th>
				<th align="center">Marca</th>
				<th align="center">Modelo</th>
				<th align="center">Nro Serie</th>
				<th align="center">Estado Asociaci&oacute;n</th>
			</tr>
			<?php
			while($resp=mysql_fetch_array($result))
			{
				echo '<tr bgcolor="#E8FDD9">';
				$var=explode("-",$resp["fecha_inicio"]);
				$fecha=$var[2]."-".$var[1]."-".$var[0];
				echo '<td bgcolor="#CCCC66" align="center">'.$fecha.'</td>';
				$var=explode("-",$resp["fecha_termino"]);
				$fecha=$var[2]."-".$var[1]."-".$var[0];
				echo '<td bgcolor="#CCCC66" align="center">'.$fecha.'</td>';
				//se recupera la informacion del centro de costo de ubicacion
				$query="select descripcion from centro_costo where centro_costo='".$resp["cc_ubicacion"]."';";
				$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
				$r=mysql_fetch_array($res_tmp);
				mysql_free_result($res_tmp);
				echo '<td bgcolor="#CCCC66" align="center">'.$resp["cc_ubicacion"].' - '.$r["descripcion"].'</td>';
				//se recuperan los datos del equipo
				$query="select marca,modelo,nro_serie from hardware where codigo='".$resp["cod_equipo"]."';";
				$res_tmp=mysql_db_query("cia_web",$query,$link);
				$r=mysql_fetch_array($res_tmp);
				mysql_free_result($res_tmp);
				echo '<td align="center" bgcolor="#CCCC66">&nbsp;';
				//se recupera el tipo de equipo
				$tip=substr($resp["cod_equipo"],0,3);
				$query="select nombre_subclase as nom from sub_clase where valor_subclase1='".$tip."';";
				$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
				$r_tmp=mysql_fetch_array($res_tmp);
				echo $r_tmp["nom"].'</td>';
				echo '<td bgcolor="#CCCC66" align="center">'.$r["marca"].'</td>';
				echo '<td bgcolor="#CCCC66" align="center">'.$r["modelo"].'</td>';
				echo '<td bgcolor="#CCCC66" align="center">'.$r["nro_serie"].'</td>';
				//se coloca la informacion de la asociacion
				echo '<td bgcolor="#CCCC66" align="center">';
				if($resp["estado_asoc"]==1)
					echo 'Activa';
				else
					echo 'Terminada';
				echo '</td>';	
				//se recupera la informacion de las partes asociadas
				$query="select * from asoc_partes_equipos where nro_asoc_eq_user=".$resp["nro_asoc"].";";
				$res_tmp=mysql_db_query("cia_web",$query,$link);
				$cant=mysql_num_rows($res_tmp);
				if(!$cant)
					echo '<td align="center" colspan="7">No hay equipos Asociados en este periodo</td>';
				else
				{	
					$i=0;
					while($resp_tmp=mysql_fetch_array($res_tmp))
					{
						$var=explode("-",$resp_tmp["fecha_inicio"]);
						$fecha=$var[2]."-".$var[1]."-".$var[0];
						echo '<td align="center">'.$fecha.'</td>';
						$var=explode("-",$resp_tmp["fecha_termino"]);
						$fecha=$var[2]."-".$var[1]."-".$var[0];
						echo '<td align="center">'.$fecha.'</td>';
						echo '<td align="center">&nbsp;';
						//se recupera el tipo de equipo
						$tip=substr($resp_tmp["cod_parte"],0,3);
						$query="select nombre_subclase as nom from sub_clase where valor_subclase1='".$tip."';";
						$result_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
						$r_tmp=mysql_fetch_array($result_tmp);
						echo $r_tmp["nom"].'</td>';
						//se recupera la informacion de la parte
						$query="select marca,modelo,nro_serie from hardware where codigo='".$resp_tmp["cod_parte"]."';";
						$r_tmp=mysql_db_query("cia_web",$query,$link);
						$r=mysql_fetch_array($r_tmp);
						mysql_free_result($r_tmp);
						echo '<td align="center">'.$r["marca"].'</td>';
						echo '<td align="center">'.$r["modelo"].'</td>';
						echo '<td align="center">'.$r["nro_serie"].'</td>';
						//se coloca la informacion de la asociacion
						echo '<td align="center">';
						if($resp_tmp["estado_asoc"]==1)
							echo 'Activa';
						else
							echo 'Terminada';
						$i++;
						if($i!=$cant)
						{
							echo '</tr>';
							echo '<tr bgcolor="#E8FDD9">';
							echo '<td colspan="8" bgcolor="#FFFFFF">&nbsp;</td>';
						}
					}
					mysql_free_result($res_tmp);
				}
			}
			echo '</table>';
			break;
	}
	?>

	</td>
</tr>
</table>
</body>
</html>
