<?php //Funcion elimina movimientos teniente via ferrocarril.
	function eliminatte($producto,$sub_producto,$fecha1,$fecha2) 	
	{		
		
		//Busca recepcion desde Recepcion_externa
		$contr=0; 
		$consulta = "SELECT * FROM sea_web.recepcion_externa WHERE cod_producto = ".$producto." AND cod_subproducto = ".$sub_producto;
		$consulta. =" and fecha between '".$fecha1."' and '".$fecha2."'";
		$rs = mysqli_query($link, $consulta);
		while ($fila = mysqli_fetch_array($rs))
		{
			$consulta1 ="Select * from sea_web.relaciones where cod_producto = '".$producto."' and ";
			$consulta1.=" lote_ventana = '".$fila[lote_ventana]."'";
			$rs1 = mysqli_query($link, $consulta1);
			if ($fila1 =mysqli_fetch_array($rs1))
			{
				$consulta2="Select * from sea_web.hornadas where cod_producto = '".$producto."' and cod_subproducto = '".$sub_producto."'";
				$consulta2.=" and hornada_ventana = '".$fila1[hornada_ventana]."' ";
				$rs2 = mysqli_query($link, $consulta2);
				if ($fila2 = mysqli_fetch_array($rs2))
				{
					$consulta3 ="Select * from sea_web.movimientos where cod_producto= '".$producto."' and cod_subproducto = '".$sub_producto."'";
					$consulta3. =" and hornada = '".$fila2[hornada_ventana]."'";
					$rs3 = mysqli_query($link, $consulta3);
					if ($fila3 = mysqli_fetch_array($rs3))
					{
						$e_movim ="delete from sea_web.movimientos where cod_producto= '".$fila3["cod_producto"]."'";
						$e_movim. =" and cod_subproducto = '".$fila3["cod_subproducto"]."' and hornada = '".$fila3["hornada"]."'";
						$resp =mysqli_query($link, $e_movim);
					}
					$e_hornada ="delete from sea_web.hornadas where cod_producto = '".$fila2["cod_producto"]."' and cod_subproducto = '".$fila2["cod_subproducto"]."'";
					$e_hornada.=" and hornada_ventana = '".$fila2[hornada_ventana]."' ";
					$rsp1 = mysqli_query($link, $e_hornada);
				}
				$e_relacion ="delete from sea_web.relaciones where cod_producto = '".$fila1["cod_producto"]."' and ";
				$e_relacion.=" lote_ventana = '".$fila1[lote_ventana]."'";
				$rsp2 = mysqli_query($link, $e_relacion);
			 }
			 $consulta4="Select * from sipa_web.recepciones where cod_subproducto = '".$fila["cod_producto"]."'";
			 $consulta4.=" and guia_despacho = '".$fila["guia"]."' and lote = '".$fila[lote_ventana]."'";
			 $rs4 = mysqli_query($link, $consulta4);
			 if ($fila5= mysqli_fetch_array($rs4))
			 {
			 	$e_recepcion ="delete from sipa_web.recepciones where cod_subproducto = '".$fila5["cod_producto"]."'";
			 	$e_recepcion.=" and guia_despacho = '".$fila5["guia_despacho"]."' and lote = '".$fila5[lote]."'";
			 	$resp4 = mysqli_query($link, $e_recepcion);
			}
			$e_externa = "delete FROM sea_web.recepcion_externa WHERE cod_producto = ".$fila["cod_producto"]." AND cod_subproducto = ".$fila["cod_subproducto"];
			$e_externa. =" and lote_ventana = '".$fila[lote_ventana]."' and  guia'".$fila["guia"]."'";
			$resp6 = mysqli_query($link, $e_externa);

		}
		return $eliminatte;
	}	
