<?php
include("../principal/conectar_ram_web.php"); 

$cmbtipo  = isset($_REQUEST["cmbtipo"])?$_REQUEST["cmbtipo"]:"";
$cmbtipo_d  = isset($_REQUEST["cmbtipo_d"])?$_REQUEST["cmbtipo_d"]:"";
$cod_lugar  = isset($_REQUEST["cod_lugar"])?$_REQUEST["cod_lugar"]:"";
$cod_lugar_d  = isset($_REQUEST["cod_lugar_d"])?$_REQUEST["cod_lugar_d"]:"";
$num_lugar  = isset($_REQUEST["num_lugar"])?$_REQUEST["num_lugar"]:"";
$num_lugar_d  = isset($_REQUEST["num_lugar_d"])?$_REQUEST["num_lugar_d"]:"";
$Proceso  = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";

$checkbox  = isset($_REQUEST["checkbox"])?$_REQUEST["checkbox"]:"";
$fecha  = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
$cmbmovimiento  = isset($_REQUEST["cmbmovimiento"])?$_REQUEST["cmbmovimiento"]:"";
$num_conjunto  = isset($_REQUEST["num_conjunto"])?$_REQUEST["num_conjunto"]:"";
$num_conjunto_d  = isset($_REQUEST["num_conjunto_d"])?$_REQUEST["num_conjunto_d"]:"";

$peso_humedo  = isset($_REQUEST["peso_humedo"])?$_REQUEST["peso_humedo"]:0;
$dia = isset($_REQUEST["dia"])?$_REQUEST["dia"]:date("d");
$mes = isset($_REQUEST["mes"])?$_REQUEST["mes"]:date("m");
$ano = isset($_REQUEST["ano"])?$_REQUEST["ano"]:date("Y");
$hh = isset($_REQUEST["hh"])?$_REQUEST["hh"]:"";
$mm = isset($_REQUEST["mm"])?$_REQUEST["mm"]:"";

if($peso_humedo=="")
	$peso_humedo=0;

if(strlen($dia) == 1)
	$dia = "0".$dia;

if(strlen($mes) == 1)
	$mes = "0".$mes;

$peso_humedo = str_replace(',','.',$peso_humedo);
$peso_humedo = $peso_humedo * 1000;

if(strlen($cmbtipo) == 1)
	$cmbtipo = "0".$cmbtipo;

if(strlen($cmbtipo_d) == 1)
	$cmbtipo_d = "0".$cmbtipo_d;

if(strlen($cod_lugar) == 1)
	$cod_lugar = "0".$cod_lugar;

if(strlen($cod_lugar_d) == 1)
	$cod_lugar_d= "0".$cod_lugar_d;

if(strlen($num_lugar) == 1)
	$num_lugar = "0".$num_lugar;

if(strlen($num_lugar_d) == 1)
	$num_lugar_d = "0".$num_lugar_d;
	
//Guardar	
if($Proceso == "G")
{			
	$Insertar = "INSERT INTO movimiento_conjunto (COD_EXISTENCIA,FECHA_MOVIMIENTO,COD_CONJUNTO,NUM_CONJUNTO,COD_LUGAR_ORIGEN,LUGAR_ORIGEN,
				COD_CONJUNTO_DESTINO,CONJUNTO_DESTINO,COD_LUGAR_DESTINO,LUGAR_DESTINO,PESO_SECO_MOVIDO,PESO_HUMEDO_MOVIDO,PESO_HUMEDO_ACUMULADO,ESTADO_VALIDACION)";

	$fecha = $ano.'-'.$mes.'-'.$dia.' '.date("H:i:s");
    
	if($checkbox == "on")
	{
		   $validacion = 1;
	}
	else
	{
			$validacion = 0;
	}    
	
	$Insertar = "$Insertar VALUES('$cmbmovimiento','$fecha','$cmbtipo','$num_conjunto','$cod_lugar','$num_lugar','$cmbtipo_d','$num_conjunto_d','$cod_lugar_d','$num_lugar_d',0,$peso_humedo,0,$validacion)";												  
	//echo $Insertar;
	mysqli_query($link, $Insertar);
	
	header("Location:ram_ing_movimientos.php");	

}

if($Proceso == "M")
{		
    
	if($checkbox == "on")
	{
		   $validacion = 1;
	}
	else
	{
			$validacion = 0;
	}    
			
     $Modificar = "UPDATE ram_web.movimiento_conjunto SET peso_humedo_movido = $peso_humedo, estado_validacion = $validacion WHERE fecha_movimiento ='$fecha'";
	 $Modificar = $Modificar." AND cod_existencia = $cmbmovimiento AND num_conjunto = $num_conjunto AND conjunto_destino = $num_conjunto_d";
 	  mysqli_query($link, $Modificar);	
	 header("Location:ram_ing_movimientos.php");	

}

?>