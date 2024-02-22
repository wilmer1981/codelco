<?php
//esta pagina requiere haber pasado previamente por la pagina: ingreso_equipos.php
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
<title>CIA_WEB</title>
<script language="JavaScript">
function validar(tipo)
{
	var f=document.frmDatosAdicionales; 
	//se valida la informacion adicional ingresada
	if(f.procesador.value=='0')
	{
		alert("Debe seleccionar un Procesador");
		f.procesador.focus();
		return false;
	}
	if(f.mhz.value=="")
	{
		alert("Debe ingresar la frecuencia del procesador");
		f.mhz.focus();
		return false;
	}
	var tmp;
	tmp=parseInt(f.mhz.value);
	if(isNaN(tmp) || tmp.toString().length < 3 )
	{
		alert("La frecuencia del procesador ingresada no es valida");
		f.mhz.focus();
		return false;
	}
	if(f.ram.value=="")
	{
		alert("Debe imgresar un valor para la memoria RAM");
		f.ram.focus();
		return false;
	}
	tmp=parseInt(f.ram.value);
	if(isNaN(tmp) || tmp.toString().length < 2)
	{
		alert("El valor ingresado para la memoria RAM no es valido");
		f.ram.focus();
		return false;
	}
	if(f.disco_duro.value=="")
	{
		alert("Debe ingresar un valor para el DISCO DURO");
		f.disco_duro.focus();
		return false;
	}
	tmp=parseInt(f.disco_duro.value);
	if(isNaN(tmp) || tmp.toString().length < 1 )
	{
		alert("El valor ingresado en DISCO DURO no es valido");
		f.procesador.focus();
		return false;
	}
	if(f.cant_seriales.value!="")
	{
		tmp=parseInt(f.cant_seriales.value);
		if(isNaN(tmp))
		{
			alert("El valor ingresado en la cantidad de seriales no es valido");
			f.cant_seriales.focus();
			return false;
		}
	}
	else
		f.cant_seriales.value=0;
	if(f.cant_paralelos.value!="")
	{
		tmp=parseInt(f.cant_paralelos.value);
		if(isNaN(tmp))
		{
			alert("El valor ingresado en la cantidad de paralelos no es valido");
			f.cant_paralelos.focus();
			return false;
		}
	}
	else
		f.cant_paralelos.value=0;
	if(tipo=="CMP;EQUIPO")
	{
	//se valida la informacion de los perifericos
	if(!f.no_mon.checked)
	{
		if(f.mon_marca.value=="")
		{
			alert("Debe ingresar la marca del Monitor");
			f.mon_marca.focus();
			return false;
		}
		f.mon_marca.value=f.mon_marca.value.toUpperCase();
		if(f.mon_modelo.value=="")
		{
			alert("Debe ingresar el modelo del Monitor");
			f.mon_modelo.focus();
			return false;
		}
		f.mon_modelo.value=f.mon_modelo.value.toUpperCase();
		if(f.mon_serie.value=="")
		{
			alert("Debe ingresar el Numero de Serie del Monitor");
			f.mon_serie.focus();
			return false;
		}
		f.mon_serie.value=f.mon_serie.value.toUpperCase();
		if(f.mon_garantia.value!="")
		{
			tmp=parseInt(f.mon_garantia.value);
			if(isNaN(tmp) || tmp < 0 || tmp.toString().length < 1)
			{
				alert("El valor ingresado para la garantia del Monitor no es valido");
				f.mon_garantia.focus();
				return false;
			}
		}
		else
			f.mon_garantia.value=0;
	}
	
	if(!f.no_kbd.checked)
	{
		if(f.kbd_marca.value=="")
		{
			alert("Debe ingresar la marca del Teclado");
			f.kbd_marca.focus();
			return false;
		}
		f.kbd_marca.value=f.kbd_marca.value.toUpperCase();
		if(f.kbd_modelo.value=="")
		{
			alert("Debe ingresar el modelo del Teclado");
			f.kbd_modelo.focus();
			return false;
		}
		f.kbd_modelo.value=f.kbd_modelo.value.toUpperCase();
		if(f.kbd_serie.value=="")
		{
			alert("Debe ingresar el Numero de Serie del Teclado");
			f.kbd_serie.focus();
			return false;
		}
		f.kbd_serie.value=f.kbd_serie.value.toUpperCase();
		if(f.kbd_garantia.value!="")
		{
			tmp=parseInt(f.kbd_garantia.value);
			if(isNaN(tmp) || tmp < 0 || tmp.toString().length < 1)
			{
				alert("El valor ingresado para la garantia del Teclado no es valido");
				f.kbd_garantia.focus();
				return false;
			}
		}
		else
			f.kbd_garantia.value=0;
	}
	
	if(!f.no_mou.checked)
	{
		if(f.mou_marca.value=="")
		{
			alert("Debe ingresar la marca del Mouse");
			f.mou_marca.focus();
			return false;
		}
		f.mou_marca.value=f.mou_marca.value.toUpperCase();
		if(f.mou_modelo.value=="")
		{
			alert("Debe ingresar el modelo del Mouse");
			f.mou_modelo.focus();
			return false;
		}
		f.mou_modelo.value=f.mou_modelo.value.toUpperCase();
		if(f.mou_serie.value=="")
		{
			alert("Debe ingresar el Numero de Serie del Mouse");
			f.mou_serie.focus();
			return false;
		}
		f.mou_serie.value=f.mou_serie.value.toUpperCase();
		if(f.mou_garantia.value!="")
		{
			tmp=parseInt(f.mou_garantia.value);
			if(isNaN(tmp) || tmp < 0 || tmp.toString().length < 1 )
			{
				alert("El valor ingresado para la garantia del Mouse no es valido");
				f.mou_garantia.focus();
				return false;
			}
		}
		else
			f.mou_garantia.value=0;
	}
	}
	
	f.action="ingreso_datos.php?op=2";
	f.submit();
	return true;
}

