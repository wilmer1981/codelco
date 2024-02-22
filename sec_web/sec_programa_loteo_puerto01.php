<?php 	
	include("../principal/conectar_principal.php");
	$Proceso = $_REQUEST["Proceso"];
	$TxtCodPuerto = $_REQUEST["TxtCodPuerto"];
	$TxtNomPuerto = $_REQUEST["TxtNomPuerto"];
	$TxtCodTransp = $_REQUEST["TxtCodTransp"];
	$TxtCodPtoCentral = $_REQUEST["TxtCodPtoCentral"];
	$TxtCodCiudad = $_REQUEST["TxtCodCiudad"];
	$TxtCodPais = $_REQUEST["TxtCodPais"];
	$TxtEta     = $_REQUEST["TxtEta"];

	switch($Proceso)
	{
		case "G":
			$Insertar="insert into sec_web.puertos(cod_puerto,nom_aero_puerto,cod_v_transp,cod_puerto_central,cod_ciudad,cod_pais,eta_programada) values (";
			$Insertar.="'".strtoupper($TxtCodPuerto)."','".strtoupper($TxtNomPuerto)."','$TxtCodTransp','$TxtCodPtoCentral','$TxtCodCiudad','$TxtCodPais','$TxtEta')";
			//echo $Insertar;
			mysqli_query($link, $Insertar);
			header('location:sec_programa_loteo_puerto.php?Buscar=S&CmbPtoDestino='.strtoupper($TxtCodPuerto));
			break;
		case "M":
			$Actualizar="UPDATE sec_web.puertos set nom_aero_puerto='".strtoupper($TxtNomPuerto)."',cod_v_transp='$TxtCodTransp',cod_puerto_central='$TxtCodPtoCentral',";
			$Actualizar.="cod_ciudad='$TxtCodCiudad',cod_pais='$TxtCodPais',eta_programada='$TxtEta' where cod_puerto='$TxtCodPuerto'";
			mysqli_query($link, $Actualizar);
			header('location:sec_programa_loteo_puerto.php?Buscar=S&CmbPtoDestino='.strtoupper($TxtCodPuerto));
			break;
		case "E":
			$Eliminar="delete from sec_web.puertos where cod_puerto='$TxtCodPuerto'";
			//echo $Eliminar;
			mysqli_query($link, $Eliminar);
			header('location:sec_programa_loteo_puerto.php');
			break;
	}
	
?>