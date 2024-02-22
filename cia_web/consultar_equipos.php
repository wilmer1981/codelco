<?php
$CodigoDeSistema=18;
$CodigoDePantalla=7;
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
function mostrar()
{
	var f=document.frmConsultarEquipos;
	switch(f.buscar_por.value)
	{
		case 'ubicacion':
			f.buscar.style.width="0px"; f.buscar.style.visibility="hidden";
			//f.cmbEstado.style.width="130px"; f.cmbEstado.style.visibility="";
			f.cmbUsuario.style.width="0px"; f.cmbUsuario.style.visibility="hidden";			
			f.cmbProveedor.style.width="0px";f.cmbProveedor.style.visibility="hidden";
			f.cmbTipo.style.width="0px";f.cmbTipo.style.visibility="hidden";
			f.cmbUbicacion.style.width="300px";f.cmbUbicacion.style.visibility="visible";
			f.cmbUbicacion.focus();
			break;
		case 'estado':
			f.buscar.style.width="0px"; f.buscar.style.visibility="hidden";
			//f.cmbEstado.style.width="130px"; f.cmbEstado.style.visibility="visible";
			f.cmbUsuario.style.width="0px"; f.cmbUsuario.style.visibility="hidden";			
			f.cmbProveedor.style.width="0px";f.cmbProveedor.style.visibility="hidden";
			f.cmbTipo.style.width="0px";f.cmbTipo.style.visibility="hidden";
			f.cmbUbicacion.style.width="0px";f.cmbUbicacion.style.visibility="hidden";
			f.cmbEstado.focus();
			break;
		case 'proveedor':
			f.buscar.style.width="0px"; f.buscar.style.visibility="hidden";
			//f.cmbEstado.style.width="130px"; f.cmbEstado.style.visibility="";
			f.cmbTipo.style.width="0px";f.cmbTipo.style.visibility="hidden";
			f.cmbUsuario.style.width="0px"; f.cmbUsuario.style.visibility="hidden";			
			f.cmbProveedor.style.width="220px";f.cmbProveedor.style.visibility="visible";
			f.cmbUbicacion.style.width="0px";f.cmbUbicacion.style.visibility="hidden";
			f.cmbProveedor.focus();
			break;
		case 'usuario':
			f.buscar.style.width="150px"; f.buscar.style.visibility="visible";
			//f.cmbEstado.style.width="130px"; f.cmbEstado.style.visibility="";
			f.cmbUsuario.style.width="130px"; f.cmbUsuario.style.visibility="visible";
			f.cmbProveedor.style.width="0px"; f.cmbProveedor.style.visibility="hidden";
			f.cmbTipo.style.width="0px";f.cmbTipo.style.visibility="hidden";
			f.cmbUbicacion.style.width="0px";f.cmbUbicacion.style.visibility="hidden";
			f.buscar.value=""; f.buscar.focus();
			break;
		case 'tipo':
			f.buscar.style.width="0px"; f.buscar.style.visibility="hidden";
			//f.cmbEstado.style.width="130px"; f.cmbEstado.style.visibility="";
			f.cmbUsuario.style.width="0px"; f.cmbUsuario.style.visibility="hidden";
			f.cmbProveedor.style.width="0px"; f.cmbProveedor.style.visibility="hidden";
			f.cmbTipo.style.width="200px";f.cmbTipo.style.visibility="visible";
			f.cmbUbicacion.style.width="0px";f.cmbUbicacion.style.visibility="hidden";
			f.cmbTipo.focus();
			break;
		default:
			f.buscar.style.width="150px"; f.buscar.style.visibility="visible";
			//f.cmbEstado.style.width="130px"; f.cmbEstado.style.visibility="";
			f.cmbUsuario.style.width="0px"; f.cmbUsuario.style.visibility="hidden";
			f.cmbTipo.style.width="0px";f.cmbTipo.style.visibility="hidden";
			f.cmbProveedor.style.width="0px"; f.cmbProveedor.style.visibility="hidden";
			f.cmbUbicacion.style.width="0px";f.cmbUbicacion.style.visibility="hidden";
			if(f.buscar_por.value=="fecha_compra")
				f.buscar.value="dd-mm-yyyy";
			else
				f.buscar.value=""; 
			f.buscar.focus();
			break;
	}
}

