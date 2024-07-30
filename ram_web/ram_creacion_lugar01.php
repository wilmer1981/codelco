<?
 include("../principal/conectar_ram_web.php"); 

if(strlen($cmbtipo) == 1)
	$cmbtipo = "0".$cmbtipo;

if(strlen($num_lugar) == 1)
	$num_lugar = "0".$num_lugar;

//Guardar Datos
if($Proceso == "G")
{
	$Insertar = "INSERT INTO lugar_conjunto (cod_tipo_lugar,num_lugar,descripcion_lugar, cod_estado)";
	$Insertar = "$Insertar values('$cmbtipo','$num_lugar','$descripcion', '$cmbestado')";
	mysql_query($Insertar);
}

//Modificar Datos
if($Proceso == "M")
{
	$Modificar = "UPDATE lugar_conjunto SET cod_tipo_lugar = '$cmbtipo', num_lugar = '$num_lugar',
	              descripcion_lugar = '$descripcion', cod_estado = '$cmbestado'
	              WHERE cod_tipo_lugar = $cmbtipo AND num_lugar = $radio";
	mysql_query($Modificar);
	
}

//Eliminar Datos
if($Proceso == "E")
{
	$Eliminar = "DELETE FROM lugar_conjunto WHERE cod_tipo_lugar = $cmbtipo AND num_lugar = $radio";
	mysql_query($Eliminar);
}

	$valores = "Proceso=V"."&cmbtipo=".$cmbtipo;  
    header("Location:ram_creacion_lugar.php?".$valores); 

?>