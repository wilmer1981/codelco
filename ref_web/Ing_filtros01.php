<?php include("../principal/conectar_ref_web.php");

$Proceso      = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
$hora         = isset($_REQUEST["hora"])?$_REQUEST["hora"]:"";
$minuto       = isset($_REQUEST["minuto"])?$_REQUEST["minuto"]:"";
$fecha        = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
$cod_filtro   = isset($_REQUEST["cod_filtro"])?$_REQUEST["cod_filtro"]:"";
$observacion  = isset($_REQUEST["observacion"])?$_REQUEST["observacion"]:"";
$situ         = isset($_REQUEST["situ"])?$_REQUEST["situ"]:"";

$consulta_fecha_actual="select left(SYSDATE(),10) as fecha2";
$resultado = mysqli_query($link, $consulta_fecha_actual);
$row1      = mysqli_fetch_array($resultado);
$fecha2    = $row1["fecha2"];

echo "fecha:".$fecha;
echo "<br>Proceso:".$Proceso;
$time=$hora.':'.$minuto.':00';
	if ($Proceso == "N")
	{		
		$consulta = "SELECT * FROM ref_web.historia_filtros WHERE fecha = '".$fecha."' and cod_filtro = '".$cod_filtro."' and hora = '".$time."' ";
		$rs = mysqli_query($link, $consulta);		
		if ($row = mysqli_fetch_array($rs)) //Si Existe.
		{	
			$mensaje = "Error";
			header("Location:ing_filtros.php?mensaje=".$mensaje);
		}else{		
			$Insertar = "INSERT INTO ref_web.historia_filtros (fecha,cod_filtro, hora, situacion, observacion)";
			$Insertar.= " VALUES ('".$fecha."','".$cod_filtro."','".$time."', '".$situ."', '".$observacion."')";
			mysqli_query($link, $Insertar);
			$mensaje = "Registro guardado con exito";
			header ("location:ing_filtros.php?fecha=$fecha&mensaje=".$mensaje);
		}
	}
	if ($Proceso == "M")
	{
		$actualizar="UPDATE ref_web.historia_filtros set fecha='".$fecha."', cod_filtro='".$cod_filtro."', hora='".$time."', situacion='".$situ."', observacion='".$observacion."' ";
		$actualizar.="WHERE fecha='".$fecha."' and cod_filtro='".$cod_filtro."' and hora='".$time."' ";
		mysqli_query($link,$actualizar);
		$mensaje = "Registro actualizado correctamente";
		header ("location:ing_filtros.php?fecha=$fecha&filtro=$cod_filtro&horas=$time&mensaje=".$mensaje);
	}
	if ($Proceso == "E")
	{	    
		$Eliminar = "DELETE FROM ref_web.historia_filtros WHERE cod_filtro = '".$cod_filtro."' and fecha='".$fecha."' and hora='".$hora."'";
		//echo $Eliminar;
		mysqli_query($link, $Eliminar);
		$mensaje = "Registro eliminado correctamente";
		header ("location:Filtros.php?fecha=$fecha2&mensaje=".$mensaje);
	}	   
?> 
