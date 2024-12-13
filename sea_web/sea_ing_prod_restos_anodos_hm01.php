<?php
	include("../principal/conectar_sea_web.php");

	if(isset($_REQUEST["proceso"])) {
		$proceso = $_REQUEST["proceso"];
	}else{
		$proceso = "";
	}

	if(isset($_REQUEST["cmbgrupo"])) {
		$cmbgrupo = $_REQUEST["cmbgrupo"];
	}else{
		$cmbgrupo = "";
	}

	if(isset($_REQUEST["pdia"])) {
		$pdia = $_REQUEST["pdia"];
	}else{
		$pdia = date("d");
	}
	if(isset($_REQUEST["pmes"])) {
		$pmes = $_REQUEST["pmes"];
	}else{
		$pmes = date("m");
	}
	if(isset($_REQUEST["pano"])) {
		$pano = $_REQUEST["pano"];
	}else{
		$pano = date("Y");
	}
	if(isset($_REQUEST["dia"])) {
		$dia = $_REQUEST["dia"];
	}else{
		$dia = date("d");
	}
	if(isset($_REQUEST["mes"])) {
		$mes = $_REQUEST["mes"];
	}else{
		$mes =  date("m");
	}
	if(isset($_REQUEST["ano"])) {
		$ano = $_REQUEST["ano"];
	}else{
		$ano =  date("Y");
	}

	if(isset($_REQUEST["txtunid1"])) {
		$txtunid1 = $_REQUEST["txtunid1"];
	}else{
		$txtunid1 = "";
	}
	if(isset($_REQUEST["txtpeso1"])) {
		$txtpeso1 = $_REQUEST["txtpeso1"];
	}else{
		$txtpeso1 = "";
	}
	if(isset($_REQUEST["parametros"])) {
		$parametros = $_REQUEST["parametros"];
	}else{
		$parametros = "";
	}

	if(isset($_REQUEST["Hora"])) {
		$Hora = $_REQUEST["Hora"];
	}else{
		$Hora = date("G");
	}
	if(isset($_REQUEST["Minutos"])) {
		$Minutos = $_REQUEST["Minutos"];
	}else{
		$Minutos = date("i");
	}
	if(isset($_REQUEST["txtpesoproduccion"])) {
		$txtpesoproduccion = $_REQUEST["txtpesoproduccion"];
	}else{
		$txtpesoproduccion = "";
	}

    $fecha   = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:date('Y-m-d');
	$hornada = isset($_REQUEST["hornada"])?$_REQUEST["hornada"]:"";
	$fecha_aux = isset($_REQUEST["fecha_aux"])?$_REQUEST["fecha_aux"]:"";
	if(strlen($pmes)==1)
		$pmes="0".$pmes;
	if (strlen($pdia)==1)
		$pdia="0".$pdia;
	$pfecha=$pano."-".$pmes."-".$pdia;
	function CubasDisponibles($cmbgrupo,$pfecha, $link)
	{
	//Buscar los productos H.M.		
		$consulta = "SELECT valor_subclase2 FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2002"; //Colunma de H.M.	
		$rs = mysqli_query($link, $consulta);
		
		$valoreshm = "";
		while ($row = mysqli_fetch_array($rs))
		{
			$valoreshm = $valoreshm.$row["valor_subclase2"].","; 
		}
		$valoreshm = substr($valoreshm,0,strlen($valoreshm)-1);
				
		
		$consulta = "SELECT campo1, MIN(fecha_movimiento) AS fecha_movimiento, cod_subproducto FROM sea_web.movimientos WHERE tipo_movimiento = 2 AND cod_producto = 17";
		$consulta.=" AND cod_subproducto in (".$valoreshm.") AND numero_recarga = 0 AND campo2 = '".$cmbgrupo."' and fecha_movimiento < '".$pfecha."'";
		$consulta.= "GROUP BY campo1";
		//echo "uno".$consulta."<br>";
		$rs1 = mysqli_query($link, $consulta);
		

		$parametros = "";
		$cant_cubas = 0;
		while ($row1 = mysqli_fetch_array($rs1))
		{		
			$Ano=substr($row1["fecha_movimiento"],0,4);
			$Mes=substr($row1["fecha_movimiento"],5,2);
			$Dia=substr($row1["fecha_movimiento"],8,2);
			$FechaInicioa=date("Y-m-d", mktime(1,0,0,$Mes,($Dia -1),$Ano))." 08:00:00";
			$FechaTerminoa=$row1["fecha_movimiento"]." 07:59:59";
			$FechaInicio  =$row1["fecha_movimiento"]." 08:00:00";			
			$FechaTermino =date("Y-m-d", mktime(1,0,0,$Mes,($Dia +1),$Ano))." 07:59:59";
			$FechaTermino2 =date("Y-m-d", mktime(1,0,0,$Mes,($Dia +1),$Ano));
			
			$consulta = "SELECT SUM(unidades) AS unidadesmov, SUM(peso) AS peso FROM sea_web.movimientos WHERE tipo_movimiento = 2 AND cod_producto = 17";
			$consulta = $consulta." AND cod_subproducto = ".$row1["cod_subproducto"]." AND numero_recarga = 0 AND campo2 = '".$cmbgrupo."'";
			$consulta = $consulta." AND campo1 = '".$row1["campo1"]."' AND fecha_movimiento between '".$row1["fecha_movimiento"]."' and '".$FechaTermino2."'";
			$consulta = $consulta." and ((hora between '".$FechaInicio."' and '".$FechaTermino."') or ";
			$consulta = $consulta." (hora between '".$FechaInicioa."' and '".$FechaTerminoa."'))";
			//echo "dos".$consulta."<br>";
			$rs2 = mysqli_query($link, $consulta);
			$row2 = mysqli_fetch_array($rs2);
			
			$parametros = $parametros.$row1["campo1"].'~'.$row2["unidadesmov"].'~'.$row2["peso"].'~'.$row1["fecha_movimiento"].'/';
			$cant_cubas ++;				
		}
		
		$linea = "parametros=".$parametros."&cant_cubas=".$cant_cubas;
		
		return $linea;
	}
