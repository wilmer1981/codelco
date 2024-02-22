<?php
//popup para asociar un equipo con un software
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
function terminar(codigo)
{
	var f=document.frmAsociarSW;
	//se valida la seleccion
	if(f.sw.value==0)
	{
		alert("Debe seleccionar un Software");
		f.sw.focus();
		return false;
	}
	
	if(confirm("¿Seguro que desea asociar este Software?"))
	{
		f.action="actualizar_datos.php?op=6&cod_equipo=" + codigo;
		f.submit();
	}
	return true;
	
}
</script>
</head>

<body bgcolor="#CCCCCC">
<form name="frmAsociarSW" method="post">
<!---------------------------------- cuerpo de la pagina ------------------------------------->
<table class="TablaPrincipal" cellpadding="0" cellspacing="0" border="0" width="350" align="center">
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>
	<table border="0" class="TablaInterior" align="center" width="300">
	<tr>
	        <td class="ColorTabla01" align="center"><strong>Software</strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="center">
		<?php
		//se cargan todos los softwares disponibles
		$query="select codigo,nombre,version_sw from software order by(nombre);";
		$result=mysql_db_query("cia_web",$query,$link);
		if(mysql_num_rows($result))
		{
			echo '<select name="sw">';
			echo '<option value="0" selected>Seleccione un software</option>';
			while($resp=mysql_fetch_array($result))
				echo '<option value="'.$resp["codigo"].'">'.$resp["nombre"].'(Versi&oacute;n: '.$resp["version_sw"].')</option>';
			echo '</select>';
		}
		else
			echo '<strong>No hay softwares disponibles</strong>';
		?>
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
	<?php
	if(mysql_num_rows($result))
	{
		echo '<input type="button" name="Enviar" value="Terminar" style="width: 80px;" onClick="terminar(\''.$codigo_equipo.'\')">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		mysql_free_result($result);
	}
	?>
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
