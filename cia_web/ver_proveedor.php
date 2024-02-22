<?php
//pagina para mostrar el detalle de un proveedor
$var=explode(";",$valor);
$cod=$var[0];

include("../principal/conectar_principal.php");

//se recupera la informacion del proveedor
$query="select * from proveedor, hardware where codigo= '".$cod."'and rut_proveedor = rut;";
$result=mysql_db_query("cia_web",$query,$link);
$resp=mysql_fetch_array($result);
mysql_free_result($result);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Cia Web</title>
<script type="text/javascript" src="funciones.js"></script>
<script language="JavaScript">
var popup=0;

function to_excel(valor)
{
	var URL,opciones;
	URL="ToExcel/ver_proveedor_excel.php?valor=" + valor;
	opciones="toolbar=0,resizable=0,menubar=1,status=0";
	verificar_popup(popup);
	popup=window.open(URL,"",opciones);
	popup.focus();
	popup.resizeTo(parseInt(screen.availWidth),parseInt(screen.availHeight));
	popup.moveTo(0,0);
}

function guardar(rut)
{
	var f=document.frmDetalleProveedor;
	//se validan los datos ingresados
	if(f.razon_social.value=="" || f.razon_social.value.length < 3)
	{
		alert("Debe ingresar un valor de Razon Social valido");
		f.razon_social.focus();
		return false;
	}
	//se llevan a mayusculas los datos
	f.razon_social.value=f.razon_social.value.toUpperCase();
	f.nombre_fantasia.value=f.nombre_fantasia.value.toUpperCase();
	f.contacto_1.value=f.contacto_1.value.toUpperCase();
	f.contacto_2.value=f.contacto_2.value.toUpperCase();
	f.fono_1.value=f.fono_1.value.toUpperCase();
	f.fono_2.value=f.fono_2.value.toUpperCase();
	f.fax.value=f.fax.value.toUpperCase();
	
	if(confirm("¿Seguro que desea guardar los cambios en los datos del Proveedor?"))
	{
		f.action="actualizar_datos.php?op=12&rut=" + rut;
		f.submit();
	}
	return true;
}
</script>
</head>

<body bgcolor="#CCCCCC" onUnload="verificar_popup(popup)">
<form name="frmDetalleProveedor" method="post">
<!---------------------------------- cuerpo de la pagina ------------------------------------->
<table width="530" class="TablaPrincipal" cellpadding="0" cellspacing="0" border="0" align="center">
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>
	<table width="500" border="0" class="TablaInterior" align="center">
	<tr>
		<td class="ColorTabla01" align="center"><strong>DETALLE PROVEEDOR</strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
		<table cellpadding="0" cellspacing="2" border="0" style="border:solid 2px #000000;" width="450" align="center">
		<tr>
			<td style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center" colspan="2">Informaci&oacute;n Proveedor</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Rut</strong></td>
			      <td>&nbsp;&nbsp;&nbsp;<?php echo $resp["rut"];?></td>
		</tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Raz&oacute;n Social</strong></td>
			<td>&nbsp;&nbsp;
			<input type="text" name="razon_social" value="<?php echo $resp["razon_social"];?>" maxlength="35" size="43">
			</td>
		</tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Nombre Fantasia</strong></td>
			<td>&nbsp;&nbsp;
			<input type="text" name="nombre_fantasia" value="<?php echo $resp["nombre_fantasia"];?>" maxlength="35" size="43">
			</td>
		</tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Contacto 1</strong></td>
			<td>&nbsp;&nbsp;
			<input type="text" name="contacto_1" value="<?php echo $resp["contacto_1"];?>" maxlength="30" size="30">
			</td>
		</tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Fono 1</strong></td>
			<td>&nbsp;&nbsp;
			<input type="text" name="fono_1" value="<?php echo $resp["fono_1"];?>" maxlength="15" size="17">
			&nbsp;&nbsp;&nbsp;
			</td>
		</tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Contacto 2</strong></td>
			<td>&nbsp;&nbsp;
			<input type="text" name="contacto_2" value="<?php echo $resp["contacto_2"];?>" maxlength="30" size="30">
			&nbsp;&nbsp;&nbsp;</td>
		</tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Fono 2</strong></td>
			<td>&nbsp;&nbsp;
			<input type="text" name="fono_2" value="<?php echo $resp["fono_2"];?>" maxlength="15" size="17">
			</td>
		</tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Fax</strong></td>
			<td>&nbsp;&nbsp;
			<input type="text" name="fax" value="<?php echo $resp["fax"];?>" maxlength="15" size="17">
			</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td colspan="2" style="border: solid 1px #666666;" align="center">
			&nbsp;
			<input type="button" name="Guardar" value="Guardar Cambios" onClick="guardar('<?php echo $resp["rut"];?>')" style="width: 105px;">
			</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
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
	<input type="button" name="ToExcel" value="Excel" style="width: 80px;" onClick="to_excel('<?php echo $valor;?>')">&nbsp;&nbsp;&nbsp;
	<input type="button" name="Cerrar" value="Cerrar" onClick="javascript: window.close();" style="width: 80px;"></td>
</tr>
<tr><td>&nbsp;</td></tr>
</table>
</form>
</body>
</html>
