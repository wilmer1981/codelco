<?
    $var=explode(";",$valor);
$cod=$var[0];
$tipo=$var[1];
//echo ($cod);
//echo ($tipo);
include("../principal/conectar_principal.php");
	
?>
	<?php 
		$query="select nro_asociacion_activa as nro_asoc from cia_web.hardware where codigo='".$cod."'";
		$res_tmp=mysql_db_query("cia_web",$query,$link);
	    $r_tmp=mysql_fetch_array($res_tmp);
	    mysql_free_result($res_tmp);
		$nro_asoc=$r_tmp["nro_asoc"];
			
		
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
<script language="JavaScript" type="text/javascript">

function hoy(opcion)
{
	var f=document.frmIngresoFallas;
	if(opcion==1)
		f.fecha_inicio.disabled=f.f_inicio.checked;
	else
		f.fecha_termino.disabled=f.f_termino.checked;
}

function registrar(nro_asoc,cod,tipo)
{
//alert(nro_asoc);
//alert(cod);
	var f=document.frmIngresoFallas;
	var dia,mes,ano,foobar;
	//alert('entre');
	//se validan los datos
	if(!f.f_inicio.checked)
	{
		if(f.fecha_inicio.value!="")
		{
			foobar=new Array();
			foobar=f.fecha_inicio.value.split("-");
			dia=foobar[0];
			mes=foobar[1];
			ano=foobar[2];
			if(isNaN(dia) || dia < 1 || dia.toString().length > 2)
			{
				alert("El dia ingresado no es valido");
				f.fecha_inicio.focus();
				return false;
			}
			if(isNaN(mes) || mes < 1 || mes.toString().length > 2)
			{
				alert("El mes ingresado no es valido");
				f.fecha_inicio.focus();
				return false;
			}
			if(isNaN(ano) || ano < 1 || ano.toString().length < 4)
			{
				alert("El año ingresado no es valido");
				f.fecha_inicio.focus();
				return false;
			}
		}
		else
		{
			alert("Debe ingresar la Fecha de Inicio");
			f.fecha_inicio.focus();
			return false;
		}
	}
	if(!f.f_termino.checked)
	{
		if(f.fecha_termino.value!="")
		{
			foobar=new Array();
			foobar=f.fecha_termino.value.split("-");
			dia=foobar[0];
			mes=foobar[1];
			ano=foobar[2];
			if(isNaN(dia) || dia < 1 || dia.toString().length > 2)
			{
				alert("El dia ingresado no es valido");
				f.fecha_termino.focus();
				return false;
			}
			if(isNaN(mes) || mes < 1 || mes.toString().length > 2)
			{
				alert("El mes ingresado no es valido");
				f.fecha_termino.focus();
				return false;
			}
			if(isNaN(ano) || ano < 1 || ano.toString().length < 4)
			{
				alert("El año ingresado no es valido");
				f.fecha_termino.focus();
				return false;
			}
		}
		else
		{
			alert("Debe ingresar la Fecha de Termino");
			f.fecha_termino.focus();
			return false;
		}
	}
	if(f.duracion.value=="")
	{
		alert("Debe ingresar la duración aproximada del Trabajo Realizado");
		f.duracion.focus();
		return false;
	}
	if(isNaN(f.duracion.value))
	{
		alert("Debe ingresar valor valido para la duración del Trabajo");
		f.duracion.focus();
		return false;
	}
	if(f.causa.value.length < 3)
	{
		alert("Debe ingresar el detalle de la causa de la Falla");
		f.causa.focus();
		return false;
	}
	if(f.d_trabajo.value.length < 3)
	{
		alert("Debe ingresar el detalle del Trabajo realizado");
		f.d_trabajo.focus();
		return false;
	}
	
	//se ingresan los datos
	f.action="ingreso_datos.php?op=5&nro_asoc=" + nro_asoc + "&cod=" + cod + "&tipo=" + tipo + "$durac" + f.opcion_duracion.value;
	
	f.submit();
	return true;
}
</script>
</head>

