<?Php
//---------------------------------  FUNCION msg_usuario  -------------------------------------//
// Esta Funcion me muestra  un mensaje al usuario si se inserto bien o no los datos en la BD  // 
function msg_usuario ($mensaje) 
{
   include("previcion.php");     
   if(isset($mensaje)&&($mensaje != "")){
		echo ' <script languaje = "Javascript">';
 		echo " alert('".$mensaje."')";
		$mensaje = "";
		echo ' </script>';
	}
}
//------------------------------  FIN FUNCION msg_usuario  -----------------------------------//

include("conectar.php");
/*************************************DATOS_PREVICIONALES***************************************/  
  if ($guardar=='S'){
	   /*********************       GUARDA DATOS AFP   *****************************************/
		$msg_correcto="Datos almacenados correctamente.";
		$msg_incorrecto= "Problema al ingresar los datos.";
	   if ($salvar=='A'){
	 		$fecha = date("Y-m-d");
			$insertar =  "UPDATE subs_web.afp SET fecha ='".$fecha."', porcent_afp='".$porcent."' WHERE COD_AFP ='".$combo_afp."'" ;
 			if($consulta = mysql_query($insertar)){
				msg_usuario ($msg_correcto);
			}else{
				msg_usuario ($msg_incorrecto);
	 		}
		}
	   /*********************       GUARDA DATOS ISAPRE   *****************************************/
	   if ($salvar=='I'){
	   		$rut = "$rut_isa"."-"."$dv";
			$nombre = strtoupper($nombre);
			$insertar="INSERT INTO subs_web.isapre (rut_isapre, nombre, convenio) values ('".$rut."','".$nombre_isa."','".$convenio."')";
		    if($consulta = mysql_query($insertar)){
				msg_usuario ($msg_correcto);
		    }else{
				msg_usuario ($msg_incorrecto);
		   	 }
		}
	   /*********************       GUARDA DATOS FONASA   *****************************************/
	   if ($salvar=='F'){
			  $insertar="INSERT INTO subs_web.fonasa (porcent, fecha) values ('".$porc_fonasa."','".$fecha."')";
			  if($consulta = mysql_query($insertar)){	         
				msg_usuario ($msg_correcto);
			  }else{
				msg_usuario ($msg_incorrecto);
			  }
	   }		  
  } 
?>