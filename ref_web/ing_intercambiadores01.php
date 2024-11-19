<?php  include("../principal/conectar_ref_web.php");

$Proceso   = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
$hora      = isset($_REQUEST["hora"])?$_REQUEST["hora"]:"";
$minuto    = isset($_REQUEST["minuto"])?$_REQUEST["minuto"]:"";
$fecha      = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
$horas      = isset($_REQUEST["horas"])?$_REQUEST["horas"]:"";
$intercambiador = isset($_REQUEST["intercambiador"])?$_REQUEST["intercambiador"]:"";
$observacion    = isset($_REQUEST["observacion"])?$_REQUEST["observacion"]:"";
$situ           = isset($_REQUEST["situ"])?$_REQUEST["situ"]:"";

$consulta_fecha_actual="select left(SYSDATE(),10) as fecha2";
$resultado=mysqli_query($link, $consulta_fecha_actual);
$row1 = mysqli_fetch_array($resultado);
$fecha2=$row1["fecha2"];

	$time=$hora.':'.$minuto.':00';		
	if ($Proceso == "N")
	{	    
		$consulta = "SELECT * FROM ref_web.historia_intercambiadores WHERE fecha = '".$fecha."' and cod_intercambiador = '".$intercambiador."' and hora = '".$time."' ";
		$rs = mysqli_query($link, $consulta);		
		if ($row = mysqli_fetch_array($rs)) //Si Existe.
		{	
			$mensaje = "Error";
			header("Location:ing_intercambiadores.php?mensaje=".$mensaje);
		}else{	
			$Insertar = "INSERT INTO ref_web.historia_intercambiadores (fecha, cod_intercambiador, hora, observacion, situacion  )";
			$Insertar.= " VALUES ('".$fecha."','".$intercambiador."','".$time."', '".$observacion."', '".$situ."')";
			//echo $Insertar;
			mysqli_query($link, $Insertar);
			$mensaje = "Registro guardado con exito";
			header ("location:ing_bombas.php?fecha=$fecha&mensaje=".$mensaje);
		}
	}
	if ($Proceso == "M")
	{
		$actualizar="UPDATE ref_web.historia_intercambiadores set fecha='".$fecha."', cod_intercambiador='".$intercambiador."', hora='".$time."', observacion='".$observacion."', situacion='".$situ."' ";
		$actualizar.="WHERE fecha='".$fecha."' and cod_intercambiador='".$intercambiador."' and hora='".$time."' ";
		mysqli_query($link,$actualizar);
		$mensaje = "Registro actualizado correctamente";
		header ("location:ing_intercambiadores.php?fecha=$fecha&intercambiador=$intercambiador&horas=$time&mensaje=".$mensaje);
		
	}
	if ($Proceso == "E")
	{
		$Eliminar = "DELETE FROM ref_web.historia_intercambiadores WHERE cod_intercambiador = '".$intercambiador."' and fecha='".$fecha."' and hora='".$horas."'";
		//echo $Eliminar;
		mysqli_query($link, $Eliminar);
		$mensaje = "Registro eliminado con exito";
		header ("location:intercambiadores.php?fecha=$fecha2&mensaje=".$mensaje);
	}	   



?> 
