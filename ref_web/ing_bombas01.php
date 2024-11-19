<?php 
include("../principal/conectar_ref_web.php"); 

$Proceso   = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
$iso       = isset($_REQUEST["iso"])?$_REQUEST["iso"]:"";
$horas      = isset($_REQUEST["horas"])?$_REQUEST["horas"]:"";
$hora      = isset($_REQUEST["hora"])?$_REQUEST["hora"]:"";
$minuto    = isset($_REQUEST["minuto"])?$_REQUEST["minuto"]:"";
$bomba     = isset($_REQUEST["bomba"])?$_REQUEST["bomba"]:"";
$circuito = isset($_REQUEST["circuito"])?$_REQUEST["circuito"]:"";
$fecha     = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
$situ      = isset($_REQUEST["situ"])?$_REQUEST["situ"]:"";
$observacion = isset($_REQUEST["observacion"])?$_REQUEST["observacion"]:"";
$cod_bomba   = isset($_REQUEST["cod_bomba"])?$_REQUEST["cod_bomba"]:"";

$consulta_fecha_actual="select left(SYSDATE(),10) as fecha2";
$resultado = mysqli_query($link, $consulta_fecha_actual);
$row1      = mysqli_fetch_array($resultado);
$fecha2    = $row1["fecha2"];

//echo "Proceso:".$Proceso;
//exit();
if ($Proceso == "N")
{
	$time = $hora.':'.$minuto.':'.date("s");
	//$consulta = "SELECT * FROM ref_web.historia_bombas WHERE fecha = '".$fecha."' and cod_filtro = '".$cod_filtro."' and hora = '".$time."' ";
	$consulta = "SELECT * FROM ref_web.historia_bombas WHERE fecha = '".$fecha."' and cod_bomba = '".$bomba."' ";
	$rs = mysqli_query($link, $consulta);		
	if ($row = mysqli_fetch_array($rs)) //Si Existe.
	{	
		$mensaje = "Error";
		header("Location:ing_bombas.php?mensaje=".$mensaje);
	}else{	
		
		$Insertar = "INSERT INTO ref_web.historia_bombas (fecha, cod_bomba, hora, situacion, observacion,iso)";
		$Insertar.= " VALUES ('".$fecha."','".$bomba."','".$time."', '".$situ."', '".$observacion."','".$iso."')";
		//echo $Insertar;
		mysqli_query($link, $Insertar);
		$mensaje = "Registro guardado con exito";
		header ("location:ing_bombas.php?fecha=$fecha&mensaje=".$mensaje);
	}
}
if ($Proceso == "M")
{
	
	if($horas!=""){
		$hhoras = explode(":",$horas);
		$hora     = $hhoras[0];
		$minuto   = $hhoras[1];
		$seg   = $hhoras[2];	
        $hora1 = $hora.":".$minuto;	
	}
	$hora2 = $hora.":".$minuto;
	if($hora1==$hora2){
		$time = $horas;
	}else{
		$time = $hora.':'.$minuto.':'.date("s");
	}
		
	$actualizar="UPDATE ref_web.historia_bombas set fecha='".$fecha."', cod_bomba='".$bomba."', hora='".$time."', situacion='".$situ."', observacion='".$observacion."', iso='".$iso."' ";
	$actualizar.="WHERE fecha='".$fecha."' and cod_bomba='".$bomba."' ";
	mysqli_query($link,$actualizar);
	$mensaje = "Registro actualizado correctamente";
	header ("location:ing_bombas.php?fecha=$fecha&circuito=$circuito&bomba=$bomba&horas=$time&mensaje=".$mensaje);
		
}
if ($Proceso == "E")
{
	$Eliminar = "DELETE FROM ref_web.historia_bombas WHERE cod_bomba = '".$cod_bomba."' and fecha='".$fecha."' and hora='".$hora."' and iso='".$iso."'";
	//echo $Eliminar;
	mysqli_query($link, $Eliminar);
	header ("location:Bombas.php?fecha=$fecha2");
}	   


?> 
