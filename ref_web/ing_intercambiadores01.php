<?php  include("../principal/conectar_ref_web.php");

$Proceso   = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
$hora      = isset($_REQUEST["hora"])?$_REQUEST["hora"]:"";
$minuto    = isset($_REQUEST["minuto"])?$_REQUEST["minuto"]:"";
$fecha          = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
$intercambiador = isset($_REQUEST["intercambiador"])?$_REQUEST["intercambiador"]:"";
$observacion    = isset($_REQUEST["observacion"])?$_REQUEST["observacion"]:"";
$situ           = isset($_REQUEST["situ"])?$_REQUEST["situ"]:"";



$consulta_fecha_actual="select left(SYSDATE(),10) as fecha2";
$resultado=mysqli_query($link, $consulta_fecha_actual);
$row1 = mysqli_fetch_array($resultado);
$fecha2=$row1["fecha2"];

	if ($Proceso == "G")
	{
	    $time=$hora.':'.$minuto.':00';
		$Insertar = "INSERT INTO historia_intercambiadores (fecha, cod_intercambiador, hora, observacion, situacion  )";
		$Insertar.= " VALUES ('".$fecha."','".$intercambiador."','".$time."', '".$observacion."', '".$situ."')";
		//echo $Insertar;
		mysqli_query($link, $Insertar);
		header ("location:ing_intercambiadores.php?fecha=$fecha");
	}
	if ($Proceso == "E")
	{
		$Eliminar = "DELETE FROM ref_web.historia_intercambiadores WHERE cod_intercambiador = '".$intercambiador."' and fecha='".$fecha."' and hora='".$hora."'";
		//echo $Eliminar;
		mysqli_query($link, $Eliminar);
		header ("location:intercambiadores.php?fecha=$fecha2");
	}	   



?> 
