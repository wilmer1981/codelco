<?php
	//Elegir tipo movimiento
	$fecha_ini = $ano_i.'-'.$mes_i.'-'.$dia_i;
	$fecha_ter = $ano_t.'-'.$mes_t.'-'.$dia_t;
	
	if ($cmbmovimiento == "1") //Recepcion
	{
		if ($cmborigen == "0") //Incluye Todos
		{
			if ($radio1 == "P") //Por Producto
			{
				if ($radio2 == "F") //Finos
				{
					
				}
				else // Leyes
				{
				
				}
			}
			else // Por Flujo
			{
			}
		}
		else // Individual		
		{
		}
	}
	else if ($cmbmovimiento == "2") //Beneficio
		{
	
		}
	else if ($cmbmovimiento == "3") //Produccion
		{
		}
	


?>