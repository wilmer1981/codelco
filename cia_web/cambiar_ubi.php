<?php
//popup para el cambio de ubicacion de un equipo

include("../principal/conectar_principal.php");
//se recupera la ubicacion actual del equipo
$query="select descripcion,centro_costo from centro_costo where centro_costo='".$cc_ubi."';";
$result=mysql_db_query("proyecto_modernizacion",$query,$link);
$resp=mysql_fetch_array($result);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<style>
<!--
.LINK{
	font:Arial, Helvetica, sans-serif;
	color:#FFFF00;
	text-align:center;
	text-decoration:none;
}

a:link{
	color:#FFFF00;
}	

a:hover{
	color:#FFFF00;
}

a:visited{
	color:#FFFF00;
}

a:active{
	color:#FFFFFF;
}

.CELDA{
	border: solid 1px #333333;
	text-align: center;
}
-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Cia Web</title>
<script language="JavaScript">
function cambiar(cod_equipo)
{
	if(confirm("¿Seguro que desea cambiar la ubicacion de este equipo?"))
	{
		document.frmCambiarUbi.action="actualizar_datos.php?op=8&cod_equipo=" + cod_equipo;
		document.frmCambiarUbi.submit();
	}
}
</script>
</head>

<body bgcolor="#CCCCCC">
<form name="frmCambiarUbi" method="post">
<!---------------------------------- cuerpo de la pagina ------------------------------------->
<table class="TablaPrincipal" cellpadding="0" cellspacing="0" border="0" width="380" align="center">
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>
	<table border="0" class="TablaInterior" align="center" width="340">
	<tr>
	        <td class="ColorTabla01" align="center"><strong>Cambio de Ubicaci&oacute;n</strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="center">
		<table align="center" width="330" cellpadding="0" cellspacing="0">
		<tr>
			<td width="50">&nbsp;Actual</td>
			<td>&nbsp;<input type="text" name="ubi_actual" value="<?php echo $resp["centro_costo"]." - ".$resp["descripcion"];?>" size="40" disabled></td>
		</tr>
		<tr>
			<td width="50">&nbsp;Nueva</td>
			<td>&nbsp;<select name="new_ubi">
			<?php
			//se cargan todos los centros de costos
			$query="select centro_costo, descripcion from centro_costo;";
			$result=mysql_db_query("proyecto_modernizacion",$query,$link);
			while($resp=mysql_fetch_array($result))
			{
				echo '<option value="'.$resp["centro_costo"].'"';
				if($cc_ubi==$resp["centro_costo"])
					echo ' selected';
				echo '>'.$resp["centro_costo"].' - '.$resp["descripcion"].'</option>';
			}
			mysql_free_result($result);
			?>
			</select>
			</td>
		</tr>
		</table>
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	</table>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td align="center">
	<input type="button" name="Enviar" value="Cambiar" style="width: 80px;" onClick="cambiar('<?php echo $cod_equipo;?>')">
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="button" name="Cerrar" value="Cancelar" style="width: 80px;" onClick="javascript:window.close();">
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
</table>

</form>
</body>
</html>
