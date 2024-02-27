<?php 
include("../principal/conectar_principal.php");
$Proceso = $_REQUEST["Proceso"];
$TxtId      = $_REQUEST["TxtId"];
$TxtCliente = $_REQUEST["TxtCliente"];
$TxtRut     = $_REQUEST["TxtRut"];
$TxtSubCliente = $_REQUEST["TxtSubCliente"];
$TxtCiudad     = $_REQUEST["TxtCiudad"];
$TxtComuna     = $_REQUEST["TxtComuna"];
$TxtDireccion = $_REQUEST["TxtDireccion"];
$cmbregion    = $_REQUEST["cmbregion"];
$TxtRepresentante = $_REQUEST["TxtRepresentante"];
$TxtFono    = $_REQUEST["TxtFono"];
$TxtCelular = $_REQUEST["TxtCelular"];

if($Proceso == "G")
{		
	$Insertar = "INSERT INTO sec_web.sub_cliente_vta(Id,cod_cliente,rut_cliente,cod_sub_cliente,ciudad,comuna,direccion,region,representante,fono,celular)";
	$Insertar = $Insertar." values($TxtId,'$TxtCliente','$TxtRut','$TxtSubCliente','$TxtCiudad','$TxtComuna','$TxtDireccion',$cmbregion,'$TxtRepresentante','$TxtFono','$TxtCelular')";
	mysqli_query($link, $Insertar);

    echo "<script languaje='JavaScript'>";
	echo "window.close();</script>";
}
?>