function no_incluido(opcion)
{
	var f=document.frmDatosAdicionales;
	switch(opcion)
	{
		case 1:		//monitor
			f.mon_marca.disabled=f.mon_modelo.disabled=f.no_mon.checked;
			f.mon_serie.disabled=f.mon_garantia.disabled=f.no_mon.checked;
			break;
		case 2:		//teclado
			f.kbd_marca.disabled=f.kbd_modelo.disabled=f.no_kbd.checked;
			f.kbd_serie.disabled=f.kbd_garantia.disabled=f.no_kbd.checked;
			break;
		case 3:		//mouse
			f.mou_marca.disabled=f.mou_modelo.disabled=f.no_mou.checked;
			f.mou_serie.disabled=f.mou_garantia.disabled=f.no_mou.checked;
			break;
	}
}
</script>
</head>

<body onLoad="javascript: frmDatosAdicionales.procesador.focus();">
<form name="frmDatosAdicionales" method="post" action="ingreso_datos.php?op=2">
<?php
//se crean variables con la información del equipo
echo '<input type="hidden" name="tipo" value="'.$tipo.'">';
echo '<input type="hidden" name="cmbMarca" value="'.$cmbMarca.'">';
echo '<input type="hidden" name="cmbModelo" value="'.$cmbModelo.'">';
echo '<input type="hidden" name="nro_serie" value="'.$nro_serie.'">';
echo '<input type="hidden" name="fecha_compra" value="'.$fecha_compra.'">';
echo '<input type="hidden" name="p_garantia" value="'.$p_garantia.'">';
echo '<input type="hidden" name="nro_factura" value="'.$nro_factura.'">';
echo '<input type="hidden" name="nro_guia" value="'.$nro_guia.'">';
echo '<input type="hidden" name="rut_proveedor" value="'.$rut_proveedor.'">';
echo '<input type="hidden" name="observaciones" value="'.$observaciones.'">';
echo '<input type="hidden" name="cod_activo_fijo" value="'.$cod_activo_fijo.'">';
?>
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
	<table width="700" border="0" class="TablaInterior" align="center">
	<tr>
		  <td class="ColorTabla01" align="center"><strong>Informaci&oacute;n Adicional 
            del Computador y sus Perifericos.</strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
		
		<!------------------------- Tabla Info. Pc --------------------->
		<table align="center" class="TablaDetalle02" width="500" cellspacing="2">
		<tr>
			    <td colspan="3" bgcolor="#999999" align="center" style="border:solid 1px #666666;">
				<font color="#FFFFFF"><strong>Informaci&oacute;n del Computador</strong></font>
				</td>
		</tr>
		<tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<td width="180" align="right" style="border:solid 1px #666666;">Procesador:</td>
			<td width="200">&nbsp;&nbsp;&nbsp;
			<select name="procesador">
			<option value="0" selected>Seleccione el procesador</option>
			<?php
			$query="select nombre_subclase as name from sub_clase where cod_clase=18002;";
			$result=mysql_db_query("proyecto_modernizacion",$query);
			while($resp=mysql_fetch_array($result))
				echo '<option value="'.$resp["name"].'">'.$resp["name"].'</option>';
			mysql_free_result($result);
			?>
			</select>
			</td>
			<td>
			<input type="text" name="mhz" maxlength="5" size="7">&nbsp;&nbsp;MHZ
			</td>
		</tr>
		<tr>
			<td align="right" style="border:solid 1px #666666;">Memoria RAM:</td>
			<td colspan="2">&nbsp;&nbsp;&nbsp;
			<input type="text" name="ram" maxlength="8" size="10">&nbsp;&nbsp;&nbsp;MB
			</td>
		</tr>
		<tr>
			<td align="right" style="border:solid 1px #666666;">Disco Duro:</td>
			<td colspan="2">&nbsp;&nbsp;&nbsp;
			<input type="text" name="disco_duro" maxlength="8" size="10">&nbsp;&nbsp;&nbsp;GB
			</td>
		</tr>
		<tr>
			<td align="right" style="border:solid 1px #666666;">Cantidad de Puertos Seriales:</td>
			<td colspan="2">&nbsp;&nbsp;&nbsp;
			<input type="text" name="cant_seriales" maxlength="8" size="10">
			</td>
		</tr>
		<tr>
			<td align="right" style="border:solid 1px #666666;">Cantidad de Puertos Paralelos:</td>
			<td colspan="2">&nbsp;&nbsp;&nbsp;
			<input type="text" name="cant_paralelos" maxlength="8" size="10">
			</td>
		</tr>
		</table>
		<?php
		if($tipo!="NBK;EQUIPO")
		{
		echo '<br><br>
		<!---------------------- Tabla Info. Perifericos ----------------->
		<table align="center" class="TablaDetalle02" width="600" cellspacing="2">
		<tr>
			      <td colspan="3" bgcolor="#999999" align="center"> <font color="#FFFFFF"><strong>Informaci&oacute;n 
                    de Dispositivos Perifericos</strong></font></td>
		</tr>
		<tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			
			<!------------------------ Tabla Monitor ------------------------->
			<td width="200">
			<table width="100%" class="TablaDetalle" cellspacing="2">
			<tr>
				<td colspan="2" align="center" bgcolor="#CCCCCC" style="border:solid 1px #666666;"><font color="#0000CC">Monitor</font></td>
			</tr> 
			<tr>
				<td style="border:solid 1px #666666;">Marca:</td>
				<td><input type="text" name="mon_marca" maxlength="30" size="25"></td>
			</tr>
			<tr>
				<td style="border:solid 1px #666666;">Modelo:</td>
				<td><input type="text" name="mon_modelo" maxlength="30" size="25"></td>
			</tr>
			<tr>
				<td style="border:solid 1px #666666;">N° Serie:</td>
				<td><input type="text" name="mon_serie" maxlength="20" size="25"></td>
			</tr>
			<tr>
				<td style="border:solid 1px #666666;">Garantia:</td>
				<td><input type="text" name="mon_garantia" maxlength="5" size="12"> Meses</td>
			</tr>
			<tr>
				<td colspan="2" align="center" style="border:solid 1px #666666;">
				<input type="checkbox" name="no_mon" onClick="no_incluido(1)">No Incluido
				</td>
			</tr>
			</table>
			</td>
			
			<!------------------------ Tabla Teclado ------------------------->
			<td width="200">
			<table width="100%" class="TablaDetalle" cellspacing="2">
			<tr>
				<td colspan="2" align="center" bgcolor="#CCCCCC" style="border:solid 1px #666666;"><font color="#0000CC">Teclado</font></td>
			</tr> 
			<tr>
				<td style="border:solid 1px #666666;">Marca:</td>
				<td><input type="text" name="kbd_marca" maxlength="30" size="25"></td>
			</tr>
			<tr>
				<td style="border:solid 1px #666666;">Modelo:</td>
				<td><input type="text" name="kbd_modelo" maxlength="30" size="25"></td>
			</tr>
			<tr>
				<td style="border:solid 1px #666666;">N° Serie:</td>
				<td><input type="text" name="kbd_serie" maxlength="20" size="25"></td>
			</tr>
			<tr>
				<td style="border:solid 1px #666666;">Garantia:</td>
				<td><input type="text" name="kbd_garantia" maxlength="5" size="12"> Meses</td>
			</tr>
			<tr>
				<td colspan="2" align="center" style="border:solid 1px #666666;">
				<input type="checkbox" name="no_kbd" onClick="no_incluido(2)">No Incluido
				</td>
			</tr>
			</table>
			</td>
			
			<!------------------------ Tabla Mouse ------------------------->
			<td>
			<table width="100%" class="TablaDetalle" cellspacing="2">
			<tr>
				<td colspan="2" align="center" bgcolor="#CCCCCC" style="border:solid 1px #666666;"><font color="#0000CC">Mouse</font></td>
			</tr> 
			<tr>
				<td style="border:solid 1px #666666;">Marca:</td>
				<td><input type="text" name="mou_marca" maxlength="30" size="25"></td>
			</tr>
			<tr>
				<td style="border:solid 1px #666666;">Modelo:</td>
				<td><input type="text" name="mou_modelo" maxlength="30" size="25"></td>
			</tr>
			<tr>
				<td style="border:solid 1px #666666;">N° Serie:</td>
				<td><input type="text" name="mou_serie" maxlength="20" size="25"></td>
			</tr>
			<tr>
				<td style="border:solid 1px #666666;">Garantia:</td>
				<td><input type="text" name="mou_garantia" maxlength="5" size="12"> Meses</td>
			</tr>
			<tr>
				<td colspan="2" align="center" style="border:solid 1px #666666;">
				<input type="checkbox" name="no_mou" onClick="no_incluido(3)">No Incluido
				</td>
			</tr>
			</table>
			</td>
		</tr>
		</table>
		</td>
	</tr>';
	}?>
	<tr>
		<td>&nbsp;</td>
	</tr>
	</table>
	</td>
</tr>
<tr align="center">
	<td>&nbsp;</td>
</tr>
<!---------------------- Botones --------------------->
<tr>
	<td align="center">
	<input type="reset" name="limpiar" value="Limpiar" style="width: 80px;">
	&nbsp;&nbsp;&nbsp;
	<input type="submit" name="Enviar" value="Ingresar" style="width: 80px;" onClick="return validar('<?php echo $tipo;?>')">
	&nbsp;&nbsp;&nbsp;
	<input type="button" name="Volver" value="Volver" style="width: 80px;" onClick="javascript: history.back()">		
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
mysql_close();
?>
</form>
</body>
</html>
