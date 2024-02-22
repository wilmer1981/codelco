<?Php
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