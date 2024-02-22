<?php
	$consulta = "SELECT * FROM sea_web.existencia_nodo";
	$consulta = $consulta." WHERE ano = YEAR('".$valida_fecha_movimiento."') AND mes = MONTH('".$valida_fecha_movimiento."')";
	$consulta = $consulta." AND bloqueado = 1";
	
	$rs = mysqli_query($link, $consulta);
	
	if ($row  = mysqli_fetch_array($rs))
	{
		$meses = array (1=>"Enero", 2=>"Febrero", 3=>"Marzo", 4=>"Abril", 5=>"Mayo", 6=>"Junio", 7=>"Julio", 8=>"Agosto", 9=>"Septiembre", 10=>"Octubre", 11=>"Noviembre", 12=>"Diciembre");
		$array_fecha = explode("-",$valida_fecha_movimiento);
				
		echo '<script language="JavaScript">';
		echo 'alert("El Mes de '.$meses[intval($array_fecha[1])].' Fue Cerrado,\n Ya No Se Puede Realizar Ningun Movimiento\n  Correccion En Este Mes");';
		echo 'window.history.back()';
		echo '</script>';
		//break;
	}	

	$valida_fecha_actual = date("Y-n-j");
	$vector_fecha = explode('-',$valida_fecha_movimiento);
	if (strlen($vector_fecha[1]) == 1)
		$vector_fecha[1] = '0'.$vector_fecha[1];
	if (strlen($vector_fecha[2]) == 1)
		$vector_fecha[2] = '0'.$vector_fecha[2];
	
	$valida_fecha_movimiento = $vector_fecha[0].'-'.$vector_fecha[1].'-'.$vector_fecha[2];
//	echo $valida_fecha_movimiento."<br>";
//	echo $valida_fecha_actual."<br>";	 
		 
	if (date($valida_fecha_movimiento) > date($valida_fecha_actual))
	{
		echo '<script language="JavaScript">';
		echo 'alert("No Puede Grabar el Movimiento En Una Fecha Mayor A La Actual");';
		echo 'window.history.back()';
		echo '</script>';
		//break;			
	}

?>