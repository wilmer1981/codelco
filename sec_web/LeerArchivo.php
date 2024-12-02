<?php
//ruta:ruta,archivo:archivo,vpeso:vpeso
$ruta      = isset($_REQUEST['ruta'])?$_REQUEST['ruta']:"";
$archivo   = isset($_REQUEST['archivo'])?$_REQUEST['archivo']:"";
$vpeso     = isset($_REQUEST['vpeso'])?$_REQUEST['vpeso']:"0";
$output    = LeerArchivo($ruta,$archivo,$vpeso);
$respuestaValidacion = array();
$respuestaValidacion["respuesta"] = true;
$respuestaValidacion["numero"] = $output;
//Convertimos el array a JSON y lo imprimimos para que pueda recuperarlo el JS
$respuesta = json_encode($respuestaValidacion);
echo $respuesta;

/*************** Funcion Leer Archivo TXT**************************/
//Modulo : PESAJE
function LeerArchivo($ruta,$archivo,$vpeso)
{   $valor=0;
	$nombre=$archivo;
	if($ruta!=""){
		$ubicacion = "D:\\xampp\\htdocs\\proyecto\\".$ruta."\\".$nombre;
	}else{
		$ubicacion = 'D:/'.$nombre;
	}	
	if(file_exists($ubicacion)){
		$arc = fopen($ubicacion,"r");
		while(! feof($arc))  {
			$valor = fgets($arc);
		}
		fclose($arc);
	}else{
		$valor=$vpeso;
	}
	return($valor); 
}

?>