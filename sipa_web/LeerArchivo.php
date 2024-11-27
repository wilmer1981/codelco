<?php
$ruta = $_POST['ruta'];
$archivo = $_POST['archivo'];

$output = LeerArchivo($ruta,$archivo);
//echo $output;
$respuestaValidacion = array();
$respuestaValidacion["respuesta"] = true;
$respuestaValidacion["numero"] = $output;
 
/*ahora lo imprimes 
IMPORTANTE !! IMPORTANTE !! IMPORTANTE !! IMPORTANTE !! 
No imprimas otra cosa más que la respuesta */
 
//Convertimos el array a JSON y lo imprimimos para que pueda recuperarlo el JS
$respuesta = json_encode($respuestaValidacion);
echo $respuesta;

/*************** Funcion Leer Archivo TXT**************************/
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
		while(! feof($arc))  {
			$valor = fgets($arc);
		}
		fclose($arc);
	}else{
		$valor="";
	}
	return($valor); 
}

?>