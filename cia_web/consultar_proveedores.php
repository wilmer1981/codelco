<?php
$CodigoDeSistema=18;
$CodigoDePantalla=4;
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
-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Cia Web</title>
<script language="JavaScript">
function ver_todo()
{
	var form=frmConsultarProveedores;
	form.buscar_campo.disabled=form.ver_todos.checked;
	form.buscar.disabled=form.ver_todos.checked;
}

function Ver()
{
	var form=frmConsultarProveedores;
	//se valida la busqueda
	if(!form.ver_todos.checked && form.buscar.value=="")
	{
		alert("Debe ingresar algún parametro para la busqueda");
		form.buscar.focus();
		return false;
	}
	form.action="ver_datos.php?op=1";
	form.submit();
}

function salir()
{
	document.frmConsultarProveedores.action="../principal/sistemas_usuario.php?CodSistema=18";
	document.frmConsultarProveedores.target="_self";
	document.frmConsultarProveedores.submit();
}
</script>
</head>

<body onLoad="javascript: frmConsultarProveedores.buscar.focus()">
<form name="frmConsultarProveedores" method="post">
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
		    <td class="ColorTabla01" align="center"><strong>Buscador de Proveedores</strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
		<table width="500" border="0" cellspacing="2" cellpadding="0" align="center">
                <tr> 
                  <td width="150" align="center" style="border:solid 1px #666666;">Buscar 
                    Como:</td>
                  <td style="border:solid 1px #666666;"> <table border="0" width="300" cellspacing="2" cellpadding="0" align="center">
                      <tr> 
                        <td> <select name="buscar_campo">
                            <option value="rut" selected>Rut</option>
                            <option value="razon_social">Raz&oacute;n social</option>
                            <option value="nombre_fantasia">Nombre Fantasia</option>
                            <option value="contacto">Contacto</option>
                            <option value="fono">Fono</option>
                            <option value="fax">Fax</option>
                          </select> </td>
                      </tr>
                      <tr> 
                        <td>&nbsp;</td>
                      </tr>
                      <tr> 
                        <td><input type="text" name="buscar" maxlength="35" size="30"></td>
                      </tr>
                      <tr> 
                        <td>&nbsp;</td>
                      </tr>
                      <tr> 
                        <td> <input type="checkbox" name="ver_todos" onClick="ver_todo()">
                          No Buscar. Ver Todos los Registros </td>
                      </tr>
                    </table></td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr> 
                  <td colspan="2" align="center" style="border:solid 1px #666666;"> 
                    <input type="button" name="ver" value="Ver" style="width: 80px;" onClick="Ver()"> 
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