<body bgcolor="#CCCCCC">
<form name="frmIngresoFallas" method="post">
<!---------------------------------- cuerpo de la pagina ------------------------------------->
<table width="500" class="TablaPrincipal" cellpadding="0" cellspacing="0" border="0" align="center">
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>
	<table width="470" border="0" class="TablaInterior" align="center">
	<tr>
	    <td class="ColorTabla01" align="center"><strong>REPORTE DE NUEVA FALLA</strong></td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	
	<!--   Tabla de Ingreso de Datos -->
	<tr>
		<td>
		<table width="400" align="center" border="0" cellpadding="0" cellspacing="3" style="border:solid 2px #000000;">
		<tr>
			      <td colspan="2" align="center" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC">Datos 
                    de la Falla y el Trabajo realizado</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td width="150" align="left" style="border:solid 1px #666666;">&nbsp;&nbsp;<strong>Tipo de Falla</strong></td>
			<td align="left">
			&nbsp;&nbsp;
			<select name="opcion1">
			<option value="EQUIPO" selected>Equipo</option>
			<option value="RED">Red</option>
			</select>
			&nbsp;&nbsp;&nbsp;
			<select name="opcion2">
			<option value="HARDWARE" selected>Hardware</option>
			<option value="SOFTWARE">Software</option>
			</select>
			</td>
		</tr>
		<tr>
			<td align="left" style="border:solid 1px #666666;">&nbsp;&nbsp;<strong>Acci&oacute;n Realizada</strong></td>
			<td align="left">
			&nbsp;&nbsp;
			<input type="radio" name="accion" value="REPARACION" checked>Reparaci&oacute;n
			&nbsp;&nbsp;
			<input type="radio" name="accion" value="MANTENCION">Mantenci&oacute;n
			</td>
		</tr>
		<tr>
			<td align="left" style="border:solid 1px #666666;">&nbsp;&nbsp;<strong>Fecha de Inicio</strong></td>
			<td align="left">
			&nbsp;&nbsp;
			<input type="text" name="fecha_inicio" maxlength="10" size="17" value="dd-mm-yyyy">
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="f_inicio" onClick="hoy(1)">Hoy
			</td>
		</tr>
		<tr>
			<td align="left" style="border:solid 1px #666666;">&nbsp;&nbsp;<strong>Fecha de Termino</strong></td>
			<td align="left">
			&nbsp;&nbsp;
			<input type="text" name="fecha_termino" maxlength="10" size="17" value="dd-mm-yyyy">
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="f_termino" onClick="hoy(2)">Hoy
			</td>
		</tr>
		<tr>
			<td align="left" style="border:solid 1px #666666;">&nbsp;&nbsp;<strong>Duraci&oacute;n</strong></td>
			<td align="left">
			&nbsp;&nbsp;
			<input type="text" name="duracion" maxlength="5" size="8">
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="left">
			&nbsp;&nbsp;
			<input type="radio" name="opcion_duracion" value="MIN" checked>Minutos
			&nbsp;&nbsp;
			<input type="radio" name="opcion_duracion" value="HORAS">Horas
			&nbsp;&nbsp;
			<input type="radio" name="opcion_duracion" value="DIAS">D&iacute;as
			</td>
		</tr>
		</table> 
		</td>
	</tr>
	<!--  fin tabla ingreso de datos -->
	
	<tr><td>&nbsp;</td></tr>
	
	<!-- Tabla ingreso de DEtalle FAlla -->
	<tr>
		<td>
		<table width="400" align="center" border="0" cellpadding="0" cellspacing="3" style="border:solid 2px #000000;">
		<tr>
			<td colspan="2" align="center" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC">Detalle de la Falla</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td width="150" align="left" style="border:solid 1px #666666;">&nbsp;&nbsp;<strong>Causa</strong></td>
			<td align="left">
			&nbsp;&nbsp;
			<textarea name="causa" rows="3" cols="20"></textarea>
			</td>
		</tr>
		<tr>
			<td width="150" align="left" style="border:solid 1px #666666;">&nbsp;&nbsp;<strong>Descripci&oacute;n Trabajo</strong></td>
			<td align="left">
			&nbsp;&nbsp;
			<textarea name="d_trabajo" rows="3" cols="20"></textarea>
			</td>
		</tr>
		<tr>
			<td width="150" align="left" style="border:solid 1px #666666;">&nbsp;&nbsp;<strong>Insumos Comprados</strong></td>
			<td align="left">
			&nbsp;&nbsp;
			<textarea name="insumos" rows="3" cols="20"></textarea>
			</td>
		</tr>
		</table>
		</td>
	</tr>
	<!-- fin Tabla ingreso Detalle Falla -->
	
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td align="center">
	
		
		<input type="button" name="ingresar" value="Ingresar" onClick="registrar(<?php echo "'".$nro_asoc."','".$cod."','".$tipo."'";?>)" style="width: 80px;">
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
	<input type="button" name="Cerrar" value="Cerrar" onClick="javascript: window.close();" style="width: 80px;">
	</td>
</tr>
<tr><td>&nbsp;</td></tr>
</table>
</td>

</form>
</body>
</html>
