<?php

$var=explode(";",$valor);
$cod=$var[0];
$tipo=$var[1];
include("../principal/conectar_principal.php");

//se recuperan los datos necesarios
if($tipo=="EQUIPO")
	$query="select * from asoc_equipos_usuarios where cod_equipo='".$cod."' order by fecha_inicio;";
else
	$query="select * from asoc_partes_equipos where cod_parte='".$cod."' and nro_asoc_eq_user <> 0 order by fecha_inicio;";
$result=mysql_db_query("cia_web",$query,$link);
$cant=mysql_num_rows($result);
echo $query;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<style>
<!--
.LINK{
	font:Arial, Helvetica, sans-serif;
	color:#b26c4a;
	text-align:center;
	text-decoration:none;
}

a:link{
	color: #b26c4a;
}	

a:hover{
	color: #b26c4a;
	background-color: #FFFFFF;
}

a:visited{
	color: #b26c4a;
}

a:active{
	color: #b26c4a;
}
-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Cia Web</title>
<script type="text/javascript" src="funciones.js"></script>
<script language="JavaScript">
var popup=0;
function revisar(cant)
{
	if(cant==0)
	{
		alert("Este equipo no registra Movimientos");
		window.close();
	}
}

function ver(nro_asoc)
{
	document.frmMovimientos.nro_asoc.value=nro_asoc;
	document.frmMovimientos.action="det_mov.php#detalle_historial";
	document.frmMovimientos.submit();
}

function to_excel(nro_asoc)
{
	var URL,opciones;
	URL="opcion.php?op=1&valor=" + document.frmMovimientos.valor.value + "&nro_asoc=" + nro_asoc;
	opciones="toolbar=0,resizable=0,menubar=1,status=1,width=370,heigth=300";
	verificar_popup(popup);
	popup=window.open(URL,"",opciones);
	popup.focus();
	popup.moveTo((screen.width - 370)/2,(screen.heigth - 300)/2);
}
</script>
</head>

<body bgcolor="#CCCCCC" onLoad="revisar(<?php echo $cant;?>)" onUnload="verificar_popup(popup)">
<form name="frmMovimientos" method="post">
<input type="hidden" name="valor" value="<?php echo $valor;?>">
<input type="hidden" name="nro_asoc">
<!---------------------------------- cuerpo de la pagina ------------------------------------->
<table width="800" class="TablaPrincipal" cellpadding="0" cellspacing="0" border="0" align="center">
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>
	<table width="770" border="0" class="TablaInterior" align="center">
	<tr>
	    <td class="ColorTabla01" align="center"><strong>HISTORIAL DE MOVIMIENTOS</strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
		<table border="0" cellspacing="2" cellpadding="0" width="760">
		<tr>
			<td width="80" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Fecha Inicio</td>
			<td width="90" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Fecha Termino</td>
			<td width="200" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Ubicaci&oacute;n</td>
			<td width="200" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Usuario</td>
			<td width="100" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Estado Asociaci&oacute;n</td>
			<td width="90" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">
			<?php
			if($tipo=="EQUIPO")
				echo 'Partes Asociadas';
			else
				echo 'Equipo Asociado';
			?>
			</td>
		</tr>
		<?php
