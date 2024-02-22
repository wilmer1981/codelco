<?php 	
	include("../principal/conectar_principal.php");
	$Proceso = $_REQUEST["Proceso"];
	$TxtCodCliente   = $_REQUEST["TxtCodCliente"];
	$TxtSiglaCliente = $_REQUEST["TxtSiglaCliente"];
	$TxtCodRep   = $_REQUEST["TxtCodRep"];
	$TxtNomRepre = $_REQUEST["TxtNomRepre"];
	$TxtRut      = $_REQUEST["TxtRut"];
	$TxtDireccion1  = $_REQUEST["TxtDireccion1"];
	$TxtCiudad      = $_REQUEST["TxtCiudad"];
	$TxtComuna      = $_REQUEST["TxtComuna"];
	$CmbRegion      = $_REQUEST["CmbRegion"];
	$CmbPais        = $_REQUEST["CmbPais"];
	$TxtNomContacto = $_REQUEST["TxtNomContacto"];
	$TxtFono1       = $_REQUEST["TxtFono1"];
	$TxtFono2       = $_REQUEST["TxtFono2"];
	$TxtFax         = $_REQUEST["TxtFax"];
	$TxtObs         = $_REQUEST["TxtObs"];
	$TxtDireccion2  = $_REQUEST["TxtDireccion2"];
	
	switch($Proceso)
	{
		case "G":
			$Insertar="INSERT INTO sec_web.cliente_venta(cod_cliente,sigla_cliente,cod_represent_cliente,nombre_cliente,rut,direccion,ciudad,comuna,region,";
			$Insertar.="cod_ciudad,cod_pais,nombre_contacto,fono1,fono2,fax,observacion,direccion2)values (";
			$Insertar.="'$TxtCodCliente','$TxtSiglaCliente','$TxtCodRep','$TxtNomRepre','$TxtRut','$TxtDireccion1','$TxtCiudad',";
			$Insertar.="'$TxtComuna','$CmbRegion','$TxtCiudad','$CmbPais','$TxtNomContacto','$TxtFono1','$TxtFono2','$TxtFax','$TxtObs','$TxtDireccion2')";
			mysqli_query($link, $Insertar);
			break;
		case "M":
			$Actualizar="UPDATE sec_web.cliente_venta set sigla_cliente='$TxtSiglaCliente',cod_represent_cliente='$TxtCodRep',nombre_cliente='$TxtNomRepre',rut='$TxtRut',direccion='$TxtDireccion1',ciudad='$TxtCiudad'";
			$Actualizar.=",comuna='$TxtComuna',region='$CmbRegion',cod_ciudad='$TxtCiudad',cod_pais='$CmbPais',";
			$Actualizar.="nombre_contacto='$TxtNomContacto',fono1='$TxtFono1',fono2='$TxtFono2',fax='$TxtFax',observacion='$TxtObs',direccion2='$TxtDireccion2' ";
			$Actualizar.="where cod_cliente='$TxtCodCliente'";
			mysqli_query($link, $Actualizar);
			break;
		case "E":
			$Eliminar="DELETE FROM sec_web.cliente_venta where cod_cliente='$TxtCodCliente'";
			mysqli_query($link, $Eliminar);
			break;		
	}
	header('location:sec_programa_loteo_cliente.php');
?>