/**********************/	
	
	if ($proceso == "B")
	{
		$linea = CubasDisponibles($cmbgrupo,$pfecha,$link); 
		//echo "VV".$linea;
		$linea = $linea."&dia=".$pdia."&mes=".$pmes."&ano=".$pano."&Hora=".$Hora."&Minutos=".$Minutos."&cmbgrupo=".$cmbgrupo."&txtunid1=".$txtunid1."&txtpeso1=".$txtpeso1."&mostrar=S";
		header("Location:sea_ing_prod_restos_anodos_hm.php?".$linea);
	}
/***********************/	

	if ($proceso == "B2")
	{
		//Obtengo las unidades y pesos cargados, de cada cuba.
		$arreglo = array();
		$total_prod = 0;
		$total_unid_cargadas = 0;
		$total_peso_cargado = 0;
					
		$consulta = "SELECT * FROM sea_web.movimientos";
		$consulta = $consulta." WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$fecha."' AND hornada = '".$hornada."' ";
		$consulta = $consulta." AND campo2 = '".$cmbgrupo."' AND campo1 NOT IN ('T','M')";
		//echo $consulta."<br>";
		$rs = mysqli_query($link, $consulta);
				
		while ($row = mysqli_fetch_array($rs))
		{
			$Ano=substr($row["fecha_benef"],0,4);
			//echo "RRR".$Ano;
			
			$Mes=substr($row["fecha_benef"],5,2);
			$Dia=substr($row["fecha_benef"],8,2);
			$FechaInicio=$row["fecha_benef"]." 08:00:00";
			$FechaInicioa=date("Y-m-d", mktime(1,0,0,$Mes,($Dia - 1),$Ano))." 08:00:00";
			$FechaTerminoa=$row["fecha_benef"]." 07:59:59";
			$FechaTermino =date("Y-m-d", mktime(1,0,0,$Mes,($Dia +1),$Ano))." 07:59:59";
			$FechaTermino2 =date("Y-m-d", mktime(1,0,0,$Mes,($Dia +1),$Ano));			
			$consulta = "SELECT * FROM sea_web.movimientos";
			$consulta = $consulta." WHERE tipo_movimiento = 2 AND fecha_movimiento between '".$row["fecha_benef"]."' and '".$FechaTermino2."'";
			$consulta = $consulta." AND hornada = ".$row["numero_recarga"]." AND cod_subproducto = ".$row["cod_subproducto"];
			$consulta = $consulta." AND campo2 = '".$row["campo2"]."' AND campo1 = '".$row["campo1"]."'";
			$consulta = $consulta." AND unidades = ".$row["unidades"]." AND numero_recarga = 1";
			$consulta = $consulta." and ((hora between '".$FechaInicio."' and '".$FechaTermino."') or ";
			$consulta = $consulta." (hora between '".$FechaInicioa."' and '".$FechaTerminoa."'))";
			//echo $consulta."<br>";
			$rs1 = mysqli_query($link, $consulta);
			$row1 = mysqli_fetch_array($rs1);
						
			$arreglo[$row1["campo1"]][0] = $arreglo[$row1["campo1"]][0] + $row1["unidades"]; 	//unidades cargadas.
			$arreglo[$row1["campo1"]][1] = $arreglo[$row1["campo1"]][1] + $row1["peso"];    	//peso beneficio.
			$arreglo[$row1["campo1"]][2] = $row["fecha_benef"];								//Fecha de carga.								
			
			$total_prod = $total_prod + $row["peso"];
			$total_unid_cargadas = $total_unid_cargadas + $row1["unidades"];
			$total_peso_cargado = $total_peso_cargado + $row1["peso"];			
		}
		
		$parametros = "";
		reset($arreglo);			
		//while (list($c,$v) = each($arreglo))
		foreach ($arreglo as $c => $v)
		{
			$parametros = $parametros.$c.'~'.$v[0].'~'.$v[1].'~'.$v[2].'/';
			//echo $c."/".$v[0]."/".$v[1]."/".$v[2]."<br>";
		}
				
		$fecha_mov = explode("-",$fecha);

		$linea = "parametros=".$parametros."&cant_cubas=".count($arreglo);
		$linea = $linea."&dia=".$fecha_mov[2]."&mes=".$fecha_mov[1]."&ano=".$fecha_mov[0]."&Hora=".$Hora."&Minutos=".$Minutos;
		$linea = $linea."&cmbgrupo=".$cmbgrupo."&txtunid1=".$total_unid_cargadas."&txtpeso1=".$total_peso_cargado."&mostrar=S";
		$linea = $linea."&total_prod=".$total_prod."&bloquear=S&hornada_aux=".$hornada;
		//echo "MMM".$linea;
		header("Location:sea_ing_prod_restos_anodos_hm.php?".$linea);
	}
	
	
	
	
