<? include("conectar.php") ?>
<?
	if (empty($CookieUsuario))
	{
		Header("Location:error_acceso.htm");
		exit;
	}
	else
	{

		$dia=date("d");
  		$mes=date("m");
  		$ano=date("Y");
  		$fecha_actual="dia/mes/ano";
		if ($CookieFechaIngreso!=$fecha_actual)
		{
			Header("Location:error_acceso2.htm");
			exit;
		}
		elseif ($CookieTipoUsuario!='01' && $CookieTipoUsuario!='02' && $CookieTipoUsuario!='03' &&
			    $CookieTipoUsuario!='04' && $CookieTipoUsuario!='05' && $CookieTipoUsuario!='06')
		{
			Header("Location:error_acceso2.htm");
			exit;
		}
	}
	$consulta="select * from usuarios where rut='$CookieUsuario'";
	$result=mysql_query($consulta);
	while ($row=mysql_fetch_array($result))
	{
		$nombre=$row[NOMBRE_APELLIDO];
	}
?>
<html>
<head>
<title>Usuarios SAM-WEB</title>
</head>
<!-- Funciones y Estilos -->
<style>
<!--a{text-decoration:none}-->
</style>
<style>

body
{
scrollbar-3dlight-color:006699;
scrollbar-arrow-color:C2E3FB;
scrollbar-base-color:006699;
scrollbar-darkshadow-color:333F74;
scrollbar-face-color:006699;
scrollbar-highlight-color:AAB9FC;
scrollbar-shadow-color:#C2E3FB;
}

