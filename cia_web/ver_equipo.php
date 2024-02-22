<?php
//pagina para mostrar el detalle de un equipo
//requiere del codigo y del tipo de equipo
$var=explode(";",$valor);
$cod=$var[0];
$tipo=$var[1];
include("../principal/conectar_principal.php");

//se recuperan los datos del equipo
$query="select * from hardware where codigo='".$cod."';";
$result=mysql_db_query("cia_web",$query,$link);
$info_equipo=mysql_fetch_array($result);
mysql_free_result($result);
//se recuperan los datos de la asociacion
$query="select fecha_inicio,cc_ubicacion,rut_usuario from asoc_equipos_usuarios where ";
if($tipo=="EQUIPO")
	$query.="nro_asoc=".$info_equipo["nro_asociacion_activa"].";";
else
	$query.="nro_asoc IN (select nro_asoc_eq_user from asoc_partes_equipos where nro_asoc=".$info_equipo["nro_asociacion_activa"].");";
$result=mysql_db_query("cia_web",$query,$link);
$info_asoc=mysql_fetch_array($result);
$foobar=mysql_num_rows($result);
mysql_free_result($result);
//se recuperan los datos de los equipos asociados
if($tipo=="EQUIPO")
{
	//recuperan todos las partes asociadas a el
	$query="select cod_parte as cod_equipo from asoc_partes_equipos where cod_equipo='".$info_equipo["codigo"]."'";
	$query.=" and estado_asoc=1";
}
else
{
	//se recupera el equipo al que esta asociado
	$query="select cod_equipo from asoc_partes_equipos where nro_asoc=".$info_equipo["nro_asociacion_activa"].";";
}
$result=mysql_db_query("cia_web",$query,$link);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<style>
<!--
.LINK{
	font:Arial, Helvetica, sans-serif;
	color: #b26c4a;
	text-align:center;
	text-decoration:none;
}

a:link{
	color: #b26c4a;
}	

a:hover{
	color: #b26c4a;
	background-color: #FFFFFF;
}

a:visited{
	color: #b26c4a;
}

a:active{
	color: #b26c4a;
}
-->
</style>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Cia Web</title>
<script type="text/javascript" src="funciones.js"></script>
<script language="JavaScript">
var popup=0;

function to_excel()
{
	var URL,opciones;
	URL="ToExcel/ver_equipo_excel.php?valor=" + document.frmDetalleEquipo.valor.value;
	opciones="toolbar=0,resizable=0,menubar=1,status=1";
	verificar_popup(popup);
	popup=window.open(URL,"",opciones);
	popup.focus();
	popup.resizeTo(parseInt(screen.availWidth),parseInt(screen.availHeight));
	popup.moveTo(0,0);
}

function ver_fallas(cod_equipo)
{
	var URL;
	URL="det_fallas.php?cod_equipo=" + cod_equipo;
	verificar_popup(popup);
	popup=window.open(URL,"",'width=740,height=500,scrollbars=yes,status=yes');
	popup.focus();
	popup.moveTo((screen.width-740)/2,(screen.height-500)/2);
}

function nuevo_rp(cod_equipo,tipo,nro_asoc)
{
	var URL;
	//alert(cod_equipo);
	URL="ing_reporte_falla.php?cod_equipo=" + cod_equipo + "&tipo=" + tipo + "&nro_asoc=" + nro_asoc;
	verificar_popup(popup);
	popup=window.open(URL,"",'width=560,height=700,scrollbars=yes,status=1');
	popup.focus();
	popup.moveTo((screen.width-560)/2,0);
}

function ver_historial(valor)
{
	var f=document.frmDetalleEquipo;
	verificar_popup(popup);
	popup=window.open('det_mov.php?valor='+valor,"",'width=840,height=500,scrollbars=yes,status=1');
	popup.focus();
	popup.moveTo((screen.width-840)/2,(screen.height-500)/2);
}

function terminar(codigo,nro_asoc,valor)
{
	if(confirm('¿Seguro que desea terminar esta asociación?'))
	{
		document.frmDetalleEquipo.action="actualizar_datos.php?op=1&cod=" + codigo + "&nro_asoc=" 
		+ nro_asoc + "&valor=" + valor;
		document.frmDetalleEquipo.submit();
	}
}

