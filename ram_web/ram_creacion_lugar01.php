<?php
 include("../principal/conectar_ram_web.php"); 
 $Proceso     = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
 $cmbtipo     = isset($_REQUEST["cmbtipo"])?$_REQUEST["cmbtipo"]:"";
 $num_lugar   = isset($_REQUEST["num_lugar"])?$_REQUEST["num_lugar"]:"";
 $descripcion = isset($_REQUEST["descripcion"])?$_REQUEST["descripcion"]:"";
 $cmbestado   = isset($_REQUEST["cmbestado"])?$_REQUEST["cmbestado"]:"";
 $radio       = isset($_REQUEST["radio"])?$_REQUEST["radio"]:"";

if(strlen($cmbtipo) == 1)
	$cmbtipo = "0".$cmbtipo;

if(strlen($num_lugar) == 1)
	$num_lugar = "0".$num_lugar;

//Guardar Datos
if($Proceso == "G")
{
	$Consulta="select * from ram_web.lugar_conjunto ";
	$Consulta.=" where cod_tipo_lugar = '".$cmbtipo."' AND num_lugar= '".$num_lugar."' ";
	$Respuesta=mysqli_query($link, $Consulta);
	if ($Fila=mysqli_fetch_array($Respuesta))
	{
		$msg ="Lugar ya Existe...";
	}
	else
	{
		$Insertar = "INSERT INTO lugar_conjunto (cod_tipo_lugar,num_lugar,descripcion_lugar, cod_estado)";
		$Insertar = "$Insertar values('$cmbtipo','$num_lugar','$descripcion', '$cmbestado')";
		mysqli_query($link,$Insertar);
		$msg ="Lugar registrado correctamente...";
	}
}

//Modificar Datos
if($Proceso == "M")
{
	$Modificar = "UPDATE lugar_conjunto SET cod_tipo_lugar = '$cmbtipo', num_lugar = '$num_lugar',
	              descripcion_lugar = '$descripcion', cod_estado = '$cmbestado'
	              WHERE cod_tipo_lugar = $cmbtipo AND num_lugar = $radio";
	mysqli_query($link,$Modificar);
	$msg ="Lugar actualizado correctamente...";
}

//Eliminar Datos
if($Proceso == "E")
{
	$Eliminar = "DELETE FROM lugar_conjunto WHERE cod_tipo_lugar = $cmbtipo AND num_lugar = $radio";
	mysqli_query($link,$Eliminar);
	$msg ="Lugar eliminado correctamente...";
}

	$valores = "Proceso=V"."&cmbtipo=".$cmbtipo."&mensaje=".$msg;  
    header("Location:ram_creacion_lugar.php?".$valores); 

?>