<?php

$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";

$ano_r = isset($_REQUEST["ano_r"])?$_REQUEST["ano_r"]:date("Y");
$mes_r = isset($_REQUEST["mes_r"])?$_REQUEST["mes_r"]:date("m");
$dia_r = isset($_REQUEST["dia_r"])?$_REQUEST["dia_r"]:date("d");

$ano_t = isset($_REQUEST["ano_t"])?$_REQUEST["ano_t"]:date("Y");
$mes_t = isset($_REQUEST["mes_t"])?$_REQUEST["mes_t"]:date("m");
$dia_t = isset($_REQUEST["dia_t"])?$_REQUEST["dia_t"]:date("d");
$radio = isset($_REQUEST["radio"])?$_REQUEST["radio"]:"";
$cmbtipo = isset($_REQUEST["cmbtipo"])?$_REQUEST["cmbtipo"]:"";
$cmbproducto = isset($_REQUEST["cmbproducto"])?$_REQUEST["cmbproducto"]:"";

$valores_hornada     = isset($_REQUEST["valores_hornada"])?$_REQUEST["valores_hornada"]:"";
$valores_peso        = isset($_REQUEST["valores_peso"])?$_REQUEST["valores_peso"]:"";
$valores_unidades    = isset($_REQUEST["valores_unidades"])?$_REQUEST["valores_unidades"]:"";
$valores_subproducto = isset($_REQUEST["valores_subproducto"])?$_REQUEST["valores_subproducto"]:"";
$valores_producto    = isset($_REQUEST["valores_producto"])?$_REQUEST["valores_producto"]:"";

$fecha_r = $ano_r."-".$mes_r."-".$dia_r;

include("../principal/conectar_sea_web.php");

//*******************************************************************************//
	//Valida que no se realicen cambios de movimientos, en la fecha ingresada.
	
	$valida_fecha_movimiento = $ano_r."-".$mes_r."-".$dia_r;
	include("sea_valida_mes.php");
//******************************************************************************//

if ($Proceso == 'G1')
{

// guarda en traspaso a Raf
	$largo_h = strlen($valores_hornada);
	$largo_p = strlen($valores_peso);	
	$largo_u = strlen($valores_unidades);
	$largo_s = strlen($valores_subproducto);
	$largo_pr = strlen($valores_producto);

	for ($i=0; $i < $largo_h; $i++)
	{
		if (substr($valores_hornada,$i,1) == "/")
		{				
			$valor_h = substr($valores_hornada,0,$i);				
			$valores_hornada = substr($valores_hornada,$i+1);
			$i = 0;
			
  			$Insertar = "INSERT INTO movimientos";
			$Insertar = "$Insertar (tipo_movimiento,
			                       cod_producto,
								   cod_subproducto,								   
								   hornada,
								   numero_recarga,
								   fecha_movimiento,
								   unidades,
								   peso)";
		    $Insertar = "$Insertar VALUES(5,0,0,$valor_h,0,'$fecha_r',0,0)";
			mysqli_query($link, $Insertar);
			

			for ($l=0; $l < $largo_pr; $l++)
			{
				if (substr($valores_producto,$l,1) == "/")
				{				
					$valor_pr = substr($valores_producto,0,$l);				
					$valores_producto = substr($valores_producto,$l+1);
					$l=0;
					
                	include("../principal/conectar_sea_web.php");									
					$Actualizar = "UPDATE movimientos set cod_producto = $valor_pr WHERE tipo_movimiento = 5 AND fecha_movimiento='$fecha_r' AND hornada= $valor_h AND cod_producto = 0";
					mysqli_query($link, $Actualizar);
					
					break;
				}			
		
			}

			for ($l=0; $l < $largo_s; $l++)
			{
				if (substr($valores_subproducto,$l,1) == "/")
				{				
					$valor_s = substr($valores_subproducto,0,$l);				
					$valores_subproducto = substr($valores_subproducto,$l+1);
					$l=0;
					
                    //consulto flujo 
		             include("../principal/conectar_principal.php");
					
		             $consulta = "SELECT flujo FROM relacion_prod_flujo_nodo WHERE cod_proceso = 4 AND cod_producto = 17";
		             $consulta = $consulta." AND cod_subproducto = ".$valor_s;
		
		             $rs1 = mysqli_query($link, $consulta);
		             if ($row1 = mysqli_fetch_array($rs1))
			         $flujo = $row1["flujo"];
		             else 
			         $flujo = 0;
					
                	include("../principal/conectar_sea_web.php");									
					$Actualizar = "UPDATE movimientos set cod_subproducto = $valor_s WHERE tipo_movimiento = 5 AND fecha_movimiento='$fecha_r' AND hornada= $valor_h AND cod_subproducto = 0";
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
					$Actualizar1 = "UPDATE movimientos SET unidades = $valor_u WHERE tipo_movimiento = 5 AND fecha_movimiento='$fecha_r' AND hornada= $valor_h AND unidades = 0";
					 mysqli_query($link, $Actualizar1);
					 
					break;
				}			
		
			}

			for ($k=0; $k < $largo_p; $k++)
			{
				if (substr($valores_peso,$k,1) == "/")
				{				
					$valor_p = substr($valores_peso,0,$k);				
					$valores_peso = substr($valores_peso,$k+1);
					$k=0;
					$Actualizar1 = "UPDATE movimientos SET peso = $valor_p WHERE tipo_movimiento = 5 AND fecha_movimiento='$fecha_r' AND hornada= $valor_h AND peso = 0";
					 mysqli_query($link, $Actualizar1);
					 
					break;
				}			
		
			}
																				    			

  		}
		
  	}



    $valores = "Mensaje=1"."&radio=".$radio."&Proceso=V"."&cmbtipo=".$cmbtipo."&cmbproducto=".$cmbproducto."&dia_t=".$dia_t."&mes_t=".$mes_t."&ano_t=".$ano_t."&dia_r=".$dia_r."&mes_r=".$mes_r."&ano_r=".$ano_r;  

    header("Location:sea_ing_anodos_a_venta.php?".$valores); 

}


