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

.CELDA{
	border: solid 1px #333333;
	text-align: center;
}
-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Cia Web</title>
<script language="JavaScript">
function to_excel(opcion)
{
	var URL,opciones;
	switch(opcion)
	{
		case 1:
			URL="ToExcel/det_mov_excel.php";
			document.frmOpcion.action=URL;
			document.frmOpcion.submit();
			window.resizeTo(parseInt(screen.availWidth),parseInt(screen.availHeight));
			window.moveTo(0,0);
			break;
		case 2:
			URL="ToExcel/det_fallas_excel.php";
			document.frmOpcion.action=URL;
			document.frmOpcion.submit();
			window.resizeTo(parseInt(screen.availWidth),parseInt(screen.availHeight));
			window.moveTo(0,0);
			break;
		case 3:
			URL="ToExcel/det_mov_user_excel.php";
			document.frmOpcion.action=URL;
			document.frmOpcion.submit();
			window.resizeTo(parseInt(screen.availWidth),parseInt(screen.availHeight));
			window.moveTo(0,0);
			break;
		case 4:
			URL="ToExcel/det_fallas_user_excel.php";
			document.frmOpcion.action=URL;
			document.frmOpcion.submit();
			window.resizeTo(parseInt(screen.availWidth),parseInt(screen.availHeight));
			window.moveTo(0,0);
			break;
	}
}
</script>
</head>

<body bgcolor="#CCCCCC">
<form name="frmOpcion" method="post">
<?php
$var=explode(";",$valor);
$cod_equipo=$var[0];

switch($op)
{
	case 1:
		echo '<input type="hidden" name="valor" value="'.$valor.'">';
		echo '<input type="hidden" name="nro_asoc" value="'.$nro_asoc.'">';
		break;
	case 2:
		echo '<input type="hidden" name="cod_equipo" value="'.$cod_equipo.'">';
		echo '<input type="hidden" name="nro_falla" value="'.$nro_falla.'">';
		break;
	case 3:
		echo '<input type="hidden" name="rut_user" value="'.$rut_user.'">';
		echo '<input type="hidden" name="nro_asoc" value="'.$nro_asoc.'">';
		break;
	case 4:
		echo '<input type="hidden" name="rut_user" value="'.$rut_user.'">';
		echo '<input type="hidden" name="nro_falla" value="'.$nro_falla.'">';
		break;
}
?>
<!---------------------------------- cuerpo de la pagina ------------------------------------->
<table class="TablaPrincipal" cellpadding="0" cellspacing="0" border="0" width="350" align="center">
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>
	<table border="0" class="TablaInterior" align="center" width="300" cellspacing="2">
	<tr>
	        <td class="ColorTabla01" align="center"><strong>Marque una opci&oacute;n</strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr><td>
		<?php
		switch($op)
		{
			case 1:		//movimientos
				?>
				<table align="center" width="250" border="0" cellpadding="0" cellspacing="2">
				<tr><td>&nbsp;&nbsp;<input type="radio" name="opcion" value="t_historial" checked>Tabla Historial de Movimientos</td></tr>
				<?php
				if($nro_asoc!="undefined")
				 echo '<tr><td>&nbsp;&nbsp;<input type="radio" name="opcion" value="t_detalle">Tabla Detalle de Movimiento</td></tr>';
				?>
				<tr><td>&nbsp;&nbsp;<input type="radio" name="opcion" value="historial_c">Historial Completo Detallado</td></tr>
				</table>
				<?php
				break;
			
			case 2:		//fallas
				?>
				<table align="center" width="250" border="0" cellpadding="0" cellspacing="2">
				<tr><td>&nbsp;&nbsp;<input type="radio" name="opcion" value="t_fallas" checked>Tabla Historial de Fallas</td></tr>
				<?php
				if($nro_falla!="undefined")
				 echo '<tr><td>&nbsp;&nbsp;<input type="radio" name="opcion" value="t_detalle">Tabla Detalle de Falla</td></tr>';
				?>
				<tr><td>&nbsp;&nbsp;<input type="radio" name="opcion" value="historial_c">Historial Completo Detallado</td></tr>
				</table>
				<?php
				break;
			case 3:		//movimientos usuarios
				?>
				<table align="center" width="250" border="0" cellpadding="0" cellspacing="2">
				<tr><td>&nbsp;&nbsp;<input type="radio" name="opcion" value="t_historial" checked>Tabla Historial de Movimientos</td></tr>
				<?php
				if($nro_asoc!="undefined")
				 echo '<tr><td>&nbsp;&nbsp;<input type="radio" name="opcion" value="t_detalle">Tabla Detalle de Movimiento</td></tr>';
				?>
				<tr><td>&nbsp;&nbsp;<input type="radio" name="opcion" value="historial_c">Historial Completo Detallado</td></tr>
				</table>
				<?php
				break;
			case 4:		//fallas usuarios
				?>
				<table align="center" width="250" border="0" cellpadding="0" cellspacing="2">
				<tr><td>&nbsp;&nbsp;<input type="radio" name="opcion" value="t_fallas" checked>Tabla Historial de Fallas</td></tr>
				<?php
				if($nro_falla!="undefined")
				 echo '<tr><td>&nbsp;&nbsp;<input type="radio" name="opcion" value="t_detalle">Tabla Detalle de Falla</td></tr>';
				?>
				<tr><td>&nbsp;&nbsp;<input type="radio" name="opcion" value="historial_c">Historial Completo Detallado</td></tr>
				</table>
				<?php
				break;
		}
		?>
	</td></tr>
	<tr><td>&nbsp;</td></tr>
	</table>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td align="center">
	<input type="button" name="Enviar" value="Excel" style="width: 80px;" onClick="to_excel(<?php echo $op;?>)">
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="button" name="Cerrar" value="Cancelar" style="width: 80px;" onClick="javascript:window.close();">
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
</table>

</form>
</body>
</html>
