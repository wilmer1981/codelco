<?
	include("../principal/conectar_sea_web.php");
//*******************************************************************************//
	//Valida que no se realicen cambios de movimientos, en la fecha ingresada.
/*	
	$valida_fecha_movimiento = $ano."-".$mes."-".$dia;
	include("sea_valida_mes.php");
//*******************************************************************************/

$codigo = substr($proveedor,0,1);

//ANODOS
if (($Proceso == 'M' || $Proceso == 'G') && $codigo == "A")
{

    $fecha = $ano.'-'.$mes.'-'.$dia;
	reset($unidades);	
	while (list($clave,$valor) = each($unidades))
	{
		$hornadas = '';
        $unidades_total = '';
        $peso_total = '';
					
		$hornadas = '';
        $unidades_total = '';
        $peso_total = '';
		
		$peso_unidades = '';
		$unidades_nuevas = '';

		if($hornada_aux[$clave]	!= '')
           $hornadas = $hornada_aux[$clave];

		if($peso_recepcion[$clave] == 0 || $peso_recepcion[$clave] == '')  
		{
		   $peso_recep =  $peso_origen[$clave];
		   $estado = 1;
		}
		else
		{
		   $peso_recep = $peso_recepcion[$clave];
		   $estado = 0;
		}  

     if($unidades[$clave] != '')
	 {
			$consulta = "SELECT * FROM sea_web.movimientos WHERE tipo_movimiento = 1 AND fecha_movimiento = '$fecha' AND hornada = $hornadas";
			$rs2 = mysql_query($consulta);
			if($row2 = mysql_fetch_array($rs2))
			{
			
					$unidades_nuevas = '';
					$peso_unidades = '';
					$consulta = "SELECT * from sea_web.hornadas where hornada_ventana = $hornadas";
					$rs = mysql_query($consulta);
					if($row = mysql_fetch_array($rs))
					{
					   $unidades_nuevas = $row[unidades] - $unidades_ant[$clave];
					   $unidades_nuevas = $unidades_nuevas + $unidades[$clave];
			
					   $peso_unidades = $row[peso_unidades] - $peso_ant[$clave];
					   $peso_unidades = $peso_unidades + $peso_recep;
			 
					   $Actualizar = "UPDATE sea_web.hornadas set unidades = $unidades_nuevas, peso_unidades = $peso_unidades WHERE hornada_ventana = $hornadas";
					   mysql_query($Actualizar);
					}
			
					$Actualizar1 = "UPDATE sea_web.movimientos set unidades = $unidades[$clave], peso = $peso_recep, peso_origen = $peso_origen[$clave] WHERE tipo_movimiento = 1 AND fecha_movimiento = '$fecha' AND hornada = $hornadas";
					mysql_query($Actualizar1);  
			}
			else
			{
					//consulta flujo
					$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 1 AND cod_producto = 17";
					$consulta = $consulta." AND cod_subproducto = ".$producto[$clave];
		
					$rs1 = mysql_query($consulta);
			
					if ($row1 = mysql_fetch_array($rs1))
					   $flujo = $row1[flujo];
					else 
					   $flujo = 0;
						   
					//Inserta en Movimientos
					$Insertar = "INSERT INTO sea_web.movimientos";
					$Insertar = "$Insertar (tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,fecha_movimiento,campo1,campo2,unidades,flujo,peso,estado,lote_ventana,peso_origen)";	
					$Insertar = "$Insertar  VALUES(1,17,$producto[$clave],$hornadas,$recargo[$clave],'$fecha','999999','999999',$unidades[$clave],$flujo,$peso_recep,$estado,$lote_ventana[$clave],$peso_origen[$clave])";
					mysql_query($Insertar);
		
					//consulto en tabla Hornadas
					$Consulta = "SELECT * FROM sea_web.hornadas WHERE hornada_ventana = $hornadas";
					$rs = mysql_query($Consulta);
					
					if($row = mysql_fetch_array($rs))
					{ 
						$unidades_total =  $unidades[$clave] + $row[unidades];
						$peso_total =  $peso_recep + $row[peso_unidades];		  
			
						$Actualizar = "UPDATE sea_web.hornadas set unidades = $unidades_total, peso_unidades = $peso_total WHERE hornada_ventana= $hornadas AND cod_producto =17";
						mysql_query($Actualizar);
						//echo $Actualizar.'<br>';
		
					} 
					else
					{
						$Insertar2 = "INSERT INTO sea_web.hornadas";
						$Insertar2 = "$Insertar2 (cod_producto,cod_subproducto,hornada_ventana,unidades,peso_unidades)";			
						$Insertar2 = "$Insertar2 VALUES(17,$producto[$clave],$hornadas,$unidades[$clave],$peso_recep)";
						mysql_query($Insertar2);
						
					}
			
			}

		}

	}			

}


