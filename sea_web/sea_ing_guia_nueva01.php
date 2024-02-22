<?php

/******************************* Guardar *********************************/
if ($Proceso == 'G')
{
	$largo_h = strlen($valores_hornada);
	$largo_p = strlen($valores_peso);
	$largo_u = strlen($valores_unidades);
    $largo_a = strlen($valores_cmbanodos);
	$largo_l = strlen($valores_lote);
	$largo_r = strlen($valores_recargo);

	
	for ($k=0; $k < $largo_h; $k++)
	{
         include("../principal/conectar_sea_web.php");
		
		/********* inserta hornada ***********/

		if (substr($valores_hornada,$k,1) == "/")
		{				

			$valor_h = substr($valores_hornada,0,$k);				
			$valores_hornada = substr($valores_hornada,$k+1);
			$k = 0;

			$Insertar = "INSERT INTO movimientos";
			$Insertar = "$Insertar (tipo_movimiento,
			                       cod_producto,
								   cod_subproducto,
								   hornada,
								   numero_recarga,
								   fecha_movimiento,
								   campo1,
								   campo2,
								   unidades,								 
								   flujo,
								   peso)";
		    $Insertar = "$Insertar VALUES(1,17,0,$valor_h,0,'$fecha','$guia','$patente',0,0,0)";
		    mysqli_query($link, $Insertar);			
						
			//consulto
			$Consulta = "SELECT * FROM hornadas WHERE hornada_ventana = $valor_h";
			$rs = mysqli_query($link, $Consulta);
			
			if($row = mysqli_fetch_array($rs))
			{ 
              $unidades = $row["unidades"];
			  $peso = $row[peso_unidades];
			} 
			else
			{
				$Insertar2 = "INSERT INTO hornadas";
				$Insertar2 = "$Insertar2 (cod_producto,cod_subproducto,
										  hornada_ventana,unidades,peso_unidades)";
									   
				$Insertar2 = "$Insertar2 VALUES(17,0,$valor_h,0,0)";
				mysqli_query($link, $Insertar2);
			}
			
			
			/********** inserta	cod_subproducto de anodos *********/	
			for ($j=0; $l < $largo_a; $j++)
			{
				if (substr($valores_cmbanodos,$j,1) == "/")
				{				
					$valor_a = substr($valores_cmbanodos,0,$j);				
					$valores_cmbanodos = substr($valores_cmbanodos,$j+1);
					$j=0;


                    /************ consulto flujo *********/ 
		             include("../principal/conectar_principal.php");
					
		             $consulta = "SELECT flujo FROM relacion_prod_flujo_nodo WHERE cod_proceso = 1 AND cod_producto = 17";
		             $consulta = $consulta." AND cod_subproducto = ".$valor_a;
		
		             $rs1 = mysqli_query($link, $consulta);
		             if ($row1 = mysqli_fetch_array($rs1))
			         	$flujo = $row1["flujo"];
		             else 
			        	$flujo = 0;
					
					include("../principal/conectar_sea_web.php");
					 
					$Actualizar1 = "UPDATE movimientos set cod_subproducto = $valor_a, flujo = $flujo where fecha_movimiento='$fecha' and hornada= $valor_h and cod_subproducto = 0 and flujo=0";
			    	 mysqli_query($link, $Actualizar1);

					$Actualizar5 = "UPDATE hornadas set cod_subproducto = $valor_a where hornada_ventana= $valor_h and cod_producto =17 and cod_subproducto = 0";
					mysqli_query($link, $Actualizar5);
					break;

				}			
		
			}
			
			
           /************** inserta nro recargo ************/
			for ($r=0; $l < $largo_r; $r++)
			{
				if (substr($valores_recargo,$r,1) == "/")
				{				
					$valor_r = substr($valores_recargo,0,$r);				
					$valores_recargo = substr($valores_recargo,$r+1);
					$r=0;

					$Actualizar2 = "UPDATE movimientos set numero_recarga = $valor_r where fecha_movimiento='$fecha' and hornada= $valor_h and numero_recarga = 0 and tipo_movimiento = 1";
					mysqli_query($link, $Actualizar2);
					break;
				}			
		
			}

			/************** inserta unidades ****************/
			for ($u=0; $u < $largo_u; $u++)
			{
				if (substr($valores_unidades,$u,1) == "/")
				{				
					$valor_u = substr($valores_unidades,0,$u);				
					$valores_unidades = substr($valores_unidades,$u+1);
					$u=0;

					$Actualizar3 = "UPDATE movimientos set unidades = $valor_u where fecha_movimiento='$fecha' and hornada= $valor_h and unidades = 0 and tipo_movimiento = 1";
					mysqli_query($link, $Actualizar3);

                    $valor_u = $valor_u + $row["unidades"]; 
 					$Actualizar6 = "UPDATE hornadas set unidades = $valor_u where hornada_ventana= $valor_h and cod_producto =17";
					mysqli_query($link, $Actualizar6);
					break;     
				} 					
			
			}
											
			/***************** Actualiza peso ************/
			for ($p=0; $p < $largo_p; $p++)
			{
				if (substr($valores_peso,$p,1) == "/")
				{				
					$valor_p = substr($valores_peso,0,$p);				
					$valores_peso = substr($valores_peso,$p+1);
					$p=0;

					$Actualizar4 = "UPDATE movimientos set peso = $valor_p where fecha_movimiento='$fecha' and hornada= $valor_h and peso = 0 and tipo_movimiento = 1";
					mysqli_query($link, $Actualizar4);

					$valor_p =  $valor_p  + $row[peso_unidades];
					$Actualizar7 = "UPDATE hornadas set peso_unidades = $valor_p where hornada_ventana= $valor_h and cod_producto =17";
					mysqli_query($link, $Actualizar7);
					break;

				}

			}

       
      }     
  } 

		echo "<Script>
			JavaScript:window.close();
			</Script>";
}


?>