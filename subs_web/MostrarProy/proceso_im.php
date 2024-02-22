<?Php
//---------------------------------  FUNCION msg_usuario  -------------------------------------//
// Esta Funcion me muestra  un mensaje al usuario si se inserto bien o no los datos en la BD  // 
function msg_usuario ($mensaje) {
   include("info_mensual.php");     
   if(isset($mensaje)&&($mensaje != "")){
		echo ' <script languaje = "Javascript">';
 		echo " alert('".$mensaje."')";
		$mensaje = "";
		echo ' </script>';
	}
}
//------------------------------  FIN FUNCION msg_usuario  -----------------------------------//
	include("conectar.php");
	$fecha = $ano1."-".$mes1."-01";
    $valor_uf = str_replace('.','', $valor_uf); // Elimina puntos
	/*************************Guardar_Valor_UF***************************/
	if($guardar=="uf")
	{
			$eliminar="DELETE FROM subs_web.mes_uf WHERE fecha = '".$fecha."'";
			mysql_query($eliminar);
			$insertar="INSERT INTO subs_web.mes_uf (fecha,valor) values ('".$fecha."','".$valor_uf."')";
			if($consulta = mysql_query($insertar)){
				msg_usuario("LOS DATOS SE INGRESARON CORRECTAMENTE");		
			}else{			
				msg_usuario("ERROR AL INGRESAR UF");		
		   }
	}
   
?>