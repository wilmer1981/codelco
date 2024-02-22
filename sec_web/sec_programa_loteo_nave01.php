<?php 	
	include("../principal/conectar_principal.php");

	$Proceso = $_REQUEST["Proceso"];
	
	$TxtCodNave    = $_REQUEST["TxtCodNave"];
	$TxtNomNave    = $_REQUEST["TxtNomNave"];
	$TxtCodNaviera = $_REQUEST["TxtCodNaviera"];
	$TxtViaTrans   = $_REQUEST["TxtViaTrans"];
	$TxtCodBandera = $_REQUEST["TxtCodBandera"];
	$TxtAnoConstruccion = $_REQUEST["TxtAnoConstruccion"];

	if($TxtAnoConstruccion=='')
		$TxtAnoConstruccion=0;
	if($TxtCodBandera=='')
		$TxtCodBandera=0;
	if($TxtCodNaviera=='')
		$TxtCodNaviera=0;

	switch($Proceso)
	{
		case "G":
			$Insertar="INSERT INTO sec_web.nave(cod_nave,nombre_nave,cod_naviera,cod_via_transporte,cod_bandera,ano_construccion) values (";
			$Insertar.="'$TxtCodNave','$TxtNomNave','$TxtCodNaviera','$TxtViaTrans','$TxtCodBandera','$TxtAnoConstruccion')";
			//echo $Insertar;
			mysqli_query($link, $Insertar);
			break;
		case "M":
			$Actualizar="UPDATE sec_web.nave set nombre_nave='$TxtNomNave',cod_naviera='$TxtCodNaviera',cod_via_transporte='$TxtViaTrans',";
			$Actualizar.="cod_bandera='$TxtCodBandera',ano_construccion='$TxtAnoConstruccion' where cod_nave='$TxtCodNave'";
			mysqli_query($link, $Actualizar);
			break;
		case "E":
			$Eliminar="DELETE from sec_web.nave where cod_nave='$TxtCodNave'";
			//echo $Eliminar;
			mysqli_query($link, $Eliminar);
			break;		
	}
	header('location:sec_programa_loteo_nave.php');
?>