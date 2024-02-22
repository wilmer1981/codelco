<?php
	$CodigoDeSistema=18;
	$CodigoDePantalla=3;
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
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Cia Web</title>
<script type="text/javascript" src="funciones.js"></script>
<script language="JavaScript">
function validar()
{
	var f=document.frmIngresoProveedores;
	//se validan los datos
	if(f.rut.value=="")
	{
		alert("Debe ingresar el Rut");
		f.rut.focus();
		return false;
	}
	if(f.rut.value.length < 7)
	{
		alert("Debe ingresar un Rut valido");
		f.rut.focus();
		return false;
	}
	if(f.rut.value.length==7)
		f.rut.value="0" + f.rut.value;
	if(f.verificador.value=="x")
	{
		alert("Debe seleccionar el digito verificador");
		f.verificador.focus();
		return false;
	}
	if(f.r_social.value=="" || f.r_social.value.length < 3)
	{
		alert("Debe ingresar un valor de Razon Social valido");
		f.r_social.focus();
		return false;
	}
	//se colocan en mayusculas los campos
	f.r_social.value=f.r_social.value.toUpperCase();
	f.n_fantasia.value=f.n_fantasia.value.toUpperCase();
	f.contacto_1.value=f.contacto_1.value.toUpperCase();
	f.contacto_2.value=f.contacto_2.value.toUpperCase();
	f.fono_1.value=f.fono_1.value.toUpperCase();
	f.fono_2.value=f.fono_2.value.toUpperCase();
	f.fax.value=f.fax.value.toUpperCase();
	f.action="ingreso_datos.php?op=3";
	f.submit();
	return true;
}
</script>
</head>

<body onLoad="javascript: frmIngresoProveedores.rut.focus()"> 
<form name="frmIngresoProveedores" method="post">
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
	<table width="600" border="0" class="TablaInterior" align="center">
	<tr>
		<td class="ColorTabla01" align="center"><strong>Informaci&oacute;n del Proveedor </strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
		<table width="400" border="0" cellpadding="0" cellspacing="2" align="center">
		<tr>
			<td width="150" style="border:solid 1px #666666;">Rut:</td>
			<td>&nbsp;&nbsp;
			<input type="text" name="rut" maxlength="8" size="10">&nbsp;-&nbsp;
			<select name="verificador">
			<option value="x" selected></option>
			<option value="0">0</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
			<option value="6">6</option>
			<option value="7">7</option>
			<option value="8">8</option>
			<option value="9">9</option>
			<option value="K">K</option>
			</select></td>
		</tr>
		<tr>
			<td style="border:solid 1px #666666;">Raz&oacute;n Social:</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" name="r_social" maxlength="35" size="30"></td>
		</tr>
		<tr>
			<td style="border:solid 1px #666666;">Nombre Fantasia:</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" name="n_fantasia" maxlength="35" size="30"></td>
		</tr>
		<tr>
			<td style="border:solid 1px #666666;">Contacto (1/2):</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" name="contacto_1" maxlength="30" size="30"></td>
		</tr>
		<tr>
			<td style="border:solid 1px #666666;">Fono Contacto 1:</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" name="fono_1" maxlength="15" size="20"></td>
		</tr>
		<tr>
			<td style="border:solid 1px #666666;">Contacto (2/2):</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" name="contacto_2" maxlength="30" size="30"></td>
		</tr>
		<tr>
			<td style="border:solid 1px #666666;">Fono Contacto 2:</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" name="fono_2" maxlength="15" size="20"></td>
		</tr>
		<tr>
			<td style="border:solid 1px #666666;">Fax :</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" name="fax" maxlength="15" size="15"></td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		</table>
		</td>
	</tr>
	</table>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td align="center">
	<input type="reset" name="Limpiar" value="Limpiar" style="width: 80px;">
	&nbsp;&nbsp;&nbsp;
	<input type="button" name="Ingresar" value="Ingresar" style="width: 80px;" onClick=" return validar()">
	&nbsp;&nbsp;&nbsp;
	<input type="button" name="Volver" value="Salir" style="width: 80px;" onClick="salir()">
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