function guardar(valor,parte)
{
	var f=document.frmDetalleEquipo;
	f.marca.value=f.marca.value.toUpperCase();
	f.modelo.value=f.modelo.value.toUpperCase();
	f.nro_serie.value=f.nro_serie.value.toUpperCase();
	f.p_garantia.value=f.p_garantia.value.toUpperCase();
	f.nro_factura.value=f.nro_factura.value.toUpperCase();
	f.nro_guia.value=f.nro_guia.value.toUpperCase();
	f.cod_activo_fijo.value=f.cod_activo_fijo.value.toUpperCase();
	if(parte=='EQUIPO')
	{
		f.procesador.value=f.procesador.value.toUpperCase();
		f.ram.value=f.ram.value.toUpperCase();
		f.disco_duro.value=f.disco_duro.value.toUpperCase();
	}	
	//alert(parte);
	if(confirm('¿Seguro que desea guardar los cambios realizados?'))
	{
		f.action="actualizar_datos.php?op=2&valor="+valor+"&TipoParte="+parte;
		f.submit();
	}
}

function baja(valor)
{
	if(confirm('¿Seguro que desea dar de Baja este equipo?'))
	{
		verificar_popup(popup);
		popup=window.open('baja.php?valor='+valor,"",'width=400,height=200,status=1');
		popup.focus();
		popup.moveTo((screen.width-400)/2,(screen.height-200)/2);
	}
}

function recuperar(valor)
{
	if(confirm('¿Seguro que desea recuperar este equipo?'))
	{	
		document.frmDetalleEquipo.action="actualizar_datos.php?op=4&valor=" + valor;
		document.frmDetalleEquipo.submit();
	}
}

function asociar(op,codigo)
{
	var URL,opciones;
	switch(op)
	{
		case 1:		//asociar el equipo con una parte
			URL='asociar_parte.php?codigo_equipo=' + codigo;
			opciones='resizable=0,toolbar=0,scrollbars=1,menubar=0,width=550,height=700,status=1';
			verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo((screen.width-550)/2,0);
			break;
		case 2:		//asociar un software
			URL='asociar_sw.php?codigo_equipo=' + codigo;
			opciones='resizable=0,toolbar=0,scrollbars=1,menubar=0,width=400,height=200,status=1';
			verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo((screen.width-400)/2,(screen.height-200)/2);
			break;
		case 3:		//asociar una parte con un equipo
			URL='asociar_equipo.php?cod_parte=' + codigo;
			opciones='resizable=0,toolbar=0,scrollbars=1,menubar=0,width=550,height=700,status=1';
			verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo((screen.width-550)/2,0);
			break;
		case 4:
			URL='cambiar_user.php?codigo_equipo=' + codigo + '&nro_asoc=0';
			opciones='resizable=0,toolbar=0,scrollbars=1,menubar=0,width=640,height=700,status=1';
			verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo((screen.width-640)/2,0);
			break;
	}
}

function ver_sw(cod_equipo)
{
	var URL,opciones;
	URL='ver_sw_asoc.php?cod_equipo=' + cod_equipo;
	opciones='resizable=0,toolbar=0,scrollbars=1,menubar=0,width=500,height=700,status=1';
	verificar_popup(popup);
	popup=window.open(URL,"",opciones);
	popup.focus();
	popup.moveTo((screen.width-500)/2,0);
}

function cambiar(op,dato,cod_equipo)
{
	var URL,opciones;
	switch(op)
	{
		case 1:		//cambio de ubicacion
			URL='cambiar_ubi.php?cod_equipo=' + cod_equipo + '&cc_ubi=' + dato;
			opciones='resizable=0,toolbar=0,scrollbars=1,menubar=0,width=420,height=220,status=1';
			verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo((screen.width-420)/2,(screen.height-220)/2);
			break;
		case 2:		//cambio de usuario
			URL='cambiar_user.php?codigo_equipo=' + cod_equipo + '&nro_asoc=' + dato;
			opciones='resizable=0,toolbar=0,scrollbars=1,menubar=0,width=640,height=700,status=1';
			verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo((screen.width-640)/2,0);
			break;
		case 3:		//termino de asociacion equipo-user
			if(confirm("¿Seguro que desea terminar la asociacion?"))
			{
				URL='actualizar_datos.php?op=10&cod_equipo=' + cod_equipo + '&nro_asoc=' + dato;
				verificar_popup(popup);
				popup=window.open(URL,"","");
				popup.focus();
			}
			break;
		}
}
</script>
</head>