/**********************/	
	if ($proceso == "G")
	{		
	    //*******************************************************************************//
	    //Valida que no se realicen cambios de movimientos, en la fecha ingresada.
	
	       $valida_fecha_movimiento = $ano.'-'.$mes.'-'.$dia;
	       include("sea_valida_mes.php");
        //*******************************************************************************//
	
		//Se le concatena a la hornada para que sea unica en la tabla.
		if (strlen($mes) == 1)
			$mes = "0".$mes;
		$ano_mes = $ano.$mes;
		
		$peso_promedio = ($txtpesoproduccion / $txtunid1); //peso produccion por unidad.
		
		//Busca la Hornada de los diferentes productos H.M.		
		$hornadas = array();
		$consulta = "SELECT valor_subclase2 FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2002"; //Colunma de H.M.
		$rs5 = mysqli_query($link, $consulta);
		while ($row5 = mysqli_fetch_array($rs5))
		{
			$consulta = "SELECT MAX(case when length(substring(hornada_ventana,7,6))=4 then concat('00',substring(hornada_ventana,7,6)) else substring(hornada_ventana,7,6) end) AS hornada_max";
			$consulta = $consulta." FROM sea_web.hornadas";
			$consulta = $consulta." WHERE cod_producto = 19 AND cod_subproducto = '".$row5["valor_subclase2"]."' ";			
			$rs6 = mysqli_query($link, $consulta);
			$row6 = mysqli_fetch_array($rs6);
			if (is_null($row6["hornada_max"]))
			{
				$consulta = "SELECT valor_subclase1 FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2007 AND cod_subclase = '".$row5["valor_subclase2"]."' ";
			
				$rs7 = mysqli_query($link, $consulta);						
				$row7 = mysqli_fetch_array($rs7);
				$hornadas[$row5["valor_subclase2"]] = $ano_mes.$row7["valor_subclase1"];
			}
			else{
				if(isset($row6["hornada_max"])){
					$hornadamax= $row6["hornada_max"];
				}else{
					$hornadamax= 0;
				}
				//$hornadas[$row5["valor_subclase2"]] = $ano_mes.$row6["hornada_max"] + 1;
				$hornadas[$row5["valor_subclase2"]] = (int)($ano_mes.$hornadamax) + 1;
			}
									
		}

/***/			
		//ESTO DESAPARE, Y LA HORNADA ES GENERADA POR EL SISTEMA.		
		//Si la hornada_aux contiene un valor, reemplazar.
//		if ($hornada_aux != "")
//			$hornadas[8] = $ano_mes.$hornada_aux;
/***/			
		
		$fecha = $ano.'-'.$mes.'-'.$dia;
		$fecha_hora = $ano."-".$mes."-".$dia." ".$Hora.":".$Minutos;
		//Leno un arreglo con los parametros.
		$arreglo = array();
		$largo = strlen($parametros);
		for ($i=0; $i < $largo; $i++)
		{
			if (substr($parametros,$i,1) == "/")
			{				
				$valor = substr($parametros,0,$i);
												
				$pos = strpos($valor,"~"); //el N de la cuba
				$cuba = substr($valor,0,$pos);
				$valor = substr($valor,$pos+1,strlen($valor));					
				
				$pos = strpos($valor,"~"); //unidades
				$unidades = substr($valor,0,$pos);
				$valor = substr($valor,$pos+1,strlen($valor));
				
				$pos = strpos($valor,"~"); //peso
				$peso = substr($valor,0,$pos); 
				$valor = substr($valor,$pos+1,strlen($valor));
				
				$fecha_mov = $valor; //fecha de carga.
								
				$parametros = substr($parametros,$i+1);
				$i = 0;			
				$arreglo[$cuba][0] = $unidades;
				$arreglo[$cuba][1] = $peso;
				$arreglo[$cuba][2] = $fecha_mov;				
			}				
		}
		

		//Arreglo de totales por hornada.
		$totales = array();
		reset($hornadas);
		//while(list($c,$v) = each($hornadas))
		foreach ($hornadas as $c => $v)
		{
			$totales[$c][0] = 0; //unidades.
			$totales[$c][1] = 0; //peso.
		}

					
		//Arreglo con las cubas, la fecha_carga, unidades y peso.
		reset($arreglo);
		//while (list($clave,$valor) = each($arreglo))
		foreach ($arreglo as $clave => $valor)
		{
			$Ano=substr($valor[2],0,4);
			$Mes=substr($valor[2],5,2);
			$Dia=substr($valor[2],8,2);
			$FechaInicio=$valor[2]." 08:00:00";
			$FechaInicioa=date("Y-m-d", mktime(1,0,0,$Mes,($Dia - 1),$Ano))." 07:59:59";
			$FechaTerminoa=$FechaInicio;
			$FechaTermino =date("Y-m-d", mktime(1,0,0,$Mes,($Dia +1),$Ano))." 07:59:59";
			$FechaTermino2 =date("Y-m-d", mktime(1,0,0,$Mes,($Dia +1),$Ano));
			
			//Busca los movimientos para la cuba involucrada.
			$consulta = "SELECT * FROM sea_web.movimientos WHERE tipo_movimiento = 2 AND cod_producto = 17";
			$consulta = $consulta." AND numero_recarga = 0 AND campo1 = '".$clave."' AND campo2 = '".$cmbgrupo."'";
			$consulta = $consulta." AND fecha_movimiento between '".$valor[2]."' and '".$FechaTermino2."'";
			$consulta = $consulta." and ((hora between '".$FechaInicio."' and '".$FechaTermino."') or ";
			$consulta = $consulta." (hora between '".$FechaInicioa."' and '".$FechaTerminoa."'))";
			//echo $consulta."<br>";
			$rs = mysqli_query($link, $consulta);
			
			while ($row = mysqli_fetch_array($rs))
			{	
				//Busca el flujo Asociado al producto y proceso.					
				$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 3 AND cod_producto = 19";
				$consulta = $consulta." AND cod_subproducto = ".$row["cod_subproducto"];
				$rs1 = mysqli_query($link, $consulta);
				if ($row1 = mysqli_fetch_array($rs1))
					$flujo = $row1["flujo"];
				else 
					$flujo = 0;			
			
			
				$insertar = "INSERT INTO sea_web.movimientos (tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,fecha_movimiento,campo1,campo2,unidades,flujo,fecha_benef,peso,hora)";
				$insertar = $insertar." VALUES (3,19,".$row["cod_subproducto"].",".$hornadas[$row["cod_subproducto"]].",".$row["hornada"].",'".$fecha."'";
				$insertar = $insertar.",'".$row["campo1"]."','".$row["campo2"]."',".$row["unidades"].",".$flujo.",'".$row["fecha_movimiento"]."',".($row["unidades"] * $peso_promedio).",'$fecha_hora')";
				//echo $insertar."<br>";
				mysqli_query($link, $insertar);
				
				//Actualiza Movimiento.
				$actualizar = "UPDATE sea_web.movimientos SET numero_recarga = 1";
				$actualizar = $actualizar." WHERE tipo_movimiento = 2 AND cod_producto = 17 AND cod_subproducto = ".$row["cod_subproducto"];
				$actualizar = $actualizar." AND hornada = ".$row["hornada"]." AND numero_recarga = 0 AND fecha_movimiento = '".$row["fecha_movimiento"]."'";
				$actualizar = $actualizar." AND campo1 = '".$row["campo1"]."' AND campo2 = '".$row["campo2"]."' AND unidades = ".$row["unidades"];
				$actualizar = $actualizar." AND peso = ".$row["peso"]." AND flujo = ".$row["flujo"];
				mysqli_query($link, $actualizar); 
				//echo $actualizar."<br>";
												
				$totales[$row["cod_subproducto"]][0] = $totales[$row["cod_subproducto"]][0] + $row["unidades"]; //unidades cargadas.
				$totales[$row["cod_subproducto"]][1] = $totales[$row["cod_subproducto"]][1] + $row["peso"];    //peso carga.
			}														
		}

		//Graba las hornadas en la tabla Hornadas.
		reset($hornadas);
		$valores = "";
		//while(list($c,$v) = each($hornadas))
		foreach ($hornadas as $c => $v)
		{	
			if ($totales[$c][0] != 0)
			{
				$insertar = "INSERT INTO sea_web.hornadas (cod_producto,cod_subproducto,hornada_ventana,unidades,peso_unidades,estado)";
				$insertar = $insertar." VALUES (19,".$c.",".$v.",".$totales[$c][0].",".$txtpesoproduccion.",0)";
				mysqli_query($link, $insertar);
				$valores = $valores.$v.'-'.$totales[$c][0].'-'.$txtpesoproduccion.'/';
				//echo $insertar."<br>";
				
				//Agrega la diferencia a un registo, con mas unidades en la produccion.
				
				$consulta = "SELECT SUM(peso) AS peso_mov FROM sea_web.movimientos";
				$consulta = $consulta." WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$fecha."' AND hornada = ".$v;
				$consulta = $consulta." AND campo2 = '".$cmbgrupo."' AND campo1 NOT IN ('T','M')";		 
				$rs2 = mysqli_query($link, $consulta);
				$row2 = mysqli_fetch_array($rs2);
				$diferencia = $txtpesoproduccion - $row2["peso_mov"];
				
				$consulta = "SELECT * FROM sea_web.movimientos";
				$consulta = $consulta." WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$fecha."' AND hornada = ".$v;
				$consulta = $consulta." AND campo2 = '".$cmbgrupo."' AND campo1 NOT IN ('T','M')";		 
				$consulta = $consulta." ORDER BY unidades DESC";
				$consulta = $consulta." LIMIT 0,1";
				//echo $consulta."<br>";
				$rs3 = mysqli_query($link, $consulta);
				if ($row3 = mysqli_fetch_array($rs3))
				{
					$actualizar = "UPDATE sea_web.movimientos SET peso = (peso + ".$diferencia.")";
					$actualizar = $actualizar." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$row3["cod_subproducto"];
					$actualizar = $actualizar." AND hornada = ".$row3["hornada"]." AND numero_recarga = ".$row3["numero_recarga"];
					$actualizar = $actualizar." AND fecha_movimiento = '".$row3["fecha_movimiento"]."'";
					$actualizar = $actualizar." AND campo1 = '".$row3["campo1"]."' AND campo2 = '".$row3["campo2"]."' AND unidades = ".$row3["unidades"];
					$actualizar = $actualizar." AND fecha_benef = '".$row3["fecha_benef"]."' AND peso = '".$row3["peso"]."'";
					//echo $actualizar."<br>";
					mysqli_query($link, $actualizar);						
				}
			}
		}

		//Busca las Cubas Disponibles.
		$linea = CubasDisponibles($cmbgrupo,$pfecha,$link); 
		
		$linea = $linea."&ano=".$ano."&mes=".$mes."&dia=".$dia."&cmbgrupo=".$cmbgrupo."&txtunid1=0&txtpeso1=0";
		$linea = $linea."&mostrar=S&activar=S&valores=".$valores;

		header("Location:sea_ing_prod_restos_anodos_hm.php?".$linea);
		
	}
