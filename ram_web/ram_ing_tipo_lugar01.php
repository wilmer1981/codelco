<?php
 include("../principal/conectar_ram_web.php"); 
 $Proceso     = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
 $cod_tipo    = isset($_REQUEST["cod_tipo"])?$_REQUEST["cod_tipo"]:"";
 $descripcion = isset($_REQUEST["descripcion"])?$_REQUEST["descripcion"]:"";
 $radio       = isset($_REQUEST["radio"])?$_REQUEST["radio"]:"";

//Guardar Datos
if($Proceso == "G")
{
	if(strlen($cod_tipo) == 1)
		$cod_tipo = "0".$cod_tipo;				

	$Insertar = "INSERT INTO tipo_lugar (cod_tipo_lugar, descripcion_lugar)";
	$Insertar = "$Insertar values('$cod_tipo', '$descripcion')";
	mysqli_query($link,$Insertar);
}

//Modificar Datos
if($Proceso == "M")
{
	if(strlen($cod_tipo) == 1)
		$cod_tipo = "0".$cod_tipo;				

	$Modificar = "UPDATE tipo_lugar SET cod_tipo_lugar = '$cod_tipo', descripcion_lugar = '$descripcion'
	              WHERE cod_tipo_lugar = $radio";
	mysqli_query($link,$Modificar);

}

//Eliminar Datos
if($Proceso == "E")
{
	$Eliminar = "DELETE FROM tipo_lugar WHERE cod_tipo_lugar = $radio";
	mysqli_query($link,$Eliminar);
}

	$valores = "Proceso=V";  
    header("Location:ram_ing_tipo_lugar.php?".$valores); 

?>