<body bgcolor="#CCCCCC" onUnload="verificar_popup(popup)">
<form name="frmDetalleEquipo" method="post" action="">
<input type="hidden" name="valor" value="<?php echo $valor;?>">
<!---------------------------------- cuerpo de la pagina ------------------------------------->
<table width="530" class="TablaPrincipal" cellpadding="0" cellspacing="0" border="0" align="center">
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>
	<table width="500" border="0" class="TablaInterior" align="center">
	<tr>
		<td class="ColorTabla01" align="center"><strong>DETALLE EQUIPO</strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
		<table cellpadding="0" cellspacing="2" border="0" style="border:solid 2px #000000;" width="450" align="center">
		<tr>
			<td style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center" colspan="2">Informaci&oacute;n Equipo</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Codigo</strong></td>
			      <td>&nbsp;&nbsp;&nbsp;<?php echo $info_equipo["codigo"]?></td>
		</tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Tipo</strong></td>
			<td>&nbsp;&nbsp;
			<?php
			//se busca el tipo en la tabla sub_clase
			$var=substr($info_equipo["codigo"],0,3);
			$query="select nombre_subclase from sub_clase where cod_clase=18003 and valor_subclase1='".$var."';";
			$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
			$r_tmp=mysql_fetch_array($res_tmp);
			mysql_free_result($res_tmp);
			echo $r_tmp["nombre_subclase"]
			?>
			</td>
		</tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Marca</strong></td>
			<td>&nbsp;&nbsp;
			<input type="text" name="marca" value="<?php echo $info_equipo["marca"]?>" maxlength="30" size="30">
			</td>
		</tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Modelo</strong></td>
			<td>&nbsp;&nbsp;
			<input type="text" name="modelo" value="<?php echo $info_equipo["modelo"]?>" maxlength="30" size="30">
			</td>
		</tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>N&uacute;mero de Serie</strong></td>
			<td>&nbsp;&nbsp;
			<input type="text" name="nro_serie" value="<?php echo $info_equipo["nro_serie"]?>" maxlength="20" size="25">
			</td>
		</tr>
		<tr>
			<?php
			//se arregla la fecha de compra
			$fecha=explode("-",$info_equipo["fecha_compra"]);
			$fecha=$fecha[2]."-".$fecha[1]."-".$fecha[0];
			?>
			      <td width="200" height="20" align="center" style="border:solid 1px #666666;"><strong>Fecha 
                    Compra</strong></td>
			<td>&nbsp;&nbsp;
			<?php echo $fecha?>
			</td>
		</tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Periodo Garantia</strong></td>
			<td>&nbsp;&nbsp;
			<input type="text" name="p_garantia" value="<?php echo $info_equipo["p_garantia"]?>" maxlength="6" size="14">
			&nbsp;&nbsp;&nbsp;Meses
			</td>
		</tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>N&uacute;mero de Factura</strong></td>
			<td>&nbsp;&nbsp;
			<input type="text" name="nro_factura" value="<?php echo $info_equipo["nro_factura"]?>" maxlength="20" size="24">
			</td>
		</tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>N&uacute;mero de Guia</strong></td>
			<td>&nbsp;&nbsp;
			<input type="text" name="nro_guia" value="<?php echo $info_equipo["nro_guia"]?>" maxlength="20" size="24">
			</td>
		</tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Cod Activo Fijo</strong></td>
			<td>&nbsp;&nbsp;
			<input type="text" name="cod_activo_fijo" value="<?php echo $info_equipo["cod_activo_fijo"]?>" maxlength="12" size="15">
			</td>
		</tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Proveedor</strong></td>
			<td>&nbsp;&nbsp;
			<select name="proveedor">
			<option value="">Seleccione un Proveedor</option>
			<?php
			//se recupera la lista de proveedores
			$query="select rut,razon_social from proveedor;";
			$res_tmp=mysql_db_query("cia_web",$query,$link);
			while($r_tmp=mysql_fetch_array($res_tmp))
			{
				echo '<option value="'.$r_tmp["rut"].'"';
				if($r_tmp["rut"]==$info_equipo["rut_proveedor"])
					echo ' selected';
				echo '>'.$r_tmp["razon_social"].'</option>';
			}
			mysql_free_result($res_tmp);
			?>
			</select>
			</td>
		</tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Estado</strong></td>
			<td>&nbsp;&nbsp;
			<?php
			if($info_equipo["estado"]==1)
				echo "Asignado";
			if($info_equipo["estado"]==2)
				echo "Para Baja";
			if($info_equipo["estado"]==3)
				echo "De Baja";
			if($info_equipo["estado"]==4)
				echo "Disponible";
			?>
			</td>
		</tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Observaciones</strong></td>
			<td>&nbsp;&nbsp;
				<textarea name="observaciones" cols="30" rows="3" tabindex="10"><?php echo $info_equipo["observaciones"];?>
				</textarea>
            </td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<?php
		if(substr($info_equipo["codigo"],0,3)=="CMP" || substr($info_equipo["codigo"],0,3)=="NBK")
		{
			//se recupera el detalle del equipo
			$query="select * from detalle_equipos where cod_equipo='".$info_equipo["codigo"]."';";
			$res_tmp=mysql_db_query("cia_web",$query,$link);
			$det_equipo=mysql_fetch_array($res_tmp);
			mysql_free_result($res_tmp);
		echo '<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Procesador</strong></td>
			<td>&nbsp;&nbsp;<input name="procesador" type="text" value ="'.$det_equipo["procesador"].'"></td>
		</tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Memoria Ram</strong></td>
			<td>&nbsp;&nbsp;<input name="ram" type="text" value="'.$det_equipo["ram"].'"></td>
		</tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Disco Duro</strong></td>
			<td>&nbsp;&nbsp;<input name="disco_duro" type="text" value="'.$det_equipo["disco_duro"].'"></td>
		</tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Cantidad Seriales</strong></td>
			<td>&nbsp;&nbsp;'.$det_equipo["cant_seriales"].'</td>
		</tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Cantidad Paralelos</strong></td>
			<td>&nbsp;&nbsp;'.$det_equipo["cant_paralelos"].'</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>';
		}
		?>
		<tr>
			      <td colspan="2" style="border: solid 1px #666666;" align="center"> 
                    &nbsp; <input type="button" name="Guardar" value="Guardar Cambios" onClick="guardar('<? echo $valor?>','<? echo $tipo;?>')" style="width: 105px;"> 
                    <?php
			if($info_equipo["estado"]!=3)
				echo '<input type="button" name="de_baja" value="Dar de Baja" style="width: 100px;" onClick="baja(\''.$valor.'\')">&nbsp;';
			if($info_equipo["estado"]==2)
				echo '<input type="button" name="recover" value="Recuperar" style="width: 100px;" onClick="recuperar(\''.$valor.'\')">&nbsp;';
			
			if((substr($info_equipo["codigo"],0,3)=="CMP" || substr($info_equipo["codigo"],0,3)=="NBK" ) && ($info_equipo["estado"]==1 || $info_equipo["estado"]==4))
				echo '<input type="button" name="asoc_parte" value="Asociar Parte" style="width: 100px;" onClick="asociar(1,\''.$info_equipo["codigo"].'\')">&nbsp;';
			else
			{
				if($info_equipo["estado"]==4 && $info_equipo["tipo"]=="PARTE")			
					echo '<input type="button" name="asoc_equipo" value="Asociar Equipo" style="width: 100px;" onClick="asociar(3,\''.$info_equipo["codigo"].'\')">&nbsp;';
			}
			if((substr($info_equipo["codigo"],0,3)=="CMP" || substr($info_equipo["codigo"],0,3)=="NBK" ) && $info_equipo["estado"]!=2 && $info_equipo["estado"]!=3)
				echo '<input type="button" name="asoc_sw" value="Asociar Software" style="width: 100px;" onClick="asociar(2,\''.$info_equipo["codigo"].'\')">';
			if($info_equipo["estado"]==4 && $info_equipo["tipo"]=="EQUIPO") 
				echo '<input type="button" name="asoc_user" value="Asociar Usuario" style="width: 100px;" onClick="asociar(4,\''.$info_equipo["codigo"].'\')">';
			?>
                  </td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		</table>
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td>
		<table cellpadding="0" cellspacing="2" border="0" style="border:solid 2px #000000;" width="450" align="center">
		<tr>
			<td style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center" colspan="2">Informaci&oacute;n Asociaci&oacute;n</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<?php
		if($info_equipo["estado"]!=1 || !$foobar)
			echo '<tr><td colspan="2" align="center"><strong>Este equipo no ha sido Asignado a ningun Usuario</strong></td></tr>';
		else
		{
		echo '<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Fecha Inicio</strong></td>
			<td>&nbsp;&nbsp;&nbsp;'.$info_asoc["fecha_inicio"].'
			</td>
		</tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Ubicaci&oacute;n</strong></td>
			<td>&nbsp;&nbsp;';
			//se recupera el centro de costo donde esta ubicado el equipo
			$query="select descripcion from centro_costo where centro_costo='".$info_asoc["cc_ubicacion"]."';";
			$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
			$r_tmp=mysql_fetch_array($res_tmp);
			mysql_free_result($res_tmp);
		echo '
			<input type="text" name="ubi" value="'.$info_asoc["cc_ubicacion"].' - '.$r_tmp["descripcion"].'" disabled size="45" style="font-size: 10;">
			</td>
		</tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Usuario</strong></td>
			<td>&nbsp;&nbsp;';
			
			//se recupera la informacion del usuario
			$query="select APELLIDO_PATERNO,APELLIDO_MATERNO,NOMBRES from antecedentes_personales where";
			$query.=" RUT='".$info_asoc["rut_usuario"]."';";
			$res_tmp=mysql_db_query("bd_rrhh",$query,$link);
			$r_tmp=mysql_fetch_array($res_tmp);
			mysql_free_result($res_tmp);
			echo '
			<input type="text" style="font-size: 10;" name="user" value="'.$r_tmp["APELLIDO_PATERNO"].' '.$r_tmp["APELLIDO_MATERNO"].' '.$r_tmp["NOMBRES"].'" size="45" disabled>
			</td>
		</tr>';
		if($tipo=="EQUIPO")
		{
			echo '<tr></tr><td colspan="2">&nbsp;</td>
			<tr><td align="center" colspan="2" style="border:solid 1px #666666;">
			<input type="button" name="cambiar_ubi" value="Cambiar Ubicacion" onClick="cambiar(1,\''.$info_asoc["cc_ubicacion"].'\',\''.$info_equipo["codigo"].'\')" style="width: 150px;">
			&nbsp;&nbsp;&nbsp;
			<input type="button" name="cambiar_user" value="Cambiar Usuario" onClick="cambiar(2,\''.$info_equipo["nro_asociacion_activa"].'\',\''.$info_equipo["codigo"].'\')" style="width: 150px;">
			</td></tr>
			<tr><td align="center" colspan="2" style="border:solid 1px #666666;"> 
			<input type="button" name="terminar_asoc" value="Terminar Asociacion" onClick="cambiar(3,\''.$info_equipo["nro_asociacion_activa"].'\',\''.$info_equipo["codigo"].'\')" style="width:150px;">
			</td></tr>
			';
		}
		}?>
		<tr><td colspan="2">&nbsp;</td></tr>
		</table>
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td>
		<table cellpadding="0" cellspacing="2" border="0" style="border:solid 2px #000000;" width="450" align="center">
		<tr>
			<td style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center" colspan="2">
			<?php
			if($tipo=="EQUIPO")
				echo 'Equipos Asociados';
			else
				echo 'Equipo Asociado';
			?>
			</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<?php 
		if(!mysql_num_rows($result))	//no hay resultados
			echo '<tr><td colspan="2" align="center"><strong>No hay Equipos Asociados</strong></td></tr>';
		else	//se muestran todos los equipos asociados
		{
			while($resp=mysql_fetch_array($result))
			{
				echo '<tr><td colspan="2">&nbsp;</td></tr>';
				//se recupera informacion del equipo en base al codigo
				$query="select codigo,marca,modelo,nro_serie,nro_asociacion_activa from hardware where codigo='".$resp["cod_equipo"]."';";
				$res_tmp=mysql_db_query("cia_web",$query,$link);
				$r_tmp=mysql_fetch_array($res_tmp);
				mysql_free_result($res_tmp);
				//se recupera el tipo de equipo
				$var=substr($r_tmp["codigo"],0,3);
				$query="select nombre_subclase from sub_clase where cod_clase=18003 and valor_subclase1='".$var."';";
				$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
				$r=mysql_fetch_array($res_tmp);
				mysql_free_result($res_tmp);
				//se escribe la informacion
				echo '
				<tr>
					<td align="center" style="border:solid 1px #666666;" width="200"><strong>Codigo</strong></td>
					<td>&nbsp;&nbsp;'.$r_tmp["codigo"].'</td>
				</tr>
				<tr>
					<td align="center" style="border:solid 1px #666666;" width="200"><strong>Tipo</strong></td>
					<td>&nbsp;&nbsp;'.$r["nombre_subclase"].'</td>
				</tr>
				<tr>
					<td align="center" style="border:solid 1px #666666;" width="200"><strong>Marca</strong></td>
					<td>&nbsp;&nbsp;'.$r_tmp["marca"].'</td>
				</tr>
				<tr>
					<td align="center" style="border:solid 1px #666666;" width="200"><strong>Modelo</strong></td>
					<td>&nbsp;&nbsp;'.$r_tmp["modelo"].'</td>
				</tr>
				<tr>
					<td align="center" style="border:solid 1px #666666;" width="200"><strong>N&uacute;mero de Serie</strong></td>
					<td>&nbsp;&nbsp;'.$r_tmp["nro_serie"].'</td>
				</tr>
				<tr><td align="center" colspan="2" style="border:solid 1px #666666;">
				';
				if($info_equipo["tipo"]=="PARTE")
					echo '<input type="button" value="Terminar" style="width: 80px;" onClick="terminar(\''.$info_equipo["codigo"].'\',\''.$info_equipo["nro_asociacion_activa"].'\',\''.$valor.'\')">';
				else
					echo '<input type="button" value="Terminar" style="width: 80px;" onClick="terminar(\''.$r_tmp["codigo"].'\',\''.$r_tmp["nro_asociacion_activa"].'\',\''.$valor.'\')">';
				echo '</td></tr>';
			}
		}
		?>		
		<tr><td colspan="2">&nbsp;</td></tr>
		</table>
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td>
		<table cellpadding="0" cellspacing="2" border="0" style="border:solid 2px #000000;" width="450" align="center">
		<tr>
			<td style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Funciones Avanzadas</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td align="center">
			<table border="0" cellpadding="0" cellspacing="2" width="440" align="center">
			<tr>
				<td align="center" width="220">
				<?php 
				if(substr($info_equipo["codigo"],0,3)=="CMP" || substr($info_equipo["codigo"],0,3)=="NBK")
					echo '<a href="javascript: ver_sw(\''.$info_equipo["codigo"].'\')" class="LINK">';
				?>
				<strong>VER SOFTWARES ASOCIADOS</strong>
				<?php
				if(substr($info_equipo["codigo"],0,3)=="CMP" || substr($info_equipo["codigo"],0,3)=="NBK")
					echo '</a>';
				?>
				</td>
				<td align="center"><a href="javascript: ver_historial('<?php echo $valor;?>',<?php echo $foobar;?>)" class="LINK"><strong>VER HISTORIAL DE MOVIMIENTOS</strong></a></td>
			</tr>
			<tr>
				<td align="center">
				<!--<a href="javascript: nuevo_rp('<?php echo $info_equipo["codigo"]?>','<?php echo $info_equipo["tipo"]?>',<?php echo $info_equipo["nro_asociacion_activa"]?>)" class="LINK"><strong>NUEVO REPORTE DE FALLA</strong></a>!-->
				</td>
				<td align="center">
				<!-- <a href="javascript: ver_fallas('<?php  echo $info_equipo["codigo"];?>')" class="LINK"><strong>VER HISTORIAL DE FALLAS</strong></a>!-->
				</td>
			</tr>		
			</table>
			</td>
		</tr>
		<tr><td>&nbsp;</td></tr>	
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
	<input type="button" name="ToExcel" value="Excel" style="width: 80px;" onClick="to_excel()">&nbsp;&nbsp;&nbsp;
	<input type="button" name="Cerrar" value="Cerrar" onClick="javascript: window.close()" style="width: 80px;"></td>
</tr>
<tr><td>&nbsp;</td></tr>
</table>
</form>
</body>
</html>
