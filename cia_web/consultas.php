<?php
$CodigoDeSistema=18;
$CodigoDePantalla=8;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<style>
<!--
.LINK{
	font:Arial, Helvetica, sans-serif;
	color: #b26c4a;
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
<script language="JavaScript" type="text/javascript">
var popup=0;
function ir(opcion)
{
	var URL,opciones;
	switch(opcion)
	{
		case 1:		//listado completo de equipos y partes
			URL="Filtros/filtro_listado.php";
			opciones='toolbar=0,resizable=0,menubar=1,status=1,width=640,height=650,scrollbars=1';
			verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo((screen.width - 640)/2,0);
			break;
		case 2:		//estadisticas
			URL="estadisticas.php";
			opciones='toolbar=0,resizable=0,menubar=0,status=1,width=640,height=700,scrollbars=1';
			verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo((screen.width - 640)/2,0);
			break;
		case 3:		//historial de fallas o movimientos de un usuario
			URL='cambiar_user.php?codigo_equipo=0&nro_asoc=0&opcion=2';
			opciones='resizable=0,toolbar=0,scrollbars=1,status=1,menubar=0,width=640,height=700';
			verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo((screen.width - 640)/2,0);
			break;
	}
}
</script>
</head>

<body onUnload="verificar_popup(popup)">
<form name="frmConsulta" method="post">
<!-------------------------------- cabecera de la pagina ------------------------------------>
<?php
include("../principal/encabezado.php");
?>

<!---------------------------------- cuerpo de la pagina ------------------------------------->
<table width="770" class="TablaPrincipal" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>
	<table width="600" border="0" class="TablaInterior" align="center" cellspacing="2">
	<tr>
		    <td class="ColorTabla01" align="center"><strong>Seleccione la consulta 
              que desea realizar.</strong></td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td>
		<table border="0" align="center" width="500" cellspacing="2" cellpadding="0">
		<tr>
			<td align="center" width="250" style="border:solid 1px #666666;">
			<a href="javascript: ir(1)" class="LINK">LISTADO COMPLETO DE EQUIPOS Y PARTES</a>
			</td>
			<td align="left" style="border:solid 1px #666666; color: #b26c4a;" bgcolor="#CCCCCC">
			Esta consulta permite generar listados de todos los equipos y partes
			en base a los siguientes filtros:<br>
			<strong><br>- Tipo de Equipo o Parte
			<br>- Estado de un Equipo o Parte
			<br>- Proveedores
			<br>- Usuarios
			<br>- Ubicaci&oacute;n de los Equipos o Partes
			<br>- Detalle de Equipos
			<br>- Otros campos comunes a Equipos y Partes</strong>
			<br>
			</td>
		</tr>
		<tr>
			<td align="center" width="250" style="border:solid 1px #666666;">
			<a href="javascript: ir(2)" class="LINK">ESTADISTICAS</a>
			</td>
			<td align="left" style="border:solid 1px #666666; color: #b26c4a;" bgcolor="#CCCCCC">
			Esta consulta permite ver estadisticas del hardware registrado. Se divide en 2 partes:<br>
			<br>- <strong>Generales:</strong> Datos de todo el hardware actualmente registrado
			<br>- <strong>Por Centro de Costo:</strong> Datos particulares del hardware asignado a un centro de costo especifico.
			</td>
		</tr>
		<tr>
			<td align="center" width="250" style="border:solid 1px #666666;">
			<a href="javascript: ir(3)" class="LINK">HISTORIAL DE MOVIMIENTOS Y/O FALLAS<br>POR USUARIO</a>
			</td>
			<td align="left" style="border:solid 1px #666666; color: #b26c4a;" bgcolor="#CCCCCC">&nbsp;
			Esta consulta muestra el historial completo de fallas o movimientos de un determinado usuario.
			</td>
		</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	</table>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td align="center">
	<input type="button" name="volver" value="Salir" style="width: 80px;" onClick="salir()">
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr> 
</table>
</td>

<!--------------------------------------- pie de pagina ------------------------------------>
<?php
include("../principal/pie_pagina.php");
?>
</form>
</body>
</html>
