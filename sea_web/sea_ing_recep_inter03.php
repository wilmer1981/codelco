<?php
	include("../principal/conectar_sea_web.php");
//*******************************************************************************//
	//Valida que no se realicen cambios de movimientos, en la fecha ingresada.
/*	
	$valida_fecha_movimiento = $ano."-".$mes."-".$dia;
	include("sea_valida_mes.php");
//*******************************************************************************/

$codigo = substr($proveedor,0,1);
$provee = substr($proveedor,2,10);

//ANODOS  TTE Y DISPUTADA
 $l = strlen($mes);
 if ($l==1)
 {
		$mes = "0$mes";
 }
 $fecha = $ano.'-'.$mes.'-'.$dia;
 $horaI="7:59:59";
 $horaF="8:00:00";
 $fecha2 = date("Y-m-d", mktime(0,0,0,intval(substr($fecha, 5, 2)) ,intval(substr($fecha, 8, 2)) + 1,intval(substr($fecha, 0, 4))));
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
	 	$sumunid = 0;
	 	$pesoprom = 0;
		$ajuste = 49;
		$ajuste = $ajuste / 100;
     	if($unidades[$clave] != '')
	 	{
		        $ll= strlen($lote_ventanas[$clave]);
				if ($ll==7)
				{
					$lote_ventanas[$clave] = "0$lote_ventanas[$clave]";
				}
	 			$pesoprom = $peso_recep / $unidades[$clave];
				$consulta_r = "Select * from sipa_web.recepciones where ((fecha = '".$fecha."' and hora_entrada > '".$horaI."') or ";
				$consulta_r.=" (fecha= '".$fecha2."' and hora_entrada < '".$horaF."')) and rut_prv = '".$provee."' and lote = '".$lote_ventanas[$clave]."'";
				$consulta_r.=" and cod_subproducto = '17'";
				echo $consulta_r;
				$res_r = mysqli_query($link, $consulta_r);
				while ($row_r=mysqli_fetch_array($res_r))
				{
					$unidad_rec = $row_r["peso_neto"] / $peso_prom;
					$unidad_rec = $unidad_rec + $ajuste;
					$unidad_rec = number_format($unidad_rec,0,'','');
					$sumunid = $sumunid + $unidad_rec;
			    	$recargo = $row_r["recargo"];
					$FFecha  = $row_r["fecha"];
					$HHora   = $row_r[hora_entrada];
				
					$consulta = "SELECT * FROM sea_web.movimientos WHERE tipo_movimiento = 1 AND fecha_movimiento = '".$FFecha."' and hora = '".$HHora."' ";
					$consulta.=" AND hornada = '".$hornadas."' and numero_recarga = '".$recargo."' and lote_ventana = '".$lote_ventanas[$clave]."'";;
					$rs2 = mysqli_query($link, $consulta);
					if( $row2 = mysqli_fetch_array($rs2))
					{						
                    	//actualiza tabla movimientos
						$Actualizar1 = "UPDATE sea_web.movimientos set unidades = '".$unidad_rec."', peso = '".$row_r["peso_neto"]."', peso_origen = $peso_origen[$clave]";
						$Actualizar1.=" WHERE tipo_movimiento = 1 AND fecha_movimiento = '".$FFecha."' and hora = '".HHora."'  AND hornada = $hornadas";
						$Actualizar1.=" and numero_recarga = '".$recargo."'";
						mysqli_query($link, $Actualizar1);  
                       //actualiza tabla hornadas
					   $Consulta = "SELECT SUM(unidades) as unid, SUM(peso) as pes FROM sea_web.movimientos WHERE tipo_movimiento = 1 "
					   $Consulta.= "and  cod_producto = 17 AND hornada = $hornadas";
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
					$Insertar = "INSERT INTO sea_web.movimientos";
					$Insertar = "$Insertar (tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,fecha_movimiento,campo1,campo2,unidades,flujo,peso,estado,lote_ventana,peso_origen)";	
					$Insertar.="VALUES(1,17,$producto[$clave],$hornadas,$recargo,$FFecha,'999999','999999',$unidad_rec,$flujo,$row_r["peso_neto"],$estado,$lote_ventana[$clave],$peso_origen[$clave])";
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
						$Insertar2 = "$Insertar2 VALUES(17,$producto[$clave],$hornadas,$unidad_rec,$rpw_r[peso_neto])";
						mysqli_query($link, $Insertar2);
						
					}
				}		
 
			}
            if ($sumunid <> $unidades[$clave])
			{
					if($sumunid > $unidades[$clave])
					{
						$unidad_rec = $unidad_rec - ($sumunid - $unidades[$clave]);
					}
					else
					{
						$unidad_rec = $unidad_rec + ($unidades[$clave] - $sumunid);
					}
					$actualiza = "UPDATE sea_web.movimientos set unidades = '".$unidad_rec."' WHERE tipo_movimiento = 1 ";
					$actualiza.=" cod_producto = '17' and fecha_movimiento = '".$FFecha."' and hora = '".HHora."'  and ";
					$actualiza.=" hornada = $hornadas and numero_recarga = '".$recargo."' and lote_ventana = '".$lote_ventanas[$clave]."'";
					mysqli_query($link, $actualiza);  
			}

		}

	}			




        $valores = 'mostrar=S'.'&ano='.$ano.'&mes='.$mes.'&dia='.$dia.'&proveedor='.$proveedor; 
        header("Location:sea_ing_recep_inter_res.php?".$valores);
	include("../principal/cerrar_sea_web.php");		
?>