/*************************************** EQUIPOS ****************************************/
		if($tipo=="EQUIPO")
		{
		while($resp=mysql_fetch_array($result))
		{
			echo '<tr ';
			if(isset($nro_asoc) && $nro_asoc==$resp["nro_asoc"])
				echo 'bgcolor="#D5EAFF"';
			echo '>';
			$var=explode("-",$resp["fecha_inicio"]);
			$fecha=$var[2]."-".$var[1]."-".$var[0];
			echo '<td style="border:solid 1px #666666;" align="center">&nbsp;'.$fecha.'</td>';
			$var=explode("-",$resp["fecha_termino"]);
			$fecha=$var[2]."-".$var[1]."-".$var[0];
			echo '<td style="border:solid 1px #666666;" align="center">&nbsp;'.$fecha.'</td>';
			//se recupera la informacion del centro de costo de ubicacion
			$query="select descripcion from centro_costo where centro_costo='".$resp["cc_ubicacion"]."';";
			$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
			$r=mysql_fetch_array($res_tmp);
			mysql_free_result($res_tmp);
			echo '<td style="border:solid 1px #666666;" align="center">&nbsp;'.$resp["cc_ubicacion"].' - '.$r["descripcion"].'</td>';
			//se recupera la informacion del usuario
			$query="select APELLIDO_PATERNO as ap_p,APELLIDO_MATERNO as ap_m,NOMBRES from antecedentes_personales where RUT='".$resp["rut_usuario"]."';";
			$res_tmp=mysql_db_query("bd_rrhh",$query,$link);
			$r=mysql_fetch_array($res_tmp);
			mysql_free_result($res_tmp);
			echo '<td style="border:solid 1px #666666;" align="center">&nbsp;'.$r["NOMBRES"].' '.$r["ap_p"].' '.$r["ap_m"].'</td>';
			//se coloca la informacion de la asociacion
			echo '<td style="border:solid 1px #666666;" align="center">';
			if($resp["estado_asoc"]==1)
				echo 'Activa';
			else
				echo 'Terminada';
			echo '</td>';
			//enlace para detalle de partes asociadas
			echo '<td style="border:solid 1px #666666;" align="center">';
			if(substr($cod,0,3)=='CMP' || substr($cod,0,3)=='NBK')
				echo '<a href="javascript: ver('.$resp["nro_asoc"].');" class="LINK"><strong>Ver</strong></a></td>';
			else
				echo '&nbsp;';
			echo '</tr>';
		}
		}
/******************************* PARTES *******************************************/
		else  
		{
		while($resp=mysql_fetch_array($result))
		{
			echo '<tr ';
			if(isset($nro_asoc) && $nro_asoc==$resp["nro_asoc"])
				echo 'bgcolor="#D5EAFF"';
			echo '>';
			$var=explode("-",$resp["fecha_inicio"]);
			$fecha=$var[2]."-".$var[1]."-".$var[0];
			echo '<td style="border:solid 1px #666666;" align="center">&nbsp;'.$fecha.'</td>';
			$var=explode("-",$resp["fecha_termino"]);
			$fecha=$var[2]."-".$var[1]."-".$var[0];
			echo '<td style="border:solid 1px #666666;" align="center">&nbsp;'.$fecha.'</td>';
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
			echo '<td style="border:solid 1px #666666;" align="center">&nbsp;'.$r["cc_ubicacion"].' - '.$r_tmp["descripcion"].'</td>';
			//se recupera la informacion del usuario
			$query="select APELLIDO_PATERNO as ap_p,APELLIDO_MATERNO as ap_m,NOMBRES from antecedentes_personales where RUT='".$r["rut_usuario"]."';";
			$res_tmp=mysql_db_query("bd_rrhh",$query,$link);
			$r_tmp=mysql_fetch_array($res_tmp);
			mysql_free_result($res_tmp);
			echo '<td style="border:solid 1px #666666;" align="center">&nbsp;'.$r_tmp["NOMBRES"].' '.$r_tmp["ap_p"].' '.$r_tmp["ap_m"].'</td>';
			//se coloca la informacion de la asociacion
			echo '<td style="border:solid 1px #666666;" align="center">';
			if($resp["estado_asoc"]==1)
				echo 'Activa';
			else
				echo 'Terminada';
			echo '</td>';
			//enlace para detalle de equipo asociado
			echo '<td style="border:solid 1px #666666;" align="center"><a href="javascript: ver('.$resp["nro_asoc"].');" class="LINK"><strong>';
			echo $resp["cod_equipo"];
			echo '</strong></a></td>';
			echo '</tr>';
		}
		}
		?>
		<tr>
			<td colspan="6">&nbsp;</td>
		</tr>
		</table>
		</td>
	</tr>
	</table>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<?php