/******************/

	if ($proceso == "M")
	{
        //*******************************************************************************//
	         //Valida que no se realicen cambios de movimientos, en la fecha ingresada.
	
	         $valida_fecha_movimiento = $fecha_aux;
	         include("sea_valida_mes.php");
        //*******************************************************************************//		
		
		$fecha_mov = $ano."-".$mes."-".$dia;
		$fecha_hora = $ano."-".$mes."-".$dia." ".$Hora.":".$Minutos;
		if($txtunid1==0)
		{
				echo '<script language="JavaScript">';
				echo 'alert("Unidades para calculo peso promedio no debe ser 0 ");';
				echo 'window.history.back()';
				echo '</script>';		
				echo 'header("Location:sea_ing_prod_restos_anodos_hm.php");';

		}

		$peso_promedio = round(($txtpesoproduccion / $txtunid1),2);
		
		//Actualiza los pesos de la produccion.		
		$consulta = "SELECT * FROM sea_web.movimientos";
		$consulta = $consulta." WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$fecha_aux."' AND hornada = '".$hornada."' ";
		$consulta = $consulta." AND campo2 = '".$cmbgrupo."' AND campo1 NOT IN ('T','M')";
		//echo $consulta."<br>";
		$rs = mysqli_query($link, $consulta);
		
		while ($row = mysqli_fetch_array($rs))
		{	
			$actualizar = "UPDATE sea_web.movimientos SET peso = ROUND(unidades * ".$peso_promedio."), fecha_movimiento = '".$fecha_mov."',hora='".$fecha_hora."' ";
			$actualizar = $actualizar." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$row["cod_subproducto"];
			$actualizar = $actualizar." AND hornada = '".$row["hornada"]."' AND numero_recarga = '".$row["numero_recarga"]."' ";
			$actualizar = $actualizar." AND campo1 ='".$row["campo1"]."' AND campo2 = '".$row["campo2"]."' AND unidades = '".$row["unidades"]."' ";
			mysqli_query($link, $actualizar);			
		}
		
		//Agrega la diferencia a un registo, con mas unidades en la produccion.
		$consulta = "SELECT SUM(peso) AS peso_mov FROM sea_web.movimientos";
		$consulta = $consulta." WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$fecha_mov."' AND hornada = '".$hornada."' ";
		$consulta = $consulta." AND campo2 = '".$cmbgrupo."' AND campo1 NOT IN ('T','M')";		 
		$rs2 = mysqli_query($link, $consulta);
		$row2 = mysqli_fetch_array($rs2);
		$diferencia = $txtpesoproduccion - $row2["peso_mov"];
		
		$consulta = "SELECT * FROM sea_web.movimientos";
		$consulta = $consulta." WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$fecha_mov."' AND hornada = '".$hornada."' ";
		$consulta = $consulta." AND campo2 = '".$cmbgrupo."' AND campo1 NOT IN ('T','M')";		 
		$consulta = $consulta." ORDER BY unidades DESC";
		$consulta = $consulta." LIMIT 0,1";
		//echo $consulta."<br>";
		$rs3 = mysqli_query($link, $consulta);
		if ($row3 = mysqli_fetch_array($rs3))
		{
			$actualizar = "UPDATE sea_web.movimientos SET peso = (peso + ".$diferencia.")";
			$actualizar = $actualizar." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = '".$row3["cod_subproducto"]."' ";
			$actualizar = $actualizar." AND hornada = '".$row3["hornada"]."' AND numero_recarga = '".$row3["numero_recarga"]."' ";
			$actualizar = $actualizar." AND fecha_movimiento = '".$row3["fecha_movimiento"]."'";
			$actualizar = $actualizar." AND campo1 = '".$row3["campo1"]."' AND campo2 = '".$row3["campo2"]."' AND unidades = '".$row3["unidades"]."' ";
			$actualizar = $actualizar." AND fecha_benef = '".$row3["fecha_benef"]."' AND peso = '".$row3["peso"]."'";
			//echo $actualizar."<br>";
			mysqli_query($link, $actualizar);						
		}
							
		//Actualiza la hornada.
		$actualizar = "UPDATE sea_web.hornadas SET unidades = '".$txtunid1."', peso_unidades = '".$txtpesoproduccion."' ";
		$actualizar = $actualizar." WHERE hornada_ventana = '".$hornada."' ";
		mysqli_query($link, $actualizar);
		
		//Actualiza los pesos de los beneficios ya realizados y traspaso.
		$actualizar = "UPDATE sea_web.movimientos SET peso = (unidades * ".$peso_promedio.")";
		$actualizar = $actualizar." WHERE tipo_movimiento IN (2,4) AND cod_producto = 19 AND hornada = '".$hornada."' ";
		mysqli_query($link, $actualizar);
				
		//Cambia la fecha_benef de los traspasos.
		$consulta = "SELECT * FROM sea_web.movimientos";
		$consulta = $consulta." WHERE tipo_movimiento = 4 AND fecha_benef= '".$fecha_aux."' AND hornada = '".$hornada."' ";
		$consulta = $consulta." AND campo2 = '".$cmbgrupo."' AND campo1 NOT IN ('T','M')";
		$rs1 = mysqli_query($link, $consulta);
		while ($row1 = mysqli_fetch_array($rs1))
		{
			$actualizar = "UPDATE sea_web.movimientos SET fecha_benef = '".$fecha_mov."'";
			$actualizar = $actualizar." WHERE tipo_movimiento = 4 AND cod_producto = 19 AND cod_subproducto = '".$row1["cod_subproducto"]."' ";
			$actualizar = $actualizar." AND hornada = '".$row1["hornada"]."' AND campo1 = '".$row1["campo1"]."' AND campo2 = '".$row1["campo2"]."' AND unidades = '".$row1["unidades"]."' ";
			mysqli_query($link, $actualizar);
		}
		
		 header("Location:sea_ing_prod_restos_anodos_hm.php");
	}
	
	
	
	if ($proceso == "E")
	{
        //*******************************************************************************//
	         //Valida que no se realicen cambios de movimientos, en la fecha ingresada.
	
	         $valida_fecha_movimiento = $fecha_aux;
	         include("sea_valida_mes.php");
        //*******************************************************************************//		
		
		//Consulta las cubas que pertenece a esta produccion.
		$consulta = "SELECT DISTINCT cod_subproducto, campo1, campo2, fecha_benef";
		$consulta = $consulta." FROM sea_web.movimientos";
		$consulta = $consulta." WHERE tipo_movimiento = 3 AND hornada = '".$hornada."' ";
		$consulta = $consulta." AND fecha_movimiento = '".$fecha_aux."' AND campo2 = '".$cmbgrupo."'";
		//echo $consulta."<br>";
		
		$rs = mysqli_query($link, $consulta);
		while ($row = mysqli_fetch_array($rs))
		{
			//Actualiza Movimientos de Benefio.
			$actualizar = "UPDATE sea_web.movimientos SET numero_recarga = 0";
			$actualizar = $actualizar." WHERE tipo_movimiento = 2 AND campo2='".$row["campo2"]."' and campo1='".$row["campo1"]."'";
			$actualizar = $actualizar." AND cod_subproducto = '".$row["cod_subproducto"]."' and fecha_movimiento = '".$row["fecha_benef"]."'";
			$actualizar = $actualizar." AND cod_producto = 17 AND numero_recarga = 1";
			mysqli_query($link, $actualizar);
			//echo $actualizar."<br>";			
		}
		
		//Elimina Movimientos de Produccion.
		$eliminar = "DELETE FROM sea_web.movimientos ";
		$eliminar = $eliminar." WHERE tipo_movimiento = 3 AND hornada = ".$hornada;
		$eliminar = $eliminar." AND fecha_movimiento = '".$fecha_aux."' AND campo2 = '".$cmbgrupo."'";
		mysqli_query($link, $eliminar);
		//echo $eliminar."<br>";
		
		
		//Elimina Movimientos de Traspaso.
		$eliminar = "DELETE FROM sea_web.movimientos";
		$eliminar = $eliminar." WHERE tipo_movimiento = 4 AND fecha_benef = '".$fecha_aux."'";
		$eliminar = $eliminar." AND hornada = ".$hornada." AND campo2 = '".$cmbgrupo."'"; 
		mysqli_query($link, $eliminar);
		//echo $eliminar."<br>";		
		
		//Elimina los Beneficios Realizados.
		$eliminar = "DELETE FROM sea_web.movimientos";
		$eliminar = $eliminar." WHERE tipo_movimiento = 2 AND cod_producto = 19 AND hornada = ".$hornada;
		mysqli_query($link, $eliminar);
		//echo $eliminar."<br>";		
				
		
		//Elimina ne la tabla Hornadas.
		$eliminar = "DELETE FROM sea_web.hornadas";
		$eliminar = $eliminar." WHERE cod_producto = 19 AND hornada_ventana = ".$hornada;
		mysqli_query($link, $eliminar);
		//echo $eliminar."<br>";		
		
		header("Location:sea_ing_prod_restos_anodos_hm.php");
	}	

	include("../principal/cerrar_sea_web.php");	
?>