<?php
$CodigoDeSistema=18;
$CodigoDePantalla=5;
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
<script type="text/javascript" src="funciones.js"></script>
<script language="JavaScript">
function validar()
{
	var f=document.frmIngresoSW;
	//se validan los campos
	if(f.marca.value=="")
	{
		alert("Debe ingresar la marca del Software");
		f.marca.focus();
		return false;
	}
	f.marca.value=f.marca.value.toUpperCase();
	if(f.nombre.value=="")
	{
		alert("Debe ingresar el Nombre del Producto");
		f.nombre.focus();
		return false;
	}
	f.nombre.value=f.nombre.value.toUpperCase();
	if(f.tipo.value==0)
	{
		alert("Debe seleccionar el tipo de Software");
		f.tipo.focus();
		return false;
	}
	/*if(f.rut_proveedor.value==0)
	{
		alert("Debe seleccionar el Proveedor");
		f.rut_proveedor.focus();
		return false;
	}
	f.nro_factura.value=f.nro_factura.value.toUpperCase();
	f.version.value=f.version.value.toUpperCase();
	f.descripcion.value=f.descripcion.value.toUpperCase();
	if(f.fecha_compra.value!="")
	{
		//se valida la fecha
		var dia,mes,ano,foobar;
		foobar=new Array();
		foobar=f.fecha_compra.value.split("-");
		dia=foobar[0];
		mes=foobar[1];
		ano=foobar[2];
		if(isNaN(dia) || dia < 1 || dia.toString().length > 2)
		{
			alert("El dia ingresado no es valido");
			f.fecha_compra.focus();
			return false;
		}
		if(isNaN(mes) || mes < 1 || mes.toString().length > 2)
		{
			alert("El mes ingresado no es valido");
			f.fecha_compra.focus();
			return false;
		}
		if(isNaN(ano) || ano < 1 || ano.toString().length < 4)
		{
			alert("El año ingresado no es valido");
			f.fecha_compra.focus();
			return false;
		}
	}
	else
	{
		alert("Debe ingresar una Fecha de Compra");
		f.fecha_compra.focus();
		return false;
	}*/
	f.action="ingreso_datos.php?op=4";
	f.submit();
	return true;
}
</script>
</head>

<body onLoad="javascript: document.frmIngresoSW.marca.focus();">
<form name="frmIngresoSW" method="post">
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
		<td class="ColorTabla01" align="center"><strong>Informaci&oacute;n del Software.</strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
		<table width="550" border="0" cellpadding="0" cellspacing="2" align="center">
		<tr>
			<td width="200" style="border:solid 1px #666666;">Marca:</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" name="marca" maxlength="30" size="30"></td>
		</tr>
		<tr>
			<td style="border:solid 1px #666666;">Nombre:</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" name="nombre" maxlength="30" size="30"></td>
		</tr>
		<tr>
			<td style="border:solid 1px #666666;">Versi&oacute;n:</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" name="version" maxlength="10" size="15"></td>
		</tr>
		<tr>
			      <td style="border:solid 1px #666666;">Numero de Licencias:</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" name="nro_licencia" maxlength="4" size="4"></td>
		</tr>
		<tr>
			<td style="border:solid 1px #666666;">Tipo:</td>
			<td>&nbsp;&nbsp;
			<select name="tipo">
			<option value="0" selected>Seleccione un tipo</option>
			<?php
			$query="select nombre_subclase as nombre from sub_clase where cod_clase=18000;";
			$result=mysql_db_query("proyecto_modernizacion",$query,$link);
			while($resp=mysql_fetch_array($result))
				echo '<option value="'.$resp["nombre"].'">'.$resp["nombre"].'</option>';
			mysql_free_result($result);
			?>
			</select>
			</td>
		</tr>
		<tr>
			<td style="border:solid 1px #666666;">Fecha de Compra:</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" name="fecha_compra" maxlength="10" size="15">
			&nbsp;&nbsp;&nbsp;&nbsp;Formato: dd-mm-yyyy</td>
		</tr>
		<tr>
			<td style="border:solid 1px #666666;">N&uacute;mero de Factura:</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" name="nro_factura" maxlength="20" size="25"></td>
		</tr>
		<tr>
			<td style="border:solid 1px #666666;">Proveedor:</td>
			<td>&nbsp;&nbsp;
			<select name="rut_proveedor">
			<option value="0" selected>Seleccione un Proveedor</option>
			<?php
			$query="select rut,razon_social from proveedor;";
			$result=mysql_db_query("cia_web",$query,$link);
			while($resp=mysql_fetch_array($result))
				echo '<option value="'.$resp["rut"].'">'.$resp["razon_social"].'</option>';
			?>
			</select>
			</td>
		</tr>
		<tr>
			<td style="border:solid 1px #666666;">Observaciones:</td>
			<td>&nbsp;&nbsp;&nbsp;<textarea name="descripcion" cols="30" rows="3"></textarea></td>
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
	<input type="reset" name="limpiar" value="Limpiar" style="width: 80px;">
	&nbsp;&nbsp;&nbsp;
	<input type="submit" name="Enviar" onClick="return validar()" value="Ingresar" style="width: 80px;">
	&nbsp;&nbsp;&nbsp;
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
