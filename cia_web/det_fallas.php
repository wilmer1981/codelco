<?php
$var=explode(";",$valor);
$cod=$var[0];
$tipo=$var[1];
include("../principal/conectar_principal.php");

//se recuperan todas las fallas asociadas a este equipo
$query="select * from historial_fallas where cod_equipo='".$cod."' ";
//echo($query);
$result=mysql_db_query("cia_web",$query,$link);
$cant=mysql_num_rows($result);
//echo ($cod);
if (isset($nro_falla))
{
	//echo('entree');
	$query="select causa,nro_asoc_activa,d_trabajo,compra_insumos,tipo from historial_fallas where ";
	$query.="nro_falla=".$nro_falla." and cod_equipo='".$cod."'";
	$res_tmp=mysql_db_query("cia_web",$query,$link);
	$r=mysql_fetch_array($res_tmp);
	mysql_free_result($res_tmp);
	//echo($query);
	//se recuperan los datos de la ubicacion del equipo
	if($r["nro_asoc_activa"]!=0)
	{
		$query="select cc_ubicacion from asoc_equipos_usuarios where ";
		if($r["tipo"]=="EQUIPO")
			$query.="nro_asoc=".$r["nro_asoc_activa"].";";
		else
			$query.="nro_asoc in (select nro_asoc_eq_user from asoc_partes_equipos where nro_asoc=".$r["nro_asoc_activa"].");";
		$res_tmp=mysql_db_query("cia_web",$query,$link);
		$r_tmp=mysql_fetch_array($res_tmp);
		mysql_free_result($res_tmp);
		//se recupera la descripcion del centro de costo
		$query="select descripcion from centro_costo where centro_costo='".$r_tmp["cc_ubicacion"]."';";
		$ubi=$r_tmp["cc_ubicacion"];
		$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
		$r_tmp=mysql_fetch_array($res_tmp);
		mysql_free_result($res_tmp);
		$ubi.=" - ".$r_tmp["descripcion"];
	}
	//se recuperan los datos del usuario
	if($r["nro_asoc_activa"]!=0)
	{
		$query="select APELLIDO_PATERNO,APELLIDO_MATERNO,NOMBRES,COD_CENTRO_COSTO from bd_rrhh.antecedentes_personales ";
		if($r["tipo"]=="EQUIPO")
			$query.="where RUT in (select rut_usuario from cia_web.asoc_equipos_usuarios where nro_asoc=".$r["nro_asoc_activa"].");";
		else
		{
			$query="where RUT in (select rut_usuario from cia_web.asoc_equipos_usuarios where nro_asoc in ";
			$query.="(select nro_asoc_eq_user from cia_web.asoc_partes_equipos where nro_asoc=".$r["nro_asoc_activa"]."));";
		}
		$res_tmp=mysql_query($query,$link);
		$r_tmp=mysql_fetch_array($res_tmp);
		mysql_free_result($res_tmp);
		$user=$r_tmp["APELLIDO_PATERNO"]." ".$r_tmp["APELLIDO_MATERNO"]." ".$r_tmp["NOMBRES"]."<br>";
		//se recupera la informacion del centro de costo del usuario
		$cc=substr($r_tmp["COD_CENTRO_COSTO"],3,5);
		$cc=explode(".",$cc);
		$cc=$cc[0].$cc[1];
		$query="select descripcion from centro_costo where centro_costo='".$cc."';";
		$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
		$r_tmp=mysql_fetch_array($res_tmp);
		mysql_free_result($res_tmp);
		//$user.="&nbsp;&nbsp;&nbsp;&nbsp;".$cc." - ".$r_tmp["descripcion"];
	}
	else
		$user="No esta asociado a ningun usuario";
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
	color:#b26c4a;
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
<script type="text/javascript" src="file:///D|/cia_web/funciones.js"></script>
<script language="JavaScript" type="text/javascript">
var popup=0;

function to_excel(nro_falla,valor)
{
	//alert(valor);
	//alert(nro_falla);
	var URL,opciones;
	URL="opcion.php?op=2&valor=" + valor + "&nro_falla=" + nro_falla;
	opciones="toolbar=0,resizable=0,menubar=1,status=1,width=370,heigth=300";
	//verificar_popup(popup);
	popup=window.open(URL,"",opciones);
	popup.focus();
	popup.moveTo((screen.width - 370)/2,(screen.heigth - 300)/2);
}

function revisar(cant)
{
	/*if(cant==0)
	{
		alert("Este equipo no registra Fallas");
		window.close();
	}*/
	
}

function ver_detalle(nro_falla,valor)
{
	//alert(nro_falla);
	//document.frmFallas.action="det_fallas.php#detalle_falla";
	document.frmFallas.action="det_fallas.php?valor="+valor;
	document.frmFallas.nro_falla.value=nro_falla;
	document.frmFallas.submit();
	//alert(frmFallas.nro_falla.value);
 //" onUnload="verificar_popup(popup)" esto va depe de bodybgcolor
}
</script>
</head>

<body bgcolor="#CCCCCC" onLoad="revisar(<?php echo $cant;?>)">
 
<form name="frmFallas" method="post">
<input type="hidden" name="cod_equipo" value="<?php echo $cod_equipo;?>">
 
<input type="hidden" name="nro_falla">
<table width="700" class="TablaPrincipal" cellpadding="0" cellspacing="0" border="0" align="center">
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>
	<table width="680" border="0" class="TablaInterior" align="center">
	<tr>
	        <td class="ColorTabla01" align="center"><strong>HISTORIAL DE FALLAS</strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
		
		<!--      TABLA HISTORIAL DE FALLAS    -->
		<table border="0" cellspacing="2" cellpadding="0" width="660" align="center">
		<tr>
			<td width="90" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Fecha Inicio</td>
			<td width="90" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Fecha Termino</td>
			<td width="90" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Duraci&oacute;n</td>
			<td width="150" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Tipo de Tarea</td>
			<td width="150" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">Acci&oacute;n Realizada</td>
			<td width="90" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center">&nbsp;</td>
		</tr>
		<?php
		while($resp=mysql_fetch_array($result))
		{
			echo '<tr ';
			if(isset($nro_falla) && $nro_falla==$resp["nro_falla"])
				echo 'bgcolor="#D5EAFF"';
			echo '>';
			$fecha=explode("-",$resp["fecha_inicio"]);
			$fecha=$fecha[2]."-".$fecha[1]."-".$fecha[0];
			echo '<td align="center" style="border:solid 1px #666666;">&nbsp;'.$fecha.'</td>';
			$fecha=explode("-",$resp["fecha_termino"]);
			$fecha=$fecha[2]."-".$fecha[1]."-".$fecha[0];
			echo '<td align="center" style="border:solid 1px #666666;">&nbsp;'.$fecha.'</td>';
			echo '<td align="center" style="border:solid 1px #666666;">&nbsp;'.$resp["duracion"].'</td>';
			echo '<td align="center" style="border:solid 1px #666666;">&nbsp;'.$resp["tipo_tarea"].'</td>';
			echo '<td align="center" style="border:solid 1px #666666;">&nbsp;'.$resp["accion"].'</td>';
			echo "<td align='center' style='border:solid 1px #666666;'><a href=\"javascript: ver_detalle('".$resp[nro_falla]."','".$valor."')\" class='LINK'><strong>Ver Detalle</strong></a>";
			//echo($nro_falla);
			echo '</tr>';
		}
		?>
		<tr>
			<td colspan="6">&nbsp;</td>
		</tr>
		</table>
		<!--      FIN TABLA HISTORIAL DE FALLAS  -->
		
		</td>
	</tr>
	</table>
	</td>
</tr>
<tr>
	  <td>&nbsp;</td>
</tr>
<?php
if(isset($nro_falla))
{
echo '
<tr>
	<td>
	<a name="detalle_falla">
	<table width="400" border="0" class="TablaInterior" align="center">
	<tr>
	    <td class="ColorTabla01" align="center"><strong>DETALLE DE LA FALLA</strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
		
		<!--      TABLA DETALLE DE FALLAS    -->
		<table border="0" cellspacing="2" cellpadding="0" width="380" align="center">
		<tr>
			<td align="left" style="border:solid 1px #666666;" width="140">&nbsp;&nbsp;<strong>Nro Falla</strong></td>
			<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;'.$nro_falla.'</td>
		</tr>
		<tr>
			<td align="left" style="border:solid 1px #666666;">&nbsp;&nbsp;<strong>Usuario</strong></td>
			<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;'.$user.'</td>
		</tr>
		<tr>
			<td align="left" style="border:solid 1px #666666;">&nbsp;&nbsp;<strong>Ubicaci&oacute;n</strong></td>
			<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;'.$ubi.'</td>
		</tr>
		<tr>
			<td align="left" style="border:solid 1px #666666;">&nbsp;&nbsp;<strong>Causa</strong></td>
			<td align="left">&nbsp;&nbsp;&nbsp;
			<textarea name="causa" cols="20" rows="3" readonly>'.$r["causa"].'</textarea>
			</td>
		</tr>
		<tr>
			<td align="left" style="border:solid 1px #666666;">&nbsp;&nbsp;<strong>Detalle Trabajo</strong></td>
			<td align="left">&nbsp;&nbsp;&nbsp;
			<textarea name="d_trabajo" cols="20" rows="3" readonly>'.$r["d_trabajo"].'</textarea>
			</td>
		</tr>
		<tr>
			<td align="left" style="border:solid 1px #666666;">&nbsp;&nbsp;<strong>Compra de Insumos</strong></td>
			<td align="left">&nbsp;&nbsp;&nbsp;
			<textarea name="insumos" cols="20" rows="3" readonly>'.$r["compra_insumos"].'</textarea>
			</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		</table>
		</a>
		<!--      FIN TABLA DETALLE DE FALLAS  -->
		
		</td>
	</tr>
	</table>
	</td>
</tr>
<tr><td>&nbsp;</td></tr>';
}
?>
<tr>
	<td align="center">
	
	<input type="button" name="ToExcel" value="Excel" style="width: 80px;" onClick="to_excel(<?php echo"'".$nro_falla."','".$valor."'";?>)">&nbsp;&nbsp;&nbsp;
	<input type="button" name="cerrar" value="Cerrar" style="width: 80px;" onClick="javascript: window.close();"></td>
</tr>
<tr><td>&nbsp;</td></tr>
</table>
</td>

</form>
</body>
</html>
