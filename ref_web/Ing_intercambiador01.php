<?php 
 include("../principal/conectar_ref_web.php"); 
  $time= "$hora:$minuto:00";		
  if ($Proceso == "G")
	{
	    $arreglo=explode('-',$parametros);
		
	    $fecha=$ano1.'-'.$mes1.'-'.$dia1;
		$Insertar = "INSERT INTO ref_web.historia_intercambiadores (fecha,cod_intercambiador, hora, situacion, observacion)";
		$Insertar.= " VALUES ('".$fecha."','".$cmbintercambiadores."','".$time."', '".$situ."', '".$observacion."')";
		//echo $Insertar;
		mysqli_query($link, $Insertar);
		header ("location:Ing_intercambiadores.php");
	}
	
?> 
