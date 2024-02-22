<?php
	include("conectar_principal.php");
	//obtenemos variable proceso mediante GET
	$Proceso   = $_GET['Proceso'];
	$CookieRut = $_COOKIE["CookieRut"];
	switch ($Proceso)
	{
		case "CS":
			$Actualizar = " UPDATE funcionarios set ";
			$Actualizar.= " activo=''";
			$Actualizar.= " where rut='".$CookieRut."'";
			mysqli_query($link, $Actualizar);
			header("location:../index.php");
			break;
	}
?>