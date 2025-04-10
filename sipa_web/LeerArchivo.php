<?php
$ruta    = $_POST['ruta'];
$archivo = $_POST['archivo'];

$output = LeerArchivo($ruta,$archivo);

$respuestaValidacion = array();
$respuestaValidacion["respuesta"] = true;
$respuestaValidacion["numero"] = $output;
//Convertimos el array a JSON y lo imprimimos para que pueda recuperarlo el JS
$respuesta = json_encode($respuestaValidacion);
echo $respuesta;

/*************** Funcion Leer Archivo TXT**************************/
//Modulo: RECEPCION
function LeerArchivo($ruta,$archivo)
{   $valor=0;
	$nombre=$archivo;
	if($ruta!=""){
		$ubicacion = "D:\\xampp\\htdocs\\proyecto\\".$ruta."\\".$nombre;
	}else{
		$ubicacion = 'D:/'.$nombre;
	}	
	if(file_exists($ubicacion)){
		$arc = fopen($ubicacion,"r");
		while (($line = fgets($arc)) !== false) {
		   //echo $line;  // Imprimir la línea leída
		   $valor = $line;
		}
		/*
		while(! feof($arc))  {
			$valor = fgets($arc);
		}
		*/
		fclose($arc);
	}else{
		$valor="";
	}
	return($valor); 
}

?>