if(isset($nro_asoc))
{
	if($tipo=="EQUIPO")	//se recuperan partes asociadas
		$query="select * from asoc_partes_equipos where nro_asoc_eq_user=".$nro_asoc.";";
	else		//se recupera el equipo asociado en ese periodo para esa parte
		$query="select * from asoc_partes_equipos where nro_asoc=".$nro_asoc.";";
	$result_tmp=mysql_db_query("cia_web",$query,$link);
	
	echo '<tr><td>';
	echo '<a name="detalle_historial">';
	echo '<table width="770" border="0" class="TablaInterior" align="center">
	<tr>
	    <td class="ColorTabla01" align="center"><strong>DETALLE EQUIPOS ASOCIADOS</strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
		<table border="0" cellspacing="2" cellpadding="0" width="760">
		';
		
/************************************** EQUIPO ***************************************/
		if($tipo=="EQUIPO")
		{
			if(mysql_num_rows($result_tmp))
			{
				echo'
				<tr>
			<td width="80" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Fecha Inicio</td>
			<td width="90" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Fecha Termino</td>
			<td width="70" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Tipo</td>
			<td width="170" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Marca</td>
			<td width="170" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Modelo</td>
			<td width="90" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Nro. Serie</td>
			<td width="90" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Estado</td>
			</tr>';
				while($resp_tmp=mysql_fetch_array($result_tmp))
				{
			echo '<tr>';
			$var=explode("-",$resp_tmp["fecha_inicio"]);
			$fecha=$var[2]."-".$var[1]."-".$var[0];
			echo '<td style="border:solid 1px #666666;" align="center">&nbsp;'.$fecha.'</td>';
			$var=explode("-",$resp_tmp["fecha_termino"]);
			$fecha=$var[2]."-".$var[1]."-".$var[0];
			echo '<td style="border:solid 1px #666666;" align="center">&nbsp;'.$fecha.'</td>';
			echo '<td style="border:solid 1px #666666;" align="center">&nbsp;';
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
			echo '<td style="border:solid 1px #666666;" align="center">&nbsp;'.$r["marca"].'</td>';
			echo '<td style="border:solid 1px #666666;" align="center">&nbsp;'.$r["modelo"].'</td>';
			echo '<td style="border:solid 1px #666666;" align="center">&nbsp;'.$r["nro_serie"].'</td>';
			//se coloca la informacion de la asociacion
			echo '<td style="border:solid 1px #666666;" align="center">';
			if($resp_tmp["estado_asoc"]==1)
				echo 'Activa';
			else
				echo 'Terminada';
			echo '</td>';
			echo '</tr>';
		}
		}
		else
			echo'<tr><td colspan="7" align="center"><strong>No hay Partes Asociadas en este Periodo</strong></td></tr>';	
		}
		
/****************************************** PARTES  ****************************************/		
		else	//para las partes
		{
		echo'
				<tr>
			<td width="80" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Fecha Inicio</td>
			<td width="90" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Fecha Termino</td>
			<td width="80" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Tipo</td>
			<td width="210" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Marca</td>
			<td width="210" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Modelo</td>
			<td width="90" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Nro. Serie</td>
			</tr>';
		while($resp=mysql_fetch_array($result_tmp))
		{
			echo '<tr>';
			$var=explode("-",$resp["fecha_inicio"]);
			$fecha=$var[2]."-".$var[1]."-".$var[0];
			echo '<td style="border:solid 1px #666666;" align="center">&nbsp;'.$fecha.'</td>';
			$var=explode("-",$resp["fecha_termino"]);
			$fecha=$var[2]."-".$var[1]."-".$var[0];
			echo '<td style="border:solid 1px #666666;" align="center">&nbsp;'.$fecha.'</td>';
			echo '<td style="border:solid 1px #666666;" align="center">&nbsp;';
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
			echo '<td style="border:solid 1px #666666;" align="center">&nbsp;'.$r["marca"].'</td>';
			echo '<td style="border:solid 1px #666666;" align="center">&nbsp;'.$r["modelo"].'</td>';
			echo '<td style="border:solid 1px #666666;" align="center">&nbsp;'.$r["nro_serie"].'</td>';
			echo '</tr>';
		}
		}
		echo'
		<tr>
			<td colspan="7">&nbsp;</td>
		</tr>
		</table>
		</a>
		</td>
	</tr>
	</table>';
	echo '</td></tr><tr><td>&nbsp;</td></tr>';
}
?>
<tr>
	<td align="center">
	<input type="button" name="ToExcel" value="Excel" style="width: 80px;" onClick="to_excel(<?php echo $nro_asoc;?>)">&nbsp;&nbsp;&nbsp;
	<input type="button" name="cerrar" value="Cerrar" style="width: 80px;" onClick="javascript: window.close();">
	</td>
</tr>
<tr><td>&nbsp;</td></tr>
</table>
</td>

</form>
</body>
</html>
