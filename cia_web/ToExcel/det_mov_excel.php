<?php
header("Content-Type:  application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
include ("../../principal/conectar_principal.php");

$var=explode(";",$valor);
$cod=$var[0];
$tipo=$var[1];
//se recupera la informacion del equipó
$query="select marca,modelo,nro_serie from hardware where codigo='".$cod."';";
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
	<td align="center">&nbsp;<?php echo $cod;?>&nbsp;</td>
	<td align="center">&nbsp;<?php echo $info_equipo["marca"];?>&nbsp;</td>
	<td align="center">&nbsp;<?php echo $info_equipo["modelo"];?>&nbsp;</td>
	<td align="center">&nbsp;<?php echo $info_equipo["nro_serie"];?>&nbsp;</td>
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
			if($tipo=="EQUIPO")
				$query="select * from asoc_equipos_usuarios where cod_equipo='".$cod."' order by fecha_inicio;";
			else
				$query="select * from asoc_partes_equipos where cod_parte='".$cod."' and nro_asoc_eq_user <> 0 order by fecha_inicio;";
			$result=mysql_db_query("cia_web",$query,$link);
			?>
			<table border="1" cellspacing="2" cellpadding="0" width="800" align="left">
			<tr bgcolor="#999999"><th colspan="5" align="center">HISTORIAL DE MOVIMIENTOS</th></tr>
			<tr bgcolor="#CCCCCC">
				<th width="100" align="center">Fecha Inicio</th>
				<th width="110" align="center">Fecha Termino</th>
				<th width="220" align="center">Ubicaci&oacute;n</th>
				<th width="220" align="center">Usuario</th>
				<th width="130" align="center">Estado Asociaci&oacute;n</th>
			</tr>
			<?php
		/*************************************** EQUIPOS ****************************************/
		if($tipo=="EQUIPO")
		{
		while($resp=mysql_fetch_array($result))
		{
			echo '<tr bgcolor="#E8FDD9">';
			$var=explode("-",$resp["fecha_inicio"]);
			$fecha=$var[2]."-".$var[1]."-".$var[0];
			echo '<td align="center">&nbsp;'.$fecha.'</td>';
			$var=explode("-",$resp["fecha_termino"]);
			$fecha=$var[2]."-".$var[1]."-".$var[0];
			echo '<td align="center">&nbsp;'.$fecha.'</td>';
			//se recupera la informacion del centro de costo de ubicacion
			$query="select descripcion from centro_costo where centro_costo='".$resp["cc_ubicacion"]."';";
			$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
			$r=mysql_fetch_array($res_tmp);
			mysql_free_result($res_tmp);
			echo '<td align="center">&nbsp;'.$resp["cc_ubicacion"].' - '.$r["descripcion"].'</td>';
			//se recupera la informacion del usuario
			$query="select APELLIDO_PATERNO as ap_p,APELLIDO_MATERNO as ap_m,NOMBRES from antecedentes_personales where rut='".$resp["rut_usuario"]."';";
			$res_tmp=mysql_db_query("bd_rrhh",$query,$link);
			$r=mysql_fetch_array($res_tmp);
			mysql_free_result($res_tmp);
			echo '<td align="center">&nbsp;'.$r["NOMBRES"].' '.$r["ap_p"].' '.$r["ap_m"].'</td>';
			//se coloca la informacion de la asociacion
			echo '<td align="center">';
			if($resp["estado_asoc"]==1)
				echo 'Activa';
			else
				echo 'Terminada';
			echo '</td>';
			echo '</tr>';
		}
		}
/******************************* PARTES *******************************************/
		else  
		{
		while($resp=mysql_fetch_array($result))
		{
			echo '<tr bgcolor="#E8FDD9">';
			$var=explode("-",$resp["fecha_inicio"]);
			$fecha=$var[2]."-".$var[1]."-".$var[0];
			echo '<td align="center">'.$fecha.'</td>';
			$var=explode("-",$resp["fecha_termino"]);
			$fecha=$var[2]."-".$var[1]."-".$var[0];
			echo '<td align="center">'.$fecha.'</td>';
			//se recupera la informacion del centro de costo de ubicacion y del usuario
			$query="select cc_ubicacion,rut_usuario from asoc_equipos_usuarios where nro_asoc=".$resp["nro_asoc_eq_user"].";";
			$res_tmp=mysql_db_query("cia_web",$query,$link);
			$r=mysql_fetch_array($res_tmp);
			mysql_free_result($res_tmp);
			//se muestra la informacion del centro de costo
			$query="select descripcion from centro_costo where centro_costo='".$r["cc_ubicacion"]."';";
			$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
			$r_tmp=mysql_fetch_array($res_tmp);
			mysql_free_result($res_tmp);
			echo '<td style="border:solid 1px #666666;" align="center">'.$r["cc_ubicacion"].' - '.$r_tmp["descripcion"].'</td>';
			//se recupera la informacion del usuario
			$query="select APELLIDO_PATERNO as ap_p,APELLIDO_MATERNO as ap_m,NOMBRES from antecedentes_personales where rut='".$r["rut_usuario"]."';";
			$res_tmp=mysql_db_query("bd_rrhh",$query,$link);
			$r_tmp=mysql_fetch_array($res_tmp);
			mysql_free_result($res_tmp);
			echo '<td align="center">'.$r_tmp["NOMBRES"].' '.$r_tmp["ap_p"].' '.$r_tmp["ap_m"].'</td>';
			//se coloca la informacion de la asociacion
			echo '<td align="center">';
			if($resp["estado_asoc"]==1)
				echo 'Activa';
			else
				echo 'Terminada';
			echo '</td>';
			echo '</tr>';
		}
		}
			?>
			</table>
			<?php
			break;
		
		//historial especifico con detalle
		case "t_detalle":
			//se recuperan los datos de la asociacion
			if($tipo=="EQUIPO")
				$query="select * from asoc_equipos_usuarios where nro_asoc=".$nro_asoc.";";
			else
				$query="select * from asoc_partes_equipos where nro_asoc=".$nro_asoc.";";
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
			//se recupera la informacion del usuario
			if($tipo=="EQUIPO")
				$query="select APELLIDO_PATERNO as ap_p,APELLIDO_MATERNO as ap_m,NOMBRES from bd_rrhh.antecedentes_personales where rut='".$resp["rut_usuario"]."';";
			else
			{
				$query="select APELLIDO_PATERNO as ap_p,APELLIDO_MATERNO as ap_m,NOMBRES from bd_rrhh.antecedentes_personales";
				$query.=" where rut in (select rut_usuario from cia_web.asoc_equipos_usuarios where nro_asoc";
				$query.="=".$resp["nro_asoc_eq_user"].");";
			}
			$res_tmp=mysql_query($query,$link);
			$r=mysql_fetch_array($res_tmp);
			mysql_free_result($res_tmp);
			$user=$r["NOMBRES"]." ".$r["ap_p"]." ".$r["ap_m"];
			//se recupera la informacion de la ubicacion
			if($tipo=="EQUIPO")
				$cc=$resp["cc_ubicacion"];
			else
			{
				$query="select cc_ubicacion from asoc_equipos_usuarios where nro_asoc=".$resp["nro_asoc_eq_user"].";";
				$res_tmp=mysql_db_query("cia_web",$query,$link);
				$r=mysql_fetch_array($res_tmp);
				mysql_free_result($res_tmp);
				$cc=$r["cc_ubicacion"];
			}
			$query="select descripcion from centro_costo where centro_costo='".$cc."';";
			$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
			$r=mysql_fetch_array($res_tmp);
			mysql_free_result($res_tmp);
			$ubicacion=$cc." - ".$r["descripcion"];
			?>
			<table border="1" cellspacing="2" cellpadding="0" width="800" align="left">
			<tr bgcolor="#999999"><th colspan="5" align="center">DATOS DEL MOVIMIENTO</th></tr>
			<tr bgcolor="#CCCCCC">
				<th width="100" align="center">Fecha Inicio</th>
				<th width="110" align="center">Fecha Termino</th>
				<th width="220" align="center">Ubicaci&oacute;n</th>
				<th width="220" align="center">Usuario</th>
				<th width="130" align="center">Estado Asociaci&oacute;n</th>
			</tr>
			<tr bgcolor="#E8FDD9">
				<td align="center"><?php echo $fecha_inicio;?></td>
				<td align="center"><?php echo $fecha_termino;?></td>
				<td align="center"><?php echo $ubicacion;?></td>
				<td align="center"><?php echo $user;?></td>
				<td align="center"><?php echo $estado;?></td>
			</tr>
			</table>
			</td></tr>
			<tr><td>&nbsp;</td></tr>
			<tr><td>
			<?php
			//se recupera el detalle de la asociacion
			if($tipo=="EQUIPO")	//se recuperan partes asociadas
				$query="select * from asoc_partes_equipos where nro_asoc_eq_user=".$nro_asoc.";";
			else		//se recupera el equipo asociado en ese periodo para esa parte
				$query="select * from asoc_partes_equipos where nro_asoc=".$nro_asoc.";";
			$result_tmp=mysql_db_query("cia_web",$query,$link);
			?>
			<table border="1" cellspacing="2" cellpadding="0" width="800" align="left">
			<?php
			if($tipo=="EQUIPO")
			{
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
						echo '<td align="center">';
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
			}
		
			/****************************************** PARTES  ****************************************/		
			else	//para las partes
			{
				echo '<tr bgcolor="#999999"><th colspan="6" align="center">EQUIPO ASOCIADO</th></tr>';
				echo'
					<tr bgcolor="#CCCCCC">
					<th width="80" align="center">Fecha Inicio</th>
					<th width="90" align="center">Fecha Termino</th>
					<th width="80" align="center">Tipo</th>
					<th width="210" align="center">Marca</th>
					<th width="210" align="center">Modelo</th>
					<th width="90" align="center">Nro. Serie</th>
				</tr>';
				while($resp=mysql_fetch_array($result_tmp))
				{
					echo '<tr bgcolor="#E8FDD9">';
					$var=explode("-",$resp["fecha_inicio"]);
					$fecha=$var[2]."-".$var[1]."-".$var[0];
					echo '<td align="center">'.$fecha.'</td>';
					$var=explode("-",$resp["fecha_termino"]);
					$fecha=$var[2]."-".$var[1]."-".$var[0];
					echo '<td align="center">'.$fecha.'</td>';
					echo '<td align="center">';
					//se recupera el tipo de equipo
					$tip=substr($resp["cod_equipo"],0,3);
					$query="select nombre_subclase as nom from sub_clase where valor_subclase1='".$tip."';";
					$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
					$r_tmp=mysql_fetch_array($res_tmp);
					echo $r_tmp["nom"].'</td>';
					//se recupera la informacion del equipo al que esta asociado
					$query="select marca,modelo,nro_serie from hardware where codigo='".$resp["cod_equipo"]."';";
					$res_tmp=mysql_db_query("cia_web",$query,$link);
					$r=mysql_fetch_array($res_tmp);
					mysql_free_result($res_tmp);
					echo '<td align="center">'.$r["marca"].'</td>';
					echo '<td align="center">'.$r["modelo"].'</td>';
					echo '<td align="center">'.$r["nro_serie"].'</td>';
					echo '</tr>';
				}
			}
			echo '</table>';
			break;
			
		//historial completo detallado	
		case "historial_c":
			//se recuperan los datos necesarios
			if($tipo=="EQUIPO")
				$query="select * from asoc_equipos_usuarios where cod_equipo='".$cod."' order by fecha_inicio;";
			else
				$query="select * from asoc_partes_equipos where cod_parte='".$cod."' and nro_asoc_eq_user <> 0 order by fecha_inicio;";
			$result=mysql_db_query("cia_web",$query,$link);
			?>
			<table border="1" cellspacing="2" cellpadding="0" align="left" width="1510">
			<?php
			if($tipo=="EQUIPO")
				$var=12;
			else
				$var=9;
			?>
			<tr bgcolor="#999999"><th colspan="<?php echo $var;?>" align="center">HISTORIAL DE MOVIMIENTOS DETALLADO</th></tr>
			<tr bgcolor="#999999">
				<th align="center" colspan="5">MOVIMIENTO</th>
				<?php
				if($tipo=="EQUIPO")
					echo '<th align="center" colspan="7">PARTES ASOCIADAS</th>';
				else
					echo '<th align="center" colspan="4">EQUIPO ASOCIADO</th>';
				?>
			</tr>
			<tr bgcolor="#CCCCCC">
				<th align="center" width="80">Fecha Inicio</th>
				<th align="center" width="80">Fecha Termino</th>
				<th align="center" width="200">Ubicaci&oacute;n</th>
				<th align="center" width="200">Usuario</th>
				<th align="center" width="100">Estado Asociaci&oacute;n</th>
				<?php
				if($tipo=="EQUIPO")
				{
					echo '
					<th align="center" width="80">Fecha Inicio</th>
					<th align="center" width="80">Fecha Termino</th>
					<th align="center" width="80">Tipo</th>
					<th align="center" width="170">Marca</th>
					<th align="center" width="170">Modelo</th>
					<th align="center" width="170">Nro. Serie</th>
					<th align="center" width="100">Estado Asociaci&oacute;n</th>
					';
				}
				else
				{
					echo '
					<th align="center" width="80">Tipo</th>
					<th align="center" width="170">Marca</th>
					<th align="center" width="170">Modelo</th>
					<th align="center" width="170">Nro. Serie</th>';				
				}
				?>
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
				
				//                EQUIPOS
				if($tipo=="EQUIPO")
				{
					//se recupera la informacion del centro de costo de ubicacion
					$query="select descripcion from centro_costo where centro_costo='".$resp["cc_ubicacion"]."';";
					$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
					$r=mysql_fetch_array($res_tmp);
					mysql_free_result($res_tmp);
					echo '<td bgcolor="#CCCC66" align="center">'.$resp["cc_ubicacion"].' - '.$r["descripcion"].'</td>';
					//se recupera la informacion del usuario
					$query="select APELLIDO_PATERNO as ap_p,APELLIDO_MATERNO as ap_m,NOMBRES from antecedentes_personales where rut='".$resp["rut_usuario"]."';";
					$res_tmp=mysql_db_query("bd_rrhh",$query,$link);
					$r=mysql_fetch_array($res_tmp);
					mysql_free_result($res_tmp);
					echo '<td bgcolor="#CCCC66" align="center">'.$r["NOMBRES"].' '.$r["ap_p"].' '.$r["ap_m"].'</td>';
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
							echo '<td align="center">';
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
								echo '<td colspan="5" bgcolor="#FFFFFF">&nbsp;</td>';
							}
						}
						mysql_free_result($res_tmp);
					}
				}
				
				//        PARTES
				else
				{
					//se recupera la informacion del centro de costo de ubicacion y del usuario
					$query="select cc_ubicacion,rut_usuario from asoc_equipos_usuarios where nro_asoc=".$resp["nro_asoc_eq_user"].";";
					$res_tmp=mysql_db_query("cia_web",$query,$link);
					$r=mysql_fetch_array($res_tmp);
					mysql_free_result($res_tmp);
					//se muestra la informacion del centro de costo
					$query="select descripcion from centro_costo where centro_costo='".$r["cc_ubicacion"]."';";
					$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
					$r_tmp=mysql_fetch_array($res_tmp);
					mysql_free_result($res_tmp);
					echo '<td bgcolor="#CCCC66" align="center">'.$r["cc_ubicacion"].' - '.$r_tmp["descripcion"].'</td>';
					//se recupera la informacion del usuario
					$query="select APELLIDO_PATERNO as ap_p,APELLIDO_MATERNO as ap_m,NOMBRES from antecedentes_personales where rut='".$r["rut_usuario"]."';";
					$res_tmp=mysql_db_query("bd_rrhh",$query,$link);
					$r_tmp=mysql_fetch_array($res_tmp);
					mysql_free_result($res_tmp);
					echo '<td bgcolor="#CCCC66" align="center">'.$r_tmp["NOMBRES"].' '.$r_tmp["ap_p"].' '.$r_tmp["ap_m"].'</td>';
					//se coloca la informacion de la asociacion
					echo '<td align="center" bgcolor="#CCCC66">';
					if($resp["estado_asoc"]==1)
						echo 'Activa';
					else
						echo 'Terminada';
					echo '</td>';
					
					//se recupera la informacion del equipo asociado
					$query="select marca,modelo,nro_serie from hardware where codigo='".$resp["cod_equipo"]."';";
					$res_tmp=mysql_db_query("cia_web",$query,$link);
					$r=mysql_fetch_array($res_tmp);
					mysql_free_result($res_tmp);
					echo '<td align="center">';
					//se recupera el tipo de equipo
					$tip=substr($resp["cod_equipo"],0,3);
					$query="select nombre_subclase as nom from sub_clase where valor_subclase1='".$tip."';";
					$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
					$r_tmp=mysql_fetch_array($res_tmp);
					echo $r_tmp["nom"].'</td>';
					echo '<td align="center">'.$r["marca"].'</td>';
					echo '<td align="center">'.$r["modelo"].'</td>';
					echo '<td align="center">'.$r["nro_serie"].'</td>';
				}
				echo '</tr>';
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