function ver_todo()
{
	var f=frmConsultarEquipos;
	f.buscar_por.disabled=f.ver_todos.checked;
	if(f.ver_todos.checked)
	{
		f.buscar.style.width="0px"; f.buscar.style.visibility="hidden";
		//f.cmbEstado.style.width="0px"; f.cmbEstado.style.visibility="";
		f.cmbUsuario.style.width="0px"; f.cmbUsuario.style.visibility="hidden";
		f.cmbProveedor.style.width="0px"; f.cmbProveedor.style.visibility="hidden";
		f.cmbUbicacion.style.width="0px";f.cmbUbicacion.style.visibility="hidden";
		f.cmbTipo.style.width="0px";f.cmbTipo.style.visibility="hidden";
	}
	else
	{
		f.buscar.style.width="150px"; f.buscar.style.visibility="visible";
		f.buscar.value=""; f.buscar_por.focus();
		f.buscar_por.value="codigo";
	}
}

function Ver()
{
	var f=frmConsultarEquipos;
	
	//primero se valida la busqueda
	if(f.ver_todos.checked)
	{
		//if(f.buscar_por.value=="estado")
	//	{
			//if(f.cmbEstado.value=="0")
		//{
			//	alert("Debe seleccionar un estado");
			//	f.cmbEstado.focus();
			//	return false;
			//}
		//}else{
		if(f.buscar_por.value=="proveedor")
		{
			if(f.cmbProveedor.value=="0")
			{
				alert("Debe seleccionar un Proveedor");
				f.cmbProveedor.focus();
				return false;
			}
			if(f.cmbProveedor.value=="1")
			{
				alert("No se puede buscar por Proveedor. No existen registros de Proveedores. Seleccione otra opcion");
				f.buscar_por.focus();
				return false;
			}
		}
		else{
		if(f.buscar_por.value=="tipo")
		{
			if(f.cmbTipo.value=="0")
			{
				alert("Debe seleccionar una Tipo de Hardware");
				f.cmbTipo.focus();
				return false;
			}
			if(f.cmbTipo.value=="1")
			{
				alert("No se puede buscar por Tipo. No existen registros de tipos. Seleccione otra opcion");
				f.buscar_por.focus();
				return false;
			}
		}
		else{
		
		//if(f.cmbEstado.value=="0")
		//	{
		//		alert("Debe seleccionar un estado");
		//		f.cmbEstado.focus();
		//		return false;
		//	}	
		if(f.buscar_por.value=="ubicacion")
		{
			if(f.cmbUbicacion.value=="0")
			{
				alert("Debe seleccionar una Ubicacion");
				f.cmbUbicacion.focus();
				return false;
			}
			if(f.cmbUbicacion.value=="1")
			{
				alert("No se puede buscar por Ubicacion. No existen registros de Centros de Costo. Seleccione otra opcion");
				f.buscar_por.focus();
				return false;
			}
		}
		else{
		if((f.buscar.value=="" )&& (!f.ver_todos.checked))
		{
			alert("Debe ingresar algún parametro para realizar la busqueda")
			//f.buscar.focus();
			return false;
	//	}
		}
		}
		}
		}
	}
	f.action="ver_datos.php?op=3";
	f.submit();
	return true;	
}
</script>
<script type="text/javascript" src="funciones.js"></script>
</head>

