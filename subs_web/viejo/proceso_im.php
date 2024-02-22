<?
include("conectar.php");
	$fecha = $ano1."-".$mes1."-01";
    $valor_uf = str_replace('.','', $valor_uf); // Elimina puntos
/*************************Guardar_Valor_UF***************************/
	if(($guardar=="uf")||($guardar=="ui")){
	    $insertar="INSERT INTO subs_web.mes_uf (fecha,valor) values ('".$fecha."','".$valor_uf."')";
 		if($consulta = mysql_query($insertar)){
			$mensaje = "Valor UF almacenada correctamente.";
		 	header("location:main.php?mensaje=$mensaje");
		}else{
			$mensaje = "Problema al ingresar valor UF.";
			header("location:main.php?mensaje=$mensaje");
	   }
	}
/*********************Guardar_Impuesto_Unico*************************/
	if(($guardar=="im")||($guardar=="ui")){
	   while(list($clave,$valor) = each($desde)){
	  	 if($hasta[$clave] == "y M�s..."){
		  $hasta[$clave] = "-1";
		  }
		  $hasta[$clave] = str_replace('.','', $hasta[$clave]);	
	      $insertar="INSERT INTO subs_web.detalle_mes (fecha,desde,hasta,factor,rebaja) values ('".$fecha."','".$desde[$clave]."','".$hasta[$clave]."','".$factor[$clave]."','".$rebaja[$clave]."')";
 		if($consulta = mysql_query($insertar)){
			$mensaje = "Datos almacenados correctamente.";
			header("location:main.php?mensaje=$mensaje");
		}else{
			$mensaje = "Problema al ingresar los datos.";
			header("location:main.php?mensaje=$mensaje");
	   }
	}
}		
?>