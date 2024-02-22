<?php
	include("../principal/conectar_sea_web.php");
//*******************************************************************************//
	//Valida que no se realicen cambios de movimientos, en la fecha ingresada.
/*	
	$valida_fecha_movimiento = $ano."-".$mes."-".$dia;
	include("sea_valida_mes.php");
//*******************************************************************************/
$hh_actual = date("H");
$mm_actual = date("i");
$hora_actual = $hh_actual.":".$mm_actual.":00";
$codigo = substr($proveedor,0,1);
$fecha_hora = $ano."-".$mes."-".$dia." ".$Hora.":".$Minutos.":00";
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
		
		if($peso_origen[$clave] == '')
			$peso_origen = 0;  

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
			$consulta = "SELECT * FROM sea_web.movimientos WHERE tipo_movimiento = 1 AND fecha_movimiento = '$Fecha_Mov[$clave]' AND hornada = $hornadas";
			$consulta.=" and sub_tipo_movim = '1'";
			$rs2 = mysqli_query($link, $consulta);
			if($row2 = mysqli_fetch_array($rs2))
			{						
                    //actualiza tabla movimientos
					$Actualizar1 = "UPDATE sea_web.movimientos set fecha_movimiento='$fecha',hora='$fecha_hora',unidades = $unidades[$clave], peso = $peso_recep, peso_origen = $peso_origen[$clave] WHERE tipo_movimiento = 1 AND fecha_movimiento = '$Fecha_Mov[$clave]' AND hornada = $hornadas";
					$Actualizar1.=" and sub_tipo_movim=1 ";
					mysqli_query($link, $Actualizar1);  

                    //actualiza tabla hornadas
					$Consulta = "SELECT SUM(unidades) as unid, SUM(peso) as pes FROM sea_web.movimientos WHERE tipo_movimiento = 1 AND cod_producto = 17 AND hornada = $hornadas";
					$Rs = mysqli_query($link, $Consulta);
					if($fila = mysqli_fetch_array($Rs))
					{
						$Actualizo = "Update sea_web.hornadas set unidades = $fila[unid], peso_unidades = $fila[pes] WHERE cod_producto = 17 AND hornada_ventana = $hornadas";
						mysqli_query($link, $Actualizo);
						
					}
			}
			else
			{
					//consulta flujo
					$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 1 AND cod_producto = 17";
					$consulta = $consulta." AND cod_subproducto = ".$producto[$clave];
		
					$rs1 = mysqli_query($link, $consulta);
			
					if ($row1 = mysqli_fetch_array($rs1))
					   $flujo = $row1["flujo"];
					else 
					   $flujo = 0;
						   
					//Inserta en Movimientos
					//$Fecha_R = $
					$Insertar = "INSERT INTO sea_web.movimientos";
					$Insertar = "$Insertar (tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,fecha_movimiento,campo1,campo2,unidades,flujo,peso,estado,lote_ventana,peso_origen,hora,sub_tipo_movim)";	
					$Insertar = "$Insertar  VALUES(1,17,$producto[$clave],$hornadas,$recargo[$clave],'$fecha','999999','999999',$unidades[$clave],$flujo,$peso_recep,$estado,$lote_ventana[$clave],'".$peso_origen[$clave]."','$fecha_hora',1)";
					mysqli_query($link, $Insertar);
					//consulto en tabla Hornadas
					$Consulta = "SELECT * FROM sea_web.hornadas WHERE hornada_ventana = $hornadas";
					$rs = mysqli_query($link, $Consulta);
					
					if($row = mysqli_fetch_array($rs))
					{ 
						//actualiza tabla hornadas
						$Consulta = "SELECT SUM(unidades) as unid, SUM(peso) as pes FROM sea_web.movimientos WHERE tipo_movimiento = 1 AND cod_producto = 17 AND hornada = $hornadas";
						$Rs = mysqli_query($link, $Consulta);
						if($fila = mysqli_fetch_array($Rs))
						{
							$Actualizo = "Update sea_web.hornadas set unidades = $fila[unid], peso_unidades = $fila[pes] WHERE cod_producto = 17 AND hornada_ventana = $hornadas";
							mysqli_query($link, $Actualizo);
							
						}
		
					} 
					else
					{
						$Insertar2 = "INSERT INTO sea_web.hornadas";
						$Insertar2 = "$Insertar2 (cod_producto,cod_subproducto,hornada_ventana,unidades,peso_unidades)";			
						$Insertar2 = "$Insertar2 VALUES(17,$producto[$clave],$hornadas,$unidades[$clave],$peso_recep)";
						mysqli_query($link, $Insertar2);
					}
			}

		}

	}			

}