if ($Proceso == 'G2')
{

// guarda en traspaso a Raf
	$largo_h = strlen($valores_hornada);
	$largo_p = strlen($valores_peso);	
	$largo_u = strlen($valores_unidades);
	$largo_s = strlen($valores_subproducto);
	$largo_pr = strlen($valores_producto);

	for ($i=0; $i < $largo_h; $i++)
	{
		if (substr($valores_hornada,$i,1) == "/")
		{				
			$valor_h = substr($valores_hornada,0,$i);				
			$valores_hornada = substr($valores_hornada,$i+1);
			$i = 0;
			
  			$Insertar = "INSERT INTO movimientos";
			$Insertar = "$Insertar (tipo_movimiento,
			                       cod_producto,
								   cod_subproducto,								   
								   hornada,
								   numero_recarga,
								   fecha_movimiento,
								   unidades,
								   peso)";
		    $Insertar = "$Insertar VALUES(9,0,0,$valor_h,0,'$fecha_r',0,0)";
			mysqli_query($link, $Insertar);
			

			for ($l=0; $l < $largo_pr; $l++)
			{
				if (substr($valores_producto,$l,1) == "/")
				{				
					$valor_pr = substr($valores_producto,0,$l);				
					$valores_producto = substr($valores_producto,$l+1);
					$l=0;
					
                	include("../principal/conectar_sea_web.php");									
					$Actualizar = "UPDATE movimientos set cod_producto = $valor_pr WHERE tipo_movimiento = 9 AND fecha_movimiento='$fecha_r' AND hornada= $valor_h AND cod_producto = 0";
					mysqli_query($link, $Actualizar);
					
					break;
				}			
		
			}

			for ($l=0; $l < $largo_s; $l++)
			{
				if (substr($valores_subproducto,$l,1) == "/")
				{				
					$valor_s = substr($valores_subproducto,0,$l);				
					$valores_subproducto = substr($valores_subproducto,$l+1);
					$l=0;
					
                    // consulto flujo 
		             include("../principal/conectar_principal.php");
					
		             $consulta = "SELECT flujo FROM relacion_prod_flujo_nodo WHERE cod_proceso = 4 AND cod_producto = 17";
		             $consulta = $consulta." AND cod_subproducto = ".$valor_s;
		
		             $rs1 = mysqli_query($link, $consulta);
		             if ($row1 = mysqli_fetch_array($rs1))
			         $flujo = $row1["flujo"];
		             else 
			         $flujo = 0;
					
                	include("../principal/conectar_sea_web.php");									
					$Actualizar = "UPDATE movimientos set cod_subproducto = $valor_s WHERE tipo_movimiento = 9 AND fecha_movimiento='$fecha_r' AND hornada= $valor_h AND cod_subproducto = 0";
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
					$Actualizar1 = "UPDATE movimientos SET unidades = $valor_u WHERE tipo_movimiento = 9 AND fecha_movimiento='$fecha_r' AND hornada= $valor_h AND unidades = 0";
					 mysqli_query($link, $Actualizar1);
					 
					break;
				}			
		
			}

			for ($k=0; $k < $largo_p; $k++)
			{
				if (substr($valores_peso,$k,1) == "/")
				{				
					$valor_p = substr($valores_peso,0,$k);				
					$valores_peso = substr($valores_peso,$k+1);
					$k=0;
					$Actualizar1 = "UPDATE movimientos SET peso = $valor_p WHERE tipo_movimiento = 9 AND fecha_movimiento='$fecha_r' AND hornada= $valor_h AND peso = 0";
					 mysqli_query($link, $Actualizar1);
					 
					break;
				}			
		
			}
			
																	    			

  		}
		
  	}



    $valores = "Mensaje=1"."&radio=".$radio."&Proceso=V"."&cmbtipo=".$cmbtipo."&cmbproducto=".$cmbproducto."&dia_t=".$dia_t."&mes_t=".$mes_t."&ano_t=".$ano_t."&dia_r=".$dia_r."&mes_r=".$mes_r."&ano_r=".$ano_r;  

    header("Location:sea_ing_anodos_a_venta.php?".$valores); 

}

?>