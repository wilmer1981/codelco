<?php
	include("../principal/conectar_sea_web.php");

	$proceso = isset($_REQUEST["proceso"])?$_REQUEST["proceso"]:"";

	$parametros = isset($_REQUEST["parametros"])?$_REQUEST["parametros"]:"";
	$recup1 = isset($_REQUEST["recup1"])?$_REQUEST["recup1"]:"";
	$recup2 = isset($_REQUEST["recup2"])?$_REQUEST["recup2"]:"";
	$recup3 = isset($_REQUEST["recup3"])?$_REQUEST["recup3"]:"";
	$recup4 = isset($_REQUEST["recup4"])?$_REQUEST["recup4"]:"";

	$recha1 = isset($_REQUEST["recha1"])?$_REQUEST["recha1"]:"";
	$recha2 = isset($_REQUEST["recha2"])?$_REQUEST["recha2"]:"";
	$recha3 = isset($_REQUEST["recha3"])?$_REQUEST["recha3"]:"";
	$recha4 = isset($_REQUEST["recha4"])?$_REQUEST["recha4"]:"";

	$prod1 = isset($_REQUEST["prod1"])?$_REQUEST["prod1"]:"";
	$prod2 = isset($_REQUEST["prod2"])?$_REQUEST["prod2"]:"";
	$prod3 = isset($_REQUEST["prod3"])?$_REQUEST["prod3"]:"";
	$prod4 = isset($_REQUEST["prod4"])?$_REQUEST["prod4"]:"";

	$cmbhornada = isset($_REQUEST["cmbhornada"])?$_REQUEST["cmbhornada"]:"";
	//$cmbhornada = substr($cmbhornada, 1);
	//echo "HORNADAI:".$cmbhornada;
	//$cmbhornada = substr($cmbhornada, 0, -2);
	//echo "HORNADAF:".$cmbhornada;

	$txthornada = isset($_REQUEST["txthornada"])?$_REQUEST["txthornada"]:"";

	$dia1 = isset($_REQUEST["dia1"])?$_REQUEST["dia1"]:"";
	$mes1 = isset($_REQUEST["mes1"])?$_REQUEST["mes1"]:"";
	$ano1 = isset($_REQUEST["ano1"])?$_REQUEST["ano1"]:"";

	$dia2 = isset($_REQUEST["dia2"])?$_REQUEST["dia2"]:"";
	$mes2 = isset($_REQUEST["mes2"])?$_REQUEST["mes2"]:"";
	$ano2 = isset($_REQUEST["ano2"])?$_REQUEST["ano2"]:"";

	$hr1 = isset($_REQUEST["hr1"])?$_REQUEST["hr1"]:"";
	$mm1 = isset($_REQUEST["mm1"])?$_REQUEST["mm1"]:"";
	$hr2 = isset($_REQUEST["hr2"])?$_REQUEST["hr2"]:"";
	$mm2 = isset($_REQUEST["mm2"])?$_REQUEST["mm2"]:"";

	if ($proceso == "G")
	{
		$fecha_ini = $ano1.'-'.$mes1.'-'.$dia1.' '.$hr1.'-'.$mm1;
		$fecha_ter = $ano2.'-'.$mes2.'-'.$dia2.' '.$hr2.'-'.$mm2;
		
		if ($prod1 == "")
			$prod1 = 0;
		if ($prod2 == "")
			$prod2 = 0;
		if ($prod3 == "")
			$prod3 = 0;
			
		if ($recup1 == "")
			$recup1 = 0;
		if ($recha1 == "")
			$recha1 = 0;

		if ($recup2 == "")
			$recup2 = 0;
		if ($recha2 == "")
			$recha2 = 0;		

		if ($recup3 == "")
			$recup3 = 0;
		if ($recha3 == "")
			$recha3 = 0;
		
		$consulta = "SELECT * FROM rechazos WHERE cod_tipo = 6 AND hornada = '".$cmbhornada."' ";
		$rs = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs))
		{
			//Actualizar.
			
			//PRODUCCION.
			//Graba las Producciones en la tabla Produccion.			
			$actualizar = "UPDATE produccion SET rueda1 = ".$prod1.", rueda2 = ".$prod2.", hm = ".$prod3." WHERE hornada = '".$cmbhornada."' "; 
			mysqli_query($link, $actualizar);
			
			//Corrientes.
			//Rueda 1. (Actualiza en Rechazos)
			$actualizar = "UPDATE rechazos SET recuperables = ".$recup1.", rechazados = ".$recha1;
			$actualizar = $actualizar." WHERE cod_tipo = 6 AND cod_defecto = 0 AND cod_subproducto = 4";
			$actualizar = $actualizar." AND rueda = 1 AND hornada = '".$cmbhornada."' ";
			mysqli_query($link, $actualizar);
			
			//Rueda 2.
			$actualizar = "UPDATE rechazos SET recuperables = ".$recup2.", rechazados = ".$recha2;
			$actualizar = $actualizar." WHERE cod_tipo = 6 AND cod_defecto = 0 AND cod_subproducto = 4";
			$actualizar = $actualizar." AND rueda = 2 AND hornada = '".$cmbhornada."' ";
			mysqli_query($link, $actualizar);			
				
			//hm
			$actualizar = "UPDATE rechazos SET recuperables = ".$recup3.", rechazados = ".$recha3;
			$actualizar = $actualizar." WHERE cod_tipo = 6 AND cod_defecto = 0 AND cod_subproducto = 8";
			$actualizar = $actualizar." AND hornada = '".$cmbhornada."' ";
			mysqli_query($link, $actualizar);
		
		/***/
			
			//consulta peso para las unidades.
			$consulta = "SELECT (".($recha1 + $recha2)." * (peso_unidades / unidades)) AS peso FROM hornadas WHERE cod_producto = 17 AND cod_subproducto = 4 AND hornada_ventana = '".$cmbhornada."' ";
			$rs2 = mysqli_query($link, $consulta);
			$row2 = mysqli_fetch_array($rs2);			
			
			//Actualiza los Corrientes en Movimientos.
			$actualizar = "UPDATE movimientos SET unidades = ".($recha1 + $recha2).", peso = ".$row2["peso"];
			$actualizar = $actualizar." WHERE tipo_movimiento = 6 AND cod_producto = 17 AND cod_subproducto = 4 AND hornada = '".$cmbhornada."' ";
			mysqli_query($link, $actualizar);
			
			//consulta peso para las unidades.
			$consulta = "SELECT (".$recha3." * (peso_unidades / unidades)) AS peso FROM hornadas WHERE cod_producto = 17 AND cod_subproducto = 8 AND hornada_ventana = '".$cmbhornada."' ";
			$rs3 = mysqli_query($link, $consulta);
			$row3 = mysqli_fetch_array($rs3);
			
			//Actualiza las H.M en Movimientis.
			$actualizar = "UPDATE movimientos SET unidades = ".$recha3.", peso = ".$row3["peso"];
			$actualizar = $actualizar." WHERE tipo_movimiento = 6 AND cod_producto = 17 AND cod_subproducto = 8 AND hornada = '".$cmbhornada."' ";
			mysqli_query($link, $actualizar);			
			
			//Borrar los detalles para ser ingresados de nuevo.
			$eliminar = "DELETE FROM rechazos WHERE cod_tipo = 6 AND cod_defecto <> 0 AND hornada = '".$cmbhornada."' ";
			mysqli_query($link, $eliminar);

			//Ingresa los detalles de los rechazos y recuperables. 
			$arreglo = explode("/",$parametros); //Separa los parametros en un array.
			reset($arreglo);					
			//while (list($clave, $valor) = each($arreglo))
			foreach ($arreglo as $clave=>$valor)
			{		
				$detalle = explode("-",$valor); //check - observacion - recu1 - recu2 - recu3 - recu4 - recha1 - recha2 - recha3 - recha4. 
				
				$insertar = "INSERT INTO rechazos VALUES (6,'".$fecha_ini."','".$fecha_ter."',17,4,'".$cmbhornada."' ".",".$detalle[1].",'";
				$insertar = $insertar.$CookieRut."',".$detalle[2].",".$detalle[6].",1)";
				mysqli_query($link, $insertar);
				
				$insertar = "INSERT INTO rechazos VALUES (6,'".$fecha_ini."','".$fecha_ter."',17,4,'".$cmbhornada."' ".",".$detalle[1].",'";
				$insertar = $insertar.$CookieRut."',".$detalle[3].",".$detalle[7].",2)";			
				mysqli_query($link, $insertar);
				
				$insertar = "INSERT INTO rechazos VALUES (6,'".$fecha_ini."','".$fecha_ter."',17,8,'".$cmbhornada."' ".",".$detalle[1].",'";
				$insertar = $insertar.$CookieRut."',".$detalle[4].",".$detalle[8].",0)";
				mysqli_query($link, $insertar);												
			}			
			
			$mensaje = "Rechazos Actualizados Correctamente";						
		}
		else
		{
			//PRODUCCION.
			//Graba las Producciones en la tabla Produccion.			
			$insertar = "INSERT INTO produccion VALUES ('".$fecha_ini."','".$cmbhornada."' ".",".$prod1.",".$prod2.",".$prod3.")";
			mysqli_query($link, $insertar);
									
			//RECUPERABLES Y RECHAZOS.
			//Ingresa los totales de rechazos y recuperables.
			
			//Corrientes.
			//Rueda 1.
			$insertar = "INSERT INTO rechazos VALUES (6,'".$fecha_ini."','".$fecha_ter."',17,4,'".$cmbhornada."' ".",0,'";
			$insertar = $insertar.$CookieRut."',".$recup1.",".$recha1.",1)";
			mysqli_query($link, $insertar);
			
			//Rueda 2.
			$insertar = "INSERT INTO rechazos VALUES (6,'".$fecha_ini."','".$fecha_ter."',17,4,'".$cmbhornada."' ".",0,'";
			$insertar = $insertar.$CookieRut."',".$recup2.",".$recha2.",2)";
			mysqli_query($link, $insertar);		
			
			//Hojas Madres.
			$insertar = "INSERT INTO rechazos VALUES (6,'".$fecha_ini."','".$fecha_ter."',17,8,'".$cmbhornada."' ".",0,'";
			$insertar = $insertar.$CookieRut."',".$recup3.",".$recha3.",0)";
			mysqli_query($link, $insertar);		
	
		/**/	
			//Busca el flujo Asociado al producto y proceso.		
			$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 6 AND cod_producto = 17";
			$consulta = $consulta." AND cod_subproducto = 4";

			$rs1 = mysqli_query($link, $consulta);
			if ($row1 = mysqli_fetch_array($rs1))
				$flujo = $row1["flujo"];
			else 
				$flujo = 0;	
		/***/
		
			//consulta peso para las unidades.
			$consulta = "SELECT (".($recha1 + $recha2)." * (peso_unidades / unidades)) AS peso FROM hornadas WHERE cod_producto = 17 AND cod_subproducto = 4 AND hornada_ventana = '".$cmbhornada."' ";
			$rs5 = mysqli_query($link, $consulta);
			$row5 = mysqli_fetch_array($rs5);		
			
			//Ingresa los Corrientes en Movimientos.
			$insertar = "INSERT INTO movimientos (tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,fecha_movimiento,campo1,campo2,unidades,flujo,peso)";
			$insertar = $insertar." VALUES (6,17,4,'".$cmbhornada."' ".",0,'".$fecha_ini."',0,0,".($recha1 + $recha2).",".$flujo.",".$row5["peso"].")";
			mysqli_query($link, $insertar);

		/**/			
			//Busca el flujo Asociado al producto y proceso.		
			$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 6 AND cod_producto = 17";
			$consulta = $consulta." AND cod_subproducto = 8";
	
			$rs2 = mysqli_query($link, $consulta);
			if ($row2 = mysqli_fetch_array($rs2))
				$flujo = $row2["flujo"];
			else 
				$flujo = 0;			
			
			//consulta peso para las unidades.
			$consulta = "SELECT (".$recha3." * (peso_unidades / unidades)) AS peso FROM hornadas WHERE cod_producto = 17 AND cod_subproducto = 8 AND hornada_ventana = '".$cmbhornada."' ";
			$rs6 = mysqli_query($link, $consulta);
			$row6 = mysqli_fetch_array($rs6);
			
			//Ingresa las H.M en Movimientis.
			$insertar = "INSERT INTO movimientos (tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,fecha_movimiento,campo1,campo2,unidades,flujo,peso)";
			$insertar = $insertar." VALUES (6,17,8,'".$cmbhornada."' ".",0,'".$fecha_ini."',0,0,".$recha3.",".$flujo.",".$row6["peso"].")";
			mysqli_query($link, $insertar);			
	
			//Ingresa los detalles de los rechazos y recuperables.
			$arreglo = explode("/",$parametros); //Separa los parametros en un array.
			reset($arreglo);					
			//while (list($clave, $valor) = each($arreglo))
			foreach ($arreglo as $clave=>$valor)
			{		
				$detalle = explode("-",$valor); //check - observacion - recu1 - recu2 - recu3 - recu4 - recha1 - recha2 - recha3 - recha4. 
				
				$insertar = "INSERT INTO rechazos VALUES (6,'".$fecha_ini."','".$fecha_ter."',17,4,'".$cmbhornada."' ".",".$detalle[1].",'";
				$insertar = $insertar.$CookieRut."',".$detalle[2].",".$detalle[6].",1)";
				mysqli_query($link, $insertar);
				
				$insertar = "INSERT INTO rechazos VALUES (6,'".$fecha_ini."','".$fecha_ter."',17,4,'".$cmbhornada."' ".",".$detalle[1].",'";
				$insertar = $insertar.$CookieRut."',".$detalle[3].",".$detalle[7].",2)";			
				mysqli_query($link, $insertar);
				
				$insertar = "INSERT INTO rechazos VALUES (6,'".$fecha_ini."','".$fecha_ter."',17,8,'".$cmbhornada."' ".",".$detalle[1].",'";
				$insertar = $insertar.$CookieRut."',".$detalle[4].",".$detalle[8].",0)";
				mysqli_query($link, $insertar);												
			}
			$mensaje = "Rechazos Grabados Correctamente";
		}		
		
		header("Location:sea_ing_rechazos_anodos_ven.php?mensaje=".$mensaje);				
	}
	
	if ($proceso == "B")
	{

		$valores = "buscar=S&txtbuscar=".$txthornada."&cmbhornada=".$cmbhornada;
		if ($cmbhornada == -1)
			$valores = $valores."&mostrar=N";
		else
			$valores = $valores."&mostrar=S";

		//Corrientes. (Rueda 1)
		$consulta = "SELECT * FROM rechazos WHERE cod_tipo = 6 AND cod_defecto = 0 AND cod_subproducto = 4 AND hornada = ".$cmbhornada." AND rueda = 1"; 
		//echo $consulta;
		$rs1 = mysqli_query($link, $consulta);
		if ($row1 = mysqli_fetch_array($rs1))
		{
			$valores = $valores."&recup1=".$row1["recuperables"]."&recha1=".$row1["rechazados"];
	
			//Corrientes. (Rueda 2)
			$consulta = "SELECT * FROM rechazos WHERE cod_tipo = 6 AND cod_defecto = 0 AND cod_subproducto = 4 AND hornada = ".$cmbhornada." AND rueda = 2"; 
			$rs2 = mysqli_query($link, $consulta);
			$row2 = mysqli_fetch_array($rs2);
			$valores = $valores."&recup2=".$row2["recuperables"]."&recha2=".$row2["rechazados"];
						
			//Hojas Madres.
			$consulta = "SELECT * FROM rechazos WHERE cod_tipo = 6 AND cod_defecto = 0 AND cod_subproducto = 8 AND hornada = ".$cmbhornada; 
			$rs3 = mysqli_query($link, $consulta);
			$row3 = mysqli_fetch_array($rs3);
			$valores = $valores."&recup3=".$row3["recuperables"]."&recha3=".$row3["rechazados"];				
			
			$valores = $valores."&recup4=".($row1["recuperables"] + $row2["recuperables"] + $row3["recuperables"]);
			$valores = $valores."&recha4=".($row1["rechazados"] + $row2["rechazados"] + $row3["rechazados"]);
			
			//Recupera la produccion.
			$consulta = "SELECT * FROM produccion WHERE hornada = '".$cmbhornada."' ";
			$rs7 = mysqli_query($link, $consulta);
			$row7 = mysqli_fetch_array($rs7);
			$valores = $valores."&prod1=".$row7["rueda1"]."&prod2=".$row7["rueda2"]."&prod3=".$row7["hm"]."&prod4=".($row7["rueda1"] + $row7["rueda2"] + $row7["hm"]);
			
			//Recupera los detalles.
			$parametros = "";
			$cont = 0;
			$consulta = "SELECT * FROM rechazos WHERE cod_tipo = 6 AND cod_defecto <> 0 AND hornada = ".$cmbhornada." AND cod_subproducto = 4 AND rueda = 1";
			$rs4 = mysqli_query($link, $consulta);
			while ($row4 = mysqli_fetch_array($rs4))
			{
				$consulta = "SELECT * FROM rechazos WHERE cod_tipo = 6 AND cod_defecto = ".$row4["cod_defecto"]." AND hornada = '".$cmbhornada."' AND cod_subproducto = 4 AND rueda = 2";
				$rs5 = mysqli_query($link, $consulta);
				$row5 = mysqli_fetch_array($rs5);
				
				$consulta = "SELECT * FROM rechazos WHERE cod_tipo = 6 AND cod_defecto = ".$row4["cod_defecto"]." AND hornada = '".$cmbhornada."' AND cod_subproducto = 8";
				$rs6 = mysqli_query($link, $consulta);
				$row6 = mysqli_fetch_array($rs6);
				
				$parametros = $parametros."0-".$row4["cod_defecto"]."-".$row4["recuperables"]."-".$row5["recuperables"]."-".$row6["recuperables"]."-".($row4["recuperables"] + $row5["recuperables"] + $row6["recuperables"])."-";
				$parametros = $parametros.$row4["rechazados"]."-".$row5["rechazados"]."-".$row6["rechazados"]."-".($row4["rechazados"] + $row5["rechazados"] + $row6["rechazados"])."/";
				$cont++;
			}
		
			$valores = $valores."&mostrar=S&recargapag=S&verificatabla=S&agregafila=N&mostrar=S&numero=".$cont;
			
			$arreglo1 = explode("-",substr($row1["fecha_ini"],0,10)); //0: a�o, 1: mes, 2: dia.
			$arreglo2 = explode(":",substr($row1["fecha_ini"],11,5)); //0: Hr, 1: mm.
			$arreglo3 = explode("-",substr($row1["fecha_ter"],0,10));
			$arreglo4 = explode(":",substr($row1["fecha_ter"],11,5));
			
			$valores = $valores."&ano1=".$arreglo1[0]."&mes1=".$arreglo1[1]."&dia1=".$arreglo1[2]."&hr1=".$arreglo2[0]."&mm1=".$arreglo2[1];
			$valores = $valores."&ano2=".$arreglo3[0]."&mes2=".$arreglo3[1]."&dia2=".$arreglo3[2]."&hr2=".$arreglo4[0]."&mm2=".$arreglo4[1];
			$valores = $valores."&parametros=".$parametros;
		}
		
		header("Location:sea_ing_rechazos_anodos_ven.php?".$valores);
	}
	
	if ($proceso == "E")
	{
		$consulta = "SELECT * FROM rechazos WHERE cod_tipo = 6 AND hornada = '".$cmbhornada."' ";
		$rs = mysqli_query($link, $consulta);
		
		if ($row = mysqli_fetch_array($rs))
		{
			//Elimina en Movimientos.
			$eliminar = "DELETE FROM movimientos WHERE tipo_movimiento = 6 AND cod_producto = 17 AND hornada = '".$cmbhornada."' ";
			mysqli_query($link, $eliminar);
		
			//Elimina en Rechazos.		
			$eliminar = "DELETE FROM rechazos WHERE cod_tipo = 6 AND hornada = '".$cmbhornada."' ";
			mysqli_query($link, $eliminar);
			
			//Elimina en Produccion.
			$eliminar = "DELETE FROM produccion WHERE hornada = '".$cmbhornada."' ";
			mysqli_query($link, $eliminar);
			
			$mensaje = "Rechazos Eliminados Correctamente";
		}
		else
			$mensaje = "No Existen Rechazos para Eliminar";		
			
		header("Location:sea_ing_rechazos_anodos_ven.php?mensaje=".$mensaje);	
	}
	
	include("../principal/cerrar_sea_web.php");
?>