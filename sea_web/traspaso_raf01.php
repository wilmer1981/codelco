<?php
	include("../principal/conectar_sea_web.php");

	$proceso = $_REQUEST["proceso"];
	$dia1 = $_REQUEST["dia1"];
	$mes1 = $_REQUEST["mes1"];
	$ano1 = $_REQUEST["ano1"];
	$cmbtipo = $_REQUEST["cmbtipo"];


	
	//echo $tipo_boton."<br>";
	
    //*******************************************************************************//
	//Valida que no se realicen cambios de movimientos, en la fecha ingresada.
	
	$valida_fecha_movimiento = $ano1."-".$mes1."-".$dia1;
	include("sea_valida_mes.php");
    //*******************************************************************************// 	
    $codigo = substr($cmbtipo,0,2);
	//$FechaHoraActual = date("Y-m-d H:i:s");
	$HoraActual = date("H:i:s");
	$fechaA = date("Y-m-d");
	$FechaHoraActual = $ano1."-".$mes1."-".$dia1." ".$HoraActual;
	$des_unidad = 0;
	if ($proceso == "G" AND $codigo != "16" AND $codigo != "18" AND $codigo != "48" AND $codigo != "66")
	{		
		$fecha = $ano1."-".$mes1."-".$dia1;
		$unidades = 0;	
		reset($hornada);
		//while(list($clave, $valor) = each($hornada))
		foreach ($hornada as $clave =>$valor) 
		{
			//Aqui van todas las unidades traspasadas.
			if (($unid_trasp[$clave] != 0) and ($unid_trasp[$clave] != ""))
			{
				$unidades = $unidades + $unid_trasp[$clave];
				//Busca el flujo Asociado al producto y proceso.		
				$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 4 AND cod_producto = 17";
				$consulta = $consulta." AND cod_subproducto = ".$cmbproducto;
		
				$rs1 = mysqli_query($link, $consulta);
				if ($row1 = mysqli_fetch_array($rs1))
					$flujo = $row1["flujo"];
				else 
					$flujo = 0;			
			
			    
				$insertar = "INSERT INTO sea_web.movimientos (tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,fecha_movimiento,unidades,peso,flujo,hora,sub_tipo_movim)";
				$insertar = $insertar." VALUES (4,17,".$cmbproducto.",".$valor.",0,'".$fecha."',".$unid_trasp[$clave].",".$peso_trasp[$clave].",".$flujo.",'".$FechaHoraActual."',0)";			
				mysqli_query($link, $insertar);
				//echo $insertar."<br>";
					
				//Aqui va la diferencia entre lo traspasado - lo rechazado. (tener en cuenta, cuando la hornada no tiene rechazos: boton_tipo = 2).
				$diferencia = ($unid_trasp[$clave] - $unid_aux[$clave]);
				$peso = $peso_aux[$clave] - $peso_aux[$clave];
			
				if (($diferencia > 0 ) && ($tipo_boton == 1))
				{
					$insertar = "INSERT INTO sea_web.movimientos (tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,fecha_movimiento,unidades,peso,hora,sub_tipo_movim)";
					$insertar = $insertar." VALUES (7,17,".$cmbproducto.",".$valor.",0,'".$fecha."','".$unid_trasp[$clave]."','".$peso_trasp[$clave]."','".$FechaHoraActual."',0)";
					mysqli_query($link, $insertar);
					//echo $insertar."<br>";
				}
			
				if ($tipo_boton == 2)
				{
					$insertar = "INSERT INTO sea_web.movimientos (tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,fecha_movimiento,unidades,peso,hora,sub_tipo_movim)";
					$insertar = $insertar." VALUES (7,17,".$cmbproducto.",".$valor.",0,'".$fecha."',".$unid_trasp[$clave].",".$peso_trasp[$clave].",'".$FechaHoraActual."',0)";
					mysqli_query($link, $insertar);
					//echo $insertar."<br>";			
				}
			}			
		}
		// esto es nuevo para descontra rechazos traspasados a raf
		
		$Consulta="SELECT * from sea_web.inf_rechazos where fecha between '".$fecha."' and '".$fechaA."'";
		$resp=mysqli_query($link, $Consulta);
		//echo $Consulta;
		while ($fila=mysqli_fetch_array($resp))
		{
				$fechap = $fila["fecha"];
				if ($cmbproducto=='1')
					$actualiza = "UPDATE sea_web.inf_rechazos set Fis_FHVL = Fis_FHVL - '".$unidades."' where ";
				if ($cmbproducto=='2')
					$actualiza = "UPDATE sea_web.inf_rechazos set Fis_Teniente = Fis_Teniente - '".$unidades."' where ";
				if ($cmbproducto=='3')
					$actualiza = "UPDATE sea_web.inf_rechazos set Fis_Disputada = Fis_Disputada - '".$unidades."' where ";
				if ($cmbproducto=='4')
					$actualiza = "UPDATE sea_web.inf_rechazos set Fis_Vent = Fis_Vent - '".$unidades."' where ";
				if ($cmbproducto=='8')
					$actualiza = "UPDATE sea_web.inf_rechazos set Fis_HMadres = Fis_HMadres - '".$unidades."' where ";
				$actualiza.=" fecha = '".$fechap."'";
				//echo $actualiza;
				mysqli_query($link, $actualiza);
		}
		$linea = "recargapag1=S&cmbtipo=".$cmbtipo."&cmbproducto=".$cmbproducto."&dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1;
		header("Location:traspaso_raf.php?".$linea);
	}
	
	
	//BLISTER
	if ($proceso == "G" AND $codigo == "16")
	{		
		$fecha = $ano1."-".$mes1."-".$dia1;
		$subproducto = substr($cmbproducto,2,2);
				
		reset($hornada);
		//while(list($clave, $valor) = each($hornada))
		foreach ($hornada as $clave =>$valor) 
		{
			//Aqui van todas las unidades traspasadas.
			if (($unid_trasp[$clave] != 0) and ($unid_trasp[$clave] != ""))
			{
				//Busca el flujo Asociado al producto y proceso.		

				//consulto ap_subproducto
				$consulta = "SELECT ap_subproducto FROM proyecto_modernizacion.subproducto WHERE cod_producto = 16 AND cod_subproducto = ".$subproducto;
				$rs = mysqli_query($link, $consulta);

				if($row = mysqli_fetch_array($rs))
				{
					$producto = $row["ap_subproducto"];
				} 
				
				//consulta flujo
				$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 4 AND cod_producto = 16";
				$consulta = $consulta." AND cod_subproducto = ".$subproducto;
	
				$rs1 = mysqli_query($link, $consulta);
		
				if ($row1 = mysqli_fetch_array($rs1))
				   $flujo = $row1["flujo"];
				else 
				   $flujo = 0;

			
				$insertar = "INSERT INTO sea_web.movimientos (tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,fecha_movimiento,unidades,peso,flujo,hora,sub_tipo_movim)";
				$insertar = $insertar." VALUES (4,16,".$subproducto.",".$valor.",0,'".$fecha."',".$unid_trasp[$clave].",".$peso_trasp[$clave].",".$flujo.",'".$FechaHoraActual."',0)";			
				mysqli_query($link, $insertar);
				//echo $insertar."<br>";
					
				// mf $hornada_aux = substr($valor,3,6);
				
				// mf ***
				if (strlen($valor) == 3)
				{
					$hornada_aux = $valor;
				}
				else
				{
					$hornada_aux = substr($valor,3,6);
				}
				// ***
			}			
		}
		
		$linea = "recargapag1=S&recargapag2=S&cmbtipo=".$cmbtipo."&cmbproducto=".$cmbproducto."&dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1."&dia2=".$dia2."&mes2=".$mes2."&ano2=".$ano2."&txthornada=".$hornada_aux."&boton=2";
		header("Location:traspaso_raf.php?".$linea);
	}



	//CATODOS
	if ($proceso == "G" AND $codigo == "18")
	{		
		$fecha = $ano1."-".$mes1."-".$dia1;
		$subproducto = substr($cmbproducto,2,2);
				
		reset($hornada);
		//while(list($clave, $valor) = each($hornada))
		foreach ($hornada as $clave =>$valor) 
		{
			//Aqui van todas las unidades traspasadas.
			if (($unid_trasp[$clave] != 0) and ($unid_trasp[$clave] != ""))
			{
				//consulta flujo
				$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 4 AND cod_producto = 18";
				$consulta = $consulta." AND cod_subproducto = ".$subproducto;
	
				$rs1 = mysqli_query($link, $consulta);
		
				if ($row1 = mysqli_fetch_array($rs1))
				   $flujo = $row1["flujo"];
				else 
				   $flujo = 0;

			
				$insertar = "INSERT INTO sea_web.movimientos (tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,fecha_movimiento,unidades,peso,flujo,hora,sub_tipo_movim)";
				$insertar = $insertar." VALUES (4,18,".$subproducto.",".$valor.",0,'".$fecha."',".$unid_trasp[$clave].",".$peso_trasp[$clave].",".$flujo.",'".$FechaHoraActual."',0)";			
				mysqli_query($link, $insertar);
				//echo $insertar."<br>";
					
				$hornada_aux = substr($valor,6,6);
			}			
		}
		
		$linea = "recargapag1=S&recargapag2=S&cmbtipo=".$cmbtipo."&cmbproducto=".$cmbproducto."&dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1."&dia2=".$dia2."&mes2=".$mes2."&ano2=".$ano2."&txthornada=".$hornada_aux."&boton=2";
		header("Location:traspaso_raf.php?".$linea);
	}
	
	//LAMINAS
	if ($proceso == "G" AND $codigo == "48")
	{		
		$fecha = $ano1."-".$mes1."-".$dia1;
		$subproducto = substr($cmbproducto,2,2);
				
		reset($hornada);
		//while(list($clave, $valor) = each($hornada))
		foreach ($hornada as $clave =>$valor) 
		{
			//Aqui van todas las unidades traspasadas.
			if (($unid_trasp[$clave] != 0) and ($unid_trasp[$clave] != ""))
			{
				//consulta flujo
				$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 4 AND cod_producto = 48";
				$consulta = $consulta." AND cod_subproducto = ".$subproducto;
	
				$rs1 = mysqli_query($link, $consulta);
		
				if ($row1 = mysqli_fetch_array($rs1))
				   $flujo = $row1["flujo"];
				else 
				   $flujo = 0;

			
				$insertar = "INSERT INTO sea_web.movimientos (tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,fecha_movimiento,unidades,peso,flujo,hora,sub_tipo_movim)";
				$insertar = $insertar." VALUES (4,48,".$subproducto.",".$valor.",0,'".$fecha."',".$unid_trasp[$clave].",".$peso_trasp[$clave].",".$flujo.",'".$FechaHoraActual."',0)";			
				mysqli_query($link, $insertar);
				//echo $insertar."<br>";
					
				$hornada_aux = substr($valor,6,6);
			}			
		}
		
		$linea = "recargapag1=S&recargapag2=S&cmbtipo=".$cmbtipo."&cmbproducto=".$cmbproducto."&dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1."&dia2=".$dia2."&mes2=".$mes2."&ano2=".$ano2."&txthornada=".$hornada_aux."&boton=2";
		header("Location:traspaso_raf.php?".$linea);
	}		
	
	if ($proceso == "G" AND $codigo == "66")
	{		
		$fecha = $ano1."-".$mes1."-".$dia1;
		$subproducto = substr($cmbproducto,2,2);
				
		reset($hornada);
		//while(list($clave, $valor) = each($hornada))
		foreach ($hornada as $clave =>$valor) 
		{
			//Aqui van todas las unidades traspasadas.
			if (($unid_trasp[$clave] != 0) and ($unid_trasp[$clave] != ""))
			{
				//consulta flujo
				$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 4 AND cod_producto = 66";
				$consulta = $consulta." AND cod_subproducto = ".$subproducto;
	
				$rs1 = mysqli_query($link, $consulta);
		
				if ($row1 = mysqli_fetch_array($rs1))
				   $flujo = $row1["flujo"];
				else 
				   $flujo = 0;

			
				$insertar = "INSERT INTO sea_web.movimientos (tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,fecha_movimiento,unidades,peso,flujo,hora,sub_tipo_movim)";
				$insertar = $insertar." VALUES (4,66,".$subproducto.",".$valor.",0,'".$fecha."',".$unid_trasp[$clave].",".$peso_trasp[$clave].",".$flujo.",'".$FechaHoraActual."',0)";			
				mysqli_query($link, $insertar);
				//echo $insertar."<br>";
					
				$hornada_aux = substr($valor,6,6);
			}			
		}
		
		$linea = "recargapag1=S&recargapag2=S&cmbtipo=".$cmbtipo."&cmbproducto=".$cmbproducto."&dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1."&dia2=".$dia2."&mes2=".$mes2."&ano2=".$ano2."&txthornada=".$hornada_aux."&boton=2";
		header("Location:traspaso_raf.php?".$linea);
	}			
	include("../principal/cerrar_sea_web.php");
?>