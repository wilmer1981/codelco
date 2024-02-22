<?php
//pagina para mostrar el detalle de un software

include("../principal/conectar_principal.php");

if(!isset($foo))
	$foo=0;

//se recupera la informacion del software
$query="select * from software where codigo='".$codigo."';";
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

function to_excel(codigo)
{
	var URL,opciones;
	URL="ToExcel/ver_sw_excel.php?codigo=" + codigo;
	opciones="toolbar=0,resizable=0,menubar=1,status=0";
	verificar_popup(popup);
	popup=window.open(URL,"",opciones);
	popup.focus();
	popup.resizeTo(parseInt(screen.availWidth),parseInt(screen.availHeight));
	popup.moveTo(0,0);
}

function guardar(codigo,foo)
{
	var f=document.frmDetalleSW;
	//se validan los datos ingresados
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
	//se llevan a mayusculas los datos
	f.nro_factura.value=f.nro_factura.value.toUpperCase();
	f.version_sw.value=f.version_sw.value.toUpperCase();
	f.descripcion.value=f.descripcion.value.toUpperCase();
		
	if(confirm("¿Seguro que desea guardar los cambios en los datos del Software?"))
	{
		f.action="actualizar_datos.php?op=13&codigo=" + codigo + "&foo=" + foo;
		f.submit();
	}
	return true;
}
</script>
</head>

<body bgcolor="#CCCCCC" onUnload="verificar_popup(popup)">
<form name="frmDetalleSW" method="post">
<!---------------------------------- cuerpo de la pagina ------------------------------------->
<table width="530" class="TablaPrincipal" cellpadding="0" cellspacing="0" border="0" align="center">
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>
	<table width="500" border="0" class="TablaInterior" align="center">
	<tr>
		<td class="ColorTabla01" align="center"><strong>DETALLE SOFTWARE</strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
		<table cellpadding="0" cellspacing="2" border="0" style="border:solid 2px #000000;" width="450" align="center">
		<tr>
			<td style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center" colspan="2">Informaci&oacute;n Software</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Codigo</strong></td>
			      <td>&nbsp;&nbsp;&nbsp;<?php echo $resp["codigo"];?></td>
		</tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Marca</strong></td>
			<td>&nbsp;&nbsp;
			<input type="text" name="marca" value="<?php echo $resp["marca"];?>" maxlength="30" size="35">
			</td>
		</tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Nombre</strong></td>
			<td>&nbsp;&nbsp;
			<input type="text" name="nombre" value="<?php echo $resp["nombre"];?>" maxlength="30" size="35">
			</td>
		</tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Versi&oacute;n</strong></td>
			<td>&nbsp;&nbsp;
			<input type="text" name="version_sw" value="<?php echo $resp["version_sw"];?>" maxlength="10" size="15">
			</td>
		</tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Tipo</strong></td>
			<td>&nbsp;&nbsp;&nbsp;<select name="tipo">
			<option value="">Seleccione un Tipo</option>
			<?php
			//se recuperan los tipos de softwares
			$query="select nombre_subclase as nom from sub_clase where cod_clase=18000;";
			$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
			while($r=mysql_fetch_array($res_tmp))
			{
				echo '<option value="'.$r["nom"].'"';
				if($resp["tipo"]==$r["nom"])
					echo ' selected';
				echo '>'.$r["nom"].'</option>';
			}
			mysql_free_result($res_tmp);
			?>
			</select>
			</td>
		</tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Fecha Compra</strong></td>
			<td>&nbsp;&nbsp;&nbsp;
			<?php 
	$fecha=explode("-",$resp["fecha_compra"]);
	$fecha=$fecha[2]."-".$fecha[1]."-".$fecha[0];
	echo $fecha;
	?></td>
		</tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>N&uacute;mero de Factura</strong></td>
			<td>&nbsp;&nbsp;
			<input type="text" name="nro_factura" value="<?php echo $resp["nro_factura"];?>" maxlength="20" size="25">
			</td>
		</tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Proveedor</strong></td>
			<td>&nbsp;&nbsp;&nbsp;<select name="rut_proveedor">
			<option value="">Seleccione un Proveedor</option>
			<?php
			//se recuperan todos los proveedores
			$query="select rut,razon_social from proveedor;";
			$res_tmp=mysql_db_query("cia_web",$query,$link);
			while($r=mysql_fetch_array($res_tmp))
			{
				echo '<option value="'.$r["rut"].'"';
				if($resp["rut_proveedor"]==$r["rut"])
					echo ' selected';
				echo '>'.$r["razon_social"].'</option>';
			}
			mysql_free_result($res_tmp);
			?>
			</select>
			</td>
		</tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Descripci&oacute;n</strong></td>
			<td>&nbsp;&nbsp;
				<textarea name="descripcion" cols="30" rows="3" tabindex="10"><?php echo $resp["descripcion"];?>
				</textarea>
            </td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td colspan="2" style="border: solid 1px #666666;" align="center">
			&nbsp;
			<input type="button" name="Guardar" value="Guardar Cambios" onClick="guardar('<?php echo $resp["codigo"]."',".$foo;?>)" style="width: 105px;">
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
	<input type="button" name="ToExcel" value="Excel" style="width: 80px;" onClick="to_excel('<?php echo $codigo;?>')">&nbsp;&nbsp;&nbsp;
	<input type="button" name="Cerrar" value="Cerrar" onClick="javascript: window.close();" style="width: 80px;"></td>
</tr>
<tr><td>&nbsp;</td></tr>
</table>
</form>
</body>
</html>