//BLISTER
if (($Proceso == 'M' || $Proceso == 'G') && $codigo == "B")
{

    $fecha = $ano.'-'.$mes.'-'.$dia;

	reset($unidades);	
	while (list($clave,$valor) = each($unidades))
	{
		$hornadas = '';
        $unidades_total = '';
        $peso_total = '';
		$peso_recep = 0;							

		$peso_unidades = '';
		$unidades_nuevas = '';

        $hornadas = "200".$hornada[$clave];

		if($peso_recepcion[$clave] == 0 || $peso_recepcion[$clave] == '')  
		{
		   $peso_recep =  $peso_origen[$clave];
		   $estado = 1;
		}
		else
		{
		   $peso_recep = $peso_recepcion[$clave];
		   $estado = 0;
		}  

	       $peso_recep = $peso_recep - ($zuncho[$clave] * $unidades[$clave]);

     if($unidades[$clave] != '')
	 {
			$consulta = "SELECT * FROM sea_web.movimientos WHERE tipo_movimiento = 1 AND fecha_movimiento = '$fecha' AND hornada = $hornadas AND numero_recarga = $recargo[$clave] AND lote_ventana = $lote_ventana[$clave]";
			$rs2 = mysql_query($consulta);
			if($row2 = mysql_fetch_array($rs2))
			{
			
					$unidades_nuevas = '';
					$peso_unidades = '';
                					
					$consulta = "SELECT * from sea_web.hornadas where hornada_ventana = $hornadas";
					$rs = mysql_query($consulta);
					if($row = mysql_fetch_array($rs))
					{
					   $unidades_nuevas = $row[unidades] - $unidades_ant[$clave];
					   $unidades_nuevas = $unidades_nuevas + $unidades[$clave];
			
					   $peso_unidades = $row[peso_unidades] - $peso_ant[$clave];
					   $peso_unidades = $peso_unidades + $peso_recep;
			 
					$Actualizar = "UPDATE sea_web.hornadas set unidades = $unidades_nuevas, peso_unidades = $peso_unidades WHERE hornada_ventana = $hornadas";
					mysql_query($Actualizar);
					}
					
					$Actualizar1 = "UPDATE sea_web.movimientos set cod_subproducto = $subproducto[$clave], unidades = $unidades[$clave], peso = $peso_recep, peso_origen = $peso_origen[$clave], zuncho = $zuncho[$clave] WHERE tipo_movimiento = 1 AND fecha_movimiento = '$fecha' AND numero_recarga = $recargo[$clave] AND lote_ventana = $lote_ventana[$clave]";
					mysql_query($Actualizar1);  
			}
			else
			{					
					//consulta flujo
					$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 1 AND cod_producto = 16";
					$consulta = $consulta." AND cod_subproducto = ".$subproducto[$clave];		
					$rs1 = mysql_query($consulta);
			
					if ($row1 = mysql_fetch_array($rs1))
					   $flujo = $row1[flujo];
					else 
					   $flujo = 0;

					//consulta relaciones
					$consulta = "SELECT * FROM sea_web.relaciones WHERE cod_origen = $subproducto[$clave] AND lote_ventana = $lote_ventana[$clave] AND hornada_ventana = $hornadas";
					$rs3 = mysql_query($consulta);
			
					if ($row3 = mysql_fetch_array($rs3))
					{
						if($row3[estado_lote] != $radio[$clave])
						{
							$Actualiza = "UPDATE sea_web.relaciones SET estado_lote = $radio[$clave]  WHERE cod_origen = $subproducto[$clave] AND lote_ventana = $lote_ventana[$clave] AND hornada_ventana = $hornadas";	
							mysql_query($Actualiza);
						}		
					}
					else 
					{					
						$Inserta = "INSERT INTO sea_web.relaciones (cod_origen,lote_ventana,lote_origen,hornada_externa,hornada_ventana,marca,ciclo,estado_lote)";
						$Inserta = $Inserta."VALUES (".$subproducto[$clave].",".$lote_ventana[$clave].",'NA',16,".$hornadas.",'NA',0,".$radio[$clave].")";
						mysql_query($Inserta);
					}
					
					//Zuncho
					$Consulta = "SELECT * FROM sea_web.relacion_zuncho WHERE cod_producto = 16 AND cod_subproducto = ".$subproducto[$clave];
					$rs = mysql_query($Consulta);
					
					if($row = mysql_fetch_array($rs))
					{
						$Actualizar = "UPDATE sea_web.relacion_zuncho SET zuncho = $zuncho[$clave] WHERE cod_producto = 16 AND cod_subproducto = ".$subproducto[$clave];
						mysql_query($Actualizar);
					}
					else
					{
						$Insertar = "INSERT INTO sea_web.relacion_zuncho (cod_producto, cod_subproducto, zuncho)";
						$Insertar = $Insertar."VALUES (16,".$subproducto[$clave].",".$zuncho[$clave].")";
						mysql_query($Insertar);
					}	
															   
					//Inserta en Movimientos
					$Insertar = "INSERT INTO sea_web.movimientos";
					$Insertar = "$Insertar (tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,fecha_movimiento,campo1,campo2,unidades,flujo,peso,estado,peso_origen,lote_ventana,zuncho)";	
					$Insertar = "$Insertar  VALUES(1,16,$subproducto[$clave],$hornadas,$recargo[$clave],'$fecha','$guia[$clave]','$patente[$clave]',$unidades[$clave],$flujo,$peso_recep,$estado,$peso_origen[$clave],$lote_ventana[$clave],$zuncho[$clave])";
				    mysql_query($Insertar);
					//echo $Insertar.'<br>';

		
					//Consulto en tabla Hornadas
					$Consulta = "SELECT * FROM sea_web.hornadas WHERE hornada_ventana = $hornadas";
					$rs = mysql_query($Consulta);
					
					if($row = mysql_fetch_array($rs))
					{ 
						$unidades_total =  $unidades[$clave] + $row[unidades];
						$peso_total =  $peso_recep + $row[peso_unidades];		  
			
						$Actualizar = "UPDATE sea_web.hornadas set unidades = $unidades_total, peso_unidades = $peso_total WHERE hornada_ventana= $hornadas AND cod_producto =16";
						mysql_query($Actualizar);		
					} 
					else
					{
						$Insertar2 = "INSERT INTO sea_web.hornadas";
						$Insertar2 = "$Insertar2 (cod_producto,cod_subproducto,hornada_ventana,unidades,peso_unidades)";			
						$Insertar2 = "$Insertar2 VALUES(16,$subproducto[$clave],$hornadas,$unidades[$clave],$peso_recep)";
						mysql_query($Insertar2);
					}
			
			}

		}

	}			

}

        $valores = 'mostrar=S'.'&ano='.$ano.'&mes='.$mes.'&dia='.$dia.'&proveedor='.$proveedor; 
        header("Location:sea_ing_recep_inter.php?".$valores);
	include("../principal/cerrar_sea_web.php");		
?>