</style>
<!-- CUERPO DEL DOCUMENTO -->
<body link="#000000" alink="#000000" vlink="#000000">
<table border="0" cellspacing="2" cellpadding="2">
	<tr>
		<td>
			<?
				$consulta="select * from usuarios where rut='$CookieUsuario'";
				$result=mysql_query($consulta);
				while ($row=mysql_fetch_array($result))
				{
					$nombre=$row[NOMBRE_APELLIDO];
					$tipo=$row[COD_TIPO_USUARIO];
				}
				$consulta="Select * from tipos where cod_clase='04' and cod_tipo='$tipo'";
				$result=mysql_query($consulta);
				while ($row2=mysql_fetch_array($result))
				{
					$tipo=$row2[DESCRIPCION];
				}
				echo "<font size=2 face=verdana color=#ff0000><b>Usuario Actual: </b></font><font size=1 face=verdana color=#336699>$nombre</font><br>\n";
				echo "<font size=2 face=verdana color=#ff0000><b>Tipo de usuario: </b></font><font size=1 face=verdana color=#336699>$tipo</font><br><br>\n";
			?>
			<div align="center"><img src="imagenes/banner1.gif" alt="Planificación y Control de la Mantención" align="middle" width="250" height="110" border="0"></div>
		</td>
		<td>
			<font size=2 face="verdana" color="#336699">Menú Usuarios</font>
			<hr color="#336699">
			<font size=1 face="verdana" color="#000000">
			<dl>
			<?
				if ($CookieTipoUsuario=='01')
     			{
					echo "<dt><img src='imagenes/f_der.gif' align=middle><a href='ingreso_val_mano_obra.php' target='_parent'>Valorización Mano de Obra</a>\n";
					echo "<dt><img src='imagenes/f_der.gif' align=middle><a href='ingreso_sse.php' target='_parent'>Creación de S.S.E.</a>\n";
					echo "<dt><img src='imagenes/f_der.gif' align=middle><a href='ing_car_tec.php' target='_parent'>Características Técnicas</a>\n";
					echo "<dt><img src='imagenes/f_der.gif' align=middle><a href='modifica_estado_sse.php' target='_parent'>Deshabilitación S.S.E.</a>\n";
					echo "<dt><img src='imagenes/f_der.gif' align=middle><a href='modifica_posicion_sse.php' target='_parent'>Cambio de Posición de Equipos</a>\n";
					echo "<dt><img src='imagenes/f_der.gif' align=middle><a href='ing_user.php' target='_parent'>Ingreso - Modificación de Usuarios</a>\n";
					echo "<dt><img src='imagenes/f_der.gif' align=middle><a href='elim_user.php' target='_parent'>Eliminación de Usuarios</a>\n";
					echo "<dt><img src='imagenes/f_der.gif' align=middle><a href='ing_clas_tip.php' target='_parent'>Ingreso de Clases</a>\n";
					echo "<dt><img src='imagenes/f_der.gif' align=middle><a href='elim_clas_tip.php' target='_parent'>Eliminación de Clases</a>\n";
					echo "<dt><img src='imagenes/f_der.gif' align=middle><a href='ing_tip.php' target='_parent'>Ingreso de Tipos</a>\n";
					echo "<dt><img src='imagenes/f_der.gif' align=middle><a href='elim_tip.php' target='_parent'>Eliminación de Tipos</a>\n";
					
					//ELIMINACION PAUTAS DE MANTENCION
					echo "<dt><img src='imagenes/f_der.gif' align=middle><a href='ingreso_pautas_mantencion.php' target='_parent'>Eliminación Pautas Mantención</a>\n";
					echo "<dt><img src='imagenes/f_der.gif' align=middle><a href='modifica_ot.php' target='_parent'>Modifica O.T. (NO CONST.)</a>\n";
				}
				if ($CookieTipoUsuario=='02')
				{
				}
				if ($CookieTipoUsuario=='03')
				{
				}
				if ($CookieTipoUsuario=='04')
				{					
					//INGRESO Y MODIFICACION PAUTAS DE MANTENCION
					//AL MODIFICAR ENVIA E-MAIL
					echo "<dt><img src='imagenes/f_der.gif' align=middle><a href='ingreso_pautas_mantencion.php' target='_parent'>Pautas de Mantención</a>\n";
					echo "<dt><img src='imagenes/f_der.gif' align=middle><a href='ingreso_relacion_pautas.php' target='_parent'>Relaciones de Pautas con SSE.</a>\n";
					echo "<dt><img src='imagenes/f_der.gif' align=middle><a href='ingreso_ot.php?opcion=3' target='_parent'>Creación O.T.</a>\n";
				    echo "<dt><img src='imagenes/f_der.gif' align=middle><a href='procedimientos.php' target='_parent'>Ingreso - Eliminación de Procedimientos O.T.</a>\n";
					echo "<dt><img src='imagenes/f_der.gif' align=middle><a href='obs_ot.php' target='_parent'>Cierre y Observaciones O.T.</a>\n";
					//SOLO INGRESO MODIFICACION Y ELIMINACION (MES ACTUAL  + 5 DIAS)
					echo "<dt><img src='imagenes/f_der.gif' align=middle><a href='ingreso_hh.php' target='_parent'>Ingreso H.H.</a>\n";
					echo "<dt><img src='imagenes/f_der.gif' align=middle><a href='modifica_posicion_sse.php' target='_parent'>Cambio de Posición de Equipos</a>\n";
				}
				if ($CookieTipoUsuario=='05')
				{
				}
				if ($CookieTipoUsuario=='06')
				{					
					echo "<dt><img src='imagenes/f_der.gif' align=middle><a href='ingreso_pautas_mantencion.php' target='_parent'>Pautas de Mantención</a>\n";
					echo "<dt><img src='imagenes/f_der.gif' align=middle><a href='ingreso_relacion_pautas.php' target='_parent'>Relaciones de Pautas con SSE.</a>\n";
					echo "<dt><img src='imagenes/f_der.gif' align=middle><a href='ingreso_ot.php?opcion=3' target='_parent'>Creación O.T.</a>\n";
					echo "<dt><img src='imagenes/f_der.gif' align=middle><a href='obs_ot.php' target='_parent'>Cierre y Observaciones O.T.</a>\n";
					echo "<dt><img src='imagenes/f_der.gif' align=middle><a href='modifica_posicion_sse.php' target='_parent'>Cambio de Posición de Equipos</a>\n";
				}																						
			?>
			</dl>
			</font>
		</td>
	</tr>
</table>
<br><br>
<hr>
<div align="center">
<font size=1 face="verdana"><a href="index.html" target="_parent">Inicio</a></font>
</div>
</body>
</html>
