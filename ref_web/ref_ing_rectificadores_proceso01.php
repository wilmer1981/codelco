<?php
	include("../principal/conectar_sec_web.php");
	$consulta_fecha_systema="SELECT left(sysdate(),10) as fecha2";
	$rss = mysqli_query($link, $consulta_fecha_systema);
	$rows = mysqli_fetch_array($rss);
	
	if (($proceso == "G") and ($opcion == "N"))
	{	
		$consulta = "SELECT * FROM ref_web.rectificadores ";
		$consulta.= " WHERE cod_rectificador = '".$txtrectificador."'";
		$consulta.= " and fecha = '".$Ano."-".$Mes."-".$Dia."'";
		$rs = mysqli_query($link, $consulta);
		
		if ($row = mysqli_fetch_array($rs)) //Si Existe.
		{	
			$mensaje = "El Rectificador Ya Existe";
			header("Location:ref_ing_rectificador.php?activar=&mensaje=".$mensaje);
		}
		else //No Existe.
		{
			//Inserta en Sec_Web.
			$insertar = "INSERT INTO ref_web.rectificadores (fecha,cod_rectificador,descripcion_rectificador,Corriente_aplicada)";
			$insertar = $insertar." VALUES ('".$Ano."-".$Mes."-".$Dia."','".$txtrectificador."','".$txtdescripcion."','".$txtaplicada."')";
			mysqli_query($link, $insertar);					
    		header("Location:ref_ing_rectificador.php?activar=");
		}				
	}
	
	if (($proceso == "G") and ($opcion == "M"))
	{
	   $consulta="select fecha,cod_rectificador from ref_web.rectificadores where fecha= '".$Ano."-".$Mes."-".$Dia."' and cod_rectificador = '".$txtrectificador."'";
	   $rs = mysqli_query($link, $consulta);
	   if (!($row = mysqli_fetch_array($rs))) //Si Existe.
		{ 
		  $insertar = "INSERT INTO ref_web.rectificadores (fecha,cod_rectificador,descripcion_rectificador,Corriente_aplicada)";
		  $insertar = $insertar." VALUES ('".$Ano."-".$Mes."-".$Dia."','".$txtrectificador."','".$txtdescripcion."','".$txtaplicada."')";
		  mysqli_query($link, $insertar);
		  }
		else{
			 $actualizar = "UPDATE ref_web.rectificadores SET Corriente_aplicada = '".$txtaplicada."', descripcion_rectificador = '".$txtdescripcion."' ";
		     $actualizar.= " WHERE cod_rectificador = '".$txtrectificador."'";
		     $actualizar.= " and fecha= '".$Ano."-".$Mes."-".$Dia."'";
			 //echo $actualizar;
			 mysqli_query($link, $actualizar);
		   }		
    	header("Location:ref_ing_rectificador.php?activar=");		
	}
	
	if ($proceso == "E")
	{
		$valores = explode("-",$parametros);
		while(list($c,$v) = each($valores))
		{
			$eliminar = "DELETE FROM ref_web.rectificadores ";
			$eliminar.= " WHERE cod_rectificador = '".$v."'";
			$eliminar.= " and fecha='".$Ano."-".$Mes."-".$Dia."'";
			mysqli_query($link, $eliminar);
			//echo $eliminar;						
		}
		
		$mensaje = "Rectificador(s) Eliminado(s) Correctamente";
		header("Location:ref_ing_rectificadores.php?mensaje=".$mensaje);				
	}

	
	include("../principal/cerrar_sec_web.php");
?>