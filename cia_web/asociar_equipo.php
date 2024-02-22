<?php
//popup para asociar una parte con un equipo
include("../principal/conectar_principal.php");
if(isset($op))	//se debe mostrar resultados de la busqueda
{
	//se verifica si esta marcada la opcion para no realizar busqueda
	if($no_buscar=="on")
		$query="select codigo,marca,modelo,nro_serie from cia_web.hardware where tipo='EQUIPO' and estado!=5;";
	else
	{
		//se verifica que tipo de busqueda se desea realizar
		$query="select codigo,marca,modelo,nro_serie from cia_web.hardware where tipo='EQUIPO' and estado!=5 ";
		switch($buscar_por)
		{
			case "usuario": //busqueda de equipo por usuario
				$query.="and nro_asociacion_activa in (select nro_asoc from cia_web.asoc_equipos_usuarios ";
				if($campo_user=="rut")
					$query.="where rut_usuario like '%".$buscar."%' and estado_asoc='1');";
				else
				{
					$query.="where rut_usuario in (select RUT from bd_rrhh.antecedentes_personales where";
					$query.=" ".$campo_user." like '%".$buscar."%') and estado_asoc='1');";
				}
				break;
			case "ubicacion":	//busqueda por ubicacion
				$query.="and nro_asociacion_activa in (select nro_asoc from cia_web.asoc_equipos_usuarios ";
				if($campo_ubi=="cod_cc")
					$query.="where cc_ubicacion like '%".$buscar."%' and estado_asoc='1');";
				else
				{
					$query.="where cc_ubicacion in (select centro_costo from proyecto_modernizacion.centro_costo";
					$query.=" where descripcion like '%".$buscar."%') and estado_asoc='1');";
				}
				break;
			default:
				$query.="and ".$buscar_por." like '%".$buscar."%';";
				break;	
		}
	}
	$result=mysql_query($query,$link);
	$cant=mysql_num_rows($result);
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
function cambiar()
{
	var f=document.frmAsociarEquipo;
	switch(f.buscar_por.value)
	{
		case "0":
			f.campo_user.style.width="0"; f.campo_user.style.visibility="hidden";
			f.campo_ubi.style.width="0"; f.campo_ubi.style.visibility="hidden";
			f.buscar.style.width="0"; f.buscar.style.visibility="hidden";
			break;
		case "usuario":
			f.campo_user.style.width="120"; f.campo_user.style.visibility="visible";
			f.campo_ubi.style.width="0"; f.campo_ubi.style.visibility="hidden";
			f.buscar.style.width="200"; f.buscar.style.visibility="visible";
			break;
		case "ubicacion":
			f.campo_user.style.width="0"; f.campo_user.style.visibility="hidden";
			f.campo_ubi.style.width="150"; f.campo_ubi.style.visibility="visible";
			f.buscar.style.width="200"; f.buscar.style.visibility="visible";
			break;
		default:
			f.campo_user.style.width="0"; f.campo_user.style.visibility="hidden";
			f.campo_ubi.style.width="0"; f.campo_ubi.style.visibility="hidden";
			f.buscar.style.width="200"; f.buscar.style.visibility="visible";
			break;
	}
}

function no()
{
	var f=document.frmAsociarEquipo;
	
	f.buscar_por.disabled=f.no_buscar.checked;
	f.buscar.disabled=f.no_buscar.checked;
	f.campo_user.disabled=f.no_buscar.checked;
	f.campo_ubi.disabled=f.no_buscar.checked;
}

function busqueda(cod_parte)
{
	var f= document.frmAsociarEquipo;
	
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
	f.action="asociar_equipo.php?op=1&cod_parte=" + cod_parte;
	f.target="_self";
	f.submit();
}

function crear_asociacion(codigo_parte,cant)
{
	var f=document.frmAsociarEquipo;
	if(confirm("¿Seguro que desea asociar este equipo?"))
	{
		//se valida la eleccion
		if(cant==1)
		{
			if(!f.codigo_equipo.checked)
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
				if(f.codigo_equipo[i].checked)
					break;
			}
			if(i==cant)
			{
				alert("Debe seleccionar un equipo para continuar");
				return false;
			}
		}
		f.action="actualizar_datos.php?op=7&codigo_parte=" + codigo_parte;
		f.submit();
		return true;
	}
}
</script>
</head>

<body bgcolor="#CCCCCC">
<form name="frmAsociarEquipo" method="post">
<!---------------------------------- cuerpo de la pagina ------------------------------------->
<table width="500" class="TablaPrincipal" cellpadding="0" cellspacing="0" border="0" align="center">
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>
	<table width="470" border="0" class="TablaInterior" align="center">
	<tr>
		    <td class="ColorTabla01" align="center"><strong>INFORMACI&Oacute;N 
              DEL EQUIPO</strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
		<table cellpadding="0" cellspacing="2" border="0" width="440" align="center" style="border:solid 2px #000000;">
		<tr>
			<td colspan="2" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Busqueda de Equipos</td>
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
			<option value="usuario">Usuario</option>
			<option value="ubicacion">Ubicaci&oacute;n</option>
			</select>
			</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td align="center" colspan="2">
			<select name="campo_user" style="width: 0px; visibility: hidden;">
			<option value="RUT" selected>Rut</option>
			<option value="APELLIDO_PATERNO">Apellido Paterno</option>
			<option value="APELLIDO_MATERNO">Apellido Materno</option>
			<option value="NOMBRES">Nombres</option>
			</select>
			<select name="campo_ubi" style="width: 0px; visibility: hidden;">
			<option value="cod_cc" selected>Codigo Centro Costo</option>
			<option value="nom_cc">Nombre Centro Costo</option>
			</select>
			<input type="text" name="buscar" value="" size="35" maxlength="40" style="width: 0px; visibility: hidden;">
			</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td colspan="2" align="center">
			<input type="checkbox" name="no_buscar" onClick="no()">No buscar. Ver Todos los Equipos
			</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td colspan="2" align="center">
			<input type="button" name="Buscar" value="Buscar" style="width: 80px;" onClick="busqueda('<?php echo $cod_parte;?>')">
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
		echo '<td align="center" style="border:solid 1px #666666;"><input type="radio" name="codigo_equipo" value="'.$resp["codigo"].'"></td>';
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
			<input type="button" name="asociar" style="width: 80px;" value="Asociar" onClick="crear_asociacion(\''.$cod_parte.'\','.$cant.')"></td>
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
	<td align="center"><input type="button" name="Cerrar" style="width: 80px;" value="Cancelar" onClick="javascript: window.close();"></td>
</tr>
<tr><td>&nbsp;</td></tr>
</table>

</form>
</body>
</html>
