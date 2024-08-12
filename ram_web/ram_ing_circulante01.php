<?php
include("../principal/conectar_ram_web.php"); 

if(isset($_REQUEST["ano"])){
	$ano = $_REQUEST["ano"];
}else{
	$ano = date("Y");
}
if(isset($_REQUEST["dia"])){
	$dia = $_REQUEST["dia"];
}else{
	$dia = date("d");
}
if(isset($_REQUEST["mes"])){
	$mes = $_REQUEST["mes"];
}else{
	$mes = date("m");
}
if(isset($_REQUEST["fecha_c"])){
	$fecha_c = $_REQUEST["fecha_c"];
}else{
	$fecha_c = "";
}
if(isset($_REQUEST["n_conjunto"])){
	$n_conjunto = $_REQUEST["n_conjunto"];
}else{
	$n_conjunto = "";
}
if(isset($_REQUEST["fecha"])){
	$fecha = $_REQUEST["fecha"];
}else{
	$fecha = "";
}
if(isset($_REQUEST["conjunto"])){
	$conjunto = $_REQUEST["conjunto"];
}else{
	$conjunto = "";
}
/*
echo "conjunto".$conjunto;
echo "fecha".$fecha;

echo "n_conjunto".$n_conjunto;
echo "fecha_c".$fecha_c;
*/

if(isset($_REQUEST["Proceso"])){
	$Proceso = $_REQUEST["Proceso"];
}else{
	$Proceso = "";
}

if(isset($_REQUEST["peso_humedo"])){
	$peso_humedo = $_REQUEST["peso_humedo"];
}else{
	$peso_humedo = 0;
}
if(isset($_REQUEST["cod_conjunto"])){
	$cod_conjunto = $_REQUEST["cod_conjunto"];
}else{
	$cod_conjunto = 0;
}
if(isset($_REQUEST["cod_lugar"])){
	$cod_lugar = $_REQUEST["cod_lugar"];
}else{
	$cod_lugar = 0;
}

if(isset($_REQUEST["num_conjunto"])){
	$num_conjunto = $_REQUEST["num_conjunto"];
}else{
	$num_conjunto = 0;
}

//$fecha = $ano.'-'.$mes.'-'.$dia;

$peso_humedo = str_replace(',','.',$peso_humedo);
$peso_humedo = $peso_humedo * 1000;

if(strlen($cod_conjunto) == 1)
	$cod_conjunto = "0".$cod_conjunto;

if(strlen($cod_lugar) == 1)
	$cod_lugar = "0".$cod_lugar;

//Guardar Circulante
if($Proceso == "G")
{

		$consulta = "SELECT * FROM conjunto_ram WHERE cod_conjunto = 03 AND num_conjunto = $num_conjunto AND estado != 'f'";
		$rs = mysqli_query($link, $consulta);
	
		if($row = mysqli_fetch_array($rs))
		{
			$cod_conjunto = $row["cod_conjunto"];
			$cod_lugar = $row["cod_lugar"];
			$num_lugar = $row["num_lugar"];
			
			if(strlen($cod_conjunto) == 1)
				$cod_conjunto = "0".$cod_conjunto;				

			if(strlen($cod_lugar) == 1)
				$cod_lugar = "0".$cod_lugar;				

			if(strlen($num_lugar) == 1)
				$num_lugar = "0".$num_lugar;				

			$Insertar = "INSERT INTO movimiento_conjunto (COD_EXISTENCIA,FECHA_MOVIMIENTO,COD_CONJUNTO,NUM_CONJUNTO,COD_LUGAR_ORIGEN,
						 LUGAR_ORIGEN,COD_CONJUNTO_DESTINO,CONJUNTO_DESTINO,COD_LUGAR_DESTINO,LUGAR_DESTINO,PESO_SECO_MOVIDO,PESO_HUMEDO_MOVIDO,
					     PESO_HUMEDO_ACUMULADO,ESTADO_VALIDACION)";
	
		    $fecha = $ano.'-'.$mes.'-'.$dia.' '.date("H:i:s");
			$Insertar = "$Insertar VALUES('02','$fecha','03','$num_conjunto','0','0','$cod_conjunto','$num_conjunto','$cod_lugar','$num_lugar',0,$peso_humedo,0,0)";												  
			mysqli_query($link, $Insertar);
			
		}

}

if($Proceso == "M")
{

 	if (strlen($mes) < 2)
	   $mes = '0'.$mes; 
    
	//$fecha = $ano.'-'.$mes.'-'.$dia;
		   
	$Modificar = "UPDATE movimiento_conjunto SET NUM_CONJUNTO = '$num_conjunto', PESO_HUMEDO_MOVIDO = $peso_humedo
	              WHERE COD_EXISTENCIA = 02 AND COD_CONJUNTO = 03 AND NUM_CONJUNTO = '".$n_conjunto."'  AND FECHA_MOVIMIENTO = '".$fecha_c."' ";
			//	  echo $Modificar;
	mysqli_query($link, $Modificar);
		
}

if($Proceso == "E")
{
		   
	$Eliminar = "DELETE FROM movimiento_conjunto
	              WHERE COD_CONJUNTO = 03 AND NUM_CONJUNTO = '$n_conjunto' AND FECHA_MOVIMIENTO = '$fecha_c' ";
	mysqli_query($link, $Eliminar);
		
}

	$valores = "Proceso=V"."&ano=".$ano."&mes=".$mes."&dia=".$dia;  
   header("Location:ram_ing_circulante.php?".$valores); 

?>