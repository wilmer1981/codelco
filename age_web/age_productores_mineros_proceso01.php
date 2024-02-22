<?php
	include("../principal/conectar_principal.php");
	
	switch ($Proceso)
	{
		case "N"://NUEVO PRODUCTOR MINERO
			$Insertar="insert into age_web.productores_mineros () values (";
			$Insertar.="'$TxtRut','$TxtNombre','','$TxtDireccion','$TxtCiudad','$CmbRegion','$TxtTelefono','$TxtRutD','$TxtNombreD','$TxtDireccionD','$TxtCiudadD','$CmbRegionD','$TxtTelefonoD')";
			mysqli_query($link, $Insertar);
			break;
		case "M"://MODIFICAR PRODUCTOR MINERO
			$Modificar="UPDATE age_web.productores_mineros set nombre='$TxtNombre',direccion_p='$TxtDireccion',ciudad_comuna_p='$TxtCiudad', ";
			$Modificar.="region_p='$CmbRegion',telefono_p='$TxtTelefono',rut_r='$TxtRutD',nombre_r='$TxtNombreD',direccion_r='$TxtDireccionD',";
			$Modificar.="ciudad_comuna_r='$TxtCiudadD',region_p='$CmbRegionD',telefono_r='$TxtTelefonoD' where rut='$TxtRut'";
			mysqli_query($link, $Modificar);
			break;
		case "E"://ELIMINAR PRODUCTOR MINERO
			$Eliminar ="delete from age_web.productores_mineros where rut='$TxtRut'";
			mysqli_query($link, $Eliminar);
			break;
	}
	header("location:age_productores_mineros_proceso.php?Recarga=S&CmbProductor=".$TxtRut);
?>