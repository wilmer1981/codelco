<?php
include("../principal/conectar_principal.php");

//se recuperan todos los equipos asociados al usuario
$query="select * from asoc_equipos_usuarios where rut_usuario='".$rut_user."';";
$result=mysql_db_query("cia_web",$query,$link);
$cant=mysql_num_rows($result);
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
		alert("Este Usuario no registra Movimientos");
		window.close();
	}
}

function ver(nro_asoc)
{
	document.frmMovimientos.nro_asoc.value=nro_asoc;
	document.frmMovimientos.action="det_mov_user.php#detalle_historial";
	document.frmMovimientos.submit();
}

function to_excel(nro_asoc)
{
	var URL,opciones;
	URL="opcion.php?op=3&rut_user=" + document.frmMovimientos.rut_user.value + "&nro_asoc=" + nro_asoc;
	opciones='toolbar=0,resizable=0,menubar=1,status=1,width=370,heigth=200';
	verificar_popup(popup);
	popup=window.open(URL,"",opciones);
	popup.focus();
	popup.moveTo((screen.width - 370)/2,(screen.heigth - 200)/2);
}

</script>
</head>

<body bgcolor="#CCCCCC" onLoad="revisar(<?php echo $cant;?>)" onUnload="verificar_popup(popup)">
<form name="frmMovimientos" method="post">
<input type="hidden" name="rut_user" value="<?php echo $rut_user;?>">
<input type="hidden" name="nro_asoc" value="">
<!---------------------------------- cuerpo de la pagina ------------------------------------->
<table width="960" class="TablaPrincipal" cellpadding="0" cellspacing="0" border="0" align="center">
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>
	<table width="950" border="0" class="TablaInterior" align="center">
	<tr>
	    <td class="ColorTabla01" align="center"><strong>HISTORIAL DE MOVIMIENTOS</strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
		<table border="0" cellspacing="2" cellpadding="0" width="940">
		<tr>
			<td width="80" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Fecha Inicio</td>
			<td width="90" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Fecha Termino</td>
			<td width="200" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Ubicaci&oacute;n</td>
			<td width="80" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Tipo</td>
			<td width="100" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Marca</td>
			<td width="100" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Modelo</td>
			<td width="100" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Nro Serie</td>
			<td width="100" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Estado Asociaci&oacute;n</td>
			<td width="90" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Partes Asociadas</td>
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
			
			echo '<tr ';
			if(isset($nro_asoc) && $nro_asoc==$resp["nro_asoc"])
				echo 'bgcolor="#D5EAFF"';
			echo '>';
			$fecha=explode("-",$resp["fecha_inicio"]);
			$fecha=$fecha[2]."-".$fecha[1]."-".$fecha[0];
			echo '<td align="center" style="border:solid 1px #666666;">&nbsp;'.$fecha.'</td>';
			$fecha=explode("-",$resp["fecha_termino"]);
			$fecha=$fecha[2]."-".$fecha[1]."-".$fecha[0];
			echo '<td align="center" style="border:solid 1px #666666;">&nbsp;'.$fecha.'</td>';
			//se recupera la informacion del centro de costo de ubicacion
			$query="select descripcion from centro_costo where centro_costo='".$resp["cc_ubicacion"]."';";
			$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
			$r_tmp=mysql_fetch_array($res_tmp);
			mysql_free_result($res_tmp);
			echo '<td style="border:solid 1px #666666;" align="center">&nbsp;'.$resp["cc_ubicacion"].' - '.$r_tmp["descripcion"].'</td>';
			echo '<td style="border:solid 1px #666666;" align="center">&nbsp;';
			//se recupera el tipo de equipo
			$tip=substr($resp["cod_equipo"],0,3);
			$query="select nombre_subclase as nom from sub_clase where valor_subclase1='".$tip."';";
			$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
			$r_tmp=mysql_fetch_array($res_tmp);
			echo $r_tmp["nom"].'</td>';
			echo '<td align="center" style="border:solid 1px #666666;">&nbsp;'.$r["marca"].'</td>';
			echo '<td align="center" style="border:solid 1px #666666;">&nbsp;'.$r["modelo"].'</td>';
			echo '<td align="center" style="border:solid 1px #666666;">&nbsp;'.$r["nro_serie"].'</td>';
			//se coloca la informacion de la asociacion
			echo '<td style="border:solid 1px #666666;" align="center">';
			if($resp["estado_asoc"]==1)
				echo 'Activa';
			else
				echo 'Terminada';
			echo '</td>';
			//enlace para detalle de partes asociadas
			echo '<td style="border:solid 1px #666666;" align="center">';
			if(substr($resp["cod_equipo"],0,3)=='CMP' || substr($resp["cod_equipo"],0,3)=='NBK')
				echo '<a href="javascript: ver('.$resp["nro_asoc"].');" class="LINK"><strong>Ver</strong></a></td>';
			else
				echo '&nbsp;';
			echo '</tr>';
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
	$query="select * from asoc_partes_equipos where nro_asoc_eq_user=".$nro_asoc.";";
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
		echo '<tr><td colspan="7" align="center"><strong>No hay Partes Asociadas en este Periodo</strong></td></tr>';	
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
