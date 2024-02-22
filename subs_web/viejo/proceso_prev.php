<?
include("conectar.php");
/*************************************DATOS_PREVICIONALES***************************************/  
  if ($guardar=='S'){
	   if ($salvar=='A'){
	   //		$nombre_afp = strtoupper($nombre_afp);
	 		$fecha = date("Y-m-d");
			$insertar =  "UPDATE subs_web.afp SET fecha ='".$fecha."', porcent_afp='".$porcent."' WHERE COD_AFP ='".$combo_afp."'" ;
 			  if($consulta = mysql_query($insertar)){
	          $mensaje = "Datos almacenados correctamente.";
			  header("location:main.php?mensaje=$mensaje");
			  }else{
			  $mensaje = "Problema al ingresar los datos.";
			  header("location:main.php?mensaje=$mensaje");
	 		  }
}
/*************************************************************************************************/
	   if ($salvar=='I'){
	   		$rut = "$rut_isa"."-"."$dv";
			$nombre = strtoupper($nombre);
			$insertar="INSERT INTO subs_web.isapre (rut_isapre, nombre, convenio) values ('".$rut."','".$nombre_isa."','".$convenio."')";
			  if($consulta = mysql_query($insertar)){
	          $mensaje = "Datos almacenados correctamente.";
			  header("location:main.php?mensaje=$mensaje");
	  		  }else{
			  $mensaje = "Problema al ingresar los datos.";
			  header("location:main.php?mensaje=$mensaje");
	    	  }
		}
/*************************************************************************************************/
	   if ($salvar=='F'){
			  $insertar="INSERT INTO subs_web.fonasa (porcent, fecha) values ('".$porc_fonasa."','".$fecha."')";
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