<body onLoad="javascript: frmConsultarEquipos.buscar.focus()">
<form name="frmConsultarEquipos" method="post">
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
	<table width="600" border="0" class="TablaInterior" align="center" cellspacing="2">
	<tr>
		  <td class="ColorTabla01" align="center"><strong>Seleccione la Informaci&oacute;n que desea ver.</strong></td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td>
		<table width="500" border="0" cellspacing="2" cellpadding="0" align="center">
                <tr> 
                  <td width="150" align="center" style="border:solid 1px #666666;"><strong>Buscar 
                    por:</strong></td>
                  <td style="border:solid 1px #666666;"> <table border="0" width="100%" cellspacing="2" cellpadding="0">
                      <tr> 
                        <td align="left"> <select name="buscar_por" onChange="mostrar()">
                            <option value="codigo" selected>Codigo</option>
                            <option value="marca">Marca</option>
                            <option value="modelo">Modelo</option>
                            <option value="nro_serie">Nro. Serie</option>
                            <option value="p_garantia">Periodo Garantia</option>
                            <option value="nro_factura">Nro. Factura</option>
                            <option value="nro_guia">Nro. Guia</option>
                            <!--<option value="estado">Estado</option>!-->
                            <option value="fecha_compra">Fecha Compra</option>
							<option value="cod_activo_fijo">Cod. Activo Fijo</option>
                            <option value="proveedor">Proveedor</option>
                            <option value="usuario">Usuario</option>
                            <option value="ubicacion">Ubicaci&oacute;n</option>
                            <option value="tipo">Tipo de Equipo</option>
                          </select>
						<!--<select name="cmbEstado" style="visibility: 'visible'; width: 130px;">
                            <option value="0" selected>Seleccione un estado</option>
                            <option value="1">Asignado</option>
                            <option value="2">Para Baja</option>
                            <option value="3">De Baja</option>
                            <option value="4">Disponible</option>
                          </select> !-->
                        </td>
                      </tr>
                      <tr> 
                        <td>&nbsp;</td>
                      </tr>
                      <tr> 
                        <td align="left"> <!--<select name="cmbEstado" style="visibility: 'hidden'; width: 0px;">
                            <option value="0" selected>Seleccione un estado</option>
                            <option value="1">Asignado</option>
                            <option value="2">Para Baja</option>
                            <option value="3">De Baja</option>
                            <option value="4">Disponible</option>!-->
                          </select><select name="cmbProveedor" style="visibility: 'hidden'; width: 0px;">
                            <option value="0" selected>Seleccione un Proveedor</option>
                            <?php
							//se recuperan todos los proveedores
							$query="select rut,razon_social from proveedor;";
							$res_tmp=mysql_db_query("cia_web",$query,$link);
							while($r=mysql_fetch_array($res_tmp))
								echo '<option value="'.$r["rut"].'">'.$r["razon_social"].'</option>';
							if(mysql_num_rows($res_tmp))
								mysql_free_result($res_tmp);
							else
								echo '<option value="1">NO HAY PROVEEDORES</option>';
							?>
                          </select><select name="cmbUsuario" style="visibility: 'hidden'; width: 0px;">
                            <option value="RUT" selected>Rut</option>
                            <option value="APELLIDO_PATERNO">Apellido Paterno</option>
                            <option value="APELLIDO_MATERNO">Apellido Materno</option>
                            <option value="NOMBRES">Nombres</option>
                          </select><input type="text" name="buscar" maxlength="35" size="30"><select name="cmbUbicacion" style="visibility: 'hidden'; width: 0px;">
                            <option value="0" selected>Seleccione una ubicaci&oacute;n</option>
                            <?php
						//se cargan todos los centros de costo
						  	$query="select centro_costo,descripcion from centro_costo order by(centro_costo);";
							$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
							while($r=mysql_fetch_array($res_tmp))
								echo '<option value="'.$r["centro_costo"].'">'.$r["centro_costo"].' - '.$r["descripcion"].'</option>';
							if(mysql_num_rows($res_tmp))
								mysql_free_result($res_tmp);
							else
								echo '<option value="1">NO HAY CENTROS DE COSTO</option>';
						  ?>
                          </select><select name="cmbTipo" style="visibility: 'hidden'; width: 0px;">
                            <option value="0" selected>Seleccione un Tipo de Equipo</option>
                            <?php
						  //se cargan todos los tipos de hardware
						  	$query="select nombre_subclase as nom,valor_subclase1 as val from sub_clase where cod_clase=18003;";
							$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
							while($r=mysql_fetch_array($res_tmp))
								echo '<option value="'.$r["val"].'">'.$r["nom"].'</option>';
							if(mysql_num_rows($res_tmp))
								mysql_free_result($res_tmp);
							else
								echo '<option value="1">NO HAY TIPOS DE HW REGISTRADOS</option>';
						  ?>
                          </select> </td>
                      </tr>
                      <tr> 
                        <td>&nbsp;</td>
                      </tr>
                      <tr> 
                        <td><input type="radio" name="opcion" value="EQUIPO" checked>
                          Equipo &nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="opcion" value="PARTE">
                          Parte </td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                      <tr> 
                        <td> <input type="checkbox" name="ver_todos" value="all" onClick="ver_todo()">
                         No Buscar. Ver Todos los Registros </td>
                      </tr>
                    </table></td>
                </tr>
                <tr> 
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr> 
                  <td colspan="2" align="center" style="border:solid 1px #666666;"> 
                    <input type="button" name="ver" value="Ver" style="width: 80px;" onClick="return Ver()"> 
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
