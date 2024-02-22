<?php
//popup para la asignacion de la ubicacion del equipo
include("../principal/conectar_principal.php");
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
	var f=document.frmAsignarUbi;
	if(f.new_ubi.value==0)
	{
		alert("Debe seleccionar una ubicación");
		f.new_ubi.focus();
		return false;
	}
	if(confirm("¿Seguro que desea asignar esta ubicacion al equipo?"))
	{
		f.action="actualizar_datos.php?op=11&cod_equipo=" + cod_equipo;
		f.submit();
	}
	return true;
}

function redimensionar()
{
	self.resizeTo(430,220);
	self.moveTo(350,350);
	document.frmAsignarUbi.new_ubi.focus();
}
</script>
</head>

<body bgcolor="#CCCCCC" onLoad="redimensionar()">
<form name="frmAsignarUbi" method="post">
<input type="hidden" name="rut_user" value="<?php echo $rut_user;?>">
<!---------------------------------- cuerpo de la pagina ------------------------------------->
<table class="TablaPrincipal" cellpadding="0" cellspacing="0" border="0" width="380" align="center">
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>
	<table border="0" class="TablaInterior" align="center" width="340">
	<tr>
	        <td class="ColorTabla01" align="center"><strong>Ubicaci&oacute;n</strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="center">
		<select name="new_ubi">
		<option value="0" selected>Seleccione una ubicaci&oacute;n</option>
		<?php
		//se cargan todos los centros de costos
		$query="select centro_costo, descripcion from centro_costo;";
		$result=mysql_db_query("proyecto_modernizacion",$query,$link);
		while($resp=mysql_fetch_array($result))
			echo '<option value="'.$resp["centro_costo"].'">'.$resp["centro_costo"].' - '.$resp["descripcion"].'</option>';
		mysql_free_result($result);
		?>
		</select>
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
	<input type="button" name="Enviar" value="Asignar" style="width: 80px;" onClick="cambiar('<?php echo $cod_equipo;?>')">
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="button" name="Cerrar" value="Cancelar" style="width: 80px;" onClick="javascript: window.close()">
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
</table>

</form>
</body>
</html>
