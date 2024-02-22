<?php
//popup
//recibe el codigo de un equipo para cambiar su estado
//se recupera el codigo
$var=explode(";",$valor);
$cod=$var[0];
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
function terminar(valor,codigo)
{
	if(confirm("¿Seguro que desea dar de Baja este Equipo?"))
	{
		document.frmBaja.action="actualizar_datos.php?op=3&valor=" + valor + "&cod=" + codigo;
		document.frmBaja.submit();
	}
}
</script>
</head>

<body bgcolor="#CCCCCC">
<form name="frmBaja" method="post">
<!---------------------------------- cuerpo de la pagina ------------------------------------->
<table class="TablaPrincipal" cellpadding="0" cellspacing="0" border="0" width="350" align="center">
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>
	<table border="0" class="TablaInterior" align="center" width="300" cellspacing="2">
	<tr>
	        <td class="ColorTabla01" align="center"><strong>Marque una opci&oacute;n</strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="center">
		<input type="radio" name="opcion" value="3" checked>De Baja
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio" name="opcion" value="2">Para Baja
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		    <td align="center" style="font-size: 8pt; color: #333333;">
			Todos los Equipos asociados quedaran Disponibles</td>
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
	<input type="button" name="Enviar" value="Terminar" style="width: 80px;" onClick="terminar(<?php echo "'".$valor."','".$cod."'";?>)">
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
