<?php
//popup para el cambio de usuario de un equipo
include("../principal/conectar_principal.php");
if(!isset($opcion))
	$opcion=1;
if(isset($op))
{
	//se realiza la busqueda
	$query="select RUT,NOMBRES,APELLIDO_PATERNO,APELLIDO_MATERNO,COD_CENTRO_COSTO from antecedentes_personales where";
	if($buscar_por=="cc")	//busqueda por centro costo
		$query.=" COD_CENTRO_COSTO like '%-".substr($centro_costo,0,2).".".substr($centro_costo,2,2)."'";
	else
		$query.=" ".$buscar_por." like '%".$buscar."%';";
	$result=mysql_db_query("bd_rrhh",$query,$link);
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
<script language="JavaScript" type="text/javascript" src="funciones.js"></script>
<script language="JavaScript" type="text/javascript">
var popup=0;
function validar(cant)
{
	var f=document.frmCambiarUser;
	var i=0;
	//se valida la eleccion
	if(cant==1)
	{
		if(!f.rut_user.checked)
		{
			alert("Debe seleccionar un usuario para continuar");
			return 'no';
		}
	}
	else
	{
		for(;i<cant;i++)
		{
			if(f.rut_user[i].checked)
				break;
		}
		if(i==cant)
		{
			alert("Debe seleccionar un usuario para continuar");
			return 'no';
		}
	}
	return i;
}

function ver_historial(cant)
{
	var f=document.frmCambiarUser,i;
	i=validar(cant);
	if(i!='no')
	{
		//se valida la eleccion de la opcion
		if(!f.opt_historial[0].checked && !f.opt_historial[1].checked)
		{
			alert("Debe seleccionar el tipo de historial que desea ver");
			f.opt_historial[0].focus();
			return false;
		}
		verificar_popup(popup);
		if(cant==1)
		{
			if(f.opt_historial[0].checked)
				popup=window.open('det_mov_user.php?rut_user=' + f.rut_user.value,"",'width=1010,height=500,scrollbars=yes');
			else
				popup=window.open('det_fallas_user.php?rut_user=' + f.rut_user.value,"",'width=1020,height=500,scrollbars=yes');
		}
		else
		{
			if(f.opt_historial[0].checked)
				popup=window.open('det_mov_user.php?rut_user=' + f.rut_user[i].value,"",'width=1010,height=500,scrollbars=yes');
			else
				popup=window.open('det_fallas_user.php?rut_user=' + f.rut_user[i].value,"",'width=1010,height=500,scrollbars=yes');
		}
		popup.focus();
		popup.moveTo(0,(screen.height-500)/2);
	}
}

function cambio_user(cod_equipo,nro_asoc,cant)
{
	var f=document.frmCambiarUser;
	var i=validar(cant);
	if(i!='no')
	{
		if(confirm("¿Seguro que desea asignar el equipo a este usuario?"))
		{
			f.action="actualizar_datos.php?op=9&cod_equipo=" + cod_equipo + "&nro_asoc=" + nro_asoc;
			f.submit();
			return true;
		}
	}
}

function cambiar()
{
	var f=document.frmCambiarUser;
	switch(f.buscar_por.value)
	{
		case 'cc':
			f.centro_costo.style.width="300px"; f.centro_costo.style.visibility="visible";
			f.buscar.style.width="0px"; f.buscar.style.visibility="hidden";
			break;
		case '0':
			f.centro_costo.style.width="0px"; f.centro_costo.style.visibility="hidden";
			f.buscar.style.width="0px"; f.buscar.style.visibility="hidden";
			break;
		default:
			f.centro_costo.style.width="0px"; f.centro_costo.style.visibility="hidden";
			f.buscar.style.width="220px"; f.buscar.style.visibility="visible";
			break;
	}
}

function asignar_user(codigo_equipo,cant)
{
	var f=document.frmCambiarUser;
	var i=validar(cant);
	if(i!='no')
	{
		if(confirm("¿Seguro que desea asignar el equipo a este usuario?"))
		{
			f.action="asignar_ubi.php?cod_equipo=" + codigo_equipo;
			f.submit();
			return true;
		}
	}
}

function busqueda(codigo_equipo,nro_asoc,opcion)
{
	var f= document.frmCambiarUser;
	
	//se validan los campos
	if(f.buscar_por.value==0)
	{
		alert("Debe seleccionar un campo de busqueda");
		f.buscar_por.focus();
		return false;
	}
	if(f.buscar_por.value=="cc")
	{
		if(f.centro_costo.value==0)
		{
			alert("Debe seleccionar un Centro de Costo");
			f.centro_costo.focus();
			return false;
		}
	}else
	{
		if(f.buscar.value=="")
		{
			alert("Debe ingresar algun parametro para realizar la busqueda");
			f.buscar.focus();
			return false;
		}
	}
	f.action="cambiar_user.php?op=1&codigo_equipo=" + codigo_equipo + "&nro_asoc=" + nro_asoc + "&opcion=" + opcion;
	f.target="_self";
	f.submit();
}
</script>
</head>

<body bgcolor="#CCCCCC" onUnload="verificar_popup(popup)">
<form name="frmCambiarUser" method="post">
<!---------------------------------- cuerpo de la pagina ------------------------------------->
<table width="600" class="TablaPrincipal" cellpadding="0" cellspacing="0" border="0" align="center">
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>
	<table width="570" border="0" class="TablaInterior" align="center">
	<tr>
		<td class="ColorTabla01" align="center"><strong>INFORMACI&Oacute;N DEL USUARIO</strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
		<table cellpadding="0" cellspacing="2" border="0" width="440" align="center" style="border:solid 2px #000000;">
		<tr>
			<td colspan="2" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Busqueda de Usuarios</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td align="right" width="167"><strong>Buscar Por:</strong></td>
			<td width="263" align="left">&nbsp;&nbsp;&nbsp;
			<select name="buscar_por" onChange="cambiar()">
			<option value="0" selected>Seleccione una opci&oacute;n</option>
			<option value="RUT">Rut</option>
			<option value="APELLIDO_PATERNO">Apellido Paterno</option>
			<option value="APELLIDO_MATERNO">Apellido Materno</option>
			<option value="NOMBRES">Nombre</option>
			<option value="cc">Centro Costo</option>
			</select>
			</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td align="center" colspan="2">
			<select name="centro_costo" style="width: 0px; visibility: hidden;">
			<option value="0" selected>Seleccione un centro de costo</option>
			<?php
			//se recuperan todos los centros de costo
			$query="select centro_costo,descripcion from centro_costo;";
			$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
			while($r_tmp=mysql_fetch_array($res_tmp))
				echo '<option value="'.$r_tmp["centro_costo"].'">'.$r_tmp["centro_costo"].' - '.$r_tmp["descripcion"].'</option>';
			mysql_free_result($res_tmp);
			?>
			</select>
			<input type="text" name="buscar" size="40" maxlength="40" style="width: 0px; visibility: hidden;">
			</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td colspan="2" align="center">
			<input type="button" name="Buscar" value="Buscar" style="width: 80px;" onClick="busqueda(<?php echo "'".$codigo_equipo."',".$nro_asoc.",".$opcion?>)">
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
		<table cellpadding="0" cellspacing="2" border="0" width="540" align="center" style="border:solid 2px #000000;">
		<tr>
			<td colspan="6" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Resultado de la busqueda</td>
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
	echo '<tr><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td width="20">&nbsp;</td>
			<td align="center" style="border:solid 1px #666666" width="80"><strong>Rut</strong></td>
			<td align="center" style="border:solid 1px #666666"><strong>Apellido Paterno</strong></td>
			<td align="center" style="border:solid 1px #666666"><strong>Apellido Materno</strong></td>
			<td align="center" style="border:solid 1px #666666"><strong>Nombres</strong></td>
			<td align="center" style="border:solid 1px #666666"><strong>Centro Costo</strong></td>
		</tr>';
	if($buscar_por=="cc")
	{
		//se recupera la informacion de ese centro de costo
		$query="select descripcion from centro_costo where centro_costo='".$centro_costo."';";
		$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
		$r_tmp=mysql_fetch_array($res_tmp);
		mysql_free_result($res_tmp);
		$cc=$centro_costo." - ".$r_tmp["descripcion"];
	}
	while($resp=mysql_fetch_array($result))
	{
		echo '<tr>';
		echo '<td align="center" style="border:solid 1px #666666;"><input type="radio" name="rut_user" value="'.$resp["RUT"].'"></td>';
		echo '<td align="center" style="border:solid 1px #666666;">'.$resp["RUT"].'</td>';
		echo '<td align="center" style="border:solid 1px #666666;">&nbsp;'.$resp["APELLIDO_PATERNO"].'</td>';
		echo '<td align="center" style="border:solid 1px #666666;">&nbsp;'.$resp["APELLIDO_MATERNO"].'</td>';
		echo '<td align="center" style="border:solid 1px #666666;">&nbsp;'.$resp["NOMBRES"].'</td>';
		echo '<td align="center" style="border:solid 1px #666666;">&nbsp;';
		if($buscar_por=="cc")
			echo $cc;
		else
		{
			//se recupera el nombre del centro de costo
			$var=substr($resp["COD_CENTRO_COSTO"],3,5);
			$var=explode(".",$var);
			$cc=$var[0].$var[1];
			$query="select descripcion from centro_costo where centro_costo='".$cc."';";
			$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
			$r_tmp=mysql_fetch_array($res_tmp);
			mysql_free_result($res_tmp);
			echo $cc." - ".$r_tmp["descripcion"];
		}
		echo '</td>';
		echo '</tr>';
	}
	echo '<tr><td colspan="6">&nbsp;</td></tr>
	<tr>
		<td colspan="6" align="center">';
		if($opcion==2)
		{
			echo '
			<table cellspacing="2" width="400">
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><input type="radio" name="opt_historial" value="mov">Historial de Movimientos</td>
			<td align="center" style="border:solid 1px #666666;"><input type="radio" name="opt_historial" value="fallas">Historial de Fallas</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td colspan="2" align="center">
			<input type="button" style="width: 80px;" name="Ver" value="Ver" onClick="ver_historial('.$cant.')">
			</td>
		</tr>
		</table>
		';
		}
		else
		{
		if($nro_asoc!=0)
			echo '<input type="button" name="cambiar_usuario" style="width: 80px;" value="Cambiar" onClick="cambio_user(\''.$codigo_equipo.'\','.$nro_asoc.','.$cant.')"></td>';
		else
			echo '<input type="button" name="asignar_usuario" style="width: 80px;" value="Asignar" onClick="asignar_user(\''.$codigo_equipo.'\','.$cant.')"></td>';
		}
	echo '</tr>';
	}
		echo '
		<tr><td colspan="6">&nbsp;</td></tr>
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
	<td align="center"><input type="button" name="Cerrar" style="width: 80px;" value="Cerrar" onClick="javascript: window.close();"></td>
</tr>
<tr><td>&nbsp;</td></tr>
</table>

</form>
</body>
</html>
