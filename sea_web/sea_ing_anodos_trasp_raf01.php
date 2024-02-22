<?php
$fecha_r = $ano_r."-".$mes_r."-".$dia_r;

include("../principal/conectar_sea_web.php");

if ($Proceso == 'G')
{

// guarda en traspaso a Raf
	$largo_h = strlen($valores_hornada);
	$largo_p = strlen($valores_peso);	
	$largo_u = strlen($valores_unidades);
	$largo_p_a = strlen($valores_peso_a);
	$largo_u_a = strlen($valores_unidades_a);
	$largo_s = strlen($valores_subproducto);

	for ($i=0; $i < $largo_h; $i++)
	{
		if (substr($valores_hornada,$i,1) == "/")
		{				
			$valor_h = substr($valores_hornada,0,$i);				
			$valores_hornada = substr($valores_hornada,$i+1);
			$i = 0;
			
	        if(strlen($valores_unidades) > 0)
			{
				$Insertar = "INSERT INTO movimientos";
				$Insertar = "$Insertar (tipo_movimiento,
									   cod_producto,
									   cod_subproducto,								   
									   hornada,
									   numero_recarga,
									   fecha_movimiento,
									   unidades)";
				$Insertar = "$Insertar VALUES(4,17,0,$valor_h,0,'$fecha_r',0)";
				mysqli_query($link, $Insertar);
			}

   		    //inserta en aprobados a raf			
	        if((strlen($valores_unidades_a) > 0) or ($buenos_raf == "S" and (strlen($valores_unidades) > 0)))
			{
				$Insertar = "INSERT INTO movimientos";
				$Insertar = "$Insertar (tipo_movimiento,
									   cod_producto,
									   cod_subproducto,								   
									   hornada,
									   numero_recarga,
									   fecha_movimiento,
									   unidades)";
				$Insertar = "$Insertar VALUES(7,17,0,$valor_h,0,'$fecha_r',0)";
				mysqli_query($link, $Insertar);			
             }
			
			for ($l=0; $l < $largo_u; $l++)
			{
				if (substr($valores_subproducto,$l,1) == "/")
				{				
					$valor_s = substr($valores_subproducto,0,$l);				
					$valores_subproducto = substr($valores_subproducto,$l+1);
					$l=0;
					
                    /************ consulto flujo *********/ 
		             include("../principal/conectar_principal.php");
					
		             $consulta = "SELECT flujo FROM relacion_prod_flujo_nodo WHERE cod_proceso = 4 AND cod_producto = 17";
		             $consulta = $consulta." AND cod_subproducto = ".$valor_s;
		
		             $rs1 = mysqli_query($link, $consulta);
		             if ($row1 = mysqli_fetch_array($rs1))
			         $flujo = $row1["flujo"];
		             else 
			         $flujo = 0;
					
                	include("../principal/conectar_sea_web.php");									
					$Actualizar = "UPDATE movimientos set cod_subproducto = $valor_s, flujo = $flujo WHERE tipo_movimiento in (4,7) AND fecha_movimiento='$fecha_r' AND hornada= $valor_h AND cod_subproducto = 0";
					mysqli_query($link, $Actualizar);
					
					break;
				}			
		
			}

			for ($j=0; $j < $largo_u; $j++)
			{
				if (substr($valores_unidades,$j,1) == "/")
				{				
					$valor_u = substr($valores_unidades,0,$j);				
					$valores_unidades = substr($valores_unidades,$j+1);
					$j=0;
					$Actualizar1 = "UPDATE movimientos SET unidades = $valor_u WHERE tipo_movimiento = 4 AND fecha_movimiento='$fecha_r' AND hornada= $valor_h AND unidades = 0";
					 mysqli_query($link, $Actualizar1);
					 
					break;
				}			
		
			}
			
			// inserta unidades en aprobados
			for ($j=0; $j < $largo_u_a; $j++)
			{
				if (substr($valores_unidades_a,$j,1) == "/")
				{				
					$valor_u = substr($valores_unidades_a,0,$j);				
					$valores_unidades_a = substr($valores_unidades_a,$j+1);
					$j=0;
					$Actualizar1 = "UPDATE movimientos SET unidades = $valor_u WHERE tipo_movimiento = 7 AND fecha_movimiento='$fecha_r' AND hornada= $valor_h AND unidades = 0";
					 mysqli_query($link, $Actualizar1);
					 
					break;
				}			
		
			}
																	    			

  		}
		
  	}



    $valores = "Mensaje=1"."&Proceso=V"."&cmbtipo=".$cmbtipo."&cmbproducto=".$cmbproducto."&dia_t=".$dia_t."&mes_t=".$mes_t."&ano_t=".$ano_t."&dia_r=".$dia_r."&mes_r=".$mes_r."&ano_r=".$ano_r;  

    header("Location:sea_ing_anodos_trasp_raf.php?".$valores); 

}

?>