<?php 
include("../principal/conectar_principal.php");

if($Proceso == "G")
{		
	$Insertar = "INSERT INTO sec_web.sub_cliente_vta(Id,cod_cliente,rut_cliente,cod_sub_cliente,ciudad,comuna,direccion,region,representante,fono,celular)";
	$Insertar = $Insertar." values($TxtId,'$TxtCliente','$TxtRut','$TxtSubCliente','$TxtCiudad','$TxtComuna','$TxtDireccion',$cmbregion,'$TxtRepresentante','$TxtFono','$TxtCelular')";
	mysqli_query($link, $Insertar);

    echo "<script languaje='JavaScript'>";
	echo "window.close();</script>";
}
?>
