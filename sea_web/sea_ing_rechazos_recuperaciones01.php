<?php
	include("../principal/conectar_sea_web.php");
	
	if ($proceso == "B")
	{
		$unid_1 = 0;
		$unid_2 = 0;
		$unid_3 = 0;
		$unid_4 = 0;

		//El Total de Unidades de la Hornada.
		$consulta = "SELECT * FROM hornadas WHERE cod_producto = 17 AND cod_subproducto = ".$cmbsubprod." AND hornada_ventana = ".$cmbhornada;
		$rs3 = mysqli_query($link, $consulta);
		if ($row3 = mysqli_fetch_array($rs3))
			$total_produccion = $row3["unidades"];
		
		//Rechazados (Cod_Tipo 1).
		$consulta = "SELECT (recuperables + rechazados) AS total FROM rechazos WHERE cod_tipo = 1 AND cod_defecto = 0";
		$consulta = $consulta." AND hornada = ".$cmbhornada." AND cod_subproducto = ".$cmbsubprod;		
		$rs = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs))
		{
			$unid_1 = $row["total"];
			
			//Recuperados (Cod_Tipo 2).
			$consulta = "SELECT recuperables FROM rechazos WHERE cod_tipo = 2 AND hornada = ".$cmbhornada;
			$consulta = $consulta." AND cod_subproducto = ".$cmbsubprod;
			
			$rs1 = mysqli_query($link, $consulta);
			if ($row1 = mysqli_fetch_array($rs1))
				$unid_1 = $unid_1 - $row1[recuperables];			
		}
		
		$unid_3 = $total_produccion - $unid_1;
		
		//Si la Hornada Existe Recuperar Movimientos 3 y 4.
		$consulta = "SELECT * FROM rechazos WHERE cod_tipo = 3 AND cod_subproducto = ".$cmbsubprod." AND hornada = ".$cmbhornada;				
		$rs4 = mysqli_query($link, $consulta);
		if ($row4 = mysqli_fetch_array($rs4))
			$unid_2 = $row4[recuperables];
		
		$consulta = "SELECT * FROM rechazos WHERE cod_tipo = 4 AND cod_subproducto = ".$cmbsubprod." AND hornada = ".$cmbhornada;		
		$rs5 = mysqli_query($link, $consulta);
		if ($row5 = mysqli_fetch_array($rs5))
			$unid_4 = $row5[recuperables];
		
		
		$valores = "mostrar=S&recargapag1=S&unid_1=".$unid_1."&unid_2=".$unid_2."&unid_3=".$unid_3."&unid_4=".$unid_4."&total=".$total_produccion;
		$valores = $valores."&cmbhornada=".$cmbhornada."&cmbsubprod=".$cmbsubprod;
		$valores = $valores."&ano=".$ano."&mes=".$mes."&dia=".$dia;
		header("Location:sea_ing_rechazos_recuperaciones.php?".$valores);		
	}
	
	if ($proceso == "G")	
	{	
		$fecha = $ano."-".$mes."-".$dia;
		
		//(Cod_Tipo 3).
		$consulta = "SELECT * FROM rechazos WHERE cod_tipo = 3 AND hornada = ".$cmbhornada." AND cod_subproducto = ".$cmbsubprod;
		$rs = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs))
		{
			$actualizar = "UPDATE rechazos SET recuperables = ".$unid_2." WHERE cod_tipo = 3";
			$actualizar = $actualizar." AND hornada = ".$cmbhornada." AND cod_subproducto = ".$cmbsubprod;
			mysqli_query($link, $actualizar);
		}
		else 
		{
			$insertar = "INSERT INTO rechazos VALUES (3,'".$fecha."',0,17,".$cmbsubprod.",".$cmbhornada.",0,'".$CookieRut;
			$insertar = $insertar."',".$unid_2.",0,0)";
			mysqli_query($link, $insertar);						
		}
		
		//(Cod_Tipo 4).
		$consulta = "SELECT * FROM rechazos WHERE cod_tipo = 4 AND hornada = ".$cmbhornada." AND cod_subproducto = ".$cmbsubprod;
		$rs1 = mysqli_query($link, $consulta);
		if ($row1 = mysqli_fetch_array($rs1))
		{
			$actualizar = "UPDATE rechazos SET recuperables = ".$unid_4." WHERE cod_tipo = 4";
			$actualizar = $actualizar." AND hornada = ".$cmbhornada." AND  cod_subproducto = ".$cmbsubprod;
			mysqli_query($link, $actualizar);			
		}
		else 
		{
			$insertar = "INSERT INTO rechazos VALUES (4,'".$fecha."',0,17,".$cmbsubprod.",".$cmbhornada.",0,'".$CookieRut;
			$insertar = $insertar."',".$unid_4.",0,0)";
			mysqli_query($link, $insertar);
		}		
		
		$mensaje = "Movimiento Grabado Correctamente";
		header("Location:sea_ing_rechazos_recuperaciones.php?mensaje=".$mensaje);		
	}
	
	include("../principal/conectar_sea_web.php");
?>