<?php
/*** devolvemos el ultimo dia de cada mes ****************/
function ultimodia($mes,$ano,$ultdia){
	
	if($mes=='04' || $mes=='06' || $mes=='09' || $mes=='11'){
	  $ultdia=30;
	}
	 
	if($mes=='01' || $mes=='03' || $mes=='05' || $mes=='07' || $mes=='08' || $mes=='10' || $mes=='12'){
	   $ultdia=31;
	}
	$AnoBisiesto = esBisiesto($ano);
	 
	if($mes=='02' && $AnoBisiesto==1){
		$ultdia=29;
	}
	if($mes=='02' && $AnoBisiesto==0){
		$ultdia=28;
	}
	 
	return $ultdia;
}

/*** Comprobamos si un año es bisiesto 
  return 0 -- Año no es bisiesto
  return 1 -- Año es bisiesto
****************/
function esBisiesto($anio=null) {
	return date('L',($anio==null) ? time(): strtotime($anio.'-01-01'));
}

?>