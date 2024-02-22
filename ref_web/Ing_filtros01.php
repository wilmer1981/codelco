<?php include("../principal/conectar_ref_web.php");
$consulta_fecha_actual="select left(SYSDATE(),10) as fecha2";
$resultado=mysqli_query($link, $consulta_fecha_actual);
$row1 = mysqli_fetch_array($resultado);
$fecha2=$row1[fecha2];

	if ($Proceso == "G")
	{
	    $time=$hora.':'.$minuto.':00';
		$Insertar = "INSERT INTO ref_web.historia_filtros (fecha,cod_filtro, hora, situacion, observacion)";
		$Insertar.= " VALUES ('".$fecha."','".$cod_filtro."','".$time."', '".$situ."', '".$observacion."')";
		mysqli_query($link, $Insertar);
		header ("location:ing_filtros.php?fecha=$fecha");
	}
	if ($Proceso == "E")
	{
	    
		$Eliminar = "DELETE FROM ref_web.historia_filtros WHERE cod_filtro = '".$cod_filtro."' and fecha='".$fecha."' and hora='".$hora."'";
		//echo $Eliminar;
		mysqli_query($link, $Eliminar);
		header ("location:Filtros.php?fecha=$fecha2");
	}	   
?> 