//BLISTER
if (($Proceso == 'M' || $Proceso == 'G') && $codigo == "B")
{

    $fecha = $ano.'-'.$mes.'-'.$dia;
	
	//mf 
	$codhorna1 = substr($ano,0,3);

	reset($unidades);	
	while (list($clave,$valor) = each($unidades))
	{
		$hornadas = '';
        $unidades_total = '';
        $peso_total = '';
		$peso_recep = 0;							

		$peso_unidades = '';
		$unidades_nuevas = '';

        //mf $hornadas = "201".$hornada[$clave];
		
		//mf 
		$hornadas = $codhorna1.$hornada[$clave];

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
			$consulta = "SELECT * FROM sea_web.movimientos WHERE tipo_movimiento = 1 AND fecha_movimiento = '$fecha' AND hornada = $hornadas AND numero_recarga = $recargo[$clave] AND lote_ventana = $lote_ventana[$clave] and sub_tipo_movim='1'";
			$rs2 = mysqli_query($link, $consulta);
			if($row2 = mysqli_fetch_array($rs2))
			{
					//actualiza tabla movimientos								
					$Actualizar1 = "UPDATE sea_web.movimientos set cod_subproducto = $subproducto[$clave], unidades = $unidades[$clave], peso = $peso_recep, peso_origen = $peso_origen[$clave], zuncho = $zuncho[$clave] WHERE tipo_movimiento = 1 AND fecha_movimiento = '$fecha' AND numero_recarga = $recargo[$clave] AND lote_ventana = $lote_ventana[$clave] and sub_tipo_movim=1";
					mysqli_query($link, $Actualizar1);  

					//actualiza tabla hornadas
					$Consulta = "SELECT SUM(unidades) as unid, SUM(peso) as pes FROM sea_web.movimientos WHERE tipo_movimiento = 1 AND cod_producto = 16 AND hornada = $hornadas";
					$Rs = mysqli_query($link, $Consulta);
					if($fila = mysqli_fetch_array($Rs))
					{
						$Actualizo = "Update sea_web.hornadas set unidades = $fila[unid], peso_unidades = $fila[pes] WHERE cod_producto = 16 AND hornada_ventana = $hornadas";
						mysqli_query($link, $Actualizo);
						
					}

			}
			else
			{					
					//consulta flujo
					$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 1 AND cod_producto = 16";
					$consulta = $consulta." AND cod_subproducto = ".$subproducto[$clave];		
					$rs1 = mysqli_query($link, $consulta);
			
					if ($row1 = mysqli_fetch_array($rs1))
					   $flujo = $row1["flujo"];
					else 
					   $flujo = 0;

					//consulta relaciones
					$consulta = "SELECT * FROM sea_web.relaciones WHERE cod_origen = $subproducto[$clave] AND lote_ventana = $lote_ventana[$clave] AND hornada_ventana = $hornadas";
					$rs3 = mysqli_query($link, $consulta);
			
					if ($row3 = mysqli_fetch_array($rs3))
					{
						if($row3[estado_lote] != $radio[$clave])
						{
							$Actualiza = "UPDATE sea_web.relaciones SET estado_lote = $radio[$clave]  WHERE cod_origen = $subproducto[$clave] AND lote_ventana = $lote_ventana[$clave] AND hornada_ventana = $hornadas";	
							mysqli_query($link, $Actualiza);
						}		
					}
					else 
					{					
						$Inserta = "INSERT INTO sea_web.relaciones (cod_origen,lote_ventana,lote_origen,hornada_externa,hornada_ventana,marca,ciclo,estado_lote)";
						$Inserta = $Inserta."VALUES (".$subproducto[$clave].",'".$lote_ventana[$clave]."','NA',16,".$hornadas.",'NA',0,".$radio[$clave].")";
						mysqli_query($link, $Inserta);
					}
					
					//Zuncho
					$Consulta = "SELECT * FROM sea_web.relacion_zuncho WHERE cod_producto = 16 AND cod_subproducto = ".$subproducto[$clave];
					$rs = mysqli_query($link, $Consulta);
					
					if($row = mysqli_fetch_array($rs))
					{
						$Actualizar = "UPDATE sea_web.relacion_zuncho SET zuncho = $zuncho[$clave] WHERE cod_producto = 16 AND cod_subproducto = ".$subproducto[$clave];
						mysqli_query($link, $Actualizar);
					}
					else
					{
						$Insertar = "INSERT INTO sea_web.relacion_zuncho (cod_producto, cod_subproducto, zuncho)";
						$Insertar = $Insertar."VALUES (16,".$subproducto[$clave].",".$zuncho[$clave].")";
						mysqli_query($link, $Insertar);
					}	
															   
					//Inserta en Movimientos
					$Insertar = "INSERT INTO sea_web.movimientos";
					$Insertar = "$Insertar (tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,fecha_movimiento,campo1,campo2,unidades,flujo,peso,estado,peso_origen,lote_ventana,zuncho,hora,sub_tipo_movim)";	
					$Insertar = "$Insertar  VALUES(1,16,$subproducto[$clave],$hornadas,$recargo[$clave],'$fecha','$guia[$clave]','$patente[$clave]',$unidades[$clave],$flujo,$peso_recep,$estado,$peso_origen[$clave],'".$lote_ventana[$clave]."',$zuncho[$clave],'$fecha_hora',1)";
				    mysqli_query($link, $Insertar);
					//echo $Insertar.'<br>';

		
					//Consulto en tabla Hornadas
					$Consulta = "SELECT * FROM sea_web.hornadas WHERE hornada_ventana = $hornadas";
					$rs = mysqli_query($link, $Consulta);
					
					if($row = mysqli_fetch_array($rs))
					{ 
						$unidades_total =  $unidades[$clave] + $row["unidades"];
						$peso_total =  $peso_recep + $row[peso_unidades];		  
			
						$Actualizar = "UPDATE sea_web.hornadas set unidades = $unidades_total, peso_unidades = $peso_total WHERE hornada_ventana= $hornadas AND cod_producto =16";
						mysqli_query($link, $Actualizar);		
					} 
					else
					{
						$Insertar2 = "INSERT INTO sea_web.hornadas";
						$Insertar2 = "$Insertar2 (cod_producto,cod_subproducto,hornada_ventana,unidades,peso_unidades)";			
						$Insertar2 = "$Insertar2 VALUES(16,$subproducto[$clave],$hornadas,$unidades[$clave],$peso_recep)";
						mysqli_query($link, $Insertar2);
					}
			

			}
			

		}

	}			

}

        $valores = 'mostrar=S'.'&ano='.$ano.'&mes='.$mes.'&dia='.$dia.'&proveedor='.$proveedor; 
        header("Location:sea_ing_recep_inter.php?".$valores);
	include("../principal/cerrar_sea_web.php");		
?>