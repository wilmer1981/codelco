<?php
	/**************** Funcion Resta de fechas *************************/
	function resta_fechas($fecha1,$fecha2)       
 	{         
	//echo "FF".$fecha1."-".$fecha2;
       if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha1))
          list($dia1,$mes1,$año1)=split("/",$fecha1);          
       if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha1))
          list($dia1,$mes1,$año1)=split("-",$fecha1);
       if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha2))
          list($dia2,$mes2,$año2)=split("/",$fecha2);
       if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha2))
          list($dia2,$mes2,$año2)=split("-",$fecha2);
       $dif = mktime(1,0,0,$mes1,$dia1,$año1) - mktime(1,0,0,$mes2,$dia2,$año2);
//	   echo "----DIF-----".$dif."d...".$dia1."...".$mes1."...".$año1;
	//    echo "----dia2---".$dia2."...".$mes2."...".$año2;
       $ndias=floor($dif/(24*60*60));
	//   echo "----NDIAS".$ndias;
       return($ndias);   
  }
 /*****************  Funcion Colocar Cero al Rut *************************/
  function colocar_cero_rut ($rut)
  {
  	if (strlen($rut)==9)
	{
		$rut="0".$rut;
	}
	return($rut);
  }
  /*****************  Funcion Sacar Cero al Rut *************************/
  function sacar_cero_rut ($rut)
  {
  	if ((strlen($rut)==10) && ($rut[0]==0))
	{
		$rut= substr($rut,1);		
	}
	return($rut);
  }
  function sacarmestexto ($num_mes) 
  {
	switch($num_mes)
		{
			case '01':					
				return "Enero";		
				break;
			case '02':					
				return "Febrero";		
				break;
			case '03':					
				return "Marzo";		
				break;
			case '04':					
				return "Abril";		
				break;
			case '05':					
				return "Mayo";		
				break;
			case '06':					
				return "Junio";		
				break;
			case '07':					
				return "Julio";		
				break;
			case '08':					
				return "Agosto";		
				break;
			case '09':					
				return "Septiembre";		
				break;
			case '10':					
				return "Octubre";		
				break;
			case '11':					
				return "Noviembre";		
				break;
			case '12':					
				return "Diciembre";		
				break;					
		}
  }

  function sacarmes ($texto_mes) 
  {
	switch($texto_mes)
		{
			case "Enero":					
				return '01';		
				break;
			case "Febrero":					
				return '02';		
				break;
			case "Marzo":					
				return '03';		
				break;
			case "Abril":					
				return '04';		
					break;
			case "Mayo":					
				return '05';		
				break;
			case "Junio":					
				return '06';		
				break;
			case "Julio":					
				return '07';		
				break;
			case "Agosto":					
				return '08';		
				break;
			case "Septiembre":					
				return '09';		
				break;
			case "Octubre":					
				return '10';		
				break;
			case "Noviembre":					
				return '11';		
				break;
			case "Diciembre":					
				return '12';		
				break;					
		}
 }  
?>