<?php
$carpeta = $_POST['carpeta'];
$archivo = $_POST['archivo'];
$content = $_POST['content'];

$output = EscribirArchivo($carpeta,$archivo,$content);

$respuestaValidacion = array();
$respuestaValidacion["respuesta"] = true;
$respuestaValidacion["valor"] = $output;
$respuestaValidacion["carpeta"] = $carpeta;
$respuestaValidacion["arhcivo"] = $archivo;
$respuestaValidacion["content"] = $content;
//Convertimos el array a JSON y lo imprimimos para que pueda recuperarlo el JS
$respuesta = json_encode($respuestaValidacion);
echo $respuesta;

/*************** Funcion Leer Archivo TXT**************************/
//Modulo: RECEPCION
function EscribirArchivo($carpeta,$archivo,$content)
{   $carpeta = 'configuracion_pesaje';
	$fichero = $archivo;
	if($carpeta!=""){
		$ubicacion = "D:\\xampp\\htdocs\\proyecto\\".$carpeta."\\".$fichero;
	}else{
		$ubicacion = "D:/".$fichero;
	}
	//echo "<br>ubicacion:".$ubicacion;
	if(file_exists($ubicacion)){
		// Abre el fichero para obtener el contenido existente		
		$file = fopen($ubicacion,"w");
		fwrite($file, $content . PHP_EOL);	
		fclose($file);
		$valor=true;
	}else{
		$valor=false;
	}
	return $valor; 
}

?>