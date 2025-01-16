<?php //Funcion que calcula el Stock Disponible de la Hornada.
	function StockActual($hornada,$producto,$sub_producto, $link) 	
	{		
		$stock_actual = 0;
		//Busca el Stock Inicial de la Hornada ( Recepcion) (+).
		$consulta = "SELECT * FROM sea_web.hornadas WHERE cod_producto = '".$producto."' AND cod_subproducto = '".$sub_producto."' ";
		$consulta = $consulta." AND hornada_ventana = '".$hornada."' ";	
		//echo ".......0...".$consulta."<br>";
		$rs = mysqli_query($link, $consulta);
		
		if ($row = mysqli_fetch_array($rs))
		{
		
			$stock_actual = $row["unidades"];
			
			//Busca los Beneficios (-). (tipo 2)
			$consulta = "SELECT IFNULL(SUM(unidades),0) AS unid_mov FROM sea_web.movimientos WHERE tipo_movimiento = 2 AND cod_producto = '".$producto."' AND cod_subproducto = '".$sub_producto."' ";
			$consulta = $consulta." AND hornada = '".$hornada."' ";
			$rs1 = mysqli_query($link, $consulta);
			$row1 = mysqli_fetch_array($rs1);
			$stock_actual = $stock_actual - $row1["unid_mov"];
				
			//Busca los Traspasos (-). (tipo 4)
			$consulta = "SELECT IFNULL(SUM(unidades),0) AS unid_mov FROM sea_web.movimientos WHERE tipo_movimiento = 4 AND cod_producto = '".$producto."' AND cod_subproducto = '".$sub_producto."' ";
			$consulta = $consulta." AND hornada = '".$hornada."' ";
			$rs2 = mysqli_query($link, $consulta);
			$row2 = mysqli_fetch_array($rs2);
			$stock_actual = $stock_actual - $row2["unid_mov"];
/*			
			//Busca los Rechazados por el Inspector(-). (tipo 6)
			$consulta = "SELECT IFNULL(SUM(unidades),0) AS unid_mov FROM sea_web.movimientos WHERE tipo_movimiento = 6 AND cod_producto = ".$producto." AND cod_subproducto = ".$sub_producto;			$consulta = $consulta." AND hornada = ".$hornada;
			$rs2 = mysqli_query($link, $consulta);
			$row2 = mysqli_fetch_array($rs2);
			$stock_actual = $stock_actual - $row2["unid_mov"];
			//Busca los Aprobados a RAF (-). (tipo 7)
			$consulta = "SELECT IFNULL(SUM(unidades),0) AS unid_mov FROM sea_web.movimientos WHERE tipo_movimiento = 7 AND cod_producto = ".$producto." AND cod_subproducto = ".$sub_producto;
			$consulta = $consulta." AND hornada = ".$hornada;
			$rs3 = mysqli_query($link, $consulta);
			$row3 = mysqli_fetch_array($rs3);
			$stock_actual = $stock_actual - $row3["unid_mov"];
			//Busca los Rechazados a N.E (+). (tipo 8)				
			$consulta = "SELECT IFNULL(SUM(unidades),0) AS unid_mov FROM sea_web.movimientos WHERE tipo_movimiento = 8 AND cod_producto = ".$producto." AND cod_subproducto = ".$sub_producto;
			$consulta = $consulta." AND hornada = ".$hornada;
			$rs4 = mysqli_query($link, $consulta);
			$row4 = mysqli_fetch_array($rs4);
			$stock_actual = $stock_actual + $row4["unid_mov"];						
*/

/*    aqui despues consulta  

			//Busca los Rechazados Fisicos. (tipo mov  1 y  sub tipo =  2 .3 .4)
   			$consulta = "SELECT IFNULL(SUM(unidades),0) AS unid_rec FROM sea_web.movimientos WHERE tipo_movimiento = 1 ";
			$consulta.=" and cod_producto = '".$producto."' and cod_subproducto = '".$sub_producto."' and hornada = '".$hornada."'";
			$consulta.=" and (sub_tipo_movim = '2' || sub_tipo_movim = '3' || sub_tipo_movim = '4')";
			$rsr = mysqli_query($link, $consulta);
			//echo "hhh".$consulta;
			$rowr = mysqli_fetch_array($rsr);
			$stock_actual = $stock_actual - $rowr[unid_rec]; 

	hasta aqui   */	
		
			//Busca los Envios de Anodos Buenos(-). (tipo 9)
			$consulta = "SELECT IFNULL(SUM(unidades),0) AS unid_mov FROM sea_web.movimientos WHERE tipo_movimiento = 9 AND cod_producto = '".$producto."' AND cod_subproducto = '".$sub_producto."' ";
			$consulta = $consulta." AND hornada = '".$hornada."' ";
			//echo ".......4.....".$consulta."<br>";			
			$rs5 = mysqli_query($link, $consulta);
			$row5 = mysqli_fetch_array($rs5);
			$stock_actual = $stock_actual - $row5["unid_mov"];																
		}
		return $stock_actual;
	}	
	
	
	//Funcion que calcula los Anodos Rechazados de la Hornada.
	function StockRechazo($hornada,$producto,$sub_producto,$link)
	{
		$stock_actual = 0;
		//Busca los Rechazos del Inspector (+). (tipo 6)
		$consulta = "SELECT * FROM sea_web.movimientos WHERE tipo_movimiento = 6 AND cod_producto = ".$producto." AND cod_subproducto = ".$sub_producto;
		$consulta = $consulta." AND hornada = ".$hornada;

		$rs = mysqli_query($link, $consulta);

		if ($row = mysqli_fetch_array($rs))		
		{
			$stock_actual = $row["unidades"];
			
			//Busca los Aprobados a RAF (+). (tipo 7)
			$consulta = "SELECT IFNULL(SUM(unidades),0) AS unid_mov FROM sea_web.movimientos WHERE tipo_movimiento = 7 AND cod_producto = ".$producto." AND cod_subproducto = ".$sub_producto;
			$consulta = $consulta." AND hornada = ".$hornada;
			$rs1 = mysqli_query($link, $consulta);
			$row1 = mysqli_fetch_array($rs1);
			$stock_actual = $stock_actual + $row1["unid_mov"];
			
			//Busca los Rechazados a N.E (-). (tipo 8)				
			$consulta = "SELECT IFNULL(SUM(unidades),0) AS unid_mov FROM sea_web.movimientos WHERE tipo_movimiento = 8 AND cod_producto = ".$producto." AND cod_subproducto = ".$sub_producto;
			$consulta = $consulta." AND hornada = ".$hornada;
			$rs2 = mysqli_query($link, $consulta);
			$row2 = mysqli_fetch_array($rs2);
			$stock_actual = $stock_actual - $row2["unid_mov"];
			
			//Busca los Traspasos (-). (tipo 4)
			$consulta = "SELECT IFNULL(SUM(unidades),0) AS unid_mov FROM sea_web.movimientos WHERE tipo_movimiento = 4 AND cod_producto = ".$producto." AND cod_subproducto = ".$sub_producto;
			$consulta = $consulta." AND hornada = ".$hornada;
			$rs3 = mysqli_query($link, $consulta);
			$row3 = mysqli_fetch_array($rs3);
			$stock_actual = $stock_actual - $row3["unid_mov"];
			
			//Busca los Envios de Rechazos(-). (tipo 5)
			$consulta = "SELECT IFNULL(SUM(unidades),0) AS unid_mov FROM sea_web.movimientos WHERE tipo_movimiento = 5 AND cod_producto = ".$producto." AND cod_subproducto = ".$sub_producto;
			$consulta = $consulta." AND hornada = ".$hornada;
			$rs5 = mysqli_query($link, $consulta);
			$row5 = mysqli_fetch_array($rs5);
			$stock_actual = $stock_actual - $row5["unid_mov"];						
			
		}
		return $stock_actual;
	}	
	//******************************************
	//Funcion que calcula los Anodos Rechazados de la Hornada.
	//Calcula el Stock de Resto de H.M.
	function StockRestoHM($hornada,$producto,$sub_producto,$link)
	{
		$stock_actual = 0;
		
		$consulta = "SELECT * FROM sea_web.hornadas WHERE cod_producto = ".$producto." AND cod_subproducto = ".$sub_producto;
		$consulta = $consulta." AND hornada_ventana = ".$hornada;
		$rs = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs))
		{
			$stock_actual = $row["unidades"];
			$consulta = "SELECT IFNULL(SUM(unidades),0) AS unid_mov FROM sea_web.movimientos WHERE tipo_movimiento IN(2,4) AND cod_producto = ".$producto;
			$consulta = $consulta." AND cod_subproducto = ".$sub_producto." AND hornada = ".$hornada;
			$rs1 = mysqli_query($link, $consulta);
			$row1 = mysqli_fetch_array($rs1);
			$stock_actual = $stock_actual - $row1["unid_mov"];
		}
		return $stock_actual;
	}
	
	//Calcula el Stock de Resto de Corriente.
	function StockRestoCTTE($hornada,$producto,$sub_producto, $link)
	{
		$stock_actual = 0;
		$consulta = "SELECT SUM(unidades) AS unid_mov FROM sea_web.movimientos WHERE tipo_movimiento = 3 AND cod_producto = '".$producto."' ";
		$consulta = $consulta." AND cod_subproducto = '".$sub_producto."' AND hornada = '".$hornada."' ";
		$rs = mysqli_query($link, $consulta);
		$row = mysqli_fetch_array($rs);
		if (!is_null($row["unid_mov"]))
			$stock_actual = $row["unid_mov"];
		
		return $stock_actual;
	}
	
	
	//Funcion que cambia el estado a la Hornada para no volver a pescarla.
	function CambiaEstadoHornada($hornada,$producto,$sub_producto, $link)
	{
		$actualiza = "UPDATE sea_web.hornadas SET estado = 1 WHERE cod_producto = '".$producto."' AND cod_subproducto = '".$sub_producto."' AND hornada_ventana = '".$hornada."' ";
		mysqli_query($link, $actualiza);		
	}
	
	function PesoFaltante($cod_producto, $cod_subproducto, $hornada, $link)
	{
		$consulta = "SELECT peso_unidades FROM sea_web.hornadas";
		$consulta = $consulta." WHERE cod_producto = '".$cod_producto."' AND cod_subproducto = '".$cod_subproducto."' ";
		$consulta = $consulta." AND hornada_ventana = '".$hornada."' ";
		$rs = mysqli_query($link, $consulta);
		$row = mysqli_fetch_array($rs);
		
		if(isset($row["peso_unidades"])){
			$StockPeso = $row["peso_unidades"];
		}else{
			$StockPeso = 0;	
		}	
	
		$consulta = "SELECT IFNULL(SUM(peso),0) AS peso FROM sea_web.movimientos";
		$consulta = $consulta." WHERE tipo_movimiento IN (2,4,9) and cod_producto = '".$cod_producto."' ";
		$consulta = $consulta." AND cod_subproducto = '".$cod_subproducto."' AND hornada = '".$hornada."' ";
		$rs1 = mysqli_query($link, $consulta);
		$row1 = mysqli_fetch_array($rs1);
		
		$StockPeso = $StockPeso - $row1["peso"];
		
		return $StockPeso;
	}
	
	function StockPesoActual($hornada,$producto,$sub_producto,$link) 
	{
		$stock_actual = 0;
		//Busca el Stock Inicial de la Hornada ( Recepcion � Produccion) (+).
		$consulta = "SELECT * FROM sea_web.hornadas WHERE cod_producto = ".$producto." AND cod_subproducto = ".$sub_producto;
		$consulta = $consulta." AND hornada_ventana = ".$hornada;		
		$rs = mysqli_query($link, $consulta);
		
		if ($row = mysqli_fetch_array($rs))
		{
			$stock_actual = $row["peso_unidades"];
			
			//Busca los Beneficios (-). (tipo 2)
			$consulta = "SELECT IFNULL(SUM(peso),0) AS peso_mov FROM sea_web.movimientos WHERE tipo_movimiento = 2 AND cod_producto = ".$producto." AND cod_subproducto = ".$sub_producto;
			$consulta = $consulta." AND hornada = ".$hornada;			
			$rs1 = mysqli_query($link, $consulta);
			$row1 = mysqli_fetch_array($rs1);
			$stock_actual = $stock_actual - $row1["peso_mov"];
				
			//Busca los Traspasos (-). (tipo 4)
			$consulta = "SELECT IFNULL(SUM(peso),0) AS peso_mov FROM sea_web.movimientos WHERE tipo_movimiento = 4 AND cod_producto = ".$producto." AND cod_subproducto = ".$sub_producto;
			$consulta = $consulta." AND hornada = ".$hornada;
			$rs2 = mysqli_query($link, $consulta);
			$row2 = mysqli_fetch_array($rs2);
			$stock_actual = $stock_actual - $row2["peso_mov"];

				
			//Busca los Envios de Anodos Buenos(-). (tipo 9)
			$consulta = "SELECT IFNULL(SUM(peso),0) AS peso_mov FROM sea_web.movimientos WHERE tipo_movimiento = 9 AND cod_producto = ".$producto." AND cod_subproducto = ".$sub_producto;
			$consulta = $consulta." AND hornada = ".$hornada;			
			$rs5 = mysqli_query($link, $consulta);
			$row5 = mysqli_fetch_array($rs5);
			$stock_actual = $stock_actual - $row5["peso_mov"];																
		}
		return $stock_actual;	
	}
?>