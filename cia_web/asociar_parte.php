<?php
//popup para asociar un equipo con una parte
include("../principal/conectar_principal.php");
if(isset($op))	//se debe mostrar resultados de la busqueda
{
	//se verifica si esta marcada la opcion para no realizar busqueda
	if($no_buscar=="on")
		$query="select codigo,marca,modelo,nro_serie from hardware where tipo='PARTE' and estado=4";	//seleccionar todas las partes disponibles	
	else
		$query="select codigo,marca,modelo,nro_serie from hardware where ".$buscar_por." like '%".$buscar."%' and tipo='PARTE' and estado<>1;";
	$result=mysql_db_query("cia_web",$query,$link);
	$cant=mysql_num_rows($result);
	//echo $query; 
}
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
function no()
{
	var f=document.frmAsociarParte;
	
	f.buscar_por.disabled=f.buscar.disabled=f.no_buscar.checked;
}

function busqueda(codigo_equipo)
{
	var f= document.frmAsociarParte;
	
	//se validan los campos
	if(!f.no_buscar.checked)
	{
		if(f.buscar_por.value==0)
		{
			alert("Debe seleccionar un campo de busqueda");
			return false;
		}
		if(f.buscar.value=="")
		{
			alert("Debe ingresar algun parametro para realizar la busqueda");
			return false;
		}
	}
	f.action="asociar_parte.php?op=1&codigo_equipo=" + codigo_equipo;
	f.target="_self";
	f.submit();
}

function cambiar()
{
	if(document.frmAsociarParte.buscar_por.value=="fecha_compra")
		document.frmAsociarParte.buscar.value="yyyy-mm-dd";
	else
		document.frmAsociarParte.buscar.value="";
}

function terminar()
{
	window.close();
	opener.focus();
}

function crear_asociacion(codigo_equipo,cant)
{
	var f=document.frmAsociarParte;
	//se valida la eleccion
	if(cant==1)
	{
		if(!f.codigo_parte.checked)
		{
			alert("Debe seleccionar un equipo para continuar");
			return false;
		}
	}
	else
	{
		var i;
		for(i=0;i<cant;i++)
		{
			if(f.codigo_parte[i].checked)
				break;
		}
		if(i==cant)
		{
			alert("Debe seleccionar un equipo para continuar");
			return false;
		}
	}
	if(confirm("¿Seguro que desea asociar este equipo?"))
	{
		f.action="actualizar_datos.php?op=5&codigo_equipo=" + codigo_equipo;
		f.submit();
		return true;
	}
}
</script>
</head>

<body bgcolor="#CCCCCC" onLoad="javascript: document.frmAsociarParte.buscar_por.focus();">
<form name="frmAsociarParte" method="post">
<!---------------------------------- cuerpo de la pagina ------------------------------------->
<table width="500" class="TablaPrincipal" cellpadding="0" cellspacing="0" border="0" align="center">
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>
	<table width="470" border="0" class="TablaInterior" align="center">
	<tr>
		<td class="ColorTabla01" align="center"><strong>INFORMACI&Oacute;N DE LA PARTE</strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
		<table cellpadding="0" cellspacing="2" border="0" width="440" align="center" style="border:solid 2px #000000;">
		<tr>
			<td colspan="2" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Busqueda de Partes</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td align="right" width="167"><strong>Buscar Por:</strong></td>
			<td width="263" align="left">&nbsp;&nbsp;&nbsp;
			<select name="buscar_por" onChange="cambiar()">
			<option value="0" selected>Seleccione una opci&oacute;n</option>
			<option value="codigo">Codigo</option>
			<option value="marca">Marca</option>
			<option value="modelo">Modelo</option>
			<option value="nro_serie">Nro. de Serie</option>
			<option value="fecha_compra">Fecha Compra</option>
			<option value="nro_factura">Nro Factura</option> 
			<option value="nro_guia">Nro Guia</option>
			</select>
			</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td align="center" colspan="2">
			<input type="text" name="buscar" value="" size="40" maxlength="40">
			</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td colspan="2" align="center">
			<input type="checkbox" name="no_buscar" onClick="no()">No buscar. Ver Todas las partes
			</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td colspan="2" align="center">
			<input type="button" name="Buscar" value="Buscar" style="width: 80px;" onClick="busqueda('<?php echo $codigo_equipo;?>')">
			</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		</table>
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<?php
	if(isset($op))
	{
	echo '<tr>
		<td align="center">
		<table cellpadding="0" cellspacing="2" border="0" width="440" align="center" style="border:solid 2px #000000;">
		<tr>
			<td colspan="5" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Resultado de la busqueda</td>
		</tr>';
	if(!$cant)
	{
		echo '<tr><td>&nbsp;</td></tr>';
		echo '<tr><td align="center">';
		echo '<strong>No se hallaron resultados</strong>';
		echo '</td></tr>';
	}
	else
	{
	echo '<tr><td colspan="5">&nbsp;</td></tr>
		<tr>
			<td width="20">&nbsp;</td>
			<td align="center" style="border:solid 1px #666666"><strong>Codigo</strong></td>
			<td align="center" style="border:solid 1px #666666"><strong>Marca</strong></td>
			<td align="center" style="border:solid 1px #666666"><strong>Modelo</strong></td>
			<td align="center" style="border:solid 1px #666666"><strong>Nro Serie</strong></td>
		</tr>';
	while($resp=mysql_fetch_array($result))
	{
		echo '<tr>';
		echo '<td align="center" style="border:solid 1px #666666;"><input type="radio" name="codigo_parte" value="'.$resp["codigo"].'"></td>';
		echo '<td align="center" style="border:solid 1px #666666;">'.$resp["codigo"].'</td>';
		echo '<td align="center" style="border:solid 1px #666666;">&nbsp;'.$resp["marca"].'</td>';
		echo '<td align="center" style="border:solid 1px #666666;">&nbsp;'.$resp["modelo"].'</td>';
		echo '<td align="center" style="border:solid 1px #666666;">&nbsp;'.$resp["nro_serie"].'</td>';
		echo '</tr>';
	}
	}
	echo '<tr><td colspan="5">&nbsp;</td></tr>
		<tr>
			<td colspan="5" align="center">
			<input type="button" name="asociar" style="width: 80px;" value="Asociar" onClick="crear_asociacion(\''.$codigo_equipo.'\','.$cant.')"></td>
		</tr>
		<tr><td colspan="5">&nbsp;</td></tr>
		</table>
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>';
	}
	?>
	</table>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td align="center"><input type="button" name="Cerrar" style="width: 80px;" value="Cancelar" onClick="terminar()"></td>
</tr>
<tr><td>&nbsp;</td></tr>
</table>

</form>
</body>
</html>
