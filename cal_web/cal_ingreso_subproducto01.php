<?php
include("../principal/conectar_cal_web.php");
$Consulta="select max(cod_subproducto) as mayor from proyecto_modernizacion.subproducto";
$Respuesta=mysqli_query($link, $Consulta);
$Fila=mysqli_fetch_array($Respuesta);
$CodSubProducto=$Fila["mayor"]+1;
switch ($TipoSA)
{
	case "E"://SA ESPECIAL
		$Insertar="insert into proyecto_modernizacion.subproducto(cod_producto,cod_subproducto,descripcion) values('";
		$Insertar=$Insertar.$CmbProductos."','";
		$Insertar=$Insertar.$CodSubProducto."','";
		$Insertar=$Insertar.$Producto." ".$TxtOpcion."')";
		mysqli_query($link, $Insertar);
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmSolicitud.action='cal_solicitud.php';";
		echo "window.opener.document.FrmSolicitud.submit();";
		echo "window.close();</script>";
		break;
	case "A"://SA AUTOMATICA
		$Insertar="insert into proyecto_modernizacion.subproducto(cod_producto,cod_subproducto,descripcion,mostrar) values('";
		$Insertar=$Insertar.$CmbProductos."','";
		$Insertar=$Insertar.$CodSubProducto."','";
		$Insertar=$Insertar.$Producto." ".$TxtOpcion."','1')";
		mysqli_query($link, $Insertar);
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmSolicitudAut.action='cal_solicitud_Automatica.php';";
		echo "window.opener.document.FrmSolicitudAut.submit();";
		echo "window.close();</script>";
		break;
}
?>